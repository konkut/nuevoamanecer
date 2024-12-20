<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Servicewithprice;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ServicewithpriceController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $servicewithprices = Servicewithprice::with(['user'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        return view("servicewithprice.index", compact('servicewithprices', 'perPage'));
    }

    public function create()
    {
        $servicewithprice = new Servicewithprice();
        $categories = Category::all();
        return view("servicewithprice.create", compact('servicewithprice', 'categories'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => [
                'required',
                'unique:servicewithprices,name',
                'string',
                'max:50',
                'regex:/^[a-zA-Z0-9\s]+$/',
            ],
            'description' => [
                'nullable',
                'string',
                'max:100',
            ],
            'amount' => [
                'required',
                'numeric',
                'regex:/^\d{1,20}(\.\d{1,2})?$/',
            ],
            'commission' => [
                'nullable',
                'numeric',
                'between:0,9999999999.99',
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
        Servicewithprice::create([
            'name' => $request->name,
            'description' => $request->description,
            'amount' => $request->amount ?? 0.00,
            'commission' => $request->commission ?? 0.00,
            'category_uuid' => $request->category_uuid,
            'user_id' => Auth::id(),
        ]);
        return redirect("/serviceswithprices")->with('success', 'Servicio registrado correctamente.');
    }

    public function edit(string $servicewithprice_uuid)
    {
        $categories = Category::all();
        $servicewithprice = Servicewithprice::where('servicewithprice_uuid', $servicewithprice_uuid)->firstOrFail();
        return view("servicewithprice.edit", compact('servicewithprice', 'categories'));
    }

    public function update(Request $request, string $servicewithprice_uuid)
    {
        $servicewithprice = Servicewithprice::where('servicewithprice_uuid', $servicewithprice_uuid)->firstOrFail();
        $rules = [
            'name' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-zA-Z0-9\s]+$/',
                'unique:servicewithprices,name,' . $servicewithprice->servicewithprice_uuid . ',servicewithprice_uuid',
            ],
            'description' => [
                'nullable',
                'string',
                'max:100',
            ],
            'amount' => [
                'required',
                'numeric',
                'regex:/^\d{1,20}(\.\d{1,2})?$/',
            ],
            'commission' => [
                'nullable',
                'numeric',
                'between:0,9999999999.99',
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
        $servicewithprice->update([
            'name' => $request->name,
            'description' => $request->description,
            'amount' => $request->amount ?? 0.00,
            'commission' => $request->commission ?? 0.00,
            'category_uuid' => $request->category_uuid,
            'status' => $request->status,
        ]);
        return redirect("/serviceswithprices")->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy(string $servicewithprice_uuid)
    {
        $servicewithprice = Servicewithprice::where('servicewithprice_uuid', $servicewithprice_uuid)->firstOrFail();
        $servicewithprice->delete();
        return redirect("/serviceswithprices")->with('success', 'Servicio eliminado correctamente.');
    }
}
