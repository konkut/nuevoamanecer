<?php

namespace Database\Seeders;

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
      ServicewithpriceSeeder::class,
      ServicewithoutpriceSeeder::class,
      TransactionmethodSeeder::class,
        ProductSeeder::class,
    ]);
  }
}
