<?php

namespace App\Http\Controllers;

use App\Exports\ExpenseExport;
use App\Exports\IncomeExport;
use App\Models\Bankregister;
use App\Models\Cashregister;
use App\Models\Cashshift;
use App\Models\Category;
use App\Models\Denomination;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Method;
use App\Models\Paymentwithprice;
use App\Models\Platform;
use App\Models\Product;
use App\Models\Servicewithoutprice;
use App\Models\Transaction;
use App\Models\Transactionmethod;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use function PHPUnit\Framework\isEmpty;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $expenses = Expense::with(['cashshift','denomination','category', 'cashregisters', 'bankregisters', 'platforms'])->orderBy('created_at', 'desc')->paginate($perPage);
        $expenses->each(function ($expense) {
            if (!empty($expense->cashregisters->toArray())) $name = array_column($expense->cashregisters->toArray(), 'name');
            if (!empty($expense->bankregisters->toArray())) $name = array_column($expense->bankregisters->toArray(), 'name');
            if (!empty($expense->platforms->toArray())) $name = array_column($expense->platforms->toArray(), 'name');
            $expense->name = implode(', ', $name) ?? "";
            $expense->user = $expense->cashshift->user->name;
            $expense->user_id = $expense->cashshift->user->id;
        });
        $cashshift = Cashshift::where('status', true)->first();
        return view("expense.index", compact('expenses', 'perPage', 'cashshift'));
    }

    public function create()
    {
        $expense = new Expense();
        $denomination = new Denomination();
        $categories = Category::where("status", '1')->get();
        $cashshiftController = new CashshiftController();
        $data = $cashshiftController->methods(Auth::id());
        return view("expense.create", compact('expense', 'denomination', 'data', 'categories'));
    }

    public function store(Request $request)
    {
        $rules = [
            'observation' => 'nullable|string|max:100',
            'amount' => 'required|numeric',
            'category_uuid' => 'required|string|max:36|exists:categories,category_uuid',
            'charge_uuid' => 'required|string|max:36',
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
            if ($request->input('amount') == 0) {
                $validator->errors()->add('amount', __('word.rules.rule_eighteen'));
                return;
            }
            if ($request->input('amount') > 10000) {
                $validator->errors()->add('amount', __('word.rules.rule_nineteen'));
                return;
            }
            if ($request->input('amount') < 0) {
                $validator->errors()->add('amount', __('word.rules.rule_twenty'));
                return;
            }
            if (!is_numeric($request->input('amount'))) {
                $validator->errors()->add('amount', __('word.rules.rule_twenty_one'));
                return;
            }
            if (!preg_match('/^\d+(\.\d{1,2})?$/', $request->input('amount'))) {
                $validator->errors()->add('amount', __('word.rules.rule_twenty_two'));
                return;
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
                    $validator->errors()->add('total', __('word.expense.one_validate', ['charge' => $charge, 'total' => $total]));
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
                $cashregister = Cashregister::where('cashregister_uuid', $request->charge_uuid)->first();
                if ($cashregister) {
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
                        'total' => $request->physical_cash ?? 0,
                    ]);
                }
                $expense = Expense::create([
                    'amount' => $request->amount,
                    'observation' => $request->observation,
                    'category_uuid' => $request->category_uuid,
                    'denomination_uuid' => $denomination->denomination_uuid ?? null,
                    'cashshift_uuid' => $cashshift_uuid,
                ]);
                $this->add($expense, $request);
            }
        });
        return redirect("/expenses")->with('success', __('word.expense.alert.store'));
    }

    public function edit(string $expense_uuid)
    {
        $expense = Expense::where('expense_uuid', $expense_uuid)->with(['cashshift','denomination','category', 'cashregisters', 'bankregisters', 'platforms'])->first();
        if (!empty($expense->cashregisters->toArray())) $charge_uuid = $expense->cashregisters()->value('cashregisters.cashregister_uuid');
        if (!empty($expense->bankregisters->toArray())) $charge_uuid = $expense->bankregisters()->value('bankregisters.bankregister_uuid');
        if (!empty($expense->platforms->toArray())) $charge_uuid = $expense->platforms()->value('platforms.platform_uuid');
        $expense->charge_uuid = $charge_uuid;
        $denomination = Denomination::where('denomination_uuid', $expense->denomination_uuid)->first() ?? new Denomination();
        $categories = Category::where("status", '1')->get();
        $cashshiftController = new CashshiftController();
        $data = $cashshiftController->methods($expense->cashshift->user_id);
        return view("expense.edit", compact('expense', 'denomination', 'data', 'categories'));
    }

    public function update(Request $request, string $expense_uuid)
    {
        $expense = Expense::where('expense_uuid', $expense_uuid)->with(['cashshift','denomination','category', 'cashregisters', 'bankregisters', 'platforms'])->first();
        $rules = [
            'observation' => 'nullable|string|max:100',
            'amount' => 'required|numeric',
            'category_uuid' => 'required|string|max:36|exists:categories,category_uuid',
            'charge_uuid' => 'required|string|max:36',
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
            if ($request->input('amount') == 0) {
                $validator->errors()->add('amount', __('word.rules.rule_eighteen'));
                return;
            }
            if ($request->input('amount') > 10000) {
                $validator->errors()->add('amount', __('word.rules.rule_nineteen'));
                return;
            }
            if ($request->input('amount') < 0) {
                $validator->errors()->add('amount', __('word.rules.rule_twenty'));
                return;
            }
            if (!is_numeric($request->input('amount'))) {
                $validator->errors()->add('amount', __('word.rules.rule_twenty_one'));
                return;
            }
            if (!preg_match('/^\d+(\.\d{1,2})?$/', $request->input('amount'))) {
                $validator->errors()->add('amount', __('word.rules.rule_twenty_two'));
                return;
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
                    $validator->errors()->add('method_uuid', __('word.expense.one_validate', ['charge' => $charge, 'total' => $total]));
                }
                return;
            }
        });
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        DB::transaction(function () use ($request, $expense, $expense_uuid) {
            $cashregister = Cashregister::where('cashregister_uuid', $request->charge_uuid)->exists();
            $denomination = Denomination::where('denomination_uuid', $expense->denomination_uuid)->first();
            if ($expense->denomination_uuid && $cashregister) {
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
            if (!$expense->denomination_uuid && $cashregister) {
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
                $expense->update([
                    'denomination_uuid' => $billcoin->denomination_uuid,
                ]);
            }
            if ($expense->denomination_uuid && !$cashregister) {
                $expense->update([
                    'denomination_uuid' => null,
                ]);
                $denomination->delete();
            }
            $expense->update([
                'amount' => $request->amount,
                'observation' => $request->observation,
                'category_uuid' => $request->category_uuid,
            ]);
            $expense->cashregisters()->detach();
            $expense->bankregisters()->detach();
            $expense->platforms()->detach();
            $this->add($expense, $request);
        });
        return redirect("/expenses")->with('success', __('word.expense.alert.update'));
    }

    public function destroy(string $expense_uuid)
    {
        $expense = Expense::where('expense_uuid', $expense_uuid)->with(['denomination'])->first();
        if ($expense){
            DB::transaction(function () use ($expense, $expense_uuid) {
                $expense->cashregisters()->detach();
                $expense->bankregisters()->detach();
                $expense->platforms()->detach();
                $expense->update(['denomination_uuid' => null]);
                if ($expense->denomination) {
                    $expense->denomination->delete();
                }
                $expense->delete();
            });
        }
        return redirect("/expenses")->with('success', __('word.expense.alert.delete'));
    }

    public function detail(string $expense_uuid)
    {
        try {
            $expense = Expense::where('expense_uuid', $expense_uuid)->with(['cashshift','denomination','category', 'cashregisters', 'bankregisters', 'platforms'])->first();
            if ($expense->denomination_uuid) {
                $incomeController = new IncomeController();
                $operation = $incomeController->object_operation($expense->denomination);
            }
            $cashregister = $expense->cashregisters()->select('cashregisters.name as name', 'expense_cashregisters.total as total')->get()->toArray();
            $bankregister = $expense->bankregisters()->select('bankregisters.name as name', 'expense_bankregisters.total as total')->get()->toArray();
            $platform = $expense->platforms()->select('platforms.name as name', 'expense_platforms.total as total')->get()->toArray();
            return response()->json([
                'type' => 'success',
                'title' => __('word.general.success'),
                'denomination' => $expense->denomination ?? null,
                'operation' => $operation ?? null,
                'cashregister' => $cashregister ?? [],
                'bankregister' => $bankregister ?? [],
                'platform' => $platform ?? [],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.general.bad_request'),
            ], 500);
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
            $expenses = Expense::whereBetween('created_at', [$start_date, $end_date])
                ->with(['cashshift','denomination','category', 'cashregisters', 'bankregisters', 'platforms'])->get();
        }else{
            $cashshift_uuids = Cashshift::where('user_id', auth::id())->pluck('cashshift_uuid')->toArray();
            $expenses = Expense::whereBetween('created_at', [$start_date, $end_date])
                ->with(['cashshift','denomination','category', 'cashregisters', 'bankregisters', 'platforms'])
                ->whereIn('cashshift_uuid', $cashshift_uuids)->get();
        }
        $expenses->each(function ($expense) {
            $name = "";
            $total = 0;
            foreach ($expense->cashregisters as $item) {
                $name = $item->name;
                $total = $item->pivot->total;
            }
            foreach ($expense->bankregisters as $item) {
                $name = $item->name;
                $total = $item->pivot->total;
            }
            foreach ($expense->platforms as $item) {
                $name= $item->name;
                $total = $item->pivot->total;
            }
            $expense->format_payment = $expense->category->name ?? "";
            $expense->format_observation = $expense->observation ?? "";
            $expense->format_name = $name ?? "";
            $expense->format_total = $total ?? "";
            $expense->format_user = $expense->cashshift->user->name ?? "";
            $expense->format_created_at = $expense->created_at->format('H:i:s d-m-Y') ?? "";
            $expense->format_updated_at = $expense->updated_at->format('H:i:s d-m-Y') ?? "";
        });
        $range_start = Carbon::parse($start_date)->format('H-i-s_d-m-Y');
        $range_end = Carbon::parse($end_date)->format('H-i-s_d-m-Y');
        $name = __('word.expense.filename');
        $filename = "{$name}_{$range_start}_{$range_end}.xlsx";
        return Excel::download(new ExpenseExport($expenses), $filename);
    }

    public function add($expense, Request $request)
    {
        $sync_cashregister = [];
        $sync_bankregister = [];
        $sync_platform = [];
        if (Cashregister::where('cashregister_uuid', $request->charge_uuid)->exists()) {
            $sync_cashregister[$request->charge_uuid] = [
                'total' => $request->amount,
            ];
        }
        if (Bankregister::where('bankregister_uuid', $request->charge_uuid)->exists()) {
            $sync_bankregister[$request->charge_uuid] = [
                'total' => $request->amount,
            ];
        }
        if (Platform::where('platform_uuid', $request->charge_uuid)->exists()) {
            $sync_platform[$request->charge_uuid] = [
                'total' => $request->amount,
            ];
        }
        if (!empty($sync_cashregister)) {
            $expense->cashregisters()->attach($sync_cashregister);
        }
        if (!empty($sync_bankregister)) {
            $expense->bankregisters()->attach($sync_bankregister);
        }
        if (!empty($sync_platform)) {
            $expense->platforms()->attach($sync_platform);
        }
    }
}
