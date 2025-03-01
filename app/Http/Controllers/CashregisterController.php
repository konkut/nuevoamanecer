<?php

namespace App\Http\Controllers;

use App\Models\Cashregister;
use App\Models\Cashshift;
use App\Models\Denomination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CashregisterController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $cashregisters = Cashregister::orderBy('created_at', 'desc')->paginate($perPage);
        return view("cashregister.index", compact('cashregisters', 'perPage'));
    }

    public function create()
    {
        $cashregister = new Cashregister();
        $denomination = new Denomination();
        return view("cashregister.create", compact('cashregister', 'denomination'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:cashregisters,name|string|max:30',
            'bill_200' => 'nullable|integer',
            'bill_100' => 'nullable|integer',
            'bill_50' => 'nullable|integer',
            'bill_20' => 'nullable|integer',
            'bill_10' => 'nullable|integer',
            'coin_5' => 'nullable|integer',
            'coin_2' => 'nullable|integer',
            'coin_1' => 'nullable|integer',
            'coin_0_5' => 'nullable|integer',
            'coin_0_2' => 'nullable|integer',
            'coin_0_1' => 'nullable|integer',
            'total' => 'required|numeric',
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
            $denomination = Denomination::create([
                'bill_200' => $request->bill_200 ?? 0,
                'bill_100' => $request->bill_100 ?? 0,
                'bill_50' => $request->bill_50 ?? 0,
                'bill_20' => $request->bill_20 ?? 0,
                'bill_10' => $request->bill_10 ?? 0,
                'coin_5' => $request->coin_5 ?? 0,
                'coin_2' => $request->coin_2 ?? 0,
                'coin_1' => $request->coin_1 ?? 0,
                'coin_0_5' => $request->coin_0_5 ?? 0,
                'coin_0_2' => $request->coin_0_2 ?? 0,
                'coin_0_1' => $request->coin_0_1 ?? 0,
            ]);
            Cashregister::create([
                'name' => $request->name,
                'total' => $request->total,
                'user_id' => Auth::id(),
                'denomination_uuid' => $denomination->denomination_uuid,
            ]);

        });
        return redirect("/cashregisters")->with('success', __('word.cashregister.alert.store'));
    }

    public function edit(string $cashregister_uuid)
    {
        $cashregister = Cashregister::where('cashregister_uuid', $cashregister_uuid)->first();
        $denomination = Denomination::where('denomination_uuid', $cashregister->denomination_uuid)->first();
        $denomination->total = $cashregister->total;
        return view("cashregister.edit", compact('cashregister', 'denomination'));
    }

    public function update(Request $request, string $cashregister_uuid)
    {
        $cashregister = Cashregister::where('cashregister_uuid', $cashregister_uuid)->first();
        $denomination = Denomination::where('denomination_uuid', $cashregister->denomination_uuid)->first();
        $rules = [
            'name' => 'required|unique:cashregisters,name,' . $cashregister->cashregister_uuid . ',cashregister_uuid|string|max:30',
            'bill_200' => 'nullable|integer',
            'bill_100' => 'nullable|integer',
            'bill_50' => 'nullable|integer',
            'bill_20' => 'nullable|integer',
            'bill_10' => 'nullable|integer',
            'coin_5' => 'nullable|integer',
            'coin_2' => 'nullable|integer',
            'coin_1' => 'nullable|integer',
            'coin_0_5' => 'nullable|integer',
            'coin_0_2' => 'nullable|integer',
            'coin_0_1' => 'nullable|integer',
            'total' => 'required|numeric',
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
        DB::transaction(function () use ($cashregister, $denomination, $request) {
            $cashregister->update([
                'name' => $request->name,
                'total' => $request->total ?? 0,
            ]);
            $denomination->update([
                'bill_200' => $request->bill_200 ?? 0,
                'bill_100' => $request->bill_100 ?? 0,
                'bill_50' => $request->bill_50 ?? 0,
                'bill_20' => $request->bill_20 ?? 0,
                'bill_10' => $request->bill_10 ?? 0,
                'coin_5' => $request->coin_5 ?? 0,
                'coin_2' => $request->coin_2 ?? 0,
                'coin_1' => $request->coin_1 ?? 0,
                'coin_0_5' => $request->coin_0_5 ?? 0,
                'coin_0_2' => $request->coin_0_2 ?? 0,
                'coin_0_1' => $request->coin_0_1 ?? 0,
            ]);
        });
        return redirect("/cashregisters")->with('success', __('word.cashregister.alert.update'));
    }

    public function destroy(string $cashregister_uuid)
    {
        try {
            $cashregister = Cashregister::where('cashregister_uuid', $cashregister_uuid)->first();
            $verified_session = Cashshift::where('cashregister_uuid',$cashregister_uuid)->exists();
            if (!$verified_session){
                if ($cashregister) {
                    DB::transaction(function () use ($cashregister) {
                        $cashregister->delete();
                    });
                    return response()->json([
                        'type' => 'success',
                        'title' => __('word.general.success'),
                        'msg' => __('word.cashregister.delete_success'),
                        'redirect' => route('cashregisters.index')
                    ], 200);
                } else {
                    return response()->json([
                        'type' => 'error',
                        'title' => __('word.general.error'),
                        'msg' => __('word.general.not_found'),
                    ], 404);
                }
            }else{
                return response()->json([
                    'type' => 'error',
                    'title' => __('word.general.error'),
                    'msg' => __('word.cashregister.not_allow'),
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.general.bad_request'),
                'error' => $e->getMessage(),
            ], 500);
        }

    }

    public function disable(string $cashregister_uuid)
    {
        $cashregister = Cashregister::where('cashregister_uuid', $cashregister_uuid)->first();
        $cashregister->update([
            'status' => false,
        ]);
        return redirect("/cashregisters")->with('success', __('word.cashregister.alert.disable'));
    }
    public function enable(string $cashregister_uuid)
    {
        $cashregister = Cashregister::where('cashregister_uuid', $cashregister_uuid)->first();
        $cashregister->update([
            'status' => true,
        ]);
        return redirect("/cashregisters")->with('success', __('word.cashregister.alert.enable'));
    }

    public function detail(string $cashregister_uuid)
    {
        try {
            $cashregister = Cashregister::where('cashregister_uuid',$cashregister_uuid)->first();
            $denomination = Denomination::where('denomination_uuid', $cashregister->denomination_uuid)->first();
            $denomination->total = $cashregister->total;
            if ($denomination) {
                $operation = (object)[
                    'bill_200' => number_format($denomination->bill_200 * 200, 2,'.',''),
                    'bill_100' => number_format($denomination->bill_100 * 100, 2,'.',''),
                    'bill_50' => number_format($denomination->bill_50 * 50, 2,'.',''),
                    'bill_20' => number_format($denomination->bill_20 * 20, 2,'.',''),
                    'bill_10' => number_format($denomination->bill_10 * 10, 2,'.',''),
                    'coin_5' => number_format($denomination->coin_5 * 5, 2,'.',''),
                    'coin_2' => number_format($denomination->coin_2 * 2, 2,'.',''),
                    'coin_1' => number_format($denomination->coin_1 * 1, 2,'.',''),
                    'coin_0_5' => number_format($denomination->coin_0_5 * 0.5, 2,'.',''),
                    'coin_0_2' => number_format($denomination->coin_0_2 * 0.2, 2,'.',''),
                    'coin_0_1' => number_format($denomination->coin_0_1 * 0.1, 2,'.',''),
                ];
                return response()->json([
                    'type' => 'success',
                    'title' => __('word.general.success'),
                    'denomination' => $denomination,
                    'operation' => $operation,
                ], 200);
            } else {
                return response()->json([
                    'type' => 'error',
                    'title' => __('word.general.error'),
                    'msg' => __('word.general.not_found'),
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.general.bad_request'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
