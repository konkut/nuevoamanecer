<?php

namespace App\Http\Controllers;

use App\Models\Cashshift;
use App\Models\Denomination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CashcountController extends Controller
{
    public function create(string $cashshift_uuid)
    {
        $cashshift = Cashshift::where('cashshift_uuid', $cashshift_uuid)
            ->with(['user', 'cashregister', 'bankregisters', 'platforms', 'denominations'])->first();
        if ($cashshift->status == false){
            $denomination_uuid = DB::table('cashshift_denominations')->where('cashshift_uuid', $cashshift_uuid)
                ->where('type', '4')->value('denomination_uuid');
            $denomination = DB::table('denominations')->where('denomination_uuid', $denomination_uuid)->first();
            $cashcount = $denomination;
        }else{
            $cashcount = new Denomination();
        }
        $dashboardController = new DashboardController();
        $closing = $dashboardController->closing($cashshift_uuid);
        $difference = $this->difference($cashcount, $closing);
        $operation_cashcount = $this->operation($cashcount);
        $operation_closing = $this->operation($closing);
        $operation_difference = $this->operation($difference);
        return view("cashcount.create", compact('cashshift_uuid', 'closing', 'difference', 'cashcount', 'operation_closing', 'operation_difference','operation_cashcount'));
    }

    public function store(Request $request, string $cashshift_uuid)
    {
        $rules = [
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
        });
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        DB::transaction(function () use ($request, $cashshift_uuid) {
            $cashshift = Cashshift::where('cashshift_uuid', $cashshift_uuid)
                ->with(['user', 'cashregister', 'bankregisters', 'platforms', 'denominations'])->first();
            $cashshift->update([
                'end_time' => now()->format('Y-m-d\TH:i'),
                'status' => false,
            ]);
            if ($cashshift->status == false){
                $denomination_uuid = DB::table('cashshift_denominations')->where('cashshift_uuid', $cashshift_uuid)
                    ->where('type', '4')->value('denomination_uuid');
                DB::table('denominations')->where('denomination_uuid', $denomination_uuid)->delete();
                DB::table('cashshift_denominations')->where('cashshift_uuid', $cashshift_uuid)->where('type', '4')->delete();
                DB::table('cashshift_bankregisters')->where('cashshift_uuid', $cashshift_uuid)->where('type', '4')->delete();
                DB::table('cashshift_platforms')->where('cashshift_uuid', $cashshift_uuid)->where('type', '4')->delete();
            }
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
                'total' => $request->total,
            ]);
            $sync_denomination[$denomination->denomination_uuid] = [
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
        return redirect("/cashshifts")->with('success', __('word.cashshift.alert.cashcount'));
    }

    public function difference($cashcount, $closing){
        $difference = (object)[
            'bill_200' => ($cashcount->bill_200 ?? 0) - ($closing->bill_200 ?? 0),
            'bill_100' => ($cashcount->bill_100 ?? 0) - ($closing->bill_100 ?? 0),
            'bill_50' => ($cashcount->bill_50 ?? 0) - ($closing->bill_50 ?? 0),
            'bill_20' => ($cashcount->bill_20 ?? 0) - ($closing->bill_20 ?? 0),
            'bill_10' => ($cashcount->bill_10 ?? 0) - ($closing->bill_10 ?? 0),
            'coin_5' => ($cashcount->coin_5 ?? 0) - ($closing->coin_5 ?? 0),
            'coin_2' => ($cashcount->coin_2 ?? 0) - ($closing->coin_2 ?? 0),
            'coin_1' => ($cashcount->coin_1 ?? 0) - ($closing->coin_1 ?? 0),
            'coin_0_5' => ($cashcount->coin_0_5 ?? 0) - ($closing->coin_0_5 ?? 0),
            'coin_0_2' => ($cashcount->coin_0_2 ?? 0) - ($closing->coin_0_2 ?? 0),
            'coin_0_1' => ($cashcount->coin_0_1 ?? 0) - ($closing->coin_0_1 ?? 0),
            'total' => number_format(($cashcount->total ?? 0) - ($closing->total ?? 0),2,'.',''),
        ];
        return $difference;
    }

    public function operation($denomination){
        $operation = (object)[
            'bill_200' => number_format(($denomination->bill_200 ?? 0) * 200,2,'.',''),
            'bill_100' => number_format(($denomination->bill_100 ?? 0) * 100,2,'.',''),
            'bill_50' => number_format(($denomination->bill_50 ?? 0) * 50,2,'.',''),
            'bill_20' => number_format(($denomination->bill_20 ?? 0) * 20,2,'.',''),
            'bill_10' => number_format(($denomination->bill_10 ?? 0) * 10,2,'.',''),
            'coin_5' => number_format(($denomination->coin_5 ?? 0) * 5,2,'.',''),
            'coin_2' => number_format(($denomination->coin_2 ?? 0) * 2,2,'.',''),
            'coin_1' => number_format(($denomination->coin_1 ?? 0) * 1,2,'.',''),
            'coin_0_5' => number_format(($denomination->coin_0_5 ?? 0) * 0.5,2,'.',''),
            'coin_0_2' => number_format(($denomination->coin_0_2 ?? 0) * 0.2,2,'.',''),
            'coin_0_1' => number_format(($denomination->coin_0_1 ?? 0) * 0.1,2,'.',''),
        ];
        return $operation;
    }
}
