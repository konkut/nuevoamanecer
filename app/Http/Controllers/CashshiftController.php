<?php

namespace App\Http\Controllers;

use App\Models\Bankregister;
use App\Models\Cashregister;
use App\Models\Cashshift;
use App\Models\Denomination;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Paymentwithoutprice;
use App\Models\Paymentwithprice;
use App\Models\Platform;
use App\Models\Sale;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isEmpty;

class CashshiftController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $cashshifts = Cashshift::orderBy('created_at', 'desc')->with(['user', 'cashregister', 'bankregisters', 'platforms', 'denominations'])->paginate($perPage);
        $cashshifts->each(function ($cashshift) {
            $cashshift->cash_name = $cashshift->cashregister->name;
            $cashshift->cash_opening_total = $cashshift->denominations()->wherePivot('type','1')->value('denominations.total');
            $cashshift->cash_closing_total = $cashshift->denominations()->wherePivot('type','4')->value('denominations.total');
            $bank_names = $cashshift->bankregisters()->wherePivot('type','1')->select('bankregisters.name')->get()->toArray();
            $cashshift->bank_name = implode(', ', array_column($bank_names, 'name')) ?? "";
            $bank_opening_totals = $cashshift->bankregisters()->wherePivot('type','1')->select('cashshift_bankregisters.total')->get()->toArray();
            $bank_closing_totals = $cashshift->bankregisters()->wherePivot('type','4')->select('cashshift_bankregisters.total')->get()->toArray();
            $cashshift->bank_opening_total = implode(', ', array_column($bank_opening_totals, 'total')) ?? "";
            $cashshift->bank_closing_total = implode(', ', array_column($bank_closing_totals, 'total')) ?? "";
            $platform_names = $cashshift->platforms()->wherePivot('type','1')->select('platforms.name')->get()->toArray();
            $cashshift->platform_name = implode(', ', array_column($platform_names, 'name')) ?? "";
            $platform_opening_totals = $cashshift->platforms()->wherePivot('type','1')->select('cashshift_platforms.total')->get()->toArray();
            $platform_closing_totals = $cashshift->platforms()->wherePivot('type','4')->select('cashshift_platforms.total')->get()->toArray();
            $cashshift->platform_opening_total = implode(', ', array_column($platform_opening_totals, 'total')) ?? "";
            $cashshift->platform_closing_total = implode(', ', array_column($platform_closing_totals, 'total')) ?? "";
            $cashshift->start_time = $cashshift->start_time ? Carbon::parse($cashshift->start_time)->format('H:i d/m/Y') : null;
            $cashshift->end_time = $cashshift->end_time ? Carbon::parse($cashshift->end_time)->format('H:i d/m/Y') : null;
        });
        return view("cashshift.index", compact('cashshifts', 'perPage'));
    }

    public function create()
    {
        $cashshift = new Cashshift();
        $denomination = new Denomination();
        $users = User::all();
        $cashregisters = Cashregister::where("status", true)->get();
        $bankregisters = Bankregister::where("status", true)->get();
        $platforms = Platform::where("status", true)->get();
        return view("cashshift.create", compact('cashshift', 'denomination', 'cashregisters', 'users', 'bankregisters', 'platforms'));
    }

    public function store(Request $request)
    {
        $rules = [
            'start_time' => 'required|date_format:Y-m-d\TH:i|after_or_equal:today',
            'end_time' => 'nullable|date_format:Y-m-d\TH:i|after:start_time',
            'cashregister_uuid' => 'required|string|max:36|exists:cashregisters,cashregister_uuid',
            'price_cash' => 'required|numeric',
            'bankregister_uuids' => 'required|array',
            'bankregister_uuids.*' => 'required|string|max:36|exists:bankregisters,bankregister_uuid',
            'amount_bank' => 'required|array',
            'amount_bank.*' => 'required|numeric',
            'platform_uuids' => 'required|array',
            'platform_uuids.*' => 'required|string|max:36|exists:platforms,platform_uuid',
            'amount_platform' => 'required|array',
            'amount_platform.*' => 'required|numeric',
            'user_id' => 'required|integer',
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
            $amounts = count($request->input('amount_bank', []));
            $bankregister_uuids = count($request->input('bankregister_uuids', []));
            if ($amounts !== $bankregister_uuids) {
                $validator->errors()->add('bankregister_uuids', __('word.cashshift.three_validation'));
                return;
            }
            $values = count($request->input('amount_platform', []));
            $platform_uuids = count($request->input('platform_uuids', []));
            if ($values !== $platform_uuids) {
                $validator->errors()->add('platform_uuids', __('word.cashshift.six_validation'));
                return;
            }
            if ($request->input('user_id')) {
                $cashshift = Cashshift::where('user_id', $request->input('user_id'))->where('status', true)->with('user')->first();
                if ($cashshift) {
                    $validator->errors()->add('user_id', __('word.cashshift.one_validation', ['name' => $cashshift->user->name]));
                    return;
                }
            }
            if ($request->input('cashregister_uuid')) {
                $cashshift = Cashshift::where('cashregister_uuid', $request->input('cashregister_uuid'))
                    ->where('status', true)->with('cashregister')->first();
                if ($cashshift) {
                    $validator->errors()->add('cashregister_uuid', __('word.cashshift.two_validation', ['name' => $cashshift->cashregister->name]));
                    return;
                }
            }
            if ($request->input('bankregister_uuids')) {
                foreach ($request->input('bankregister_uuids') as $bankregister_uuid) {
                    $bankregister = Bankregister::where('bankregister_uuid', $bankregister_uuid)->with('cashshifts')->first();
                    foreach ($bankregister->cashshifts as $cashshift) {
                        if ($cashshift->status) {
                            $validator->errors()->add('bankregister_uuids', __('word.cashshift.four_validation', ['name' => $bankregister->name]));
                            return;
                        }
                    }
                }
            }
            if ($request->input('platform_uuids')) {
                foreach ($request->input('platform_uuids') as $platform_uuid) {
                    $platforms = Platform::where('platform_uuid', $platform_uuid)->with('cashshifts')->first();
                    foreach ($platforms->cashshifts as $cashshift) {
                        if ($cashshift->status) {
                            $validator->errors()->add('platform_uuids', __('word.cashshift.seven_validation', ['name' => $platforms->name]));
                            return;
                        }
                    }
                }
            }
            if ($request->input('price_cash') == 0) {
                $validator->errors()->add('price_cash', __('word.rules.rule_twenty_three'));
                return;
            }
            if ($request->input('price_cash') > 10000) {
                $validator->errors()->add('price_cash', __('word.rules.rule_twenty_four'));
                return;
            }
            if ($request->input('price_cash') < 0) {
                $validator->errors()->add('price_cash', __('word.rules.rule_twenty_five'));
                return;
            }
            if (!is_numeric($request->input('price_cash'))) {
                $validator->errors()->add('price_cash', __('word.rules.rule_twenty_six'));
                return;
            }
            if (!preg_match('/^\d+(\.\d{1,2})?$/', $request->input('price_cash'))) {
                $validator->errors()->add('price_cash', __('word.rules.rule_twenty_seven'));
                return;
            }
            foreach ($request->input('amount_bank') as $amount) {
                if ($amount == 0) {
                    $validator->errors()->add('amount_bank', __('word.rules.rule_twenty_eight'));
                    return;
                }
                if ($amount > 10000) {
                    $validator->errors()->add('amount_bank', __('word.rules.rule_twenty_nine'));
                    return;
                }
                if ($amount < 0) {
                    $validator->errors()->add('amount_bank', __('word.rules.rule_thirty'));
                    return;
                }
                if (!is_numeric($amount)) {
                    $validator->errors()->add('amount_bank', __('word.rules.rule_thirty_one'));
                    return;
                }
                if (!preg_match('/^\d+(\.\d{1,2})?$/', $amount)) {
                    $validator->errors()->add('amount_bank', __('word.rules.rule_thirty_two'));
                    return;
                }
            }
            foreach ($request->input('amount_platform') as $amount) {
                if ($amount == 0) {
                    $validator->errors()->add('amount_platform', __('word.rules.rule_twenty_eight'));
                    return;
                }
                if ($amount > 10000) {
                    $validator->errors()->add('amount_platform', __('word.rules.rule_twenty_nine'));
                    return;
                }
                if ($amount < 0) {
                    $validator->errors()->add('amount_platform', __('word.rules.rule_thirty'));
                    return;
                }
                if (!is_numeric($amount)) {
                    $validator->errors()->add('amount_platform', __('word.rules.rule_thirty_one'));
                    return;
                }
                if (!preg_match('/^\d+(\.\d{1,2})?$/', $amount)) {
                    $validator->errors()->add('amount_platform', __('word.rules.rule_thirty_two'));
                    return;
                }
            }
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
                $validator->errors()->add('total', __('word.cashshift.five_validation', ['charge' => $charge, 'total' => $total]));
                return;
            }
        });
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        DB::transaction(function () use ($request) {
            $cashshift = Cashshift::create([
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'user_id' => $request->user_id,
                'cashregister_uuid' => $request->cashregister_uuid,
            ]);
            $this->add($cashshift, $request);
        });
        return redirect("/cashshifts")->with('success', __('word.cashshift.alert.store'));
    }

    public function edit(string $cashshift_uuid)
    {
        $cashshift = Cashshift::where('cashshift_uuid', $cashshift_uuid)->with('denominations')->first();
        $denomination = DB::table('cashshift_denominations')
            ->join('denominations', 'cashshift_denominations.denomination_uuid', '=', 'denominations.denomination_uuid')
            ->where('cashshift_denominations.cashshift_uuid', $cashshift_uuid)
            ->where('cashshift_denominations.type', '1')->first();
        $cashshift->price = $denomination->total;
        $bankregisters = DB::table('cashshift_bankregisters')
            ->join('cashshifts', 'cashshift_bankregisters.cashshift_uuid', '=', 'cashshifts.cashshift_uuid')
            ->where('cashshift_bankregisters.cashshift_uuid', $cashshift_uuid)
            ->where('cashshift_bankregisters.type', '1')->get();
        $cashshift->bankregister_uuids = $bankregisters->pluck('bankregister_uuid')->toArray();
        $cashshift->amounts = $bankregisters->pluck('total')->toArray();
        $platforms = DB::table('cashshift_platforms')
            ->join('cashshifts', 'cashshift_platforms.cashshift_uuid', '=', 'cashshifts.cashshift_uuid')
            ->where('cashshift_platforms.cashshift_uuid', $cashshift_uuid)
            ->where('cashshift_platforms.type', '1')->get();
        $cashshift->platform_uuids = $platforms->pluck('platform_uuid')->toArray();
        $cashshift->values = $platforms->pluck('total')->toArray();
        $users = User::all();
        $cashregisters = Cashregister::where("status", true)->get();
        $bankregisters = Bankregister::where("status", true)->get();
        $platforms = Platform::where("status", true)->get();
        return view("cashshift.edit", compact('cashshift', 'denomination', 'cashregisters', 'users', 'bankregisters', 'platforms'));
    }

    public function update(Request $request, string $cashshift_uuid)
    {
        $cashshift = Cashshift::where('cashshift_uuid', $cashshift_uuid)->first();
        $denomination_uuid = DB::table('cashshift_denominations')
            ->join('denominations', 'cashshift_denominations.denomination_uuid', '=', 'denominations.denomination_uuid')
            ->where('cashshift_denominations.cashshift_uuid', $cashshift_uuid)
            ->where('cashshift_denominations.type', '1')->value('denominations.denomination_uuid');
        $denomination = Denomination::where('denomination_uuid', $denomination_uuid)->first();
        $rules = [
            'start_time' => 'required|date_format:Y-m-d\TH:i|after_or_equal:today',
            'end_time' => 'nullable|date_format:Y-m-d\TH:i|after:start_time',
            'cashregister_uuid' => 'required|string|max:36|exists:cashregisters,cashregister_uuid',
            'price_cash' => 'required|numeric',
            'bankregister_uuids' => 'required|array',
            'bankregister_uuids.*' => 'required|string|max:36|exists:bankregisters,bankregister_uuid',
            'amount_bank' => 'required|array',
            'amount_bank.*' => 'required|numeric',
            'platform_uuids' => 'required|array',
            'platform_uuids.*' => 'required|string|max:36|exists:platforms,platform_uuid',
            'amount_platform' => 'required|array',
            'amount_platform.*' => 'required|numeric',
            'user_id' => 'required|integer',
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
        $validator->after(function ($validator) use ($request, $cashshift) {
            $amounts = count($request->input('amount_bank', []));
            $bankregister_uuids = count($request->input('bankregister_uuids', []));
            if ($amounts !== $bankregister_uuids) {
                $validator->errors()->add('bankregister_uuids', __('word.cashshift.three_validation'));
                return;
            }
            $values = count($request->input('amount_platform', []));
            $platform_uuids = count($request->input('platform_uuids', []));
            if ($values !== $platform_uuids) {
                $validator->errors()->add('platform_uuids', __('word.cashshift.six_validation'));
                return;
            }
            if ($request->input('user_id')) {
                if ($cashshift->user_id != $request->input('user_id')) {
                    $cashshift_user = Cashshift::where('user_id', $request->input('user_id'))->where('status', true)->with('user')->first();
                    if ($cashshift_user) {
                        $validator->errors()->add('user_id', __('word.cashshift.one_validation', ['name' => $cashshift_user->user->name]));
                        return;
                    }
                }
            }
            if ($request->input('cashregister_uuid')) {
                if ($cashshift->cashregister_uuid != $request->input('cashregister_uuid')) {
                    $cashshift_name = Cashshift::where('cashregister_uuid', $request->input('cashregister_uuid'))->where('status', true)->with('cashregister')->first();
                    if ($cashshift_name) {
                        $validator->errors()->add('cashregister_uuid', __('word.cashshift.two_validation', ['name' => $cashshift_name->cashregister->name]));
                        return;
                    }
                }
            }
            if ($request->input('bankregister_uuids')) {
                foreach ($request->input('bankregister_uuids') as $bankregister_uuid) {
                    $bankregister_uuids = DB::table('cashshift_bankregisters')
                        ->where('cashshift_bankregisters.cashshift_uuid', $cashshift->cashshift_uuid)
                        ->where('cashshift_bankregisters.type', '1')->pluck('bankregister_uuid')->toArray();
                    $verified = in_array($bankregister_uuid, $bankregister_uuids);
                    if (!$verified) {
                        $bankregister = Bankregister::where('bankregister_uuid', $bankregister_uuid)->with('cashshifts')->first();
                        foreach ($bankregister->cashshifts as $cashshift) {
                            if ($cashshift->status) {
                                $validator->errors()->add('bankregister_uuids', __('word.cashshift.four_validation', ['name' => $bankregister->name]));
                                return;
                            }
                        }
                    }
                }
            }
            if ($request->input('platform_uuids')) {
                foreach ($request->input('platform_uuids') as $platform_uuid) {
                    $platform_uuids = DB::table('cashshift_platforms')
                        ->where('cashshift_platforms.cashshift_uuid', $cashshift->cashshift_uuid)
                        ->where('cashshift_platforms.type', '1')->pluck('platform_uuid')->toArray();
                    $verified = in_array($platform_uuid, $platform_uuids);
                    if (!$verified) {
                        $platforms = Platform::where('platform_uuid', $platform_uuid)->with('cashshifts')->first();
                        foreach ($platforms->cashshifts as $cashshift) {
                            if ($cashshift->status) {
                                $validator->errors()->add('platform_uuids', __('word.cashshift.seven_validation', ['name' => $platforms->name]));
                                return;
                            }
                        }
                    }
                }
            }
            if ($request->input('price_cash') == 0) {
                $validator->errors()->add('price_cash', __('word.rules.rule_twenty_three'));
                return;
            }
            if ($request->input('price_cash') > 10000) {
                $validator->errors()->add('price_cash', __('word.rules.rule_twenty_four'));
                return;
            }
            if ($request->input('price_cash') < 0) {
                $validator->errors()->add('price_cash', __('word.rules.rule_twenty_five'));
                return;
            }
            if (!is_numeric($request->input('price_cash'))) {
                $validator->errors()->add('price_cash', __('word.rules.rule_twenty_six'));
                return;
            }
            if (!preg_match('/^\d+(\.\d{1,2})?$/', $request->input('price_cash'))) {
                $validator->errors()->add('price_cash', __('word.rules.rule_twenty_seven'));
                return;
            }
            foreach ($request->input('amount_bank') as $amount) {
                if ($amount == 0) {
                    $validator->errors()->add('amount_bank', __('word.rules.rule_twenty_eight'));
                    return;
                }
                if ($amount > 10000) {
                    $validator->errors()->add('amount_bank', __('word.rules.rule_twenty_nine'));
                    return;
                }
                if ($amount < 0) {
                    $validator->errors()->add('amount_bank', __('word.rules.rule_thirty'));
                    return;
                }
                if (!is_numeric($amount)) {
                    $validator->errors()->add('amount_bank', __('word.rules.rule_thirty_one'));
                    return;
                }
                if (!preg_match('/^\d+(\.\d{1,2})?$/', $amount)) {
                    $validator->errors()->add('amount_bank', __('word.rules.rule_thirty_two'));
                    return;
                }
            }
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
                $validator->errors()->add('total', __('word.cashshift.five_validation', ['charge' => $charge, 'total' => $total]));
                return;
            }
        });
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        DB::transaction(function () use ($request, $cashshift, $denomination) {
            $cashshift->update([
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'user_id' => $request->user_id,
                'cashregister_uuid' => $request->cashregister_uuid,
            ]);
            $cashshift->denominations()->detach($denomination->denomination_uuid);
            $cashshift->bankregisters()->detach();
            $cashshift->platforms()->detach();
            $denomination->delete();
            $this->add($cashshift, $request);
        });
        return redirect("/cashshifts")->with('success', __('word.cashshift.alert.update'));
    }

    public function add($cashshift, Request $request)
    {
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
            'total' => $request->price_cash,
        ]);
        $sync_denomination[$denomination->denomination_uuid] = [
            'type' => '1',
        ];
        $cashshift->denominations()->attach($sync_denomination);
        $sync_bankregister = [];
        foreach ($request->bankregister_uuids as $key => $bankregister_uuid) {
            $sync_bankregister[$bankregister_uuid] = [
                'total' => $request->amount_bank[$key],
                'type' => '1',
            ];
        }
        $cashshift->bankregisters()->sync($sync_bankregister);
        $sync_platform = [];
        foreach ($request->platform_uuids as $key => $platform_uuid) {
            $sync_platform[$platform_uuid] = [
                'total' => $request->amount_platform[$key],
                'type' => '1',
            ];
        }
        $cashshift->platforms()->sync($sync_platform);
    }

    public function destroy(string $cashshift_uuid)
    {
        try {
            $cashshift = Cashshift::where('cashshift_uuid', $cashshift_uuid)->with(['sales', 'expenses', 'incomes'])->first();
            if (empty($cashshift->sales->toArray()) && empty($cashshift->expenses->toArray()) && empty($cashshift->incomes->toArray())) {
                if ($cashshift) {
                    DB::transaction(function () use ($cashshift, $cashshift_uuid) {
                        $denomination_uuids = DB::table('cashshift_denominations')
                            ->where('cashshift_uuid', $cashshift_uuid)
                            ->pluck('denomination_uuid');
                        DB::table('denominations')->whereIn('denomination_uuid', $denomination_uuids)->delete();
                        $cashshift->denominations()->detach();
                        $cashshift->bankregisters()->detach();
                        $cashshift->platforms()->detach();
                        $cashshift->delete();
                    });
                    return response()->json([
                        'type' => 'success',
                        'title' => __('word.general.success'),
                        'msg' => __('word.cashshift.delete_success'),
                        'redirect' => route('cashshifts.index')
                    ], 200);
                } else {
                    return response()->json([
                        'type' => 'error',
                        'title' => __('word.general.error'),
                        'msg' => __('word.general.not_found'),
                    ], 404);
                }
            } else {
                return response()->json([
                    'type' => 'error',
                    'title' => __('word.general.error'),
                    'msg' => __('word.cashshift.not_allow'),
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.general.bad_request'),
            ], 500);
        }
    }

    public function disable(string $cashshift_uuid)
    {
        try {
            $cashshift = Cashshift::where('cashshift_uuid', $cashshift_uuid)->first();
            if ($cashshift && $cashshift->status == true) {
                $dashboardController = new DashboardController();
                $dashboardController->off_session($cashshift_uuid);
                return response()->json([
                    'type' => 'success',
                    'title' => __('word.general.success'),
                    'msg' => __('word.cashshift.disable_success'),
                    'redirect' => route('cashshifts.index')
                ], 200);
            } else {
                return response()->json([
                    'type' => 'error',
                    'title' => __('word.general.error'),
                    'msg' => __('word.general.not_found'),
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.general.bad_request'),
            ], 500);
        }
    }

    public function enable(string $cashshift_uuid)
    {
        try {
            $cashshift = Cashshift::where('cashshift_uuid', $cashshift_uuid)->first();
            if ($cashshift && $cashshift->status == false) {
                $dashboardController = new DashboardController();
                $dashboardController->on_session($cashshift_uuid);
                return response()->json([
                    'type' => 'success',
                    'title' => __('word.general.success'),
                    'msg' => __('word.cashshift.enable_success'),
                    'redirect' => route('cashshifts.index')
                ], 200);
            } else {
                return response()->json([
                    'type' => 'error',
                    'title' => __('word.general.error'),
                    'msg' => __('word.general.not_found'),
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.general.bad_request'),
            ], 500);
        }
    }

    public function detail(string $cashshift_uuid)
    {
        try {
            $denomination_open = DB::table('cashshift_denominations')
                ->join('denominations', 'cashshift_denominations.denomination_uuid', '=', 'denominations.denomination_uuid')
                ->where('cashshift_denominations.cashshift_uuid', $cashshift_uuid)
                ->where('cashshift_denominations.type', '1')->first();
            $cashregister_open = DB::table('cashregisters')
                ->join('cashshifts', 'cashregisters.cashregister_uuid', '=', 'cashshifts.cashregister_uuid')
                ->join('cashshift_denominations', 'cashshifts.cashshift_uuid', '=', 'cashshift_denominations.cashshift_uuid')
                ->join('denominations', 'cashshift_denominations.denomination_uuid', '=', 'denominations.denomination_uuid')
                ->where('cashshifts.cashshift_uuid', $cashshift_uuid)
                ->where('cashshift_denominations.type', '1')
                ->select('cashregisters.name as name', 'denominations.total as total')->get()->toArray();
            $bankregister_open = DB::table('cashshift_bankregisters')
                ->join('bankregisters', 'cashshift_bankregisters.bankregister_uuid', '=', 'bankregisters.bankregister_uuid')
                ->where('cashshift_bankregisters.cashshift_uuid', $cashshift_uuid)
                ->where('cashshift_bankregisters.type', '1')
                ->select('bankregisters.name as name', 'cashshift_bankregisters.total as total')->get()->toArray();
            $platform_open = DB::table('cashshift_platforms')
                ->join('platforms', 'cashshift_platforms.platform_uuid', '=', 'platforms.platform_uuid')
                ->where('cashshift_platforms.cashshift_uuid', $cashshift_uuid)
                ->where('cashshift_platforms.type', '1')
                ->select('platforms.name as name', 'cashshift_platforms.total as total')->get()->toArray();
            $denomination_close = DB::table('cashshift_denominations')
                ->join('denominations', 'cashshift_denominations.denomination_uuid', '=', 'denominations.denomination_uuid')
                ->where('cashshift_denominations.cashshift_uuid', $cashshift_uuid)
                ->where('cashshift_denominations.type', '4')->first();
            $cashregister_close = DB::table('cashregisters')
                ->join('cashshifts', 'cashregisters.cashregister_uuid', '=', 'cashshifts.cashregister_uuid')
                ->join('cashshift_denominations', 'cashshifts.cashshift_uuid', '=', 'cashshift_denominations.cashshift_uuid')
                ->join('denominations', 'cashshift_denominations.denomination_uuid', '=', 'denominations.denomination_uuid')
                ->where('cashshifts.cashshift_uuid', $cashshift_uuid)
                ->where('cashshift_denominations.type', '4')
                ->select('cashregisters.name as name', 'denominations.total as total')->get()->toArray();
            $bankregister_close = DB::table('cashshift_bankregisters')
                ->join('bankregisters', 'cashshift_bankregisters.bankregister_uuid', '=', 'bankregisters.bankregister_uuid')
                ->where('cashshift_bankregisters.cashshift_uuid', $cashshift_uuid)
                ->where('cashshift_bankregisters.type', '4')
                ->select('bankregisters.name as name', 'cashshift_bankregisters.total as total')->get()->toArray();
            $platform_close = DB::table('cashshift_platforms')
                ->join('platforms', 'cashshift_platforms.platform_uuid', '=', 'platforms.platform_uuid')
                ->where('cashshift_platforms.cashshift_uuid', $cashshift_uuid)
                ->where('cashshift_platforms.type', '4')
                ->select('platforms.name as name', 'cashshift_platforms.total as total')->get()->toArray();
            $incomeController = new IncomeController();
            if ($denomination_open) {
                $operation_open = $incomeController->object_operation($denomination_open);
            }
            if ($denomination_close) {
                $operation_close = $incomeController->object_operation($denomination_close);
            }
            return response()->json([
                'type' => 'success',
                'title' => __('word.general.success'),
                'denomination_open' => $denomination_open ?? null,
                'operation_open' => $operation_open ?? null,
                'cashregister_open' => $cashregister_open ?? [],
                'bankregister_open' => $bankregister_open ?? [],
                'platform_open' => $platform_open ?? [],
                'denomination_close' => $denomination_close ?? null,
                'operation_close' => $operation_close ?? null,
                'cashregister_close' => $cashregister_close ?? [],
                'bankregister_close' => $bankregister_close ?? [],
                'platform_close' => $platform_close ?? [],
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

    public function price(string $cashregister_uuid)
    {
        try {
            $cashregister = Cashregister::where('cashregister_uuid', $cashregister_uuid)->first();
            $denomination = Denomination::where('denomination_uuid', $cashregister->denomination_uuid)->first();
            if ($denomination) {
                return response()->json([
                    'type' => 'success',
                    'title' => __('word.general.success'),
                    'denomination' => $denomination,
                ], 200);
            } else {
                return response()->json([
                    'type' => 'error',
                    'title' => __('word.general.error'),
                    'msg' => __('word.general.not_found'),
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.general.bad_request'),
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function amount(string $bankregister_uuid)
    {
        try {
            $bankregister = Bankregister::where('bankregister_uuid', $bankregister_uuid)->first();
            if ($bankregister) {
                return response()->json([
                    'type' => 'success',
                    'title' => __('word.general.success'),
                    'amount' => $bankregister->total,
                    'name' => $bankregister->name,
                ], 200);
            } else {
                return response()->json([
                    'type' => 'error',
                    'title' => __('word.general.error'),
                    'msg' => __('word.general.not_found'),
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.general.bad_request'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function value(string $platform_uuid)
    {
        try {
            $platform = Platform::where('platform_uuid', $platform_uuid)->first();
            if ($platform) {
                return response()->json([
                    'type' => 'success',
                    'title' => __('word.general.success'),
                    'value' => $platform->total,
                    'name' => $platform->name,
                ], 200);
            } else {
                return response()->json([
                    'type' => 'error',
                    'title' => __('word.general.error'),
                    'msg' => __('word.general.not_found'),
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.general.bad_request'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function methods($user_id)
    {
        $cashshift = Cashshift::where('user_id', $user_id)->where('status',true)->with(['cashregister', 'bankregisters', 'platforms'])->first();
        if ($cashshift){
            $data[] = (object)[
                'name' => $cashshift->cashregister->name,
                'reference_uuid' => $cashshift->cashregister->cashregister_uuid,
                'pivot' => true,
            ];
            foreach ($cashshift->bankregisters as $bankregister) {
                $data[] = (object)[
                    'name' => $bankregister->name,
                    'reference_uuid' => $bankregister->bankregister_uuid,
                    'pivot' => false,
                ];
            }
            foreach ($cashshift->platforms as $platform) {
                $data[] = (object)[
                    'name' => $platform->name,
                    'reference_uuid' => $platform->platform_uuid,
                    'pivot' => false,
                ];
            }
            return $data;
        }else{
            return false;
        }
    }
}
