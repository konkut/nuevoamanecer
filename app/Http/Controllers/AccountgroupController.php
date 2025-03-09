<?php

namespace App\Http\Controllers;

use App\Models\Accountclass;
use Illuminate\Http\Request;
use App\Models\Accountgroup;
use App\Models\Accountsubgroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AccountgroupController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:70',
            'description' => 'nullable|string|max:100',
            'accountclass_uuid' => 'required|exists:accountclasses,accountclass_uuid',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $next = Accountgroup::max('code') + 1;
        Accountgroup::create([
            'code' => $next,
            'name' => $request->name,
            'description' => $request->description,
            'accountclass_uuid' => $request->accountclass_uuid,
            'user_id' => Auth::id(),
        ]);
        return redirect('/accounts')->with('success', __('word.accountgroup.alert.store'));
    }
    public function edit(string $accountgroup_uuid)
    {
        try {
            $accountgroup = Accountgroup::where('accountgroup_uuid', $accountgroup_uuid)->first();
            if ($accountgroup) {
                return response()->json([
                    'type' => 'success',
                    'title' => __('word.general.success'),
                    'accountgroup' => $accountgroup,
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
    public function update(Request $request, string $accountgroup_uuid)
    {
        $accountgroup = Accountgroup::where('accountgroup_uuid', $accountgroup_uuid)->firstOrFail();
        $rules = [
            'name' => 'required|string|max:70',
            'description' => 'nullable|string|max:100',
            'accountclass_uuid' => 'required|exists:accountclasses,accountclass_uuid',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::transaction(function () use ($request, $accountgroup) {
            $new_accountclass_uuid = $request->accountclass_uuid;
            if ($accountgroup->accountclass_uuid !== $new_accountclass_uuid) {
                $new_accountclass = Accountclass::where('accountclass_uuid', $new_accountclass_uuid)->firstOrFail();
                $max_code = Accountgroup::where('accountclass_uuid', $new_accountclass_uuid)->max('code');
                $next = $max_code ? $max_code + 1 : $new_accountclass->code + 1;
                $accountgroup->update([
                    'code' => $next,
                    'name' => $request->name,
                    'description' => $request->description,
                    'accountclass_uuid' => $new_accountclass_uuid,
                ]);
            } else {
                $accountgroup->update([
                    'name' => $request->name,
                    'description' => $request->description,
                ]);
            }
        });
        return redirect('/accounts')->with('success', __('word.accountgroup.alert.update'));
    }

    public function destroy(string $accountgroup_uuid)
    {
        try {
            $accountgroup = Accountgroup::where('accountgroup_uuid', $accountgroup_uuid)->first();
            $verified_subgroup = Accountsubgroup::where('accountgroup_uuid', $accountgroup_uuid)->exists();
            if (!$verified_subgroup) {
                if ($accountgroup) {
                    $accountgroup->delete();
                    return response()->json([
                        'type' => 'success',
                        'title' => __('word.general.success'),
                        'msg' => __('word.accountgroup.delete_success'),
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
                    'msg' => __('word.accountgroup.not_allow'),
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

    public function disable(string $accountgroup_uuid)
    {
        $accountgroup = Accountgroup::where('accountgroup_uuid', $accountgroup_uuid)->first();
        if ($accountgroup) {
            $accountgroup->update(['status' => false]);
        }
        return redirect('/accounts')->with('success', __('word.accountgroup.alert.disable'));
    }

    public function enable(string $accountgroup_uuid)
    {
        $accountgroup = Accountgroup::where('accountgroup_uuid', $accountgroup_uuid)->first();
        if ($accountgroup) {
            $accountgroup->update(['status' => true]);
        }
        return redirect('/accounts')->with('success', __('word.accountgroup.alert.enable'));
    }
}
