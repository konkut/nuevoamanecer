<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ForcePasswordChangeController extends Controller
{
    public function edit()
    {
        return view('force_password.force_password');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%^&])[A-Za-z\d@#$%^&]+$/|confirmed|different:current_password',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.general.error_validation'),
                'msgs' => json_encode($validator->errors()->all()),
            ], 422);
        }
        try {
            $user = Auth::user();
            if (!Hash::check($request->input('current_password'), $user->password)) {
                return response()->json([
                    'type' => 'error',
                    'title' => __('word.general.error'),
                    'msg' => __('word.force_password_change.wrong_password'),
                ], 422);
            }
            $user->update([
                'password' => Hash::make($request->input('password')),
                'password_changed_at' => now(),
            ]);
            return response()->json([
                'type' => 'success',
                'title' => __('word.general.success'),
                'redirect' => route('dashboard')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.general.bad_request'),
            ], 500);
        }
    }
}
