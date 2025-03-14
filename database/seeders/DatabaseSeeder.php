<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Bankregister;
use App\Models\Businesstype;
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
            BusinesstypeSeeder::class,
            AccountclassSeeder::class,
            AccountgroupSeeder::class,
            AccountsubgroupSeeder::class,
            MainaccountSeeder::class,
            AnalyticalaccountSeeder::class,
            ActivitySeeder::class,
            CompanySeeder::class,
            ProjectSeeder::class,
            CustomerSeeder::class,
        ]);
    }
}
