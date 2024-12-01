<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Servicewithoutprice;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class ServicewithoutpriceController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $servicewithoutprices = Servicewithoutprice::with('user')->paginate($perPage);
        return view("servicewithoutprice.index", compact('servicewithoutprices', 'perPage'));
    }

    public function create()
    {
        $servicewithoutprice = new Servicewithoutprice();
        $categories = Category::all();
        return view("servicewithoutprice.create", compact('servicewithoutprice', 'categories'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => [
                'required',
                'unique:servicewithoutprices,name',
                'string',
                'max:30',
                'regex:/^[a-zA-Z0-9\s]+$/',
            ],
            'description' => [
                'nullable',
                'string',
                'max:100',
            ],
            'category_uuid' => [
                'required',
                'string',
                'max:36',
            ]
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        Servicewithoutprice::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_uuid' => $request->category_uuid,
            'user_id' => Auth::id(),
        ]);
        return redirect("/serviceswithoutprices")->with('success', 'Servicio registrado correctamente.');
    }

    public function edit(string $servicewithoutprice_uuid)
    {
        $categories = Category::all();
        $servicewithoutprice = Servicewithoutprice::where('servicewithoutprice_uuid', $servicewithoutprice_uuid)->firstOrFail();
        return view("servicewithoutprice.edit", compact('servicewithoutprice', 'categories'));
    }

    public function update(Request $request, string $servicewithoutprice_uuid)
    {
        $servicewithoutprice = Servicewithoutprice::where('servicewithoutprice_uuid', $servicewithoutprice_uuid)->firstOrFail();
        $rules = [
            'name' => [
                'required',
                'string',
                'max:30',
                'regex:/^[a-zA-Z0-9\s]+$/',
                'unique:servicewithoutprices,name,' . $servicewithoutprice->servicewithoutprice_uuid . ',servicewithoutprice_uuid',
            ],
            'description' => [
                'nullable',
                'string',
                'max:100',
            ],
            'category_uuid' => [
                'required',
                'string',
                'max:36',
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
        $servicewithoutprice->update([
            'name' => $request->name,
            'description' => $request->description,
            'category_uuid' => $request->category_uuid,
            'status' => $request->status,
        ]);
        return redirect("/serviceswithoutprices")->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy(string $servicewithoutprice_uuid)
    {
        $servicewithoutprice = Servicewithoutprice::where('servicewithoutprice_uuid', $servicewithoutprice_uuid)->firstOrFail();
        $servicewithoutprice->delete();
        return redirect("/serviceswithoutprices")->with('success', 'Servicio eliminado correctamente.');
    }
}
