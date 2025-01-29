<?php

use App\Http\Controllers\Api\ApiServiceController;
use App\Http\Controllers\CashregisterController;
use App\Http\Controllers\BankregisterController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CashshiftController;
use App\Http\Controllers\CashflowdailyController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ControlController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DenominationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\MethodController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TwoFactorController;
use \App\Http\Middleware\ForcePasswordChange;
use App\Http\Controllers\ForcePasswordChangeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\TwoFactor;
use App\Livewire\Users;

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/liveusers',Users::class);
//Route::get('/login', [OneFactorController::class, 'create'])->middleware(['guest:'.config('fortify.guard')])->name('login');
Route::get('/forgot/password', [ForgotPasswordController::class, 'create'])
    ->middleware(['guest:'.config('fortify.guard')])->name('password.request');
Route::post('/forgot/password/update', [ForgotPasswordController::class, 'store'])
    ->middleware(['guest:'.config('fortify.guard')])->name('password.email');

Route::get('/reset/password/{id}', [ResetPasswordEmailController::class, 'edit'])
    ->middleware(['guest:'.config('fortify.guard')])->name('password.link');
Route::put('/reset/password/update', [ResetPasswordEmailController::class, 'update'])
    ->middleware(['guest:'.config('fortify.guard')])->name('password.update');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'check_user_status',
    'two_factor',
    'force_password_change',
])->group(function () {
    Route::get('/two/factor', [TwoFactorController::class, 'get_code'])->name('connect_two_factor')->withoutMiddleware([ForcePasswordChange::class]);
    Route::post('/two/factor/verify', [TwoFactorController::class, 'get_verify'])->name('verify_two_factor')->withoutMiddleware([ForcePasswordChange::class]);

    Route::get('/password/change', [ForcePasswordChangeController::class, 'edit'])->name('password.change');
    Route::post('/password/change', [ForcePasswordChangeController::class, 'update'])->name('password.change.update');

    /*SETTING*/
    Route::put('/user/data', [SettingController::class, 'update_user'])->name('update_user');
    Route::put('/user/password', [SettingController::class, 'update_password'])->name('update_password');
    Route::post('/two/factor/status', [SettingController::class, 'two_factor'])->name('status_two_factor');
    Route::post('/logout/session', [SettingController::class, 'logout_session'])->name('logout_session');
    Route::post('/disable/account', [SettingController::class, 'disable_account'])->name('disable_account');

    /*DASHBOARD*/
    Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard")->middleware('can:dashboard');
    Route::put('/dashboard/{cashshift_uuid}', [DashboardController::class, 'state'])->name('dashboards.state');
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
    Route::put('/users/enable/{id}', [UserController::class, 'enable'])->name('users.enable');
    Route::put('/users/disable/{id}', [UserController::class, 'disable'])->name('users.disable');
    Route::post('/users/{id}', [UserController::class, 'roles'])->name('users.roles')->middleware('can:users.roles');

    /*CATEGORIES */
    Route::get("/categories", [CategoryController::class, "index"])->name("categories.index")->middleware('can:categories.index');
    Route::get("/categories/create", [CategoryController::class, "create"])->name("categories.create")->middleware('can:categories.create');
    Route::post("/categories", [CategoryController::class, "store"])->name("categories.store")->middleware('can:categories.create');
    Route::get('/categories/{category_id}/edit', [CategoryController::class, 'edit'])->name('categories.edit')->middleware('can:categories.edit');
    Route::put('/categories/{category_id}', [CategoryController::class, 'update'])->name('categories.update')->middleware('can:categories.edit');
    Route::delete('/categories/{category_id}', [CategoryController::class, 'destroy'])->name('categories.destroy')->middleware('can:categories.destroy');

    /*SERVICES WITHOUT PRICE */
    Route::get("/services", [ServiceController::class, "index"])->name("services.index")->middleware('can:services.index');
    Route::get("/services/create", [ServiceController::class, "create"])->name("services.create")->middleware('can:services.create');
    Route::post("/services", [ServiceController::class, "store"])->name("services.store")->middleware('can:services.create');
    Route::get('/services/{service_uuid}/edit', [ServiceController::class, 'edit'])->name('services.edit')->middleware('can:services.edit');
    Route::put('/services/{service_uuid}', [ServiceController::class, 'update'])->name('services.update')->middleware('can:services.edit');
    Route::delete('/services/{service_uuid}', [ServiceController::class, 'destroy'])->name('services.destroy')->middleware('can:services.destroy');

    /*TRANSACTION METHOD */
    Route::get("/methods", [MethodController::class, "index"])->name("methods.index")->middleware('can:methods.index');
    Route::get("/methods/create", [MethodController::class, "create"])->name("methods.create")->middleware('can:methods.create');
    Route::post("/methods", [MethodController::class, "store"])->name("methods.store")->middleware('can:methods.create');
    Route::get('/methods/{method_uuid}/edit', [MethodController::class, 'edit'])->name('methods.edit')->middleware('can:methods.edit');
    Route::put('/methods/{method_uuid}', [MethodController::class, 'update'])->name('methods.update')->middleware('can:methods.edit');
    Route::delete('/methods/{method_uuid}', [MethodController::class, 'destroy'])->name('methods.destroy')->middleware('can:methods.destroy');

    /*INCOMES */
    Route::get("/incomes", [IncomeController::class, "index"])->name("incomes.index")->middleware('can:incomes.index');
    Route::get('/incomes/export', [IncomeController::class, 'export'])->name('incomes.export');
    Route::middleware(['cashshift_session'])->group(function () {
        Route::get("/incomes/create", [IncomeController::class, "create"])->name("incomes.create")->middleware('can:incomes.create');
        Route::post("/incomes", [IncomeController::class, "store"])->name("incomes.store")->middleware('can:incomes.create');
        Route::get('/incomes/{income_uuid}/edit', [IncomeController::class, 'edit'])->name('incomes.edit')->middleware('can:incomes.edit');
        Route::put('/incomes/{income_uuid}', [IncomeController::class, 'update'])->name('incomes.update')->middleware('can:incomes.edit');
    });
    Route::get('/incomes/tax/{income_uuid}', [IncomeController::class, 'tax'])->name('incomes.tax');
    Route::post('/incomes/detail/{income_uuid}', [IncomeController::class, 'detail'])->name('incomes.detail');
    Route::delete('/incomes/{income_uuid}', [IncomeController::class, 'destroy'])->name('incomes.destroy')->middleware('can:incomes.destroy');

    /*DENOMINATIONS */
    Route::get("/denominations", [DenominationController::class, "index"])->name("denominations.index")->middleware('can:denominations.index');
    Route::get("/denominations/create", [DenominationController::class, "create"])->name("denominations.create")->middleware('can:denominations.create');
    Route::post("/denominations", [DenominationController::class, "store"])->name("denominations.store")->middleware('can:denominations.create');
    Route::get('/denominations/{denomination_uuid}/edit', [DenominationController::class, 'edit'])->name('denominations.edit')->middleware('can:denominations.edit');
    Route::put('/denominations/{denomination_uuid}', [DenominationController::class, 'update'])->name('denominations.update')->middleware('can:denominations.edit');
    Route::delete('/denominations/{denomination_uuid}', [DenominationController::class, 'destroy'])->name('denominations.destroy')->middleware('can:denominations.destroy');

    /*CASHREGISTERS */
    Route::get("/cashregisters", [CashregisterController::class, "index"])->name("cashregisters.index")->middleware('can:cashregisters.index');
    Route::get("/cashregisters/create", [CashregisterController::class, "create"])->name("cashregisters.create")->middleware('can:cashregisters.create');
    Route::post("/cashregisters", [CashregisterController::class, "store"])->name("cashregisters.store")->middleware('can:cashregisters.create');
    Route::get('/cashregisters/{cashregister_uuid}/edit', [CashregisterController::class, 'edit'])->name('cashregisters.edit')->middleware('can:cashregisters.edit');
    Route::post('/cashregisters/{cashregister_uuid}', [CashregisterController::class, 'detail'])->name('cashregisters.detail');
    Route::put('/cashregisters/{cashregister_uuid}', [CashregisterController::class, 'update'])->name('cashregisters.update')->middleware('can:cashregisters.edit');
    Route::delete('/cashregisters/{cashregister_uuid}', [CashregisterController::class, 'destroy'])->name('cashregisters.destroy')->middleware('can:cashregisters.destroy');

    /*CASHSHIFTS */
    Route::get("/cashshifts", [CashshiftController::class, "index"])->name("cashshifts.index")->middleware('can:cashshifts.index');
    Route::get("/cashshifts/create", [CashshiftController::class, "create"])->name("cashshifts.create")->middleware('can:cashshifts.create');
    Route::post("/cashshifts", [CashshiftController::class, "store"])->name("cashshifts.store")->middleware('can:cashshifts.create');
    Route::get('/cashshifts/data/{cashshift_uuid}', [CashshiftController::class, 'data'])->name('cashshifts.data');
    Route::get('/cashshifts/balance/{cashshift_uuid}', [CashshiftController::class, 'balance'])->name('cashshifts.balance');
    Route::get("/cashshifts/create/{cashshift_uuid}", [CashshiftController::class, "create_physical"])->name("cashshifts.create_physical");
    Route::post("/cashshifts/physical/{cashshift_uuid}", [CashshiftController::class, "store_physical"])->name("cashshifts.store_physical");
    Route::get('/cashshifts/{cashshift_uuid}/edit', [CashshiftController::class, 'edit'])->name('cashshifts.edit')->middleware('can:cashshifts.edit');
    Route::get('/cashshifts/{cashshift_uuid}/edit/physical', [CashshiftController::class, 'edit_physical'])->name('cashshifts.edit_physical');
    Route::post('/cashshifts/{cashshift_uuid}', [CashshiftController::class, 'detail'])->name('cashshifts.detail');
    Route::put('/cashshifts/{cashshift_uuid}', [CashshiftController::class, 'update'])->name('cashshifts.update')->middleware('can:cashshifts.edit');
    Route::put('/cashshifts/{cashshift_uuid}/physical', [CashshiftController::class, 'update_physical'])->name('cashshifts.update_physical');
    Route::put('/cashshifts/enabled/{cashshift_uuid}', [CashshiftController::class, 'enabled'])->name('cashshifts.enabled');
    Route::put('/cashshifts/disabled/{cashshift_uuid}', [CashshiftController::class, 'disabled'])->name('cashshifts.disabled');
    Route::delete('/cashshifts/{cashshift_uuid}', [CashshiftController::class, 'destroy'])->name('cashshifts.destroy')->middleware('can:cashshifts.destroy');

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
    Route::post('/sales/detail/{sale_uuid}', [SaleController::class, 'detail'])->name('sales.detail');
    Route::delete('/sales/{sale_uuid}', [SaleController::class, 'destroy'])->name('sales.destroy')->middleware('can:sales.destroy');

    /*BANKREGISTERS */
    Route::get("/bankregisters", [BankregisterController::class, "index"])->name("bankregisters.index")->middleware('can:bankregisters.index');
    Route::get("/bankregisters/create", [BankregisterController::class, "create"])->name("bankregisters.create")->middleware('can:bankregisters.create');
    Route::post("/bankregisters", [BankregisterController::class, "store"])->name("bankregisters.store")->middleware('can:bankregisters.create');
    Route::get('/bankregisters/{bankregister_uuid}/edit', [BankregisterController::class, 'edit'])->name('bankregisters.edit')->middleware('can:bankregisters.edit');
    Route::post('/bankregisters/{bankregister_uuid}', [BankregisterController::class, 'showdetail'])->name('bankregisters.showdetail');
    Route::put('/bankregisters/{bankregister_uuid}', [BankregisterController::class, 'update'])->name('bankregisters.update')->middleware('can:bankregisters.edit');
    Route::delete('/bankregisters/{bankregister_uuid}', [BankregisterController::class, 'destroy'])->name('bankregisters.destroy')->middleware('can:bankregisters.destroy');

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
