<?php

namespace App\Http\Controllers;

use App\Mail\SendForgotPassword;
use App\Models\Password_reset_token;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class ForgotPasswordController extends Controller
{
    public function create()
    {
        return view("forgot_password.forgot_password");
    }
    public function store(Request $request)
    {
        $rules = [
            'email' => 'required|email',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.general.error_validation'),
                'msgs' => json_encode($validator->errors()->all()),
            ], 422);
        } else {
            try {
                $email = Str::lower($request->input('email'));
                $user = User::where('email', $email)->first();
                if ($user && $user->email) {
                    $token = Str::random(64);
                    Password_reset_token::create([
                        'user_id' => $user->id,
                        'token' => $token,
                        'expires_at' => Carbon::now()->addMinutes(30),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    $id = Crypt::encrypt(['id' => $user->id, 'token' => $token]);
                    $link = route('password.link', ['id' => urlencode($id)]);
                    $data = ['name' => $user->name, 'app_name' => config('setting.app_name')];
                    Mail::to($user->email)->send(new SendForgotPassword($data, $link));
                    return response()->json([
                        'type' => 'success',
                        'title' => __('word.general.success'),
                        'msg' => __('word.reset_password_email.forgot_sent'),
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
                    'error' => $e->getMessage(),
                ], 500);
            }
        }
    }
}
