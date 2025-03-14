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
        $role4 = Role::create(['name' => 'Empresa']);

        Permission::create(['name' => 'two_factor.get_code'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'two_factor.get_verify'])->syncRoles([$role1, $role2, $role3, $role4]);

        Permission::create(['name' => 'password.edit'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'password.update'])->syncRoles([$role1, $role2, $role3, $role4]);

        /*SETTING*/
        Permission::create(['name' => 'settings.update_user'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'settings.update_password'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'settings.two_factor'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'settings.logout_session'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'settings.disable_account'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'settings.change_language'])->syncRoles([$role1, $role2, $role3, $role4]);

        /*DASHBOARD*/
        Permission::create(['name' => 'dashboard'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'dashboards.off_session'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'dashboards.on_session'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'dashboards.search_sessions'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'dashboards.search_session'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'dashboards.session'])->syncRoles([$role1, $role2, $role3]);

        /*USERS ok*/
        Permission::create(['name' => 'users.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.destroy'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.status'])->syncRoles([$role1]);

        /*CATEGORIES ok*/
        Permission::create(['name' => 'categories.index'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'categories.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'categories.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'categories.destroy'])->syncRoles([$role1]);
        Permission::create(['name' => 'categories.status'])->syncRoles([$role1]);

        /*SERVICES ok*/
        Permission::create(['name' => 'services.index'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'services.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'services.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'services.destroy'])->syncRoles([$role1]);
        Permission::create(['name' => 'services.status'])->syncRoles([$role1]);

        /*PLATFORM ok*/
        Permission::create(['name' => 'platforms.index'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'platforms.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'platforms.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'platforms.destroy'])->syncRoles([$role1]);
        Permission::create(['name' => 'platforms.status'])->syncRoles([$role1]);

        /*INCOMES*/
        Permission::create(['name' => 'incomes.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'incomes.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'incomes.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'incomes.destroy'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'incomes.export'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'incomes.detail'])->syncRoles([$role1, $role2]);

        /*RECEIPTS*/
        Permission::create(['name' => 'receipts.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'receipts.create'])->syncRoles([$role1, $role2]);

        /*CASHREGISTERS*/
        Permission::create(['name' => 'cashregisters.index'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'cashregisters.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'cashregisters.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'cashregisters.destroy'])->syncRoles([$role1]);
        Permission::create(['name' => 'cashregisters.detail'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'cashregisters.status'])->syncRoles([$role1]);

        /*CASHSHIFTS ok*/
        Permission::create(['name' => 'cashshifts.index'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'cashshifts.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'cashshifts.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'cashshifts.destroy'])->syncRoles([$role1]);
        Permission::create(['name' => 'cashshifts.price'])->syncRoles([$role1]);
        Permission::create(['name' => 'cashshifts.amount'])->syncRoles([$role1]);
        Permission::create(['name' => 'cashshifts.value'])->syncRoles([$role1]);
        Permission::create(['name' => 'cashshifts.detail'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'cashshifts.status'])->syncRoles([$role1, $role2, $role3]);

        /*CASHCOUNTS*/
        Permission::create(['name' => 'cashcounts.create'])->syncRoles([$role1, $role2, $role3]);

        /*EXPENSES ok*/
        Permission::create(['name' => 'expenses.index'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'expenses.create'])->syncRoles([$role1,$role2, $role3]);
        Permission::create(['name' => 'expenses.edit'])->syncRoles([$role1,$role2, $role3]);
        Permission::create(['name' => 'expenses.destroy'])->syncRoles([$role1,$role2, $role3]);
        Permission::create(['name' => 'expenses.export'])->syncRoles([$role1,$role2, $role3]);
        Permission::create(['name' => 'expenses.detail'])->syncRoles([$role1,$role2, $role3]);

        /*PRODUCTS ok*/
        Permission::create(['name' => 'products.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'products.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'products.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'products.destroy'])->syncRoles([$role1]);
        Permission::create(['name' => 'products.status'])->syncRoles([$role1]);

        /*SALES ok*/
        Permission::create(['name' => 'sales.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'sales.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'sales.edit'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'sales.destroy'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'sales.export'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'sales.detail'])->syncRoles([$role1,$role2]);

        /*BANKREGISTERS ok*/
        Permission::create(['name' => 'bankregisters.index'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'bankregisters.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'bankregisters.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'bankregisters.destroy'])->syncRoles([$role1]);
        Permission::create(['name' => 'bankregisters.status'])->syncRoles([$role1]);

        /*ACCOUNTCLASS ok*/
        Permission::create(['name' => 'accountclasses.index'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'accountclasses.create'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'accountclasses.edit'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'accountclasses.destroy'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'accountclasses.status'])->syncRoles([$role1, $role3]);

        /*ACCOUNTGROUP ok*/
        Permission::create(['name' => 'accountgroups.index'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'accountgroups.create'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'accountgroups.edit'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'accountgroups.destroy'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'accountgroups.status'])->syncRoles([$role1, $role3]);

        /*ACCOUNTSUBGROUP ok*/
        Permission::create(['name' => 'accountsubgroups.index'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'accountsubgroups.create'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'accountsubgroups.edit'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'accountsubgroups.destroy'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'accountsubgroups.status'])->syncRoles([$role1, $role3]);

        /*MAINACCOUNTS ok*/
        Permission::create(['name' => 'mainaccounts.index'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'mainaccounts.create'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'mainaccounts.edit'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'mainaccounts.destroy'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'mainaccounts.status'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'mainaccounts.business'])->syncRoles([$role1, $role3]);

        /*ANALYTICALACCOUNTS ok*/
        Permission::create(['name' => 'analyticalaccounts.index'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'analyticalaccounts.create'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'analyticalaccounts.edit'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'analyticalaccounts.destroy'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'analyticalaccounts.status'])->syncRoles([$role1, $role3]);

        /*ACCOUNTS ok*/
        Permission::create(['name' => 'accounts.index'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'accounts.chart'])->syncRoles([$role1, $role3]);

        /*ACTIVITIES ok*/
        Permission::create(['name' => 'activities.index'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'activities.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'activities.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'activities.destroy'])->syncRoles([$role1]);
        Permission::create(['name' => 'activities.status'])->syncRoles([$role1]);

        /*COMPANIES ok*/
        Permission::create(['name' => 'companies.index'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'companies.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'companies.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'companies.destroy'])->syncRoles([$role1]);
        Permission::create(['name' => 'companies.status'])->syncRoles([$role1]);

        /*PROJECTS ok*/
        Permission::create(['name' => 'projects.index'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'projects.create'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'projects.edit'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'projects.destroy'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'projects.status'])->syncRoles([$role1, $role3]);

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
        Permission::create(['name' => 'customers.status'])->syncRoles([$role1, $role3]);

        /*REVENUES ok*/
        Permission::create(['name' => 'revenues.index'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'revenues.create'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'revenues.edit'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'revenues.destroy'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'revenues.export'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'revenues.detail'])->syncRoles([$role1, $role3]);

        /*INVOICES*/
        Permission::create(['name' => 'invoices.index'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'invoices.create'])->syncRoles([$role1, $role3]);

        /*BUSINESS TYPE ok*/
        Permission::create(['name' => 'businesstypes.index'])->syncRoles([$role1, $role3]);
        Permission::create(['name' => 'businesstypes.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'businesstypes.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'businesstypes.destroy'])->syncRoles([$role1]);
        Permission::create(['name' => 'businesstypes.status'])->syncRoles([$role1]);

        /*ACCESS ACCOUNTING ok*/
        Permission::create(['name' => 'accounting.session'])->syncRoles([$role1, $role3, $role4]);
        Permission::create(['name' => 'accounting.ledger'])->syncRoles([$role1, $role3, $role4]);
        Permission::create(['name' => 'accounting.balances'])->syncRoles([$role1, $role3, $role4]);

    }
}
