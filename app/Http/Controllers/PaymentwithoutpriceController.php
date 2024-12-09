<?php

namespace App\Http\Controllers;

use App\Models\Cashcount;
use App\Models\Denominationables;
use Illuminate\Http\Request;
use App\Models\Denomination;
use App\Models\Paymentwithoutprice;
use App\Models\Transactionmethod;
use App\Models\Servicewithprice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PaymentwithoutpriceController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $paymentwithoutprices = Paymentwithoutprice::with(['user', 'servicewithprice', 'transactionmethod'])->paginate($perPage);
        $denominationables = Denominationables::all();
        foreach ($paymentwithoutprices as $item) {
            $serviceUuids = json_decode($item->servicewithprice_uuids, true);
            $methodUuids = json_decode($item->transactionmethod_uuids, true);
            $item->services = Servicewithprice::whereIn('servicewithprice_uuid', $serviceUuids)->pluck('name');
            $aux = Denominationables::where('denominationable_uuid', $item->paymentwithoutprice_uuid)->first();
            $aux1 = Denomination::where('denomination_uuid', $aux->denomination_uuid)->first();
            $item->total = $aux1->total;
            $item->methods = Transactionmethod::whereIn('transactionmethod_uuid', $methodUuids)->pluck('name');
        }
        return view("paymentwithoutprice.index", compact('paymentwithoutprices', 'perPage', 'denominationables'));
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
        $cashcount = Cashcount::where('date', now()->toDateString())->first();
        $rules = [
            'observation' => 'nullable|string|max:100',
            'servicewithprice_uuids' => 'required|array',
            'servicewithprice_uuids.*' => 'required|string|max:36|exists:servicewithprices,servicewithprice_uuid',
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
        $paymentwithoutprice = Paymentwithoutprice::create([
            'observation' => $request->observation,
            'servicewithprice_uuids' => json_encode($request->servicewithprice_uuids),
            'transactionmethod_uuids' => json_encode($request->transactionmethod_uuids),
            'user_id' => Auth::id(),
        ]);
        $paymentwithoutprice->denominations()->attach($denomination->denomination_uuid);
        if ($cashcount && $cashcount->date == now()->toDateString()) {
            $cashcount->update([
                'closing' => ($cashcount->closing ?? 0) + ($denomination->total ?? 0),
            ]);
        }
        return redirect("/paymentwithoutprices")->with('success', 'Ingreso registrado correctamente.');
    }

    public function edit(string $paymentwithoutprice_uuid)
    {
        $paymentwithoutprice = Paymentwithoutprice::where('paymentwithoutprice_uuid', $paymentwithoutprice_uuid)->firstOrFail();
        $denominationables = Denominationables::where('denominationable_uuid', $paymentwithoutprice->paymentwithoutprice_uuid)->firstOrFail();
        $denomination = Denomination::where('denomination_uuid', $denominationables->denomination_uuid)->firstOrFail();
        $transactionmethods = Transactionmethod::all();
        $servicewithprices = Servicewithprice::all();
        $services = json_decode($paymentwithoutprice->servicewithprice_uuids, true);
        $methods = json_decode($paymentwithoutprice->transactionmethod_uuids, true);
        return view("paymentwithoutprice.edit", compact('paymentwithoutprice', 'denomination', 'transactionmethods', 'servicewithprices','services','methods'));
        }
    public function update(Request $request, string $paymentwithoutprice_uuid)
    {
        $paymentwithoutprice = Paymentwithoutprice::where('paymentwithoutprice_uuid', $paymentwithoutprice_uuid)->firstOrFail();
        $denominationables = Denominationables::where('denominationable_uuid', $paymentwithoutprice->paymentwithoutprice_uuid)->firstOrFail();
        $denomination = Denomination::where('denomination_uuid', $denominationables->denomination_uuid)->firstOrFail();
        $cashcount = Cashcount::where('date', now()->toDateString())->first();
        $rules = [
            'observation' => 'nullable|string|max:100',
            'servicewithprice_uuids' => 'required|array',
            'servicewithprice_uuids.*' => 'required|string|max:36|exists:servicewithprices,servicewithprice_uuid',
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
        if ($cashcount && $cashcount->date == now()->toDateString()) {
            $cashcount->update([
                'closing' => ($cashcount->closing ?? 0) - ($denomination->total ?? 0),
            ]);
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
            'servicewithprice_uuids' => json_encode($request->servicewithprice_uuids),
            'transactionmethod_uuids' => json_encode($request->transactionmethod_uuids),
            'user_id' => Auth::id(),
        ]);

        if ($cashcount && $cashcount->date == now()->toDateString()) {
            $cashcount->update([
                'closing' => ($cashcount->closing ?? 0) + ($denomination->total ?? 0),
            ]);
        }
        return redirect("/paymentwithoutprices")->with('success', 'Ingreso actualizado correctamente.');
    }

    public function destroy(string $paymentwithoutprice_uuid)
    {
        $paymentwithoutprice = Paymentwithoutprice::where('paymentwithoutprice_uuid', $paymentwithoutprice_uuid)->firstOrFail();
        $cashcount = Cashcount::where('date', now()->toDateString())->first();
        if ($cashcount && $cashcount->date == now()->toDateString()) {
            $cashcount->update([
                'closing' => ($cashcount->closing ?? 0) - ($denomination->total ?? 0),
            ]);
        }
        $paymentwithoutprice->delete();
        return redirect("/paymentwithoutprices")->with('success', 'Ingreso eliminado correctamente.');
    }

    public function showdetail(string $paymentwithoutprice_uuid)
    {
        $paymentwithoutprice = Paymentwithoutprice::where('paymentwithoutprice_uuid', $paymentwithoutprice_uuid)->firstOrFail();
        $denominationables = Denominationables::where('denominationable_uuid', $paymentwithoutprice->paymentwithoutprice_uuid)->firstOrFail();
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
