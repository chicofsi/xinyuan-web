<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiSales\Auth\AuthController;
use App\Http\Controllers\ApiSales\Product\ProductController;
use App\Http\Controllers\ApiSales\Customer\CustomerController;
use App\Http\Controllers\ApiSales\Transaction\TransactionController;
use App\Http\Controllers\ApiSales\Todo\TodoController;
use App\Http\Controllers\ApiSales\Warehouse\WarehouseController;
use App\Http\Controllers\ApiSales\Company\CompanyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('sales/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){

	Route::group(['prefix' => 'sales'], function() {
	    Route::post('detail', [AuthController::class, 'detail']);
	    Route::post('edit', [AuthController::class, 'editProfile']);
	    Route::post('photo', [AuthController::class, 'changePhoto']);
	    Route::post('todo', [TodoController::class, 'getTodo']);
	    Route::post('todo/check', [TodoController::class, 'checkTodo']);
		Route::post('logout', [AuthController::class, 'logout']);
	    Route::post('password', [AuthController::class, 'changePassword']);
	});

	Route::group(['prefix' => 'product'], function() {
	    Route::post('/', [ProductController::class, 'getProduct']);
	    Route::post('/factories', [ProductController::class, 'getFactories']);
	});

	Route::post('area', [CustomerController::class, 'getArea']);

	Route::group(['prefix' => 'customer'], function() {
	    Route::post('/', [CustomerController::class, 'getCustomer']);
	    Route::post('level', [CustomerController::class, 'getLevel']);
	    Route::post('register', [CustomerController::class, 'registerCustomer']);
	    Route::post('photo', [CustomerController::class, 'uploadCustomerPhoto']);
	    Route::post('idcheck', [CustomerController::class, 'CheckCustomerID']);
	    Route::post('transaction', [TransactionController::class, 'getCustomerTransaction']);
	});
	Route::group(['prefix' => 'transaction'], function() {
		Route::group(['prefix' => 'giro'], function() {
		    Route::post('/', [TransactionController::class, 'addTransactionGiro']);
		    Route::post('bank', [TransactionController::class, 'getBank']);
		    Route::post('history', [TransactionController::class, 'getAllGiro']);
		});
	    Route::post('/', [TransactionController::class, 'addTransaction']);
	    // Route::post('details', [TransactionController::class, 'addTransactionDetails']);
	    Route::post('get', [TransactionController::class, 'getTransactionDetails']);
	    Route::post('list', [TransactionController::class, 'getSalesTransaction']);
	    Route::post('payment', [TransactionController::class, 'addTransactionPayment']);
	    Route::post('accounts', [TransactionController::class, 'getPaymentAccount']);
	    Route::post('history', [TransactionController::class, 'getTransactionPayment']);
	});

	Route::group(['prefix' => 'warehouse'], function() {
	    Route::post('list', [WarehouseController::class, 'warehouseList']);
	});

	Route::group(['prefix' => 'company'], function() {
	    Route::post('list', [CompanyController::class, 'companyList']);
	});

});
