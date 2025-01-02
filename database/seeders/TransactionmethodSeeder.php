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
            'name' => 'EFECTIVO',
            'balance' => 0.00,
            'description' => 'Pago realizado directamente con dinero físico.'
        ]);
        Transactionmethod::create([
            'name' => 'YAPE',
            'balance' => 2000.00,
            'description' => 'Pago realizado a través de la aplicación de Yape.'
        ]);
        Transactionmethod::create([
            'name' => 'TIGO MONEY',
            'balance' => 2000.00,
            'description' => 'Transacciones mediante la billetera móvil Tigo Money.'
        ]);
        Transactionmethod::create([
            'name' => 'BANCO UNIÓN (5706734)',
            'balance' => 2000.00,
            'description' => 'Cuenta Banco Unión asociada al número 5706734.'
        ]);
        Transactionmethod::create([
            'name' => 'BANCO UNIÓN (4943449)',
            'balance' => 2000.00,
            'description' => 'Cuenta Banco Unión asociada al número 4943449.'
        ]);
        Transactionmethod::create([
            'name' => 'BANCO NACIONAL (5706734)',
            'balance' => 2000.00,
            'description' => 'Cuenta Banco Nacional de Bolivia asociada al número 5706734.'
        ]);
        Transactionmethod::create([
            'name' => 'BANCO NACIONAL (4943449)',
            'balance' => 2000.00,
            'description' => 'Cuenta Banco Nacional de Bolivia asociada al número 4943449.'
        ]);
        Transactionmethod::create([
            'name' => 'MULTIRED',
            'balance' => 2000.00,
            'description' => 'Servicio Multired para operaciones financieras múltiples.'
        ]);
        Transactionmethod::create([
            'name' => 'BANCO ECONOMICO',
            'balance' => 2000.00,
            'description' => 'Transacciones realizadas mediante Banco Económico.'
        ]);
        Transactionmethod::create([
            'name' => 'BANCO FIE',
            'balance' => 2000.00,
            'description' => 'Transacciones realizadas mediante Banco Fie.'
        ]);
    }
}
