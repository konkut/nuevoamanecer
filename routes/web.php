<?php

use App\Http\Controllers\Api\ApiServiceController;
use App\Http\Controllers\CashcountController;
use App\Http\Controllers\CashregisterController;
use App\Http\Controllers\CashshiftController;
use App\Http\Controllers\CategoryController;
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

    /* USERS */
    Route::get("/users", [UserController::class, "index"])->name("users.index")->middleware('can:users.index');
    Route::get("/users/create", [UserController::class, "create"])->name("users.create")->middleware('can:users.create');
    Route::post("/users", [UserController::class, "store"])->name("users.store")->middleware('can:users.create');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('can:users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update')->middleware('can:users.edit');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('can:users.destroy');
    Route::post('/users/{id}', [UserController::class, 'assign_roles'])->name('users.assign_roles')->middleware('can:users.assign_roles');

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
    Route::get('/paymentwithoutpricesuser/', [PaymentwithoutpriceController::class, 'show'])->name('paymentwithoutpricesuser.showuser')->middleware('can:paymentwithoutpricesuser.showuser');
    Route::get('/paymentwithoutprices/search', [PaymentwithoutpriceController::class, 'search'])->name('paymentwithoutprices.search');
    Route::get('/paymentwithoutprices/export', [PaymentwithoutpriceController::class, 'export'])->name('paymentwithoutprices.export');
    Route::get('/paymentwithoutprices/tax/{paymentwithoutprice_uuid}', [PaymentwithoutpriceController::class, 'tax'])->name('paymentwithoutprices.tax');
    Route::get('/paymentwithoutprices/{paymentwithoutprice_uuid}/edit', [PaymentwithoutpriceController::class, 'edit'])->name('paymentwithoutprices.edit')->middleware('can:paymentwithoutprices.edit');
    Route::post('/paymentwithoutpricesdetail/{paymentwithoutprice_uuid}', [PaymentwithoutpriceController::class, 'showdetail'])->name('paymentwithoutpricesdetail.showdetail');
    Route::put('/paymentwithoutprices/{paymentwithoutprice_uuid}', [PaymentwithoutpriceController::class, 'update'])->name('paymentwithoutprices.update')->middleware('can:paymentwithoutprices.edit');
    Route::delete('/paymentwithoutprices/{paymentwithoutprice_uuid}', [PaymentwithoutpriceController::class, 'destroy'])->name('paymentwithoutprices.destroy')->middleware('can:paymentwithoutprices.destroy');

    /*PAYMENT WITH PRICE */
    Route::get("/paymentwithprices", [PaymentwithpriceController::class, "index"])->name("paymentwithprices.index")->middleware('can:paymentwithprices.index');
    Route::get("/paymentwithprices/create", [PaymentwithpriceController::class, "create"])->name("paymentwithprices.create")->middleware('can:paymentwithprices.create');
    Route::post("/paymentwithprices", [PaymentwithpriceController::class, "store"])->name("paymentwithprices.store")->middleware('can:paymentwithprices.create');
    Route::get('/paymentwithpricesuser/', [PaymentwithpriceController::class, 'show'])->name('paymentwithpricesuser.showuser')->middleware('can:paymentwithpricesuser.showuser');
    Route::get('/paymentwithprices/export', [PaymentwithpriceController::class, 'export'])->name('paymentwithprices.export');
    Route::get('/paymentwithprices/tax/{paymentwithprice_uuid}', [PaymentwithpriceController::class, 'tax'])->name('paymentwithprices.tax');
    Route::get('/paymentwithprices/{paymentwithprice_uuid}/edit', [PaymentwithpriceController::class, 'edit'])->name('paymentwithprices.edit')->middleware('can:paymentwithprices.edit');
    Route::post('/paymentwithpricesdetail/{paymentwithprice_uuid}', [PaymentwithpriceController::class, 'showdetail'])->name('paymentwithpricesdetail.showdetail');
    Route::put('/paymentwithprices/{paymentwithprice_uuid}', [PaymentwithpriceController::class, 'update'])->name('paymentwithprices.update')->middleware('can:paymentwithprices.edit');
    Route::delete('/paymentwithprices/{paymentwithprice_uuid}', [PaymentwithpriceController::class, 'destroy'])->name('paymentwithprices.destroy')->middleware('can:paymentwithprices.destroy');

    /*DENOMINATIONS */
    Route::get("/denominations", [DenominationController::class, "index"])->name("denominations.index")->middleware('can:denominations.index');
    Route::get("/denominations/create", [DenominationController::class, "create"])->name("denominations.create")->middleware('can:denominations.create');
    Route::post("/denominations", [DenominationController::class, "store"])->name("denominations.store")->middleware('can:denominations.create');
    Route::get('/denominations/{denomination_uuid}/edit', [DenominationController::class, 'edit'])->name('denominations.edit')->middleware('can:denominations.edit');
    Route::put('/denominations/{denomination_uuid}', [DenominationController::class, 'update'])->name('denominations.update')->middleware('can:denominations.edit');
    Route::delete('/denominations/{denomination_uuid}', [DenominationController::class, 'destroy'])->name('denominations.destroy')->middleware('can:denominations.destroy');

    /*CASHCOUNTS */
    Route::get("/cashcounts", [CashcountController::class, "index"])->name("cashcounts.index")->middleware('can:cashcounts.index');
    Route::get("/cashcounts/create", [CashcountController::class, "create"])->name("cashcounts.create")->middleware('can:cashcounts.create');
    Route::post("/cashcounts", [CashcountController::class, "store"])->name("cashcounts.store")->middleware('can:cashcounts.create');
    Route::get('/cashcounts/{cashcount_uuid}/edit', [CashcountController::class, 'edit'])->name('cashcounts.edit')->middleware('can:cashcounts.edit');
    Route::post('/cashcounts/load/{cashcount_uuid}', [CashcountController::class, 'load'])->name('cashcounts.load');
    Route::post('/cashcounts/{cashcount_uuid}', [CashcountController::class, 'showdetail'])->name('cashcounts.showdetail');
    Route::post("/cashcountstatus/{cashcount_uuid}", [CashcountController::class, "changestatus"])->name('cashcounts.changestatus');
    Route::put('/cashcounts/{cashcount_uuid}', [CashcountController::class, 'update'])->name('cashcounts.update')->middleware('can:cashcounts.edit');
    Route::delete('/cashcounts/{cashcount_uuid}', [CashcountController::class, 'destroy'])->name('cashcounts.destroy')->middleware('can:cashcounts.destroy');

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
    Route::post('/cashshifts/data/', [CashshiftController::class, 'data'])->name('cashshifts.data');
    Route::get('/cashshifts/{cashshift_uuid}/edit', [CashshiftController::class, 'edit'])->name('cashshifts.edit')->middleware('can:cashshifts.edit');
    Route::post('/cashshifts/{cashshift_uuid}', [CashshiftController::class, 'showdetail'])->name('cashshifts.showdetail');
    Route::put('/cashshifts/{cashshift_uuid}', [CashshiftController::class, 'update'])->name('cashshifts.update')->middleware('can:cashshifts.edit');
    Route::delete('/cashshifts/{cashshift_uuid}', [CashshiftController::class, 'destroy'])->name('cashshifts.destroy')->middleware('can:cashshifts.destroy');


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
