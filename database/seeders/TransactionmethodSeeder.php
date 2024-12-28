<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transactionmethod;

class TransactionmethodSeeder extends Seeder
{

    public function run(): void
    {
        Transactionmethod::create([
            'name' => 'Efectivo',
            'description' => 'Pago realizado directamente con dinero físico.'
        ]);
        Transactionmethod::create([
            'name' => 'QR',
            'description' => 'Pago digital escaneando un código QR con una app móvil.'
        ]);
        Transactionmethod::create([
            'name' => 'Transferencia',
            'description' => 'Pago mediante transferencia bancaria.'
        ]);
    }
}
