<?php

namespace App\Http\Controllers;

use App\Exports\IncomeExport;
use App\Models\Bankregister;
use App\Models\Cashregister;
use App\Models\Cashshift;
use App\Models\Denomination;
use App\Models\Income;
use App\Models\Method;
use App\Models\Platform;
use App\Models\Service;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use function Livewire\of;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $incomes = Income::with(['services', 'bankregisters', 'platforms', 'denominations','cashregisters'])->orderBy('created_at', 'desc')->paginate($perPage);
        $incomes->each(function ($income) {
            $cashshift = Cashshift::where('cashshift_uuid', $income->cashshift_uuid)->with(['cashregister', 'user'])->first();
            $services = $income->services->pluck('name')->toArray();
            $transaction = $this->transaction($income);
            $income->names = implode(', ', $services) ?? "";
            $income->input_name = implode(', ', array_unique($transaction[0])) ?? "";
            $income->input_total = $transaction[1] ?? "";
            $income->output_name = implode(', ', array_unique($transaction[2])) ?? "";
            $income->output_total = $transaction[3] ?? "";
            $data = [];
            foreach ($income->services as $service) {
                if (!isset($data[$service->name])) {
                    $data[$service->name] = (object)['name' => '', 'quantity' => 0, 'price' => 0.00,];
                }
                $data[$service->name]->name = $service->name;
                $data[$service->name]->quantity += $service->pivot->quantity;
                $data[$service->name]->price += ($service->pivot->amount + $service->pivot->commission) * $service->pivot->quantity;
            }
            $income->detail = $data;
            $income->user = $cashshift->user->name;
            $income->user_id = $cashshift->user->id;
        });
        $cashshift = Cashshift::where('status', true)->first();
        return view("income.index", compact('incomes', 'perPage', 'cashshift'));
    }

    public function create()
    {
        $income = new Income();
        $denomination = new Denomination();
        $services = Service::where("status", 1)->get();
        $cashshiftController = new CashshiftController();
        $data = $cashshiftController->methods(Auth::id());
        return view("income.create", compact('income', 'denomination', 'services', 'data'));
    }

    public function store(Request $request)
    {
        $rules = [
            'codes' => 'required|array',
            'codes.*' => 'nullable|string|max:30',
            'service_uuids' => 'required|array',
            'service_uuids.*' => 'required|string|max:36|exists:services,service_uuid',
            'amounts' => 'required|array',
            'amounts.*' => 'required|numeric',
            'commissions' => 'required|array',
            'commissions.*' => 'nullable|numeric',
            'values' => 'required|array',
            'values.*' => 'nullable|numeric',
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:1',
            'charge_uuids' => 'required|array',
            'charge_uuids.*' => 'required|string|max:36',
            'payment_uuids' => 'nullable|array',
            'payment_uuids.*' => 'nullable|string|max:36',
            'observation' => 'nullable|string|max:100',
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
            'bil_200' => 'nullable|integer',
            'bil_100' => 'nullable|integer',
            'bil_50' => 'nullable|integer',
            'bil_20' => 'nullable|integer',
            'bil_10' => 'nullable|integer',
            'coi_5' => 'nullable|integer',
            'coi_2' => 'nullable|integer',
            'coi_1' => 'nullable|integer',
            'coi_0_5' => 'nullable|integer',
            'coi_0_2' => 'nullable|integer',
            'coi_0_1' => 'nullable|integer',
            'full' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $validator->after(function ($validator) use ($request) {
            $amounts = $request->input('amounts', []);
            $quantities = $request->input('quantities', []);
            $service_uuids = $request->input('service_uuids', []);
            $charge_uuids = $request->input('charge_uuids', []);
            $quantity_count = count($quantities);
            $service_count = count($service_uuids);
            $charge_count = count($charge_uuids);
            $amount_count = count($amounts);
            if ($quantity_count !== $service_count ||
                $quantity_count !== $charge_count ||
                $quantity_count !== $amount_count ||
                $service_count !== $charge_count ||
                $service_count !== $amount_count ||
                $amount_count !== $charge_count) {
                $validator->errors()->add('service_uuids', __('word.income.one_validate'));
                return;
            }
            foreach ($request->input('amounts') as $amount) {
                if ($amount == 0) {
                    $validator->errors()->add('amounts', __('word.rules.rule_six'));
                    return;
                }
                if ($amount > 10000) {
                    $validator->errors()->add('amounts', __('word.rules.rule_seven'));
                    return;
                }
                if ($amount < 0) {
                    $validator->errors()->add('amounts', __('word.rules.rule_eight'));
                    return;
                }
                if (!$amount) {
                    $validator->errors()->add('amounts', __('word.rules.rule_nine'));
                    return;
                }
                if (!preg_match('/^\d+(\.\d{1,2})?$/', $amount)) {
                    $validator->errors()->add('amounts', __('word.rules.rule_ten'));
                    return;
                }
            }
            foreach ($request->input('commissions') as $amount) {
                if ($amount > 10000) {
                    $validator->errors()->add('commissions', __('word.rules.rule_eleven'));
                    return;
                }
                if ($amount < 0) {
                    $validator->errors()->add('commissions', __('word.rules.rule_twelve'));
                    return;
                }
            }
            foreach ($request->input('values') as $value) {
                if ($value > 10000) {
                    $validator->errors()->add('commissions', __('word.rules.rule_thirty_three'));
                    return;
                }
                if ($value < 0) {
                    $validator->errors()->add('commissions', __('word.rules.rule_thirty_four'));
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
                    $validator->errors()->add('total', __('word.income.two_validate', ['charge' => $charge, 'total' => $total]));
                }
            }
            if ($request->force_payment === "0") {
                if ($request->input('full') > 10000) {
                    $validator->errors()->add('full', __('word.rules.rule_fourteen'));
                    return;
                }
                if ($request->input('full') < 0) {
                    $validator->errors()->add('full', __('word.rules.rule_fifteen'));
                    return;
                }
                $full = number_format($request->full, 1);
                $payment = number_format($request->payment, 1);
                if ($full !== $payment) {
                    $validator->errors()->add('full', __('word.income.two_validate', ['charge' => $payment, 'total' => $full]));
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
                $income = Income::create([
                    'observation' => $request->observation,
                    'cashshift_uuid' => $cashshift_uuid,
                ]);
                $this->add($income, $request);
            }
        });
        return redirect("/incomes")->with('success', __('word.income.alert.store'));
    }

    public function edit(string $income_uuid)
    {
        $income = Income::where('income_uuid', $income_uuid)->with(['services', 'cashregisters', 'denominations', 'bankregisters', 'platforms','cashshift'])->first();
        $denomination_charge = [];
        $denomination_payment = [];
        foreach ($income->denominations as $denomination) {
            if ($denomination->pivot->type == '2') {
                $denomination_charge = $this->object_denomination($denomination);
            }
            if ($denomination->pivot->type == '3') {
                $denomination_payment = $this->object_denomination($denomination);
            }
        }
        if (!$denomination_charge) $denomination_charge = $this->object_denomination(0);
        if (!$denomination_payment) $denomination_payment = $this->object_denomination(0);
        $codes = [];
        $quantities = [];
        $amounts = [];
        $commissions = [];
        $service_uuids = [];
        foreach ($income->services as $key => $service) {
            if ($service->pivot->index == $key) {
                $codes[] = $service->pivot->code;
                $quantities[] = $service->pivot->quantity;
                $amounts[] = $service->pivot->amount;
                $commissions[] = $service->pivot->commission;
                $service_uuids[] = $service->pivot->service_uuid;
            }
        }
        $income->codes = $codes;
        $income->quantities = $quantities;
        $income->amounts = $amounts;
        $income->commissions = $commissions;
        $income->service_uuids = $service_uuids;
        $charge_uuids = [];
        $payment_uuids = [];
        $values = [];
        foreach ($income->services as $key => $item) {
            $cashregister_input = $income->cashregisters()->wherePivot('type','2')->wherePivot('index',$key)->first();
            $bankregister_input = $income->bankregisters()->wherePivot('type','2')->wherePivot('index',$key)->first();
            $platform_input = $income->platforms()->wherePivot('type','2')->wherePivot('index',$key)->first();
            $cashregister_output = $income->cashregisters()->wherePivot('type','3')->wherePivot('index',$key)->first();
            $bankregister_output = $income->bankregisters()->wherePivot('type','3')->wherePivot('index',$key)->first();
            $platform_output = $income->platforms()->wherePivot('type','3')->wherePivot('index',$key)->first();
            if ($cashregister_input) $charge_uuids[$key] = $cashregister_input->cashregister_uuid;
            if ($bankregister_input) $charge_uuids[$key] = $bankregister_input->bankregister_uuid;
            if ($platform_input) $charge_uuids[$key] = $platform_input->platform_uuid;
            if ($cashregister_output) {
                $payment_uuids[$key] = $cashregister_output->cashregister_uuid;
                $values[$key] = $cashregister_output->pivot->total;
            }
            if ($bankregister_output) {
                $payment_uuids[$key] = $bankregister_output->bankregister_uuid;
                $values[$key] = $bankregister_output->pivot->total;
            }
            if ($platform_output) {
                $payment_uuids[$key] = $platform_output->platform_uuid;
                $values[$key] = $platform_output->pivot->total;
            }
        }

        $income->charge_uuids = $charge_uuids;
        $income->payment_uuids = $payment_uuids;
        $income->values = $values;

        $services = Service::where("status", 1)->get();
        $cashshiftController = new CashshiftController();
        $data = $cashshiftController->methods($income->cashshift->user_id);
        return view("income.edit", compact('income', 'denomination_charge', 'denomination_payment', 'services', 'data'));
    }

    public function update(Request $request, string $income_uuid)
    {
        $income = Income::where('income_uuid', $income_uuid)->with(['services', 'cashregisters', 'denominations', 'bankregisters', 'platforms'])->first();
        $rules = [
            'codes' => 'required|array',
            'codes.*' => 'nullable|string|max:30',
            'service_uuids' => 'required|array',
            'service_uuids.*' => 'required|string|max:36|exists:services,service_uuid',
            'amounts' => 'required|array',
            'amounts.*' => 'required|numeric',
            'commissions' => 'required|array',
            'commissions.*' => 'nullable|numeric',
            'values' => 'required|array',
            'values.*' => 'nullable|numeric',
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:1',
            'charge_uuids' => 'required|array',
            'charge_uuids.*' => 'required|string|max:36',
            'payment_uuids' => 'nullable|array',
            'payment_uuids.*' => 'nullable|string|max:36',
            'observation' => 'nullable|string|max:100',
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
            'bil_200' => 'nullable|integer',
            'bil_100' => 'nullable|integer',
            'bil_50' => 'nullable|integer',
            'bil_20' => 'nullable|integer',
            'bil_10' => 'nullable|integer',
            'coi_5' => 'nullable|integer',
            'coi_2' => 'nullable|integer',
            'coi_1' => 'nullable|integer',
            'coi_0_5' => 'nullable|integer',
            'coi_0_2' => 'nullable|integer',
            'coi_0_1' => 'nullable|integer',
            'full' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $validator->after(function ($validator) use ($request) {
            $amounts = $request->input('amounts', []);
            $quantities = $request->input('quantities', []);
            $service_uuids = $request->input('service_uuids', []);
            $charge_uuids = $request->input('charge_uuids', []);
            $quantity_count = count($quantities);
            $service_count = count($service_uuids);
            $charge_count = count($charge_uuids);
            $amount_count = count($amounts);
            if ($quantity_count !== $service_count ||
                $quantity_count !== $charge_count ||
                $quantity_count !== $amount_count ||
                $service_count !== $charge_count ||
                $service_count !== $amount_count ||
                $amount_count !== $charge_count) {
                $validator->errors()->add('service_uuids', __('word.income.one_validate'));
                return;
            }
            foreach ($request->input('amounts') as $amount) {
                if ($amount == 0) {
                    $validator->errors()->add('amounts', __('word.rules.rule_six'));
                    return;
                }
                if ($amount > 10000) {
                    $validator->errors()->add('amounts', __('word.rules.rule_seven'));
                    return;
                }
                if ($amount < 0) {
                    $validator->errors()->add('amounts', __('word.rules.rule_eight'));
                    return;
                }
                if (!$amount) {
                    $validator->errors()->add('amounts', __('word.rules.rule_nine'));
                    return;
                }
                if (!preg_match('/^\d+(\.\d{1,2})?$/', $amount)) {
                    $validator->errors()->add('amounts', __('word.rules.rule_ten'));
                    return;
                }
            }
            foreach ($request->input('commissions') as $amount) {
                if ($amount > 10000) {
                    $validator->errors()->add('commissions', __('word.rules.rule_eleven'));
                    return;
                }
                if ($amount < 0) {
                    $validator->errors()->add('commissions', __('word.rules.rule_twelve'));
                    return;
                }
            }
            foreach ($request->input('values') as $value) {
                if ($value > 10000) {
                    $validator->errors()->add('commissions', __('word.rules.rule_thirty_three'));
                    return;
                }
                if ($value < 0) {
                    $validator->errors()->add('commissions', __('word.rules.rule_thirty_four'));
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
                    $validator->errors()->add('total', __('word.income.two_validate', ['charge' => $charge, 'total' => $total]));
                }
            }
            if ($request->force_payment === "0") {
                if ($request->input('full') > 10000) {
                    $validator->errors()->add('full', __('word.rules.rule_fourteen'));
                    return;
                }
                if ($request->input('full') < 0) {
                    $validator->errors()->add('full', __('word.rules.rule_fifteen'));
                    return;
                }
                $full = number_format($request->full, 1);
                $payment = number_format($request->payment, 1);
                if ($full !== $payment) {
                    $validator->errors()->add('full', __('word.income.two_validate', ['charge' => $payment, 'total' => $full]));
                }
                return;
            }
        });
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        DB::transaction(function () use ($request, $income, $income_uuid) {
            $income->update([
                'observation' => $request->observation,
            ]);
            foreach ($income->denominations as $denomination){
                $denomination->delete();
            }
            $income->services()->detach();
            $income->cashregisters()->detach();
            $income->denominations()->detach();
            $income->bankregisters()->detach();
            $income->platforms()->detach();
            $this->add($income, $request);
        });
        return redirect("/incomes")->with('success', __('word.income.alert.update'));
    }

    public function destroy(string $income_uuid)
    {
        $income = Income::where('income_uuid', $income_uuid)->first();
        if ($income) {
            DB::transaction(function () use ($income, $income_uuid) {
                foreach ($income->denominations as $denomination){
                    $denomination->delete();
                }
                $income->services()->detach();
                $income->cashregisters()->detach();
                $income->denominations()->detach();
                $income->bankregisters()->detach();
                $income->platforms()->detach();
                $income->delete();
            });
        }
        return redirect("/incomes")->with('success', __('word.income.alert.delete'));
    }

    public function detail(string $income_uuid)
    {
        try {
            $income = Income::where('income_uuid', $income_uuid)->with(['services', 'cashregisters', 'denominations', 'bankregisters', 'platforms','cashshift'])->first();
            $denomination_input = $income->denominations()->wherePivot('type','2')->first();
            $cashregister_input = $income->cashregisters()->wherePivot('type','2')
                ->select('cashregisters.name as name', 'income_cashregisters.total as total')->get()->toArray();
            $bankregister_input = $income->bankregisters()->wherePivot('type','2')
                ->select('bankregisters.name as name', 'income_bankregisters.total as total')->get()->toArray();
            $platform_input = $income->platforms()->wherePivot('type','2')
                ->select('platforms.name as name', 'income_platforms.total as total')->get()->toArray();
            $denomination_output = $income->denominations()->wherePivot('type','3')->first();
            $cashregister_output = $income->cashregisters()->wherePivot('type','3')
                ->select('cashregisters.name as name', 'income_cashregisters.total as total')->get()->toArray();
            $bankregister_output = $income->bankregisters()->wherePivot('type','3')
                ->select('bankregisters.name as name', 'income_bankregisters.total as total')->get()->toArray();
            $platform_output = $income->platforms()->wherePivot('type','3')
                ->select('platforms.name as name', 'income_platforms.total as total')->get()->toArray();
            $operation_input = null;
            $operation_output = null;
            if ($denomination_input) {
                $operation_input = $this->object_operation($denomination_input);
            }
            if ($denomination_output) {
                $operation_output = $this->object_operation($denomination_output);
            }
            return response()->json([
                'type' => 'success',
                'title' => __('word.general.success'),
                'denomination_input' => $denomination_input ?? null,
                'operation_input' => $operation_input ?? null,
                'denomination_output' => $denomination_output ?? null,
                'operation_output' => $operation_output ?? null,
                'cashregister_input' => $cashregister_input ?? null,
                'bankregister_input' => $bankregister_input ?? null,
                'platform_input' => $platform_input ?? null,
                'cashregister_output' => $cashregister_output ?? null,
                'bankregister_output' => $bankregister_output ?? null,
                'platform_output' => $platform_output ?? null,
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

    public function add($income, Request $request){
        $sync_service = [];
        foreach ($request->service_uuids as $key => $service_uuid) {
            $sync_service[$service_uuid][] = [
                'code' => $request->codes[$key],
                'quantity' => $request->quantities[$key],
                'amount' => $request->amounts[$key],
                'commission' => $request->commissions[$key],
                'index' => $key,
            ];
        }
        foreach ($sync_service as $service_uuid => $data) {
            foreach ($data as $entry) {
                $income->services()->attach($service_uuid, $entry);
            }
        }
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
            $income->denominations()->attach([$denomination->denomination_uuid => ['type' => '2']]);
        }
        if (Cashregister::whereIn('cashregister_uuid', $request->payment_uuids)->exists()) {
            $denomination = Denomination::create([
                'bill_200' => $request->bil_200 ?? 0,
                'bill_100' => $request->bil_100 ?? 0,
                'bill_50' => $request->bil_50 ?? 0,
                'bill_20' => $request->bil_20 ?? 0,
                'bill_10' => $request->bil_10 ?? 0,
                'coin_5' => $request->coi_5 ?? 0,
                'coin_2' => $request->coi_2 ?? 0,
                'coin_1' => $request->coi_1 ?? 0,
                'coin_0_5' => $request->coi_0_5 ?? 0,
                'coin_0_2' => $request->coi_0_2 ?? 0,
                'coin_0_1' => $request->coi_0_1 ?? 0,
                'total' => $request->payment_physical_cash,
            ]);
            $income->denominations()->attach([$denomination->denomination_uuid => ['type' => '3']]);
        }
        $sync_cashregister_input = [];
        $sync_bankregister_input = [];
        $sync_platform_input = [];
        $sync_cashregister_output = [];
        $sync_bankregister_output = [];
        $sync_platform_output = [];
        foreach ($request->charge_uuids as $key => $reference_uuid) {
            $total = ($request->amounts[$key] + $request->commissions[$key]) * $request->quantities[$key];
            if ($total > 0){
                if (Cashregister::where('cashregister_uuid', $reference_uuid)->exists()) {
                    $sync_cashregister_input[$reference_uuid][] = [
                        'total' => $total,
                        'type' => '2',
                        'index' => $key
                    ];
                }
                if (Bankregister::where('bankregister_uuid', $reference_uuid)->exists()) {
                    $sync_bankregister_input[$reference_uuid][] = [
                        'total' => $total,
                        'type' => '2',
                        'index' => $key
                    ];
                }
                if (Platform::where('platform_uuid', $reference_uuid)->exists()) {
                    $sync_platform_input[$reference_uuid][] = [
                        'total' => $total,
                        'type' => '2',
                        'index' => $key
                    ];
                }
            }
        }
        foreach ($request->charge_uuids as $key => $charge_uuid) {
            $reference_uuid = $request->payment_uuids[$key];
            $total = $request->values[$key];
            if ($total > 0){
                if (Cashregister::where('cashregister_uuid', $reference_uuid)->exists()) {
                    $sync_cashregister_output[$reference_uuid][] = [
                        'total' => $total,
                        'type' => '3',
                        'index' => $key
                    ];
                }
                if (Bankregister::where('bankregister_uuid', $reference_uuid)->exists()) {
                    $sync_bankregister_output[$reference_uuid][] = [
                        'total' => $total,
                        'type' => '3',
                        'index' => $key
                    ];
                }
                if (Platform::where('platform_uuid', $reference_uuid)->exists()) {
                    $sync_platform_output[$reference_uuid][] = [
                        'total' => $total,
                        'type' => '3',
                        'index' => $key
                    ];
                }
            }
        }
        foreach ($sync_cashregister_input as $cashregister_uuid => $data) {
            foreach ($data as $entry) {
                $income->cashregisters()->attach($cashregister_uuid, $entry);
            }
        }
        foreach ($sync_bankregister_input as $bankregister_uuid => $data) {
            foreach ($data as $entry) {
                $income->bankregisters()->attach($bankregister_uuid, $entry);
            }
        }
        foreach ($sync_platform_input as $platform_uuid => $data) {
            foreach ($data as $entry) {
                $income->platforms()->attach($platform_uuid, $entry);
            }
        }
        foreach ($sync_cashregister_output as $cashregister_uuid => $data) {
            foreach ($data as $entry) {
                $income->cashregisters()->attach($cashregister_uuid, $entry);
            }
        }
        foreach ($sync_bankregister_output as $bankregister_uuid => $data) {
            foreach ($data as $entry) {
                $income->bankregisters()->attach($bankregister_uuid, $entry);
            }
        }
        foreach ($sync_platform_output as $platform_uuid => $data) {
            foreach ($data as $entry) {
                $income->platforms()->attach($platform_uuid, $entry);
            }
        }
    }
    public function object_operation($denomination)
    {
        $operation = (object)[
            'bill_200' => number_format($denomination->bill_200 * 200, 2,'.',''),
            'bill_100' => number_format($denomination->bill_100 * 100, 2,'.',''),
            'bill_50' => number_format($denomination->bill_50 * 50, 2,'.',''),
            'bill_20' => number_format($denomination->bill_20 * 20, 2,'.',''),
            'bill_10' => number_format($denomination->bill_10 * 10, 2,'.',''),
            'coin_5' => number_format($denomination->coin_5 * 5, 2,'.',''),
            'coin_2' => number_format($denomination->coin_2 * 2, 2,'.',''),
            'coin_1' => number_format($denomination->coin_1 * 1, 2,'.',''),
            'coin_0_5' => number_format($denomination->coin_0_5 * 0.5, 2,'.',''),
            'coin_0_2' => number_format($denomination->coin_0_2 * 0.2, 2,'.',''),
            'coin_0_1' => number_format($denomination->coin_0_1 * 0.1, 2,'.',''),
        ];
        return $operation;
    }
    public function object_denomination($denomination)
    {
        $object = (object)[
            'bill_200' => $denomination->bill_200 ?? 0,
            'bill_100' => $denomination->bill_100 ?? 0,
            'bill_50' => $denomination->bill_50 ?? 0,
            'bill_20' => $denomination->bill_20 ?? 0,
            'bill_10' => $denomination->bill_10 ?? 0,
            'coin_5' => $denomination->coin_5 ?? 0,
            'coin_2' => $denomination->coin_2 ?? 0,
            'coin_1' => $denomination->coin_1 ?? 0,
            'coin_0_5' => $denomination->coin_0_5 ?? 0,
            'coin_0_2' => $denomination->coin_0_2 ?? 0,
            'coin_0_1' => $denomination->coin_0_1 ?? 0,
            'total' => $denomination->total ?? 0,
        ];
        return $object;
    }

    public function transaction($income){
        $input_names = [];
        $input_total = 0;
        $output_names = [];
        $output_total = 0;
        foreach ($income->cashregisters as $cashregister) {
            if ($cashregister->pivot->type == '2') {
                $input_names[] = $cashregister->name;
                $input_total += $cashregister->pivot->total;
            }
        }
        foreach ($income->bankregisters as $bankregister) {
            if ($bankregister->pivot->type == '2') {
                $input_names[] = $bankregister->name;
                $input_total += $bankregister->pivot->total;
            }
        }
        foreach ($income->platforms as $platform) {
            if ($platform->pivot->type == '2') {
                $input_names[] = $platform->name;
                $input_total += $platform->pivot->total;
            }
        }
        foreach ($income->cashregisters as $cashregister) {
            if ($cashregister->pivot->type == '3') {
                $output_names[] = $cashregister->name;
                $output_total += $cashregister->pivot->total;
            }
        }
        foreach ($income->bankregisters as $bankregister) {
            if ($bankregister->pivot->type == '3') {
                $output_names[] = $bankregister->name;
                $output_total += $bankregister->pivot->total;
            }
        }
        foreach ($income->platforms as $platform) {
            if ($platform->pivot->type == '3') {
                $output_names[] = $platform->name;
                $output_total += $platform->pivot->total;
            }
        }
        return [$input_names,$input_total,$output_names,$output_total];
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
            $incomes = Income::whereBetween('created_at', [$start_date, $end_date])
                ->with(['cashshift','services', 'bankregisters', 'platforms', 'denominations','cashregisters'])->get();
        }else{
            $cashshift_uuids = Cashshift::where('user_id', auth::id())->pluck('cashshift_uuid')->toArray();
            $incomes = Income::whereBetween('created_at', [$start_date, $end_date])
                ->with(['cashshift','services', 'bankregisters', 'platforms', 'denominations','cashregisters'])
                ->whereIn('cashshift_uuid', $cashshift_uuids)->get();
        }
        $incomes->each(function ($income) {
            $services = $income->services->pluck('name')->toArray();
            $transaction = $this->transaction($income);
            $income->format_services = implode(', ', $services) ?? "";
            $income->format_input_name = implode(', ', array_unique($transaction[0])) ?? "";
            $income->format_input_amount = $transaction[1] ?? "";
            $income->format_output_name = implode(', ',array_unique($transaction[2])) ?? "";
            $income->format_output_amount = $transaction[3] ?? "";
            $income->format_observation = $income->observation ?? "";
            $income->format_user = $income->cashshift->user->name ?? "";
            $income->format_created_at = $income->created_at->format('H:i:s d-m-Y') ?? "";
            $income->format_updated_at = $income->updated_at->format('H:i:s d-m-Y') ?? "";
        });
        $range_start = Carbon::parse($start_date)->format('H-i-s_d-m-Y');
        $range_end = Carbon::parse($end_date)->format('H-i-s_d-m-Y');
        $name = __('word.income.filename');
        $filename = "{$name}_{$range_start}_{$range_end}.xlsx";
        return Excel::download(new IncomeExport($incomes), $filename);
    }
}
