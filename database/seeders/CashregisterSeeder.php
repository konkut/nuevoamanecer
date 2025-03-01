<?php

namespace Database\Seeders;

use App\Models\Cashregister;
use App\Models\Denomination;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class CashregisterSeeder extends Seeder
{
    public function run(): void
    {
        $denomination_one = Denomination::create([
            'bill_200' => 1,'bill_100' => 1, 'bill_50' => 1, 'bill_20' => 2, 'bill_10' => 1, 'coin_5' => 3, 'coin_2' => 2, 'coin_1' => 5, 'coin_0_5' => 2, 'coin_0_2' => 3, 'coin_0_1' => 2,'total' => 425.80,
        ]);
        Cashregister::create([
            'name' => 'CAJA 1',
            'user_id' => 1,
            'total' => 425.80,
            'denomination_uuid' =>  $denomination_one->denomination_uuid,
        ]);
        $denomination_two = Denomination::create([
            'bill_200' => 0, 'bill_100' => 2, 'bill_50' => 1, 'bill_20' => 3, 'bill_10' => 2, 'coin_5' => 1, 'coin_2' => 4, 'coin_1' => 2, 'coin_0_5' => 5, 'coin_0_2' => 2, 'coin_0_1' => 1,'total' => 348.00,
        ]);
        Cashregister::create([
            'name' => 'CAJA 2',
            'user_id' => 2,
            'total' => 348.00,
            'denomination_uuid' =>  $denomination_two->denomination_uuid,
        ]);
        $denomination_three = Denomination::create([
            'bill_200' => 2, 'bill_100' => 0, 'bill_50' => 2, 'bill_20' => 1, 'bill_10' => 4, 'coin_5' => 0, 'coin_2' => 3, 'coin_1' => 6, 'coin_0_5' => 1, 'coin_0_2' => 4, 'coin_0_1' => 3,'total' => 573.60,
        ]);
        Cashregister::create([
            'name' => 'CAJA 3',
            'user_id' => 3,
            'total' => 573.60,
            'denomination_uuid' =>  $denomination_three->denomination_uuid,
        ]);
        $denomination_four = Denomination::create([
            'bill_200' => 1, 'bill_100' => 3, 'bill_50' => 0, 'bill_20' => 4, 'bill_10' => 2, 'coin_5' => 5, 'coin_2' => 1, 'coin_1' => 4, 'coin_0_5' => 3, 'coin_0_2' => 1, 'coin_0_1' => 2,'total' => 632.90,
        ]);
        Cashregister::create([
            'name' => 'CAJA 4',
            'user_id' => 4,
            'total' => 632.90,
            'denomination_uuid' =>  $denomination_four->denomination_uuid,
        ]);
        $denomination_five = Denomination::create([
            'bill_200' => 0, 'bill_100' => 1, 'bill_50' => 1, 'bill_20' => 2, 'bill_10' => 3, 'coin_5' => 2, 'coin_2' => 5, 'coin_1' => 3, 'coin_0_5' => 4, 'coin_0_2' => 3, 'coin_0_1' => 5,'total' => 246.10,
        ]);
        Cashregister::create([
            'name' => 'CAJA 5',
            'user_id' => 5,
            'total' => 246.10,
            'denomination_uuid' =>  $denomination_five->denomination_uuid,
        ]);

    }
}
