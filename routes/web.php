<?php

use App\Http\Controllers\Api\ApiServiceController;
use App\Http\Controllers\CashcountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\IncomefromtransferController;
use App\Http\Controllers\DenominationController;
use App\Http\Controllers\ServicepriceController;
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

  /*SERVICES */
  Route::get("/services", [ServiceController::class, "index"])->name("services.index")->middleware('can:services.index');
  Route::get("/services/create", [ServiceController::class, "create"])->name("services.create")->middleware('can:services.create');
  Route::post("/services", [ServiceController::class, "store"])->name("services.store")->middleware('can:services.create');
  Route::get('/services/{service_uuid}', [ServiceController::class, 'show'])->name('services.show')->middleware('can:services.show');
  Route::get('/services/{service_uuid}/edit', [ServiceController::class, 'edit'])->name('services.edit')->middleware('can:services.edit');
  Route::put('/services/{service_uuid}', [ServiceController::class, 'update'])->name('services.update')->middleware('can:services.edit');
  Route::delete('/services/{service_uuid}', [ServiceController::class, 'destroy'])->name('services.destroy')->middleware('can:services.destroy');

  Route::get('/servicesnew', [ServiceController::class, 'getServices'])->name('servicesnew.get');

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

  Route::get("/servicesprices", [ServicepriceController::class, "index"])->name("servicesprices.index")->middleware('can:servicesprices.index');
  Route::get("/servicesprices/create", [ServicepriceController::class, "create"])->name("servicesprices.create")->middleware('can:servicesprices.create');
  Route::post("/servicesprices", [ServicepriceController::class, "store"])->name("servicesprices.store")->middleware('can:servicesprices.create');
  Route::get('/servicesprices/{service_uuid}', [ServicepriceController::class, 'show'])->name('servicesprices.show')->middleware('can:servicesprices.show');
  Route::get('/servicesprices/{service_uuid}/edit', [ServicepriceController::class, 'edit'])->name('servicesprices.edit')->middleware('can:servicesprices.edit');
  Route::put('/servicesprices/{service_uuid}', [ServicepriceController::class, 'update'])->name('servicesprices.update')->middleware('can:servicesprices.edit');
  Route::delete('/servicesprices/{service_uuid}', [ServicepriceController::class, 'destroy'])->name('servicesprices.destroy')->middleware('can:servicesprices.destroy');
});

Route::prefix('/api')->group(function () {
  Route::post('/service', [ApiServiceController::class, 'postService']);
});