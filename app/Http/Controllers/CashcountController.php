<?php

namespace App\Http\Controllers;

use App\Models\Cashcount;
use App\Models\Denomination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
      $rules = [
          'opening' => 'required|numeric|regex:/^\d{1,20}(\.\d{1,2})?$/',
          'bill_200' => 'nullable|integer',
          'bill_100' => 'nullable|integer',
          'bill_50' => 'nullable|integer',
          'bill_20' => 'nullable|integer',
          'bill_10' => 'nullable|integer',
          'coin_5' => 'nullable|integer',
          'coin_2' => 'nullable|integer',
          'coin_1' => 'nullable|integer',
          'coin_0_5' => 'nullable|integer',
          'coin_0_2' => 'nullable|integer',
          'coin_0_1' => 'nullable|integer',
          'total' => 'required|numeric|regex:/^(?!0(\.0{1,2})?$)\d{1,20}(\.\d{1,2})?$/',
      ];
      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
          return redirect()->back()
              ->withErrors($validator)
              ->withInput();
      }

    $denomination = Denomination::create([
        'type'=>'opening',
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
    return redirect("/cashcounts")->with('success', 'Arqueo registrado correctamente');
  }

    public function edit(string $cashcount_uuid)
    {
        $cashcount = Cashcount::where('cashcount_uuid', $cashcount_uuid)->firstOrFail();
        $denomination = Denomination::where('denomination_uuid', $cashcount->opening_denomination_uuid)->firstOrFail();
        return view("cashcount.edit", compact('cashcount','denomination'));
    }
  public function update(Request $request, string $cashcount_uuid)
  {
      $cashcount = Cashcount::where('cashcount_uuid', $cashcount_uuid)->firstOrFail();
      $denomination = Denomination::where('denomination_uuid', $cashcount->opening_denomination_uuid)->firstOrFail();
      $rules = [
          'opening' => 'required|numeric|regex:/^\d{1,20}(\.\d{1,2})?$/',
          'bill_200' => 'nullable|integer',
          'bill_100' => 'nullable|integer',
          'bill_50' => 'nullable|integer',
          'bill_20' => 'nullable|integer',
          'bill_10' => 'nullable|integer',
          'coin_5' => 'nullable|integer',
          'coin_2' => 'nullable|integer',
          'coin_1' => 'nullable|integer',
          'coin_0_5' => 'nullable|integer',
          'coin_0_2' => 'nullable|integer',
          'coin_0_1' => 'nullable|integer',
          'total' => 'required|numeric|regex:/^(?!0(\.0{1,2})?$)\d{1,20}(\.\d{1,2})?$/',
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
      $cashcount->update([
          'opening' => $request->opening,
          'opening_denomination_uuid' => $denomination->denomination_uuid,
          'user_id' => Auth::id(),
      ]);
    return redirect("/cashcounts")->with('success', 'Arqueo actualizado correctamente');
  }
  public function destroy(string $cashcount_uuid)
  {
      $cashcount = Cashcount::where('cashcount_uuid', $cashcount_uuid)->firstOrFail();
      $cashcount->delete();
      return redirect("/cashcounts")->with('success', 'Arqueo eliminado correctamente');
  }
}
