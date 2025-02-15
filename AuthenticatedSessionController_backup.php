<?php

namespace Laravel\Fortify\Http\Controllers;

use Illuminate\Cache\RateLimiter;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Pipeline;
use Illuminate\Support\Facades\Log;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\CanonicalizeUsername;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LoginViewResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Validator;


class AuthenticatedSessionController extends Controller
{
    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;
    protected $limiter;

    /**
     * Create a new controller instance.
     *
     * @param \Illuminate\Contracts\Auth\StatefulGuard $guard
     * @return void
     */
    public function __construct(StatefulGuard $guard, RateLimiter $limiter)
    {
        $this->guard = $guard;
        $this->limiter = $limiter;
    }

    /**
     * Show the login view.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Laravel\Fortify\Contracts\LoginViewResponse
     */
    public function create(Request $request): LoginViewResponse
    {
        return app(LoginViewResponse::class);
    }

    /**
     * Attempt to authenticate a new session.
     *
     * @param \Laravel\Fortify\Http\Requests\LoginRequest $request
     * @return mixed
     */
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

        $key = 'login:' . request()->ip(); // Clave única para identificar los intentos de login por IP
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
            if ($this->guard->attempt(
                $request->only(Fortify::username(), 'password'),
                $request->boolean('remember')
            )) {
                $user = $this->guard->user();
                if (!$user->status) {
                    $this->guard->logout(); // Cerramos la sesión iniciada
                    return response()->json([
                        'type' => 'error',
                        'title' => __('word.user.disable_message'),
                        'msg' => __('word.user.disable_description'),
                    ], 422);
                }else{
                    // Si la autenticación es exitosa y el usuario está activo
                    cookie()->queue(cookie()->forget('device_trusted'));
                    return response()->json([
                        'type' => 'success',
                        'title' => __('word.general.success'),
                        'redirect' => route('dashboard')
                    ], 200);
                }
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

    /**
     * Get the authentication pipeline instance.
     *
     * @param \Laravel\Fortify\Http\Requests\LoginRequest $request
     * @return \Illuminate\Pipeline\Pipeline
     */
    protected function loginPipeline(LoginRequest $request)
    {
        if (Fortify::$authenticateThroughCallback) {
            return (new Pipeline(app()))->send($request)->through(array_filter(
                call_user_func(Fortify::$authenticateThroughCallback, $request)
            ));
        }

        if (is_array(config('fortify.pipelines.login'))) {
            return (new Pipeline(app()))->send($request)->through(array_filter(
                config('fortify.pipelines.login')
            ));
        }

        return (new Pipeline(app()))->send($request)->through(array_filter([
            config('fortify.limiters.login') ? null : EnsureLoginIsNotThrottled::class,
            config('fortify.lowercase_usernames') ? CanonicalizeUsername::class : null,
            Features::enabled(Features::twoFactorAuthentication()) ? RedirectIfTwoFactorAuthenticatable::class : null,
            AttemptToAuthenticate::class,
            PrepareAuthenticatedSession::class,
        ]));
    }

    /**
     * Destroy an authenticated session.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Laravel\Fortify\Contracts\LogoutResponse
     */
    public function destroy(Request $request): LogoutResponse
    {
        $this->guard->logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return app(LogoutResponse::class);
    }
}
