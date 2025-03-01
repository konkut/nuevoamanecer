<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $products = Product::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        return view("product.index", compact('products', 'perPage'));
    }

    public function create()
    {
        $product = new Product();
        $categories = Category::where("status", '1')->get();
        return view("product.create", compact('product', 'categories'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:products,name|string|max:50',
            'description' => 'nullable|string|max:100',
            'price' => 'required|numeric',
            'category_uuid' => 'required|string|max:36|exists:categories,category_uuid',
            'stock' => 'required|integer|min:1',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $validator->after(function ($validator) use ($request) {
            if ($request->input('price') == 0) {
                $validator->errors()->add('price', __('word.rules.rule_six'));
                return;
            }
            if ($request->input('price') > 10000) {
                $validator->errors()->add('price', __('word.rules.rule_seven'));
                return;
            }
            if ($request->input('price') < 0) {
                $validator->errors()->add('price', __('word.rules.rule_eight'));
                return;
            }
            if (!is_numeric($request->input('price'))) {
                $validator->errors()->add('price', __('word.rules.rule_nine'));
                return;
            }
            if (!preg_match('/^\d+(\.\d{1,2})?$/', $request->input('price'))) {
                $validator->errors()->add('price', __('word.rules.rule_ten'));
                return;
            }
        });
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_uuid' => $request->category_uuid,
            'user_id' => Auth::id(),
        ]);
        return redirect("/products")->with('success', __('word.product.alert.store'));
    }

    public function edit(string $product_uuid)
    {
        $product = Product::where('product_uuid', $product_uuid)->firstOrFail();
        $categories = Category::where("status", '1')->get();
        return view("product.edit", compact('product', 'categories'));
    }

    public function update(Request $request, string $product_uuid)
    {
        $product = Product::where('product_uuid', $product_uuid)->firstOrFail();
        $rules = [
            'name' => 'required|unique:products,name,' . $product->product_uuid . ',product_uuid|string|max:50',
            'description' => 'nullable|string|max:100',
            'price' => 'required|numeric',
            'category_uuid' => 'required|string|max:36|exists:categories,category_uuid',
            'stock' => 'required|integer|min:1',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $validator->after(function ($validator) use ($request) {
            if ($request->input('price') == 0) {
                $validator->errors()->add('price', __('word.rules.rule_six'));
                return;
            }
            if ($request->input('price') > 10000) {
                $validator->errors()->add('price', __('word.rules.rule_seven'));
                return;
            }
            if ($request->input('price') < 0) {
                $validator->errors()->add('price', __('word.rules.rule_eight'));
                return;
            }
            if (!is_numeric($request->input('price'))) {
                $validator->errors()->add('price', __('word.rules.rule_nine'));
                return;
            }
            if (!preg_match('/^\d+(\.\d{1,2})?$/', $request->input('price'))) {
                $validator->errors()->add('price', __('word.rules.rule_ten'));
                return;
            }
        });
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_uuid' => $request->category_uuid,
        ]);
        return redirect("/products")->with('success', __('word.product.alert.update'));
    }

    public function destroy(string $product_uuid)
    {
        try {
            $product = Product::where('product_uuid', $product_uuid)->first();
            $verified_sale = DB::table('sale_products')
                ->where('sale_products.product_uuid', $product_uuid)->first();
            if (!$verified_sale) {
                if ($product) {
                    $product->delete();
                    return response()->json([
                        'type' => 'success',
                        'title' => __('word.general.success'),
                        'msg' => __('word.product.delete_success'),
                        'redirect' => route('products.index')
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
                    'msg' => __('word.product.not_allow'),
                ], 400);
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

    public function disable(string $product_uuid)
    {
        $product = Product::where('product_uuid', $product_uuid)->firstOrFail();
        $product->update([
            'status' => "0",
            'user_id' => Auth::id(),
        ]);
        return redirect("/products")->with('success', __('word.product.alert.disable'));
    }
    public function enable(string $product_uuid)
    {
        $product = Product::where('product_uuid', $product_uuid)->firstOrFail();
        $product->update([
            'status' => "1",
            'user_id' => Auth::id(),
        ]);
        return redirect("/products")->with('success', __('word.product.alert.enable'));
    }
}
