<?php

namespace App\Http\Controllers;
use App\Models\Denomination;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControlController extends Controller
{
    public function control(Request $request)
    {
        /*
        $perPage = $request->input('perPage', 20);
        $denominations = Denomination::where('type','!=',1)->with('cashregister')->orderBy('created_at', 'desc')->paginate($perPage);
        $transactions = Transaction::where('total','!=',0.00)->where('type','!=',1)->with('bankregister')->orderBy('created_at', 'desc')->paginate($perPage);
        $last_denomination = Denomination::latest()->first();
        $last_transaction = Transaction::latest()->first();
        $last_record = DB::table('denominations')
            ->join('transactions', function ($join) {
                $join->on('denominations.income_uuid', '=', 'transactions.income_uuid')
                    ->orOn('denominations.expense_uuid', '=', 'transactions.expense_uuid')
                    ->orOn('denominations.sale_uuid', '=', 'transactions.sale_uuid');
            })
            ->select('denominations.income_uuid as cash_income_uuid',
                            'denominations.expense_uuid as cash_expense_uuid',
                            'denominations.sale_uuid as cash_sale_uuid',
                            'transactions.income_uuid as bank_income_uuid',
                            'transactions.expense_uuid as bank_expense_uuid',
                            'transactions.sale_uuid as bank_sale_uuid')
            ->orderByDesc('denominations.created_at') // Puedes ordenar también por `transactions.created_at` si lo prefieres
            ->orderByDesc('transactions.created_at')
            ->first();
        */

/*
        $last_record = null;
        if ($last_denomination && $last_transaction) {
            if ($last_denomination->created_at >= $last_transaction->created_at) {
                $last_record = $last_denomination;
            } else {
                $last_record = $last_transaction;
            }
        } elseif ($last_denomination) {
            $last_record = $last_denomination;
        } elseif ($last_transaction) {
            $last_record = $last_transaction;
        }*/
        /*
        $equals = null;
        if ($last_transaction && $last_denomination) {
            if ($last_transaction->reference_uuid === $last_denomination->reference_uuid) {
                $equals = true;
            }else {
                $equals = 'Valor por defecto';
            }
        } else {
            $equals = 'No se encontraron registros en alguna de las tablas';
        }*/
        //return view("control.audit", compact('denominations','transactions', 'perPage','last_record'));
        return redirect("dashboard");
    }
}
