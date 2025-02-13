<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $users = User::orderBy('created_at', 'desc')->paginate($perPage);
        foreach ($users as $user) {
            $roles = $user->roles->pluck('name')->toArray();
            $user->rol = $roles;
        }
        $roles = Role::all();
        return view("user.index", compact('users', 'perPage', 'roles'));
    }

    public function create()
    {
        $user = new User();
        $roles = Role::all();
        return view("user.create", compact('user', 'roles'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:8|max:32|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%^&])[A-Za-z\d@#$%^&]+$/|confirmed',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id',
            'profile_photo_path' => 'nullable|string|max:2048',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => Str::lower($request->input('email')),
                'password' => bcrypt($request->input('password')),
                'password_changed_at' => now(),
                'profile_photo_path' => $request->input('profile_photo_path') ?? null,
            ]);
            $user->roles()->sync($request->input('roles'));
        });
        return redirect("/users")->with('success', __('word.user.alert.store'));
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view("user.edit", compact('user', 'roles'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $rules = [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|max:32|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%^&])[A-Za-z\d@#$%^&]+$/|confirmed',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id',
            'profile_photo_path' => 'nullable|string|max:2048',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        DB::transaction(function () use ($user, $request) {
            if ($request->input('new_password')) {
                $user->update([
                    'password' => bcrypt($request->input('password')),
                    'password_changed_at' => now(),
                ]);
            }
            $user->update([
                'name' => $request->input('name'),
                'email' => Str::lower($request->input('email')),
                'profile_photo_path' => $request->input('profile_photo_path') ?? null,
            ]);
            $user->roles()->sync($request->input('roles'));
        });
        return redirect("/users")->with('success', __('word.user.alert.update'));
    }
    public function enable(string $id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => true]);
        return redirect('/users')->with('success', __('word.user.alert.enable'));
    }

    public function disable(string $id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => false]);
        if (config('session.driver') === 'database') {
            DB::table('sessions')
                ->where('user_id', $user->id)
                ->delete();
        }
        if (Auth::id() == $user->id) {
            Auth::guard('web')->logout();
            return redirect('/login')->with('success', __('word.user.alert.out'));
        }
        return redirect('/users')->with('success', __('word.user.alert.disable'));
    }

    public function roles(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->roles()->sync($request->roles);
        return redirect("/users")->with('success', __('word.user.alert.roles'));
    }
}
