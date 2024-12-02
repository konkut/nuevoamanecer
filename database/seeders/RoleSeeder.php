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
        $role2 = Role::create(['name' => 'Caja']);

        //$role1->permissions()->attach([1,2,3....]);

        Permission::create(['name' => 'dashboard'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'users.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.destroy'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.assign_roles'])->syncRoles([$role1]);

        /*CATEGORIES */
        Permission::create(['name' => 'categories.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'categories.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'categories.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'categories.destroy'])->syncRoles([$role1]);

        /*SERVICES WITHOUT PRICE */
        Permission::create(['name' => 'serviceswithoutprices.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'serviceswithoutprices.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'serviceswithoutprices.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'serviceswithoutprices.destroy'])->syncRoles([$role1]);

        /*SERVICES WITH PRICE */
        Permission::create(['name' => 'serviceswithprices.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'serviceswithprices.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'serviceswithprices.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'serviceswithprices.destroy'])->syncRoles([$role1]);

        /*TRANSACTION METHOD */
        Permission::create(['name' => 'transactionmethods.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'transactionmethods.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'transactionmethods.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'transactionmethods.destroy'])->syncRoles([$role1]);

        /*PAYMENT WITHOUT PRICE*/
        Permission::create(['name' => 'paymentwithoutprices.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'paymentwithoutprices.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'paymentwithoutprices.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'paymentwithoutprices.destroy'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'paymentwithoutpricesuser.showuser'])->syncRoles([$role1]);

        /*PAYMENT WITH PRICE*/
        Permission::create(['name' => 'paymentwithprices.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'paymentwithprices.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'paymentwithprices.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'paymentwithprices.destroy'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'paymentwithpricesuser.showuser'])->syncRoles([$role1]);


        Permission::create(['name' => 'currencies.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'currencies.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'currencies.show'])->syncRoles([$role1]);
        Permission::create(['name' => 'currencies.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'currencies.destroy'])->syncRoles([$role1]);

        Permission::create(['name' => 'denominations.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'denominations.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'denominations.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'denominations.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'denominations.destroy'])->syncRoles([$role1, $role2]);


    }
}
