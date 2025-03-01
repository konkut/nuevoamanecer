<?php

namespace Database\Seeders;

use App\Models\Bankregister;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class BankregisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bankregister::create([
            'name' => 'BANCO DE CRÉDITO',
            'account_number' => '1220012345678',
            'owner_name' => 'Ibeth Pamela Quispe',
            'user_id' => 1,
            'total' => 2000.00,
        ]);
        Bankregister::create([
            'name' => 'BANCO UNIÓN (5706734)',
            'account_number' => '5706734001234',
            'owner_name' => 'Ibeth Pamela Quispe',
            'total' => 2000.00,
            'user_id' => 1
        ]);
        Bankregister::create([
            'name' => 'BANCO UNIÓN (4943449)',
            'account_number' => '4943449001234',
            'owner_name' => 'Ibeth Pamela Quispe',
            'total' => 2000.00,
            'user_id' => 1
        ]);
        Bankregister::create([
            'name' => 'BANCO NACIONAL (5706734)',
            'account_number' => '5706734123456',
            'owner_name' => 'Ibeth Pamela Quispe',
            'total' => 2000.00,
            'user_id' => 1
        ]);
        Bankregister::create([
            'name' => 'BANCO NACIONAL (4943449)',
            'account_number' => '4943449123456',
            'owner_name' => 'Ibeth Pamela Quispe',
            'total' => 2000.00,
            'user_id' => 1
        ]);
        Bankregister::create([
            'name' => 'BANCO ECONÓMICO',
            'account_number' => '3200456789012',
            'owner_name' => 'Ibeth Pamela Quispe',
            'total' => 2000.00,
            'user_id' => 1
        ]);
        Bankregister::create([
            'name' => 'BANCO FIE',
            'account_number' => '2300987654321',
            'owner_name' => 'Ibeth Pamela Quispe',
            'total' => 2000.00,
            'user_id' => 1
        ]);
    }
}
