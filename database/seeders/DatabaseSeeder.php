<?php

namespace Database\Seeders;

use App\Models\Bankregister;
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
      MethodSeeder::class,
      ProductSeeder::class,
    ]);
  }
}
