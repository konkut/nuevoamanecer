<?php

namespace App\Http\Controllers;

use App\Models\Bankregister;
use App\Models\Cashregister;
use App\Models\Cashshift;
use App\Models\Category;
use App\Models\Denomination;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Method;
use App\Models\Platform;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function __construct()
    {
        session(['date' => session('date') ?? now()->toDateString()]);
    }

    public function index()
    {
        $cashshift_uuids = Cashshift::where('user_id', Auth::id())->pluck('cashshift_uuid')->toArray();
        $total_users = User::count();
        $total_categories = Category::count();
        $total_services = Service::count();
        $total_platforms = Platform::count();
        $total_incomes = Income::count();
        $total_incomes_by_user = Income::whereIn("cashshift_uuid", $cashshift_uuids)->count();
        $total_cashregisters = Cashregister::count();
        $total_cashshifts = Cashshift::count();
        $total_cashshifts_by_user = Cashshift::where("user_id", Auth::id())->count();
        $total_expenses = Expense::count();
        $total_expenses_by_user = Expense::whereIn("cashshift_uuid", $cashshift_uuids)->count();
        $total_products = Product::count();
        $total_sales = Sale::count();
        $total_sales_by_user = Sale::whereIn("cashshift_uuid", $cashshift_uuids)->count();
        $inventory = Product::select('name', 'stock', 'price')->get();
        $total_bankregisters = Bankregister::count();
        $cashshift = $this->cashshift();
        $cashshifts = $this->cashshifts();
        $cashshifts_data = Cashshift::whereDate('cashshifts.start_time', '=', session('date'))
            ->with(['user', 'cashregister', 'bankregisters', 'platforms', 'denominations'])->get();
        $cashshift_data = Cashshift::where('user_id', Auth::id())->whereDate('cashshifts.start_time', '=', session('date'))
            ->with(['user', 'cashregister', 'bankregisters', 'platforms', 'denominations'])->get();
        $data_sessions = $this->info_session($cashshifts_data);
        $data_session = $this->info_session($cashshift_data);
        if (auth()->user()->hasRole('Administrador')) {
            return view('dashboard', compact('total_users', 'total_categories', 'total_services', 'total_platforms', 'total_incomes', 'total_cashregisters', 'total_bankregisters', 'total_cashshifts', 'total_cashshifts_by_user', 'total_expenses', 'total_products', 'total_sales', 'cashshifts', 'inventory', 'data_sessions'));
        } else {
            return view('dashboard-user', compact('total_services', 'total_incomes_by_user', 'total_cashshifts_by_user', 'total_expenses_by_user', 'total_products', 'total_sales_by_user', 'cashshift', 'inventory', 'data_session'));
        }
    }

    public function cashshift()
    {
        $cashshift = Cashshift::where('cashshifts.user_id', Auth::id())
            ->whereDate('cashshifts.start_time', '=', session('date'))
            ->with(['user', 'cashregister'])->first();
        if ($cashshift) {
            $cashshift->user = $cashshift->user->name;
            $cashshift->cash = $cashshift->cashregister->name;
        }
        return $cashshift;
    }

    public function cashshifts()
    {
        $cashshifts = Cashshift::whereDate('cashshifts.start_time', '=', session('date'))
            ->with(['user', 'cashregister'])->get();
        $cashshifts->each(function ($cashshift) {
            $cashshift->user = $cashshift->user->name;
            $cashshift->cash = $cashshift->cashregister->name;
        });
        return $cashshifts;
    }

    public function info_session($cashshifts)
    {
        //OPENING
        $a_c_o_1 = [];
        $a_b_o_1 = [];
        $a_p_o_1 = [];
        //INCOME
        $a_c_i_2 = [];
        $a_b_i_2 = [];
        $a_p_i_2 = [];
        //EXPENSE
        $a_c_i_3 = [];
        $a_b_i_3 = [];
        $a_p_i_3 = [];
        foreach ($cashshifts as $cashshift) {
            $total = $cashshift->denominations()->wherePivot('type', '1')->value('denominations.total');
            if ($total) {
                $a_c_o_1[] = ['cashregister_uuid' => $cashshift->cashregister_uuid, 'name' => $cashshift->cashregister->name, 'total' => $total];
            }
            foreach ($cashshift->bankregisters as $item) {
                if ($item->pivot->type == '1') {
                    $a_b_o_1[] = ['bankregister_uuid' => $item->bankregister_uuid, 'name' => $item->name, 'total' => $item->pivot->total];
                }
            }
            foreach ($cashshift->platforms as $item) {
                if ($item->pivot->type == '1') {
                    $a_p_o_1[] = ['platform_uuid' => $item->platform_uuid, 'name' => $item->name, 'total' => $item->pivot->total];
                }
            }
            $incomes = Income::where('cashshift_uuid', $cashshift->cashshift_uuid)->with(['services', 'bankregisters', 'platforms', 'denominations', 'cashregisters'])->get();
            foreach ($incomes as $income) {
                foreach ($income->cashregisters as $item) {
                    if ($item->pivot->type == '2') {
                        if (!isset($a_c_i_2[$item->name])) {
                            $a_c_i_2[$item->name] = ['cashregister_uuid' => '', 'name' => '', 'total' => 0,];
                        }
                        $a_c_i_2[$item->name]['cashregister_uuid'] = $item->cashregister_uuid;
                        $a_c_i_2[$item->name]['name'] = $item->name;
                        $a_c_i_2[$item->name]['total'] += $item->pivot->total;
                    }
                    if ($item->pivot->type == '3') {
                        if (!isset($a_c_i_3[$item->name])) {
                            $a_c_i_3[$item->name] = ['cashregister_uuid' => '', 'name' => '', 'total' => 0,];
                        }
                        $a_c_i_3[$item->name]['cashregister_uuid'] = $item->cashregister_uuid;
                        $a_c_i_3[$item->name]['name'] = $item->name;
                        $a_c_i_3[$item->name]['total'] += $item->pivot->total;
                    }
                }
                foreach ($income->bankregisters as $item) {
                    if ($item->pivot->type == '2') {
                        if (!isset($a_b_i_2[$item->name])) {
                            $a_b_i_2[$item->name] = ['bankregister_uuid' => '', 'name' => '', 'total' => 0,];
                        }
                        $a_b_i_2[$item->name]['bankregister_uuid'] = $item->bankregister_uuid;
                        $a_b_i_2[$item->name]['name'] = $item->name;
                        $a_b_i_2[$item->name]['total'] += $item->pivot->total;
                    }
                    if ($item->pivot->type == '3') {
                        if (!isset($a_b_i_3[$item->name])) {
                            $a_b_i_3[$item->name] = ['bankregister_uuid' => '', 'name' => '', 'total' => 0,];
                        }
                        $a_b_i_3[$item->name]['bankregister_uuid'] = $item->bankregister_uuid;
                        $a_b_i_3[$item->name]['name'] = $item->name;
                        $a_b_i_3[$item->name]['total'] += $item->pivot->total;
                    }
                }
                foreach ($income->platforms as $item) {
                    if ($item->pivot->type == '2') {
                        if (!isset($a_p_i_2[$item->name])) {
                            $a_p_i_2[$item->name] = ['platform_uuid' => '', 'name' => '', 'total' => 0,];
                        }
                        $a_p_i_2[$item->name]['platform_uuid'] = $item->platform_uuid;
                        $a_p_i_2[$item->name]['name'] = $item->name;
                        $a_p_i_2[$item->name]['total'] += $item->pivot->total;
                    }
                    if ($item->pivot->type == '3') {
                        if (!isset($a_p_i_3[$item->name])) {
                            $a_p_i_3[$item->name] = ['platform_uuid' => '', 'name' => '', 'total' => 0,];
                        }
                        $a_p_i_3[$item->name]['platform_uuid'] = $item->platform_uuid;
                        $a_p_i_3[$item->name]['name'] = $item->name;
                        $a_p_i_3[$item->name]['total'] += $item->pivot->total;
                    }
                }
            }
            $sales = Sale::where('cashshift_uuid', $cashshift->cashshift_uuid)->with(['products', 'bankregisters', 'cashregisters', 'platforms', 'denomination', 'cashshift'])->get();
            foreach ($sales as $sale) {
                foreach ($sale->cashregisters as $item) {
                    if (!isset($a_c_i_2[$item->name])) {
                        $a_c_i_2[$item->name] = ['cashregister_uuid' => '', 'name' => '', 'total' => 0,];
                    }
                    $a_c_i_2[$item->name]['cashregister_uuid'] = $item->cashregister_uuid;
                    $a_c_i_2[$item->name]['name'] = $item->name;
                    $a_c_i_2[$item->name]['total'] += $item->pivot->total;
                }
                foreach ($sale->bankregisters as $item) {
                    if (!isset($a_b_i_2[$item->name])) {
                        $a_b_i_2[$item->name] = ['bankregister_uuid' => '', 'name' => '', 'total' => 0,];
                    }
                    $a_b_i_2[$item->name]['bankregister_uuid'] = $item->bankregister_uuid;
                    $a_b_i_2[$item->name]['name'] = $item->name;
                    $a_b_i_2[$item->name]['total'] += $item->pivot->total;
                }
                foreach ($sale->platforms as $item) {
                    if (!isset($a_p_i_2[$item->name])) {
                        $a_p_i_2[$item->name] = ['platform_uuid' => '', 'name' => '', 'total' => 0,];
                    }
                    $a_p_i_2[$item->name]['platform_uuid'] = $item->platform_uuid;
                    $a_p_i_2[$item->name]['name'] = $item->name;
                    $a_p_i_2[$item->name]['total'] += $item->pivot->total;
                }
            }
            $expenses = Expense::where('cashshift_uuid', $cashshift->cashshift_uuid)->with(['cashshift', 'denomination', 'category', 'cashregisters', 'bankregisters', 'platforms'])->get();
            foreach ($expenses as $expense) {
                foreach ($expense->cashregisters as $item) {
                    if (!isset($a_c_i_3[$item->name])) {
                        $a_c_i_3[$item->name] = ['cashregister_uuid' => '', 'name' => '', 'total' => 0,];
                    }
                    $a_c_i_3[$item->name]['cashregister_uuid'] = $item->cashregister_uuid;
                    $a_c_i_3[$item->name]['name'] = $item->name;
                    $a_c_i_3[$item->name]['total'] += $item->pivot->total;
                }
                foreach ($expense->bankregisters as $item) {
                    if (!isset($a_b_i_3[$item->name])) {
                        $a_b_i_3[$item->name] = ['bankregister_uuid' => '', 'name' => '', 'total' => 0,];
                    }
                    $a_b_i_3[$item->name]['bankregister_uuid'] = $item->bankregister_uuid;
                    $a_b_i_3[$item->name]['name'] = $item->name;
                    $a_b_i_3[$item->name]['total'] += $item->pivot->total;
                }
                foreach ($expense->platforms as $item) {
                    if (!isset($a_p_i_3[$item->name])) {
                        $a_p_i_3[$item->name] = ['platform_uuid' => '', 'name' => '', 'total' => 0,];
                    }
                    $a_p_i_3[$item->name]['platform_uuid'] = $item->platform_uuid;
                    $a_p_i_3[$item->name]['name'] = $item->name;
                    $a_p_i_3[$item->name]['total'] += $item->pivot->total;
                }
            }
        }
        $a_c_c_4 = $this->data_cash($a_c_o_1, $a_c_i_2, $a_c_i_3);
        $t_c_o = array_sum(array_column($a_c_o_1, 'total'));
        $t_c_i = array_sum(array_column($a_c_i_2, 'total'));
        $t_c_e = array_sum(array_column($a_c_i_3, 'total'));
        $t_c_c = array_sum(array_column($a_c_c_4, 'total'));
        $a_b_c_4 = $this->data_bank($a_b_o_1, $a_b_i_2, $a_b_i_3);
        $t_b_o = array_sum(array_column($a_b_o_1, 'total'));
        $t_b_i = array_sum(array_column($a_b_i_2, 'total'));
        $t_b_e = array_sum(array_column($a_b_i_3, 'total'));
        $t_b_c = array_sum(array_column($a_b_c_4, 'total'));
        $a_p_c_4 = $this->data_platform($a_p_o_1, $a_p_i_2, $a_p_i_3);
        $t_p_o = array_sum(array_column($a_p_o_1, 'total'));
        $t_p_i = array_sum(array_column($a_p_i_2, 'total'));
        $t_p_e = array_sum(array_column($a_p_i_3, 'total'));
        $t_p_c = array_sum(array_column($a_p_c_4, 'total'));
        $info = [
            "opening" => [
                "cashregister" => [
                    "data" => $a_c_o_1,
                    "total" => $t_c_o
                ],
                "bankregister" => [
                    "data" => $a_b_o_1,
                    "total" => $t_b_o
                ],
                "platform" => [
                    "data" => $a_p_o_1,
                    "total" => $t_p_o
                ],
            ],
            "income" => [
                "cashregister" => [
                    "data" => $a_c_i_2,
                    "total" => $t_c_i,
                ],
                "bankregister" => [
                    "data" => $a_b_i_2,
                    "total" => $t_b_i,
                ],
                "platform" => [
                    "data" => $a_p_i_2,
                    "total" => $t_p_i,
                ],
            ],
            "expense" => [
                "cashregister" => [
                    "data" => $a_c_i_3,
                    "total" => $t_c_e,
                ],
                "bankregister" => [
                    "data" => $a_b_i_3,
                    "total" => $t_b_e,
                ],
                "platform" => [
                    "data" => $a_p_i_3,
                    "total" => $t_p_e,
                ],
            ],
            "closing" => [
                "cashregister" => [
                    "data" => $a_c_c_4,
                    "total" => $t_c_c,
                ],
                "bankregister" => [
                    "data" => $a_b_c_4,
                    "total" => $t_b_c,
                ],
                "platform" => [
                    "data" => $a_p_c_4,
                    "total" => $t_p_c,
                ],
            ],
        ];
        return $info;
    }

    public function data_cash($array_opening, $array_income, $array_expense)
    {
        $closing = [];
        $cashregister_uuids = Cashregister::pluck("cashregister_uuid", "name")->toArray();
        foreach ($cashregister_uuids as $key => $cashregister_uuid) {
            if (!isset($closing[$key])) {
                $closing[$key] = ["cashregister_uuid" => $cashregister_uuid, "name" => $key, "total" => 0];
            }
            foreach ($array_opening as $item) {
                if ($item['cashregister_uuid'] === $cashregister_uuid) {
                    $closing[$item['name']]['total'] = $item['total'];
                }
            }
            foreach ($array_income as $item) {
                if ($item['cashregister_uuid'] === $cashregister_uuid) {
                    $closing[$item['name']]['total'] += $item['total'];
                }
            }
            foreach ($array_expense as $item) {
                if ($item['cashregister_uuid'] === $cashregister_uuid) {
                    $closing[$item['name']]['total'] -= $item['total'];
                }
            }
        }
        $array_closing = array_filter($closing, function ($item) {
            return $item['total'] !== 0;
        });
        return $array_closing;
    }

    public function data_bank($array_opening, $array_income, $array_expense)
    {
        $closing = [];
        $bankregister_uuids = Bankregister::pluck("bankregister_uuid", "name")->toArray();
        foreach ($bankregister_uuids as $key => $bankregister_uuid) {
            if (!isset($closing[$key])) {
                $closing[$key] = ["bankregister_uuid" => $bankregister_uuid, "name" => $key, "total" => 0];
            }
            foreach ($array_opening as $item) {
                if ($item['bankregister_uuid'] == $bankregister_uuid) {
                    $closing[$item['name']]['total'] = $item['total'];
                }
            }
            foreach ($array_income as $item) {
                if ($item['bankregister_uuid'] === $bankregister_uuid) {
                    $closing[$item['name']]['total'] += $item['total'];
                }
            }
            foreach ($array_expense as $item) {
                if ($item['bankregister_uuid'] === $bankregister_uuid) {
                    $closing[$item['name']]['total'] -= $item['total'];
                }
            }
        }
        $array_closing = array_filter($closing, function ($item) {
            return $item['total'] !== 0;
        });
        return $array_closing;
    }

    public function data_platform($array_opening, $array_income, $array_expense)
    {
        $closing = [];
        $platform_uuids = Platform::pluck("platform_uuid", "name")->toArray();
        foreach ($platform_uuids as $key => $platform_uuid) {
            if (!isset($closing[$key])) {
                $closing[$key] = ["platform_uuid" => $platform_uuid, "name" => $key, "total" => 0];
            }
            foreach ($array_opening as $item) {
                if ($item['platform_uuid'] === $platform_uuid) {
                    $closing[$item['name']]['total'] = $item['total'];
                }
            }
            foreach ($array_income as $item) {
                if ($item['platform_uuid'] === $platform_uuid) {
                    $closing[$item['name']]['total'] += $item['total'];
                }
            }
            foreach ($array_expense as $item) {
                if ($item['platform_uuid'] === $platform_uuid) {
                    $closing[$item['name']]['total'] -= $item['total'];
                }
            }
        }
        $array_closing = array_filter($closing, function ($item) {
            return $item['total'] !== 0;
        });
        return $array_closing;
    }

    public function one_session($cashshift_uuid)
    {
        $cashshift_data = Cashshift::where('cashshift_uuid', $cashshift_uuid)->whereDate('cashshifts.start_time', '=', session('date'))
            ->with(['user', 'cashregister', 'bankregisters', 'platforms', 'denominations'])->get();
        $data = $this->info_session($cashshift_data);
        if (request()->ajax()) {
            try {
                $view_summary = view('components.panel-box-all-summary', compact('data'))->render();
                return response()->json([
                    'summary_html' => $view_summary,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'type' => 'error',
                    'title' => __('word.general.error'),
                    'msg' => __('word.panel.error.fetch'),
                ], 400);
            }
        }
        return redirect("/dashboard")->with('success', __('word.panel.alert.success'));
    }

    public function search_sessions(Request $request)
    {
        session(['date' => $request->query('date')]);
        $cashshifts_data = Cashshift::whereDate('cashshifts.start_time', '=', session('date'))
            ->with(['user', 'cashregister', 'bankregisters', 'platforms', 'denominations'])->get();
        $data = $this->info_session($cashshifts_data);
        $cashshifts = $this->cashshifts();
        if ($request->ajax()) {
            try {
                $view_summary = view('components.panel-box-all-summary', compact('data'))->render();
                $view_session = view('components.panel-box-all-sessions', compact('cashshifts'))->render();
                return response()->json([
                    'summary_html' => $view_summary,
                    'session_html' => $view_session,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'type' => 'error',
                    'title' => __('word.general.error'),
                    'msg' => __('word.panel.error.fetch'),
                ], 400);
            }
        }
        return redirect("/dashboard")->with([
            'success' => __('word.panel.alert.success'),
        ]);
    }

    public function search_session(Request $request)
    {
        session(['date' => $request->query('date')]);
        $cashshift_data = Cashshift::where('user_id', Auth::id())->whereDate('cashshifts.start_time', '=', session('date'))
            ->with(['user', 'cashregister', 'bankregisters', 'platforms', 'denominations'])->get();
        $data = $this->info_session($cashshift_data);
        $cashshift = $this->cashshift();
        if ($request->ajax()) {
            try {
                $view_summary = view('components.panel-box-all-summary', compact('data'))->render();
                $view_session = view('components.panel-box-all-session', compact('cashshift'))->render();
                return response()->json([
                    'summary_html' => $view_summary,
                    'session_html' => $view_session,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'type' => 'error',
                    'title' => __('word.general.error'),
                    'msg' => __('word.panel.error.fetch'),
                ], 400);
            }
        }
        return redirect("/dashboard")->with([
            'success' => __('word.panel.alert.success'),
        ]);
    }

    /*CIERRE DE SESION*/
    public function off_session(string $cashshift_uuid)
    {
        if ($cashshift_uuid) {
            DB::transaction(function () use ($cashshift_uuid) {
                $cashshift = Cashshift::where('cashshift_uuid', $cashshift_uuid)
                    ->with(['user', 'cashregister', 'bankregisters', 'platforms', 'denominations'])->first();
                $cashshift->update([
                    'end_time' => now()->format('Y-m-d\TH:i'),
                    'status' => false,
                ]);
                $closing = $this->closing($cashshift->cashshift_uuid);
                $sync_denomination[$closing->denomination_uuid] = [
                    'type' => '4',
                ];
                $cashshift->denominations()->attach($sync_denomination);
                $collection = collect([$cashshift]);
                $dashboardController = new DashboardController();
                $data = $dashboardController->info_session($collection);
                $sync_bankregister = [];
                foreach ($data['closing']['bankregister']['data'] as $key => $item) {
                    $sync_bankregister[$item['bankregister_uuid']] = [
                        'type' => '4',
                        'total' => $item['total'],
                    ];
                }
                $cashshift->bankregisters()->attach($sync_bankregister);
                $sync_platform = [];
                foreach ($data['closing']['platform']['data'] as $key => $item) {
                    $sync_platform[$item['platform_uuid']] = [
                        'type' => '4',
                        'total' => $item['total'],
                    ];
                }
                $cashshift->platforms()->attach($sync_platform);
            });
        }
        return redirect("/dashboard")->with('success', __('word.cashshift.alert.disable'));
    }

    public function on_session(string $cashshift_uuid)
    {
        if ($cashshift_uuid) {
            DB::transaction(function () use ($cashshift_uuid) {
                $cashshift = Cashshift::where('cashshift_uuid', $cashshift_uuid)
                    ->with(['user', 'cashregister', 'bankregisters', 'platforms', 'denominations'])->first();
                $cashshift->update([
                    'end_time' => null,
                    'status' => true,
                ]);
                $denomination_uuid = DB::table('cashshift_denominations')->where('cashshift_uuid', $cashshift_uuid)
                    ->where('type', '4')->value('denomination_uuid');
                DB::table('denominations')->where('denomination_uuid', $denomination_uuid)->delete();
                DB::table('cashshift_denominations')->where('cashshift_uuid', $cashshift_uuid)->where('type', '4')->delete();
                DB::table('cashshift_bankregisters')->where('cashshift_uuid', $cashshift_uuid)->where('type', '4')->delete();
                DB::table('cashshift_platforms')->where('cashshift_uuid', $cashshift_uuid)->where('type', '4')->delete();
            });
        }
        return redirect("/dashboard")->with('success', __('word.cashshift.alert.enable'));
    }

    public function two_denominations($denomination_one, $denomination_two)
    {
        $sum = (object)[
            'bill_200' => ($denomination_one->bill_200 ?? 0) + ($denomination_two->bill_200 ?? 0),
            'bill_100' => ($denomination_one->bill_100 ?? 0) + ($denomination_two->bill_100 ?? 0),
            'bill_50' => ($denomination_one->bill_50 ?? 0) + ($denomination_two->bill_50 ?? 0),
            'bill_20' => ($denomination_one->bill_20 ?? 0) + ($denomination_two->bill_20 ?? 0),
            'bill_10' => ($denomination_one->bill_10 ?? 0) + ($denomination_two->bill_10 ?? 0),
            'coin_5' => ($denomination_one->coin_5 ?? 0) + ($denomination_two->coin_5 ?? 0),
            'coin_2' => ($denomination_one->coin_2 ?? 0) + ($denomination_two->coin_2 ?? 0),
            'coin_1' => ($denomination_one->coin_1 ?? 0) + ($denomination_two->coin_1 ?? 0),
            'coin_0_5' => ($denomination_one->coin_0_5 ?? 0) + ($denomination_two->coin_0_5 ?? 0),
            'coin_0_2' => ($denomination_one->coin_0_2 ?? 0) + ($denomination_two->coin_0_2 ?? 0),
            'coin_0_1' => ($denomination_one->coin_0_1 ?? 0) + ($denomination_two->coin_0_1 ?? 0),
            'total' => ($denomination_one->total ?? 0) + ($denomination_two->total ?? 0),
        ];
        return $sum;
    }

    public function closing($cashshift_uuid)
    {
        $d_c_1 = DB::table('cashshift_denominations')
            ->join('denominations', 'cashshift_denominations.denomination_uuid', '=', 'denominations.denomination_uuid')
            ->where('cashshift_denominations.cashshift_uuid', $cashshift_uuid)
            ->where('cashshift_denominations.type', '1')->first();
        $d_i_2 = DB::table('incomes')
            ->join('income_denominations', 'incomes.income_uuid', '=', 'income_denominations.income_uuid')
            ->join('denominations', 'income_denominations.denomination_uuid', '=', 'denominations.denomination_uuid')
            ->where('incomes.cashshift_uuid', $cashshift_uuid)
            ->where('income_denominations.type', '2')
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
            ')->first();
        $d_s_2 = DB::table('sales')
            ->join('denominations', 'sales.denomination_uuid', '=', 'denominations.denomination_uuid')
            ->where('sales.cashshift_uuid', $cashshift_uuid)
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
            ')->first();
        $d_c_2 = $this->two_denominations($d_i_2, $d_s_2);
        $d_i_3 = DB::table('incomes')
            ->join('income_denominations', 'incomes.income_uuid', '=', 'income_denominations.income_uuid')
            ->join('denominations', 'income_denominations.denomination_uuid', '=', 'denominations.denomination_uuid')
            ->where('incomes.cashshift_uuid', $cashshift_uuid)
            ->where('income_denominations.type', '3')
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
            ')->first();
        $d_e_3 = DB::table('expenses')
            ->join('denominations', 'expenses.denomination_uuid', '=', 'denominations.denomination_uuid')
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
            ')->first();
        $d_c_3 = $this->two_denominations($d_i_3, $d_e_3);
        $denomination = Denomination::create([
            'bill_200' => ($d_c_1->bill_200 ?? 0) + ($d_c_2->bill_200 ?? 0) - ($d_c_3->bill_200 ?? 0),
            'bill_100' => ($d_c_1->bill_100 ?? 0) + ($d_c_2->bill_100 ?? 0) - ($d_c_3->bill_100 ?? 0),
            'bill_50' => ($d_c_1->bill_50 ?? 0) + ($d_c_2->bill_50 ?? 0) - ($d_c_3->bill_50 ?? 0),
            'bill_20' => ($d_c_1->bill_20 ?? 0) + ($d_c_2->bill_20 ?? 0) - ($d_c_3->bill_20 ?? 0),
            'bill_10' => ($d_c_1->bill_10 ?? 0) + ($d_c_2->bill_10 ?? 0) - ($d_c_3->bill_10 ?? 0),
            'coin_5' => ($d_c_1->coin_5 ?? 0) + ($d_c_2->coin_5 ?? 0) - ($d_c_3->coin_5 ?? 0),
            'coin_2' => ($d_c_1->coin_2 ?? 0) + ($d_c_2->coin_2 ?? 0) - ($d_c_3->coin_2 ?? 0),
            'coin_1' => ($d_c_1->coin_1 ?? 0) + ($d_c_2->coin_1 ?? 0) - ($d_c_3->coin_1 ?? 0),
            'coin_0_5' => ($d_c_1->coin_0_5 ?? 0) + ($d_c_2->coin_0_5 ?? 0) - ($d_c_3->coin_0_5 ?? 0),
            'coin_0_2' => ($d_c_1->coin_0_2 ?? 0) + ($d_c_2->coin_0_2 ?? 0) - ($d_c_3->coin_0_2 ?? 0),
            'coin_0_1' => ($d_c_1->coin_0_1 ?? 0) + ($d_c_2->coin_0_1 ?? 0) - ($d_c_3->coin_0_1 ?? 0),
            'total' => number_format(($d_c_1->total ?? 0) + ($d_c_2->total ?? 0) - ($d_c_3->total ?? 0), 2, '.', '')
        ]);
        return $denomination;
    }
}
