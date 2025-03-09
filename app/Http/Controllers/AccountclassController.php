<?php

namespace App\Http\Controllers;
use App\Models\Accountclass;
use App\Models\Accountgroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class AccountclassController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:70',
            'description' => 'nullable|string|max:100',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $next = Accountclass::max('code') + 1;
        Accountclass::create([
            'code' => $next,
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);
        return redirect("/accounts")->with('success', __('word.accountclass.alert.store'));
    }

    public function edit(string $accountclass_uuid)
    {
        try {
            $accountclass = Accountclass::where('accountclass_uuid', $accountclass_uuid)->first();
            if ($accountclass) {
                return response()->json([
                    'type' => 'success',
                    'title' => __('word.general.success'),
                    'accountclass' => $accountclass,
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

    public function update(Request $request, string $accountclass_uuid)
    {
        $accountclass = Accountclass::where('accountclass_uuid', $accountclass_uuid)->firstOrFail();
        $rules = [
            'name' => 'required|string|max:70',
            'description' => 'nullable|string|max:100',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $accountclass->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return redirect("/accounts")->with('success', __('word.accountclass.alert.update'));
    }

    public function destroy(string $accountclass_uuid)
    {
        try {
            $accountclass = Accountclass::where('accountclass_uuid', $accountclass_uuid)->first();
            $verified_group = Accountgroup::where('accountclass_uuid', $accountclass_uuid)->exists();
            if (!$verified_group) {
                if ($accountclass) {
                    $accountclass->delete();
                    return response()->json([
                        'type' => 'success',
                        'title' => __('word.general.success'),
                        'msg' => __('word.accountclass.delete_success'),
                        'redirect' => route('accounts.index')
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
                    'msg' => __('word.accountclass.not_allow'),
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

    public function disable(string $accountclass_uuid)
    {
        $accountclass = Accountclass::where('accountclass_uuid', $accountclass_uuid)->first();
        if ($accountclass) {
            $accountclass->update([
                'status' => false,
            ]);
        }
        return redirect("/accounts")->with('success', __('word.accountclass.alert.disable'));
    }

    public function enable(string $accountclass_uuid)
    {
        $accountclass = Accountclass::where('accountclass_uuid', $accountclass_uuid)->first();
        if ($accountclass) {
            $accountclass->update([
                'status' => true,
            ]);
        }
        return redirect("/accounts")->with('success', __('word.accountclass.alert.enable'));
    }
}
