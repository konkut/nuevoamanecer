<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Cashshift;

Artisan::command('close:cashshifts', function () {
    Cashshift::where('status', 1)
        ->update([
            'status' => 0,
            'end_time' => now(),
        ]);
})->describe('Cerrar sesiones de caja activas al final del día');

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();
