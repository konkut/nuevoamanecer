<?php

namespace App\Http\Controllers;

use App\Mail\SendForgotPassword;
use App\Models\Password_reset_token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ResetPasswordEmailController extends Controller
{
    public function edit(string $id)
    {
        try {
            $data = Crypt::decrypt(urldecode($id));
            $user_id = $data['id'];
            $token = $data['token'];
            $verified = Password_reset_token::where('user_id', $user_id)
                ->where('token', $token)
                ->where('expires_at', '<=', now())
                ->first();
            if ($verified) {
                abort(410);
            } else {
                return view('reset_password.reset_password_email', ['user_id' => $user_id, 'token' => $token]);
            }
        } catch (\Exception $e) {
            abort(410);
        }
    }


    public function update(Request $request)
    {
        try {
            $user = User::where('id', $request->input('user_id'))->first();
            if ($user && $user->id) {
                $validator = Validator::make($request->all(), [
                    'user_id' => 'required',
                    'token' => 'required',
                    'password' => 'required|string|min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%^&])[A-Za-z\d@#$%^&]+$/|confirmed|different:' . $user->password,
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'type' => 'error',
                        'title' => __('word.general.error'),
                        'msg' => __('word.general.error_validation'),
                        'msgs' => json_encode($validator->errors()->all()),
                    ], 422);
                }
                $token = Password_reset_token::where('user_id', $request->user_id)->where('token', $request->token)->first();
                if (!$token) {
                    return response()->json([
                        'type' => 'error',
                        'title' => __('word.general.error'),
                        'msg' => __('word.reset_password_email.token_not_found'),
                    ], 404);
                }
                $user->update([
                    'password' => Hash::make($request->input('password')),
                    'password_changed_at' => now(),
                ]);
                $token->delete();
                return response()->json([
                    'type' => 'success',
                    'title' => __('word.general.success'),
                    'msg' => __('word.reset_password_email.reset_sent'),
                    'redirect' => route('dashboard')
                ], 200);
            } else {
                return response()->json([
                    'type' => 'error',
                    'title' => __('word.general.error'),
                    'msg' => __('word.reset_password_email.user_not_found'),
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
}
