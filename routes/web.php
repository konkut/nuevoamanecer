<?php

use App\Http\Controllers\Api\ApiServiceController;
use App\Http\Controllers\CashcountController;
use App\Http\Controllers\CashregisterController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CashshiftController;
use App\Http\Controllers\CashflowdailyController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DenominationController;
use App\Http\Controllers\ServicewithoutpriceController;
use App\Http\Controllers\ServicewithpriceController;
use App\Http\Controllers\TransactionmethodController;
use App\Http\Controllers\PaymentwithoutpriceController;
use App\Http\Controllers\PaymentwithpriceController;
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
    Route::get("/serviceswithoutprices", [ServicewithoutpriceController::class, "index"])->name("serviceswithoutprices.index")->middleware('can:serviceswithoutprices.index');
    Route::get("/serviceswithoutprices/create", [ServicewithoutpriceController::class, "create"])->name("serviceswithoutprices.create")->middleware('can:serviceswithoutprices.create');
    Route::post("/serviceswithoutprices", [ServicewithoutpriceController::class, "store"])->name("serviceswithoutprices.store")->middleware('can:serviceswithoutprices.create');
    Route::get('/serviceswithoutprices/{servicewithoutprice_uuid}/edit', [ServicewithoutpriceController::class, 'edit'])->name('serviceswithoutprices.edit')->middleware('can:serviceswithoutprices.edit');
    Route::put('/serviceswithoutprices/{servicewithoutprice_uuid}', [ServicewithoutpriceController::class, 'update'])->name('serviceswithoutprices.update')->middleware('can:serviceswithoutprices.edit');
    Route::delete('/serviceswithoutprices/{servicewithoutprice_uuid}', [ServicewithoutpriceController::class, 'destroy'])->name('serviceswithoutprices.destroy')->middleware('can:serviceswithoutprices.destroy');

    /*SERVICES WITH PRICE */
    Route::get("/serviceswithprices", [ServicewithpriceController::class, "index"])->name("serviceswithprices.index")->middleware('can:serviceswithprices.index');
    Route::get("/serviceswithprices/create", [ServicewithpriceController::class, "create"])->name("serviceswithprices.create")->middleware('can:serviceswithprices.create');
    Route::post("/serviceswithprices", [ServicewithpriceController::class, "store"])->name("serviceswithprices.store")->middleware('can:serviceswithprices.create');
    Route::get('/serviceswithprices/{servicewithprice_uuid}/edit', [ServicewithpriceController::class, 'edit'])->name('serviceswithprices.edit')->middleware('can:serviceswithprices.edit');
    Route::put('/serviceswithprices/{servicewithprice_uuid}', [ServicewithpriceController::class, 'update'])->name('serviceswithprices.update')->middleware('can:serviceswithprices.edit');
    Route::delete('/serviceswithprices/{servicewithprice_uuid}', [ServicewithpriceController::class, 'destroy'])->name('serviceswithprices.destroy')->middleware('can:serviceswithprices.destroy');

    /*TRANSACTION METHOD */
    Route::get("/transactionmethods", [TransactionmethodController::class, "index"])->name("transactionmethods.index")->middleware('can:transactionmethods.index');
    Route::get("/transactionmethods/create", [TransactionmethodController::class, "create"])->name("transactionmethods.create")->middleware('can:transactionmethods.create');
    Route::post("/transactionmethods", [TransactionmethodController::class, "store"])->name("transactionmethods.store")->middleware('can:transactionmethods.create');
    Route::get('/transactionmethods/{transactionmethod_uuid}/edit', [TransactionmethodController::class, 'edit'])->name('transactionmethods.edit')->middleware('can:transactionmethods.edit');
    Route::put('/transactionmethods/{transactionmethod_uuid}', [TransactionmethodController::class, 'update'])->name('transactionmethods.update')->middleware('can:transactionmethods.edit');
    Route::delete('/transactionmethods/{transactionmethod_uuid}', [TransactionmethodController::class, 'destroy'])->name('transactionmethods.destroy')->middleware('can:transactionmethods.destroy');

    /*PAYMENT WITHOUT PRICE */
    Route::get("/paymentwithoutprices", [PaymentwithoutpriceController::class, "index"])->name("paymentwithoutprices.index")->middleware('can:paymentwithoutprices.index');
    Route::get("/paymentwithoutprices/create", [PaymentwithoutpriceController::class, "create"])->name("paymentwithoutprices.create")->middleware('can:paymentwithoutprices.create');
    Route::post("/paymentwithoutprices", [PaymentwithoutpriceController::class, "store"])->name("paymentwithoutprices.store")->middleware('can:paymentwithoutprices.create');
    Route::get('/paymentwithoutprices/export', [PaymentwithoutpriceController::class, 'export'])->name('paymentwithoutprices.export');
    Route::get('/paymentwithoutprices/tax/{paymentwithoutprice_uuid}', [PaymentwithoutpriceController::class, 'tax'])->name('paymentwithoutprices.tax');
    Route::get('/paymentwithoutprices/{paymentwithoutprice_uuid}/edit', [PaymentwithoutpriceController::class, 'edit'])->name('paymentwithoutprices.edit')->middleware('can:paymentwithoutprices.edit');
    Route::post('/paymentwithoutprices/detail/{paymentwithoutprice_uuid}', [PaymentwithoutpriceController::class, 'detail'])->name('paymentwithoutprices.detail');
    Route::put('/paymentwithoutprices/{paymentwithoutprice_uuid}', [PaymentwithoutpriceController::class, 'update'])->name('paymentwithoutprices.update')->middleware('can:paymentwithoutprices.edit');
    Route::delete('/paymentwithoutprices/{paymentwithoutprice_uuid}', [PaymentwithoutpriceController::class, 'destroy'])->name('paymentwithoutprices.destroy')->middleware('can:paymentwithoutprices.destroy');

    /*PAYMENT WITH PRICE */
    Route::get("/paymentwithprices", [PaymentwithpriceController::class, "index"])->name("paymentwithprices.index")->middleware('can:paymentwithprices.index');
    Route::get("/paymentwithprices/create", [PaymentwithpriceController::class, "create"])->name("paymentwithprices.create")->middleware('can:paymentwithprices.create');
    Route::post("/paymentwithprices", [PaymentwithpriceController::class, "store"])->name("paymentwithprices.store")->middleware('can:paymentwithprices.create');
    Route::get('/paymentwithprices/export', [PaymentwithpriceController::class, 'export'])->name('paymentwithprices.export');
    Route::get('/paymentwithprices/tax/{paymentwithprice_uuid}', [PaymentwithpriceController::class, 'tax'])->name('paymentwithprices.tax');
    Route::get('/paymentwithprices/{paymentwithprice_uuid}/edit', [PaymentwithpriceController::class, 'edit'])->name('paymentwithprices.edit')->middleware('can:paymentwithprices.edit');
    Route::post('/paymentwithprices/detail/{paymentwithprice_uuid}', [PaymentwithpriceController::class, 'detail'])->name('paymentwithprices.detail');
    Route::put('/paymentwithprices/{paymentwithprice_uuid}', [PaymentwithpriceController::class, 'update'])->name('paymentwithprices.update')->middleware('can:paymentwithprices.edit');
    Route::delete('/paymentwithprices/{paymentwithprice_uuid}', [PaymentwithpriceController::class, 'destroy'])->name('paymentwithprices.destroy')->middleware('can:paymentwithprices.destroy');

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
    Route::post('/cashregisters/{cashregister_uuid}', [CashregisterController::class, 'showdetail'])->name('cashregisters.showdetail');
    Route::put('/cashregisters/{cashregister_uuid}', [CashregisterController::class, 'update'])->name('cashregisters.update')->middleware('can:cashregisters.edit');
    Route::delete('/cashregisters/{cashregister_uuid}', [CashregisterController::class, 'destroy'])->name('cashregisters.destroy')->middleware('can:cashregisters.destroy');

    /*CASHSHIFTS */
    Route::get("/cashshifts", [CashshiftController::class, "index"])->name("cashshifts.index")->middleware('can:cashshifts.index');
    Route::get("/cashshifts/create", [CashshiftController::class, "create"])->name("cashshifts.create")->middleware('can:cashshifts.create');
    Route::post("/cashshifts", [CashshiftController::class, "store"])->name("cashshifts.store")->middleware('can:cashshifts.create');
    Route::get('/cashshifts/data/{cashshift_uuid}', [CashshiftController::class, 'data'])->name('cashshifts.data');
    Route::get("/cashshifts/create/{cashshift_uuid}", [CashshiftController::class, "create_physical"])->name("cashshifts.create_physical");
    Route::post("/cashshifts/physical/{cashshift_uuid}", [CashshiftController::class, "store_physical"])->name("cashshifts.store_physical");
    Route::get('/cashshifts/{cashshift_uuid}/edit', [CashshiftController::class, 'edit'])->name('cashshifts.edit')->middleware('can:cashshifts.edit');
    Route::get('/cashshifts/{cashshift_uuid}/edit/physical', [CashshiftController::class, 'edit_physical'])->name('cashshifts.edit_physical');
    Route::post('/cashshifts/{cashshift_uuid}', [CashshiftController::class, 'showdetail'])->name('cashshifts.showdetail');
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
