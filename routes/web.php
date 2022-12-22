<?php

use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ShopinventoriesController;
use App\Http\Controllers\UsersController;
use App\Imports\UsersImport;
use App\Models\Shop;
use App\Models\Shoptransaction;
use App\Models\Stock;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

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

    /**
     * Home Routes
     */
    //Route::get('/', 'HomeController@index')->name('home.index');
    Route::get('/', function () {
        return view('auth/login');
    });

    Route::get('/dashboard', function () {
        if(Auth::user()->roles->first()->id == 1){
            $users = \App\Models\User::all();
            $rawmats = \App\Models\Factorystore::all();
            $prdrep = \App\Models\Productionreport::all();
            $allstocks = Stock::selectRaw("SUM(qty * cost_price) as total_amount")->get();
            $stocks = Shoptransaction::where('trxtype_id', 1)->get();
            $shopstocks = $stocks->sum('total_price');
            $total_stocks = $allstocks->sum('total_amount') + $shopstocks;
            $sales = Transaction::where('trxtype_id', 1)->get();
            $salesreturned = Transaction::where('trxtype_id', 2)->get();
            $shops = \App\Models\Shop::all();
            $customers= \App\Models\Customer::all();
            return view('dashboard', compact('users', 'customers', 'shops',
                'sales', 'salesreturned','total_stocks', 'prdrep', 'rawmats'));
        }elseif(Auth::user()->roles->first()->id == 4){
            $shop_id = Shop::where('user_id', Auth::user()->id)->first();
            //dd($shop_id);
            $today = Carbon::today()->format('Y-m-d');
            $sevendate = Carbon::now()->subDays(7);
            $thirtydate = Carbon::now()->subDays(30);

            $shopsales = Transaction::where('trxtype_id', '=', 1)
                ->where('trx_date','=', $today)
                ->where('shop_id', '=', $shop_id->id)
                ->selectRaw("SUM(total_amount) as total_amount")
                ->get();
            $sevensales = Transaction::where('trxtype_id', '=', 1)
                ->where('trx_date','>=', $sevendate)
                ->where('shop_id', '=', $shop_id->id)
                ->selectRaw("SUM(total_amount) as total_amount")
                ->get();
            $thirtysales = Transaction::where('trxtype_id', '=', 1)
                ->where('trx_date','>=', $thirtydate)
                ->where('shop_id', '=', $shop_id->id)
                ->selectRaw("SUM(total_amount) as total_amount")
                ->selectRaw('shop_id as shop_id')
                ->groupBy('shop_id')
                ->get();

            $allstocks = \App\Models\Shopinventory::where('shop_id','=',$shop_id->id)->selectRaw("SUM(qty * cost_price) as total_amount")->get();
            $stocks = Shoptransaction::where('trxtype_id', 1)->get();
            $shopstocks = $stocks->sum('total_price');
            $total_stocks = $allstocks->sum('total_amount') + $shopstocks;
            $sales = Transaction::where('trxtype_id', 1)->where('user_id','=',Auth::user()->id)->get();
            $salesreturned = Transaction::where('trxtype_id', 2)->where('user_id','=',Auth::user()->id)->get();
            $shops = \App\Models\Shop::all();
            $customers= \App\Models\Customer::all();

            return view('sales_dashboard', compact('thirtysales', 'sevensales', 'shopsales', 'allstocks','customers', 'shops',
                'sales', 'salesreturned','total_stocks'));
        }else{
            return view('production_dashboard');
        }

    })->middleware(['auth'])->name('dashboard');

    require __DIR__.'/auth.php';

    Route::post('import', function() {
       Excel::import(new UsersImport, request()->file('file'));
       return redirect()->back()->with('success', 'Data Imported Successfully');
    });

    Route::group(['middleware' => ['auth', 'permission']], function() {

        Route::group(['prefix' => 'users'], function() {

            Route::get('/', 'App\Http\Controllers\UsersController@index')->name('users.index');
            Route::get('/create', 'App\Http\Controllers\UsersController@create')->name('users.create');
            Route::post('/create', 'App\Http\Controllers\UsersController@store')->name('users.store');
            Route::get('/{user}/show', 'App\Http\Controllers\UsersController@show')->name('users.show');
            Route::get('/{user}/edit', 'App\Http\Controllers\UsersController@edit')->name('users.edit');
            Route::patch('/{user}/update', 'App\Http\Controllers\UsersController@update')->name('users.update');
            Route::delete('/{user}/delete', 'App\Http\Controllers\UsersController@destroy')->name('users.destroy');
        });
        Route::resource('roles', RolesController::class);
        Route::resource('permissions', PermissionsController::class);

        // Factory inventory mgt
        Route::resource('paymentmethods', \App\Http\Controllers\PaymentmethodsController::class);
        Route::resource('paymentstatuses', \App\Http\Controllers\PaymentstatusesController::class);
        Route::resource('units', \App\Http\Controllers\UnitsController::class);
        Route::resource('suppliers', \App\Http\Controllers\SuppliersController::class);
        Route::resource('approvalstatuses', \App\Http\Controllers\ApprovalstatusesController::class);
        Route::resource('rawmaterials', \App\Http\Controllers\RawmaterialsController::class);
        Route::resource('factorystores', \App\Http\Controllers\FactorystoresController::class);
        Route::get('factorystores/restock/{id}', 'App\Http\Controllers\FactorystoresController@restock')->name('factorystores.restock');
        Route::resource('barcodes', \App\Http\Controllers\BarcodesController::class);
        Route::resource('products', \App\Http\Controllers\ProductsController::class);
        Route::resource('trxtypes', \App\Http\Controllers\TrxtypesController::class);
        Route::resource('storetrxs', \App\Http\Controllers\StoretrxsController::class);
        Route::resource('storereports', \App\Http\Controllers\StorereportsController::class);

        //production matters
       // Route::resource('production_materials', \App\Http\Controllers\ProductionmaterialsController::class);
        //Route::get('production_materials/fetchall/{id}', [\App\Http\Controllers\ProductionmaterialsController::class, 'fetchall'])->name('production_materials.fetchall');
        Route::post('productions.materials', [\App\Http\Controllers\ProductiontrxsController::class, 'materials'])->name('productions.materials');
        Route::get('productions.mats/{id}', [\App\Http\Controllers\ProductiontrxsController::class, 'mats'])->name('productions.mats');


        Route::resource('productions', \App\Http\Controllers\ProductiontrxsController::class);
        Route::get('productions/add/{id}', [\App\Http\Controllers\ProductiontrxsController::class, 'add'])->name('productions.add');
        Route::get('productions.list', [\App\Http\Controllers\ProductiontrxsController::class, 'list'])->name('productions.list');
        Route::resource('productionreports', \App\Http\Controllers\ProductionreportController::class);
        Route::get('productionreports/rawmatprice/{id}', [\App\Http\Controllers\ProductionreportController::class, 'rawmatprice'])->name('productionreports.rawmatprice');
        Route::resource('stocks', \App\Http\Controllers\StocksController::class);

        //Sales matters
        Route::resource('shops', \App\Http\Controllers\ShopsController::class);
        Route::get('shopinventories.myshop', [\App\Http\Controllers\ShopinventoriesController::class, 'myshop'])->name('shopinventories.myshop');
        Route::resource('shoptransactions', \App\Http\Controllers\ShoptransactionsController::class );
        Route::get('stocks/checkqty/{id}', [\App\Http\Controllers\StocksController::class, 'checkqty'])->name('stocks.checkqty');
        Route::resource('shopinventories', ShopinventoriesController::class);
        Route::get('shoptransactions/restock/{id}', 'App\Http\Controllers\ShoptransactionsController@restock')->name('shoptransactions.restock');
        Route::resource('customers', \App\Http\Controllers\CustomersController::class);
        Route::post('customers/add', [\App\Http\Controllers\CustomersController::class, 'add'])->name('customers.add');
        Route::resource('orders', \App\Http\Controllers\OrdersController::class);
        Route::resource('pos', \App\Http\Controllers\PosController::class);
        Route::resource('transactions', \App\Http\Controllers\TransactionsController::class);
        Route::get('transacations.myshop', [\App\Http\Controllers\TransactionsController::class, 'myshop'])->name('transactions.myshop');
        Route::get('carts/add/{id}', [\App\Http\Controllers\CartsController::class, 'add'])->name('carts.add');
        Route::resource('invoices', \App\Http\Controllers\InvoiceController::class);
        Route::get('invoices/receipt/{id}', [\App\Http\Controllers\InvoiceController::class, 'receipts'])->name('invoices.receipt');
        Route::get('transactions.returns', [\App\Http\Controllers\TransactionsController::class, 'returns'])->name('transactions.returns');
        Route::get('transactions.myreturns', [\App\Http\Controllers\TransactionsController::class, 'myreturns'])->name('transactions.myreturns');
        Route::get('transactions.paybalance/{id}', [\App\Http\Controllers\TransactionsController::class, 'paybalance'])->name('transactions.paybalance');
        Route::resource('orderdetails', \App\Http\Controllers\OrderdetailsController::class);
        Route::get('myorderdetails', [\App\Http\Controllers\OrderdetailsController::class, 'myorderdetails'])->name('orderdetails.myorderdetails');
        Route::post('orders.returnAdd', [\App\Http\Controllers\OrdersController::class, 'returnAdd'])->name('orders.returnAdd');

       //All Reports
        Route::resource('reports', \App\Http\Controllers\ReportsController::class);
        Route::post('reports.searchshop', [\App\Http\Controllers\ReportsController::class, 'searchshop'])->name('reports.searchshop');
        Route::post('reports.searchdate', [\App\Http\Controllers\ReportsController::class, 'searchdate'])->name('reports.searchdate');
        //Route::get('reports.storereport', [\App\Http\Controllers\ReportsController::class, 'storereport'])->name('reports.storereport');
        Route::get('reports.productsreport', [\App\Http\Controllers\ReportsController::class, 'productsreport'])->name('reports.productsreport');
        Route::get('reports.allshopreports', [\App\Http\Controllers\ReportsController::class, 'allshopreport'])->name('reports.allshopreports');
        Route::get('reports.shopreports', [\App\Http\Controllers\ReportsController::class, 'shopreport'])->name('reports.shopreports');
        Route::get('reports.rawmaterials', [\App\Http\Controllers\ReportsController::class, 'rawmaterials'])->name('reports.rawmaterials');
        Route::get('reports.stockstransactions', [\App\Http\Controllers\ReportsController::class, 'stockstransactions'])->name('reports.stockstransactions');
        Route::get('reports.salesreport', [\App\Http\Controllers\ReportsController::class, 'salesreport'])->name('reports.salesreport');
        Route::get('reports.salesreturned', [\App\Http\Controllers\ReportsController::class, 'salesreturned'])->name('reports.salesreturned');
        Route::get('reports.invoices', [\App\Http\Controllers\ReportsController::class, 'invoices'])->name('reports.invoices');
        Route::post('reports.rawmatsearch', [\App\Http\Controllers\ReportsController::class, 'rawmatsearch'])->name('reports.rawmatsearch');
        Route::post('reports.stocktransearch', [\App\Http\Controllers\ReportsController::class, 'stocktransearch'])->name('reports.stocktransearch');
        Route::post('reports.returnedsearch', [\App\Http\Controllers\ReportsController::class, 'returnedsearch'])->name('reports.returnedsearch');
        Route::post('reports.salessearch', [\App\Http\Controllers\ReportsController::class, 'salessearch'])->name('reports.salessearch');
        Route::post('reports.prdsearch', [\App\Http\Controllers\ReportsController::class, 'prdsearch'])->name('reports.prdsearch');
        Route::post('reports.invoicesearch', [\App\Http\Controllers\ReportsController::class, 'invoicesearch'])->name('reports.invoicesearch');

        //Shop Report Routes
        Route::get('reports.generalshopreports', [\App\Http\Controllers\ShopreportsController::class, 'generalshopreports'])->name('reports.generalshopreports');
        Route::post('reports.shopsearch', [\App\Http\Controllers\ShopreportsController::class, 'shopsearch'])->name('reports.shopsearch');
        Route::post('reports.shopsearchdate', [\App\Http\Controllers\ShopreportsController::class, 'shopsearchdate'])->name('reports.shopsearchdate');
        Route::post('reports.shopstocktransearch', [\App\Http\Controllers\ShopreportsController::class, 'shopstocktransearch'])->name('reports.shopstocktransearch');
        Route::post('reports.shopreturnedsearch', [\App\Http\Controllers\ShopreportsController::class, 'shopreturnedsearch'])->name('reports.shopreturnedsearch');
        Route::post('reports.shopsalessearch', [\App\Http\Controllers\ShopreportsController::class, 'shopsalessearch'])->name('reports.shopsalessearch');
        Route::get('reports.shopstockstransactions', [\App\Http\Controllers\ShopreportsController::class, 'shopstockstransactions'])->name('reports.shopstockstransactions');
        Route::get('reports.shopsalesreport', [\App\Http\Controllers\ShopreportsController::class, 'shopsalesreport'])->name('reports.shopsalesreport');
        Route::get('reports.shopsalesreturned', [\App\Http\Controllers\ShopreportsController::class, 'shopsalesreturned'])->name('reports.shopsalesreturned');
        Route::post('reports.shopinvoicesearch', [\App\Http\Controllers\ShopreportsController::class, 'shopinvoicesearch'])->name('reports.shopinvoicesearch');
        Route::get('reports.shopinvoices', [\App\Http\Controllers\ShopreportsController::class, 'shopinvoices'])->name('reports.shopinvoices');


        //EXPORTING OF FILES for the ADMIN
        Route::get('exportsupply/',[\App\Http\Controllers\ReportsController::class, 'exportsupply'] )->name('exportsupply');
        Route::get('exportproduct/',[\App\Http\Controllers\ReportsController::class, 'exportproduct'] )->name('exportproduct');
        Route::get('exportstock/',[\App\Http\Controllers\ReportsController::class, 'exportstock'] )->name('exportstock');
        Route::get('exportsales/',[\App\Http\Controllers\ReportsController::class, 'exportsales'] )->name('exportsales');
        Route::get('exportsalesret/',[\App\Http\Controllers\ReportsController::class, 'exportsalesret'] )->name('exportsalesret');

        //EXPORTING OF FILE FOR THE SHOPS
        Route::get('exportshopstock/',[\App\Http\Controllers\ShopreportsController::class, 'exportshopstock'] )->name('exportshopstock');
        Route::get('exportshopsales/',[\App\Http\Controllers\ShopreportsController::class, 'exportshopsales'] )->name('exportshopsales');
        Route::get('exportshopsalesret/',[\App\Http\Controllers\ShopreportsController::class, 'exportshopsalesret'] )->name('exportshopsalesret');


    });


