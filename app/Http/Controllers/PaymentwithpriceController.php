<?php

namespace App\Http\Controllers;

use App\Exports\PaymentwithpriceExport;
use App\Models\Cashcount;
use App\Models\Cashshift;
use App\Models\Denomination;
use App\Models\Denominationables;
use App\Models\Paymentwithoutprice;
use App\Models\Paymentwithprice;
use App\Models\Servicewithoutprice;
use App\Models\Servicewithprice;
use App\Models\Transactionmethod;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class PaymentwithpriceController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $paymentwithprices = Paymentwithprice::with(['user', 'servicewithoutprice', 'transactionmethod','denominations'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        foreach ($paymentwithprices as $item) {
            $serviceUuids = json_decode($item->servicewithoutprice_uuids, true);
            $methodUuids = json_decode($item->transactionmethod_uuids, true);
            $names = json_decode($item->names, true);
            $amounts = json_decode($item->amounts, true);
            $commissions = json_decode($item->commissions, true);
            $item->services = Servicewithoutprice::whereIn('servicewithoutprice_uuid', $serviceUuids)->pluck('name');
            $item->methods = Transactionmethod::whereIn('transactionmethod_uuid', $methodUuids)->pluck('name');
            $resultNames = [];
            $resultAmounts = [];
            $resultCommissions = [];
            foreach ($names as $key => $name) {
                $resultNames[] = $name;
                $resultAmounts[] = $amounts[$key] ?? null;
                $resultCommissions[] = $commissions[$key] ?? null;
            }
            $item->names = $resultNames;
            $item->amounts = number_format(array_sum($resultAmounts), 2, '.', '');
            $item->commissions = number_format(array_sum($resultCommissions), 2, '.', '');
            $item->total_price = number_format((array_sum($amounts) + array_sum($commissions)), 2, '.', '');
            $item->total_billcoin = $item->denominations->total;
        }
        $cashshiftsvalidated = Cashshift::where('user_id', auth::id())->where('status', 1)->first();
        return view("paymentwithprice.index", compact('paymentwithprices', 'cashshiftsvalidated','perPage'));
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
        $validator->after(function ($validator) use ($request) {
            $nameCount = count($request->input('names', []));
            $amountCount = count($request->input('amounts', []));
            $serviceCount = count($request->input('servicewithoutprice_uuids', []));
            $transactionCount = count($request->input('transactionmethod_uuids', []));
            if ($amountCount !== $nameCount ||
                $serviceCount !== $nameCount ||
                $serviceCount !== $amountCount ||
                $transactionCount !== $nameCount ||
                $transactionCount !== $amountCount ||
                $transactionCount !== $serviceCount){
                $validator->errors()->add('transactionmethod_uuids', __('validation.custom_paymentwithprice'));
            }
        });
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $cashshiftsvalidated = Cashshift::where('user_id', auth::id())->where('status', 1)->first();
        $amounts = array_map(fn($amount) => number_format((float) $amount, 2, '.', ''), $request->amounts ?? []);
        $commissions = array_map(fn($commission) => number_format((float) $commission, 2, '.', ''), $request->commissions ?? []);
        $denomination = Denomination::create([
            'type'=>1,
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
        Paymentwithprice::create([
            'names' => json_encode($request->names),
            'observation' => $request->observation,
            'amounts' => json_encode($amounts),
            'commissions' => json_encode($commissions),
            'servicewithoutprice_uuids' => json_encode($request->servicewithoutprice_uuids),
            'transactionmethod_uuids' => json_encode($request->transactionmethod_uuids),
            'user_id' => Auth::id(),
            'cashshift_uuid'=> $cashshiftsvalidated->cashshift_uuid,
            'denomination_uuid'=> $denomination->denomination_uuid,
        ]);
        return redirect("/paymentwithprices")->with('success', 'Ingreso registrado correctamente.');
    }
    public function edit(string $paymentwithprice_uuid)
    {
        $paymentwithprice = Paymentwithprice::where('paymentwithprice_uuid', $paymentwithprice_uuid)->with('denominations')->firstOrFail();
        $denomination = $paymentwithprice->denominations;
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
        $paymentwithprice = Paymentwithprice::where('paymentwithprice_uuid', $paymentwithprice_uuid)->with('denominations')->firstOrFail();
        $denomination = $paymentwithprice->denominations;
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
        $validator->after(function ($validator) use ($request) {
            $nameCount = count($request->input('names', []));
            $amountCount = count($request->input('amounts', []));
            $serviceCount = count($request->input('servicewithoutprice_uuids', []));
            $transactionCount = count($request->input('transactionmethod_uuids', []));
            if ($amountCount !== $nameCount ||
                $serviceCount !== $nameCount ||
                $serviceCount !== $amountCount ||
                $transactionCount !== $nameCount ||
                $transactionCount !== $amountCount ||
                $transactionCount !== $serviceCount){
                $validator->errors()->add('transactionmethod_uuids', __('validation.custom_paymentwithprice'));
            }
        });
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $cashshiftsvalidated = Cashshift::where('user_id', auth::id())->where('status', 1)->first();
        $amounts = array_map(fn($amount) => number_format((float) $amount, 2, '.', ''), $request->amounts ?? []);
        $commissions = array_map(fn($commission) => number_format((float) $commission, 2, '.', ''), $request->commissions ?? []);
        $paymentwithprice->update([
            'names' => json_encode($request->names),
            'observation' => $request->observation,
            'amounts' => json_encode($amounts),
            'commissions' => json_encode($commissions),
            'servicewithoutprice_uuids' => json_encode($request->servicewithoutprice_uuids),
            'transactionmethod_uuids' => json_encode($request->transactionmethod_uuids),
            'user_id' => Auth::id(),
            'cashshift_uuid'=> $cashshiftsvalidated->cashshift_uuid,
        ]);
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
        return redirect("/paymentwithprices")->with('success', 'Ingreso actualizado correctamente.');
    }
    public function destroy(string $paymentwithprice_uuid)
    {
        $paymentwithprice = Paymentwithprice::where('paymentwithprice_uuid', $paymentwithprice_uuid)->firstOrFail();
        $paymentwithprice->delete();
        return redirect("/paymentwithprices")->with('success', 'Ingreso eliminado correctamente.');
    }
    public function detail(string $paymentwithprice_uuid)
    {
        $paymentwithprice = Paymentwithprice::where('paymentwithprice_uuid', $paymentwithprice_uuid)->with('denominations')->firstOrFail();
        $denomination = $paymentwithprice->denominations;
        return response()->json([
            'denomination' => $denomination,
        ]);
    }
    public function tax(string $paymentwithprice_uuid)
    {
        $paymentwithprice = Paymentwithprice::with(['user', 'servicewithoutprice', 'transactionmethod','denominations'])
            ->where('paymentwithprice_uuid', $paymentwithprice_uuid)
            ->firstOrFail();
        $serviceUuids = json_decode($paymentwithprice->servicewithoutprice_uuids, true);
        $amounts = json_decode($paymentwithprice->amounts, true);
        $commissions = json_decode($paymentwithprice->commissions, true);
        $services = [];
        foreach ($serviceUuids as $key => $serviceUuid) {
            $service = Servicewithoutprice::where('servicewithoutprice_uuid', $serviceUuid)->first();
            if ($service) {
                $services[] = $service->name;
            }
        }
        $serviceCount = [];
        foreach ($services as $service) {
            if (isset($serviceCount[$service])) {
                $serviceCount[$service]['cantidad']++;
            } else {
                $serviceCount[$service] = ['cantidad' => 1, 'servicio' => $service];
            }
        }
        $names = '';
        foreach ($serviceCount as $item) {
            $names .= $item['cantidad'] . ' ' . $item['servicio'] . ', ';
        }
        $paymentwithprice->name = rtrim($names, ', ');
        $paymentwithprice->total = number_format((array_sum($amounts) + array_sum($commissions)), 2, '.', '');
        $denomination_uuid = $paymentwithprice->denominations->denomination_uuid;
        $received = Denomination::where('denomination_uuid', $denomination_uuid)
            ->selectRaw(' SUM(
            CASE WHEN bill_200 > 0 THEN bill_200 * 200 ELSE 0.00 END +
            CASE WHEN bill_100 > 0 THEN bill_100 * 100 ELSE 0.00 END +
            CASE WHEN bill_50 > 0 THEN bill_50 * 50 ELSE 0.00 END +
            CASE WHEN bill_20 > 0 THEN bill_20 * 20 ELSE 0.00 END +
            CASE WHEN bill_10 > 0 THEN bill_10 * 10 ELSE 0.00 END +
            CASE WHEN coin_5 > 0 THEN coin_5 * 5 ELSE 0.00 END +
            CASE WHEN coin_2 > 0 THEN coin_2 * 2 ELSE 0.00 END +
            CASE WHEN coin_1 > 0 THEN coin_1 * 1 ELSE 0.00 END +
            CASE WHEN coin_0_5 > 0 THEN coin_0_5 * 0.5 ELSE 0.00 END +
            CASE WHEN coin_0_2 > 0 THEN coin_0_2 * 0.2 ELSE 0.00 END +
            CASE WHEN coin_0_1 > 0 THEN coin_0_1 * 0.1 ELSE 0.00 END
        ) AS total')->firstorfail();
        $paymentwithprice->received = $received->total;
        $returned = Denomination::where('denomination_uuid', $denomination_uuid)
            ->selectRaw('SUM(
            CASE WHEN bill_200 < 0 THEN bill_200 * 200 ELSE 0.00 END +
            CASE WHEN bill_100 < 0 THEN bill_100 * 100 ELSE 0.00 END +
            CASE WHEN bill_50 < 0 THEN bill_50 * 50 ELSE 0.00 END +
            CASE WHEN bill_20 < 0 THEN bill_20 * 20 ELSE 0.00 END +
            CASE WHEN bill_10 < 0 THEN bill_10 * 10 ELSE 0.00 END +
            CASE WHEN coin_5 < 0 THEN coin_5 * 5 ELSE 0.00 END +
            CASE WHEN coin_2 < 0 THEN coin_2 * 2 ELSE 0.00 END +
            CASE WHEN coin_1 < 0 THEN coin_1 * 1 ELSE 0.00 END +
            CASE WHEN coin_0_5 < 0 THEN coin_0_5 * 0.5 ELSE 0.00 END +
            CASE WHEN coin_0_2 < 0 THEN coin_0_2 * 0.2 ELSE 0.00 END +
            CASE WHEN coin_0_1 < 0 THEN coin_0_1 * 0.1 ELSE 0.00 END
        ) AS total')->first();
        $paymentwithprice->returned = $returned->total;
        $methodUuids = json_decode($paymentwithprice->transactionmethod_uuids, true);
        $paymentwithprice->methods = Transactionmethod::whereIn('transactionmethod_uuid', $methodUuids)->pluck('name');
        $data = [
            'paymentwithprice'=>$paymentwithprice
        ];
        $pdf = Pdf::loadView('paymentwithprice.tax', $data)
            ->setPaper([0, 0, 306, 396]); // Tamaño en puntos (1 pulgada = 72 puntos)
        return response()->stream(function () use ($pdf) {
            echo $pdf->output();
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="factura.pdf"'
        ]);
    }

    public function export(){
        $paymentwithprices = Paymentwithprice::where('user_id',Auth::id())->get();
        $paymentwithprices->each(function ($paymentwithprice) {
            $serviceUuids = json_decode($paymentwithprice->servicewithoutprice_uuids, true);
            $methodUuids = json_decode($paymentwithprice->transactionmethod_uuids, true);
            $services = Servicewithoutprice::whereIn('servicewithoutprice_uuid', $serviceUuids)->pluck('name')->toArray();
            $methods = Transactionmethod::whereIn('transactionmethod_uuid', $methodUuids)->pluck('name')->toArray();
            $names = json_decode($paymentwithprice->names, true);
            $amounts = json_decode($paymentwithprice->amounts, true);
            $commissions = json_decode($paymentwithprice->commissions, true);
            $paymentwithprice->format_paymentwithprice_uuids = implode(', ', $services);
            $paymentwithprice->format_names = implode(', ', $names);
            $paymentwithprice->format_amounts = implode(', ', $amounts);
            $paymentwithprice->format_commissions = implode(', ', $commissions);
            $paymentwithprice->format_servicewithoutprice_uuids = implode(', ', $methods);
            $paymentwithprice->format_user_id = $paymentwithprice->user->name;
            $paymentwithprice->format_created_at = $paymentwithprice->created_at->format('d-m-Y H:i:s');
            $paymentwithprice->format_updated_at = $paymentwithprice->updated_at->format('d-m-Y H:i:s');
            $paymentwithprice->format_bill_200 = $paymentwithprice->denominations->bill_200;
            $paymentwithprice->format_bill_100 = $paymentwithprice->denominations->bill_100;
            $paymentwithprice->format_bill_50 = $paymentwithprice->denominations->bill_50;
            $paymentwithprice->format_bill_20 = $paymentwithprice->denominations->bill_20;
            $paymentwithprice->format_bill_10 = $paymentwithprice->denominations->bill_10;
            $paymentwithprice->format_coin_5 = $paymentwithprice->denominations->coin_5;
            $paymentwithprice->format_coin_2 = $paymentwithprice->denominations->coin_2;
            $paymentwithprice->format_coin_1 = $paymentwithprice->denominations->coin_1;
            $paymentwithprice->format_coin_0_5 = $paymentwithprice->denominations->coin_0_5;
            $paymentwithprice->format_coin_0_2 = $paymentwithprice->denominations->coin_0_2;
            $paymentwithprice->format_coin_0_1 = $paymentwithprice->denominations->coin_0_1;
            $paymentwithprice->format_total = $paymentwithprice->denominations->total;
        });
        return Excel::download(new PaymentwithpriceExport($paymentwithprices), 'transacciones_servicios_basicos.xlsx');
    }
}
