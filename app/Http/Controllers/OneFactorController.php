<?php

namespace App\Http\Controllers;

use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Requests\LoginRequest;

class OneFactorController extends Controller
{
    public function store(LoginRequest $request)
    {
        // Validación de los datos de entrada
        $validator = Validator::make($request->all(), [
            Fortify::username() => 'required|string',  // Validación de usuario
            'password' => 'required|string',           // Validación de contraseña
        ]);

        if ($validator->fails()) {
            // Respuesta con errores de validación
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.general.error_validation'),
                'msgs' => json_encode($validator->errors()->all()),
            ], 422); // Código 422 para errores de validación
        }

        // Obtener una instancia del RateLimiter desde el contenedor
        $limiter = app(RateLimiter::class);  // Esto accede al servicio RateLimiter

        $key = 'login:'.request()->ip(); // Clave única para identificar los intentos de login por IP
        $maxAttempts = 5; // Número máximo de intentos permitidos

        // Verificar si el número de intentos es excesivo
        if ($limiter->tooManyAttempts($key, $maxAttempts)) {
            // Obtener el tiempo restante en segundos para el siguiente intento
            $seconds = $limiter->availableIn($key);

            return response()->json([
                'type' => 'error',
                'title' => __('auth.too_many_requests'),
                'msg' => __('auth.throttle', ['seconds' => $seconds]),
            ], 429); // Demasiados intentos
        }

        try {
            // Intentamos autenticar al usuario
            if ($this->guard->attempt(
                $request->only(Fortify::username(), 'password'),
                $request->boolean('remember')
            )) {
                // Si la autenticación es exitosa
                cookie()->queue(cookie()->forget('device_trusted'));
                return response()->json([
                    'type' => 'success',
                    'title' => __('word.general.success'),
                ], 200);

            }
        } catch (\Exception $e) {
            // Manejo de excepciones
            Log::error('Login Error: ' . $e->getMessage());
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.general.bad_request'),
            ], 400);
        }

        // Si la autenticación falla, incrementamos el contador de intentos
        $limiter->hit($key);

        return response()->json([
            'type' => 'error',
            'title' => __('auth.failed'),
            'msg' => __('auth.failed_auth'),
        ], 401); // Error 401 si la autenticación falla

        /*
        return $this->loginPipeline($request)->then(function ($request) {
            return app(LoginResponse::class);
        });*/

    }
}
