<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->web(append: \App\Http\Middleware\TwoFactor::class);
        $middleware->appendToGroup('check_user_status', [
            \App\Http\Middleware\CheckUserStatus::class,
        ]);
        $middleware->appendToGroup('two_factor', [
            \App\Http\Middleware\TwoFactor::class,
        ]);
        $middleware->appendToGroup('force_password_change', [
            \App\Http\Middleware\ForcePasswordChange::class,
        ]);
        $middleware->appendToGroup('close_session', [
            \App\Http\Middleware\CloseSession::class,
        ]);
        $middleware->appendToGroup('cashshift_session', [
            \App\Http\Middleware\CashshiftSession::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
       // $schedule->command('close:cashshifts')->daily();
    })
    ->create();
