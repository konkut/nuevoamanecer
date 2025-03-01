<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    public function run(): void
    {
        Platform::create([
            'name' => 'TIGO MONEY',
            'description' => 'Transacciones mediante la billetera móvil Tigo Money.',
            'total' => 2000.00,
            'user_id'=>1
        ]);
        Platform::create([
            'name' => 'MULTIRED',
            'description' => 'Servicio Multired para operaciones financieras múltiples.',
            'total' => 2000.00,
            'user_id'=>1
        ]);
    }
}
