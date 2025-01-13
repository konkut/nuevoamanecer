<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Denomination;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Servicewithoutprice;
use App\Models\Servicewithprice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Monolog\Handler\IFTTTHandler;

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
        $array_servicewithoutprices = Category::join('servicewithoutprices', 'servicewithoutprices.category_uuid', '=', 'categories.category_uuid')
            ->where('servicewithoutprices.category_uuid', $category_uuid)
            ->select('servicewithoutprices.status', 'servicewithoutprices.servicewithoutprice_uuid')->get();

        $array_servicewithprices = Category::join('servicewithprices', 'servicewithprices.category_uuid', '=', 'categories.category_uuid')
            ->where('servicewithprices.category_uuid', $category_uuid)
            ->select('servicewithprices.status', 'servicewithprices.servicewithprice_uuid')->get();

        $array_products = Category::join('products', 'products.category_uuid', '=', 'categories.category_uuid')
            ->where('products.category_uuid', $category_uuid)
            ->select('products.status', 'products.product_uuid')->get();

        foreach ($array_servicewithoutprices as $item) {
            $servicewithoutprice = Servicewithoutprice::where('servicewithoutprice_uuid', $item->servicewithoutprice_uuid)->first();
            if ($servicewithoutprice) {
                $servicewithoutprice->update([
                    'status' => $request->status == '0' ? '0' : '1'
                ]);
            }
        }
        foreach ($array_servicewithprices as $item) {
            $servicewithprice = Servicewithprice::where('servicewithprice_uuid', $item->servicewithprice_uuid)->first();
            if ($servicewithprice) {
                $servicewithprice->update([
                    'status' => $request->status == '0' ? '0' : '1'
                ]);
            }
        }
        foreach ($array_products as $item) {
            $product = Product::where('product_uuid', $item->product_uuid)->first();
            if ($product) {
                $product->update([
                    'status' => $request->status == '0' ? '0' : '1'
                ]);
            }
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
