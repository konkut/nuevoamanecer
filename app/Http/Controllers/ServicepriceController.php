<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Serviceprice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class ServicepriceController extends Controller
{
  public function index(Request $request)
  {
    $perPage = $request->input('perPage', 10);
    $servicesprices = Serviceprice::with('user')->paginate($perPage);
    return view("serviceprice.index", compact('servicesprices', 'perPage'));
  }
  public function create()
  {
    $serviceprice = new Serviceprice();
    $categories = Category::all();
    //$currencies = Currency::all();
    return view("serviceprice.create", compact('serviceprice', 'categories'/*, 'currencies'*/));
  }
  public function store(Request $request)
  {
    $rules = [
      'name' => [
        'required',
        'unique:serviceprices,name',
        'string',
        'max:30',
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
      ],/*
      'currency_uuid' => [
        'required',
        'string',
        'max:36',
      ],*/
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
    Serviceprice::create([
      'name' => $request->name,
      'description' => $request->description,
      'amount' => $request->amount,
      'commission' => $request->commission,
      /*'currency_uuid' => $request->currency_uuid,*/
      'category_uuid' => $request->category_uuid,
      'user_id' => Auth::id(),
    ]);
    return redirect("/servicesprices")->with('success', 'Servicio registrado correctamente.');
  }
  public function show($serviceprice_uuid, Request $request)
  {
    $serviceprice = Serviceprice::where('serviceprice_uuid', $serviceprice_uuid)->firstOrFail();
    return view('serviceprice.show', compact('serviceprice'));
  }
  public function edit(string $serviceprice_uuid)
  {
    $categories = Category::all();
    //$currencies = Currency::all();
    $serviceprice = Serviceprice::where('serviceprice_uuid', $serviceprice_uuid)->firstOrFail();
    return view("serviceprice.edit", compact('serviceprice', 'categories'/*, 'currencies'*/));
  }

  public function update(Request $request, string $serviceprice_uuid)
  {
    $serviceprice = Serviceprice::where('serviceprice_uuid', $serviceprice_uuid)->firstOrFail(); 
    $rules = [
      'name' => [
        'required',
        'string',
        'max:30',
        'regex:/^[a-zA-Z0-9\s]+$/',
        'unique:serviceprices,name,' . $serviceprice->serviceprice_uuid . ',serviceprice_uuid',
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
      /*'currency_uuid' => [
        'required',
        'string',
        'max:36',
      ],*/
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
    $serviceprice->update([
      'name' => $request->name,
      'description' => $request->description,
      'amount' => $request->amount,
      'commission' => $request->commission,
      /*'currency_uuid' => $request->currency_uuid,*/
      'category_uuid' => $request->category_uuid,
      'status' => $request->status,
    ]);
    return redirect("/servicesprices")->with('success', 'Servicio actualizado correctamente.');
  }
  public function destroy(string $serviceprice_uuid)
  {
    $serviceprice = Serviceprice::where('serviceprice_uuid', $serviceprice_uuid)->firstOrFail();
    $serviceprice->delete();
    return redirect("/servicesprices")->with('success', 'Servicio eliminado correctamente.');
  }
}
