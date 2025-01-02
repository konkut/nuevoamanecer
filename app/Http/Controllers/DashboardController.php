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
use PHPUnit\Framework\Constraint\IsEmpty;

class DashboardController extends Controller
{
    public function index()
    {
        $total_users = User::count();
        $total_categories = Category::count();
        $total_services = Servicewithoutprice::count() + Servicewithprice::count();
        $total_transactionmethods = Transactionmethod::count();
        $total_payments = Paymentwithprice::count() + Paymentwithoutprice::count();
        $total_payments_by_user = Paymentwithprice::where("user_id", Auth::id())->count() + Paymentwithoutprice::where("user_id", Auth::id())->count();
        $total_cashregisters = Cashregister::count();
        $total_cashshifts = Cashshift::count();
        $total_cashshifts_by_user = Cashshift::where("user_id", Auth::id())->count();
        $total_expenses = Expense::count();
        $total_expenses_by_user = Expense::where("user_id", Auth::id())->count();
        $total_cashflowdailies = Cashflowdaily::count();
        $total_products = Product::count();
        $total_sales = Sale::count();
        $total_sales_by_user = Sale::where("user_id", Auth::id())->count();
        $cashshift = Cashshift::where('user_id', Auth::id())->where('status', '1')->with('cashregister')->first();
        $cashshifts = Cashshift::where('status', '1')->with('cashregister')->orderBy('created_at', 'asc')->get();
        $products_and_quantities = Product::select('name','stock','price')->get();
        $methods = Transactionmethod::select('name','balance')->get();

        if (auth()->user()->hasRole('Administrador')){
            return view('dashboard', compact('total_users', 'total_categories', 'total_services', 'total_transactionmethods', 'total_payments', 'total_payments_by_user', 'total_cashregisters', 'total_cashshifts', 'total_cashshifts_by_user', 'total_cashflowdailies', 'total_expenses', 'total_products', 'total_sales', 'cashshifts','products_and_quantities','methods'));
        }else{
            return view('dashboard-user', compact('total_services', 'total_payments_by_user', 'total_cashshifts_by_user', 'total_expenses_by_user', 'total_products', 'total_sales_by_user', 'cashshift','products_and_quantities','methods'));
        }
    }

    /*SEARCH DATE*/
    public function search(Request $request){
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
        $cashshift = Cashshift::with(['user', 'cashregister'])->where('cashshift_uuid', $cashshift_uuid)->first();
        if ($cashshift) {
            $data = $this->show($cashshift->cashshift_uuid);

            //DIGITALES SESION
            $total_session_income_expense = $this->session_incomes_expenses($cashshift);
            $session_incomes_digital = $total_session_income_expense['session_incomes_digital'];
            $session_expenses_digital = $total_session_income_expense['session_expenses_digital'];

            //DETALLES DE INGRESOS Y EGRESOS DE SESION
            $session_payment_without_prices_detail = $this->session_payment_without_prices($cashshift);
            $session_payment_with_prices_detail = $this->session_payment_with_prices($cashshift);
            $session_sales_detail = $this->session_sales($cashshift);
            $session_expenses_detail = $this->session_expenses($cashshift);

        } else {
            $data = false;
            $session_incomes_digital = false;
            $session_expenses_digital = false;
            $session_payment_without_prices_detail = false;
            $session_payment_with_prices_detail = false;
            $session_sales_detail = false;
            $session_expenses_detail = false;
        }
        if (request()->ajax()) {
            $view = view('aside', compact('data','session_incomes_digital','session_expenses_digital','session_payment_without_prices_detail','session_payment_with_prices_detail','session_sales_detail','session_expenses_detail'))->render();
            return response()->json(['html' => $view]);
        }
        return redirect("/dashboard")->with('success', 'Datos actualizados con éxito.');

    }

    public function all_sesions()
    {
        //EFECTIVO SESIONES
        $cashshifts = Cashshift::where('status', '1')->with('cashregister')->orderBy('created_at', 'asc')->get();
        $array_data = [];
        if (!$cashshifts->isEmpty()) {
            foreach ($cashshifts as $item) {
                $array_data[] = $this->show($item->cashshift_uuid);
            }
            $data = $this->total_show($array_data);

            //DIGITAL SESIONES
            $array_sessions_incomes_expenses = [];
            foreach ($cashshifts as $item) {
                $array_sessions_incomes_expenses[] = $this->session_incomes_expenses($item);
            }
            $total_sessions_incomes_expenses = $this->sessions_incomes_expenses($array_sessions_incomes_expenses);
            $session_incomes_digital = $total_sessions_incomes_expenses['sessions_incomes_digital'];
            $session_expenses_digital = $total_sessions_incomes_expenses['sessions_expenses_digital'];

            //DETALLES DE INGRESOS Y EGRESOS DE SESIONES
            $array_session_payment_without_prices_detail = [];
            $array_session_payment_with_prices_detail = [];
            $array_session_sales_detail = [];
            $array_session_expenses_detail = [];
            foreach ($cashshifts as $item) {
                $array_session_payment_without_prices_detail[] = $this->session_payment_without_prices($item);
                $array_session_payment_with_prices_detail[] = $this->session_payment_with_prices($item);
                $array_session_sales_detail[] = $this->session_sales($item);
                $array_session_expenses_detail[] = $this->session_expenses($item);
            }
            $session_payment_without_prices_detail = $this->sessions_incomes_expenses_detail($array_session_payment_without_prices_detail);
            $session_payment_with_prices_detail = $this->sessions_incomes_expenses_detail($array_session_payment_with_prices_detail);
            $session_sales_detail = $this->sessions_incomes_expenses_detail($array_session_sales_detail);
            $session_expenses_detail = $this->sessions_incomes_expenses_detail($array_session_expenses_detail);
        } else {
            $data = false;
            $session_incomes_digital = false;
            $session_expenses_digital = false;
            $session_payment_without_prices_detail = false;
            $session_payment_with_prices_detail = false;
            $session_sales_detail = false;
            $session_expenses_detail = false;
        }
        if (request()->ajax()) {
            $view = view('aside', compact('data','session_incomes_digital','session_expenses_digital','session_payment_without_prices_detail','session_payment_with_prices_detail','session_sales_detail','session_expenses_detail'))->render();
            return response()->json(['html' => $view]);
        }
        return redirect("/dashboard")->with('success', 'Datos actualizados con éxito.');

    }

    /*INGRESOS Y EGRESOS DETALLES SESIONES*/
    public function sessions_incomes_expenses_detail($array_details){
        $data_details = [];
        foreach ($array_details as $data) {
            foreach ($data as $key => $value) {
                if (!isset($data_details[$key])){
                    $data_details[$key] = (object)[
                        'name'=> '',
                        'amount'=>0.00,
                        'commission'=>0.00,
                        'quantity'=>0,
                        'total'=>0
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
    public function session_payment_without_prices($cashshift){
        $paymentwithoutprices = Paymentwithoutprice::where('cashshift_uuid', $cashshift->cashshift_uuid)
            ->select('servicewithprice_uuids','quantities')->get();
        if (!$paymentwithoutprices->isEmpty()) {
            $array_name = [];
            $array_amount = [];
            $array_commission = [];
            $array_quantities = [];
            foreach ($paymentwithoutprices as $paymentwithoutprice) {
                foreach ($paymentwithoutprice->toArray() as $key => $item) {
                    foreach ($item as $value) {
                        if ($key == 'servicewithprice_uuids') {
                            $service = Servicewithprice::where('servicewithprice_uuid', $value)->select('name', 'amount', 'commission')->firstorfail();
                            $array_name[] = $service->name;
                            $array_amount[] = $service->amount;
                            $array_commission[] = $service->commission;
                        }
                        if ($key == 'quantities') {
                            $array_quantities[] = $value;
                        }
                    }
                }
            }
            return $this->count_details($array_name,$array_amount,$array_commission,$array_quantities);
        }else{
            return [];
        }
    }
    public function session_payment_with_prices($cashshift){
        $paymentwithprices = Paymentwithprice::where('cashshift_uuid', $cashshift->cashshift_uuid)
            ->select('servicewithoutprice_uuids','amounts','commissions')->get();
        if (!$paymentwithprices->isEmpty()) {
            $array_name = [];
            $array_amount = [];
            $array_commission = [];
            $array_quantities = [];
            foreach ($paymentwithprices as $paymentwithprice) {
                foreach ($paymentwithprice->toArray() as $key => $item) {
                    foreach ($item as $value) {
                        if ($key == 'servicewithoutprice_uuids') {
                            $service = Servicewithoutprice::where('servicewithoutprice_uuid', $value)->select('name')->firstorfail();
                            $array_name[] = $service->name;
                            $array_quantities[] = 1;
                        }
                        if ($key == 'amounts') {
                            $array_amount[] = $value ?? 0;
                        }
                        if ($key == 'commissions') {
                            $array_commission[] = $value ?? 0;
                        }
                    }
                }
            }
            return $this->count_details($array_name,$array_amount,$array_commission,$array_quantities);
        }else{
            return [];
        }
    }
    public function session_sales($cashshift){
        $sales = Sale::where('cashshift_uuid', $cashshift->cashshift_uuid)
            ->select('product_uuids','quantities')->get();
        if (!$sales->isEmpty()) {
            $array_name = [];
            $array_amount = [];
            $array_commission = [];
            $array_quantities = [];
            foreach ($sales as $sale) {
                foreach ($sale->toArray() as $key => $item) {
                    foreach ($item as $value) {
                        if ($key == 'product_uuids') {
                            $product = Product::where('product_uuid', $value)->select('name', 'price', 'stock')->firstorfail();
                            $array_name[] = $product->name;
                            $array_amount[] = $product->price;
                            $array_commission[] = 0;
                        }
                        if ($key == 'quantities') {
                            $array_quantities[] = $value;
                        }
                    }
                }
            }
            return $this->count_details($array_name,$array_amount,$array_commission,$array_quantities);
        }else{
            return [];
        }
    }
    public function session_expenses($cashshift){
        $expenses = Expense::where('cashshift_uuid', $cashshift->cashshift_uuid)
            ->select('category_uuid','amount')->get();
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
                        if ($key == 'amount') {
                            $array_amount[] = $value;
                        }

                }
            }
            return $this->count_details($array_name,$array_amount,$array_commission,$array_quantities);
        }else{
            return [];
        }
    }
    public function count_details($array_name,$array_amount,$array_commission,$array_quantities){
        $array_payment=[];
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
            $array_payment[$value]->amount += (float) $array_amount[$key] * $array_quantities[$key];
            $array_payment[$value]->commission += (float) $array_commission[$key] * $array_quantities[$key];
            $array_payment[$value]->quantity += (int) $array_quantities[$key];
            $array_payment[$value]->total += (float) ($array_amount[$key] * $array_quantities[$key])+($array_commission[$key] * $array_quantities[$key]);
        }
        return $array_payment;
    }

    /*INGRESOS Y EGRESOS DIGITALES SESION*/
    public function session_incomes_expenses($cashshift) {
        $session_incomes_digital = [];
        $session_expenses_digital = [];
        if ($cashshift){
            $sales_digital = $this->sales_digital($cashshift->cashshift_uuid);
            $paymentwithoutprices_digital = $this->paymentwithoutprices_digital($cashshift->cashshift_uuid);
            $paymentwithprices_digital = $this->paymentwithprices_digital($cashshift->cashshift_uuid);
            $expenses_digital = $this->expenses_digital($cashshift->cashshift_uuid);

            $this->income_digital($sales_digital, $session_incomes_digital);
            $this->income_digital($paymentwithoutprices_digital, $session_incomes_digital);
            $this->income_digital($paymentwithprices_digital, $session_incomes_digital);

            foreach ($expenses_digital as $method => $details) {
                if (!isset($session_expenses_digital[$method])) {
                    $session_expenses_digital[$method] = 0;
                }
                $session_expenses_digital[$method] += $details->amount;
            }
        }else{
            $session_incomes_digital = false;
            $session_expenses_digital = false;
        }
        return [
            'session_incomes_digital'=>$session_incomes_digital,
            'session_expenses_digital'=>$session_expenses_digital,
        ];
    }
    public function sales_digital($cashshift_uuid)
    {
        $sales = Sale::where('cashshift_uuid', $cashshift_uuid)
            ->select('quantities', 'product_uuids', 'transactionmethod_uuids')
            ->get();
        $response_data = [];
        $quantities = [];
        $prices = [];
        $names = [];
        foreach ($sales as $sale) {
            foreach ($sale->toArray() as $key => $item) {
                foreach ($item as $value) {
                    if ($key === 'quantities') {
                        $quantities[] = $value ?? 0;
                    }
                    if ($key === 'product_uuids') {
                        $product = Product::where('product_uuid', $value)->select('price')->firstorfail();
                        $price = $product->price;
                        $prices[] = $price ?? 0;
                    }
                    if ($key === 'transactionmethod_uuids') {
                        $method = Transactionmethod::where('transactionmethod_uuid', $value)->select('name')->firstorfail();
                        $name = $method->name;
                        $names[] = $name;
                    }
                }
            }
        }
        foreach ($names as $key => $name) {
            if (!isset($response_data[$name])) {
                $response_data[$name] = (object)[
                    'amount' => 0,
                ];
            }
            $response_data[$name]->amount += number_format(($quantities[$key] * $prices[$key]) ?? 0, 2, '.', '');
        }
        return $response_data;
    }
    public function paymentwithoutprices_digital($cashshift_uuid)
    {
        $paymentwithoutprices = Paymentwithoutprice::where('cashshift_uuid', $cashshift_uuid)
            ->select('quantities', 'servicewithprice_uuids', 'transactionmethod_uuids')
            ->get();
        $response_data = [];
        $quantities = [];
        $prices = [];
        $names = [];
        foreach ($paymentwithoutprices as $paymentwithoutprice) {
            foreach ($paymentwithoutprice->toArray() as $key => $item) {
                foreach ($item as $value) {
                    if ($key === 'quantities') {
                        $quantities[] = $value ?? 0;
                    }
                    if ($key === 'servicewithprice_uuids') {
                        $servicewithprice = Servicewithprice::where('servicewithprice_uuid', $value)->select('amount', 'commission')->firstorfail();
                        $price = $servicewithprice->amount + $servicewithprice->commission;
                        $prices[] = $price ?? 0;
                    }
                    if ($key === 'transactionmethod_uuids') {
                        $method = Transactionmethod::where('transactionmethod_uuid', $value)->select('name')->firstorfail();
                        $name = $method->name;
                        $names[] = $name;
                    }
                }
            }
        }
        foreach ($names as $key => $name) {
            if (!isset($response_data[$name])) {
                $response_data[$name] = (object)[
                    'amount' => 0,
                ];
            }
            $response_data[$name]->amount += number_format(($quantities[$key] * $prices[$key]) ?? 0, 2, '.', '');
        }
        return $response_data;
    }
    public function paymentwithprices_digital($cashshift_uuid)
    {
        $paymentwithprices = Paymentwithprice::where('cashshift_uuid', $cashshift_uuid)
            ->select('amounts', 'commissions', 'transactionmethod_uuids')
            ->get();
        $response_data = [];
        $amounts = [];
        $commissions = [];
        $names = [];
        foreach ($paymentwithprices as $paymentwithprice) {
            foreach ($paymentwithprice->toArray() as $key => $item) {
                foreach ($item as $value) {
                    if ($key === 'amounts') {
                        $amounts[] = $value ?? 0;;
                    }
                    if ($key === 'commissions') {
                        $commissions[] = $value ?? 0;
                    }
                    if ($key === 'transactionmethod_uuids') {
                        $method = Transactionmethod::where('transactionmethod_uuid', $value)->select('name')->firstorfail();
                        $name = $method->name;
                        $names[] = $name;
                    }
                }
            }
        }

        foreach ($names as $key => $name) {
            if (!isset($response_data[$name])) {
                $response_data[$name] = (object)[
                    'amount' => 0,
                ];
            }
            $response_data[$name]->amount += number_format(($amounts[$key] + $commissions[$key]) ?? 0, 2, '.', '');
        }
        return $response_data;
    }
    public function expenses_digital($cashshift_uuid)
    {
        $expenses = Expense::where('cashshift_uuid', $cashshift_uuid)
            ->select('amount', 'transactionmethod_uuid')
            ->get();
        $response_data = [];
        $amounts = [];
        $names = [];
        foreach ($expenses as $expense) {
            foreach ($expense->toArray() as $key => $value) {
                if ($key === 'amount') {
                    $amounts[] = $value ?? 0;;
                }
                if ($key === 'transactionmethod_uuid') {
                    $method = Transactionmethod::where('transactionmethod_uuid', $value)->select('name')->firstorfail();
                    $name = $method->name;
                    $names[] = $name;
                }
            }
        }
        foreach ($names as $key => $name) {
            if (!isset($response_data[$name])) {
                $response_data[$name] = (object)[
                    'amount' => 0,
                ];
            }
            $response_data[$name]->amount += number_format($amounts[$key] ?? 0, 2, '.', '');
        }
        return $response_data;
    }
    public function income_digital($data, &$session_incomes_digital) {
        foreach ($data as $method => $details) {
            if (!isset($session_incomes_digital[$method])) {
                $session_incomes_digital[$method] = 0;
            }
            $session_incomes_digital[$method] += $details->amount;
        }
    }

    /*INGRESOS Y EGRESOS DIGITALES SESIONES*/
    function sessions_incomes_expenses($array_sessions_incomes_expenses){
        $sessions_incomes_digital = [];
        $sessions_expenses_digital = [];
        foreach ($array_sessions_incomes_expenses as $data) {
            foreach ($data as $key => $item) {
                if ($key === 'session_incomes_digital'){
                    foreach ($item as $name => $value) {
                        if (!isset($sessions_incomes_digital[$name])) $sessions_incomes_digital[$name] = 0;
                        $sessions_incomes_digital[$name] += $value ?? 0;
                    }
                }
                if ($key === 'session_expenses_digital'){
                    foreach ($item as $name => $value) {
                        if(!isset($sessions_expenses_digital[$name])) $sessions_expenses_digital[$name] = 0;
                        $sessions_expenses_digital[$name] += $value ?? 0;
                    }
                }
            }
        }
        return [
            'sessions_incomes_digital'=>$sessions_incomes_digital,
            'sessions_expenses_digital'=>$sessions_expenses_digital,
        ];
    }

    /*INGRESOS Y EGRESOS EFECTIVO SESION*/
    public function show(string $cashshift_uuid)
    {
        $cashshift = Cashshift::where('cashshift_uuid', $cashshift_uuid)
            ->with(['denominations_opening', 'denominations_closing', 'denominations_incomes', 'denominations_expenses', 'denominations_physical', 'denominations_difference'])->first();
        $opening = $cashshift->denominations_opening;

        $closing = $this->closing($cashshift_uuid, $opening);
        if ($cashshift->denominations_closing) {
            $denomination = $cashshift->denominations_closing;
            $denomination->update([
                'bill_200' => $closing->bill_200 ?? 0,
                'bill_100' => $closing->bill_100 ?? 0,
                'bill_50' => $closing->bill_50 ?? 0,
                'bill_20' => $closing->bill_20 ?? 0,
                'bill_10' => $closing->bill_10 ?? 0,
                'coin_5' => $closing->coin_5 ?? 0,
                'coin_2' => $closing->coin_2 ?? 0,
                'coin_1' => $closing->coin_1 ?? 0,
                'coin_0_5' => $closing->coin_0_5 ?? 0,
                'coin_0_2' => $closing->coin_0_2 ?? 0,
                'coin_0_1' => $closing->coin_0_1 ?? 0,
                'physical_cash' => $closing->physical_cash ?? 0,
                'digital_cash' => $closing->digital_cash ?? 0,
                'total' => $closing->total ?? 0,
            ]);
            $cashshift->update([
                'end_time' => now(),
                'closing_balance' => $denomination->total,
            ]);
        } else {
            $denomination = Denomination::create([
                'type' => 4,
                'bill_200' => $closing->bill_200 ?? 0,
                'bill_100' => $closing->bill_100 ?? 0,
                'bill_50' => $closing->bill_50 ?? 0,
                'bill_20' => $closing->bill_20 ?? 0,
                'bill_10' => $closing->bill_10 ?? 0,
                'coin_5' => $closing->coin_5 ?? 0,
                'coin_2' => $closing->coin_2 ?? 0,
                'coin_1' => $closing->coin_1 ?? 0,
                'coin_0_5' => $closing->coin_0_5 ?? 0,
                'coin_0_2' => $closing->coin_0_2 ?? 0,
                'coin_0_1' => $closing->coin_0_1 ?? 0,
                'physical_cash' => $closing->physical_cash ?? 0,
                'digital_cash' => $closing->digital_cash ?? 0,
                'total' => $closing->total ?? 0,
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
        } else {
            $total_physical = (object)[
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
                'bill_200' => $difference->bill_200 ?? 0,
                'bill_100' => $difference->bill_100 ?? 0,
                'bill_50' => $difference->bill_50 ?? 0,
                'bill_20' => $difference->bill_20 ?? 0,
                'bill_10' => $difference->bill_10 ?? 0,
                'coin_5' => $difference->coin_5 ?? 0,
                'coin_2' => $difference->coin_2 ?? 0,
                'coin_1' => $difference->coin_1 ?? 0,
                'coin_0_5' => $difference->coin_0_5 ?? 0,
                'coin_0_2' => $difference->coin_0_2 ?? 0,
                'coin_0_1' => $difference->coin_0_1 ?? 0,
                'physical_cash' => $difference->physical_cash ?? 0,
                'digital_cash' => $difference->digital_cash ?? 0,
                'total' => $difference->total ?? 0,
            ]);
            $cashshift->update([
                'difference_balance' => $denomination->total,
            ]);
        } else {
            $denomination = Denomination::create([
                'type' => 8,
                'bill_200' => $difference->bill_200 ?? 0,
                'bill_100' => $difference->bill_100 ?? 0,
                'bill_50' => $difference->bill_50 ?? 0,
                'bill_20' => $difference->bill_20 ?? 0,
                'bill_10' => $difference->bill_10 ?? 0,
                'coin_5' => $difference->coin_5 ?? 0,
                'coin_2' => $difference->coin_2 ?? 0,
                'coin_1' => $difference->coin_1 ?? 0,
                'coin_0_5' => $difference->coin_0_5 ?? 0,
                'coin_0_2' => $difference->coin_0_2 ?? 0,
                'coin_0_1' => $difference->coin_0_1 ?? 0,
                'physical_cash' => $difference->physical_cash ?? 0,
                'digital_cash' => $difference->digital_cash ?? 0,
                'total' => $difference->total ?? 0,
            ]);
            $cashshift->update([
                'difference_balance' => $denomination->total,
                'difference_uuid' => $denomination->denomination_uuid,
            ]);
        }
        return ['opening' => $opening,
            'closing' => $closing,
            'incomes' => $incomes,
            'expenses' => $expenses,
            'physical' => $physical,
            'difference' => $difference];
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

    public function difference($cashshift_uuid)
    {
        $cashshift = Cashshift::where('cashshift_uuid', $cashshift_uuid)
            ->with(['denominations_opening', 'denominations_closing', 'denominations_incomes', 'denominations_expenses', 'denominations_physical', 'denominations_difference'])->first();
        $physical = $cashshift->denominations_physical;
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
                        'physical_cash' => number_format(0, 2, '.', ''),
                        'digital_cash' => number_format(0, 2, '.', ''),
                        'total' => number_format(0, 2, '.', ''),
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
                $totals[$key]->physical_cash += $item->physical_cash ?? 0;
                $totals[$key]->digital_cash += $item->digital_cash ?? 0;
                $totals[$key]->total += $item->total ?? 0;
            }
        }
        return $totals;
    }


}
