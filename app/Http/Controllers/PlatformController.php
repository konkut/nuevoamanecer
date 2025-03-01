<?php

namespace App\Http\Controllers;

use App\Models\Bankregister;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Method;
use App\Models\Platform;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PlatformController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $platforms = Platform::with('user')->orderBy('created_at', 'desc')->paginate($perPage);
        return view("platform.index", compact('platforms', 'perPage'));
    }

    public function create()
    {
        $platform = new Platform();
        return view("platform.create", compact('platform'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:platforms,name|string|max:30',
            'total' => 'required|numeric',
            'description' => 'nullable|string|max:100',
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
        Platform::create([
            'name' => $request->name,
            'description' => $request->description,
            'total' => $request->total,
            'user_id' => Auth::id(),
        ]);
        return redirect("/platforms")->with('success', __('word.platform.alert.store'));
    }

    public function edit(string $platform_uuid)
    {
        $platform = Platform::where('platform_uuid', $platform_uuid)->firstOrFail();
        return view("platform.edit", compact('platform'));
    }

    public function update(Request $request, string $platform_uuid)
    {
        $platform = Platform::where('platform_uuid', $platform_uuid)->firstOrFail();
        $rules = [
            'name' => 'required|string|max:30|unique:platforms,name,' . $platform->platform_uuid . ',platform_uuid',
            'description' => 'nullable|string|max:100',
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
        $platform->update([
            'name' => $request->name,
            'description' => $request->description,
            'total' => $request->total,
        ]);
        return redirect("/platforms")->with('success', __('word.platform.alert.update'));
    }

    public function destroy(string $platform_uuid)
    {
        try {
            $platform = Platform::where('platform_uuid', $platform_uuid)->first();
            $verified_session = DB::table('cashshift_platforms')
                ->where('platform_uuid', $platform_uuid)
                ->exists();
            if (!$verified_session) {
                $platform->delete();
                return response()->json([
                    'type' => 'success',
                    'title' => __('word.general.success'),
                    'msg' => __('word.platform.delete_success'),
                    'redirect' => route('platforms.index')
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
            ], 500);
        }
    }

    public function disable(string $platform_uuid)
    {
        $platform = Platform::where('platform_uuid', $platform_uuid)->first();
        $platform->update([
            'status' => false,
        ]);
        return redirect("/platforms")->with('success', __('word.platform.alert.disable'));
    }

    public function enable(string $platform_uuid)
    {
        $platform = Platform::where('platform_uuid', $platform_uuid)->first();
        $platform->update([
            'status' => "1",
        ]);
        return redirect("/platforms")->with('success', __('word.platform.alert.enable'));
    }
}
