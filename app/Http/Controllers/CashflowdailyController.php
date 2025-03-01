<?php

namespace App\Http\Controllers;

use App\Models\Cashflowdaily;
use App\Models\Cashregister;
use App\Models\Cashshift;
use App\Models\Denomination;
use App\Models\Denominationables;
use App\Models\Paymentwithoutprice;
use App\Models\Paymentwithprice;
use App\Models\Servicewithoutprice;
use App\Models\Servicewithprice;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Css\Content\NoOpenQuote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use function PHPUnit\Framework\isEmpty;

class CashflowdailyController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $cashflowdailies = Cashflowdaily::orderBy('created_at', 'desc')->paginate($perPage);
        return view("cashflowdaily.index", compact('cashflowdailies', 'perPage'));
    }
    public function summary()
    {
        $opening = Cashshift::join('denominations', 'cashshifts.opening_uuid', '=', 'denominations.denomination_uuid')
            ->whereNull('cashshifts.deleted_at')
            ->whereNull('denominations.deleted_at')
            ->where('denominations.type', 3)
            ->where('cashshifts.start_time', now()->toDateString())
            ->selectRaw('
                COALESCE(SUM(bill_200), 0) as bill_200,
                COALESCE(SUM(bill_100), 0) as bill_100,
                COALESCE(SUM(bill_50), 0) as bill_50,
                COALESCE(SUM(bill_20), 0) as bill_20,
                COALESCE(SUM(bill_10), 0) as bill_10,
                COALESCE(SUM(coin_5), 0) as coin_5,
                COALESCE(SUM(coin_2), 0) as coin_2,
                COALESCE(SUM(coin_1), 0) as coin_1,
                COALESCE(SUM(coin_0_5), 0) as coin_0_5,
                COALESCE(SUM(coin_0_2), 0) as coin_0_2,
                COALESCE(SUM(coin_0_1), 0) as coin_0_1,
                COALESCE(SUM(total), 0) as total')->firstorfail();
        return json_decode(json_encode($opening,true));
        /*
        $total_opening = $this->total_opening();
        $total_closing = $this->total_closing($total_opening);
        $total_incomes = $this->total_incomes();
        $total_expenses = $this->total_expenses();
        $total_physical = $this->total_physical();
        $total_services = $this->total_services();
        $cashflowdaily = Cashflowdaily::where('date', now()->toDateString())->
        with(['total_denominations_opening','total_denominations_closing','total_denominations_incomes','total_denominations_expenses','total_denominations_physical'])
            ->first();
        if (!$cashflowdaily) {
            $denomination_opening = Denomination::create([
                'type' => 9,
                'bill_200' => $total_opening->bill_200 ?? 0,
                'bill_100' => $total_opening->bill_100 ?? 0,
                'bill_50' => $total_opening->bill_50 ?? 0,
                'bill_20' => $total_opening->bill_20 ?? 0,
                'bill_10' => $total_opening->bill_10 ?? 0,
                'coin_5' => $total_opening->coin_5 ?? 0,
                'coin_2' => $total_opening->coin_2 ?? 0,
                'coin_1' => $total_opening->coin_1 ?? 0,
                'coin_0_5' => $total_opening->coin_0_5 ?? 0,
                'coin_0_2' => $total_opening->coin_0_2 ?? 0,
                'coin_0_1' => $total_opening->coin_0_1 ?? 0,
                'total' => $total_opening->total ?? 0,
            ]);
            $denomination_closing = Denomination::create([
                'type' => 10,
                'bill_200' => $total_closing->bill_200 ?? 0,
                'bill_100' => $total_closing->bill_100 ?? 0,
                'bill_50' => $total_closing->bill_50 ?? 0,
                'bill_20' => $total_closing->bill_20 ?? 0,
                'bill_10' => $total_closing->bill_10 ?? 0,
                'coin_5' => $total_closing->coin_5 ?? 0,
                'coin_2' => $total_closing->coin_2 ?? 0,
                'coin_1' => $total_closing->coin_1 ?? 0,
                'coin_0_5' => $total_closing->coin_0_5 ?? 0,
                'coin_0_2' => $total_closing->coin_0_2 ?? 0,
                'coin_0_1' => $total_closing->coin_0_1 ?? 0,
                'total' => $total_closing->total ?? 0,
            ]);
            $denomination_physical = Denomination::create([
                'type' => 11,
                'bill_200' => $total_physical->bill_200 ?? 0,
                'bill_100' => $total_physical->bill_100 ?? 0,
                'bill_50' => $total_physical->bill_50 ?? 0,
                'bill_20' => $total_physical->bill_20 ?? 0,
                'bill_10' => $total_physical->bill_10 ?? 0,
                'coin_5' => $total_physical->coin_5 ?? 0,
                'coin_2' => $total_physical->coin_2 ?? 0,
                'coin_1' => $total_physical->coin_1 ?? 0,
                'coin_0_5' => $total_physical->coin_0_5 ?? 0,
                'coin_0_2' => $total_physical->coin_0_2 ?? 0,
                'coin_0_1' => $total_physical->coin_0_1 ?? 0,
                'total' => $total_physical->total ?? 0,
            ]);
            $denomination_incomes = Denomination::create([
                'type' => 12,
                'bill_200' => $total_incomes->bill_200 ?? 0,
                'bill_100' => $total_incomes->bill_100 ?? 0,
                'bill_50' => $total_incomes->bill_50 ?? 0,
                'bill_20' => $total_incomes->bill_20 ?? 0,
                'bill_10' => $total_incomes->bill_10 ?? 0,
                'coin_5' => $total_incomes->coin_5 ?? 0,
                'coin_2' => $total_incomes->coin_2 ?? 0,
                'coin_1' => $total_incomes->coin_1 ?? 0,
                'coin_0_5' => $total_incomes->coin_0_5 ?? 0,
                'coin_0_2' => $total_incomes->coin_0_2 ?? 0,
                'coin_0_1' => $total_incomes->coin_0_1 ?? 0,
                'total' => $total_incomes->total ?? 0,
            ]);
            $denomination_expenses = Denomination::create([
                'type' => 13,
                'bill_200' => $total_expenses->bill_200 ?? 0,
                'bill_100' => $total_expenses->bill_100 ?? 0,
                'bill_50' => $total_expenses->bill_50 ?? 0,
                'bill_20' => $total_expenses->bill_20 ?? 0,
                'bill_10' => $total_expenses->bill_10 ?? 0,
                'coin_5' => $total_expenses->coin_5 ?? 0,
                'coin_2' => $total_expenses->coin_2 ?? 0,
                'coin_1' => $total_expenses->coin_1 ?? 0,
                'coin_0_5' => $total_expenses->coin_0_5 ?? 0,
                'coin_0_2' => $total_expenses->coin_0_2 ?? 0,
                'coin_0_1' => $total_expenses->coin_0_1 ?? 0,
                'total' => $total_expenses->total ?? 0,
            ]);
            Cashflowdaily::create([
                'date' => Now(),
                'total_opening' => $total_opening->total,
                'total_closing' => $total_closing->total,
                'total_incomes' => $total_incomes->total,
                'total_expenses' => $total_expenses->total,
                'total_physical' => $total_physical->total,
                'total_services' => $total_services,
                'total_opening_uuid' => $denomination_opening->denomination_uuid,
                'total_closing_uuid' => $denomination_closing->denomination_uuid,
                'total_physical_uuid' => $denomination_physical->denomination_uuid,
                'total_incomes_uuid' => $denomination_incomes->denomination_uuid,
                'total_expenses_uuid' => $denomination_expenses->denomination_uuid,
            ]);
        }
        else {
            $denomination_opening = $cashflowdaily->total_denominations_opening;
            $denomination_closing = $cashflowdaily->total_denominations_closing;
            $denomination_incomes = $cashflowdaily->total_denominations_incomes;
            $denomination_expenses = $cashflowdaily->total_denominations_expenses;
            $denomination_physical = $cashflowdaily->total_denominations_physical;
            $denomination_opening->update([
                'bill_200' => $total_opening->bill_200 ?? 0,
                'bill_100' => $total_opening->bill_100 ?? 0,
                'bill_50' => $total_opening->bill_50 ?? 0,
                'bill_20' => $total_opening->bill_20 ?? 0,
                'bill_10' => $total_opening->bill_10 ?? 0,
                'coin_5' => $total_opening->coin_5 ?? 0,
                'coin_2' => $total_opening->coin_2 ?? 0,
                'coin_1' => $total_opening->coin_1 ?? 0,
                'coin_0_5' => $total_opening->coin_0_5 ?? 0,
                'coin_0_2' => $total_opening->coin_0_2 ?? 0,
                'coin_0_1' => $total_opening->coin_0_1 ?? 0,
                'total' => $total_opening->total ?? 0,
            ]);
            $denomination_closing->update([
                'bill_200' => $total_closing->bill_200 ?? 0,
                'bill_100' => $total_closing->bill_100 ?? 0,
                'bill_50' => $total_closing->bill_50 ?? 0,
                'bill_20' => $total_closing->bill_20 ?? 0,
                'bill_10' => $total_closing->bill_10 ?? 0,
                'coin_5' => $total_closing->coin_5 ?? 0,
                'coin_2' => $total_closing->coin_2 ?? 0,
                'coin_1' => $total_closing->coin_1 ?? 0,
                'coin_0_5' => $total_closing->coin_0_5 ?? 0,
                'coin_0_2' => $total_closing->coin_0_2 ?? 0,
                'coin_0_1' => $total_closing->coin_0_1 ?? 0,
                'total' => $total_closing->total ?? 0,
            ]);
            $denomination_incomes->update([
                'bill_200' => $total_incomes->bill_200 ?? 0,
                'bill_100' => $total_incomes->bill_100 ?? 0,
                'bill_50' => $total_incomes->bill_50 ?? 0,
                'bill_20' => $total_incomes->bill_20 ?? 0,
                'bill_10' => $total_incomes->bill_10 ?? 0,
                'coin_5' => $total_incomes->coin_5 ?? 0,
                'coin_2' => $total_incomes->coin_2 ?? 0,
                'coin_1' => $total_incomes->coin_1 ?? 0,
                'coin_0_5' => $total_incomes->coin_0_5 ?? 0,
                'coin_0_2' => $total_incomes->coin_0_2 ?? 0,
                'coin_0_1' => $total_incomes->coin_0_1 ?? 0,
                'total' => $total_incomes->total ?? 0,
            ]);
            $denomination_expenses->update([
                'bill_200' => $total_expenses->bill_200 ?? 0,
                'bill_100' => $total_expenses->bill_100 ?? 0,
                'bill_50' => $total_expenses->bill_50 ?? 0,
                'bill_20' => $total_expenses->bill_20 ?? 0,
                'bill_10' => $total_expenses->bill_10 ?? 0,
                'coin_5' => $total_expenses->coin_5 ?? 0,
                'coin_2' => $total_expenses->coin_2 ?? 0,
                'coin_1' => $total_expenses->coin_1 ?? 0,
                'coin_0_5' => $total_expenses->coin_0_5 ?? 0,
                'coin_0_2' => $total_expenses->coin_0_2 ?? 0,
                'coin_0_1' => $total_expenses->coin_0_1 ?? 0,
                'total' => $total_expenses->total ?? 0,
            ]);
            $denomination_physical->update([
                'bill_200' => $total_physical->bill_200 ?? 0,
                'bill_100' => $total_physical->bill_100 ?? 0,
                'bill_50' => $total_physical->bill_50 ?? 0,
                'bill_20' => $total_physical->bill_20 ?? 0,
                'bill_10' => $total_physical->bill_10 ?? 0,
                'coin_5' => $total_physical->coin_5 ?? 0,
                'coin_2' => $total_physical->coin_2 ?? 0,
                'coin_1' => $total_physical->coin_1 ?? 0,
                'coin_0_5' => $total_physical->coin_0_5 ?? 0,
                'coin_0_2' => $total_physical->coin_0_2 ?? 0,
                'coin_0_1' => $total_physical->coin_0_1 ?? 0,
                'total' => $total_physical->total ?? 0,
            ]);
            $cashflowdaily->update([
                'total_opening' => $total_opening->total,
                'total_closing' => $total_closing->total,
                'total_incomes' => $total_incomes->total,
                'total_expenses' => $total_expenses->total,
                'total_physical' => $total_physical->total,
                'total_services' => $total_services,
            ]);
        }
        return redirect("/cashflowdailies")->with('success', 'Flujo de caja actualizado correctamente.');*/
    }

    public function detail(string $cashflowdaily_uuid)
    {
        $cashflowdaily = Cashflowdaily::where('cashflowdaily_uuid', $cashflowdaily_uuid)->
        with(['total_denominations_opening','total_denominations_closing','total_denominations_incomes','total_denominations_expenses','total_denominations_physical'])
            ->firstorfail();
        $denomination_opening = $cashflowdaily->total_denominations_opening;
        $denomination_closing = $cashflowdaily->total_denominations_closing;
        $denomination_incomes = $cashflowdaily->total_denominations_incomes;
        $denomination_expenses = $cashflowdaily->total_denominations_expenses;
        $denomination_physical = $cashflowdaily->total_denominations_physical;
        $services = json_decode($cashflowdaily->total_services);
        return response()->json([
            'denomination' => $denomination_opening,
            'denomination_closing' => $denomination_closing,
            'denomination_incomes' => $denomination_incomes,
            'denomination_expenses' => $denomination_expenses,
            'denomination_physical' => $denomination_physical,
            'total_services'=>$services,
        ]);
    }

    public function report(string $cashflowdaily_uuid)
    {
        $cashflowdaily = Cashflowdaily::where('cashflowdaily_uuid', $cashflowdaily_uuid)->
        with(['total_denominations_opening','total_denominations_closing','total_denominations_incomes','total_denominations_expenses','total_denominations_physical'])
            ->firstorfail();
        $denomination_opening = $cashflowdaily->total_denominations_opening;
        $denomination_closing = $cashflowdaily->total_denominations_closing;
        $denomination_incomes = $cashflowdaily->total_denominations_incomes;
        $denomination_expenses = $cashflowdaily->total_denominations_expenses;
        $denomination_physical = $cashflowdaily->total_denominations_physical;
        $services = json_decode($cashflowdaily->total_services);
        $cashshifts = Cashshift::where('start_time', $cashflowdaily->date)
            ->with(['cashregister', 'user'])
            ->get();
        $details = [];
        if (!$cashshifts->isEmpty()) {
            foreach ($cashshifts as $cashshift) {
                $detail = new \stdClass();
                $detail->cash = $cashshift->cashregister->name ?? 'N/A'; // Manejo de valores nulos
                $detail->user = $cashshift->user->name ?? 'N/A';
                $detail->initial_balance = $cashshift->initial_balance;
                $detail->closing_balance = $cashshift->closing_balance ?? "0.00";
                $detail->incomes_balance = $cashshift->incomes_balance ?? "0.00";
                $detail->expenses_balance = $cashshift->expenses_balance ?? "0.00";
                $detail->physical_balance = $cashshift->physical_balance ?? "0.00";
                $detail->difference_balance = $cashshift->difference_balance ?? "0.00";
                $details[] = $detail;
            }
        }
        $data = [
            'cashflowdaily'=> $cashflowdaily,
            'denomination_opening'=> $denomination_opening,
            'denomination_closing'=> $denomination_closing,
            'denomination_incomes'=> $denomination_incomes,
            'denomination_expenses'=> $denomination_expenses,
            'denomination_physical'=> $denomination_physical,
            'total_services'=> $services,
            'detail_cashshift' => $details,
        ];
        $pdf = Pdf::loadView('cashflowdaily.report', $data)
            ->setPaper('letter', 'landscape');
        return response()->stream(function () use ($pdf) {
            echo $pdf->output();
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="ARQUEO DE CAJA - ' . $cashflowdaily->date . '"',
        ]);
    }
    public function total_opening(){
        $opening = Cashshift::join('denominations', 'cashshifts.opening_uuid', '=', 'denominations.denomination_uuid')
            ->whereNull('cashshifts.deleted_at')
            ->whereNull('denominations.deleted_at')
            ->where('denominations.type', 3)
            ->where('cashshifts.start_time', now()->toDateString())
            ->selectRaw('
                COALESCE(SUM(bill_200), 0) as bill_200,
                COALESCE(SUM(bill_100), 0) as bill_100,
                COALESCE(SUM(bill_50), 0) as bill_50,
                COALESCE(SUM(bill_20), 0) as bill_20,
                COALESCE(SUM(bill_10), 0) as bill_10,
                COALESCE(SUM(coin_5), 0) as coin_5,
                COALESCE(SUM(coin_2), 0) as coin_2,
                COALESCE(SUM(coin_1), 0) as coin_1,
                COALESCE(SUM(coin_0_5), 0) as coin_0_5,
                COALESCE(SUM(coin_0_2), 0) as coin_0_2,
                COALESCE(SUM(coin_0_1), 0) as coin_0_1,
                COALESCE(SUM(total), 0) as total')->firstorfail();
        return json_decode(json_encode($opening,true));
    }
    public function total_physical(){
        $physical = Cashshift::join('denominations', 'cashshifts.physical_uuid', '=', 'denominations.denomination_uuid')
            ->whereNull('cashshifts.deleted_at')
            ->whereNull('denominations.deleted_at')
            ->where('denominations.type', 5)
            ->where('cashshifts.start_time', now()->toDateString())
            ->selectRaw('
                COALESCE(SUM(bill_200), 0) as bill_200,
                COALESCE(SUM(bill_100), 0) as bill_100,
                COALESCE(SUM(bill_50), 0) as bill_50,
                COALESCE(SUM(bill_20), 0) as bill_20,
                COALESCE(SUM(bill_10), 0) as bill_10,
                COALESCE(SUM(coin_5), 0) as coin_5,
                COALESCE(SUM(coin_2), 0) as coin_2,
                COALESCE(SUM(coin_1), 0) as coin_1,
                COALESCE(SUM(coin_0_5), 0) as coin_0_5,
                COALESCE(SUM(coin_0_2), 0) as coin_0_2,
                COALESCE(SUM(coin_0_1), 0) as coin_0_1,
                COALESCE(SUM(total), 0) as total')->firstorfail();
        return json_decode(json_encode($physical,true));
    }
    public function total_closing($total_opening){
        $totals_paymentwithoutprices = Cashshift::join('paymentwithoutprices', 'cashshifts.cashshift_uuid', '=', 'paymentwithoutprices.cashshift_uuid')
            ->join('denominations', 'paymentwithoutprices.denomination_uuid', '=', 'denominations.denomination_uuid')
            ->whereNull('paymentwithoutprices.deleted_at')
            ->whereNull('denominations.deleted_at')
            ->whereIn('denominations.type', [1, 2])
            ->where('cashshifts.start_time', now()->toDateString())
            ->selectRaw('
                COALESCE(SUM(bill_200), 0) as total_bill_200,
                COALESCE(SUM(bill_100), 0) as total_bill_100,
                COALESCE(SUM(bill_50), 0) as total_bill_50,
                COALESCE(SUM(bill_20), 0) as total_bill_20,
                COALESCE(SUM(bill_10), 0) as total_bill_10,
                COALESCE(SUM(coin_5), 0) as total_coin_5,
                COALESCE(SUM(coin_2), 0) as total_coin_2,
                COALESCE(SUM(coin_1), 0) as total_coin_1,
                COALESCE(SUM(coin_0_5), 0) as total_coin_0_5,
                COALESCE(SUM(coin_0_2), 0) as total_coin_0_2,
                COALESCE(SUM(coin_0_1), 0) as total_coin_0_1,
                COALESCE(SUM(total), 0) as total_total')->firstorfail();
        $totals_paymentwithprices = Cashshift::join('paymentwithprices', 'cashshifts.cashshift_uuid', '=', 'paymentwithprices.cashshift_uuid')
            ->join('denominations', 'paymentwithprices.denomination_uuid', '=', 'denominations.denomination_uuid')
            ->whereNull('paymentwithprices.deleted_at')
            ->whereNull('denominations.deleted_at')
            ->whereIn('denominations.type', [1, 2])
            ->where('cashshifts.start_time', now()->toDateString())
            ->selectRaw('
                COALESCE(SUM(bill_200), 0) as total_bill_200,
                COALESCE(SUM(bill_100), 0) as total_bill_100,
                COALESCE(SUM(bill_50), 0) as total_bill_50,
                COALESCE(SUM(bill_20), 0) as total_bill_20,
                COALESCE(SUM(bill_10), 0) as total_bill_10,
                COALESCE(SUM(coin_5), 0) as total_coin_5,
                COALESCE(SUM(coin_2), 0) as total_coin_2,
                COALESCE(SUM(coin_1), 0) as total_coin_1,
                COALESCE(SUM(coin_0_5), 0) as total_coin_0_5,
                COALESCE(SUM(coin_0_2), 0) as total_coin_0_2,
                COALESCE(SUM(coin_0_1), 0) as total_coin_0_1,
                COALESCE(SUM(total), 0) as total_total')->firstorfail();
        $movement = [
            'bill_200' => ($totals_paymentwithoutprices->total_bill_200 ?? 0) + ($totals_paymentwithprices->total_bill_200 ?? 0),
            'bill_100' => ($totals_paymentwithoutprices->total_bill_100 ?? 0) + ($totals_paymentwithprices->total_bill_100 ?? 0),
            'bill_50' => ($totals_paymentwithoutprices->total_bill_50 ?? 0) + ($totals_paymentwithprices->total_bill_50 ?? 0),
            'bill_20' => ($totals_paymentwithoutprices->total_bill_20 ?? 0) + ($totals_paymentwithprices->total_bill_20 ?? 0),
            'bill_10' => ($totals_paymentwithoutprices->total_bill_10 ?? 0) + ($totals_paymentwithprices->total_bill_10 ?? 0),
            'coin_5' => ($totals_paymentwithoutprices->total_coin_5 ?? 0) + ($totals_paymentwithprices->total_coin_5 ?? 0),
            'coin_2' => ($totals_paymentwithoutprices->total_coin_2 ?? 0) + ($totals_paymentwithprices->total_coin_2 ?? 0),
            'coin_1' => ($totals_paymentwithoutprices->total_coin_1 ?? 0) + ($totals_paymentwithprices->total_coin_1 ?? 0),
            'coin_0_5' => ($totals_paymentwithoutprices->total_coin_0_5 ?? 0) + ($totals_paymentwithprices->total_coin_0_5 ?? 0),
            'coin_0_2' => ($totals_paymentwithoutprices->total_coin_0_2 ?? 0) + ($totals_paymentwithprices->total_coin_0_2 ?? 0),
            'coin_0_1' => ($totals_paymentwithoutprices->total_coin_0_1 ?? 0) + ($totals_paymentwithprices->total_coin_0_1 ?? 0),
            'total' => ($totals_paymentwithoutprices->total_total ?? 0) + ($totals_paymentwithprices->total_total ?? 0),
        ];
        $total_movement = json_decode(json_encode($movement));
        $closing = [
            'bill_200' => ($total_opening->bill_200 ?? 0) + ($total_movement->bill_200 ?? 0),
            'bill_100' => ($total_opening->bill_100 ?? 0) + ($total_movement->bill_100 ?? 0),
            'bill_50' => ($total_opening->bill_50 ?? 0) + ($total_movement->bill_50 ?? 0),
            'bill_20' => ($total_opening->bill_20 ?? 0) + ($total_movement->bill_20 ?? 0),
            'bill_10' => ($total_opening->bill_10 ?? 0) + ($total_movement->bill_10 ?? 0),
            'coin_5' => ($total_opening->coin_5 ?? 0) + ($total_movement->coin_5 ?? 0),
            'coin_2' => ($total_opening->coin_2 ?? 0) + ($total_movement->coin_2 ?? 0),
            'coin_1' => ($total_opening->coin_1 ?? 0) + ($total_movement->coin_1 ?? 0),
            'coin_0_5' => ($total_opening->coin_0_5 ?? 0) + ($total_movement->coin_0_5 ?? 0),
            'coin_0_2' => ($total_opening->coin_0_2 ?? 0) + ($total_movement->coin_0_2 ?? 0),
            'coin_0_1' => ($total_opening->coin_0_1 ?? 0) + ($total_movement->coin_0_1 ?? 0),
            'total' => ($total_opening->total ?? 0) + ($total_movement->total ?? 0),
        ];
        return json_decode(json_encode($closing));
    }
    public function total_incomes(){
        $incomes_paymentwithoutprices = Cashshift::join('paymentwithoutprices', 'cashshifts.cashshift_uuid', '=', 'paymentwithoutprices.cashshift_uuid')
            ->join('denominations', 'paymentwithoutprices.denomination_uuid', '=', 'denominations.denomination_uuid')
            ->whereNull('paymentwithoutprices.deleted_at')
            ->whereNull('denominations.deleted_at')
            ->where('denominations.type', "1")
            ->where('cashshifts.start_time', now()->toDateString())
            ->selectRaw('
                COALESCE(SUM(bill_200), 0) as total_bill_200,
                COALESCE(SUM(bill_100), 0) as total_bill_100,
                COALESCE(SUM(bill_50), 0) as total_bill_50,
                COALESCE(SUM(bill_20), 0) as total_bill_20,
                COALESCE(SUM(bill_10), 0) as total_bill_10,
                COALESCE(SUM(coin_5), 0) as total_coin_5,
                COALESCE(SUM(coin_2), 0) as total_coin_2,
                COALESCE(SUM(coin_1), 0) as total_coin_1,
                COALESCE(SUM(coin_0_5), 0) as total_coin_0_5,
                COALESCE(SUM(coin_0_2), 0) as total_coin_0_2,
                COALESCE(SUM(coin_0_1), 0) as total_coin_0_1,
                COALESCE(SUM(total), 0) as total_total')->firstorfail();
        $incomes_paymentwithprices = Cashshift::join('paymentwithprices', 'cashshifts.cashshift_uuid', '=', 'paymentwithprices.cashshift_uuid')
            ->join('denominations', 'paymentwithprices.denomination_uuid', '=', 'denominations.denomination_uuid')
            ->whereNull('paymentwithprices.deleted_at')
            ->whereNull('denominations.deleted_at')
            ->where('denominations.type', "1")
            ->where('cashshifts.start_time', now()->toDateString())
            ->selectRaw('
                COALESCE(SUM(bill_200), 0) as total_bill_200,
                COALESCE(SUM(bill_100), 0) as total_bill_100,
                COALESCE(SUM(bill_50), 0) as total_bill_50,
                COALESCE(SUM(bill_20), 0) as total_bill_20,
                COALESCE(SUM(bill_10), 0) as total_bill_10,
                COALESCE(SUM(coin_5), 0) as total_coin_5,
                COALESCE(SUM(coin_2), 0) as total_coin_2,
                COALESCE(SUM(coin_1), 0) as total_coin_1,
                COALESCE(SUM(coin_0_5), 0) as total_coin_0_5,
                COALESCE(SUM(coin_0_2), 0) as total_coin_0_2,
                COALESCE(SUM(coin_0_1), 0) as total_coin_0_1,
                COALESCE(SUM(total), 0) as total_total')->firstorfail();
        $incomes = [
            'bill_200' => ($incomes_paymentwithoutprices->total_bill_200 ?? 0) + ($incomes_paymentwithprices->total_bill_200 ?? 0),
            'bill_100' => ($incomes_paymentwithoutprices->total_bill_100 ?? 0) + ($incomes_paymentwithprices->total_bill_100 ?? 0),
            'bill_50' => ($incomes_paymentwithoutprices->total_bill_50 ?? 0) + ($incomes_paymentwithprices->total_bill_50 ?? 0),
            'bill_20' => ($incomes_paymentwithoutprices->total_bill_20 ?? 0) + ($incomes_paymentwithprices->total_bill_20 ?? 0),
            'bill_10' => ($incomes_paymentwithoutprices->total_bill_10 ?? 0) + ($incomes_paymentwithprices->total_bill_10 ?? 0),
            'coin_5' => ($incomes_paymentwithoutprices->total_coin_5 ?? 0) + ($incomes_paymentwithprices->total_coin_5 ?? 0),
            'coin_2' => ($incomes_paymentwithoutprices->total_coin_2 ?? 0) + ($incomes_paymentwithprices->total_coin_2 ?? 0),
            'coin_1' => ($incomes_paymentwithoutprices->total_coin_1 ?? 0) + ($incomes_paymentwithprices->total_coin_1 ?? 0),
            'coin_0_5' => ($incomes_paymentwithoutprices->total_coin_0_5 ?? 0) + ($incomes_paymentwithprices->total_coin_0_5 ?? 0),
            'coin_0_2' => ($incomes_paymentwithoutprices->total_coin_0_2 ?? 0) + ($incomes_paymentwithprices->total_coin_0_2 ?? 0),
            'coin_0_1' => ($incomes_paymentwithoutprices->total_coin_0_1 ?? 0) + ($incomes_paymentwithprices->total_coin_0_1 ?? 0),
            'total' => ($incomes_paymentwithoutprices->total_total ?? 0) + ($incomes_paymentwithprices->total_total ?? 0),
        ];
        return json_decode(json_encode($incomes));
    }
    public function total_expenses(){
        $expense_paymentwithoutprices = Cashshift::join('paymentwithoutprices', 'cashshifts.cashshift_uuid', '=', 'paymentwithoutprices.cashshift_uuid')
            ->join('denominations', 'paymentwithoutprices.denomination_uuid', '=', 'denominations.denomination_uuid')
            ->whereNull('paymentwithoutprices.deleted_at')
            ->whereNull('denominations.deleted_at')
            ->where('denominations.type', 2)
            ->where('cashshifts.start_time', now()->toDateString())
            ->selectRaw('
                COALESCE(SUM(bill_200), 0) as total_bill_200,
                COALESCE(SUM(bill_100), 0) as total_bill_100,
                COALESCE(SUM(bill_50), 0) as total_bill_50,
                COALESCE(SUM(bill_20), 0) as total_bill_20,
                COALESCE(SUM(bill_10), 0) as total_bill_10,
                COALESCE(SUM(coin_5), 0) as total_coin_5,
                COALESCE(SUM(coin_2), 0) as total_coin_2,
                COALESCE(SUM(coin_1), 0) as total_coin_1,
                COALESCE(SUM(coin_0_5), 0) as total_coin_0_5,
                COALESCE(SUM(coin_0_2), 0) as total_coin_0_2,
                COALESCE(SUM(coin_0_1), 0) as total_coin_0_1,
                COALESCE(SUM(total), 0) as total_total')->firstorfail();
        $expense_paymentwithprices = Cashshift::join('paymentwithprices', 'cashshifts.cashshift_uuid', '=', 'paymentwithprices.cashshift_uuid')
            ->join('denominations', 'paymentwithprices.denomination_uuid', '=', 'denominations.denomination_uuid')
            ->whereNull('paymentwithprices.deleted_at')
            ->whereNull('denominations.deleted_at')
            ->where('denominations.type', 2)
            ->where('cashshifts.start_time', now()->toDateString())
            ->selectRaw('
                COALESCE(SUM(bill_200), 0) as total_bill_200,
                COALESCE(SUM(bill_100), 0) as total_bill_100,
                COALESCE(SUM(bill_50), 0) as total_bill_50,
                COALESCE(SUM(bill_20), 0) as total_bill_20,
                COALESCE(SUM(bill_10), 0) as total_bill_10,
                COALESCE(SUM(coin_5), 0) as total_coin_5,
                COALESCE(SUM(coin_2), 0) as total_coin_2,
                COALESCE(SUM(coin_1), 0) as total_coin_1,
                COALESCE(SUM(coin_0_5), 0) as total_coin_0_5,
                COALESCE(SUM(coin_0_2), 0) as total_coin_0_2,
                COALESCE(SUM(coin_0_1), 0) as total_coin_0_1,
                COALESCE(SUM(total), 0) as total_total')->firstorfail();
        $expenses = [
            'bill_200' => ($expense_paymentwithoutprices->total_bill_200 ?? 0) + ($expense_paymentwithprices->total_bill_200 ?? 0),
            'bill_100' => ($expense_paymentwithoutprices->total_bill_100 ?? 0) + ($expense_paymentwithprices->total_bill_100 ?? 0),
            'bill_50' => ($expense_paymentwithoutprices->total_bill_50 ?? 0) + ($expense_paymentwithprices->total_bill_50 ?? 0),
            'bill_20' => ($expense_paymentwithoutprices->total_bill_20 ?? 0) + ($expense_paymentwithprices->total_bill_20 ?? 0),
            'bill_10' => ($expense_paymentwithoutprices->total_bill_10 ?? 0) + ($expense_paymentwithprices->total_bill_10 ?? 0),
            'coin_5' => ($expense_paymentwithoutprices->total_coin_5 ?? 0) + ($expense_paymentwithprices->total_coin_5 ?? 0),
            'coin_2' => ($expense_paymentwithoutprices->total_coin_2 ?? 0) + ($expense_paymentwithprices->total_coin_2 ?? 0),
            'coin_1' => ($expense_paymentwithoutprices->total_coin_1 ?? 0) + ($expense_paymentwithprices->total_coin_1 ?? 0),
            'coin_0_5' => ($expense_paymentwithoutprices->total_coin_0_5 ?? 0) + ($expense_paymentwithprices->total_coin_0_5 ?? 0),
            'coin_0_2' => ($expense_paymentwithoutprices->total_coin_0_2 ?? 0) + ($expense_paymentwithprices->total_coin_0_2 ?? 0),
            'coin_0_1' => ($expense_paymentwithoutprices->total_coin_0_1 ?? 0) + ($expense_paymentwithprices->total_coin_0_1 ?? 0),
            'total' => ($expense_paymentwithoutprices->total_total ?? 0) + ($expense_paymentwithprices->total_total ?? 0),
        ];
        return json_decode(json_encode($expenses));
    }

    public function total_services(){
        $cashshift = Cashshift::where('start_time', now()->toDateString())->first();
        if ($cashshift){
            $paymentwithoutprices = Paymentwithoutprice::whereDate('created_at', now())->get();
            $array_servicewithprice_uuids = [];
            foreach ($paymentwithoutprices as $item) {
                foreach ($item->toArray() as $key => $value) {
                    if ($key == 'servicewithprice_uuids') {
                        $array_servicewithprice_uuids[] = $value;
                    }
                }
            }
            $servicewithpriceCount = [];
            foreach ($array_servicewithprice_uuids as $servicewithprice_uuids) {
                $serviceUuids = json_decode($servicewithprice_uuids, true);
                foreach ($serviceUuids as $serviceUuid) {
                    $service = Servicewithprice::where('servicewithprice_uuid', $serviceUuid)->first();
                    if ($service) {
                        if (isset($servicewithpriceCount[$service->name])) {
                            $servicewithpriceCount[$service->name]['cantidad']++;
                            $servicewithpriceCount[$service->name]['monto'] += $service->amount;
                            $servicewithpriceCount[$service->name]['commission'] += $service->commission;
                        } else {
                            $servicewithpriceCount[$service->name] = ['cantidad' => 1, 'servicio' => $service->name, 'monto' => $service->amount, 'commission' => $service->commission];
                        }
                    }
                }
            }
            $array_servicewithoutprice_uuids = [];
            $array_amounts = [];
            $array_commissions = [];
            $paymentwithprices = Paymentwithprice::whereDate('created_at', now())->get();
            foreach ($paymentwithprices as $item) {
                foreach ($item->toArray() as $key => $value) {
                    if ($key == 'servicewithoutprice_uuids') $array_servicewithoutprice_uuids[] = $value;
                    if ($key == 'amounts') $array_amounts[] = $value;
                    if ($key == 'commissions') $array_commissions[] = $value;
                }
            }

            $servicewithoutpriceCount = [];
            foreach ($array_servicewithoutprice_uuids as $index => $servicewithoutprice_uuids) {
                $serviceUuids = json_decode($servicewithoutprice_uuids, true);
                $amounts = isset($array_amounts[$index]) ? json_decode($array_amounts[$index], true) : [];
                $commissions = isset($array_commissions[$index]) ? json_decode($array_commissions[$index], true) : [];
                foreach ($serviceUuids as $key => $serviceUuid) {
                    $service = Servicewithoutprice::where('servicewithoutprice_uuid', $serviceUuid)->first();
                    if ($service) {
                        $amount = isset($amounts[$key]) ? floatval($amounts[$key]) : 0.0;
                        $commission = isset($commissions[$key]) ? floatval($commissions[$key]) : 0.0;
                        if (isset($servicewithoutpriceCount[$service->name])) {
                            $servicewithoutpriceCount[$service->name]['cantidad']++;
                            $servicewithoutpriceCount[$service->name]['monto'] += $amount;
                            $servicewithoutpriceCount[$service->name]['commission'] += $commission;
                        } else {
                            $servicewithoutpriceCount[$service->name] = ['cantidad' => 1, 'servicio' => $service->name, 'monto' => $amount, 'commission' => $commission];
                        }
                    }
                }
            }
            $array_total_services = array_merge($servicewithpriceCount, $servicewithoutpriceCount);
            return json_encode($array_total_services);
        }
    }
}
