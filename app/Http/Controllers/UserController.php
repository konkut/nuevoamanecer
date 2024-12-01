<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
  public function index(Request $request)
  {
    $roles = Role::all();
    $perPage = $request->input('perPage', 10);
    $users = User::paginate($perPage);
    return view("user.index", compact('users', 'perPage','roles'));
  }
  public function create()
  {
    $user = new User();
    return view("user.create", compact('user'));
  }
  public function store(Request $request)
  {
    $rules = [
      'name' => [
        'required',
        'string',
        'max:100',
        'regex:/^[a-zA-Z\s]+$/',
      ],
      'email' => [
        'required',
        'email',
        'max:100',
        'unique:users,email',
      ],
      'password' => [
        'required',
        'string',
        'min:8',
      ],
      'profile_photo_path' => [
        'nullable',
        'string',
        'max:2048',
      ],
    ];
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator)
        ->withInput();
    }
    User::create(['name' => $request->input('name'),
      'email' => $request->input('email'),
      'password' => bcrypt($request->input('password')),
      'profile_photo_path' => $request->input('profile_photo_path') ?? null,
    ]);
    return redirect("/users")->with('success', 'Usuario registrado  orrectamente.');
  }
  public function edit(string $id)
  {
    $user = User::findOrFail($id);
    return view("user.edit", compact('user'));
  }
  public function assign_roles(Request $request, string $id){
    $user = User::findOrFail($id);
    $user->roles()->sync($request->roles);
    return redirect("/users")->with('success', 'Roles actualizado correctamente.');
  }

  public function update(Request $request, string $id)
  {
    $user = User::findOrFail($id);
    $rules = [
      'name' => [
        'required',
        'string',
        'max:100',
        'regex:/^[a-zA-Z\s]+$/',
      ],
      'email' => [
        'required',
        'email',
        'max:100',
        'unique:users,email,' . $user->id,
      ],
      'password' => [
        'required',
        'string',
        'min:8',
      ],
      'profile_photo_path' => [
        'nullable',
        'string',
        'max:2048',
      ],
    ];
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator)
        ->withInput();
    }
    $user->update([
      'name' => $request->input('name'),
      'email' => $request->input('email'),
      'password' => bcrypt($request->input('password')),
      'profile_photo_path' => $request->input('profile_photo_path') ?? null,
    ]);
    return redirect("/users")->with('success', 'Usuario actualizado correctamente.');
  }
  public function destroy(string $id)
  {
    $user = User::findOrFail($id);
    $user->delete();
    return redirect("/users")->with('success', 'Usuario eliminado correctamente.');
  }
}
