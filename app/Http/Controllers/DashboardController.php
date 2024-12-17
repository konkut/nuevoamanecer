<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Paymentwithoutprice;
use App\Models\Paymentwithprice;
use App\Models\Servicewithoutprice;
use App\Models\Servicewithprice;
use App\Models\Transactionmethod;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total_users = User::count();
        $total_categories = Category::count();
        $total_services = Servicewithoutprice::count() + Servicewithprice::count();
        $total_transactionmethods = Transactionmethod::count();
        $total_payments = Paymentwithprice::count() + Paymentwithoutprice::count();
        return view('dashboard', compact('total_users','total_categories','total_services','total_transactionmethods','total_payments'));
    }
}
