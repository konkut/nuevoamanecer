<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user && !$user->status) {
            Auth::guard('web')->logout();
            return redirect()->route('login')->withErrors([
                'status' => __('word.general.alert.disable_user'),
            ]);
        }
        return $next($request);
    }
}
