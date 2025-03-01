<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendCodeTwoFactor;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class TwoFactorController extends Controller
{
    public function get_code()
    {
        $this->get_send_code();
        return view('two_factor.two_factor');
    }

    public function get_send_code()
    {
        $code = rand(100001, 999999);
        $user = User::where('id', Auth::id())->first();
        $data = ['code' => $code, 'name' => $user->name, 'app_name' => config('setting.app_name')];
        //return view('auth.two_factor_mail',$data);
        $user->update([
            "auth_code" => $code,
        ]);
        Mail::to($user->email)->send(new SendCodeTwoFactor($data));
    }

    public function get_verify(Request $request)
    {
        $rules = [
            'auth_code' => 'required|numeric|min:6',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.general.error_validation'),
                'msgs' => json_encode($validator->errors()->all()),
            ], 422);
        }
        try {
            $user_code = Auth::user()->auth_code;
            if ($user_code != $request->input('auth_code')) {
                return response()->json([
                    'type' => 'error',
                    'title' => __('word.general.error'),
                    'msg' => __('word.two_factor.verify'),
                ], 401);
            }
            $cookie = cookie('device_trusted', '1', env('SESSION_LIFETIME'));
            return response()->json([
                'type' => 'success',
                'redirect' => route('dashboard')
            ])->withCookie($cookie);
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.general.bad_request'),
            ], 400);
        }
    }
}
