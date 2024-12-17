<?php

namespace App\Http\Controllers;

use App\Models\Cashcount;
use App\Models\Cashshift;
use App\Models\Denomination;
use App\Models\Denominationables;
use App\Models\Paymentwithoutprice;
use App\Models\Servicewithprice;
use App\Models\Transactionmethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CashcountController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $cashcounts = Cashcount::with(['user'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        $denominationables = Denominationables::all();
        $cashshiftsvalidated = Cashshift::where('user_id', auth::id())->where('status', 1)->first();
        return view("cashcount.index", compact('cashcounts', 'cashshiftsvalidated','perPage', 'denominationables'));
    }

    public function create()
    {
        $denomination = new Denomination();
        $cashcount = new Cashcount();
        return view("cashcount.create", compact('cashcount', 'denomination'));
    }

    public function store(Request $request)
    {
        $rules = [
            'physical_balance' => 'required|numeric|regex:/^\d{1,20}(\.\d{1,2})?$/',
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
            'total' => 'required|numeric|regex:/^(?!0(\.0{1,2})?$)\d{1,20}(\.\d{1,2})?$/',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $cashshiftsvalidated = Cashshift::where('user_id', auth::id())->where('status', 1)->first();
        $cashcount = Cashcount::create([
            'physical_balance' => $request->physical_balance,
            'observation' => $request->observation,
            'user_id' => Auth::id(),
            'cashshift_uuid' => $cashshiftsvalidated->cashshift_uuid,
        ]);
        $denomination = Denomination::create([
            'type' => 'cashcount',
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
            'total' => $request->total ?? 0,
        ]);
        $cashcount->denominations()->attach($denomination->denomination_uuid);
        return redirect("/cashcounts")->with('success', 'Arqueo registrado correctamente');
    }

    public function edit(string $cashcount_uuid)
    {
        $cashcount = Cashcount::where('cashcount_uuid', $cashcount_uuid)->firstOrFail();
        $denominationables = Denominationables::where('denominationable_uuid', $cashcount->cashcount_uuid)->firstOrFail();
        $denomination = Denomination::where('denomination_uuid', $denominationables->denomination_uuid)->firstOrFail();
        return view("cashcount.edit", compact('cashcount', 'denomination'));
    }

    public function update(Request $request, string $cashcount_uuid)
    {
        $cashcount = Cashcount::where('cashcount_uuid', $cashcount_uuid)->firstOrFail();
        $denominationables = Denominationables::where('denominationable_uuid', $cashcount->cashcount_uuid)->firstOrFail();
        $denomination = Denomination::where('denomination_uuid', $denominationables->denomination_uuid)->firstOrFail();
        $rules = [
            'physical_balance' => 'required|numeric|regex:/^\d{1,20}(\.\d{1,2})?$/',
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
            'total' => 'required|numeric|regex:/^(?!0(\.0{1,2})?$)\d{1,20}(\.\d{1,2})?$/',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $cashshiftsvalidated = Cashshift::where('user_id', auth::id())->where('status', 1)->first();
        $cashcount->update([
            'physical_balance' => $request->physical_balance,
            'observation' => $request->observation,
            'user_id' => Auth::id(),
            'cashshift_uuid' => $cashshiftsvalidated->cashshift_uuid,
        ]);
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
            'total' => $request->total ?? 0,
        ]);
        return redirect("/cashcounts")->with('success', 'Arqueo actualizado correctamente');
    }

    public function destroy(string $cashcount_uuid)
    {
        $cashcount = Cashcount::where('cashcount_uuid', $cashcount_uuid)->firstOrFail();
        $cashcount->delete();
        return redirect("/cashcounts")->with('success', 'Arqueo eliminado correctamente');
    }

    public function changestatus(string $cashcount_uuid)
    {
        $cashcount = Cashcount::where('cashcount_uuid', $cashcount_uuid)->firstOrFail();
        $totals = Denomination::where('type', ['income', 'expense'])
            ->selectRaw('
            SUM(bill_200) as total_bill_200,
            SUM(bill_100) as total_bill_100,
            SUM(bill_50) as total_bill_50,
            SUM(bill_20) as total_bill_20,
            SUM(bill_10) as total_bill_10,
            SUM(coin_5) as total_coin_5,
            SUM(coin_2) as total_coin_2,
            SUM(coin_1) as total_coin_1,
            SUM(coin_0_5) as total_coin_0_5,
            SUM(coin_0_2) as total_coin_0_2,
            SUM(coin_0_1) as total_coin_0_1,
            SUM(total) as total_sum')->first();
        $denomination = Denomination::create([
            'type' => 'closing',
            'bill_200' => $totals->total_bill_200 ?? 0,
            'bill_100' => $totals->total_bill_100 ?? 0,
            'bill_50' => $totals->total_bill_50 ?? 0,
            'bill_20' => $totals->total_bill_20 ?? 0,
            'bill_10' => $totals->total_bill_10 ?? 0,
            'coin_5' => $totals->total_coin_5 ?? 0,
            'coin_2' => $totals->total_coin_2 ?? 0,
            'coin_1' => $totals->total_coin_1 ?? 0,
            'coin_0_5' => $totals->total_coin_0_5 ?? 0,
            'coin_0_2' => $totals->total_coin_0_2 ?? 0,
            'coin_0_1' => $totals->total_coin_0_1 ?? 0,
            'total' => $totals->total_sum ?? 0,
        ]);
        $cashcount->update([
            'status' => '0',
            'closing' => $denomination->total,
        ]);
        $cashcount->denominations()->attach($denomination->denomination_uuid);
        return redirect("/cashcounts")->with('success', 'Arqueo cerrado correctamente.');
    }

    public function showdetail(string $cashcount_uuid)
    {
        $denominationables = Denominationables::where('denominationable_uuid', $cashcount_uuid)->get();
        $opening = null;
        $closing = null;
        foreach ($denominationables as $denominationable) {
            $denomination = Denomination::where('denomination_uuid', $denominationable->denomination_uuid)->first();
            if ($denomination) {
                if ($denomination->type === 'opening') {
                    $opening = $denomination;
                } elseif ($denomination->type === 'closing') {
                    $closing = $denomination;
                }
            }
        }
        return response()->json([
            'bill_200' => $opening->bill_200,
            'bill_100' => $opening->bill_100,
            'bill_50' => $opening->bill_50,
            'bill_20' => $opening->bill_20,
            'bill_10' => $opening->bill_10,
            'coin_5' => $opening->coin_5,
            'coin_2' => $opening->coin_2,
            'coin_1' => $opening->coin_1,
            'coin_0_5' => $opening->coin_0_5,
            'coin_0_2' => $opening->coin_0_2,
            'coin_0_1' => $opening->coin_0_1,
            'total' => $opening->total,
            'total_bill_200' => $closing->bill_200 ?? 0,
            'total_bill_100' => $closing->bill_100 ?? 0,
            'total_bill_50' => $closing->bill_50 ?? 0,
            'total_bill_20' => $closing->bill_20 ?? 0,
            'total_bill_10' => $closing->bill_10 ?? 0,
            'total_coin_5' => $closing->coin_5 ?? 0,
            'total_coin_2' => $closing->coin_2 ?? 0,
            'total_coin_1' => $closing->coin_1 ?? 0,
            'total_coin_0_5' => $closing->coin_0_5 ?? 0,
            'total_coin_0_2' => $closing->coin_0_2 ?? 0,
            'total_coin_0_1' => $closing->coin_0_1 ?? 0,
            'total_total' => $closing->total ?? 0,
        ]);
    }

    public function load(string $cashcount_uuid)
    {
        //Cashshift::where('user_id', auth::id())->where('status', 1)->where('cashshift_uuid', $cashcount->cashshift_uuid)->first();
        $totals_paymentwithoutprices = Cashshift::join('paymentwithoutprices', 'cashshifts.cashshift_uuid', '=', 'paymentwithoutprices.cashshift_uuid')
            ->join('denominationables', 'paymentwithoutprices.paymentwithoutprice_uuid', '=', 'denominationables.denominationable_uuid')
            ->join('denominations', 'denominationables.denomination_uuid', '=', 'denominations.denomination_uuid')
            ->whereNull('paymentwithoutprices.deleted_at')
            ->whereNull('denominationables.deleted_at')
            ->whereNull('denominations.deleted_at')
            ->where('type', ['income', 'expense'])
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
                COALESCE(SUM(total), 0) as total_sum')->first();
        $totals_paymentwithprices = Cashshift::join('paymentwithprices', 'cashshifts.cashshift_uuid', '=', 'paymentwithprices.cashshift_uuid')
            ->join('denominationables', 'paymentwithprices.paymentwithprice_uuid', '=', 'denominationables.denominationable_uuid')
            ->join('denominations', 'denominationables.denomination_uuid', '=', 'denominations.denomination_uuid')
            ->whereNull('paymentwithprices.deleted_at')
            ->whereNull('denominationables.deleted_at')
            ->whereNull('denominations.deleted_at')
            ->where('type', ['income', 'expense'])
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
                COALESCE(SUM(total), 0) as total_sum')->first();
        $totals_sum = [];
        $array_paymentwithoutprices = $totals_paymentwithoutprices->toArray();
        $array_paymentwithprices = $totals_paymentwithprices->toArray();
        foreach ($array_paymentwithoutprices as $key => $value) {
            $totals_sum[$key] = $value + ($array_paymentwithprices[$key] ?? 0);
        }
        $cashcount = Cashcount::where('cashcount_uuid', $cashcount_uuid)->firstOrFail();
        $difference = $cashcount->physical_balance - $totals_sum['total_sum'];
        $cashcount->update([
            'system_balance' => $totals_sum['total_sum'],
            'difference' => $difference
        ]);
        return response()->json([
            'system_balance' => $totals_sum['total_sum'],
            'difference' => $difference,
        ]);
    }
}
