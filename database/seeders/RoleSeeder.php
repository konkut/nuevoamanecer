<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
  public function run(): void
  {
    $role1 = Role::create(['name' => 'Administrador']);
    $role2  = Role::create(['name' => 'Caja']);

    //$role1->permissions()->attach([1,2,3....]);

    Permission::create(['name' => 'dashboard'])->syncRoles([$role1, $role2]);

    Permission::create(['name' => 'users.index'])->syncRoles([$role1]);
    Permission::create(['name' => 'users.create'])->syncRoles([$role1]);
    Permission::create(['name' => 'users.show'])->syncRoles([$role1]);
    Permission::create(['name' => 'users.edit'])->syncRoles([$role1]);
    Permission::create(['name' => 'users.destroy'])->syncRoles([$role1]);
    Permission::create(['name' => 'users.assign_roles'])->syncRoles([$role1]);

    Permission::create(['name' => 'services.index'])->syncRoles([$role1,$role2]);
    Permission::create(['name' => 'services.create'])->syncRoles([$role1]);
    Permission::create(['name' => 'services.show'])->syncRoles([$role1]);
    Permission::create(['name' => 'services.edit'])->syncRoles([$role1]);
    Permission::create(['name' => 'services.destroy'])->syncRoles([$role1]);

    Permission::create(['name' => 'currencies.index'])->syncRoles([$role1]);
    Permission::create(['name' => 'currencies.create'])->syncRoles([$role1]);
    Permission::create(['name' => 'currencies.show'])->syncRoles([$role1]);
    Permission::create(['name' => 'currencies.edit'])->syncRoles([$role1]);
    Permission::create(['name' => 'currencies.destroy'])->syncRoles([$role1]);

    Permission::create(['name' => 'categories.index'])->syncRoles([$role1,$role2]);
    Permission::create(['name' => 'categories.create'])->syncRoles([$role1]);
    Permission::create(['name' => 'categories.show'])->syncRoles([$role1]);
    Permission::create(['name' => 'categories.edit'])->syncRoles([$role1]);
    Permission::create(['name' => 'categories.destroy'])->syncRoles([$role1]);

    Permission::create(['name' => 'incomefromtransfers.index'])->syncRoles([$role1, $role2]);
    Permission::create(['name' => 'incomefromtransfers.create'])->syncRoles([$role1, $role2]);
    Permission::create(['name' => 'incomefromtransfers.show'])->syncRoles([$role1, $role2]);
    Permission::create(['name' => 'incomefromtransfers.edit'])->syncRoles([$role1, $role2]);
    Permission::create(['name' => 'incomefromtransfers.destroy'])->syncRoles([$role1, $role2]);

    Permission::create(['name' => 'denominations.index'])->syncRoles([$role1, $role2]);
    Permission::create(['name' => 'denominations.create'])->syncRoles([$role1, $role2]);
    Permission::create(['name' => 'denominations.show'])->syncRoles([$role1, $role2]);
    Permission::create(['name' => 'denominations.edit'])->syncRoles([$role1, $role2]);
    Permission::create(['name' => 'denominations.destroy'])->syncRoles([$role1, $role2]);

    Permission::create(['name' => 'servicesprices.index'])->syncRoles([$role1, $role2]);
    Permission::create(['name' => 'servicesprices.create'])->syncRoles([$role1]);
    Permission::create(['name' => 'servicesprices.show'])->syncRoles([$role1]);
    Permission::create(['name' => 'servicesprices.edit'])->syncRoles([$role1]);
    Permission::create(['name' => 'servicesprices.destroy'])->syncRoles([$role1]);

  }
}
