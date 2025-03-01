<?php

namespace App\Http\Middleware;

use App\Http\Controllers\DashboardController;
use App\Models\Cashshift;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CloseSession
{
    public function handle(Request $request, Closure $next): Response
    {
        $now = Carbon::now();
        $cashshifts = Cashshift::where('status', true)->whereNotNull('end_time')->where('end_time', '<', $now)->get();
        foreach ($cashshifts as $cashshift){
            $dashboardController = new DashboardController();
            $dashboardController->off_session($cashshift->cashshift_uuid);
        }
        return $next($request);
    }
}
