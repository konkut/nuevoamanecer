<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class ForcePasswordChange
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user) {
            // Convierte password_changed_at a Carbon si no es nulo
            $passwordChangedAt = $user->password_changed_at
                ? Carbon::parse($user->password_changed_at)
                : null;
            $routeName = $request->route()->getName();
           // Log::info("ruta", ['ruta' => $routeName]);
            //Log::info("date", ['date' => $passwordChangedAt->lt(Carbon::now()->subDays(30))]);
            if (in_array($routeName, ['password.change', 'password.change.update']) && $passwordChangedAt->lt(Carbon::now()->subDays(30))) {
               // Log::info("si names, si fecha", ['date' => $request->cookie('device_trusted')]);
                return $next($request);
            }elseif (in_array($routeName, ['password.change', 'password.change.update']) && !$passwordChangedAt->lt(Carbon::now()->subDays(30))){
              //  Log::info("si names, no fecha", ['date' => $request->cookie('device_trusted')]);
                return redirect()->route('dashboard');
            }elseif ($passwordChangedAt->lt(Carbon::now()->subDays(30))){
               // Log::info("si fecha", ['date' => $request->cookie('device_trusted')]);
                return redirect()->route('password.change')->with('warning', __('word.general.alert.change_password'));
            }
            /*
            FUNCIONAMIENTO EJEMPLO
            PRIMER PASO. ruta {"ruta":"cashshifts.index"} se ejecuta este middleware
            SEGUNDO PASO. date {"date":true} sobrepaso la fecha de 30 dias
            TERCER PASO. si fecha {"date":"1"} ejecuta ultimo elseif y redirige a la ruta password.change
            CUARTO PASO. ruta {"ruta":"password.change"} redirige routes pero como tiene este mismo middleware vuelve a ingresar a este middleware
            QUINTO PASO. date {"date":true} vuelve a verificar la fecha de 30 dias
            SEXTO PASO. si names, si fecha {"date":"1"} ejecuta el primer if y siguiendo su peticion siendo esta a la ruta password.change esto evita el exceso de redireccionamiento
            */
        }
        return $next($request);
    }
}
