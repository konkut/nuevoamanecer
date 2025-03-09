<?php

use App\Http\Controllers\Api\ApiServiceController;
use App\Http\Controllers\CashregisterController;
use App\Http\Controllers\BankregisterController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CashshiftController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ControlController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\AccountclassController;
use App\Http\Controllers\AccountgroupController;
use App\Http\Controllers\AccountsubgroupController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CashcountController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\VoucherController;
use App\Http\Middleware\ForcePasswordChange;
use App\Http\Controllers\ForcePasswordChangeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\MainaccountController;
use App\Http\Controllers\AnalyticalaccountController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CloseSession;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/forgot/password', [ForgotPasswordController::class, 'create'])
    ->middleware(['guest:' . config('fortify.guard')])->name('password.request');
Route::post('/forgot/password/update', [ForgotPasswordController::class, 'store'])
    ->middleware(['guest:' . config('fortify.guard')])->name('password.email');

Route::get('/reset/password/{id}', [ResetPasswordEmailController::class, 'edit'])
    ->middleware(['guest:' . config('fortify.guard')])->name('password.link');
Route::put('/reset/password/update', [ResetPasswordEmailController::class, 'update'])
    ->middleware(['guest:' . config('fortify.guard')])->name('password.update');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'check_user_status',
    'two_factor',
    'force_password_change',
    'close_session',
    'language',
])->group(function () {

    Route::get('/two/factor', [TwoFactorController::class, 'get_code'])->name('connect_two_factor')->withoutMiddleware([ForcePasswordChange::class, CloseSession::class]);
    Route::post('/two/factor/verify', [TwoFactorController::class, 'get_verify'])->name('verify_two_factor')->withoutMiddleware([ForcePasswordChange::class, CloseSession::class]);

    Route::get('/password/change', [ForcePasswordChangeController::class, 'edit'])->name('password.change')->withoutMiddleware([CloseSession::class]);
    Route::post('/password/change', [ForcePasswordChangeController::class, 'update'])->name('password.change.update')->withoutMiddleware([CloseSession::class]);

    /*SETTING*/
    Route::put('/user/data', [SettingController::class, 'update_user'])->name('update_user');
    Route::put('/user/password', [SettingController::class, 'update_password'])->name('update_password');
    Route::post('/two/factor/status', [SettingController::class, 'two_factor'])->name('status_two_factor');
    Route::post('/logout/session', [SettingController::class, 'logout_session'])->name('logout_session');
    Route::post('/disable/account', [SettingController::class, 'disable_account'])->name('disable_account');
    Route::get('/language/{lang}', [SettingController::class, 'change_language'])->name('change.language');


    /*DASHBOARD*/
    Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard")->middleware('can:dashboard');
    Route::put('/dashboard/{cashshift_uuid}/off', [DashboardController::class, 'off_session'])->name('dashboards.off_session');
    Route::put('/dashboard/{cashshift_uuid}/on', [DashboardController::class, 'on_session'])->name('dashboards.on_session');
    Route::get('/dashboard/search/sessions', [DashboardController::class, 'search_sessions'])->name('dashboards.search_sessions');
    Route::get('/dashboard/search/session', [DashboardController::class, 'search_session'])->name('dashboards.search_session');
    Route::get('/dashboard/session/{cashshift_uuid}', [DashboardController::class, 'one_session'])->name('dashboards.session');

    /*CONTROL*/
    Route::get("/control", [ControlController::class, "control"])->name("control");

    /* USERS */
    Route::get("/users", [UserController::class, "index"])->name("users.index")->middleware('can:users.index');
    Route::get("/users/create", [UserController::class, "create"])->name("users.create")->middleware('can:users.create');
    Route::post("/users", [UserController::class, "store"])->name("users.store")->middleware('can:users.create');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('can:users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update')->middleware('can:users.edit');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('can:users.destroy');
    Route::put('/users/{id}/enable', [UserController::class, 'enable'])->name('users.enable');
    Route::put('/users/{id}/disable', [UserController::class, 'disable'])->name('users.disable');
    Route::post('/users/{id}', [UserController::class, 'roles'])->name('users.roles')->middleware('can:users.roles');

    /*CATEGORIES */
    Route::get("/categories", [CategoryController::class, "index"])->name("categories.index")->middleware('can:categories.index');
    Route::get("/categories/create", [CategoryController::class, "create"])->name("categories.create")->middleware('can:categories.create');
    Route::post("/categories", [CategoryController::class, "store"])->name("categories.store")->middleware('can:categories.create');
    Route::get('/categories/{category_id}/edit', [CategoryController::class, 'edit'])->name('categories.edit')->middleware('can:categories.edit');
    Route::put("/categories/{category_id}/disable", [CategoryController::class, "disable"])->name("categories.disable");
    Route::put("/categories/{category_id}/enable", [CategoryController::class, "enable"])->name("categories.enable");
    Route::put('/categories/{category_id}', [CategoryController::class, 'update'])->name('categories.update')->middleware('can:categories.edit');
    Route::delete('/categories/{category_id}', [CategoryController::class, 'destroy'])->name('categories.destroy')->middleware('can:categories.destroy');

    /*SERVICES */
    Route::get("/services", [ServiceController::class, "index"])->name("services.index")->middleware('can:services.index');
    Route::get("/services/create", [ServiceController::class, "create"])->name("services.create")->middleware('can:services.create');
    Route::post("/services", [ServiceController::class, "store"])->name("services.store")->middleware('can:services.create');
    Route::get('/services/{service_uuid}/edit', [ServiceController::class, 'edit'])->name('services.edit')->middleware('can:services.edit');
    Route::put("/services/{service_uuid}/disable", [ServiceController::class, "disable"])->name("services.disable");
    Route::put("/services/{service_uuid}/enable", [ServiceController::class, "enable"])->name("services.enable");
    Route::put('/services/{service_uuid}', [ServiceController::class, 'update'])->name('services.update')->middleware('can:services.edit');
    Route::delete('/services/{service_uuid}', [ServiceController::class, 'destroy'])->name('services.destroy')->middleware('can:services.destroy');

    /*PLATFORM */
    Route::get("/platforms", [PlatformController::class, "index"])->name("platforms.index")->middleware('can:platforms.index');
    Route::get("/platforms/create", [PlatformController::class, "create"])->name("platforms.create")->middleware('can:platforms.create');
    Route::post("/platforms", [PlatformController::class, "store"])->name("platforms.store")->middleware('can:platforms.create');
    Route::get('/platforms/{platform_uuid}/edit', [PlatformController::class, 'edit'])->name('platforms.edit')->middleware('can:platforms.edit');
    Route::put("/platforms/{platform_uuid}/disable", [PlatformController::class, "disable"])->name("platforms.disable");
    Route::put("/platforms/{platform_uuid}/enable", [PlatformController::class, "enable"])->name("platforms.enable");
    Route::put('/platforms/{platform_uuid}', [PlatformController::class, 'update'])->name('platforms.update')->middleware('can:platforms.edit');
    Route::delete('/platforms/{platform_uuid}', [PlatformController::class, 'destroy'])->name('platforms.destroy')->middleware('can:platforms.destroy');

    /*INCOMES */
    Route::get("/incomes", [IncomeController::class, "index"])->name("incomes.index")->middleware('can:incomes.index');
    Route::get('/incomes/export', [IncomeController::class, 'export'])->name('incomes.export');
    Route::middleware(['cashshift_session'])->group(function () {
        Route::get("/incomes/create", [IncomeController::class, "create"])->name("incomes.create")->middleware('can:incomes.create');
        Route::post("/incomes", [IncomeController::class, "store"])->name("incomes.store")->middleware('can:incomes.create');
        Route::get('/incomes/{income_uuid}/edit', [IncomeController::class, 'edit'])->name('incomes.edit')->middleware('can:incomes.edit');
        Route::put('/incomes/{income_uuid}', [IncomeController::class, 'update'])->name('incomes.update')->middleware('can:incomes.edit');
    });
    Route::post('/incomes/{income_uuid}/detail', [IncomeController::class, 'detail'])->name('incomes.detail');
    Route::delete('/incomes/{income_uuid}', [IncomeController::class, 'destroy'])->name('incomes.destroy')->middleware('can:incomes.destroy');

    //RECEIPTS
    Route::get("/receipts", [ReceiptController::class, "index"])->name("receipts.index")->middleware('can:receipts.index');
    Route::get('/receipts/{income_uuid}', [ReceiptController::class, 'store'])->name('receipts.store')->middleware('can:receipts.create');

    /*CASHREGISTERS */
    Route::get("/cashregisters", [CashregisterController::class, "index"])->name("cashregisters.index")->middleware('can:cashregisters.index');
    Route::get("/cashregisters/create", [CashregisterController::class, "create"])->name("cashregisters.create")->middleware('can:cashregisters.create');
    Route::post("/cashregisters", [CashregisterController::class, "store"])->name("cashregisters.store")->middleware('can:cashregisters.create');
    Route::get('/cashregisters/{cashregister_uuid}/edit', [CashregisterController::class, 'edit'])->name('cashregisters.edit')->middleware('can:cashregisters.edit');
    Route::post('/cashregisters/{cashregister_uuid}', [CashregisterController::class, 'detail'])->name('cashregisters.detail');
    Route::put("/cashregisters/{cashregister_uuid}/disable", [CashregisterController::class, "disable"])->name("cashregisters.disable");
    Route::put("/cashregisters/{cashregister_uuid}/enable", [CashregisterController::class, "enable"])->name("cashregisters.enable");
    Route::put('/cashregisters/{cashregister_uuid}', [CashregisterController::class, 'update'])->name('cashregisters.update')->middleware('can:cashregisters.edit');
    Route::delete('/cashregisters/{cashregister_uuid}', [CashregisterController::class, 'destroy'])->name('cashregisters.destroy')->middleware('can:cashregisters.destroy');

    /*CASHSHIFTS */
    Route::get("/cashshifts", [CashshiftController::class, "index"])->name("cashshifts.index")->middleware('can:cashshifts.index');
    Route::get("/cashshifts/create", [CashshiftController::class, "create"])->name("cashshifts.create")->middleware('can:cashshifts.create');
    Route::post("/cashshifts", [CashshiftController::class, "store"])->name("cashshifts.store")->middleware('can:cashshifts.create');
    Route::get('/cashshifts/{cashshift_uuid}/price', [CashshiftController::class, 'price'])->name('cashshifts.price');
    Route::get('/cashshifts/{bankregister_uuid}/amount', [CashshiftController::class, 'amount'])->name('cashshifts.amount');
    Route::get('/cashshifts/{platform_uuid}/value', [CashshiftController::class, 'value'])->name('cashshifts.value');
    Route::post('/cashshifts/{cashshift_uuid}', [CashshiftController::class, 'detail'])->name('cashshifts.detail');
    Route::get('/cashshifts/{cashshift_uuid}/edit', [CashshiftController::class, 'edit'])->name('cashshifts.edit')->middleware('can:cashshifts.edit');
    Route::put('/cashshifts/{cashshift_uuid}', [CashshiftController::class, 'update'])->name('cashshifts.update')->middleware('can:cashshifts.edit');
    Route::put('/cashshifts/{cashshift_uuid}/enable', [CashshiftController::class, 'enable'])->name('cashshifts.enable');
    Route::put('/cashshifts/{cashshift_uuid}/disable', [CashshiftController::class, 'disable'])->name('cashshifts.disable');
    Route::delete('/cashshifts/{cashshift_uuid}', [CashshiftController::class, 'destroy'])->name('cashshifts.destroy')->middleware('can:cashshifts.destroy');

    /*CASHCOUNT*/
    Route::get("/cashshifts/{cashshift_uuid}/cashcount", [CashcountController::class, "create"])->name("cashcounts.create");
    Route::post("/cashshifts/{cashshift_uuid}/cashcount", [CashcountController::class, "store"])->name("cashcounts.store");
    Route::get('/cashshifts/{cashshift_uuid}/cashcount/edit', [CashcountController::class, 'edit'])->name('cashcounts.edit');
    Route::put('/cashshifts/{cashshift_uuid}/cashcount', [CashcountController::class, 'update'])->name('cashcounts.update');

    /*EXPENSES */
    Route::get("/expenses", [ExpenseController::class, "index"])->name("expenses.index")->middleware('can:expenses.index');
    Route::middleware(['cashshift_session'])->group(function () {
        Route::get("/expenses/create", [ExpenseController::class, "create"])->name("expenses.create")->middleware('can:expenses.create');
        Route::post("/expenses", [ExpenseController::class, "store"])->name("expenses.store")->middleware('can:expenses.create');
        Route::get('/expenses/{expense_uuid}/edit', [ExpenseController::class, 'edit'])->name('expenses.edit')->middleware('can:expenses.edit');
        Route::put('/expenses/{expense_uuid}', [ExpenseController::class, 'update'])->name('expenses.update')->middleware('can:expenses.edit');
    });
    Route::get('/expenses/export', [ExpenseController::class, 'export'])->name('expenses.export');
    Route::post('/expenses/{expense_uuid}', [ExpenseController::class, 'detail'])->name('expenses.detail');
    Route::delete('/expenses/{expense_uuid}', [ExpenseController::class, 'destroy'])->name('expenses.destroy')->middleware('can:expenses.destroy');

    /*PRODUCTS */
    Route::get("/products", [ProductController::class, "index"])->name("products.index")->middleware('can:products.index');
    Route::get("/products/create", [ProductController::class, "create"])->name("products.create")->middleware('can:products.create');
    Route::post("/products", [ProductController::class, "store"])->name("products.store")->middleware('can:products.create');
    Route::get('/products/{product_uuid}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('can:products.edit');
    Route::put("/products/{product_uuid}/disable", [ProductController::class, "disable"])->name("products.disable");
    Route::put("/products/{product_uuid}/enable", [ProductController::class, "enable"])->name("products.enable");
    Route::put('/products/{product_uuid}', [ProductController::class, 'update'])->name('products.update')->middleware('can:products.edit');
    Route::delete('/products/{product_uuid}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('can:products.destroy');

    /*SALES */
    Route::get("/sales", [SaleController::class, "index"])->name("sales.index")->middleware('can:sales.index');
    Route::middleware(['cashshift_session'])->group(function () {
        Route::get("/sales/create", [SaleController::class, "create"])->name("sales.create")->middleware('can:sales.create');
        Route::post("/sales", [SaleController::class, "store"])->name("sales.store")->middleware('can:sales.create');
        Route::get('/sales/{sale_uuid}/edit', [SaleController::class, 'edit'])->name('sales.edit')->middleware('can:sales.edit');
        Route::put('/sales/{sale_uuid}', [SaleController::class, 'update'])->name('sales.update')->middleware('can:sales.edit');
    });
    Route::get('/sales/export', [SaleController::class, 'export'])->name('sales.export');
    Route::post('/sales/{sale_uuid}/detail', [SaleController::class, 'detail'])->name('sales.detail');
    Route::delete('/sales/{sale_uuid}', [SaleController::class, 'destroy'])->name('sales.destroy')->middleware('can:sales.destroy');

    /*BANKREGISTERS */
    Route::get("/bankregisters", [BankregisterController::class, "index"])->name("bankregisters.index")->middleware('can:bankregisters.index');
    Route::get("/bankregisters/create", [BankregisterController::class, "create"])->name("bankregisters.create")->middleware('can:bankregisters.create');
    Route::post("/bankregisters", [BankregisterController::class, "store"])->name("bankregisters.store")->middleware('can:bankregisters.create');
    Route::get('/bankregisters/{bankregister_uuid}/edit', [BankregisterController::class, 'edit'])->name('bankregisters.edit')->middleware('can:bankregisters.edit');
    Route::put("/bankregisters/{bankregister_uuid}/disable", [BankregisterController::class, "disable"])->name("bankregisters.disable");
    Route::put("/bankregisters/{bankregister_uuid}/enable", [BankregisterController::class, "enable"])->name("bankregisters.enable");
    Route::put('/bankregisters/{bankregister_uuid}', [BankregisterController::class, 'update'])->name('bankregisters.update')->middleware('can:bankregisters.edit');
    Route::delete('/bankregisters/{bankregister_uuid}', [BankregisterController::class, 'destroy'])->name('bankregisters.destroy')->middleware('can:bankregisters.destroy');

    /*ACCOUNT CLASS*/
    Route::get("/accountclasses/create", [AccountclassController::class, "create"])->name("accountclasses.create")->middleware('can:accountclasses.create');
    Route::post("/accountclasses", [AccountclassController::class, "store"])->name("accountclasses.store")->middleware('can:accountclasses.create');
    Route::get('/accountclasses/{accountclass_uuid}/edit', [AccountclassController::class, 'edit'])->name('accountclasses.edit')->middleware('can:accountclasses.edit');
    Route::put("/accountclasses/{accountclass_uuid}/disable", [AccountclassController::class, "disable"])->name("accountclasses.disable");
    Route::put("/accountclasses/{accountclass_uuid}/enable", [AccountclassController::class, "enable"])->name("accountclasses.enable");
    Route::put('/accountclasses/{accountclass_uuid}', [AccountclassController::class, 'update'])->name('accountclasses.update')->middleware('can:accountclasses.edit');
    Route::delete('/accountclasses/{accountclass_uuid}', [AccountclassController::class, 'destroy'])->name('accountclasses.destroy')->middleware('can:accountclasses.destroy');

    /*ACCOUNT GROUP*/
    Route::get("/accountgroups/create", [AccountgroupController::class, "create"])->name("accountgroups.create")->middleware('can:accountgroups.create');
    Route::post("/accountgroups", [AccountgroupController::class, "store"])->name("accountgroups.store")->middleware('can:accountgroups.create');
    Route::get('/accountgroups/{accountgroup_uuid}/edit', [AccountgroupController::class, 'edit'])->name('accountgroups.edit')->middleware('can:accountgroups.edit');
    Route::put("/accountgroups/{accountgroup_uuid}/disable", [AccountgroupController::class, "disable"])->name("accountgroups.disable");
    Route::put("/accountgroups/{accountgroup_uuid}/enable", [AccountgroupController::class, "enable"])->name("accountgroups.enable");
    Route::put('/accountgroups/{accountgroup_uuid}', [AccountgroupController::class, 'update'])->name('accountgroups.update')->middleware('can:accountgroups.edit');
    Route::delete('/accountgroups/{accountgroup_uuid}', [AccountgroupController::class, 'destroy'])->name('accountgroups.destroy')->middleware('can:accountgroups.destroy');

    /*ACCOUNT SUBGROUP*/
    Route::get("/accountsubgroups/create", [AccountsubgroupController::class, "create"])->name("accountsubgroups.create")->middleware('can:accountsubgroups.create');
    Route::post("/accountsubgroups", [AccountsubgroupController::class, "store"])->name("accountsubgroups.store")->middleware('can:accountsubgroups.create');
    Route::get('/accountsubgroups/{accountsubgroup_uuid}/edit', [AccountsubgroupController::class, 'edit'])->name('accountsubgroups.edit')->middleware('can:accountsubgroups.edit');
    Route::put("/accountsubgroups/{accountsubgroup_uuid}/disable", [AccountsubgroupController::class, "disable"])->name("accountsubgroups.disable");
    Route::put("/accountsubgroups/{accountsubgroup_uuid}/enable", [AccountsubgroupController::class, "enable"])->name("accountsubgroups.enable");
    Route::put('/accountsubgroups/{accountsubgroup_uuid}', [AccountsubgroupController::class, 'update'])->name('accountsubgroups.update')->middleware('can:accountsubgroups.edit');
    Route::delete('/accountsubgroups/{accountsubgroup_uuid}', [AccountsubgroupController::class, 'destroy'])->name('accountsubgroups.destroy')->middleware('can:accountsubgroups.destroy');

    /*MAIN ACCOUNT*/
    Route::get("/mainaccounts/create", [MainaccountController::class, "create"])->name("mainaccounts.create")->middleware('can:mainaccounts.create');
    Route::post("/mainaccounts", [MainaccountController::class, "store"])->name("mainaccounts.store")->middleware('can:mainaccounts.create');
    Route::get('/mainaccounts/{mainaccount_uuid}/edit', [MainaccountController::class, 'edit'])->name('mainaccounts.edit')->middleware('can:mainaccounts.edit');
    Route::put("/mainaccounts/{mainaccount_uuid}/disable", [MainaccountController::class, "disable"])->name("mainaccounts.disable");
    Route::put("/mainaccounts/{mainaccount_uuid}/enable", [MainaccountController::class, "enable"])->name("mainaccounts.enable");
    Route::put('/mainaccounts/{mainaccount_uuid}', [MainaccountController::class, 'update'])->name('mainaccounts.update')->middleware('can:mainaccounts.edit');
    Route::delete('/mainaccounts/{mainaccount_uuid}', [MainaccountController::class, 'destroy'])->name('mainaccounts.destroy')->middleware('can:mainaccounts.destroy');

    /*ANALYTICAL ACCOUNT*/
    Route::get("/analyticalaccounts/create", [AnalyticalaccountController::class, "create"])->name("analyticalaccounts.create")->middleware('can:analyticalaccounts.create');
    Route::post("/analyticalaccounts", [AnalyticalaccountController::class, "store"])->name("analyticalaccounts.store")->middleware('can:analyticalaccounts.create');
    Route::get('/analyticalaccounts/{analyticalaccount_uuid}/edit', [AnalyticalaccountController::class, 'edit'])->name('analyticalaccounts.edit')->middleware('can:analyticalaccounts.edit');
    Route::put("/analyticalaccounts/{analyticalaccount_uuid}/disable", [AnalyticalaccountController::class, "disable"])->name("analyticalaccounts.disable");
    Route::put("/analyticalaccounts/{analyticalaccount_uuid}/enable", [AnalyticalaccountController::class, "enable"])->name("analyticalaccounts.enable");
    Route::put('/analyticalaccounts/{analyticalaccount_uuid}', [AnalyticalaccountController::class, 'update'])->name('analyticalaccounts.update')->middleware('can:analyticalaccounts.edit');
    Route::delete('/analyticalaccounts/{analyticalaccount_uuid}', [AnalyticalaccountController::class, 'destroy'])->name('analyticalaccounts.destroy')->middleware('can:analyticalaccounts.destroy');

    /*ACCOUNT*/
    Route::get("/accounts", [AccountController::class, "index"])->name("accounts.index")->middleware('can:accounts.index');
    Route::get("/accounts/chart", [AccountController::class, "chart"])->name("accounts.chart");

    /*ACTIVITY*/
    Route::get("/activities", [ActivityController::class, "index"])->name("activities.index")->middleware('can:activities.index');
    Route::get("/activities/create", [ActivityController::class, "create"])->name("activities.create")->middleware('can:activities.create');
    Route::post("/activities", [ActivityController::class, "store"])->name("activities.store")->middleware('can:activities.create');
    Route::get('/activities/{activity_uuid}/edit', [ActivityController::class, 'edit'])->name('activities.edit')->middleware('can:activities.edit');
    Route::put("/activities/{activity_uuid}/disable", [ActivityController::class, "disable"])->name("activities.disable");
    Route::put("/activities/{activity_uuid}/enable", [ActivityController::class, "enable"])->name("activities.enable");
    Route::put('/activities/{activity_uuid}', [ActivityController::class, 'update'])->name('activities.update')->middleware('can:activities.edit');
    Route::delete('/activities/{activity_uuid}', [ActivityController::class, 'destroy'])->name('activities.destroy')->middleware('can:activities.destroy');

    /*COMPANY*/
    Route::get("/companies", [CompanyController::class, "index"])->name("companies.index")->middleware('can:companies.index');
    Route::get("/companies/create", [CompanyController::class, "create"])->name("companies.create")->middleware('can:companies.create');
    Route::post("/companies", [CompanyController::class, "store"])->name("companies.store")->middleware('can:companies.create');
    Route::get('/companies/{company_uuid}/edit', [CompanyController::class, 'edit'])->name('companies.edit')->middleware('can:companies.edit');
    Route::put("/companies/{company_uuid}/disable", [CompanyController::class, "disable"])->name("companies.disable");
    Route::put("/companies/{company_uuid}/enable", [CompanyController::class, "enable"])->name("companies.enable");
    Route::put('/companies/{company_uuid}', [CompanyController::class, 'update'])->name('companies.update')->middleware('can:companies.edit');
    Route::delete('/companies/{company_uuid}', [CompanyController::class, 'destroy'])->name('companies.destroy')->middleware('can:companies.destroy');

    /*PROJECT*/
    Route::get("/projects", [ProjectController::class, "index"])->name("projects.index")->middleware('can:projects.index');
    Route::get("/projects/create", [ProjectController::class, "create"])->name("projects.create")->middleware('can:projects.create');
    Route::post("/projects", [ProjectController::class, "store"])->name("projects.store")->middleware('can:projects.create');
    Route::get('/projects/{project_uuid}/edit', [ProjectController::class, 'edit'])->name('projects.edit')->middleware('can:projects.edit');
    Route::put("/projects/{project_uuid}/disable", [ProjectController::class, "disable"])->name("projects.disable");
    Route::put("/projects/{project_uuid}/enable", [ProjectController::class, "enable"])->name("projects.enable");
    Route::put('/projects/{project_uuid}', [ProjectController::class, 'update'])->name('projects.update')->middleware('can:projects.edit');
    Route::delete('/projects/{project_uuid}', [ProjectController::class, 'destroy'])->name('projects.destroy')->middleware('can:projects.destroy');

    /*VOUCHER*/
    Route::get("/vouchers", [VoucherController::class, "index"])->name("vouchers.index")->middleware('can:vouchers.index');
    Route::get("/vouchers/create", [VoucherController::class, "create"])->name("vouchers.create")->middleware('can:vouchers.create');
    Route::post("/vouchers", [VoucherController::class, "store"])->name("vouchers.store")->middleware('can:vouchers.create');
    Route::get('/vouchers/{voucher_uuid}/edit', [VoucherController::class, 'edit'])->name('vouchers.edit')->middleware('can:vouchers.edit');
    Route::put("/vouchers/{voucher_uuid}/disable", [VoucherController::class, "disable"])->name("vouchers.disable");
    Route::put("/vouchers/{voucher_uuid}/enable", [VoucherController::class, "enable"])->name("vouchers.enable");
    Route::put('/vouchers/{voucher_uuid}', [VoucherController::class, 'update'])->name('vouchers.update')->middleware('can:vouchers.edit');
    Route::delete('/vouchers/{voucher_uuid}', [VoucherController::class, 'destroy'])->name('vouchers.destroy')->middleware('can:vouchers.destroy');

    /*CUSTOMER*/
    Route::get("/customers", [CustomerController::class, "index"])->name("customers.index")->middleware('can:customers.index');
    Route::get("/customers/create", [CustomerController::class, "create"])->name("customers.create")->middleware('can:customers.create');
    Route::post("/customers", [CustomerController::class, "store"])->name("customers.store")->middleware('can:customers.create');
    Route::get('/customers/{customer_uuid}/edit', [CustomerController::class, 'edit'])->name('customers.edit')->middleware('can:customers.edit');
    Route::put("/customers/{customer_uuid}/disable", [CustomerController::class, "disable"])->name("customers.disable");
    Route::put("/customers/{customer_uuid}/enable", [CustomerController::class, "enable"])->name("customers.enable");
    Route::put('/customers/{customer_uuid}', [CustomerController::class, 'update'])->name('customers.update')->middleware('can:customers.edit');
    Route::delete('/customers/{customer_uuid}', [CustomerController::class, 'destroy'])->name('customers.destroy')->middleware('can:customers.destroy');

    /*REVENUES*/
    Route::get("/revenues", [RevenueController::class, "index"])->name("revenues.index")->middleware('can:revenues.index');
    Route::middleware(['cashshift_session'])->group(function () {
        Route::get("/revenues/create", [RevenueController::class, "create"])->name("revenues.create")->middleware('can:revenues.create');
        Route::post("/revenues", [RevenueController::class, "store"])->name("revenues.store")->middleware('can:revenues.create');
        Route::get('/revenues/{revenue_uuid}/edit', [RevenueController::class, 'edit'])->name('revenues.edit')->middleware('can:revenues.edit');
        Route::put('/revenues/{revenue_uuid}', [RevenueController::class, 'update'])->name('revenues.update')->middleware('can:revenues.edit');
    });
    Route::get('/revenues/export', [RevenueController::class, 'export'])->name('revenues.export');
    Route::post('/revenues/{revenue_uuid}', [RevenueController::class, 'detail'])->name('revenues.detail');
    Route::delete('/revenues/{revenue_uuid}', [RevenueController::class, 'destroy'])->name('revenues.destroy')->middleware('can:revenues.destroy');

    //INVOICES
    Route::get("/invoices", [InvoiceController::class, "index"])->name("invoices.index")->middleware('can:invoices.index');
    Route::get('/invoices/{revenue_uuid}', [InvoiceController::class, 'store'])->name('invoices.store')->middleware('can:invoices.create');

    /*CASHFLOWDAILY */
    //Route::get("/cashflowdailies", [CashflowdailyController::class, "index"])->name("cashflowdailies.index")->middleware('can:cashflowdailies.index');
    // Route::get("/cashflowdailies/summary", [CashflowdailyController::class, "summary"])->name("cashflowdailies.summary");
    // Route::post('/cashflowdailies/{cashflowdaily_uuid}', [CashflowdailyController::class, 'detail'])->name('cashflowdailies.detail');
    //Route::get('/cashflowdailies/report/{cashflowdaily_uuid}', [CashflowdailyController::class, 'report'])->name('cashflowdailies.report');
    // Route::post('/cashflowdailies/data/', [CashflowdailyController::class, 'data'])->name('cashflowdailies.data');
    // Route::post('/cashflowdailies/close/{cashflowdaily_uuid}', [CashflowdailyController::class, 'close'])->name('cashflowdailies.close');
    // Route::post('/cashflowdailies/open/{cashflowdaily_uuid}', [CashflowdailyController::class, 'open'])->name('cashflowdailies.open');
    // Route::delete('/cashflowdailies/{cashflowdaily_uuid}', [CashflowdailyController::class, 'destroy'])->name('cashflowdailies.destroy')->middleware('can:cashshifts.destroy');

    /*CURRENCIES */
    /*Route::get("/currencies", [CurrencyController::class, "index"])->name("currencies.index");
    Route::get("/currencies/create", [CurrencyController::class, "create"])->name("currencies.create");
    Route::post("/currencies", [CurrencyController::class, "store"])->name("currencies.store");
    Route::get('/currencies/{currency_id}', [CurrencyController::class, 'show'])->name('currencies.show');
    Route::get('/currencies/{currency_id}/edit', [CurrencyController::class, 'edit'])->name('currencies.edit');
    Route::put('/currencies/{currency_id}', [CurrencyController::class, 'update'])->name('currencies.update');
    Route::delete('/currencies/{currency_id}', [CurrencyController::class, 'destroy'])->name('currencies.destroy');*/

});

Route::prefix('/api')->group(function () {
    Route::post('/service', [ApiServiceController::class, 'postService']);
});
