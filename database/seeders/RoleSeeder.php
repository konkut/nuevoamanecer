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
        $role3 = Role::create(['name' => 'Contador']);

        //$role1->permissions()->attach([1,2,3....]);

        Permission::create(['name' => 'dashboard'])->syncRoles([$role1, $role2, $role3]);

        /*USERS ok*/
        Permission::create(['name' => 'users.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.destroy'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.roles'])->syncRoles([$role1]);

        /*CATEGORIES ok*/
        Permission::create(['name' => 'categories.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'categories.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'categories.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'categories.destroy'])->syncRoles([$role1]);

        /*SERVICES WITHOUT PRICE ok*/
        Permission::create(['name' => 'services.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'services.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'services.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'services.destroy'])->syncRoles([$role1]);

        /*TRANSACTION METHOD ok*/
        Permission::create(['name' => 'platforms.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'platforms.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'platforms.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'platforms.destroy'])->syncRoles([$role1]);

        /*INCOMES*/
        Permission::create(['name' => 'incomes.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'incomes.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'incomes.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'incomes.destroy'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'incomes.search'])->syncRoles([$role1, $role2]);

        /*RECEIPTS*/
        Permission::create(['name' => 'receipts.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'receipts.create'])->syncRoles([$role1, $role2]);

        /*DENOMINATION*/
        Permission::create(['name' => 'denominations.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'denominations.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'denominations.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'denominations.destroy'])->syncRoles([$role1, $role2]);

        /*CASHCOUNTS*/
        Permission::create(['name' => 'cashcounts.index'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'cashcounts.create'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'cashcounts.edit'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'cashcounts.destroy'])->syncRoles([$role1, $role2, $role3]);

        /*CASHREGISTERS*/
        Permission::create(['name' => 'cashregisters.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'cashregisters.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'cashregisters.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'cashregisters.destroy'])->syncRoles([$role1]);

        /*CASHSHIFTS ok*/
        Permission::create(['name' => 'cashshifts.index'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'cashshifts.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'cashshifts.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'cashshifts.destroy'])->syncRoles([$role1]);

        /*EXPENSES ok*/
        Permission::create(['name' => 'expenses.index'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'expenses.create'])->syncRoles([$role1,$role2, $role3]);
        Permission::create(['name' => 'expenses.edit'])->syncRoles([$role1,$role2, $role3]);
        Permission::create(['name' => 'expenses.destroy'])->syncRoles([$role1,$role2, $role3]);

        /*PRODUCTS ok*/
        Permission::create(['name' => 'products.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'products.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'products.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'products.destroy'])->syncRoles([$role1]);

        /*SALES ok*/
        Permission::create(['name' => 'sales.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'sales.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'sales.edit'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'sales.destroy'])->syncRoles([$role1,$role2]);

        /*CASHREGISTERS ok*/
        Permission::create(['name' => 'bankregisters.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'bankregisters.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'bankregisters.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'bankregisters.destroy'])->syncRoles([$role1]);

        /*ACCOUNTCLASS ok*/
        Permission::create(['name' => 'accountclasses.index'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'accountclasses.create'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'accountclasses.edit'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'accountclasses.destroy'])->syncRoles([$role1, $role3]);

        /*ACCOUNTGROUP ok*/
        Permission::create(['name' => 'accountgroups.index'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'accountgroups.create'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'accountgroups.edit'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'accountgroups.destroy'])->syncRoles([$role1, $role3]);

        /*ACCOUNTSUBGROUP ok*/
        Permission::create(['name' => 'accountsubgroups.index'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'accountsubgroups.create'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'accountsubgroups.edit'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'accountsubgroups.destroy'])->syncRoles([$role1, $role3]);

        /*MAINACCOUNTS ok*/
        Permission::create(['name' => 'mainaccounts.index'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'mainaccounts.create'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'mainaccounts.edit'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'mainaccounts.destroy'])->syncRoles([$role1, $role3]);

        /*ANALYTICALACCOUNTS ok*/
        Permission::create(['name' => 'analyticalaccounts.index'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'analyticalaccounts.create'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'analyticalaccounts.edit'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'analyticalaccounts.destroy'])->syncRoles([$role1, $role3]);

        /*ACCOUNTS ok*/
        Permission::create(['name' => 'accounts.index'])->syncRoles([$role1, $role3]);

        /*ACTIVITIES ok*/
        Permission::create(['name' => 'activities.index'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'activities.create'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'activities.edit'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'activities.destroy'])->syncRoles([$role1, $role3]);

        /*COMPANIES ok*/
        Permission::create(['name' => 'companies.index'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'companies.create'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'companies.edit'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'companies.destroy'])->syncRoles([$role1, $role3]);

        /*PROJECTS ok*/
        Permission::create(['name' => 'projects.index'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'projects.create'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'projects.edit'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'projects.destroy'])->syncRoles([$role1, $role3]);

        /*VOUCHERS ok*/
        Permission::create(['name' => 'vouchers.index'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'vouchers.create'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'vouchers.edit'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'vouchers.destroy'])->syncRoles([$role1, $role3]);

        /*CUSTOMERS ok*/
        Permission::create(['name' => 'customers.index'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'customers.create'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'customers.edit'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'customers.destroy'])->syncRoles([$role1, $role3]);

        /*REVENUES ok*/
        Permission::create(['name' => 'revenues.index'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'revenues.create'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'revenues.edit'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'revenues.destroy'])->syncRoles([$role1, $role3]);

        /*INVOICES*/
        Permission::create(['name' => 'invoices.index'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'invoices.create'])->syncRoles([$role1, $role3]);

        /*CASHFLOWDAILY ok*/
        Permission::create(['name' => 'cashflowdailies.index'])->syncRoles([$role1]);

        Permission::create(['name' => 'currencies.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'currencies.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'currencies.show'])->syncRoles([$role1]);
        Permission::create(['name' => 'currencies.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'currencies.destroy'])->syncRoles([$role1]);
    }
}
