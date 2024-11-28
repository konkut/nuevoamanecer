<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{

  public function index(Request $request)
  {
    $perPage = $request->input('perPage', 10);
    $currencies = Currency::paginate($perPage);
    return view("currency.index", compact('currencies','perPage'));
  }
  public function create()
  {
    $currency = new Currency();
    return view("currency.create", compact('currency'));
  }
  public function store(Request $request)
  {
    $rules = [
      'name' => [
        'required',
        'unique:currencies,name',
        'string',
        'max:30',
        'regex:/^[a-zA-Z\s]+$/',
      ],
      'symbol' => [
        'nullable',
        'string',
        'max:10',
      ],
      'exchange_rate' => [
        'nullable',
        'numeric',
        'regex:/^\d{1,10}(\.\d{1,2})?$/',
      ]
    ];
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator)
        ->withInput();
    }
    Currency::create([
      'name' => $request->name,
      'symbol' => $request->symbol,
      'exchange_rate' => $request->exchange_rate,
    ]);
    return redirect("/currencies")->with('success', 'Moneda registrada correctamente.');
  }
  public function show($currency_uuid, Request $request)
  {
    $currency = Currency::where('currency_uuid', $currency_uuid)->firstOrFail();
    return view('currency.show', compact('currency'));
  }
  public function edit(string $currency_uuid)
  {
    $currency = Currency::where('currency_uuid', $currency_uuid)->firstOrFail();
    return view("currency.edit", compact('currency'));
  }

  public function update(Request $request, string $currency_uuid)
  {
    // Encuentra el registro de moneda actual por su slug
    $currency = Currency::where('currency_uuid', $currency_uuid)->firstOrFail();

    // Reglas de validación
    $rules = [
      'name' => [
        'required',
        'string',
        'max:30',
        'regex:/^[a-zA-Z\s]+$/',
        'unique:currencies,name,' . $currency->currency_uuid . ',currency_uuid',
      ],
      'symbol' => [
        'nullable',
        'string',
        'max:10',
      ],
      'exchange_rate' => [
        'nullable',
        'numeric',
        'regex:/^\d{1,10}(\.\d{1,2})?$/',
      ],
      'status' => [
        'required',
        'integer',
      ]
    ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator)
        ->withInput();
    }

    $currency->update([
      'name' => $request->name,
      'symbol' => $request->symbol,
      'exchange_rate' => $request->exchange_rate,
      'status' => $request->status,
    ]);

    return redirect("/currencies")->with('success', 'Moneda actualizada correctamente.');
  }

  public function destroy(string $currency_uuid)
  {
    $currency = Currency::where('currency_uuid', $currency_uuid)->firstOrFail();
    $currency->delete();
    return redirect("/currencies")->with('success', 'Moneda eliminada correctamente.');
  }
}
