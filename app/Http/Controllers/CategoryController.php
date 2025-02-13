<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $categories = Category::with('user')->orderBy('created_at', 'desc')->paginate($perPage);
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
            'name' => 'required|unique:categories,name|string|max:30',
            'description' => 'nullable|string|max:100',
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
            'user_id' => Auth::id(),
        ]);
        return redirect("/categories")->with('success', __('word.category.alert.store'));
    }

    public function edit(string $category_uuid)
    {
        $category = Category::where('category_uuid', $category_uuid)->firstOrFail();
        return view("category.edit", compact('category'));
    }

    public function update(Request $request, string $category_uuid)
    {
        $category = Category::where('category_uuid', $category_uuid)->firstOrFail();
        $rules = [
            'name' => 'required|string|max:30|unique:categories,name,' . $category->category_uuid . ',category_uuid',  //el nombre sea único, excepto para el registro actual.
            'description' => 'nullable|string|max:100',
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
            'user_id' => Auth::id(),
        ]);
        return redirect("/categories")->with('success', __('word.category.alert.update'));
    }

    public function destroy(string $category_uuid)
    {
        try {
            $category = Category::where('category_uuid', $category_uuid)->first();
            $verified_service = Service::where('category_uuid',$category_uuid)->exists();
            $verified_product = Product::where('category_uuid',$category_uuid)->exists();
            $verified_expense = Expense::where('category_uuid',$category_uuid)->exists();
            if (!$verified_service && !$verified_product && !$verified_expense) {
                if ($category) {
                    $category->delete();
                    return response()->json([
                        'type' => 'success',
                        'title' => __('word.general.success'),
                        'msg' => __('word.category.delete_success'),
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
                    'msg' => __('word.category.not_allow'),
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

    public function disable(string $category_uuid)
    {
        $category = Category::where('category_uuid', $category_uuid)->firstOrFail();
        $category->update([
            'status' => "0",
            'user_id' => Auth::id(),
        ]);
        return redirect("/categories")->with('success', __('word.category.alert.disable'));
    }
    public function enable(string $category_uuid)
    {
        $category = Category::where('category_uuid', $category_uuid)->firstOrFail();
        $category->update([
            'status' => "1",
            'user_id' => Auth::id(),
        ]);
        return redirect("/categories")->with('success', __('word.category.alert.enable'));
    }
}
