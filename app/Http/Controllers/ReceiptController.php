<?php

namespace App\Http\Controllers;

use App\Models\Cashshift;
use App\Models\Denomination;
use App\Models\Income;
use App\Models\Receipt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReceiptController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $receipts = Receipt::with(['income'])->orderBy('created_at', 'desc')->paginate($perPage);
        $receipts->each(function ($receipt) {
            $services = $receipt->income->services->pluck('name')->toArray();
            $cashregisters = $receipt->income->cashregisters()->wherePivot('type', "2")->pluck('name')->toArray();
            $bankregisters = $receipt->income->bankregisters()->wherePivot('type', "2")->pluck('name')->toArray();
            $platforms = $receipt->income->platforms()->wherePivot('type', "2")->pluck('name')->toArray();
            $names = array_merge($cashregisters, $bankregisters, $platforms);
            $receipt->services = implode(', ', array_unique($services)) ?? "";
            $receipt->methods = implode(', ', array_unique($names)) ?? "";
            $receipt->user_id = $receipt->income->cashshift->user->id;
        });
        $cashshift = Cashshift::where('user_id', auth::id())->where('status', true)->first();
        return view("receipt.index", compact('receipts', 'perPage', 'cashshift'));
    }

    public function store(string $income_uuid)
    {
        $income = Income::with(['services', 'bankregisters', 'platforms', 'denominations', 'cashregisters', 'cashshift'])->where('income_uuid', $income_uuid)->first();
        if ($income) {
            $data = [];
            foreach ($income->services as $service) {
                if (!isset($data[$service->name])) {
                    $data[$service->name] = (object)['name' => '', 'quantity' => 0, 'price' => 0.00,];
                }
                $data[$service->name]->name = $service->name;
                $data[$service->name]->quantity += $service->pivot->quantity;
                $data[$service->name]->price += $service->pivot->amount * $service->pivot->quantity;
            }
            $denomination = $income->denominations()->wherePivot('type', '2')->first();
            if ($denomination) {
                $received = Denomination::where('denomination_uuid', $denomination->denomination_uuid)
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
                    ) AS total')->first();
                $returned = Denomination::where('denomination_uuid', $denomination->denomination_uuid)
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
            }
            $cashregisters = $income->cashregisters()->wherePivot('type', "2")->pluck('name')->toArray();
            $bankregisters = $income->bankregisters()->wherePivot('type', "2")->pluck('name')->toArray();
            $platforms = $income->platforms()->wherePivot('type', "2")->pluck('name')->toArray();
            $cashregisters_total = $income->cashregisters()->wherePivot('type', "2")->sum('income_cashregisters.total');
            $bankregisters_total = $income->bankregisters()->wherePivot('type', "2")->sum('income_bankregisters.total');
            $platforms_total = $income->platforms()->wherePivot('type', "2")->sum('income_platforms.total');
            $total = $cashregisters_total + $bankregisters_total + $platforms_total;
            $income->commission = $income->services()->sum('income_services.commission');
            $income->cashregister = implode(', ', array_unique($cashregisters)) ?? "";
            $income->bankregister = implode(', ', array_unique($bankregisters)) ?? "";
            $income->platform = implode(', ', array_unique($platforms)) ?? "";
            $income->cashregister_total = number_format($cashregisters_total, 2, '.', '');
            $income->bankregister_total = number_format($bankregisters_total, 2, '.', '');
            $income->platform_total = number_format($platforms_total, 2, '.', '');
            $income->total = number_format($total, 2, '.', '');
            $income->received = $received->total ?? 0;
            $income->returned = $returned->total ?? 0;
            $income->data = $data;
            $income->user = $income->cashshift->user->name;
            DB::transaction(function () use ($income_uuid, $total) {
                $receipt = Receipt::where('income_uuid', $income_uuid)->first();
                if (!$receipt) {
                    $lastReceipt = Receipt::lockForUpdate()->orderBy('code', 'desc')->first();
                    $nextCode = $lastReceipt ? intval($lastReceipt->code) + 1 : 1;
                    $code = str_pad($nextCode, 6, '0', STR_PAD_LEFT);
                    Receipt::create([
                        'income_uuid' => $income_uuid,
                        'code' => $code,
                        'amount' => $total,
                    ]);
                } else {
                    $receipt->update([
                        'amount' => $total,
                    ]);
                }
            });
            $receipt = Receipt::where('income_uuid', $income_uuid)->first();
            $income->code = $receipt->code;
            $income->date = $receipt->created_at;
            $data = [
                'income' => $income,
            ];
            $pdf = Pdf::loadView('income.receipt', $data)
                ->setPaper([0, 0, 396, 612]);
            $name = __('word.income.receipt');
            $date = $receipt->created_at;
            $filename = "{$name}_{$date}.pdf";
            return response()->stream(function () use ($pdf) {
                echo $pdf->output();
            }, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename=' . $filename
            ]);
        }
    }
}
