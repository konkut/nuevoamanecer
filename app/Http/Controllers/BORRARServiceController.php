<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Currency;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
  public function index(Request $request)
  {
    $perPage = $request->input('perPage', 10);
    $services = Service::with('user')->paginate($perPage);
    return view("service.index", compact('services', 'perPage'));
  }
  public function create()
  {
    $service = new Service();
    $categories = Category::all();
    //$currencies = Currency::all();
    return view("service.create", compact('service','categories'/*, 'currencies'*/));
  }
  public function store(Request $request)
  {
    
    $rules = [
      'name' => [
        'required',
        'unique:services,name',
        'string',
        'max:30',
        'regex:/^[a-zA-Z0-9\s]+$/',
      ],
      'description' => [
        'nullable',
        'string',
        'max:100',
      ],
      /*'amount' => [
        'required',
        'numeric',
        'regex:/^\d{1,20}(\.\d{1,2})?$/',
      ],
      'commission' => [
        'nullable',
        'numeric',
        'between:0,9999999999.99',
      ],
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
    Service::create([
      'name' => $request->name,
      'description' => $request->description,
      /*'amount' => $request->amount,
      'commission' => $request->commission,
      'currency_uuid' => $request->currency_uuid,*/
      'category_uuid' => $request->category_uuid,
      'user_id' => Auth::id(),
    ]);
    return redirect("/services")->with('success', 'Servicio registrado correctamente.');
  }
  public function show($service_uuid, Request $request)
  {
    $service = Service::where('service_uuid', $service_uuid)->firstOrFail();
    return view('service.show', compact('service'));
  }
  public function edit(string $service_uuid)
  {
    $categories = Category::all();
    //$currencies = Currency::all();
    $service = Service::where('service_uuid', $service_uuid)->firstOrFail();
    return view("service.edit", compact('service', 'categories'/*, 'currencies'*/));
  }

  public function update(Request $request, string $service_uuid)
  {
    $service = Service::where('service_uuid', $service_uuid)->firstOrFail(); //servicio que se está actualizando.
    $rules = [
      'name' => [
        'required',
        'string',
        'max:30',
        'regex:/^[a-zA-Z0-9\s]+$/',
        'unique:services,name,' . $service->service_uuid . ',service_uuid',  //el nombre sea único, excepto para el registro actual.
      ],
      'description' => [
        'nullable',
        'string',
        'max:100',
      ],
      /*'amount' => [
        'required',
        'numeric',
        'regex:/^\d{1,20}(\.\d{1,2})?$/',
      ],
      'commission' => [
        'nullable',
        'numeric',
        'between:0,9999999999.99',
      ],
      'currency_uuid' => [
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
    $service->update([
      'name' => $request->name,
      'description' => $request->description,
      /*'amount' => $request->amount,
      'commission' => $request->commission,
      'currency_uuid' => $request->currency_uuid,*/
      'category_uuid' => $request->category_uuid,
      'status' => $request->status,
    ]);
    return redirect("/services")->with('success', 'Servicio actualizado correctamente.');
  }
  public function destroy(string $service_uuid)
  {
    $service = Service::where('service_uuid', $service_uuid)->firstOrFail();
    $service->delete(); 
    return redirect("/services")->with('success', 'Servicio eliminado correctamente.');
  }
  // Muestra todos los servicios, incluidos los "eliminados"
  public function showAllServices()
  {
    $services = Service::withTrashed()->get(); // Incluye los soft deleted
    return view('services.index', compact('services'));
  }

  // Restaura un servicio "eliminado"
  public function restoreService($id)
  {
    $service = Service::withTrashed()->find($id);
    $service->restore(); // Restaura el registro
    return back()->with('message', 'Servicio restaurado correctamente');
  }
  //Eliminación Permanente:
  public function destroyPermanent(string $slug)
  {
    $service = Service::where('slug', $slug)->firstOrFail();
    $service->forceDelete(); // elimina el registro completamente de la base de datos, ignorando softDeletes.
    return redirect("/services")->with('success', 'Servicio eliminado correctamente.');
  }
}

