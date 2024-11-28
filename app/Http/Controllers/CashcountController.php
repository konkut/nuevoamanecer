<?php

namespace App\Http\Controllers;

use App\Models\Cashcount;
use App\Models\Denomination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class CashcountController extends Controller
{
  public function index(Request $request)
  {
    $perPage = $request->input('perPage', 10);
    $cashcounts = Cashcount::with(['user', 'opening_denomination', 'closing_denomination'])->paginate($perPage);
    return view("cashcount.index", compact('cashcounts', 'perPage'));
  }
  public function create()
  {
    $denomination = new Denomination();
    $cashcount = new Cashcount();
    return view("cashcount.create", compact('cashcount','denomination'));
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
      /*'date' => [
        'required',              // El campo es obligatorio
        'date',                 // Validar que sea una fecha válida
        'after_or_equal:today', // La fecha debe ser hoy o una fecha futura (opcional)
      ],*/
      'opening' => [
        'required',
        'numeric',
        'regex:/^\d{1,20}(\.\d{1,2})?$/',
      ],
      /*'closing' => [
        'nullable',
        'numeric',
        'regex:/^\d{1,20}(\.\d{1,2})?$/',
      ],*/
      /*'opening_denomination_uuid' => [
        'required',
        'string',
        'max:36',
      ],
      'closing_denomination_uuid' => [
        'required',
        'string',
        'max:36',
      ]*/
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

    Cashcount::create([
      'date' => now(),
      'opening' => $request->opening,

      'opening_denomination_uuid' => $denomination->denomination_uuid,
      'user_id' => Auth::id(),
    ]);
    return redirect("/cashcounts")->with('success', 'Arqueo registrado correctamente.');
  }
  public function show($cashcount_uuid, Request $request)
  {
    $cashcount = Cashcount::where('cashcount_uuid', $cashcount_uuid)->firstOrFail();
    // Obtener la denominación asociada
    $denomination = Denomination::where('denomination_uuid', $cashcount->opening_denomination_uuid)->firstOrFail();
    // Pasar los servicios relacionados a la vista
    return view('incomefromtransfer.show', compact('cashcount', 'denomination'));
  }
  /*
  public function edit(string $cashcount_uuid)
  {
    $cashcount = Cashcount::where('cashcount_uuid', $cashcount_uuid)->firstOrFail();
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
  }*/
}
