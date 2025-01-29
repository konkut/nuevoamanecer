<?php

namespace App\Http\Controllers;

use App\Exports\IncomeExport;
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
            $item->services = Servicewithoutprice::whereIn('servicewithoutprice_uuid', $item->servicewithoutprice_uuids)->pluck('name');
            $item->methods = Transactionmethod::whereIn('transactionmethod_uuid', $item->transactionmethod_uuids)->pluck('name');
            $names = [];
            $amounts = [];
            $commissions = [];
            foreach ($item->names as $key => $name) {
                $names[] = $name;
                $amounts[] = $item->amounts[$key] ?? null;
                $commissions[] = $item->commissions[$key] ?? null;
            }
            $item->names = $names;
            $item->amounts = number_format(array_sum($amounts), 2, '.', '');
            $item->commissions = number_format(array_sum($commissions), 2, '.', '');
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
        $transactionmethods = Transactionmethod::where("status",'1')->get();
        $servicewithoutprices = Servicewithoutprice::where("status",'1')->get();
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
            'physical_cash' => 'nullable|numeric',
            'digital_cash' => 'nullable|numeric',
            'total' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
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
        $validator->after(function ($validator) use ($request) {
            if ($request->total !== $request->charge) {
                $validator->errors()->add(
                    'transactionmethod_uuids',
                    __("Total calculado: Bs. {$request->charge}. Total ingresado: Bs. {$request->total}. Por favor, revise los datos e intente nuevamente.")
                );
            }
        });
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $cashshiftsvalidated = Cashshift::where('user_id', auth::id())->where('status', 1)->first();
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
            'physical_cash' => $request->physical_cash ?? 0,
            'digital_cash' => $request->digital_cash ?? 0,
            'total' => $request->total ?? 0,
        ]);
        Paymentwithprice::create([
            'names' => $request->names,
            'observation' => $request->observation,
            'amounts' => $request->amounts,
            'commissions' => $request->commissions,
            'servicewithoutprice_uuids' => $request->servicewithoutprice_uuids,
            'transactionmethod_uuids' => $request->transactionmethod_uuids,
            'user_id' => Auth::id(),
            'cashshift_uuid'=> $cashshiftsvalidated->cashshift_uuid,
            'denomination_uuid'=> $denomination->denomination_uuid,
        ]);
        foreach ($request->transactionmethod_uuids as $key => $transactionmethod_uuid) {
            $transactionmethod = Transactionmethod::where('transactionmethod_uuid', $transactionmethod_uuid)->first();
            if ($transactionmethod && $transactionmethod->name !== "EFECTIVO") {
                $amount = ($request->amounts[$key] + ($request->commissions[$key] ?? 0));
                $new_balance = $transactionmethod->balance + $amount;
                $transactionmethod->update([
                    'balance' => $new_balance,
                ]);
            }
        }
        return redirect("/paymentwithprices")->with('success', 'Ingreso registrado correctamente.');
    }
    public function edit(string $paymentwithprice_uuid)
    {
        $paymentwithprice = Paymentwithprice::where('paymentwithprice_uuid', $paymentwithprice_uuid)->with('denominations')->firstOrFail();
        $denomination = $paymentwithprice->denominations;
        $transactionmethods = Transactionmethod::where("status",'1')->get();
        $servicewithoutprices = Servicewithoutprice::where("status",'1')->get();
        $names = $paymentwithprice->names;
        $commissions = $paymentwithprice->commissions;
        $amounts = $paymentwithprice->amounts;
        $methods = $paymentwithprice->transactionmethod_uuids;
        $services = $paymentwithprice->servicewithoutprice_uuids;
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
            'physical_cash' => 'nullable|numeric',
            'digital_cash' => 'nullable|numeric',
            'total' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
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
        $validator->after(function ($validator) use ($request) {
            if ($request->total !== $request->charge) {
                $validator->errors()->add(
                    'transactionmethod_uuids',
                    __("Total calculado: Bs. {$request->charge}. Total ingresado: Bs. {$request->total}. Por favor, revise los datos e intente nuevamente.")
                );
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
        foreach ($request->transactionmethod_uuids as $key => $transactionmethod_uuid) {
            $transactionmethod_before = Transactionmethod::where('transactionmethod_uuid', $paymentwithprice->transactionmethod_uuids[$key])->first();
            $transactionmethod_after = Transactionmethod::where('transactionmethod_uuid', $transactionmethod_uuid)->first();
            if ($transactionmethod_before && $transactionmethod_after) {
                $price_before = ($paymentwithprice->amounts[$key] + $paymentwithprice->commissions[$key]);
                $price_after = ($request->amounts[$key] + ($request->commissions[$key] ?? 0));
                if ($transactionmethod_after->name === "EFECTIVO" || $transactionmethod_before->name === "EFECTIVO"){
                    if ($transactionmethod_before->name !== "EFECTIVO" && $transactionmethod_after->name === "EFECTIVO") {
                        $balance_fixed = $transactionmethod_before->balance - $price_before;
                        $transactionmethod_before->update([
                            'balance' => $balance_fixed,
                        ]);
                    }
                    if ($transactionmethod_before->name === "EFECTIVO" && $transactionmethod_after->name !== "EFECTIVO") {
                        $new_balance = $transactionmethod_after->balance + $price_after;
                        $transactionmethod_after->update([
                            'balance' => $new_balance,
                        ]);
                    }
                }else{
                    if ($transactionmethod_before->name == $transactionmethod_after->name) {
                        if ($price_before < $price_after) {
                            $operation = $price_after - $price_before;
                            $new_balance = $transactionmethod_after->balance + $operation;
                            $transactionmethod_after->update([
                                'balance' => $new_balance,
                            ]);
                        }
                        if ($price_before > $price_after) {
                            $operation = $price_before - $price_after;
                            $new_balance = $transactionmethod_after->balance - $operation;
                            $transactionmethod_after->update([
                                'balance' => abs($new_balance),
                            ]);
                        }
                    }else{
                        $balance_fixed = $transactionmethod_before->balance - $price_before;
                        $transactionmethod_before->update([
                            'balance' => $balance_fixed,
                        ]);
                        $new_balance = $transactionmethod_after->balance + $price_after;
                        $transactionmethod_after->update([
                            'balance' => $new_balance,
                        ]);
                    }
                }
            }
        }
        $paymentwithprice->update([
            'names' => $request->names,
            'observation' => $request->observation,
            'amounts' => $request->amounts,
            'commissions' => $request->commissions,
            'servicewithoutprice_uuids' => $request->servicewithoutprice_uuids,
            'transactionmethod_uuids' => $request->transactionmethod_uuids,
            'cashshift_uuid'=> $cashshiftsvalidated->cashshift_uuid,
            'user_id' => Auth::id(),
        ]);
        return redirect("/paymentwithprices")->with('success', 'Ingreso actualizado correctamente.');
    }
    public function destroy(string $paymentwithprice_uuid)
    {
        $paymentwithprice = Paymentwithprice::where('paymentwithprice_uuid', $paymentwithprice_uuid)->firstOrFail();
        foreach ($paymentwithprice->transactionmethod_uuids as $key => $transactionmethod_uuid) {
            $transactionmethod = Transactionmethod::where('transactionmethod_uuid', $transactionmethod_uuid)->first();
            if ($transactionmethod && $transactionmethod->name !== "EFECTIVO") {
                $amount = ($paymentwithprice->amounts[$key] + ($paymentwithprice->commissions[$key] ?? 0));
                $new_balance = $transactionmethod->balance - $amount;
                $transactionmethod->update([
                    'balance' => $new_balance,
                ]);
            }
        }
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
        $services = [];
        foreach ($paymentwithprice->servicewithoutprice_uuids as $key => $serviceUuid) {
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
        $paymentwithprice->total = number_format((array_sum($paymentwithprice->amounts) + array_sum($paymentwithprice->commissions)), 2, '.', '');
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
        $paymentwithprice->received_physical = $received->total;
        $paymentwithprice->received_digital = $paymentwithprice->denominations->digital_cash;
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
            $services = Servicewithoutprice::whereIn('servicewithoutprice_uuid', $paymentwithprice->servicewithoutprice_uuids)->pluck('name')->toArray();
            $methods = Transactionmethod::whereIn('transactionmethod_uuid', $paymentwithprice->transactionmethod_uuids)->pluck('name')->toArray();
            $paymentwithprice->format_paymentwithprice_uuids = implode(', ', $services);
            $paymentwithprice->format_names = implode(', ', $paymentwithprice->names);
            $paymentwithprice->format_amounts = implode(', ', $paymentwithprice->amounts);
            $paymentwithprice->format_commissions = implode(', ', $paymentwithprice->commissions);
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
            $paymentwithprice->format_physical_cash = $paymentwithprice->denominations->physical_cash;
            $paymentwithprice->format_digital_cash = $paymentwithprice->denominations->digital_cash;
            $paymentwithprice->format_total = $paymentwithprice->denominations->total;
        });
        return Excel::download(new IncomeExport($paymentwithprices), 'transacciones_servicios_basicos.xlsx');
    }
}
