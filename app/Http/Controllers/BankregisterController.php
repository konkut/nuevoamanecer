<?php

namespace App\Http\Controllers;

use App\Models\Bankregister;
use App\Models\Cashregister;
use App\Models\Denomination;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BankregisterController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $bankregisters = Bankregister::orderBy('created_at', 'desc')->paginate($perPage);
        return view("bankregister.index", compact('bankregisters', 'perPage'));
    }

    public function create()
    {
        $bankregister = new Bankregister();
        return view("bankregister.create", compact('bankregister'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:bankregisters,name|string|max:30',
            'total' => 'required|numeric',
            'account_number' => 'required|digits_between:10,16',
            'owner_name' => 'required|string|max:30',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $validator->after(function ($validator) use ($request) {
            if ($request->input('total') == 0) {
                $validator->errors()->add('total', __('word.rules.rule_one'));
                return;
            }
            if ($request->input('total') > 10000) {
                $validator->errors()->add('total', __('word.rules.rule_two'));
                return;
            }
            if ($request->input('total') < 0) {
                $validator->errors()->add('total', __('word.rules.rule_three'));
                return;
            }
            if (!is_numeric($request->input('total'))) {
                $validator->errors()->add('total', __('word.rules.rule_four'));
                return;
            }
            if (!preg_match('/^\d+(\.\d{1,2})?$/', $request->input('total'))) {
                $validator->errors()->add('total', __('word.rules.rule_five'));
                return;
            }
        });
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        DB::transaction(function () use ($request) {
            Bankregister::create([
                'name' => $request->name,
                'account_number' => $request->account_number,
                'owner_name' => $request->owner_name,
                'total' => $request->total,
                'user_id' => Auth::id(),
            ]);
        });
        return redirect("/bankregisters")->with('success', __('word.bankregister.alert.store'));
    }

    public function edit(string $bankregister_uuid)
    {
        $bankregister = Bankregister::where('bankregister_uuid', $bankregister_uuid)->with('user')->firstOrFail();
        return view("bankregister.edit", compact('bankregister'));
    }

    public function update(Request $request, string $bankregister_uuid)
    {
        $bankregister = Bankregister::where('bankregister_uuid', $bankregister_uuid)->with('user')->firstOrFail();
        $rules = [
            'name' => 'required|unique:bankregisters,name,' . $bankregister->bankregister_uuid . ',bankregister_uuid|string|max:30',
            'total' => 'required|numeric',
            'account_number' => 'required|digits_between:10,16',
            'owner_name' => 'required|string|max:30',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $validator->after(function ($validator) use ($request) {
            if ($request->input('total') == 0) {
                $validator->errors()->add('total', __('word.rules.rule_one'));
                return;
            }
            if ($request->input('total') > 10000) {
                $validator->errors()->add('total', __('word.rules.rule_two'));
                return;
            }
            if ($request->input('total') < 0) {
                $validator->errors()->add('total', __('word.rules.rule_three'));
                return;
            }
            if (!is_numeric($request->input('total'))) {
                $validator->errors()->add('total', __('word.rules.rule_four'));
                return;
            }
            if (!preg_match('/^\d+(\.\d{1,2})?$/', $request->input('total'))) {
                $validator->errors()->add('total', __('word.rules.rule_five'));
                return;
            }
        });
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        DB::transaction(function () use ($bankregister, $request) {
            $bankregister->update([
                'name' => $request->name,
                'account_number' => $request->account_number,
                'owner_name' => $request->owner_name,
                'total' => $request->total,
            ]);
        });
        return redirect("/bankregisters")->with('success', __('word.bankregister.alert.update'));
    }

    public function destroy(string $bankregister_uuid)
    {
        try {
            $bankregister = Bankregister::where('bankregister_uuid', $bankregister_uuid)->first();
            $verified_session = DB::table('cashshift_bankregisters')
                ->where('bankregister_uuid', $bankregister_uuid)
                ->exists();
            if (!$verified_session) {
                if ($bankregister) {
                    $bankregister->delete();
                    return response()->json([
                        'type' => 'success',
                        'title' => __('word.general.success'),
                        'msg' => __('word.bankregister.delete_success'),
                        'redirect' => route('bankregisters.index'),
                    ], 200);
                } else {
                    return response()->json([
                        'type' => 'error',
                        'title' => __('word.general.error'),
                        'msg' => __('word.general.not_found'),
                    ], 404);
                }
            } else {
                return response()->json([
                    'type' => 'error',
                    'title' => __('word.general.error'),
                    'msg' => __('word.bankregister.not_allow'),
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.general.bad_request'),
            ], 500);
        }
    }

    public function disable(string $bankregister_uuid)
    {
        $bankregister = Bankregister::where('bankregister_uuid', $bankregister_uuid)->first();
        $bankregister->update([
            'status' => false,
        ]);
        return redirect("/bankregisters")->with('success', __('word.bankregister.alert.disable'));
    }

    public function enable(string $bankregister_uuid)
    {
        $bankregister = Bankregister::where('bankregister_uuid', $bankregister_uuid)->first();
        $bankregister->update([
            'status' => true,
        ]);
        return redirect("/bankregisters")->with('success', __('word.bankregister.alert.enable'));
    }
}
