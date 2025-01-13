<?php

namespace App\Http\Controllers;

use App\Models\Bankregister;
use App\Models\Cashcount;
use App\Models\Cashflowdaily;
use App\Models\Cashregister;
use App\Models\Cashshift;
use App\Models\Category;
use App\Models\Denomination;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Method;
use App\Models\Paymentwithoutprice;
use App\Models\Paymentwithprice;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Service;
use App\Models\Servicewithoutprice;
use App\Models\Servicewithprice;
use App\Models\Transaction;
use App\Models\Transactionmethod;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Constraint\IsEmpty;

class DashboardController extends Controller
{
    public function index()
    {
        $total_users = User::count();
        $total_categories = Category::count();
        $total_services = Service::count();
        $total_methods = Method::count();
        $total_incomes = Income::count();
        $total_incomes_by_user = Income::where("user_id", Auth::id())->count();
        $total_cashregisters = Cashregister::count();
        $total_cashshifts = Cashshift::count();
        $total_cashshifts_by_user = Cashshift::where("user_id", Auth::id())->count();
        $total_expenses = Expense::count();
        $total_expenses_by_user = Expense::where("user_id", Auth::id())->count();
        $total_products = Product::count();
        $total_sales = Sale::count();
        $total_sales_by_user = Sale::where("user_id", Auth::id())->count();
        $cashshift = Cashshift::where('user_id', Auth::id())->where('status', '1')->first();
        $cashregister_name = Cashshift::join('denominations', 'denominations.reference_uuid', '=', 'cashshifts.cashshift_uuid')
            ->join('cashregisters', 'cashregisters.cashregister_uuid', '=', 'denominations.cashregister_uuid')
            ->where('cashshifts.user_id', Auth::id())->where('cashshifts.status', '1')->value('cashregisters.name');
        $cashshifts = Cashshift::where('status', '1')->orderBy('created_at', 'asc')->get();
        $products_and_quantities = Product::select('name', 'stock', 'price')->get();
        //$methods = Transaction::select('total as name', 'total as balance')->get();
        $total_bankregisters = Bankregister::count();
/*

        $opening_bank = Transaction::where('reference_uuid', $cashshift->cashshift_uuid)->first();
        $incomes_bank = Transaction::join('bankregisters', 'transactions.bankregister_uuid', '=', 'bankregisters.bankregister_uuid')
            ->whereNull('transactions.deleted_at')
            ->where('transactions.type', 3)
            ->groupBy('transactions.bankregister_uuid', 'bankregisters.name')
            ->selectRaw('COALESCE(SUM(transactions.total), 0) as total, bankregisters.name as name')
            ->get()->toArray();
        $expenses_bank = Transaction::join('bankregisters', 'transactions.bankregister_uuid', '=', 'bankregisters.bankregister_uuid')
            ->whereNull('transactions.deleted_at')
            ->where('transactions.type', 4)
            ->groupBy('transactions.bankregister_uuid', 'bankregisters.name')
            ->selectRaw('COALESCE(SUM(transactions.total), 0) as total, bankregisters.name as name')
            ->get()->toArray();
        $name_banks = Bankregister::pluck('name')->toArray();
        $name = [];
        $credit = [];
        $debit = [];
        $total = [];
        foreach ($expenses_bank as $item){
            foreach ($item as $key => $value){
                if ($key)
                dd($key);
            }
        }

        dd($expenses_bank);
*/

        if (auth()->user()->hasRole('Administrador')) {
            return view('dashboard', compact('total_users', 'total_categories', 'total_services', 'total_methods', 'total_incomes', 'total_cashregisters', 'total_cashshifts', 'total_cashshifts_by_user', 'total_expenses', 'total_products', 'total_sales', 'cashshifts', 'products_and_quantities', 'total_bankregisters', 'cashregister_name'));
        } else {
            return view('dashboard-user', compact('total_services', 'total_incomes_by_user', 'total_cashshifts_by_user', 'total_expenses_by_user', 'total_products', 'total_sales_by_user', 'cashshift', 'products_and_quantities', 'cashregister_name'));
        }
    }

    /*SEARCH DATE*/
    public function search(Request $request)
    {
        //$date = $request->query('date');
        //dd($date);
        return redirect("/dashboard")->with('success', 'procesando ...');
    }

    /*ESTADO DE SESION*/
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

    public function one_sesion($cashshift_uuid)
    {
        $cashshift = Cashshift::where('cashshift_uuid', $cashshift_uuid)->first();
        if ($cashshift) {
            $data = $this->show($cashshift->cashshift_uuid);
            //DETALLES DE INGRESOS Y EGRESOS DE SESION
            $session_incomes_detail = $this->session_incomes($cashshift);
            $session_sales_detail = $this->session_sales($cashshift);
            $session_expenses_detail = $this->session_expenses($cashshift);
        } else {
            $data = false;
            $session_incomes_detail = false;
            $session_sales_detail = false;
            $session_expenses_detail = false;
        }
        if (request()->ajax()) {
            $view = view('aside', compact('data', 'session_incomes_detail', 'session_sales_detail', 'session_expenses_detail'))->render();
            return response()->json(['html' => $view]);
        }
        return redirect("/dashboard")->with('success', 'Datos actualizados con éxito.');

    }

    public function all_sesions()
    {
        //EFECTIVO SESIONES
        $cashshifts = Cashshift::where('status', '1')->orderBy('created_at', 'asc')->get();
        $array_data = [];
        if (!$cashshifts->isEmpty()) {
            foreach ($cashshifts as $item) {
                $array_data[] = $this->show($item->cashshift_uuid);
            }
            $data = $this->total_show($array_data);
            //DETALLES DE INGRESOS Y EGRESOS DE SESIONES
            $array_session_incomes_detail = [];
            $array_session_sales_detail = [];
            $array_session_expenses_detail = [];
            foreach ($cashshifts as $item) {
                $array_session_incomes_detail[] = $this->session_incomes($item);
                $array_session_sales_detail[] = $this->session_sales($item);
                $array_session_expenses_detail[] = $this->session_expenses($item);
            }
            $session_incomes_detail = $this->sessions_incomes_expenses_detail($array_session_incomes_detail);
            $session_sales_detail = $this->sessions_incomes_expenses_detail($array_session_sales_detail);
            $session_expenses_detail = $this->sessions_incomes_expenses_detail($array_session_expenses_detail);
        } else {
            $data = false;
            $session_incomes_detail = false;
            $session_sales_detail = false;
            $session_expenses_detail = false;
        }
        if (request()->ajax()) {
            $view = view('aside', compact('data', 'session_incomes_detail','session_sales_detail', 'session_expenses_detail'))->render();
            return response()->json(['html' => $view]);
        }
        return redirect("/dashboard")->with('success', 'Datos actualizados con éxito.');

    }

    /*INGRESOS Y EGRESOS DETALLES SESIONES*/
    public function sessions_incomes_expenses_detail($array_details)
    {
        $data_details = [];
        foreach ($array_details as $data) {
            foreach ($data as $key => $value) {
                if (!isset($data_details[$key])) {
                    $data_details[$key] = (object)[
                        'name' => '',
                        'amount' => 0.00,
                        'commission' => 0.00,
                        'quantity' => 0,
                        'total' => 0
                    ];
                }
                $data_details[$key]->name = $value->name;
                $data_details[$key]->amount += $value->amount ?? 0;
                $data_details[$key]->commission += $value->commission ?? 0;
                $data_details[$key]->quantity += $value->quantity ?? 0;
                $data_details[$key]->total += $value->total ?? 0;
            }
        }
        return $data_details;
    }

    /*INGRESOS Y EGRESOS DETALLES SESION*/
    public function session_incomes($cashshift)
    {
        $incomes = Income::where('cashshift_uuid', $cashshift->cashshift_uuid)->select('service_uuids', 'amounts', 'commissions', 'quantities')->get();
        if (!$incomes->isEmpty()) {
            $array_name = [];
            $array_amount = [];
            $array_commission = [];
            $array_quantities = [];
            foreach ($incomes as $income) {
                foreach ($income->toArray() as $key => $item) {
                    foreach ($item as $value) {
                        if ($key == 'service_uuids') $array_name[] = Service::where('service_uuid', $value)->value('name');
                        if ($key == 'quantities') $array_quantities[] = $value;
                        if ($key == 'amounts') $array_amount[] = $value;
                        if ($key == 'commissions') $array_commission[] = $value;
                    }
                }
            }
            return $this->count_details($array_name, $array_amount, $array_commission, $array_quantities);
        } else {
            return [];
        }
    }
    public function session_sales($cashshift)
    {
        $sales = Sale::where('cashshift_uuid', $cashshift->cashshift_uuid)->select('product_uuids', 'quantities')->get();
        if (!$sales->isEmpty()) {
            $array_name = [];
            $array_amount = [];
            $array_commission = [];
            $array_quantities = [];
            foreach ($sales as $sale) {
                foreach ($sale->toArray() as $key => $item) {
                    foreach ($item as $value) {
                        if ($key == 'product_uuids') {
                            $product = Product::where('product_uuid', $value)->select('name', 'price')->firstorfail();
                            $array_name[] = $product->name;
                            $array_amount[] = $product->price;
                            $array_commission[] = 0;
                        }
                        if ($key == 'quantities') $array_quantities[] = $value;
                    }
                }
            }
            return $this->count_details($array_name, $array_amount, $array_commission, $array_quantities);
        } else {
            return [];
        }
    }

    public function session_expenses($cashshift)
    {
        $expenses = Expense::where('cashshift_uuid', $cashshift->cashshift_uuid)->select('category_uuid', 'amount')->get();
        if (!$expenses->isEmpty()) {
            $array_name = [];
            $array_amount = [];
            $array_commission = [];
            $array_quantities = [];
            foreach ($expenses as $expense) {
                foreach ($expense->toArray() as $key => $value) {
                    if ($key == 'category_uuid') {
                        $category = Category::where('category_uuid', $value)->select('name')->firstorfail();
                        $array_name[] = $category->name;
                        $array_commission[] = 0;
                        $array_quantities[] = 1;
                    }
                    if ($key == 'amount') $array_amount[] = $value;
                }
            }
            return $this->count_details($array_name, $array_amount, $array_commission, $array_quantities);
        } else {
            return [];
        }
    }

    public function count_details($array_name, $array_amount, $array_commission, $array_quantities)
    {
        $array_payment = [];
        foreach ($array_name as $key => $value) {
            if (!isset($array_payment[$value])) {
                $array_payment[$value] = (object)[
                    'name' => '',
                    'amount' => 0.00,
                    'commission' => 0.00,
                    'quantity' => 0,
                    'total' => 0,
                ];
            }
            $array_payment[$value]->name = $value;
            $array_payment[$value]->amount += (float)$array_amount[$key] * $array_quantities[$key];
            $array_payment[$value]->commission += (float)$array_commission[$key] * $array_quantities[$key];
            $array_payment[$value]->quantity += (int)$array_quantities[$key];
            $array_payment[$value]->total += (float)($array_amount[$key] * $array_quantities[$key]) + ($array_commission[$key] * $array_quantities[$key]);
        }
        return $array_payment;
    }

    /*INGRESOS Y EGRESOS EFECTIVO SESION*/
    public function show(string $cashshift_uuid)
    {
        $cashshift = Cashshift::where('user_id', Auth::id())->where('status', '1')->first();
        $opening = Denomination::where('reference_uuid', $cashshift_uuid)->first();
        $closing = $this->closing($cashshift_uuid, $opening);
        $incomes = $this->incomes($cashshift_uuid);
        $expenses = $this->expenses($cashshift_uuid);
        return ['opening' => $opening,
            'closing' => $closing,
            'incomes' => $incomes,
            'expenses' => $expenses];
    }

    public function closing($cashshift_uuid, $opening)
    {
        $incomes = $this->incomes($cashshift_uuid);
        $expenses = $this->expenses($cashshift_uuid);
        $closing = (object)[
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
            'total' => number_format(($opening->total ?? 0) + ($incomes->total ?? 0) - ($expenses->total ?? 0), 2)
        ];
        return $closing;
    }

    public function incomes($cashshift_uuid)
    {
        $incomes = Denomination::leftJoin('incomes', 'denominations.reference_uuid', '=', 'incomes.income_uuid')
            ->leftJoin('sales', 'denominations.reference_uuid', '=', 'sales.sale_uuid')
            ->whereNull('denominations.deleted_at')
            ->where('denominations.type', 3)
            ->where(function ($query) use ($cashshift_uuid) {
                $query->where('incomes.cashshift_uuid', $cashshift_uuid)
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
        COALESCE(SUM(denominations.total), 0) as total
    ')->firstOrFail();
        return $incomes;
    }

    public function expenses($cashshift_uuid)
    {
        $expenses = Denomination::join('expenses', 'denominations.reference_uuid', '=', 'expenses.expense_uuid')
            ->whereNull('denominations.deleted_at')
            ->where('denominations.type', 4)
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
        COALESCE(SUM(denominations.total), 0) as total
    ')->firstOrFail();
        return $expenses;
    }
/*
    public function difference($cashshift_uuid)
    {
        $cashshift = Cashshift::where('cashshift_uuid', $cashshift_uuid)->first();
        $physical = Denomination::where('reference_uuid', $cashshift_uuid)->where('type', 5)->first();
        $closing = $cashshift->denominations_closing;
        $difference = (object)[
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
*/
    /*INGRESOS Y EGRESOS EFECTIVO SESIONES*/
    public function total_show($array_data)
    {
        $totals = [];
        foreach ($array_data as $data) {
            foreach ($data as $key => $item) {
                if (!isset($totals[$key])) {
                    $totals[$key] = (object)[
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
                        'total' => number_format(0, 2),
                    ];
                }
                $totals[$key]->bill_200 += $item->bill_200 ?? 0;
                $totals[$key]->bill_100 += $item->bill_100 ?? 0;
                $totals[$key]->bill_50 += $item->bill_50 ?? 0;
                $totals[$key]->bill_20 += $item->bill_20 ?? 0;
                $totals[$key]->bill_10 += $item->bill_10 ?? 0;
                $totals[$key]->coin_5 += $item->coin_5 ?? 0;
                $totals[$key]->coin_2 += $item->coin_2 ?? 0;
                $totals[$key]->coin_1 += $item->coin_1 ?? 0;
                $totals[$key]->coin_0_5 += $item->coin_0_5 ?? 0;
                $totals[$key]->coin_0_2 += $item->coin_0_2 ?? 0;
                $totals[$key]->coin_0_1 += $item->coin_0_1 ?? 0;
                $totals[$key]->total += $item->total ?? 0;
            }
        }
        return $totals;
    }
}
