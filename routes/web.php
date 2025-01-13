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
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Users;

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/liveusers',Users::class);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard")->middleware('can:dashboard');
    Route::put('/dashboard/{cashshift_uuid}', [DashboardController::class, 'state'])->name('dashboards.state');
    Route::get('/dashboard/search', [DashboardController::class, 'search'])->name('dashboards.search');
    Route::get('/dashboard/sesions/', [DashboardController::class, 'all_sesions'])->name('dashboards.sesions');
    Route::get('/dashboard/sesion/{cashshift_uuid}', [DashboardController::class, 'one_sesion'])->name('dashboards.sesion');

    /*CONTROL*/
    Route::get("/control", [ControlController::class, "control"])->name("control");

    /* USERS */
    Route::get("/users", [UserController::class, "index"])->name("users.index")->middleware('can:users.index');
    Route::get("/users/create", [UserController::class, "create"])->name("users.create")->middleware('can:users.create');
    Route::post("/users", [UserController::class, "store"])->name("users.store")->middleware('can:users.create');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('can:users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update')->middleware('can:users.edit');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('can:users.destroy');
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

    /*PAYMENT WITHOUT PRICE */
    Route::get("/incomes", [IncomeController::class, "index"])->name("incomes.index")->middleware('can:incomes.index');
    Route::get("/incomes/create", [IncomeController::class, "create"])->name("incomes.create")->middleware('can:incomes.create');
    Route::post("/incomes", [IncomeController::class, "store"])->name("incomes.store")->middleware('can:incomes.create');
    Route::get('/incomes/export', [IncomeController::class, 'export'])->name('incomes.export');
    Route::get('/incomes/tax/{income_uuid}', [IncomeController::class, 'tax'])->name('incomes.tax');
    Route::get('/incomes/{income_uuid}/edit', [IncomeController::class, 'edit'])->name('incomes.edit')->middleware('can:incomes.edit');
    Route::post('/incomes/detail/{income_uuid}', [IncomeController::class, 'detail'])->name('incomes.detail');
    Route::put('/incomes/{income_uuid}', [IncomeController::class, 'update'])->name('incomes.update')->middleware('can:incomes.edit');
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
    Route::get("/expenses/create", [ExpenseController::class, "create"])->name("expenses.create")->middleware('can:expenses.create');
    Route::post("/expenses", [ExpenseController::class, "store"])->name("expenses.store")->middleware('can:expenses.create');
    Route::get('/expenses/export', [ExpenseController::class, 'export'])->name('expenses.export');
    Route::get('/expenses/{expense_uuid}/edit', [ExpenseController::class, 'edit'])->name('expenses.edit')->middleware('can:expenses.edit');
    Route::post('/expenses/{expense_uuid}', [ExpenseController::class, 'detail'])->name('expenses.detail');
    Route::put('/expenses/{expense_uuid}', [ExpenseController::class, 'update'])->name('expenses.update')->middleware('can:expenses.edit');
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
    Route::get("/sales/create", [SaleController::class, "create"])->name("sales.create")->middleware('can:sales.create');
    Route::post("/sales", [SaleController::class, "store"])->name("sales.store")->middleware('can:sales.create');
    Route::get('/sales/export', [SaleController::class, 'export'])->name('sales.export');
    Route::get('/sales/tax/{sale_uuid}', [SaleController::class, 'tax'])->name('sales.tax');
    Route::get('/sales/{sale_uuid}/edit', [SaleController::class, 'edit'])->name('sales.edit')->middleware('can:sales.edit');
    Route::post('/sales/detail/{sale_uuid}', [SaleController::class, 'detail'])->name('sales.detail');
    Route::put('/sales/{sale_uuid}', [SaleController::class, 'update'])->name('sales.update')->middleware('can:sales.edit');
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
    Route::get("/cashflowdailies", [CashflowdailyController::class, "index"])->name("cashflowdailies.index")->middleware('can:cashflowdailies.index');
    Route::get("/cashflowdailies/summary", [CashflowdailyController::class, "summary"])->name("cashflowdailies.summary");
    Route::post('/cashflowdailies/{cashflowdaily_uuid}', [CashflowdailyController::class, 'detail'])->name('cashflowdailies.detail');
    Route::get('/cashflowdailies/report/{cashflowdaily_uuid}', [CashflowdailyController::class, 'report'])->name('cashflowdailies.report');
   // Route::post('/cashflowdailies/data/', [CashflowdailyController::class, 'data'])->name('cashflowdailies.data');
   // Route::post('/cashflowdailies/close/{cashflowdaily_uuid}', [CashflowdailyController::class, 'close'])->name('cashflowdailies.close');
   // Route::post('/cashflowdailies/open/{cashflowdaily_uuid}', [CashflowdailyController::class, 'open'])->name('cashflowdailies.open');
   //
   // Route::delete('/cashflowdailies/{cashflowdaily_uuid}', [CashflowdailyController::class, 'destroy'])->name('cashflowdailies.destroy')->middleware('can:cashshifts.destroy');




    /*CURRENCIES */
    Route::get("/currencies", [CurrencyController::class, "index"])->name("currencies.index");
    Route::get("/currencies/create", [CurrencyController::class, "create"])->name("currencies.create");
    Route::post("/currencies", [CurrencyController::class, "store"])->name("currencies.store");
    Route::get('/currencies/{currency_id}', [CurrencyController::class, 'show'])->name('currencies.show');
    Route::get('/currencies/{currency_id}/edit', [CurrencyController::class, 'edit'])->name('currencies.edit');
    Route::put('/currencies/{currency_id}', [CurrencyController::class, 'update'])->name('currencies.update');
    Route::delete('/currencies/{currency_id}', [CurrencyController::class, 'destroy'])->name('currencies.destroy');

    /*
    Route::get("/servicesprices", [ServicepriceController::class, "index"])->name("servicesprices.index")->middleware('can:servicesprices.index');
    Route::get("/servicesprices/create", [ServicepriceController::class, "create"])->name("servicesprices.create")->middleware('can:servicesprices.create');
    Route::post("/servicesprices", [ServicepriceController::class, "store"])->name("servicesprices.store")->middleware('can:servicesprices.create');
    Route::get('/servicesprices/{service_uuid}', [ServicepriceController::class, 'show'])->name('servicesprices.show')->middleware('can:servicesprices.show');
    Route::get('/servicesprices/{service_uuid}/edit', [ServicepriceController::class, 'edit'])->name('servicesprices.edit')->middleware('can:servicesprices.edit');
    Route::put('/servicesprices/{service_uuid}', [ServicepriceController::class, 'update'])->name('servicesprices.update')->middleware('can:servicesprices.edit');
    Route::delete('/servicesprices/{service_uuid}', [ServicepriceController::class, 'destroy'])->name('servicesprices.destroy')->middleware('can:servicesprices.destroy');
    */
});

Route::prefix('/api')->group(function () {
    Route::post('/service', [ApiServiceController::class, 'postService']);
});
