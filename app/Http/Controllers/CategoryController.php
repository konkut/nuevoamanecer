<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
  public function index(Request $request)
  {
    $perPage = $request->input('perPage', 10);
      $categories = Category::orderBy('created_at', 'desc')
          ->paginate($perPage);
    return view("category.index", compact('categories', 'perPage'));
  }
  public function create()
  {
    $category = new Category();
    return view("category.create", compact('category'));
  }
  public function store(Request $request)
  {

    $rules = [
      'name' => [
        'required',
        'unique:categories,name',
        'string',
        'max:30',
        'regex:/^[a-zA-Z0-9\s]+$/',
      ],
      'description' => [
        'nullable',
        'string',
        'max:100',
      ],
    ];
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator)
        ->withInput();
    }
    Category::create([
      'name' => $request->name,
      'description' => $request->description,
    ]);
    return redirect("/categories")->with('success', 'Categoria registrada correctamente.');
  }
  public function edit(string $category_uuid)
  {
    $category = Category::where('category_uuid', $category_uuid)->firstOrFail();
    return view("category.edit", compact('category'));
  }

  public function update(Request $request, string $category_uuid)
  {
    $category = Category::where('category_uuid', $category_uuid)->firstOrFail(); //servicio que se está actualizando.
    $rules = [
      'name' => [
        'required',
        'string',
        'max:30',
        'regex:/^[a-zA-Z0-9\s]+$/',
        'unique:categories,name,' . $category->category_uuid . ',category_uuid',  //el nombre sea único, excepto para el registro actual.
      ],
      'description' => [
        'nullable',
        'string',
        'max:100',
      ],
      'status' => [
        'required',
        'integer',
      ],
    ];
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator)
        ->withInput();
    }
    $category->update([
      'name' => $request->name,
      'description' => $request->description,
      'status' => $request->status,
    ]);
    return redirect("/categories")->with('success', 'Categoria actualizada correctamente.');
  }
  public function destroy(string $category_uuid)
  {
    $category = Category::where('category_uuid', $category_uuid)->firstOrFail();
    $category->delete();
    return redirect("/categories")->with('success', 'Categoria eliminada correctamente.');
  }
}
