<?php

use App\Http\Controllers\Api\ApiServiceController;
use App\Http\Controllers\CashregisterController;
use App\Http\Controllers\BankregisterController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CashshiftController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BusinesstypeController;
use App\Http\Controllers\AccountingController;
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
use App\Http\Controllers\LedgerController;
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

    Route::get('/two/factor', [TwoFactorController::class, 'get_code'])->name('connect_two_factor')->withoutMiddleware([ForcePasswordChange::class, CloseSession::class])->middleware('can:two_factor.get_code');
    Route::post('/two/factor/verify', [TwoFactorController::class, 'get_verify'])->name('verify_two_factor')->withoutMiddleware([ForcePasswordChange::class, CloseSession::class])->middleware('can:two_factor.get_verify');

    Route::get('/password/change', [ForcePasswordChangeController::class, 'edit'])->name('password.change')->withoutMiddleware([CloseSession::class])->middleware('can:password.edit');
    Route::post('/password/change', [ForcePasswordChangeController::class, 'update'])->name('password.change.update')->withoutMiddleware([CloseSession::class])->middleware('can:password.update');

    /*SETTING*/
    Route::put('/user/data', [SettingController::class, 'update_user'])->name('update_user')->middleware('can:settings.update_user');
    Route::put('/user/password', [SettingController::class, 'update_password'])->name('update_password')->middleware('can:settings.update_password');
    Route::post('/two/factor/status', [SettingController::class, 'two_factor'])->name('status_two_factor')->middleware('can:settings.two_factor');
    Route::post('/logout/session', [SettingController::class, 'logout_session'])->name('logout_session')->middleware('can:settings.logout_session');
    Route::post('/disable/account', [SettingController::class, 'disable_account'])->name('disable_account')->middleware('can:settings.disable_account');
    Route::get('/language/{lang}', [SettingController::class, 'change_language'])->name('change.language')->middleware('can:settings.change_language');

    /*DASHBOARD*/
    Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard")->middleware('can:dashboard');
    Route::put('/dashboard/{cashshift_uuid}/off', [DashboardController::class, 'off_session'])->name('dashboards.off_session');
    Route::put('/dashboard/{cashshift_uuid}/on', [DashboardController::class, 'on_session'])->name('dashboards.on_session');
    Route::get('/dashboard/search/sessions', [DashboardController::class, 'search_sessions'])->name('dashboards.search_sessions');
    Route::get('/dashboard/search/session', [DashboardController::class, 'search_session'])->name('dashboards.search_session');
    Route::get('/dashboard/session/{cashshift_uuid}', [DashboardController::class, 'one_session'])->name('dashboards.session');

    /* USERS */
    Route::get("/users", [UserController::class, "index"])->name("users.index")->middleware('can:users.index');
    Route::get("/users/create", [UserController::class, "create"])->name("users.create")->middleware('can:users.create');
    Route::post("/users", [UserController::class, "store"])->name("users.store")->middleware('can:users.create');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('can:users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update')->middleware('can:users.edit');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('can:users.destroy');
    Route::put('/users/{id}/enable', [UserController::class, 'enable'])->name('users.enable')->middleware('can:users.status');
    Route::put('/users/{id}/disable', [UserController::class, 'disable'])->name('users.disable')->middleware('can:users.status');
    Route::post('/users/{id}', [UserController::class, 'roles'])->name('users.roles')->middleware('can:users.roles');

    /*CATEGORIES */
    Route::get("/categories", [CategoryController::class, "index"])->name("categories.index")->middleware('can:categories.index');
    Route::get("/categories/create", [CategoryController::class, "create"])->name("categories.create")->middleware('can:categories.create');
    Route::post("/categories", [CategoryController::class, "store"])->name("categories.store")->middleware('can:categories.create');
    Route::get('/categories/{category_uuid}/edit', [CategoryController::class, 'edit'])->name('categories.edit')->middleware('can:categories.edit');
    Route::put("/categories/{category_uuid}/disable", [CategoryController::class, "disable"])->name("categories.disable")->middleware('can:categories.status');
    Route::put("/categories/{category_uuid}/enable", [CategoryController::class, "enable"])->name("categories.enable")->middleware('can:categories.status');
    Route::put('/categories/{category_uuid}', [CategoryController::class, 'update'])->name('categories.update')->middleware('can:categories.edit');
    Route::delete('/categories/{category_uuid}', [CategoryController::class, 'destroy'])->name('categories.destroy')->middleware('can:categories.destroy');

    /*SERVICES */
    Route::get("/services", [ServiceController::class, "index"])->name("services.index")->middleware('can:services.index');
    Route::get("/services/create", [ServiceController::class, "create"])->name("services.create")->middleware('can:services.create');
    Route::post("/services", [ServiceController::class, "store"])->name("services.store")->middleware('can:services.create');
    Route::get('/services/{service_uuid}/edit', [ServiceController::class, 'edit'])->name('services.edit')->middleware('can:services.edit');
    Route::put("/services/{service_uuid}/disable", [ServiceController::class, "disable"])->name("services.disable")->middleware('can:services.status');
    Route::put("/services/{service_uuid}/enable", [ServiceController::class, "enable"])->name("services.enable")->middleware('can:services.status');
    Route::put('/services/{service_uuid}', [ServiceController::class, 'update'])->name('services.update')->middleware('can:services.edit');
    Route::delete('/services/{service_uuid}', [ServiceController::class, 'destroy'])->name('services.destroy')->middleware('can:services.destroy');

    /*PLATFORM */
    Route::get("/platforms", [PlatformController::class, "index"])->name("platforms.index")->middleware('can:platforms.index');
    Route::get("/platforms/create", [PlatformController::class, "create"])->name("platforms.create")->middleware('can:platforms.create');
    Route::post("/platforms", [PlatformController::class, "store"])->name("platforms.store")->middleware('can:platforms.create');
    Route::get('/platforms/{platform_uuid}/edit', [PlatformController::class, 'edit'])->name('platforms.edit')->middleware('can:platforms.edit');
    Route::put("/platforms/{platform_uuid}/disable", [PlatformController::class, "disable"])->name("platforms.disable")->middleware('can:platforms.status');
    Route::put("/platforms/{platform_uuid}/enable", [PlatformController::class, "enable"])->name("platforms.enable")->middleware('can:platforms.status');
    Route::put('/platforms/{platform_uuid}', [PlatformController::class, 'update'])->name('platforms.update')->middleware('can:platforms.edit');
    Route::delete('/platforms/{platform_uuid}', [PlatformController::class, 'destroy'])->name('platforms.destroy')->middleware('can:platforms.destroy');

    /*INCOMES */
    Route::get("/incomes", [IncomeController::class, "index"])->name("incomes.index")->middleware('can:incomes.index');
    Route::get('/incomes/export', [IncomeController::class, 'export'])->name('incomes.export')->middleware('can:incomes.export');
    Route::middleware(['cashshift_session'])->group(function () {
        Route::get("/incomes/create", [IncomeController::class, "create"])->name("incomes.create")->middleware('can:incomes.create');
        Route::post("/incomes", [IncomeController::class, "store"])->name("incomes.store")->middleware('can:incomes.create');
        Route::get('/incomes/{income_uuid}/edit', [IncomeController::class, 'edit'])->name('incomes.edit')->middleware('can:incomes.edit');
        Route::put('/incomes/{income_uuid}', [IncomeController::class, 'update'])->name('incomes.update')->middleware('can:incomes.edit');
    });
    Route::post('/incomes/{income_uuid}/detail', [IncomeController::class, 'detail'])->name('incomes.detail')->middleware('can:incomes.detail');
    Route::delete('/incomes/{income_uuid}', [IncomeController::class, 'destroy'])->name('incomes.destroy')->middleware('can:incomes.destroy');

    //RECEIPTS
    Route::get("/receipts", [ReceiptController::class, "index"])->name("receipts.index")->middleware('can:receipts.index');
    Route::get('/receipts/{income_uuid}', [ReceiptController::class, 'store'])->name('receipts.store')->middleware('can:receipts.create');

    /*CASHREGISTERS */
    Route::get("/cashregisters", [CashregisterController::class, "index"])->name("cashregisters.index")->middleware('can:cashregisters.index');
    Route::get("/cashregisters/create", [CashregisterController::class, "create"])->name("cashregisters.create")->middleware('can:cashregisters.create');
    Route::post("/cashregisters", [CashregisterController::class, "store"])->name("cashregisters.store")->middleware('can:cashregisters.create');
    Route::get('/cashregisters/{cashregister_uuid}/edit', [CashregisterController::class, 'edit'])->name('cashregisters.edit')->middleware('can:cashregisters.edit');
    Route::post('/cashregisters/{cashregister_uuid}', [CashregisterController::class, 'detail'])->name('cashregisters.detail')->middleware('can:cashregisters.detail');
    Route::put("/cashregisters/{cashregister_uuid}/disable", [CashregisterController::class, "disable"])->name("cashregisters.disable")->middleware('can:cashregisters.status');
    Route::put("/cashregisters/{cashregister_uuid}/enable", [CashregisterController::class, "enable"])->name("cashregisters.enable")->middleware('can:cashregisters.status');
    Route::put('/cashregisters/{cashregister_uuid}', [CashregisterController::class, 'update'])->name('cashregisters.update')->middleware('can:cashregisters.edit');
    Route::delete('/cashregisters/{cashregister_uuid}', [CashregisterController::class, 'destroy'])->name('cashregisters.destroy')->middleware('can:cashregisters.destroy');

    /*CASHSHIFTS */
    Route::get("/cashshifts", [CashshiftController::class, "index"])->name("cashshifts.index")->middleware('can:cashshifts.index');
    Route::get("/cashshifts/create", [CashshiftController::class, "create"])->name("cashshifts.create")->middleware('can:cashshifts.create');
    Route::post("/cashshifts", [CashshiftController::class, "store"])->name("cashshifts.store")->middleware('can:cashshifts.create');
    Route::get('/cashshifts/{cashshift_uuid}/price', [CashshiftController::class, 'price'])->name('cashshifts.price')->middleware('can:cashshifts.price');
    Route::get('/cashshifts/{bankregister_uuid}/amount', [CashshiftController::class, 'amount'])->name('cashshifts.amount')->middleware('can:cashshifts.amount');
    Route::get('/cashshifts/{platform_uuid}/value', [CashshiftController::class, 'value'])->name('cashshifts.value')->middleware('can:cashshifts.value');
    Route::post('/cashshifts/{cashshift_uuid}', [CashshiftController::class, 'detail'])->name('cashshifts.detail')->middleware('can:cashshifts.detail');
    Route::get('/cashshifts/{cashshift_uuid}/edit', [CashshiftController::class, 'edit'])->name('cashshifts.edit')->middleware('can:cashshifts.edit');
    Route::put('/cashshifts/{cashshift_uuid}', [CashshiftController::class, 'update'])->name('cashshifts.update')->middleware('can:cashshifts.edit');
    Route::put('/cashshifts/{cashshift_uuid}/enable', [CashshiftController::class, 'enable'])->name('cashshifts.enable')->middleware('can:cashshifts.status');
    Route::put('/cashshifts/{cashshift_uuid}/disable', [CashshiftController::class, 'disable'])->name('cashshifts.disable')->middleware('can:cashshifts.status');
    Route::delete('/cashshifts/{cashshift_uuid}', [CashshiftController::class, 'destroy'])->name('cashshifts.destroy')->middleware('can:cashshifts.destroy');

    /*CASHCOUNT*/
    Route::get("/cashshifts/{cashshift_uuid}/cashcount", [CashcountController::class, "create"])->name("cashcounts.create")->middleware('can:cashcounts.create');
    Route::post("/cashshifts/{cashshift_uuid}/cashcount", [CashcountController::class, "store"])->name("cashcounts.store")->middleware('can:cashcounts.create');

    /*EXPENSES */
    Route::get("/expenses", [ExpenseController::class, "index"])->name("expenses.index")->middleware('can:expenses.index');
    Route::get('/expenses/export', [ExpenseController::class, 'export'])->name('expenses.export')->middleware('can:expenses.export');
    Route::middleware(['cashshift_session'])->group(function () {
        Route::get("/expenses/create", [ExpenseController::class, "create"])->name("expenses.create")->middleware('can:expenses.create');
        Route::post("/expenses", [ExpenseController::class, "store"])->name("expenses.store")->middleware('can:expenses.create');
        Route::get('/expenses/{expense_uuid}/edit', [ExpenseController::class, 'edit'])->name('expenses.edit')->middleware('can:expenses.edit');
        Route::put('/expenses/{expense_uuid}', [ExpenseController::class, 'update'])->name('expenses.update')->middleware('can:expenses.edit');
    });
    Route::post('/expenses/{expense_uuid}', [ExpenseController::class, 'detail'])->name('expenses.detail')->middleware('can:expenses.detail');
    Route::delete('/expenses/{expense_uuid}', [ExpenseController::class, 'destroy'])->name('expenses.destroy')->middleware('can:expenses.destroy');

    /*PRODUCTS */
    Route::get("/products", [ProductController::class, "index"])->name("products.index")->middleware('can:products.index');
    Route::get("/products/create", [ProductController::class, "create"])->name("products.create")->middleware('can:products.create');
    Route::post("/products", [ProductController::class, "store"])->name("products.store")->middleware('can:products.create');
    Route::get('/products/{product_uuid}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('can:products.edit');
    Route::put("/products/{product_uuid}/disable", [ProductController::class, "disable"])->name("products.disable")->middleware('can:products.status');
    Route::put("/products/{product_uuid}/enable", [ProductController::class, "enable"])->name("products.enable")->middleware('can:products.status');
    Route::put('/products/{product_uuid}', [ProductController::class, 'update'])->name('products.update')->middleware('can:products.edit');
    Route::delete('/products/{product_uuid}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('can:products.destroy');

    /*SALES */
    Route::get("/sales", [SaleController::class, "index"])->name("sales.index")->middleware('can:sales.index');
    Route::get('/sales/export', [SaleController::class, 'export'])->name('sales.export')->middleware('can:sales.export');
    Route::middleware(['cashshift_session'])->group(function () {
        Route::get("/sales/create", [SaleController::class, "create"])->name("sales.create")->middleware('can:sales.create');
        Route::post("/sales", [SaleController::class, "store"])->name("sales.store")->middleware('can:sales.create');
        Route::get('/sales/{sale_uuid}/edit', [SaleController::class, 'edit'])->name('sales.edit')->middleware('can:sales.edit');
        Route::put('/sales/{sale_uuid}', [SaleController::class, 'update'])->name('sales.update')->middleware('can:sales.edit');
    });
    Route::post('/sales/{sale_uuid}/detail', [SaleController::class, 'detail'])->name('sales.detail')->middleware('can:sales.detail');
    Route::delete('/sales/{sale_uuid}', [SaleController::class, 'destroy'])->name('sales.destroy')->middleware('can:sales.destroy');

    /*BANKREGISTERS */
    Route::get("/bankregisters", [BankregisterController::class, "index"])->name("bankregisters.index")->middleware('can:bankregisters.index');
    Route::get("/bankregisters/create", [BankregisterController::class, "create"])->name("bankregisters.create")->middleware('can:bankregisters.create');
    Route::post("/bankregisters", [BankregisterController::class, "store"])->name("bankregisters.store")->middleware('can:bankregisters.create');
    Route::get('/bankregisters/{bankregister_uuid}/edit', [BankregisterController::class, 'edit'])->name('bankregisters.edit')->middleware('can:bankregisters.edit');
    Route::put('/bankregisters/{bankregister_uuid}', [BankregisterController::class, 'update'])->name('bankregisters.update')->middleware('can:bankregisters.edit');
    Route::put("/bankregisters/{bankregister_uuid}/disable", [BankregisterController::class, "disable"])->name("bankregisters.disable")->middleware('can:bankregisters.status');
    Route::put("/bankregisters/{bankregister_uuid}/enable", [BankregisterController::class, "enable"])->name("bankregisters.enable")->middleware('can:bankregisters.status');
    Route::delete('/bankregisters/{bankregister_uuid}', [BankregisterController::class, 'destroy'])->name('bankregisters.destroy')->middleware('can:bankregisters.destroy');

    /*ACCOUNT CLASS*/
    Route::get("/accountclasses/create", [AccountclassController::class, "create"])->name("accountclasses.create")->middleware('can:accountclasses.create');
    Route::post("/accountclasses", [AccountclassController::class, "store"])->name("accountclasses.store")->middleware('can:accountclasses.create');
    Route::get('/accountclasses/{accountclass_uuid}/edit', [AccountclassController::class, 'edit'])->name('accountclasses.edit')->middleware('can:accountclasses.edit');
    Route::put('/accountclasses/{accountclass_uuid}', [AccountclassController::class, 'update'])->name('accountclasses.update')->middleware('can:accountclasses.edit');
    Route::put("/accountclasses/{accountclass_uuid}/disable", [AccountclassController::class, "disable"])->name("accountclasses.disable")->middleware('can:accountclasses.status');
    Route::put("/accountclasses/{accountclass_uuid}/enable", [AccountclassController::class, "enable"])->name("accountclasses.enable")->middleware('can:accountclasses.status');
    Route::delete('/accountclasses/{accountclass_uuid}', [AccountclassController::class, 'destroy'])->name('accountclasses.destroy')->middleware('can:accountclasses.destroy');

    /*ACCOUNT GROUP*/
    Route::get("/accountgroups/create", [AccountgroupController::class, "create"])->name("accountgroups.create")->middleware('can:accountgroups.create');
    Route::post("/accountgroups", [AccountgroupController::class, "store"])->name("accountgroups.store")->middleware('can:accountgroups.create');
    Route::get('/accountgroups/{accountgroup_uuid}/edit', [AccountgroupController::class, 'edit'])->name('accountgroups.edit')->middleware('can:accountgroups.edit');
    Route::put('/accountgroups/{accountgroup_uuid}', [AccountgroupController::class, 'update'])->name('accountgroups.update')->middleware('can:accountgroups.edit');
    Route::put("/accountgroups/{accountgroup_uuid}/disable", [AccountgroupController::class, "disable"])->name("accountgroups.disable")->middleware('can:accountgroups.status');
    Route::put("/accountgroups/{accountgroup_uuid}/enable", [AccountgroupController::class, "enable"])->name("accountgroups.enable")->middleware('can:accountgroups.status');
    Route::delete('/accountgroups/{accountgroup_uuid}', [AccountgroupController::class, 'destroy'])->name('accountgroups.destroy')->middleware('can:accountgroups.destroy');

    /*ACCOUNT SUBGROUP*/
    Route::get("/accountsubgroups/create", [AccountsubgroupController::class, "create"])->name("accountsubgroups.create")->middleware('can:accountsubgroups.create');
    Route::post("/accountsubgroups", [AccountsubgroupController::class, "store"])->name("accountsubgroups.store")->middleware('can:accountsubgroups.create');
    Route::get('/accountsubgroups/{accountsubgroup_uuid}/edit', [AccountsubgroupController::class, 'edit'])->name('accountsubgroups.edit')->middleware('can:accountsubgroups.edit');
    Route::put('/accountsubgroups/{accountsubgroup_uuid}', [AccountsubgroupController::class, 'update'])->name('accountsubgroups.update')->middleware('can:accountsubgroups.edit');
    Route::put("/accountsubgroups/{accountsubgroup_uuid}/disable", [AccountsubgroupController::class, "disable"])->name("accountsubgroups.disable")->middleware('can:accountsubgroups.status');
    Route::put("/accountsubgroups/{accountsubgroup_uuid}/enable", [AccountsubgroupController::class, "enable"])->name("accountsubgroups.enable")->middleware('can:accountsubgroups.status');
    Route::delete('/accountsubgroups/{accountsubgroup_uuid}', [AccountsubgroupController::class, 'destroy'])->name('accountsubgroups.destroy')->middleware('can:accountsubgroups.destroy');

    /*MAIN ACCOUNT*/
    Route::get("/mainaccounts/create", [MainaccountController::class, "create"])->name("mainaccounts.create")->middleware('can:mainaccounts.create');
    Route::post("/mainaccounts", [MainaccountController::class, "store"])->name("mainaccounts.store")->middleware('can:mainaccounts.create');
    Route::get('/mainaccounts/{mainaccount_uuid}/edit', [MainaccountController::class, 'edit'])->name('mainaccounts.edit')->middleware('can:mainaccounts.edit');
    Route::put('/mainaccounts/{mainaccount_uuid}', [MainaccountController::class, 'update'])->name('mainaccounts.update')->middleware('can:mainaccounts.edit');
    Route::put("/mainaccounts/{mainaccount_uuid}/disable", [MainaccountController::class, "disable"])->name("mainaccounts.disable")->middleware('can:mainaccounts.status');
    Route::put("/mainaccounts/{mainaccount_uuid}/enable", [MainaccountController::class, "enable"])->name("mainaccounts.enable")->middleware('can:mainaccounts.status');
    Route::delete('/mainaccounts/{mainaccount_uuid}', [MainaccountController::class, 'destroy'])->name('mainaccounts.destroy')->middleware('can:mainaccounts.destroy');
    Route::post('/mainaccounts/{mainaccount_uuid}', [MainaccountController::class, 'business'])->name('mainaccounts.business')->middleware('can:mainaccounts.business');

    /*ANALYTICAL ACCOUNT*/
    Route::get("/analyticalaccounts/create", [AnalyticalaccountController::class, "create"])->name("analyticalaccounts.create")->middleware('can:analyticalaccounts.create');
    Route::post("/analyticalaccounts", [AnalyticalaccountController::class, "store"])->name("analyticalaccounts.store")->middleware('can:analyticalaccounts.create');
    Route::get('/analyticalaccounts/{analyticalaccount_uuid}/edit', [AnalyticalaccountController::class, 'edit'])->name('analyticalaccounts.edit')->middleware('can:analyticalaccounts.edit');
    Route::put("/analyticalaccounts/{analyticalaccount_uuid}/disable", [AnalyticalaccountController::class, "disable"])->name("analyticalaccounts.disable")->middleware('can:analyticalaccounts.status');
    Route::put("/analyticalaccounts/{analyticalaccount_uuid}/enable", [AnalyticalaccountController::class, "enable"])->name("analyticalaccounts.enable")->middleware('can:analyticalaccounts.status');
    Route::put('/analyticalaccounts/{analyticalaccount_uuid}', [AnalyticalaccountController::class, 'update'])->name('analyticalaccounts.update')->middleware('can:analyticalaccounts.edit');
    Route::delete('/analyticalaccounts/{analyticalaccount_uuid}', [AnalyticalaccountController::class, 'destroy'])->name('analyticalaccounts.destroy')->middleware('can:analyticalaccounts.destroy');

    /*ACCOUNT*/
    Route::get("/accounts", [AccountController::class, "index"])->name("accounts.index")->middleware('can:accounts.index');
    Route::get("/accounts/chart", [AccountController::class, "chart"])->name("accounts.chart")->middleware('can:accounts.chart');

    /*ACTIVITY*/
    Route::get("/activities", [ActivityController::class, "index"])->name("activities.index")->middleware('can:activities.index');
    Route::get("/activities/create", [ActivityController::class, "create"])->name("activities.create")->middleware('can:activities.create');
    Route::post("/activities", [ActivityController::class, "store"])->name("activities.store")->middleware('can:activities.create');
    Route::get('/activities/{activity_uuid}/edit', [ActivityController::class, 'edit'])->name('activities.edit')->middleware('can:activities.edit');
    Route::put("/activities/{activity_uuid}/disable", [ActivityController::class, "disable"])->name("activities.disable")->middleware('can:activities.status');
    Route::put("/activities/{activity_uuid}/enable", [ActivityController::class, "enable"])->name("activities.enable")->middleware('can:activities.status');
    Route::put('/activities/{activity_uuid}', [ActivityController::class, 'update'])->name('activities.update')->middleware('can:activities.edit');
    Route::delete('/activities/{activity_uuid}', [ActivityController::class, 'destroy'])->name('activities.destroy')->middleware('can:activities.destroy');

    /*COMPANY*/
    Route::get("/companies", [CompanyController::class, "index"])->name("companies.index")->middleware('can:companies.index');
    Route::get("/companies/create", [CompanyController::class, "create"])->name("companies.create")->middleware('can:companies.create');
    Route::post("/companies", [CompanyController::class, "store"])->name("companies.store")->middleware('can:companies.create');
    Route::get('/companies/{company_uuid}/edit', [CompanyController::class, 'edit'])->name('companies.edit')->middleware('can:companies.edit');
    Route::put("/companies/{company_uuid}/disable", [CompanyController::class, "disable"])->name("companies.disable")->middleware('can:companies.status');
    Route::put("/companies/{company_uuid}/enable", [CompanyController::class, "enable"])->name("companies.enable")->middleware('can:companies.status');
    Route::put('/companies/{company_uuid}', [CompanyController::class, 'update'])->name('companies.update')->middleware('can:companies.edit');
    Route::delete('/companies/{company_uuid}', [CompanyController::class, 'destroy'])->name('companies.destroy')->middleware('can:companies.destroy');

    /*PROJECT*/
    Route::get("/projects", [ProjectController::class, "index"])->name("projects.index")->middleware('can:projects.index');
    Route::get("/projects/create", [ProjectController::class, "create"])->name("projects.create")->middleware('can:projects.create');
    Route::post("/projects", [ProjectController::class, "store"])->name("projects.store")->middleware('can:projects.create');
    Route::get('/projects/{project_uuid}/edit', [ProjectController::class, 'edit'])->name('projects.edit')->middleware('can:projects.edit');
    Route::put("/projects/{project_uuid}/disable", [ProjectController::class, "disable"])->name("projects.disable")->middleware('can:projects.status');
    Route::put("/projects/{project_uuid}/enable", [ProjectController::class, "enable"])->name("projects.enable")->middleware('can:projects.status');
    Route::put('/projects/{project_uuid}', [ProjectController::class, 'update'])->name('projects.update')->middleware('can:projects.edit');
    Route::delete('/projects/{project_uuid}', [ProjectController::class, 'destroy'])->name('projects.destroy')->middleware('can:projects.destroy');

    /*VOUCHER*/
    Route::get("/vouchers", [VoucherController::class, "index"])->name("vouchers.index")->middleware('can:vouchers.index');
    Route::get("/vouchers/create", [VoucherController::class, "create"])->name("vouchers.create")->middleware('can:vouchers.create');
    Route::post("/vouchers", [VoucherController::class, "store"])->name("vouchers.store")->middleware('can:vouchers.create');
    Route::get('/vouchers/{voucher_uuid}/edit', [VoucherController::class, 'edit'])->name('vouchers.edit')->middleware('can:vouchers.edit');
    Route::put('/vouchers/{voucher_uuid}', [VoucherController::class, 'update'])->name('vouchers.update')->middleware('can:vouchers.edit');
    Route::delete('/vouchers/{voucher_uuid}', [VoucherController::class, 'destroy'])->name('vouchers.destroy')->middleware('can:vouchers.destroy');

    /*CUSTOMER*/
    Route::get("/customers", [CustomerController::class, "index"])->name("customers.index")->middleware('can:customers.index');
    Route::get("/customers/create", [CustomerController::class, "create"])->name("customers.create")->middleware('can:customers.create');
    Route::post("/customers", [CustomerController::class, "store"])->name("customers.store")->middleware('can:customers.create');
    Route::get('/customers/{customer_uuid}/edit', [CustomerController::class, 'edit'])->name('customers.edit')->middleware('can:customers.edit');
    Route::put("/customers/{customer_uuid}/disable", [CustomerController::class, "disable"])->name("customers.disable")->middleware('can:customers.status');
    Route::put("/customers/{customer_uuid}/enable", [CustomerController::class, "enable"])->name("customers.enable")->middleware('can:customers.status');
    Route::put('/customers/{customer_uuid}', [CustomerController::class, 'update'])->name('customers.update')->middleware('can:customers.edit');
    Route::delete('/customers/{customer_uuid}', [CustomerController::class, 'destroy'])->name('customers.destroy')->middleware('can:customers.destroy');

    /*REVENUES*/
    Route::get("/revenues", [RevenueController::class, "index"])->name("revenues.index")->middleware('can:revenues.index');
    Route::get('/revenues/export', [RevenueController::class, 'export'])->name('revenues.export')->middleware('can:revenues.export');
    Route::middleware(['cashshift_session'])->group(function () {
        Route::get("/revenues/create", [RevenueController::class, "create"])->name("revenues.create")->middleware('can:revenues.create');
        Route::post("/revenues", [RevenueController::class, "store"])->name("revenues.store")->middleware('can:revenues.create');
        Route::get('/revenues/{revenue_uuid}/edit', [RevenueController::class, 'edit'])->name('revenues.edit')->middleware('can:revenues.edit');
        Route::put('/revenues/{revenue_uuid}', [RevenueController::class, 'update'])->name('revenues.update')->middleware('can:revenues.edit');
    });
    Route::post('/revenues/{revenue_uuid}', [RevenueController::class, 'detail'])->name('revenues.detail')->middleware('can:revenues.detail');
    Route::delete('/revenues/{revenue_uuid}', [RevenueController::class, 'destroy'])->name('revenues.destroy')->middleware('can:revenues.destroy');

    //INVOICES
    Route::get("/invoices", [InvoiceController::class, "index"])->name("invoices.index")->middleware('can:invoices.index');
    Route::get('/invoices/{revenue_uuid}', [InvoiceController::class, 'store'])->name('invoices.store')->middleware('can:invoices.create');

    /*BUSINESS TYPE*/
    Route::get("/businesstypes", [BusinesstypeController::class, "index"])->name("businesstypes.index")->middleware('can:businesstypes.index');
    Route::get("/businesstypes/create", [BusinesstypeController::class, "create"])->name("businesstypes.create")->middleware('can:businesstypes.create');
    Route::post("/businesstypes", [BusinesstypeController::class, "store"])->name("businesstypes.store")->middleware('can:businesstypes.create');
    Route::get('/businesstypes/{businesstype_uuid}/edit', [BusinesstypeController::class, 'edit'])->name('businesstypes.edit')->middleware('can:businesstypes.edit');
    Route::put("/businesstypes/{businesstype_uuid}/disable", [BusinesstypeController::class, "disable"])->name("businesstypes.disable")->middleware('can:businesstypes.status');
    Route::put("/businesstypes/{businesstype_uuid}/enable", [BusinesstypeController::class, "enable"])->name("businesstypes.enable")->middleware('can:businesstypes.status');
    Route::put('/businesstypes/{businesstype_uuid}', [BusinesstypeController::class, 'update'])->name('businesstypes.update')->middleware('can:businesstypes.edit');
    Route::delete('/businesstypes/{businesstype_uuid}', [BusinesstypeController::class, 'destroy'])->name('businesstypes.destroy')->middleware('can:businesstypes.destroy');

    /*REVISAR ROLES DESDE AQUI*/
    Route::get("/accounting/ledgers", [AccountingController::class, "ledger"])->name("accounting.ledger")->middleware('can:accounting.ledger');
    Route::get("/accounting/balances", [AccountingController::class, "balances"])->name("accounting.balances")->middleware('can:accounting.balances');
    Route::get('/accounting/export', [AccountingController::class, 'export'])->name('accounting.export');
    Route::get("/accounting/{project_uuid}", [AccountingController::class, "session"])->name("accounting.session")->middleware('can:accounting.session');


    //Route::get("/accounting/access", [AccountingController::class, "create"])->name("accounting.create")->middleware('can:accounting.create');
    //Route::post("/accounting", [AccountingController::class, "store"])->name("accounting.store")->middleware('can:accounting.create');
    //Route::get("/accounting/access/{company_uuid}", [AccountingController::class, "search"])->name("accounting.search")->middleware('can:accounting.search');



   // Route::get("/ledgers/{company_uuid}", [LedgerController::class, "data_ledger"])->name("ledgers.data");

    //Route::get("/ledgers/{company_uuid}/balance", [LedgerController::class, "data_trial_balance"])->name("ledgers.data");
    /*CONTROL*/
    //Route::get("/control", [ControlController::class, "control"])->name("control");
});

