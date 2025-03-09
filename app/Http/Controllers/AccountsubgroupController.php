<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Accountclass;
use App\Models\Accountgroup;
use App\Models\Accountsubgroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AccountsubgroupController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:70',
            'description' => 'nullable|string|max:100',
            'accountgroup_uuid' => 'required|exists:accountgroups,accountgroup_uuid',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $next = Accountsubgroup::max('code') + 1;
        Accountsubgroup::create([
            'code' => $next,
            'name' => $request->name,
            'description' => $request->description,
            'accountgroup_uuid' => $request->accountgroup_uuid,
            'user_id' => Auth::id(),
        ]);
        return redirect('/accounts')->with('success', __('word.accountsubgroup.alert.store'));
    }

    public function edit(string $accountsubgroup_uuid)
    {
        try {
            $accountsubgroup = Accountsubgroup::where('accountsubgroup_uuid', $accountsubgroup_uuid)->first();
            if ($accountsubgroup) {
                return response()->json([
                    'type' => 'success',
                    'title' => __('word.general.success'),
                    'accountsubgroup' => $accountsubgroup,
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

    public function update(Request $request, string $accountsubgroup_uuid)
    {
        $accountsubgroup = Accountsubgroup::where('accountsubgroup_uuid', $accountsubgroup_uuid)->firstOrFail();
        $rules = [
            'name' => 'required|string|max:70',
            'description' => 'nullable|string|max:100',
            'accountgroup_uuid' => 'required|exists:accountgroups,accountgroup_uuid',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        DB::transaction(function () use ($request, $accountsubgroup) {
            $new_accountgroup_uuid = $request->accountgroup_uuid;
            if ($accountsubgroup->accountgroup_uuid !== $new_accountgroup_uuid) {
                $new_accountgroup = Accountgroup::where('accountgroup_uuid', $new_accountgroup_uuid)->firstOrFail();
                $max_code = Accountsubgroup::where('accountgroup_uuid', $new_accountgroup_uuid)->max('code');
                $next = $max_code ? $max_code + 1 : $new_accountgroup->code + 1;
                $accountsubgroup->update([
                    'code' => $next,
                    'name' => $request->name,
                    'description' => $request->description,
                    'accountgroup_uuid' => $new_accountgroup_uuid,
                ]);
            } else {
                $accountsubgroup->update([
                    'name' => $request->name,
                    'description' => $request->description,
                ]);
            }
        });
        return redirect('/accounts')->with('success', __('word.accountsubgroup.alert.update'));
    }

    public function destroy(string $accountsubgroup_uuid)
    {
        try {
            $accountsubgroup = Accountsubgroup::where('accountsubgroup_uuid', $accountsubgroup_uuid)->first();
            $verified_accounts = Account::where('accountsubgroup_uuid', $accountsubgroup_uuid)->exists();
            if (!$verified_accounts) {
                if ($accountsubgroup) {
                    $accountsubgroup->delete();
                    return response()->json([
                        'type' => 'success',
                        'title' => __('word.general.success'),
                        'msg' => __('word.accountsubgroup.delete_success'),
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
                    'msg' => __('word.accountsubgroup.not_allow'),
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

    public function disable(string $accountsubgroup_uuid)
    {
        $accountsubgroup = Accountsubgroup::where('accountsubgroup_uuid', $accountsubgroup_uuid)->first();
        if ($accountsubgroup) {
            $accountsubgroup->update(['status' => false]);
        }
        return redirect('/accounts')->with('success', __('word.accountsubgroup.alert.disable'));
    }

    public function enable(string $accountsubgroup_uuid)
    {
        $accountsubgroup = Accountsubgroup::where('accountsubgroup_uuid', $accountsubgroup_uuid)->first();
        if ($accountsubgroup) {
            $accountsubgroup->update(['status' => true]);
        }
        return redirect('/accounts')->with('success', __('word.accountsubgroup.alert.enable'));
    }
}
