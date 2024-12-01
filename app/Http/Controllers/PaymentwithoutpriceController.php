<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Denomination;
use App\Models\Paymentwithoutprice;
use App\Models\Transactionmethod;
use App\Models\Servicewithprice;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PaymentwithoutpriceController extends Controller
{
    public function index(Request $request)
    {
        $denomination = new Denomination();
        $perPage = $request->input('perPage', 10);
        $paymentwithoutprices = Paymentwithoutprice::with(['user', 'denomination', 'servicewithprice', 'transactionmethod'])->paginate($perPage);
        return view("paymentwithoutprice.index", compact('paymentwithoutprices', 'perPage', 'denomination'));
    }

    public function create()
    {
        $paymentwithoutprice = new Paymentwithoutprice();
        $denomination = new Denomination();
        $transactionmethods = Transactionmethod::all();
        $servicewithprices = Servicewithprice::all();
        return view("paymentwithoutprice.create", compact('paymentwithoutprice', 'denomination', 'transactionmethods', 'servicewithprices'));
    }

    public function store(Request $request)
    {
        $rules = [
            'observation' => 'nullable|string|max:100',
            'servicewithprice_uuid' => 'required|string|max:36|exists:servicewithprices,servicewithprice_uuid',
            'transactionmethod_uuid' => 'required|string|max:36|exists:transactionmethods,transactionmethod_uuid',
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

        Paymentwithoutprice::create([
            'observation' => $request->observation,
            'servicewithprice_uuid' => $request->servicewithprice_uuid,
            'transactionmethod_uuid' => $request->transactionmethod_uuid,
            'denomination_uuid' => $denomination->denomination_uuid,
            'user_id' => Auth::id(),
        ]);
        return redirect("/paymentwithoutprices")->with('success', 'Ingreso registrado correctamente.');
    }

    public function edit(string $paymentwithoutprice_uuid)
    {
        $paymentwithoutprice = Paymentwithoutprice::where('paymentwithoutprice_uuid', $paymentwithoutprice_uuid)->firstOrFail();
        $denomination = Denomination::where('denomination_uuid', $paymentwithoutprice->denomination_uuid)->firstOrFail();
        $transactionmethods = Transactionmethod::all();
        $servicewithprices = Servicewithprice::all();
        return view("paymentwithoutprice.edit", compact('paymentwithoutprice', 'denomination', 'transactionmethods', 'servicewithprices'));
    }

    public function update(Request $request, string $paymentwithoutprice_uuid)
    {
        $paymentwithoutprice = Paymentwithoutprice::where('paymentwithoutprice_uuid', $paymentwithoutprice_uuid)->firstOrFail();
        $denomination = Denomination::where('denomination_uuid', $paymentwithoutprice->denomination_uuid)->firstOrFail();

        $rules = [
            'observation' => 'nullable|string|max:100',
            'servicewithprice_uuid' => 'required|string|max:36|exists:servicewithprices,servicewithprice_uuid',
            'transactionmethod_uuid' => 'required|string|max:36|exists:transactionmethods,transactionmethod_uuid',
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

        $paymentwithoutprice->update([
            'observation' => $request->observation,
            'servicewithprice_uuid' => $request->servicewithprice_uuid,
            'transactionmethod_uuid' => $request->transactionmethod_uuid,
            'user_id' => Auth::id(),
        ]);
        return redirect("/paymentwithoutprices")->with('success', 'Ingreso actualizado correctamente.');
    }

    public function destroy(string $paymentwithoutprice_uuid)
    {
        $paymentwithoutprice = Paymentwithoutprice::where('paymentwithoutprice_uuid', $paymentwithoutprice_uuid)->firstOrFail();
        $paymentwithoutprice->delete();
        return redirect("/paymentwithoutprices")->with('success', 'Ingreso eliminado correctamente.');
    }

    public function showdetail(string $paymentwithoutprice_uuid)
    {
        $paymentwithoutprice = Paymentwithoutprice::where('paymentwithoutprice_uuid', $paymentwithoutprice_uuid)->firstOrFail();
        $denomination = Denomination::where('denomination_uuid', $paymentwithoutprice->denomination_uuid)->firstOrFail();
        return response()->json([
            'bill_200' => $denomination->bill_200,
            'bill_100' => $denomination->bill_100,
            'bill_50' => $denomination->bill_50,
            'bill_20' => $denomination->bill_20,
            'bill_10' => $denomination->bill_10,
            'coin_5' => $denomination->coin_5,
            'coin_2' => $denomination->coin_2,
            'coin_1' => $denomination->coin_1,
            'coin_0_5' => $denomination->coin_0_5,
            'coin_0_2' => $denomination->coin_0_2,
            'coin_0_1' => $denomination->coin_0_1,
            'total' => $denomination->total,
        ]);
    }
}
