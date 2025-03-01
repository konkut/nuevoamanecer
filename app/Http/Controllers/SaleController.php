<?php

namespace App\Http\Controllers;

use App\Exports\ExpenseExport;
use App\Exports\PaymentwithoutpriceExport;
use App\Exports\SaleExport;
use App\Models\Bankregister;
use App\Models\Cashregister;
use App\Models\Cashshift;
use App\Models\Denomination;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Method;
use App\Models\Platform;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Servicewithprice;
use App\Models\Transactionmethod;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $sales = Sale::with(['products', 'bankregisters', 'cashregisters', 'platforms', 'denomination', 'cashshift'])->orderBy('created_at', 'desc')->paginate($perPage);
        $sales->each(function ($sale) {
            $array_products = array_column($sale->products->toArray(), 'name');
            $array_cashregisters = array_column($sale->cashregisters->toArray(), 'name');
            $array_bankregisters = array_column($sale->bankregisters->toArray(), 'name');
            $array_platforms = array_column($sale->platforms->toArray(), 'name');
            $sale->name = implode(', ', $array_products) ?? "";
            $array_methods = array_merge($array_cashregisters, $array_bankregisters, $array_platforms);
            $sale->methods = implode(', ', $array_methods) ?? "";
            $amounts = [];
            $data = [];
            foreach ($sale->products as $key => $product) {
                if ($product) {
                    if (!isset($data[$product->name])) {
                        $data[$product->name] = (object)['name' => '','quantity' => 0,'amount' => 0.00];
                    }
                    $amounts[] = $product->pivot->amount * $product->pivot->quantity;
                    $data[$product->name]->name = $product->name;
                    $data[$product->name]->quantity += $product->pivot->quantity;
                    $data[$product->name]->amount += $product->pivot->amount * $product->pivot->quantity;
                }
            }
            $sale->detail = $data;
            $sale->total = number_format(array_sum($amounts), 2, '.', '');
            $sale->user = $sale->cashshift->user->name;
            $sale->user_id = $sale->cashshift->user->id;
        });
        $cashshift = Cashshift::where('status', true)->first();
        return view("sale.index", compact('sales', 'perPage', 'cashshift'));
    }

    public function create()
    {
        $sale = new Sale();
        $denomination = new Denomination();
        $products = Product::where("status", '1')->get();
        $cashshiftController = new CashshiftController();
        $data = $cashshiftController->methods(Auth::id());
        return view("sale.create", compact('sale', 'denomination', 'data', 'products'));
    }

    public function store(Request $request)
    {
        $rules = [
            'observation' => 'nullable|string|max:100',
            'product_uuids' => 'required|array',
            'product_uuids.*' => 'required|string|max:36|exists:products,product_uuid',
            'charge_uuids' => 'required|array',
            'charge_uuids.*' => 'required|string|max:36',
            'amounts' => 'required|array',
            'amounts.*' => 'required|numeric',
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
            'total' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $validator->after(function ($validator) use ($request) {
            $quantity = count($request->input('quantities', []));
            $product = count($request->input('product_uuids', []));
            $charge = count($request->input('charge_uuids', []));
            if ($product !== $charge || $product !== $quantity || $charge !== $quantity) {
                $validator->errors()->add('method_uuids', __('word.sale.one_validation'));
                return;
            }
            foreach ($request->input('amounts') as $amount) {
                if ($amount == 0) {
                    $validator->errors()->add('amounts', __('word.rules.rule_eighteen'));
                    return;
                }
                if ($amount > 10000) {
                    $validator->errors()->add('amounts', __('word.rules.rule_nineteen'));
                    return;
                }
                if ($amount < 0) {
                    $validator->errors()->add('amounts', __('word.rules.rule_twenty'));
                    return;
                }
                if (!$amount) {
                    $validator->errors()->add('amounts', __('word.rules.rule_twenty_one'));
                    return;
                }
                if (!preg_match('/^\d+(\.\d{1,2})?$/', $amount)) {
                    $validator->errors()->add('amounts', __('word.rules.rule_twenty_two'));
                    return;
                }
            }
            if ($request->product_uuids) {
                $stocks = [];
                foreach ($request->product_uuids as $key => $product_uuid) {
                    $product = Product::where('product_uuid', $product_uuid)->select('stock', 'name')->first();
                    if ($product) {
                        if (!isset($stocks[$product->name])) {
                            $stocks[$product->name] = [
                                'stock' => $product->stock,
                                'requested' => 0,
                            ];
                        }
                        $quantity = $request->quantities[$key] ?? 0;
                        $stocks[$product->name]['requested'] += $quantity;
                        if ($quantity > $product->stock) {
                            $validator->errors()->add('quantities', __("word.sale.two_validation", ['product' => $product->name, 'request' => $quantity, 'available' => $product->stock]));
                            return;
                        }
                    }
                }
                foreach ($stocks as $name => $data) {
                    if ($data['requested'] > $data['stock']) {
                        $validator->errors()->add('quantities', __("word.sale.two_validation", ['product' => $name, 'request' => $data['requested'], 'available' => $data['stock']]));
                        return;
                    }
                }
            }
            if ($request->force === "0") {
                if ($request->input('total') == 0) {
                    $validator->errors()->add('total', __('word.rules.rule_thirteen'));
                    return;
                }
                if ($request->input('total') > 10000) {
                    $validator->errors()->add('total', __('word.rules.rule_fourteen'));
                    return;
                }
                if ($request->input('total') < 0) {
                    $validator->errors()->add('total', __('word.rules.rule_fifteen'));
                    return;
                }
                if (!is_numeric($request->input('total'))) {
                    $validator->errors()->add('total', __('word.rules.rule_sixteen'));
                    return;
                }
                if (!preg_match('/^\d+(\.\d{1,2})?$/', $request->input('total'))) {
                    $validator->errors()->add('total', __('word.rules.rule_seventeen'));
                    return;
                }
                $total = number_format($request->total, 1);
                $charge = number_format($request->charge, 1);
                if ($total !== $charge) {
                    $validator->errors()->add('method_uuids', __('word.expense.one_validate', ['charge' => $charge, 'total' => $total]));
                }
                return;
            }
        });
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        DB::transaction(function () use ($request) {
            $cashshift_uuid = Cashshift::where('user_id', auth::id())->where('status', true)->value('cashshift_uuid');
            if ($cashshift_uuid) {
                if (Cashregister::whereIn('cashregister_uuid', $request->charge_uuids)->exists()) {
                    $denomination = Denomination::create([
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
                        'total' => $request->physical_cash,
                    ]);
                }
                $sale = Sale::create([
                    'observation' => $request->observation,
                    'cashshift_uuid' => $cashshift_uuid,
                    'denomination_uuid' => $denomination->denomination_uuid ?? null,
                ]);
                foreach ($request->product_uuids as $key => $product_uuid) {
                    $product = Product::where('product_uuid', $product_uuid)->first();
                    if ($product) {
                        $new_stock = $product->stock - $request->quantities[$key];
                        $product->update([
                            'stock' => $new_stock,
                        ]);
                    }
                }
                $this->add($sale, $request);
            }
        });
        return redirect("/sales")->with('success', __('word.sale.alert.store'));
    }

    public function edit(string $sale_uuid)
    {
        $sale = Sale::where('sale_uuid', $sale_uuid)->with(['products', 'cashregisters', 'denomination', 'bankregisters', 'platforms', 'cashshift'])->first();
        $denomination = $sale->denomination ?? new Denomination();
        $quantities = [];
        $amounts = [];
        $product_uuids = [];
        $charge_uuids = [];
        foreach ($sale->products as $key => $product) {
            $cashregister = $sale->cashregisters()->wherePivot('index', $key)->first();
            $bankregister = $sale->bankregisters()->wherePivot('index', $key)->first();
            $platform = $sale->platforms()->wherePivot('index', $key)->first();
            if ($product) {
                $quantities[$key] = $product->pivot->quantity;
                $amounts[$key] = $product->pivot->amount;
                $product_uuids[$key] = $product->product_uuid;
            }
            if ($cashregister) $charge_uuids[$key] = $cashregister->cashregister_uuid;
            if ($bankregister) $charge_uuids[$key] = $bankregister->bankregister_uuid;
            if ($platform) $charge_uuids[$key] = $platform->platform_uuid;
        }
        $sale->quantities = $quantities;
        $sale->amounts = $amounts;
        $sale->product_uuids = $product_uuids;
        $sale->charge_uuids = $charge_uuids;
        $products = Product::where("status", '1')->get();
        $cashshiftController = new CashshiftController();
        $data = $cashshiftController->methods($sale->cashshift->user_id);
        return view("sale.edit", compact('sale', 'denomination', 'data', 'products'));
    }

    public function update(Request $request, string $sale_uuid)
    {
        $sale = Sale::where('sale_uuid', $sale_uuid)->firstOrFail();
        $rules = [
            'observation' => 'nullable|string|max:100',
            'product_uuids' => 'required|array',
            'product_uuids.*' => 'required|string|max:36|exists:products,product_uuid',
            'charge_uuids' => 'required|array',
            'charge_uuids.*' => 'required|string|max:36',
            'amounts' => 'required|array',
            'amounts.*' => 'required|numeric',
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
            'total' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $validator->after(function ($validator) use ($request, $sale) {
            $quantity = count($request->input('quantities', []));
            $product = count($request->input('product_uuids', []));
            $charge = count($request->input('charge_uuids', []));
            if ($product !== $charge || $product !== $quantity || $charge !== $quantity) {
                $validator->errors()->add('method_uuids', __('word.sale.one_validation'));
                return;
            }
            if ($request->product_uuids) {
                $stocks = [];
                foreach ($request->product_uuids as $key => $product_uuid) {
                    $product = Product::where('product_uuid', $product_uuid)->select('stock', 'name')->first();
                    if ($product) {
                        $quantity_requested = $request->quantities[$key] ?? 0; //91 //80
                        $quantity_previous = $sale->quantities[$key] ?? 0; //3  //80
                        $difference = $quantity_requested - $quantity_previous; //88  //0
                        $projected_stock = $product->stock - $difference;  //20 - 0 = 20
                        if ($projected_stock < 0) {
                            $validator->errors()->add('quantities', __("word.sale.two_validation", ['product' => $product->name, 'request' => $quantity_requested, 'available' => $product->stock]));
                            return;
                        }
                        if (!isset($stocks[$product->name])) {
                            $stocks[$product->name] = [
                                'stock' => $product->stock,
                                'total_requested' => 0,
                            ];
                        }
                        $stocks[$product->name]['total_requested'] += $difference;
                    }
                }
                foreach ($stocks as $name => $data) {
                    if ($data['total_requested'] > $data['stock']) {
                        $validator->errors()->add('quantities', __("word.sale.three_validation", ['product' => $name, 'request' => $data['total_requested'], 'available' => $data['stock']]));
                    }
                }
            }
            foreach ($request->input('amounts') as $amount) {
                if ($amount == 0) {
                    $validator->errors()->add('amounts', __('word.rules.rule_eighteen'));
                    return;
                }
                if ($amount > 10000) {
                    $validator->errors()->add('amounts', __('word.rules.rule_nineteen'));
                    return;
                }
                if ($amount < 0) {
                    $validator->errors()->add('amounts', __('word.rules.rule_twenty'));
                    return;
                }
                if (!$amount) {
                    $validator->errors()->add('amounts', __('word.rules.rule_twenty_one'));
                    return;
                }
                if (!preg_match('/^\d+(\.\d{1,2})?$/', $amount)) {
                    $validator->errors()->add('amounts', __('word.rules.rule_twenty_two'));
                    return;
                }
            }
            if ($request->force === "0") {
                if ($request->input('total') == 0) {
                    $validator->errors()->add('total', __('word.rules.rule_thirteen'));
                    return;
                }
                if ($request->input('total') > 10000) {
                    $validator->errors()->add('total', __('word.rules.rule_fourteen'));
                    return;
                }
                if ($request->input('total') < 0) {
                    $validator->errors()->add('total', __('word.rules.rule_fifteen'));
                    return;
                }
                if (!is_numeric($request->input('total'))) {
                    $validator->errors()->add('total', __('word.rules.rule_sixteen'));
                    return;
                }
                if (!preg_match('/^\d+(\.\d{1,2})?$/', $request->input('total'))) {
                    $validator->errors()->add('total', __('word.rules.rule_seventeen'));
                    return;
                }
                $total = number_format($request->total, 1);
                $charge = number_format($request->charge, 1);
                if ($total !== $charge) {
                    $validator->errors()->add('total', __('word.sale.four_validate', ['charge' => $charge, 'total' => $total]));
                }
                return;
            }
        });
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        DB::transaction(function () use ($request, $sale, $sale_uuid) {
            $cashregister = Cashregister::whereIn('cashregister_uuid', $request->charge_uuids)->exists();
            $denomination = Denomination::where('denomination_uuid', $sale->denomination_uuid)->first();
            if ($sale->denomination_uuid && $cashregister) {
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
                    'total' => $request->physical_cash ?? 0,
                ]);
            }
            if (!$sale->denomination_uuid && $cashregister) {
                $billcoin = Denomination::create([
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
                    'total' => $request->physical_cash,
                ]);
                $sale->update([
                    'denomination_uuid' => $billcoin->denomination_uuid,
                ]);
            }
            if ($sale->denomination_uuid && !$cashregister) {
                $sale->update([
                    'denomination_uuid' => null,
                ]);
                $denomination->delete();
            }
            $sale->update([
                'observation' => $request->observation,
            ]);
            $products = DB::table('sale_products')->where('sale_uuid', $sale_uuid)
                ->orderBy('index')->get()->toArray();
            foreach ($request->product_uuids as $key => $product_uuid) {
                $product = Product::where('product_uuid', $product_uuid)->first();
                if ($product) {
                    if ($products[$key]->quantity < $request->quantities[$key]) {
                        $operation = $request->quantities[$key] - $products[$key]->quantity;
                        $new_stock = $product->stock - $operation;
                        $product->update([
                            'stock' => $new_stock,
                        ]);
                    }
                    if ($products[$key]->quantity > $request->quantities[$key]) {
                        $operation = $products[$key]->quantity - $request->quantities[$key];
                        $new_stock = $product->stock + $operation;
                        $product->update([
                            'stock' => $new_stock,
                        ]);
                    }
                }
            }
            $sale->products()->detach();
            $sale->cashregisters()->detach();
            $sale->bankregisters()->detach();
            $sale->platforms()->detach();
            $this->add($sale, $request);
        });
        return redirect("/sales")->with('success', __('word.sale.alert.update'));
    }

    public function destroy(string $sale_uuid)
    {
        $sale = Sale::where('sale_uuid', $sale_uuid)->with(['denomination'])->first();
        if ($sale) {
            DB::transaction(function () use ($sale, $sale_uuid) {
                $products = DB::table('sale_products')->where('sale_uuid', $sale_uuid)->get();
                foreach ($products as $key => $product) {
                    $product = Product::where('product_uuid', $product->product_uuid)->first();
                    if ($product) {
                        $new_stock = $product->stock + $product->quantity;
                        $product->update([
                            'stock' => $new_stock,
                        ]);
                    }
                }
                $sale->products()->detach();
                $sale->cashregisters()->detach();
                $sale->bankregisters()->detach();
                $sale->platforms()->detach();
                $sale->update(['denomination_uuid' => null]);
                if ($sale->denomination) {
                    $sale->denomination->delete();
                }
                $sale->delete();
            });
        }
        return redirect("/sales")->with('success', __('word.sale.alert.delete'));
    }

    public function detail(string $sale_uuid)
    {
        try {
            $sale = Sale::where('sale_uuid', $sale_uuid)->with(['denomination'])->first();
            if ($sale->denomination_uuid) {
                $incomeController = new IncomeController();
                $operation = $incomeController->object_operation($sale->denomination);
            }
            $cashregister = $sale->cashregisters()->select('cashregisters.name as name', 'sale_cashregisters.total as total')->get()->toArray();
            $bankregister = $sale->bankregisters()->select('bankregisters.name as name', 'sale_bankregisters.total as total')->get()->toArray();
            $platform = $sale->platforms()->select('platforms.name as name', 'sale_platforms.total as total')->get()->toArray();
            return response()->json([
                'type' => 'success',
                'title' => __('word.general.success'),
                'denomination' => $sale->denomination ?? null,
                'operation' => $operation ?? null,
                'cashregister' => $cashregister ?? null,
                'bankregister' => $bankregister ?? null,
                'platform' => $platform ?? null,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.general.bad_request'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function add($sale, Request $request)
    {
        $sync_product = [];
        foreach ($request->product_uuids as $key => $product_uuid) {
            $sync_product[$product_uuid][] = [
                'quantity' => $request->quantities[$key],
                'amount' => $request->amounts[$key],
                'index' => $key,
            ];
        }
        foreach ($sync_product as $product_uuid => $data) {
            foreach ($data as $entry) {
                $sale->products()->attach($product_uuid, $entry);
            }
        }
        $sync_cashregister = [];
        $sync_bankregister = [];
        $sync_platform = [];
        foreach ($request->charge_uuids as $key => $reference_uuid) {
            $total = $request->amounts[$key] * $request->quantities[$key];
            if (Cashregister::where('cashregister_uuid', $reference_uuid)->exists()) {
                $sync_cashregister[$reference_uuid][] = [
                    'total' => $total,
                    'index' => $key
                ];
            }
            if (Bankregister::where('bankregister_uuid', $reference_uuid)->exists()) {
                $sync_bankregister[$reference_uuid][] = [
                    'total' => $total,
                    'index' => $key
                ];
            }
            if (Platform::where('platform_uuid', $reference_uuid)->exists()) {
                $sync_platform[$reference_uuid][] = [
                    'total' => $total,
                    'index' => $key
                ];
            }
        }
        foreach ($sync_cashregister as $cashregister_uuid => $data) {
            foreach ($data as $entry) {
                $sale->cashregisters()->attach($cashregister_uuid, $entry);
            }
        }
        foreach ($sync_bankregister as $bankregister_uuid => $data) {
            foreach ($data as $entry) {
                $sale->bankregisters()->attach($bankregister_uuid, $entry);
            }
        }
        foreach ($sync_platform as $platform_uuid => $data) {
            foreach ($data as $entry) {
                $sale->platforms()->attach($platform_uuid, $entry);
            }
        }
    }

    public function export(Request $request)
    {
        $filter = $request->input('filter', 'day');
        $date = Carbon::now();
        switch ($filter) {
            case 'day':
                $start_date = $date->startOfDay()->toDateTimeString();
                $end_date = $date->endOfDay()->toDateTimeString();
                break;
            case 'week':
                $start_date = $date->startOfWeek()->toDateTimeString();
                $end_date = $date->endOfWeek()->toDateTimeString();
                break;
            case 'month':
                $start_date = $date->startOfMonth()->toDateTimeString();
                $end_date = $date->endOfMonth()->toDateTimeString();
                break;
            case 'custom':
                $start_date = Carbon::parse($request->input('start_date'))->startOfDay()->toDateTimeString();
                $end_date = Carbon::parse($request->input('end_date'))->endOfDay()->toDateTimeString();
                break;
        }

        if (auth()->user()->hasRole('Administrador')){
            $sales = Sale::whereBetween('created_at', [$start_date, $end_date])
                ->with(['products', 'bankregisters', 'cashregisters', 'platforms', 'denomination', 'cashshift'])->get();
        }else{
            $cashshift_uuids = Cashshift::where('user_id', auth::id())->pluck('cashshift_uuid')->toArray();
            $sales = Sale::whereBetween('created_at', [$start_date, $end_date])
                ->with(['products', 'bankregisters', 'cashregisters', 'platforms', 'denomination', 'cashshift'])
                ->whereIn('cashshift_uuid', $cashshift_uuids)->get();
        }
        $sales->each(function ($sale) {
            $products = $sale->products->pluck('name')->toArray();
            $names = [];
            $totals = 0;
            foreach ($sale->cashregisters as $item) {
                $names[] = $item->name;
                $totals += $item->pivot->total;
            }
            foreach ($sale->bankregisters as $item) {
                $names[] = $item->name;
                $totals += $item->pivot->total;
            }
            foreach ($sale->platforms as $item) {
                $names[] = $item->name;
                $totals += $item->pivot->total;
            }
            $sale->format_products = implode(', ', $products) ?? "";
            $sale->format_observation = $sale->observation ?? "";
            $sale->format_name = implode(', ', array_unique($names)) ?? "";
            $sale->format_amount = $totals ?? "";
            $sale->format_user = $sale->cashshift->user->name ?? "";
            $sale->format_created_at = $sale->created_at->format('H:i:s d-m-Y') ?? "";
            $sale->format_updated_at = $sale->updated_at->format('H:i:s d-m-Y') ?? "";
        });
        $range_start = Carbon::parse($start_date)->format('H-i-s_d-m-Y');
        $range_end = Carbon::parse($end_date)->format('H-i-s_d-m-Y');
        $name = __('word.sale.filename');
        $filename = "{$name}_{$range_start}_{$range_end}.xlsx";
        return Excel::download(new SaleExport($sales), $filename);
    }
}
