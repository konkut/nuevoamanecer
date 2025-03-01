<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    public function update_password(Request $request)
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
            $user->forceFill([
                'password' => Hash::make($request->input('password')),
                'password_changed_at' => now(),
            ])->save();
            return response()->json([
                'type' => 'success',
                'title' => __('word.general.success'),
                'msg' => __('word.general.updated_information'),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.general.bad_request'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function update_user(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100|unique:users,email,' . $user->id,
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
            $user->forceFill([
                'name' => $request->input('name') ?? $user->name,
                'email' => Str::lower($request->input('email')) ?? $user->email,
            ])->save();
            return response()->json([
                'type' => 'success',
                'title' => __('word.general.success'),
                'msg' => __('word.general.updated_information'),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.general.bad_request'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function two_factor(Request $request)
    {
        try {
            $user = Auth::user();
            $rules = [
                'password_two_factor' => 'required|string',
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
            if (!Hash::check($request->input('password_two_factor'), $user->password)) {
                return response()->json([
                    'type' => 'error',
                    'title' => __('word.general.error'),
                    'msg' => __('word.force_password_change.wrong_password'),
                ], 422);
            }
            if ($user->status_two_factor) {
                $user->update([
                    'status_two_factor' => false
                ]);
                return response()->json([
                    'type' => 'success',
                    'title' => __('word.general.success'),
                    'msg' => __('word.two_factor.disable'),
                    'status' => $user->status_two_factor,
                    'redirect' => route('login')
                ], 200);
            } else {
                $user->update([
                    'status_two_factor' => true
                ]);
                Auth::guard('web')->logout();
                return response()->json([
                    'type' => 'success',
                    'title' => __('word.general.success'),
                    'msg' => __('word.two_factor.enable'),
                    'status' => $user->status_two_factor,
                    'redirect' => route('login')
                ], 200);
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
    public function logout_session(Request $request)
    {
        $user = Auth::user();
        $rules = [
            'password_logout' => 'required|string',
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
        if (!Hash::check($request->input('password_logout'), $user->password)) {
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.force_password_change.wrong_password'),
            ], 422);
        }
        try {
            Auth::guard('web')->logoutOtherDevices($request->input('password_logout'));
            // Eliminar registros de sesiones de la base de datos (si el driver de sesión es "database")
            if (config('session.driver') === 'database') {
                DB::table('sessions')
                    ->where('user_id', $user->id)
                    ->where('id', '!=', $request->session()->getId())
                    ->delete();
            }
            // Mantener la sesión actual activa
            $request->session()->put([
                'password_hash_' . Auth::getDefaultDriver() => $user->getAuthPassword(),
            ]);
            return response()->json([
                'type' => 'success',
                'title' => __('word.general.success'),
                'msg' => __('word.logout_session.success'),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.general.bad_request'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function disable_account(Request $request)
    {
        try {
            $user = Auth::user();
            $rules = [
                'password_disable_account' => 'required|string',
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
            if (!Hash::check($request->input('password_disable_account'), $user->password)) {
                return response()->json([
                    'type' => 'error',
                    'title' => __('word.general.error'),
                    'msg' => __('word.force_password_change.wrong_password'),
                ], 422);
            }
            $user->update(['status' => false]);
            if (config('session.driver') === 'database') {
                DB::table('sessions')
                    ->where('user_id', $user->id)
                    ->delete();
            }
            Auth::guard('web')->logout();
            return response()->json([
                'type' => 'success',
                'title' => __('word.general.success'),
                'msg' => __('word.user.disable_message'),
                'redirect' => route('login'),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.general.bad_request'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function change_language($lang){
        if (in_array($lang, ['es', 'en'])) {
            Session::put('locale', $lang);
        }
        return redirect()->back();
    }
}
