<?php

namespace App\Http\Middleware;

use App\Models\Denomination;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Sale;
use App\Models\Transaction;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Cashshift;

class CashshiftSession
{

    public function handle(Request $request, Closure $next): Response
    {
        //PROTECCION RUTAS INCOME
        if ($request->route('income_uuid')) {
            $income = Income::where('income_uuid', $request->route('income_uuid'))->first();
            $session_state = Cashshift::where('cashshift_uuid', $income->cashshift_uuid)->where('status', true)->exists();
            if ($session_state) return $next($request);
            else return redirect()->route('dashboard')->with('error', __('word.general.alert.denied'));
        }
        //PROTECCION RUTAS INCOME
        if ($request->route('expense_uuid')) {
            $expense = Expense::where('expense_uuid', $request->route('expense_uuid'))->first();
            $session_state = Cashshift::where('cashshift_uuid', $expense->cashshift_uuid)->where('status', true)->exists();
            if ($session_state) return $next($request);
            else return redirect()->route('dashboard')->with('error', __('word.general.alert.denied'));
        }
        //PROTECCION RUTAS SALES
        if ($request->route('sale_uuid')) {
            $sale = Sale::where('sale_uuid', $request->route('sale_uuid'))->first();
            $session_state = Cashshift::where('cashshift_uuid', $sale->cashshift_uuid)->where('status', true)->exists();
            if ($session_state) return $next($request);
            else return redirect()->route('dashboard')->with('error', __('word.general.alert.denied'));
        }
        $has_active_session = Cashshift::where('user_id', Auth::id())->where('status', true)->exists();
        if (!$has_active_session) {
            return redirect()->route('dashboard')->with('error', __('word.general.alert.not_allow'));
        }
        return $next($request);
    }
}
