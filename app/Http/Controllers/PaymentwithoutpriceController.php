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
            $item->services = Servicewithprice::whereIn('servicewithprice_uuid', $item->servicewithprice_uuids)->pluck('name');
            $item->methods = Transactionmethod::whereIn('transactionmethod_uuid', $item->transactionmethod_uuids)->pluck('name');
            $prices = [];
            $amounts = [];
            $commissions = [];
            foreach ($item->servicewithprice_uuids  as $key => $serviceUuid) {
                $service = Servicewithprice::where('servicewithprice_uuid', $serviceUuid)->first();
                if ($service) {
                    $prices[] = ($service->amount+$service->commission)*$item->quantities[$key];
                    $amounts[] = $service->amount * $item->quantities[$key];;
                    $commissions[] = $service->commission * $item->quantities[$key];;
                }
            }
            $item->amounts = number_format(array_sum($amounts), 2, '.', '');
            $item->commissions = number_format(array_sum($commissions), 2, '.', '');
            $item->total_price = number_format(array_sum($prices), 2, '.', '');
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
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:1',
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
            'physical_cash' => 'nullable|numeric',
            'digital_cash' => 'nullable|numeric',
            'total' => 'required|numeric|regex:/^(?!0(\.0{1,2})?$)\d{1,20}(\.\d{1,2})?$/',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->after(function ($validator) use ($request) {
            $quantityCount = count($request->input('quantities', []));
            $serviceCount = count($request->input('servicewithprice_uuids', []));
            $transactionCount = count($request->input('transactionmethod_uuids', []));
            if ($serviceCount !== $transactionCount) {
                $validator->errors()->add('transactionmethod_uuids', __('validation.custom_paymentwithoutprice'));
            }
            if ($serviceCount !== $quantityCount) {
                $validator->errors()->add('transactionmethod_uuids', __('validation.custom_paymentwithoutprice'));
            }
            if ($transactionCount !== $quantityCount) {
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
            'physical_cash' => $request->physical_cash ?? 0,
            'digital_cash' => $request->digital_cash ?? 0,
            'total' => $request->total ?? 0,
        ]);
        Paymentwithoutprice::create([
            'observation' => $request->observation,
            'quantities' => $request->quantities,
            'servicewithprice_uuids' => $request->servicewithprice_uuids,
            'transactionmethod_uuids' => $request->transactionmethod_uuids,
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
        $quantities = $paymentwithoutprice->quantities;
        $services = $paymentwithoutprice->servicewithprice_uuids;
        $methods = $paymentwithoutprice->transactionmethod_uuids;
        return view("paymentwithoutprice.edit", compact('paymentwithoutprice', 'denomination', 'transactionmethods', 'servicewithprices', 'services', 'methods','quantities'));
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
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:1',
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
            'physical_cash' => 'nullable|numeric',
            'digital_cash' => 'nullable|numeric',
            'total' => 'required|numeric|regex:/^(?!0(\.0{1,2})?$)\d{1,20}(\.\d{1,2})?$/',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->after(function ($validator) use ($request) {
            $quantityCount = count($request->input('quantities', []));
            $serviceCount = count($request->input('servicewithprice_uuids', []));
            $transactionCount = count($request->input('transactionmethod_uuids', []));
            if ($serviceCount !== $transactionCount) {
                $validator->errors()->add('transactionmethod_uuids', __('validation.custom_paymentwithoutprice'));
            }
            if ($serviceCount !== $quantityCount) {
                $validator->errors()->add('transactionmethod_uuids', __('validation.custom_paymentwithoutprice'));
            }
            if ($transactionCount !== $quantityCount) {
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
            'physical_cash' => $request->physical_cash ?? 0,
            'digital_cash' => $request->digital_cash ?? 0,
            'total' => $request->total ?? 0,
        ]);
        $paymentwithoutprice->update([
            'observation' => $request->observation,
            'quantities' => $request->quantities,
            'servicewithprice_uuids' => $request->servicewithprice_uuids,
            'transactionmethod_uuids' => $request->transactionmethod_uuids,
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
        $services = [];
        $amounts = [];
        $commissions = [];
        foreach ($paymentwithoutprice->servicewithprice_uuids as $serviceUuid) {
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
        $paymentwithoutprice->received_physical = $received->total;
        $paymentwithoutprice->received_digital = $paymentwithoutprice->denominations->digital_cash;
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
            $services = Servicewithprice::whereIn('servicewithprice_uuid', $paymentwithoutprice->servicewithprice_uuids)->pluck('name')->toArray();
            $amounts = Servicewithprice::whereIn('servicewithprice_uuid', $paymentwithoutprice->servicewithprice_uuids)->pluck('amount')->toArray();
            $commissions = Servicewithprice::whereIn('servicewithprice_uuid', $paymentwithoutprice->servicewithprice_uuids)->pluck('commission')->toArray();
            $methods = Transactionmethod::whereIn('transactionmethod_uuid', $paymentwithoutprice->transactionmethod_uuids)->pluck('name')->toArray();
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
            $paymentwithoutprice->format_physical_cash = $paymentwithoutprice->denominations->physical_cash;
            $paymentwithoutprice->format_digital_cash = $paymentwithoutprice->denominations->digital_cash;
            $paymentwithoutprice->format_total = $paymentwithoutprice->denominations->total;
        });
        return Excel::download(new PaymentwithoutpriceExport($paymentwithoutprices), 'transacciones.xlsx');
    }

}
