<?php

namespace App\Http\Controllers;

use App\Models\Cashcount;
use App\Models\Denomination;
use App\Models\Denominationables;
use App\Models\Paymentwithprice;
use App\Models\Servicewithoutprice;
use App\Models\Transactionmethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentwithpriceController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $paymentwithprices = Paymentwithprice::with(['user', 'servicewithoutprice', 'transactionmethod'])->paginate($perPage);
        $denominationables = Denominationables::all();
        foreach ($paymentwithprices as $item) {
            $serviceUuids = json_decode($item->servicewithoutprice_uuids, true);
            $methodUuids = json_decode($item->transactionmethod_uuids, true);
            $item->services = Servicewithoutprice::whereIn('servicewithoutprice_uuid', $serviceUuids)->pluck('name');
            $item->methods = Transactionmethod::whereIn('transactionmethod_uuid', $methodUuids)->pluck('name');
            $aux = Denominationables::where('denominationable_uuid', $item->paymentwithprice_uuid)->first();
            $aux1 = Denomination::where('denomination_uuid', $aux->denomination_uuid)->first();
            $item->total = $aux1->total;
        }
        return view("paymentwithprice.index", compact('paymentwithprices', 'perPage', 'denominationables'));
    }

    public function create()
    {
        $paymentwithprice = new Paymentwithprice();
        $denomination = new Denomination();
        $transactionmethods = Transactionmethod::all();
        $servicewithoutprices = Servicewithoutprice::all();
        return view("paymentwithprice.create", compact('paymentwithprice', 'denomination', 'transactionmethods', 'servicewithoutprices'));
    }

    public function store(Request $request)
    {
        $rules = [
            'observation' => 'nullable|string|max:100',
            'names' => 'required|array',
            'names.*' => 'required|string|max:30',
            'amounts' => 'required|array',
            'amounts.*' => 'required|numeric|regex:/^\d{1,20}(\.\d{1,2})?$/',
            'commissions' => 'required|array',
            'commissions.*' => 'nullable|numeric|between:0,9999999999.99',
            'servicewithoutprice_uuids' => 'required|array',
            'servicewithoutprice_uuids.*' => 'required|string|max:36|exists:servicewithoutprices,servicewithoutprice_uuid',
            'transactionmethod_uuids' => 'required|array',
            'transactionmethod_uuids.*' => 'required|string|max:36|exists:transactionmethods,transactionmethod_uuid',
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
        $paymentwithprice = Paymentwithprice::create([
            'names' => json_encode($request->names),
            'observation' => $request->observation,
            'amounts' => json_encode($request->amounts),
            'commissions' => json_encode($request->commissions),
            'servicewithoutprice_uuids' => json_encode($request->servicewithoutprice_uuids),
            'transactionmethod_uuids' => json_encode($request->transactionmethod_uuids),
            'user_id' => Auth::id(),
        ]);
        $paymentwithprice->denominations()->attach($denomination->denomination_uuid);
        return redirect("/paymentwithprices")->with('success', 'Ingreso registrado correctamente.');
    }

    public function edit(string $paymentwithprice_uuid)
    {
        $paymentwithprice = Paymentwithprice::where('paymentwithprice_uuid', $paymentwithprice_uuid)->firstOrFail();
        $denominationables = Denominationables::where('denominationable_uuid', $paymentwithprice->paymentwithprice_uuid)->firstOrFail();
        $denomination = Denomination::where('denomination_uuid', $denominationables->denomination_uuid)->firstOrFail();
        $transactionmethods = Transactionmethod::all();
        $servicewithoutprices = Servicewithoutprice::all();
        $names = json_decode($paymentwithprice->names, true);
        $commissions = json_decode($paymentwithprice->commissions, true);
        $amounts = json_decode($paymentwithprice->amounts, true);
        $methods = json_decode($paymentwithprice->transactionmethod_uuids, true);
        $services = json_decode($paymentwithprice->servicewithoutprice_uuids, true);
        return view("paymentwithprice.edit", compact('paymentwithprice', 'denomination', 'transactionmethods', 'servicewithoutprices', 'services', 'methods','names','commissions','amounts'));

    }

    public function update(Request $request, string $paymentwithprice_uuid)
    {
        $paymentwithprice = Paymentwithprice::where('paymentwithprice_uuid', $paymentwithprice_uuid)->firstOrFail();
        $denominationables = Denominationables::where('denominationable_uuid', $paymentwithprice->paymentwithprice_uuid)->firstOrFail();
        $denomination = Denomination::where('denomination_uuid', $denominationables->denomination_uuid)->firstOrFail();
        $rules = [
            'observation' => 'nullable|string|max:100',
            'names' => 'required|array',
            'names.*' => 'required|string|max:30',
            'amounts' => 'required|array',
            'amounts.*' => 'required|numeric|regex:/^\d{1,20}(\.\d{1,2})?$/',
            'commissions' => 'required|array',
            'commissions.*' => 'nullable|numeric|between:0,9999999999.99',
            'servicewithoutprice_uuids' => 'required|array',
            'servicewithoutprice_uuids.*' => 'required|string|max:36|exists:servicewithoutprices,servicewithoutprice_uuid',
            'transactionmethod_uuids' => 'required|array',
            'transactionmethod_uuids.*' => 'required|string|max:36|exists:transactionmethods,transactionmethod_uuid',
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
        $paymentwithprice->update([
            'names' => json_encode($request->names),
            'observation' => $request->observation,
            'amounts' => json_encode($request->amounts),
            'commissions' => json_encode($request->commissions),
            'servicewithoutprice_uuids' => json_encode($request->servicewithoutprice_uuids),
            'transactionmethod_uuids' => json_encode($request->transactionmethod_uuids),
            'user_id' => Auth::id(),
        ]);
        return redirect("/paymentwithprices")->with('success', 'Ingreso actualizado correctamente.');
    }

    public function destroy(string $paymentwithprice_uuid)
    {
        $paymentwithprice = Paymentwithprice::where('paymentwithprice_uuid', $paymentwithprice_uuid)->firstOrFail();
        $paymentwithprice->delete();
        return redirect("/paymentwithprices")->with('success', 'Ingreso eliminado correctamente.');
    }

    public function showdetail(string $paymentwithprice_uuid)
    {
        $paymentwithprice = Paymentwithprice::where('paymentwithprice_uuid', $paymentwithprice_uuid)->firstOrFail();
        $denominationables = Denominationables::where('denominationable_uuid', $paymentwithprice->paymentwithprice_uuid)->firstOrFail();
        $denomination = Denomination::where('denomination_uuid', $denominationables->denomination_uuid)->firstOrFail();
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
