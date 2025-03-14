<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TwoFactor
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ($user && $user->status_two_factor) {
            $routeName = $request->route()->getName();
            //Log::info("route", ['ruta' => $routeName]);
            // Log::info("data_initial_session", ['cookie' => $request->cookie('device_trusted')]);
            if (in_array($routeName, ['connect_two_factor', 'verify_two_factor']) && !$request->cookie('device_trusted')) {
                //Log::info("si names sin cookie", ['date' => $request->cookie('device_trusted')]);
                return $next($request);
            } elseif (in_array($routeName, ['connect_two_factor', 'verify_two_factor']) && $request->cookie('device_trusted')) {
                // Log::info("si names con cookie", ['date' => $request->cookie('device_trusted')]);
                return redirect()->route('dashboard');
            } elseif (!$request->cookie('device_trusted')) {
                // Log::info("no cookie", ['date' => $request->cookie('device_trusted')]);
                return redirect()->route('connect_two_factor');
            }
        }
        return $next($request);
    }
}
