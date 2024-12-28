<?php

namespace App\Http\Controllers;

use App\Models\Cashcount;
use App\Models\Cashflowdaily;
use App\Models\Cashregister;
use App\Models\Cashshift;
use App\Models\Category;
use App\Models\Denomination;
use App\Models\Expense;
use App\Models\Paymentwithoutprice;
use App\Models\Paymentwithprice;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Servicewithoutprice;
use App\Models\Servicewithprice;
use App\Models\Transactionmethod;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $total_users = User::count();
        $total_categories = Category::count();
        $total_services = Servicewithoutprice::count() + Servicewithprice::count();
        $total_transactionmethods = Transactionmethod::count();
        $total_payments = Paymentwithprice::count() + Paymentwithoutprice::count();
        $total_payments_by_user = Paymentwithprice::where("user_id",Auth::id())->count() + Paymentwithoutprice::where("user_id",Auth::id())->count();
        $total_cashregisters = Cashregister::count();
        $total_cashshifts = Cashshift::count();
        $total_cashshifts_by_user = Cashshift::where("user_id",Auth::id())->count();
        $total_expenses = Expense::count();
        $total_expenses_by_user = Expense::where("user_id",Auth::id())->count();
        $total_cashflowdailies = Cashflowdaily::count();
        $total_products = Product::count();
        $total_sales = Sale::count();
        $total_sales_by_user = Sale::where("user_id",Auth::id())->count();
        $cashshift = Cashshift::where('user_id',Auth::id())->where('status','1')->with('cashregister')->first();
        if ($cashshift) $data = $this->show($cashshift->cashshift_uuid);
        else $data = false;
        return view('dashboard', compact('total_users','total_categories','total_services','total_transactionmethods','total_payments','total_payments_by_user','total_cashregisters','total_cashshifts','total_cashshifts_by_user','total_cashflowdailies','total_expenses','total_expenses_by_user','total_products','total_sales','total_sales_by_user','data','cashshift'));
    }

    public function state(string $cashshift_uuid)
    {
        $cashshift = Cashshift::where('cashshift_uuid', $cashshift_uuid)->firstOrFail();
        if ($cashshift->status === '1') {
            $cashshift->update([
                'end_time' => now(),
                'status' => '0',
            ]);
        }
        return redirect("/dashboard")->with('success', 'Arqueo cerrado exitosamente');
    }
    public function show(string $cashshift_uuid)
    {
        $cashshift = Cashshift::where('cashshift_uuid', $cashshift_uuid)
            ->with(['denominations_opening', 'denominations_closing', 'denominations_incomes', 'denominations_expenses', 'denominations_physical', 'denominations_difference'])->first();
        $opening = $cashshift->denominations_opening;

        $closing = $this->closing($cashshift_uuid, $opening);
        if ($cashshift->denominations_closing) {
            $denomination = $cashshift->denominations_closing;
            $denomination->update([
                'bill_200' => $closing['bill_200'] ?? 0,
                'bill_100' => $closing['bill_100'] ?? 0,
                'bill_50' => $closing['bill_50'] ?? 0,
                'bill_20' => $closing['bill_20'] ?? 0,
                'bill_10' => $closing['bill_10'] ?? 0,
                'coin_5' => $closing['coin_5'] ?? 0,
                'coin_2' => $closing['coin_2'] ?? 0,
                'coin_1' => $closing['coin_1'] ?? 0,
                'coin_0_5' => $closing['coin_0_5'] ?? 0,
                'coin_0_2' => $closing['coin_0_2'] ?? 0,
                'coin_0_1' => $closing['coin_0_1'] ?? 0,
                'physical_cash' => $closing['physical_cash'] ?? 0,
                'digital_cash' => $closing['digital_cash'] ?? 0,
                'total' => $closing['total'] ?? 0,
            ]);
            $cashshift->update([
                'end_time' => now(),
                'closing_balance' => $denomination->total,
            ]);
        } else {
            $denomination = Denomination::create([
                'type' => 4,
                'bill_200' => $closing['bill_200'] ?? 0,
                'bill_100' => $closing['bill_100'] ?? 0,
                'bill_50' => $closing['bill_50'] ?? 0,
                'bill_20' => $closing['bill_20'] ?? 0,
                'bill_10' => $closing['bill_10'] ?? 0,
                'coin_5' => $closing['coin_5'] ?? 0,
                'coin_2' => $closing['coin_2'] ?? 0,
                'coin_1' => $closing['coin_1'] ?? 0,
                'coin_0_5' => $closing['coin_0_5'] ?? 0,
                'coin_0_2' => $closing['coin_0_2'] ?? 0,
                'coin_0_1' => $closing['coin_0_1'] ?? 0,
                'physical_cash' => $closing['physical_cash'] ?? 0,
                'digital_cash' => $closing['digital_cash'] ?? 0,
                'total' => $closing['total'] ?? 0,
            ]);
            $cashshift->update([
                'end_time' => now(),
                'closing_balance' => $denomination->total,
                'closing_uuid' => $denomination->denomination_uuid,
            ]);
        }

        $incomes = $this->incomes($cashshift_uuid);
        if ($cashshift->denominations_incomes) {
            $denomination = $cashshift->denominations_incomes;
            $denomination->update([
                'bill_200' => $incomes->bill_200 ?? 0,
                'bill_100' => $incomes->bill_100 ?? 0,
                'bill_50' => $incomes->bill_50 ?? 0,
                'bill_20' => $incomes->bill_20 ?? 0,
                'bill_10' => $incomes->bill_10 ?? 0,
                'coin_5' => $incomes->coin_5 ?? 0,
                'coin_2' => $incomes->coin_2 ?? 0,
                'coin_1' => $incomes->coin_1 ?? 0,
                'coin_0_5' => $incomes->coin_0_5 ?? 0,
                'coin_0_2' => $incomes->coin_0_2 ?? 0,
                'coin_0_1' => $incomes->coin_0_1 ?? 0,
                'physical_cash' => $incomes->physical_cash ?? 0,
                'digital_cash' => $incomes->digital_cash ?? 0,
                'total' => $incomes->total ?? 0,
            ]);
            $cashshift->update([
                'incomes_balance' => $denomination->total,
            ]);
        } else {
            $denomination = Denomination::create([
                'type' => 6,
                'bill_200' => $incomes->bill_200 ?? 0,
                'bill_100' => $incomes->bill_100 ?? 0,
                'bill_50' => $incomes->bill_50 ?? 0,
                'bill_20' => $incomes->bill_20 ?? 0,
                'bill_10' => $incomes->bill_10 ?? 0,
                'coin_5' => $incomes->coin_5 ?? 0,
                'coin_2' => $incomes->coin_2 ?? 0,
                'coin_1' => $incomes->coin_1 ?? 0,
                'coin_0_5' => $incomes->coin_0_5 ?? 0,
                'coin_0_2' => $incomes->coin_0_2 ?? 0,
                'coin_0_1' => $incomes->coin_0_1 ?? 0,
                'physical_cash' => $incomes->physical_cash ?? 0,
                'digital_cash' => $incomes->digital_cash ?? 0,
                'total' => $incomes->total ?? 0,
            ]);
            $cashshift->update([
                'incomes_balance' => $denomination->total,
                'incomes_uuid' => $denomination->denomination_uuid,
            ]);
        }

        $expenses = $this->expenses($cashshift_uuid);
        if ($cashshift->denominations_expenses) {
            $denomination = $cashshift->denominations_expenses;
            $denomination->update([
                'bill_200' => $expenses->bill_200 ?? 0,
                'bill_100' => $expenses->bill_100 ?? 0,
                'bill_50' => $expenses->bill_50 ?? 0,
                'bill_20' => $expenses->bill_20 ?? 0,
                'bill_10' => $expenses->bill_10 ?? 0,
                'coin_5' => $expenses->coin_5 ?? 0,
                'coin_2' => $expenses->coin_2 ?? 0,
                'coin_1' => $expenses->coin_1 ?? 0,
                'coin_0_5' => $expenses->coin_0_5 ?? 0,
                'coin_0_2' => $expenses->coin_0_2 ?? 0,
                'coin_0_1' => $expenses->coin_0_1 ?? 0,
                'physical_cash' => $expenses->physical_cash ?? 0,
                'digital_cash' => $expenses->digital_cash ?? 0,
                'total' => $expenses->total ?? 0,
            ]);
            $cashshift->update([
                'expenses_balance' => $denomination->total,
            ]);
        } else {
            $denomination = Denomination::create([
                'type' => 7,
                'bill_200' => $expenses->bill_200 ?? 0,
                'bill_100' => $expenses->bill_100 ?? 0,
                'bill_50' => $expenses->bill_50 ?? 0,
                'bill_20' => $expenses->bill_20 ?? 0,
                'bill_10' => $expenses->bill_10 ?? 0,
                'coin_5' => $expenses->coin_5 ?? 0,
                'coin_2' => $expenses->coin_2 ?? 0,
                'coin_1' => $expenses->coin_1 ?? 0,
                'coin_0_5' => $expenses->coin_0_5 ?? 0,
                'coin_0_2' => $expenses->coin_0_2 ?? 0,
                'coin_0_1' => $expenses->coin_0_1 ?? 0,
                'physical_cash' => $expenses->physical_cash ?? 0,
                'digital_cash' => $expenses->digital_cash ?? 0,
                'total' => $expenses->total ?? 0,
            ]);
            $cashshift->update([
                'expenses_balance' => $denomination->total,
                'expenses_uuid' => $denomination->denomination_uuid,
            ]);
        }

        if ($cashshift->denominations_physical) {
            $physical = $cashshift->denominations_physical;
        }else {
            $total_physical = [
                'bill_200' => 0,
                'bill_100' => 0,
                'bill_50' => 0,
                'bill_20' => 0,
                'bill_10' => 0,
                'coin_5' => 0,
                'coin_2' => 0,
                'coin_1' => 0,
                'coin_0_5' => 0,
                'coin_0_2' => 0,
                'coin_0_1' => 0,
                'physical_cash' => number_format(0, 2, '.', ''),
                'digital_cash' => number_format(0, 2, '.', ''),
                'total' => number_format(0, 2, '.', ''),
            ];
            $physical = $total_physical;
        }

        $difference = $this->difference($cashshift_uuid);
        if ($cashshift->denominations_difference) {
            $denomination = $cashshift->denominations_difference;
            $denomination->update([
                'bill_200' => $difference['bill_200'] ?? 0,
                'bill_100' => $difference['bill_100'] ?? 0,
                'bill_50' => $difference['bill_50'] ?? 0,
                'bill_20' => $difference['bill_20'] ?? 0,
                'bill_10' => $difference['bill_10'] ?? 0,
                'coin_5' => $difference['coin_5'] ?? 0,
                'coin_2' => $difference['coin_2'] ?? 0,
                'coin_1' => $difference['coin_1'] ?? 0,
                'coin_0_5' => $difference['coin_0_5'] ?? 0,
                'coin_0_2' => $difference['coin_0_2'] ?? 0,
                'coin_0_1' => $difference['coin_0_1'] ?? 0,
                'physical_cash' => $difference['physical_cash'] ?? 0,
                'digital_cash' => $difference['digital_cash'] ?? 0,
                'total' => $difference['total'] ?? 0,
            ]);
            $cashshift->update([
                'difference_balance' => $denomination->total,
            ]);
        } else {
            $denomination = Denomination::create([
                'type' => 8,
                'bill_200' => $difference['bill_200'] ?? 0,
                'bill_100' => $difference['bill_100'] ?? 0,
                'bill_50' => $difference['bill_50'] ?? 0,
                'bill_20' => $difference['bill_20'] ?? 0,
                'bill_10' => $difference['bill_10'] ?? 0,
                'coin_5' => $difference['coin_5'] ?? 0,
                'coin_2' => $difference['coin_2'] ?? 0,
                'coin_1' => $difference['coin_1'] ?? 0,
                'coin_0_5' => $difference['coin_0_5'] ?? 0,
                'coin_0_2' => $difference['coin_0_2'] ?? 0,
                'coin_0_1' => $difference['coin_0_1'] ?? 0,
                'physical_cash' => $difference['physical_cash'] ?? 0,
                'digital_cash' => $difference['digital_cash'] ?? 0,
                'total' => $difference['total'] ?? 0,
            ]);
            $cashshift->update([
                'difference_balance' => $denomination->total,
                'difference_uuid' => $denomination->denomination_uuid,
            ]);
        }
        return ['opening' => $opening,
            'closing' => $closing,
            'incomes' => $incomes->toArray(),
            'expenses' => $expenses->toArray(),
            'physical' => $physical,
            'difference' => $difference];
    }
    public function closing($cashshift_uuid, $opening)
    {
        $incomes = $this->incomes($cashshift_uuid);
        $expenses = $this->expenses($cashshift_uuid);
        $closing = [
            'bill_200' => ($opening->bill_200 ?? 0) + ($incomes->bill_200 ?? 0) - ($expenses->bill_200 ?? 0),
            'bill_100' => ($opening->bill_100 ?? 0) + ($incomes->bill_100 ?? 0) - ($expenses->bill_100 ?? 0),
            'bill_50' => ($opening->bill_50 ?? 0) + ($incomes->bill_50 ?? 0) - ($expenses->bill_50 ?? 0),
            'bill_20' => ($opening->bill_20 ?? 0) + ($incomes->bill_20 ?? 0) - ($expenses->bill_20 ?? 0),
            'bill_10' => ($opening->bill_10 ?? 0) + ($incomes->bill_10 ?? 0) - ($expenses->bill_10 ?? 0),
            'coin_5' => ($opening->coin_5 ?? 0) + ($incomes->coin_5 ?? 0) - ($expenses->coin_5 ?? 0),
            'coin_2' => ($opening->coin_2 ?? 0) + ($incomes->coin_2 ?? 0) - ($expenses->coin_2 ?? 0),
            'coin_1' => ($opening->coin_1 ?? 0) + ($incomes->coin_1 ?? 0) - ($expenses->coin_1 ?? 0),
            'coin_0_5' => ($opening->coin_0_5 ?? 0) + ($incomes->coin_0_5 ?? 0) - ($expenses->coin_0_5 ?? 0),
            'coin_0_2' => ($opening->coin_0_2 ?? 0) + ($incomes->coin_0_2 ?? 0) - ($expenses->coin_0_2 ?? 0),
            'coin_0_1' => ($opening->coin_0_1 ?? 0) + ($incomes->coin_0_1 ?? 0) - ($expenses->coin_0_1 ?? 0),
            'physical_cash' => number_format(($opening->physical_cash ?? 0) + ($incomes->physical_cash ?? 0) - ($expenses->physical_cash ?? 0), 2, '.', ''),
            'digital_cash' => number_format(($opening->digital_cash ?? 0) + ($incomes->digital_cash ?? 0) - ($expenses->digital_cash ?? 0), 2, '.', ''),
            'total' => number_format(($opening->total ?? 0) + ($incomes->total ?? 0) - ($expenses->total ?? 0), 2, '.', '')
        ];
        return $closing;
    }
    public function incomes($cashshift_uuid)
    {
        $incomes = Denomination::leftJoin('paymentwithoutprices', 'denominations.denomination_uuid', '=', 'paymentwithoutprices.denomination_uuid')
            ->leftJoin('paymentwithprices', 'denominations.denomination_uuid', '=', 'paymentwithprices.denomination_uuid')
            ->leftJoin('sales', 'denominations.denomination_uuid', '=', 'sales.denomination_uuid')
            ->whereNull('denominations.deleted_at')
            ->where('denominations.type', 1)
            ->where(function ($query) use ($cashshift_uuid) {
                $query->where('paymentwithoutprices.cashshift_uuid', $cashshift_uuid)
                    ->orWhere('paymentwithprices.cashshift_uuid', $cashshift_uuid)
                    ->orWhere('sales.cashshift_uuid', $cashshift_uuid);
            })
            ->selectRaw('
        COALESCE(SUM(denominations.bill_200), 0) as bill_200,
        COALESCE(SUM(denominations.bill_100), 0) as bill_100,
        COALESCE(SUM(denominations.bill_50), 0) as bill_50,
        COALESCE(SUM(denominations.bill_20), 0) as bill_20,
        COALESCE(SUM(denominations.bill_10), 0) as bill_10,
        COALESCE(SUM(denominations.coin_5), 0) as coin_5,
        COALESCE(SUM(denominations.coin_2), 0) as coin_2,
        COALESCE(SUM(denominations.coin_1), 0) as coin_1,
        COALESCE(SUM(denominations.coin_0_5), 0) as coin_0_5,
        COALESCE(SUM(denominations.coin_0_2), 0) as coin_0_2,
        COALESCE(SUM(denominations.coin_0_1), 0) as coin_0_1,
        COALESCE(SUM(denominations.physical_cash), 0) as physical_cash,
        COALESCE(SUM(denominations.digital_cash), 0) as digital_cash,
        COALESCE(SUM(denominations.total), 0) as total
    ')->firstOrFail();
        return $incomes;
    }
    public function expenses($cashshift_uuid)
    {
        $expenses = Denomination::join('expenses', 'denominations.denomination_uuid', '=', 'expenses.denomination_uuid')
            ->whereNull('denominations.deleted_at')
            ->where('denominations.type', 2)
            ->where('expenses.cashshift_uuid', $cashshift_uuid)
            ->selectRaw('
        COALESCE(SUM(denominations.bill_200), 0) as bill_200,
        COALESCE(SUM(denominations.bill_100), 0) as bill_100,
        COALESCE(SUM(denominations.bill_50), 0) as bill_50,
        COALESCE(SUM(denominations.bill_20), 0) as bill_20,
        COALESCE(SUM(denominations.bill_10), 0) as bill_10,
        COALESCE(SUM(denominations.coin_5), 0) as coin_5,
        COALESCE(SUM(denominations.coin_2), 0) as coin_2,
        COALESCE(SUM(denominations.coin_1), 0) as coin_1,
        COALESCE(SUM(denominations.coin_0_5), 0) as coin_0_5,
        COALESCE(SUM(denominations.coin_0_2), 0) as coin_0_2,
        COALESCE(SUM(denominations.coin_0_1), 0) as coin_0_1,
        COALESCE(SUM(denominations.physical_cash), 0) as physical_cash,
        COALESCE(SUM(denominations.digital_cash), 0) as digital_cash,
        COALESCE(SUM(denominations.total), 0) as total
    ')->firstOrFail();
        return $expenses;
    }
    public function difference ($cashshift_uuid){
        $cashshift = Cashshift::where('cashshift_uuid', $cashshift_uuid)
            ->with(['denominations_opening', 'denominations_closing', 'denominations_incomes', 'denominations_expenses', 'denominations_physical', 'denominations_difference'])->first();
        $physical = $cashshift->denominations_physical;
        $closing = $cashshift->denominations_closing;
        $difference = [
            'bill_200' => ($physical->bill_200 ?? 0) - ($closing->bill_200 ?? 0),
            'bill_100' => ($physical->bill_100 ?? 0) - ($closing->bill_100 ?? 0),
            'bill_50' => ($physical->bill_50 ?? 0) - ($closing->bill_50 ?? 0),
            'bill_20' => ($physical->bill_20 ?? 0) - ($closing->bill_20 ?? 0),
            'bill_10' => ($physical->bill_10 ?? 0) - ($closing->bill_10 ?? 0),
            'coin_5' => ($physical->coin_5 ?? 0) - ($closing->coin_5 ?? 0),
            'coin_2' => ($physical->coin_2 ?? 0) - ($closing->coin_2 ?? 0),
            'coin_1' => ($physical->coin_1 ?? 0) - ($closing->coin_1 ?? 0),
            'coin_0_5' => ($physical->coin_0_5 ?? 0) - ($closing->coin_0_5 ?? 0),
            'coin_0_2' => ($physical->coin_0_2 ?? 0) - ($closing->coin_0_2 ?? 0),
            'coin_0_1' => ($physical->coin_0_1 ?? 0) - ($closing->coin_0_1 ?? 0),
            'physical_cash' => number_format(($physical->physical_cash ?? 0) - ($closing->physical_cash ?? 0), 2, '.', ''),
            'digital_cash' => number_format(($physical->digital_cash ?? 0) - ($closing->digital_cash ?? 0), 2, '.', ''),
            'total' => number_format(($physical->total ?? 0) - ($closing->total ?? 0), 2, '.', ''),
        ];
        return $difference;
    }
}
