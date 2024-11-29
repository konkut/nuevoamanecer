<?php

use App\Http\Controllers\Api\ApiServiceController;
use App\Http\Controllers\CashcountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\IncomefromtransferController;
use App\Http\Controllers\DenominationController;
use App\Http\Controllers\ServicepriceController;
use App\Http\Controllers\ServicewithoutpriceController;
use App\Http\Controllers\ServicewithpriceController;
use App\Http\Controllers\TransactionmethodController;
use App\Http\Controllers\PaymentwithoutpriceController;
use App\Http\Controllers\UserController;
use App\Models\Cashcount;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('welcome');
});

Route::middleware([
  'auth:sanctum',
  config('jetstream.auth_session'),
  'verified',
])->group(function () {
  Route::get('/dashboard', function () {
    return view('dashboard');
  })->middleware('can:dashboard')->name('dashboard');
  //Route::resource("/income",IncomeController::class)->names("income");
  //Route::resource("/service", ServiceController::class)->names("service");

  /* USERS */
  Route::get("/users", [UserController::class, "index"])->name("users.index");
  Route::get("/users/create", [UserController::class, "create"])->name("users.create");
  Route::post("/users", [UserController::class, "store"])->name("users.store");
  Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
  Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
  Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
  Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
  Route::post('/users/{id}', [UserController::class, 'assign_roles'])->name('users.assign_roles');

  /*SERVICES WITHOUT PRICE */
  Route::get("/serviceswithoutprices", [ServicewithoutpriceController::class, "index"])->name("serviceswithoutprices.index")->middleware('can:serviceswithoutprices.index');
  Route::get("/serviceswithoutprices/create", [ServicewithoutpriceController::class, "create"])->name("serviceswithoutprices.create")->middleware('can:serviceswithoutprices.create');
  Route::post("/serviceswithoutprices", [ServicewithoutpriceController::class, "store"])->name("serviceswithoutprices.store")->middleware('can:serviceswithoutprices.create');
  Route::get('/serviceswithoutprices/{servicewithoutprice_uuid}', [ServicewithoutpriceController::class, 'show'])->name('serviceswithoutprices.show')->middleware('can:serviceswithoutprices.show');
  Route::get('/serviceswithoutprices/{servicewithoutprice_uuid}/edit', [ServicewithoutpriceController::class, 'edit'])->name('serviceswithoutprices.edit')->middleware('can:serviceswithoutprices.edit');
  Route::put('/serviceswithoutprices/{servicewithoutprice_uuid}', [ServicewithoutpriceController::class, 'update'])->name('serviceswithoutprices.update')->middleware('can:serviceswithoutprices.edit');
  Route::delete('/serviceswithoutprices/{servicewithoutprice_uuid}', [ServicewithoutpriceController::class, 'destroy'])->name('serviceswithoutprices.destroy')->middleware('can:serviceswithoutprices.destroy');

  /*SERVICES WITH PRICE */
  Route::get("/serviceswithprices", [ServicewithpriceController::class, "index"])->name("serviceswithprices.index")->middleware('can:serviceswithprices.index');
  Route::get("/serviceswithprices/create", [ServicewithpriceController::class, "create"])->name("serviceswithprices.create")->middleware('can:serviceswithprices.create');
  Route::post("/serviceswithprices", [ServicewithpriceController::class, "store"])->name("serviceswithprices.store")->middleware('can:serviceswithprices.create');
  Route::get('/serviceswithprices/{servicewithprice_uuid}', [ServicewithpriceController::class, 'show'])->name('serviceswithprices.show')->middleware('can:serviceswithprices.show');
  Route::get('/serviceswithprices/{servicewithprice_uuid}/edit', [ServicewithpriceController::class, 'edit'])->name('serviceswithprices.edit')->middleware('can:serviceswithprices.edit');
  Route::put('/serviceswithprices/{servicewithprice_uuid}', [ServicewithpriceController::class, 'update'])->name('serviceswithprices.update')->middleware('can:serviceswithprices.edit');
  Route::delete('/serviceswithprices/{servicewithprice_uuid}', [ServicewithpriceController::class, 'destroy'])->name('serviceswithprices.destroy')->middleware('can:serviceswithprices.destroy');

  /*TRANSACTION METHOD */
  Route::get("/transactionmethods", [TransactionmethodController::class, "index"])->name("transactionmethods.index")->middleware('can:transactionmethods.index');
  Route::get("/transactionmethods/create", [TransactionmethodController::class, "create"])->name("transactionmethods.create")->middleware('can:transactionmethods.create');
  Route::post("/transactionmethods", [TransactionmethodController::class, "store"])->name("transactionmethods.store")->middleware('can:transactionmethods.create');
  Route::get('/transactionmethods/{transactionmethod_uuid}', [TransactionmethodController::class, 'show'])->name('transactionmethods.show')->middleware('can:transactionmethods.show');
  Route::get('/transactionmethods/{transactionmethod_uuid}/edit', [TransactionmethodController::class, 'edit'])->name('transactionmethods.edit')->middleware('can:transactionmethods.edit');
  Route::put('/transactionmethods/{transactionmethod_uuid}', [TransactionmethodController::class, 'update'])->name('transactionmethods.update')->middleware('can:transactionmethods.edit');
  Route::delete('/transactionmethods/{transactionmethod_uuid}', [TransactionmethodController::class, 'destroy'])->name('transactionmethods.destroy')->middleware('can:transactionmethods.destroy');

  /*PAYMENT WITHOUT PRICE */
  Route::get("/paymentwithoutprices", [PaymentwithoutpriceController::class, "index"])->name("paymentwithoutprices.index")->middleware('can:paymentwithoutprices.index');
  Route::get("/paymentwithoutprices/create", [PaymentwithoutpriceController::class, "create"])->name("paymentwithoutprices.create")->middleware('can:paymentwithoutprices.create');
  Route::post("/paymentwithoutprices", [PaymentwithoutpriceController::class, "store"])->name("paymentwithoutprices.store")->middleware('can:paymentwithoutprices.create');
  Route::get('/paymentwithoutprices/{paymentwithoutprice_uuid}', [PaymentwithoutpriceController::class, 'show'])->name('paymentwithoutprices.show')->middleware('can:paymentwithoutprices.show');
  Route::get('/paymentwithoutprices/{paymentwithoutprice_uuid}/edit', [PaymentwithoutpriceController::class, 'edit'])->name('paymentwithoutprices.edit')->middleware('can:paymentwithoutprices.edit');
  Route::put('/paymentwithoutprices/{paymentwithoutprice_uuid}', [PaymentwithoutpriceController::class, 'update'])->name('paymentwithoutprices.update')->middleware('can:paymentwithoutprices.edit');
  Route::delete('/paymentwithoutprices/{paymentwithoutprice_uuid}', [PaymentwithoutpriceController::class, 'destroy'])->name('paymentwithoutprices.destroy')->middleware('can:paymentwithoutprices.destroy');



  /*
  Route::get("/services", [ServiceController::class, "index"])->name("services.index")->middleware('can:services.index');
  Route::get("/services/create", [ServiceController::class, "create"])->name("services.create")->middleware('can:services.create');
  Route::post("/services", [ServiceController::class, "store"])->name("services.store")->middleware('can:services.create');
  Route::get('/services/{service_uuid}', [ServiceController::class, 'show'])->name('services.show')->middleware('can:services.show');
  Route::get('/services/{service_uuid}/edit', [ServiceController::class, 'edit'])->name('services.edit')->middleware('can:services.edit');
  Route::put('/services/{service_uuid}', [ServiceController::class, 'update'])->name('services.update')->middleware('can:services.edit');
  Route::delete('/services/{service_uuid}', [ServiceController::class, 'destroy'])->name('services.destroy')->middleware('can:services.destroy');*/
  //Route::get('/servicesnew', [ServiceController::class, 'getServices'])->name('servicesnew.get');

  /*CURRENCIES */
  Route::get("/currencies", [CurrencyController::class, "index"])->name("currencies.index");
  Route::get("/currencies/create", [CurrencyController::class, "create"])->name("currencies.create");
  Route::post("/currencies", [CurrencyController::class, "store"])->name("currencies.store");
  Route::get('/currencies/{currency_id}', [CurrencyController::class, 'show'])->name('currencies.show');
  Route::get('/currencies/{currency_id}/edit', [CurrencyController::class, 'edit'])->name('currencies.edit');
  Route::put('/currencies/{currency_id}', [CurrencyController::class, 'update'])->name('currencies.update');
  Route::delete('/currencies/{currency_id}', [CurrencyController::class, 'destroy'])->name('currencies.destroy');

  /*CATEGORIES */
  Route::get("/categories", [CategoryController::class, "index"])->name("categories.index")->middleware('can:categories.index');
  Route::get("/categories/create", [CategoryController::class, "create"])->name("categories.create")->middleware('can:categories.create');
  Route::post("/categories", [CategoryController::class, "store"])->name("categories.store")->middleware('can:categories.create');
  Route::get('/categories/{category_id}', [CategoryController::class, 'show'])->name('categories.show')->middleware('can:categories.show');
  Route::get('/categories/{category_id}/edit', [CategoryController::class, 'edit'])->name('categories.edit')->middleware('can:categories.edit');
  Route::put('/categories/{category_id}', [CategoryController::class, 'update'])->name('categories.update')->middleware('can:categories.edit');
  Route::delete('/categories/{category_id}', [CategoryController::class, 'destroy'])->name('categories.destroy')->middleware('can:categories.destroy');

  /*INCOME FROM TRANSFER */
  Route::get("/incomefromtransfers", [IncomefromtransferController::class, "index"])->name("incomefromtransfers.index");
  Route::get("/incomefromtransfers/create", [IncomefromtransferController::class, "create"])->name("incomefromtransfers.create");
  Route::post("/incomefromtransfers", [IncomefromtransferController::class, "store"])->name("incomefromtransfers.store");
  Route::get('/incomefromtransfers/{incomefromtransfers_uuid}', [IncomefromtransferController::class, 'show'])->name('incomefromtransfers.show');
  Route::get('/incomefromtransfers/{incomefromtransfers_uuid}/edit', [IncomefromtransferController::class, 'edit'])->name('incomefromtransfers.edit');
  Route::put('/incomefromtransfers/{incomefromtransfers_uuid}', [IncomefromtransferController::class, 'update'])->name('incomefromtransfers.update');
  Route::delete('/incomefromtransfers/{incomefromtransfers_uuid}', [IncomefromtransferController::class, 'destroy'])->name('incomefromtransfers.destroy');

  /*DENOMINATIONS */
  Route::get("/denominations", [DenominationController::class, "index"])->name("denominations.index");
  Route::get("/denominations/create", [DenominationController::class, "create"])->name("denominations.create");
  Route::post("/denominations", [DenominationController::class, "store"])->name("denominations.store");
  Route::get('/denominations/{denomination_uuid}', [DenominationController::class, 'show'])->name('denominations.show');
  Route::get('/denominations/{denomination_uuid}/edit', [DenominationController::class, 'edit'])->name('denominations.edit');
  Route::put('/denominations/{denomination_uuid}', [DenominationController::class, 'update'])->name('denominations.update');
  Route::delete('/denominations/{denomination_uuid}', [DenominationController::class, 'destroy'])->name('denominations.destroy');

  /*CASHCOUNTS */
  Route::get("/cashcounts", [CashcountController::class, "index"])->name("cashcounts.index");
  Route::get("/cashcounts/create", [CashcountController::class, "create"])->name("cashcounts.create");
  Route::post("/cashcounts", [CashcountController::class, "store"])->name("cashcounts.store");
  Route::get('/cashcounts/{cashcount_uuid}', [CashcountController::class, 'show'])->name('cashcounts.show');
  Route::get('/cashcounts/{cashcount_uuid}/edit', [CashcountController::class, 'edit'])->name('cashcounts.edit');
  Route::put('/cashcounts/{cashcount_uuid}', [CashcountController::class, 'update'])->name('cashcounts.update');
  Route::delete('/cashcounts/{cashcount_uuid}', [CashcountController::class, 'destroy'])->name('cashcounts.destroy');

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
