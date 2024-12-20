<?php

namespace App\Http\Controllers;

use App\Models\Cashcount;
use App\Models\Cashregister;
use App\Models\Cashshift;
use App\Models\Category;
use App\Models\Paymentwithoutprice;
use App\Models\Paymentwithprice;
use App\Models\Servicewithoutprice;
use App\Models\Servicewithprice;
use App\Models\Transactionmethod;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $total_users = User::count();
        $total_categories = Category::count();
        $total_services = Servicewithoutprice::count() + Servicewithprice::count();
        $total_transactionmethods = Transactionmethod::count();
        $total_payments = Paymentwithprice::count() + Paymentwithoutprice::count();
        $total_payments_by_user = Paymentwithprice::where("user_id",Auth::id())->count() + Paymentwithoutprice::where("user_id",Auth::id())->count();
        $total_cashregisters = Cashregister::count();
        $total_cashshifts = Cashshift::count();
        $total_cashshifts_by_user = Cashshift::where("user_id",Auth::id())->count();
        $total_cashcounts = Cashcount::count();
        $total_cashcounts_by_user = Cashcount::where("user_id",Auth::id())->count();
        return view('dashboard', compact('total_users','total_categories','total_services','total_transactionmethods','total_payments','total_payments_by_user','total_cashregisters','total_cashshifts','total_cashshifts_by_user','total_cashcounts','total_cashcounts_by_user'));
    }
}
