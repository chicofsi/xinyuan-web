<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\Auth\LoginController;

use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\Sales\ManageSales;
use App\Http\Controllers\Admin\Sales\ManageTarget;
use App\Http\Controllers\Admin\Sales\ManageToDo;
use App\Http\Controllers\Admin\Area\ManageArea;
use App\Http\Controllers\Admin\Company\ManageCompany;
use App\Http\Controllers\Admin\Product\ManageProduct;
use App\Http\Controllers\Admin\Product\ManageFactories;
use App\Http\Controllers\Admin\Product\ManageLogo;
use App\Http\Controllers\Admin\Product\ManageType;
use App\Http\Controllers\Admin\Product\ManageSize;
use App\Http\Controllers\Admin\Product\ManageColour;
use App\Http\Controllers\Admin\Product\ManageWeight;
use App\Http\Controllers\Admin\Product\ManageGrossWeight;
use App\Http\Controllers\Admin\Product\ManageProductValue;
use App\Http\Controllers\Admin\Customer\ManageCustomer;
use App\Http\Controllers\Admin\Customer\ManageLevel;
use App\Http\Controllers\Admin\Transaction\ManageTransaction;
use App\Http\Controllers\Admin\Transaction\ManageTransactionReturn;
use App\Http\Controllers\Admin\Purchase\ManagePurchase;
use App\Http\Controllers\Admin\PurchasePayment\ManagePurchasePayment;
use App\Http\Controllers\Admin\Payment\ManagePayment;
use App\Http\Controllers\Admin\Payment\ManagePaymentHistory;
use App\Http\Controllers\Admin\Payment\ManagePaymentAccount;
use App\Http\Controllers\Admin\Bank\ManageBank;
use App\Http\Controllers\Admin\Giro\ManageGiro;
use App\Http\Controllers\Admin\Warehouse\ManageWarehouse;
use App\Http\Controllers\Admin\Finance\ManageFinance;
use App\Http\Controllers\Admin\Finance\ManageFinanceAsset;
use App\Http\Controllers\Admin\Finance\ManageFinanceSales;
use App\Http\Controllers\Admin\Finance\ManageFinancePurchases;
use App\Http\Controllers\Admin\Finance\ManageFinanceExpenses;
use App\Http\Controllers\Admin\Finance\ManageFinanceProduct;
use App\Http\Controllers\Admin\Finance\ManageFinanceContact;
use App\Http\Controllers\Admin\Finance\ManageFinanceReports;
use App\Http\Controllers\Admin\Currency\ManageCurrencyProfitLoss;

use App\Http\Controllers\Admin\Auth\ManageAdminToDo;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
   	return redirect()->intended('/login');
});


Route::get('/login', [LoginController::class, 'getLogin'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'postLogin']);
Route::get('/policy', function ()
{
	return view('policyy');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'dashboard','middleware' =>['auth:web,sales']], function() {

	Route::group(['prefix' => 'admin/todo'], function() {
	    Route::get('/list'  , [ManageAdminToDo::class, 'index']);
	    Route::post('/toggle'  , [ManageAdminToDo::class, 'toggle']);
	    Route::post('/store'  , [ManageAdminToDo::class, 'store']);
	    Route::post('/delete'  , [ManageAdminToDo::class, 'destroy']);
    });
    Route::get('/', [Dashboard::class, 'index'])->name('dashboard');
    Route::post('/data', [Dashboard::class, 'getTables']);
	Route::group(['prefix' => 'announcement'], function() {
    	Route::post('/show', [Dashboard::class, 'showAnnouncement']);
    	Route::post('/store', [Dashboard::class, 'storeAnnouncement']);
	});

    Route::group(['prefix' => 'area'], function() {
        Route::get('/'  , [ManageArea::class, 'index']);
	    Route::post('/edit'  , [ManageArea::class, 'edit']);
	    Route::post('/store'  , [ManageArea::class, 'store']);
	    Route::post('/dashboard'  , [ManageArea::class, 'toggleDashboard']);
	    Route::post('/delete'  , [ManageArea::class, 'destroy']);
    });

    Route::group(['prefix' => 'company'], function() {
        Route::get('/'  , [ManageCompany::class, 'index']);
	    Route::post('/edit'  , [ManageCompany::class, 'edit']);
	    Route::post('/store'  , [ManageCompany::class, 'store']);
	    Route::post('/toggle'  , [ManageCompany::class, 'toggle']);
	    Route::post('/delete'  , [ManageCompany::class, 'destroy']);
    });

    Route::group(['prefix' => 'employee'], function() {
    	Route::group(['prefix' => 'todo'], function() {
		    Route::get('/list'  , [ManageToDo::class, 'index']);
		    Route::post('/toggle'  , [ManageToDo::class, 'toggle']);
		    Route::post('/store'  , [ManageToDo::class, 'store']);
		    Route::post('/delete'  , [ManageToDo::class, 'destroy']);
	    });
    	Route::group(['prefix' => 'target'], function() {
	        Route::get('/'  , [ManageTarget::class, 'index']);
	    	Route::post('/detail'  , [ManageTarget::class, 'show']);
       		Route::get('/list'  , [ManageTarget::class, 'list']);
		    Route::post('/store'  , [ManageTarget::class, 'store']);
		    Route::post('/delete'  , [ManageTarget::class, 'destroy']);
	    });
	    Route::post('/store'  , [ManageSales::class, 'store']);
	    Route::post('/detail'  , [ManageSales::class, 'show']);
	    Route::post('/edit'  , [ManageSales::class, 'edit']);
	    Route::post('/photo'  , [ManageSales::class, 'editPhoto']);
	    Route::post('/suspend'  , [ManageSales::class, 'suspend']);
	    Route::post('/password'  , [ManageSales::class, 'changePassword']);
	    Route::post('/addcustomer'  , [ManageSales::class, 'addCustomer']);
        Route::get('/list/{id_area?}'  , [ManageSales::class, 'list']);
        Route::get('/{id_area?}'  , [ManageSales::class, 'index']);
    });


    Route::group(['prefix' => 'product'], function() {
        Route::get('/'  , [ManageProduct::class, 'index']);
        Route::get('list'  , [ManageProduct::class, 'list']);
        Route::post('photo'  , [ManageProduct::class, 'addPhoto']);
        Route::post('photo/detail'  , [ManageProduct::class, 'getPhotoDetail']);
        Route::post('photo/delete'  , [ManageProduct::class, 'deletePhoto']);
        Route::get('addtocart'  , [ManageProduct::class, 'addtocart']);
        Route::post('getbyid'  , [ManageProduct::class, 'getbyid']);
        Route::post('getreturn'  , [ManageProduct::class, 'getReturn']);
	    Route::post('/detail'  , [ManageProduct::class, 'show']);
	    Route::post('/edit'  , [ManageProduct::class, 'edit']);
	    Route::post('/store'  , [ManageProduct::class, 'store']);
	    Route::post('/delete'  , [ManageProduct::class, 'destroy']);

	    Route::group(['prefix' => 'factories'], function() {
	        Route::get('/'  , [ManageFactories::class, 'index']);
		    Route::post('/edit'  , [ManageFactories::class, 'edit']);
		    Route::post('/store'  , [ManageFactories::class, 'store']);
		    Route::post('/delete'  , [ManageFactories::class, 'destroy']);
	    });

	    Route::group(['prefix' => 'type'], function() {
	        Route::get('/'  , [ManageType::class, 'index']);
		    Route::post('/edit'  , [ManageType::class, 'edit']);
		    Route::post('/store'  , [ManageType::class, 'store']);
		    Route::post('/delete'  , [ManageType::class, 'destroy']);
	    });

	    Route::group(['prefix' => 'size'], function() {
	        Route::get('/'  , [ManageSize::class, 'index']);
		    Route::post('/edit'  , [ManageSize::class, 'edit']);
		    Route::post('/store'  , [ManageSize::class, 'store']);
		    Route::post('/delete'  , [ManageSize::class, 'destroy']);
	    });

	    Route::group(['prefix' => 'colour'], function() {
	        Route::get('/'  , [ManageColour::class, 'index']);
		    Route::post('/edit'  , [ManageColour::class, 'edit']);
		    Route::post('/store'  , [ManageColour::class, 'store']);
		    Route::post('/delete'  , [ManageColour::class, 'destroy']);
	    });

	    Route::group(['prefix' => 'logo'], function() {
	        Route::get('/'  , [ManageLogo::class, 'index']);
		    Route::post('/edit'  , [ManageLogo::class, 'edit']);
		    Route::post('/store'  , [ManageLogo::class, 'store']);
		    Route::post('/delete'  , [ManageLogo::class, 'destroy']);
	    });
	    Route::group(['prefix' => 'weight'], function() {
	        Route::get('/'  , [ManageWeight::class, 'index']);
		    Route::post('/edit'  , [ManageWeight::class, 'edit']);
		    Route::post('/store'  , [ManageWeight::class, 'store']);
		    Route::post('/delete'  , [ManageWeight::class, 'destroy']);
	    });
	    Route::group(['prefix' => 'grossweight'], function() {
	        Route::get('/'  , [ManageGrossWeight::class, 'index']);
		    Route::post('/edit'  , [ManageGrossWeight::class, 'edit']);
		    Route::post('/store'  , [ManageGrossWeight::class, 'store']);
		    Route::post('/delete'  , [ManageGrossWeight::class, 'destroy']);
	    });
    });
    
    Route::group(['prefix' => 'warehouse'], function() {
	    Route::get('/'  , [ManageWarehouse::class, 'index']);
	    Route::post('/'  , [ManageWarehouse::class, 'store']);
	    Route::get('/list'  , [ManageWarehouse::class, 'list']);
	    Route::post('/detail'  , [ManageWarehouse::class, 'show']);


    	Route::group(['prefix' => 'product'], function() {
	        Route::get('/'  , [ManageProduct::class, 'stock']);
	        Route::post('/'  , [ManageProduct::class, 'storeStock']);
	        Route::get('/list'  , [ManageProduct::class, 'listStock']);
	        Route::post('/detail'  , [ManageProduct::class, 'detailStock']);
    	});
    });

    Route::group(['prefix' => 'bank'], function() {
    	Route::group(['prefix' => 'account'], function() {
	        Route::get('/'  , [ManagePaymentAccount::class, 'index']);
		    Route::post('/edit'  , [ManagePaymentAccount::class, 'edit']);
		    Route::post('/store'  , [ManagePaymentAccount::class, 'store']);
		    Route::post('/delete'  , [ManagePaymentAccount::class, 'destroy']);
	    });
        Route::get('/'  , [ManageBank::class, 'index']);
	    Route::post('/edit'  , [ManageBank::class, 'edit']);
	    Route::post('/store'  , [ManageBank::class, 'store']);
	    Route::post('/delete'  , [ManageBank::class, 'destroy']);
    });



	Route::group(['prefix' => 'customer'], function() {

	    Route::group(['prefix' => 'level'], function() {
	        Route::get('/'  , [ManageLevel::class, 'index']);
		    Route::post('/edit'  , [ManageLevel::class, 'edit']);
		    Route::post('/store'  , [ManageLevel::class, 'store']);
		    Route::post('/delete'  , [ManageLevel::class, 'destroy']);
		    Route::post('/change'  , [ManageCustomer::class, 'changeLevel']);
	    });

        Route::post('photo'  , [ManageCustomer::class, 'addPhoto']);
        Route::post('photo/detail'  , [ManageCustomer::class, 'getPhotoDetail']);
        Route::post('photo/delete'  , [ManageCustomer::class, 'deletePhoto']);
	    Route::get('/'  , [ManageCustomer::class, 'index']);
	    Route::get('/summary'  , [ManageCustomer::class, 'summary']);
	    Route::post('/summary/list'  , [ManageCustomer::class, 'summarylist']);
	    Route::get('/list'  , [ManageCustomer::class, 'list']);
	    Route::post('/detail'  , [ManageCustomer::class, 'show']);
	    Route::post('/edit'  , [ManageCustomer::class, 'edit']);
	    Route::post('/store'  , [ManageCustomer::class, 'store']);
	    Route::post('/delete'  , [ManageCustomer::class, 'destroy']);
        Route::get('/list/{id_area?}'  , [ManageCustomer::class, 'list']);
        Route::get('/{id_area?}'  , [ManageCustomer::class, 'index']);
	});

	Route::group(['prefix' => 'transaction'], function() {
	    Route::get('/'  , [ManageTransaction::class, 'index']);
	    Route::post('/list'  , [ManageTransaction::class, 'list']);
	    Route::post('/edit'  , [ManageTransaction::class, 'edit']);
	    Route::post('/detail'  , [ManageTransaction::class, 'show']);
	    Route::post('/product/delete'  , [ManageTransaction::class, 'deleteProduct']);
	    Route::post('/store'  , [ManageTransaction::class, 'store']);
	    Route::post('/jurnal'  , [ManageTransaction::class, 'storeJurnal']);
	    Route::post('/store/product'  , [ManageTransaction::class, 'storeProduct']);
	    Route::post('/edit/product'  , [ManageTransaction::class, 'editProduct']);
	    Route::post('/delete/product'  , [ManageTransaction::class, 'deleteProduct']);
	    Route::post('/delete'  , [ManageTransaction::class, 'destroy']);
	    Route::get('/full'  , [ManageTransaction::class, 'full']);
	    Route::get('/full/list'  , [ManageTransaction::class, 'fulllist']);

		Route::get('/refund'  , [ManageTransactionReturn::class, 'index']);
		Route::post('/refund/detail'  , [ManageTransactionReturn::class, 'detail']);
		Route::post('/refund/edit'  , [ManageTransactionReturn::class, 'edit']);
		Route::post('/refund/delete'  , [ManageTransactionReturn::class, 'edit']);
		Route::post('/refund/list'  , [ManageTransactionReturn::class, 'list']);
		Route::post('/refund/store'  , [ManageTransactionReturn::class, 'refundStore']);

		Route::post('/return/show'  , [ManageTransactionReturn::class, 'show']);
		Route::post('/return/store'  , [ManageTransactionReturn::class, 'returnStore']);
	});
	Route::group(['prefix' => 'purchase'], function() {
	    Route::get('/'  , [ManagePurchase::class, 'index']);
	    Route::post('/list'  , [ManagePurchase::class, 'list']);
	    Route::post('/edit'  , [ManagePurchase::class, 'edit']);
	    Route::post('/detail'  , [ManagePurchase::class, 'show']);
	    Route::post('/product/delete'  , [ManagePurchase::class, 'deleteProduct']);
	    Route::post('/store'  , [ManagePurchase::class, 'store']);
	    Route::post('/jurnal'  , [ManagePurchase::class, 'storeJurnal']);
	    Route::post('/store/product'  , [ManagePurchase::class, 'storeProduct']);
	    Route::post('/edit/product'  , [ManagePurchase::class, 'editProduct']);
	    Route::post('/delete/product'  , [ManagePurchase::class, 'deleteProduct']);
	    Route::post('/delete'  , [ManagePurchase::class, 'destroy']);

	    Route::group(['prefix' => 'payment'], function() {
		    Route::get('/'  , [ManagePurchasePayment::class, 'index']);
		    Route::post('/edit'  , [ManagePurchasePayment::class, 'edit']);
		    Route::post('/update'  , [ManagePurchasePayment::class, 'update']);
		    Route::post('/list'  , [ManagePurchasePayment::class, 'list']);
		    Route::post('/detail'  , [ManagePurchasePayment::class, 'show']);
		    Route::post('/pay'  , [ManagePurchasePayment::class, 'pay']);
		});
	});


	Route::group(['prefix' => 'payment'], function() {
		Route::group(['prefix' => 'history'], function() {
		    Route::get('/'  , [ManagePaymentHistory::class, 'index']);
		    Route::post('/list'  , [ManagePaymentHistory::class, 'list']);
		    Route::post('/detail'  , [ManagePaymentHistory::class, 'show']);
		    Route::post('/pay'  , [ManagePaymentHistory::class, 'pay']);
	    });
	    Route::group(['prefix' => 'giro'], function() {
		    Route::get('/'  , [ManageGiro::class, 'index']);
		    Route::get('/transaction'  , [ManageGiro::class, 'getTransaction']);
	    	Route::post('/transaction/detail'  , [ManageTransaction::class, 'show']);
		    Route::post('/list'  , [ManageGiro::class, 'list']);
		    Route::post('/detail'  , [ManageGiro::class, 'detail']);
		    Route::post('/pay'  , [ManageGiro::class, 'pay']);
		    Route::post('/reject'  , [ManageGiro::class, 'reject']);
		    Route::post('/cash'  , [ManageGiro::class, 'cash']);
	    });
	    Route::get('/'  , [ManagePayment::class, 'index']);
	    Route::post('/edit'  , [ManagePayment::class, 'edit']);
	    Route::post('/update'  , [ManagePayment::class, 'update']);
	    Route::post('/list'  , [ManagePayment::class, 'list']);
	    Route::post('/detail'  , [ManagePayment::class, 'show']);
	    Route::post('/pay'  , [ManagePayment::class, 'pay']);
	});

	Route::group(['prefix' => 'asset'], function() {
    	Route::get('/', [ManageFinanceAsset::class, 'index']);
    	Route::get('/add', [ManageFinanceAsset::class, 'add_new']);
    	Route::post('/edit', [ManageFinanceAsset::class, 'edit_data']);
    	Route::get('/edit/{id}', [ManageFinanceAsset::class, 'edit']);
    	Route::post('/record', [ManageFinanceAsset::class, 'record']);
    	Route::post('/delete/{id}', [ManageFinanceAsset::class, 'destroy']);
    	Route::post('/revert_depreciation/{id}', [ManageFinanceAsset::class, 'revert_depreciation']);
    	Route::post('/dispose', [ManageFinanceAsset::class, 'dispose']);
    });
	Route::group(['prefix' => 'finance'], function() {
	    Route::get('/'  , [ManageFinance::class, 'index'])->name('account-page');
	    Route::get('/account'  , [ManageFinance::class, 'getAccount']);
	    Route::get('/account/expense'  , [ManageFinance::class, 'getExpenseAccount']);
	    Route::post('/account'  , [ManageFinance::class, 'addAccount']);
	    Route::get('/account/{id}'  , [ManageFinance::class, 'detail']);
	    Route::get('/invoice/{id}'  , [ManageFinance::class, 'invoice']);

	    Route::group(['prefix' => 'reports'], function() {
	    	Route::get('/'  , [ManageFinanceReports::class, 'index']);
	    	Route::post('profit_and_loss', [ManageFinanceReports::class, 'profitAndLoss']);
	    });
	    
		Route::group(['prefix' => 'chart'], function() {
		    Route::get('/list'  , [ManageFinance::class, 'getAccountAll']);
		    Route::get('/list/{id}'  , [ManageFinance::class, 'getAccountByCategory']);
		    Route::get(''  , [ManageFinance::class, 'chartAccount']);
		    Route::get('/{id}'  , [ManageFinance::class, 'chartAccountCategory']);
		});
	    

		Route::group(['prefix' => 'sales'], function() {
	    	Route::get('/'  , [ManageFinanceSales::class, 'index']);
			Route::get('/invoice/new'  , [ManageFinanceSales::class, 'newInvoice']);
		    Route::post('/invoice/new'  , [ManageFinanceSales::class, 'addNewInvoice']);
		    Route::get('/invoice/{id}'  , [ManageFinanceSales::class, 'invoice']);
		    Route::get('/invoice/details/{id}'  , [ManageFinanceSales::class, 'getInvoiceDetail']);
		    Route::get('/invoice/edit/{id}'  , [ManageFinanceSales::class, 'editInvoice']);
		    Route::post('/invoice/edit/{id}'  , [ManageFinanceSales::class, 'updateInvoice']);
		    
		    Route::get('/quote/new'  , [ManageFinanceSales::class, 'newQuote']);
		    Route::post('/quote/new'  , [ManageFinanceSales::class, 'addNewQuote']);
		    Route::get('/quote/{id}'  , [ManageFinanceSales::class, 'quote']);
		    Route::get('/quote/details/{id}'  , [ManageFinanceSales::class, 'getQuoteDetail']);

		    Route::get('/order/new'  , [ManageFinanceSales::class, 'newOrder']);
		    Route::post('/order/new'  , [ManageFinanceSales::class, 'addNewOrder']);
		    Route::get('/order/{id}'  , [ManageFinanceSales::class, 'order']);
		    Route::get('/order/details/{id}'  , [ManageFinanceSales::class, 'getOrderDetail']);
		});
		Route::group(['prefix' => 'purchase'], function() {
	    	Route::get('/'  , [ManageFinancePurchases::class, 'index']);
			Route::get('/invoice/new'  , [ManageFinancePurchases::class, 'newInvoice']);
		    Route::post('/invoice/new'  , [ManageFinancePurchases::class, 'addNewInvoice']);
		    Route::get('/invoice/{id}'  , [ManageFinancePurchases::class, 'invoice']);
		    Route::get('/invoice/details/{id}'  , [ManageFinancePurchases::class, 'getInvoiceDetail']);

		    Route::get('/quote/new'  , [ManageFinancePurchases::class, 'newQuote']);
		    Route::post('/quote/new'  , [ManageFinancePurchases::class, 'addNewQuote']);
		    Route::get('/quote/{id}'  , [ManageFinancePurchases::class, 'quote']);
		    Route::get('/quote/details/{id}'  , [ManageFinancePurchases::class, 'getQuoteDetail']);

		    Route::get('/order/new'  , [ManageFinancePurchases::class, 'newOrder']);
		    Route::post('/order/new'  , [ManageFinancePurchases::class, 'addNewOrder']);
		    Route::get('/order/{id}'  , [ManageFinancePurchases::class, 'order']);
		    Route::get('/order/details/{id}'  , [ManageFinancePurchases::class, 'getOrderDetail']);
		});


	    
		Route::group(['prefix' => 'expenses'], function() {
		    Route::get('/'  , [ManageFinanceExpenses::class, 'index']);
		    Route::post('/new'  , [ManageFinanceExpenses::class, 'addNewExpense']);

			Route::get('/new'  , [ManageFinanceExpenses::class, 'add']);
		    Route::get('/{id}'  , [ManageFinanceExpenses::class, 'detail']);
		});

	    Route::get('/product'  , [ManageFinanceProduct::class, 'index']);
	    Route::get('/product/detail/{id}'  , [ManageFinanceProduct::class, 'getData']);
	    Route::get('/product/units/{id}'  , [ManageFinanceProduct::class, 'getUnits']);
	    Route::get('/product/list'  , [ManageFinanceProduct::class, 'list']);
	    Route::get('/product/{id}'  , [ManageFinanceProduct::class, 'detail']);

	    Route::get('/terms/list'  , [ManageFinance::class, 'termsList']);
	    Route::get('/terms/{id}'  , [ManageFinance::class, 'terms']);
	    Route::get('/unit/list'  , [ManageFinance::class, 'unitsList']);

	    Route::get('/taxes/list'  , [ManageFinance::class, 'taxesList']);
	    Route::get('/taxes/{id}'  , [ManageFinance::class, 'taxes']);

	    Route::get('/contact'  , [ManageFinanceContact::class, 'index']);
	    Route::get('/contact/{id}'  , [ManageFinanceContact::class, 'detail']);
	    Route::post('/contact'  , [ManageFinanceContact::class, 'addContact']);

	    Route::get('/banktransfer'  , [ManageFinance::class, 'bankTransfer']);
	    Route::post('/banktransfer'  , [ManageFinance::class, 'addBankTransfer']);



	});
	Route::group(['prefix' => 'jurnal'], function() {
		Route::get('/factories'  , [ManageFactories::class, 'factories']);
		Route::get('/currency'  , [ManagePurchase::class, 'getCurrency']);

	});
	Route::group(['prefix' => 'value-management'], function() {
        Route::get('/'  , [ManageProductValue::class, 'index']);
        Route::post('/list'  , [ManageProductValue::class, 'list']);
    });
    Route::group(['prefix' => 'currency-profit-loss'], function() {
        Route::get('/'  , [ManageCurrencyProfitLoss::class, 'index']);
        Route::post('/list'  , [ManageCurrencyProfitLoss::class, 'list']);
    });

    
});
