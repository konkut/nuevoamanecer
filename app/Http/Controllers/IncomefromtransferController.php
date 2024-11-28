<?php

namespace App\Http\Controllers;

use App\Models\Denomination;
use App\Models\Incomefromtransfer;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class IncomefromtransferController extends Controller
{
  public function index(Request $request)
  {
    $perPage = $request->input('perPage', 10);
    $incomefromtransfers = Incomefromtransfer::with(['user', 'denomination'])->paginate($perPage);
    foreach ($incomefromtransfers as $transfer) {
      // Decodificar los UUIDs de servicios
      $serviceUuids = json_decode($transfer->service_uuids, true);

      // Obtener los nombres de los servicios relacionados
      $transfer->related_services = Service::whereIn('service_uuid', $serviceUuids)->pluck('name');
    }
    return view("incomefromtransfer.index", compact('incomefromtransfers', 'perPage'));
  }

  public function create()
  {
    $incomefromtransfer = new Incomefromtransfer();
    $denomination = new Denomination();
    $services = Service::all();
    return view("incomefromtransfer.create", compact('incomefromtransfer', 'services', 'denomination'));
  }
  public function store(Request $request)
  {
    $rules_denomination = [
      'bill_200' => [
        'nullable',
        'integer',
      ],
      'bill_100' => [
        'nullable',
        'integer',
      ],
      'bill_50' => [
        'nullable',
        'integer',
      ],
      'bill_20' => [
        'nullable',
        'integer',
      ],
      'bill_10' => [
        'nullable',
        'integer',
      ],
      'coin_5' => [
        'nullable',
        'integer',
      ],
      'coin_2' => [
        'nullable',
        'integer',
      ],
      'coin_1' => [
        'nullable',
        'integer',
      ],
      'coin_0_5' => [
        'nullable',
        'integer',
      ],
      'coin_0_2' => [
        'nullable',
        'integer',
      ],
      'coin_0_1' => [
        'nullable',
        'integer',
      ],
      'total' => [
        'required',
        'numeric',
        'regex:/^(?!0(\.0{1,2})?$)\d{1,20}(\.\d{1,2})?$/',
      ],
    ];
    $validator_denomination = Validator::make($request->all(), $rules_denomination);
    if ($validator_denomination->fails()) {
      return redirect()->back()
        ->withErrors($validator_denomination)
        ->withInput();
    }

    //Validation income from transfer
    $rules = [
      'code' => [
        'required',
        'string',
        'max:30',
        'regex:/^[a-zA-Z0-9-\s]+$/',
      ],
      'amounts' => 'required|array',
      'amounts.*' => 'required|numeric|min:0.01',
      'commissions' => 'required|array',
      'commissions.*' => 'nullable|numeric|min:0',
      'service_uuids' => 'required|array',
      'service_uuids.*' => 'required|string|exists:services,service_uuid',
      'observation' => [
        'nullable',
        'string',
        'max:100',
      ]
    ];
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator)
        ->withInput();
    }

    $denomination = Denomination::create([
      'bill_200' => $request->bill_200 ?? 0,
      'bill_100' => $request->bill_100 ?? 0,
      'bill_50' => $request->bill_50 ?? 0,
      'bill_20' => $request->bill_20 ?? 0,
      'bill_10' => $request->bill_10 ?? 0,
      'coin_5' => $request->coin_5 ?? 0,
      'coin_2' => $request->coin_2 ?? 0,
      'coin_1' => $request->coin_1 ?? 0,
      'coin_0_5' => $request->coin_0_5 ?? 0,
      'coin_0_2' => $request->coin_0_2 ?? 0,
      'coin_0_1' => $request->coin_0_1 ?? 0,
      'total' => $request->total ?? 0,
    ]);

    Incomefromtransfer::create([
      'code' => $request->code,
      'amounts' => json_encode($request->amounts),
      'commissions' => json_encode($request->commissions),
      'service_uuids' => json_encode($request->service_uuids),
      'observation' => $request->observation,
      'denomination_uuid' => $denomination->denomination_uuid, // Usar el UUID de Denomination aquí
      'user_id' => Auth::id(),
    ]);
    return redirect("/incomefromtransfers")->with('success', 'Ingreso registrado correctamente.');
  }
  public function show($incomefromtransfer_uuid, Request $request)
  {
    $incomefromtransfer = Incomefromtransfer::where('incomefromtransfer_uuid', $incomefromtransfer_uuid)->firstOrFail();
    // Obtener la denominación asociada
    $denomination = Denomination::where('denomination_uuid', $incomefromtransfer->denomination_uuid)->firstOrFail();
    // Decodificar los UUIDs de los servicios relacionados
    $serviceUuids = json_decode($incomefromtransfer->service_uuids, true);
    // Obtener los nombres de los servicios relacionados
    $relatedServices = Service::whereIn('service_uuid', $serviceUuids)->pluck('name');
    // Pasar los servicios relacionados a la vista
    return view('incomefromtransfer.show', compact('incomefromtransfer', 'denomination', 'relatedServices'));
  }
  public function getServices()
  {
    $services = Service::all();  // Recupera todos los servicios
    return response()->json($services);
  }
  public function edit(string $incomefromtransfer_uuid)
  {
    $incomefromtransfer = Incomefromtransfer::where('incomefromtransfer_uuid', $incomefromtransfer_uuid)->firstOrFail();
    $denomination = Denomination::where('denomination_uuid', $incomefromtransfer->denomination_uuid)->firstOrFail();
    $services = Service::all();

    // Asegúrate de que estos campos son arrays en el controlador
    $amounts = json_decode($incomefromtransfer->amounts, true);  // Si están en formato JSON
    $commissions = json_decode($incomefromtransfer->commissions, true);
    $service_uuids = json_decode($incomefromtransfer->service_uuids, true);


    return view("incomefromtransfer.edit", compact('incomefromtransfer', 'denomination', 'services', 'amounts', 'commissions', 'service_uuids'));
  }

  public function update(Request $request, string $incomefromtransfer_uuid)
  {
    $incomefromtransfer = Incomefromtransfer::where('incomefromtransfer_uuid', $incomefromtransfer_uuid)->firstOrFail();
    $denomination = Denomination::where('denomination_uuid', $incomefromtransfer->denomination_uuid)->firstOrFail();

    $rules_denomination = [
      'bill_200' => [
        'nullable',
        'integer',
      ],
      'bill_100' => [
        'nullable',
        'integer',
      ],
      'bill_50' => [
        'nullable',
        'integer',
      ],
      'bill_20' => [
        'nullable',
        'integer',
      ],
      'bill_10' => [
        'nullable',
        'integer',
      ],
      'coin_5' => [
        'nullable',
        'integer',
      ],
      'coin_2' => [
        'nullable',
        'integer',
      ],
      'coin_1' => [
        'nullable',
        'integer',
      ],
      'coin_0_5' => [
        'nullable',
        'integer',
      ],
      'coin_0_2' => [
        'nullable',
        'integer',
      ],
      'coin_0_1' => [
        'nullable',
        'integer',
      ],
      'total' => [
        'required',
        'numeric',
        'regex:/^(?!0(\.0{1,2})?$)\d{1,20}(\.\d{1,2})?$/',
      ],
    ];
    $validator_denomination = Validator::make($request->all(), $rules_denomination);
    if ($validator_denomination->fails()) {
      return redirect()->back()
        ->withErrors($validator_denomination)
        ->withInput();
    }

    $rules = [
      'code' => [
        'required',
        'string',
        'max:30',
        'regex:/^[a-zA-Z0-9-\s]+$/',
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
      'observation' => [
        'nullable',
        'string',
        'max:100',
      ],
      'service_uuid' => [
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
    $denomination->update([
      'bill_200' => $request->bill_200 ?? 0,
      'bill_100' => $request->bill_100 ?? 0,
      'bill_50' => $request->bill_50 ?? 0,
      'bill_20' => $request->bill_20 ?? 0,
      'bill_10' => $request->bill_10 ?? 0,
      'coin_5' => $request->coin_5 ?? 0,
      'coin_2' => $request->coin_2 ?? 0,
      'coin_1' => $request->coin_1 ?? 0,
      'coin_0_5' => $request->coin_0_5 ?? 0,
      'coin_0_2' => $request->coin_0_2 ?? 0,
      'coin_0_1' => $request->coin_0_1 ?? 0,
      'total' => $request->total ?? 0,
    ]);

    $incomefromtransfer->update([
      'code' => $request->code,
      'amount' => $request->amount,
      'commission' => $request->commission,
      'observation' => $request->observation,
      'service_uuid' => $request->service_uuid,
      'status' => $request->status,
      'user_id' => Auth::id(),
    ]);
    return redirect("/incomefromtransfers")->with('success', 'Ingreso actualizado correctamente.');
  }
  public function destroy(string $incomefromtransfer_uuid)
  {
    $incomefromtransfer = Incomefromtransfer::where('incomefromtransfer_uuid', $incomefromtransfer_uuid)->firstOrFail();

    $incomefromtransfer->delete();

    return redirect("/incomefromtransfers")->with('success', 'Ingreso eliminado correctamente.');
  }
}
