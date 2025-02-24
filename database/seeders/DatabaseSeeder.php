<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Bankregister;
use App\Models\Company;
use App\Models\Platform;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ServiceSeeder::class,
            ProductSeeder::class,
            CashregisterSeeder::class,
            BankregisterSeeder::class,
            PlatformSeeder::class,
            AccountclassSeeder::class,
            AccountgroupSeeder::class,
            AccountsubgroupSeeder::class,
            AccountSeeder::class,
            ActivitySeeder::class,
            CompanySeeder::class,
        ]);
    }
}
