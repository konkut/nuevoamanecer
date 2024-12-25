<?php

namespace App\Http\Controllers;

use App\Exports\PaymentwithoutpriceExport;
use App\Models\Cashcount;
use App\Models\Cashshift;
use App\Models\Denominationables;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Denomination;
use App\Models\Paymentwithoutprice;
use App\Models\Transactionmethod;
use App\Models\Servicewithprice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class PaymentwithoutpriceController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $paymentwithoutprices = Paymentwithoutprice::with(['user', 'servicewithprice', 'transactionmethod', 'denominations'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        foreach ($paymentwithoutprices as $item) {
            $serviceUuids = json_decode($item->servicewithprice_uuids, true);
            $methodUuids = json_decode($item->transactionmethod_uuids, true);
            $item->services = Servicewithprice::whereIn('servicewithprice_uuid', $serviceUuids)->pluck('name');
            $item->methods = Transactionmethod::whereIn('transactionmethod_uuid', $methodUuids)->pluck('name');
            $amounts = [];
            $commissions = [];
            foreach ($serviceUuids as $serviceUuid) {
                $service = Servicewithprice::where('servicewithprice_uuid', $serviceUuid)->first();
                if ($service) {
                    $amounts[] = $service->amount;
                    $commissions[] = $service->commission;
                }
            }
            $item->amounts = number_format(array_sum($amounts), 2, '.', '');
            $item->commissions = number_format(array_sum($commissions), 2, '.', '');
            $item->total_price = number_format((array_sum($amounts) + array_sum($commissions)), 2, '.', '');
            $item->total_billcoin = $item->denominations->total;
        }
        $cashshiftsvalidated = Cashshift::where('user_id', auth::id())->where('status', 1)->first();
        return view("paymentwithoutprice.index", compact('paymentwithoutprices', 'cashshiftsvalidated', 'perPage'));
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
        $validator->after(function ($validator) use ($request) {
            $serviceCount = count($request->input('servicewithprice_uuids', []));
            $transactionCount = count($request->input('transactionmethod_uuids', []));
            if ($serviceCount !== $transactionCount) {
                $validator->errors()->add('transactionmethod_uuids', __('validation.custom_paymentwithoutprice'));
            }
        });
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $cashshiftsvalidated = Cashshift::where('user_id', auth::id())->where('status', 1)->first();
        $denomination = Denomination::create([
            'type' => 1,
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
            'servicewithprice_uuids' => json_encode($request->servicewithprice_uuids),
            'transactionmethod_uuids' => json_encode($request->transactionmethod_uuids),
            'user_id' => Auth::id(),
            'cashshift_uuid' => $cashshiftsvalidated->cashshift_uuid,
            'denomination_uuid' => $denomination->denomination_uuid,
        ]);
        return redirect("/paymentwithoutprices")->with('success', 'Ingreso registrado correctamente.');
    }

    public function edit(string $paymentwithoutprice_uuid)
    {
        $paymentwithoutprice = Paymentwithoutprice::where('paymentwithoutprice_uuid', $paymentwithoutprice_uuid)->with('denominations')->firstOrFail();
        $denomination = $paymentwithoutprice->denominations;
        $transactionmethods = Transactionmethod::all();
        $servicewithprices = Servicewithprice::all();
        $services = json_decode($paymentwithoutprice->servicewithprice_uuids, true);
        $methods = json_decode($paymentwithoutprice->transactionmethod_uuids, true);
        return view("paymentwithoutprice.edit", compact('paymentwithoutprice', 'denomination', 'transactionmethods', 'servicewithprices', 'services', 'methods'));
    }

    public function update(Request $request, string $paymentwithoutprice_uuid)
    {
        $paymentwithoutprice = Paymentwithoutprice::where('paymentwithoutprice_uuid', $paymentwithoutprice_uuid)->with('denominations')->firstOrFail();
        $denomination = $paymentwithoutprice->denominations;
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
        $validator->after(function ($validator) use ($request) {
            $serviceCount = count($request->input('servicewithprice_uuids', []));
            $transactionCount = count($request->input('transactionmethod_uuids', []));
            if ($serviceCount !== $transactionCount) {
                $validator->errors()->add('transactionmethod_uuids', __('validation.custom_paymentwithoutprice'));
            }
        });
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $cashshiftsvalidated = Cashshift::where('user_id', auth::id())->where('status', 1)->first();
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
            'cashshift_uuid' => $cashshiftsvalidated->cashshift_uuid,
        ]);
        return redirect("/paymentwithoutprices")->with('success', 'Ingreso actualizado correctamente.');
    }

    public function destroy(string $paymentwithoutprice_uuid)
    {
        $paymentwithoutprice = Paymentwithoutprice::where('paymentwithoutprice_uuid', $paymentwithoutprice_uuid)->firstOrFail();
        $paymentwithoutprice->delete();
        return redirect("/paymentwithoutprices")->with('success', 'Ingreso eliminado correctamente.');
    }

    public function detail(string $paymentwithoutprice_uuid)
    {
        $paymentwithoutprice = Paymentwithoutprice::where('paymentwithoutprice_uuid', $paymentwithoutprice_uuid)->with('denominations')->firstOrFail();
        $denomination = $paymentwithoutprice->denominations;
        return response()->json([
            'denomination' => $denomination,
        ]);
    }

    public function tax(string $paymentwithoutprice_uuid)
    {
        $paymentwithoutprice = Paymentwithoutprice::with(['user', 'servicewithprice', 'transactionmethod', 'denominations'])
            ->where('paymentwithoutprice_uuid', $paymentwithoutprice_uuid)
            ->firstOrFail();
        $serviceUuids = json_decode($paymentwithoutprice->servicewithprice_uuids, true);
        $services = [];
        $amounts = [];
        $commissions = [];
        foreach ($serviceUuids as $serviceUuid) {
            $service = Servicewithprice::where('servicewithprice_uuid', $serviceUuid)->first();
            if ($service) {
                $services[] = $service->name;
                $amounts[] = $service->amount;
                $commissions[] = $service->commission;
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
        $paymentwithoutprice->name = rtrim($names, ', ');
        $paymentwithoutprice->total = number_format((array_sum($amounts) + array_sum($commissions)), 2, '.', '');
        $denomination_uuid = $paymentwithoutprice->denominations->denomination_uuid;
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
        $paymentwithoutprice->received = $received->total;
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
        ) AS total')->firstorfail();
        $paymentwithoutprice->returned = $returned->total;
        $methodUuids = json_decode($paymentwithoutprice->transactionmethod_uuids, true);
        $paymentwithoutprice->methods = Transactionmethod::whereIn('transactionmethod_uuid', $methodUuids)->pluck('name');
        $data = [
            'paymentwithoutprice' => $paymentwithoutprice
        ];
        $pdf = Pdf::loadView('paymentwithoutprice.tax', $data)
            ->setPaper([0, 0, 306, 396]); // Tamaño en puntos (1 pulgada = 72 puntos)
        return response()->stream(function () use ($pdf) {
            echo $pdf->output();
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="factura.pdf"'
        ]);
    }

    public function export()
    {
        $paymentwithoutprices = Paymentwithoutprice::where('user_id', Auth::id())->get();
        $paymentwithoutprices->each(function ($paymentwithoutprice) {
            $serviceUuids = json_decode($paymentwithoutprice->servicewithprice_uuids, true);
            $methodUuids = json_decode($paymentwithoutprice->transactionmethod_uuids, true);
            $services = Servicewithprice::whereIn('servicewithprice_uuid', $serviceUuids)->pluck('name')->toArray();
            $amounts = Servicewithprice::whereIn('servicewithprice_uuid', $serviceUuids)->pluck('amount')->toArray();
            $commissions = Servicewithprice::whereIn('servicewithprice_uuid', $serviceUuids)->pluck('commission')->toArray();
            $methods = Transactionmethod::whereIn('transactionmethod_uuid', $methodUuids)->pluck('name')->toArray();
            $paymentwithoutprice->format_paymentwithoutprice_uuids = implode(', ', $services);
            $paymentwithoutprice->format_amounts = implode(', ', $amounts);
            $paymentwithoutprice->format_commissions = implode(', ', $commissions);
            $paymentwithoutprice->format_servicewithprice_uuids = implode(', ', $methods);
            $paymentwithoutprice->format_user_id = $paymentwithoutprice->user->name;
            $paymentwithoutprice->format_created_at = $paymentwithoutprice->created_at->format('d-m-Y H:i:s');
            $paymentwithoutprice->format_updated_at = $paymentwithoutprice->updated_at->format('d-m-Y H:i:s');
            $paymentwithoutprice->format_bill_200 = $paymentwithoutprice->denominations->bill_200;
            $paymentwithoutprice->format_bill_100 = $paymentwithoutprice->denominations->bill_100;
            $paymentwithoutprice->format_bill_50 = $paymentwithoutprice->denominations->bill_50;
            $paymentwithoutprice->format_bill_20 = $paymentwithoutprice->denominations->bill_20;
            $paymentwithoutprice->format_bill_10 = $paymentwithoutprice->denominations->bill_10;
            $paymentwithoutprice->format_coin_5 = $paymentwithoutprice->denominations->coin_5;
            $paymentwithoutprice->format_coin_2 = $paymentwithoutprice->denominations->coin_2;
            $paymentwithoutprice->format_coin_1 = $paymentwithoutprice->denominations->coin_1;
            $paymentwithoutprice->format_coin_0_5 = $paymentwithoutprice->denominations->coin_0_5;
            $paymentwithoutprice->format_coin_0_2 = $paymentwithoutprice->denominations->coin_0_2;
            $paymentwithoutprice->format_coin_0_1 = $paymentwithoutprice->denominations->coin_0_1;
            $paymentwithoutprice->format_total = $paymentwithoutprice->denominations->total;
        });
        return Excel::download(new PaymentwithoutpriceExport($paymentwithoutprices), 'transacciones.xlsx');
    }

}
