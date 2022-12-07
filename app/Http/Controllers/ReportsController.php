<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceExp;
use App\Exports\ProductExp;
use App\Exports\SalesExp;
use App\Exports\SalesRetExp;
use App\Exports\ShopstockExp;
use App\Exports\StockExp;
use App\Exports\SupplyExp;
use App\Models\Datefilter;
use App\Models\Factorystore;
use App\Models\Orderdetail;
use App\Models\Productionreport;
use App\Models\Shop;
use App\Models\Shoptransaction;
use App\Models\Stock;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{
    public function index(){
        $data = Factorystore::all();
        //return response()->json($data->sum('total_price'));
        $production = Productionreport::latest()->take(5)->get();
        $sales = Transaction::where('trxtype_id', 1)->get();
        $salesreturned = Transaction::where('trxtype_id', 2)->get();
        $datefilters = Datefilter::all();
        $resultdate = '';
        $shops = Shop::all();
        $shopsales = Transaction::where('trxtype_id', 1)
            ->selectRaw("SUM(total_amount) as total_amount")
            ->selectRaw('shop_id as shop_id')
            ->groupBy('shop_id')
            ->get();
            //return response()->json($shopsales);
        $stocks = Shoptransaction::where('trxtype_id', 1)->get();
        $stocksRet = Shoptransaction::where('trxtype_id', 2)->get();

        $allstocks = Stock::selectRaw("SUM(qty * cost_price) as total_amount")->get();
        $shopstocks = $stocks->sum('total_price');
        $total_stocks = $allstocks->sum('total_amount') + $shopstocks;

        return view('reports.index', compact('resultdate', 'data', 'shops','production',
            'sales', 'salesreturned', 'datefilters', 'shopsales', 'stocks', 'stocksRet', 'total_stocks'));
    }

    public function shopreport(){
        $data = Factorystore::all();
        $sales = Transaction::where('trxtype_id', 1)->get();
        $salesreturned = Transaction::where('trxtype_id', 2)->get();
        $datefilters = Datefilter::all();
        $resultdate = '';
        $shops = Shop::all();
        $shopsales = Transaction::where('trxtype_id', 1)
            ->selectRaw("SUM(total_amount) as total_amount")
            ->selectRaw('shop_id as shop_id')
            ->groupBy('shop_id')
            ->get();
        $production = Productionreport::selectRaw("SUM(total_qty) as total_qty")
            ->selectRaw('product_id as product_id')
            ->groupBy('product_id')->get();
        $stockSales = Shoptransaction::where('trxtype_id', 1)
            ->selectRaw("SUM(qty) as qty")->selectRaw('product_id as product_id')
            ->groupBy('product_id')->get();
       // return response()->json($stockSales);
        $stocks = Shoptransaction::where('trxtype_id', 1)->get();
        $stocksRet = Shoptransaction::where('trxtype_id', 2)->get();

        $allstocks = Stock::selectRaw("SUM(qty * cost_price) as total_amount")->get();
        $shopstocks = $stocks->sum('total_price');
        $total_stocks = $allstocks->sum('total_amount') + $shopstocks;

        return view('reports.shopreports', compact('stocks','resultdate', 'shopstocks', 'data', 'shops','production',
            'sales', 'salesreturned', 'datefilters', 'shopsales', 'stocksRet', 'total_stocks', 'stockSales'));

    }

    public function searchdate(Request $request){

        $dateId = $request->date_id;
        $resultdate = Datefilter::find($dateId);

        if($dateId == 1){
            $today = Carbon::today()->format('Y-m-d');
            $shopsales = Transaction::where('trxtype_id', '=', 1)
                ->where('trx_date','=', $today)
                ->selectRaw("SUM(total_amount) as total_amount")
                ->selectRaw('shop_id as shop_id')
                ->groupBy('shop_id')
                ->get();

            $data = Factorystore::where('date_of_supply', '=', $today)->get();
            $production = Productionreport::where('date_of_ptn', $today)->latest()->take(5)->get();
            $sales = Transaction::where('trxtype_id','=', 1)->where('trx_date','=', $today)->get();
            $salesreturned = Transaction::where('trxtype_id', 2)->where('trx_date', '=', $today)->get();
            $shops = Shop::all();
            $datefilters = Datefilter::all();

            $stocks = Shoptransaction::where('trxtype_id', '=', 1)->where('date_of_trx', 'LIKE', "%{$today}%")->get();
            $stocksRet = Shoptransaction::where('trxtype_id', 2)->where('date_of_trx', 'LIKE', "%{$today}%")->get();
            $allstocks = Stock::selectRaw("SUM(qty * cost_price) as total_amount")->where('created_at', 'LIKE', "%{$today}%")->get();
            $shopstocks = $stocks->sum('total_price');
            $total_stocks = $allstocks->sum('total_amount') + $shopstocks;

            return view('reports.index', compact('resultdate', 'stocks', 'data', 'shops','production',
                'sales', 'salesreturned', 'datefilters', 'shopsales', 'stocksRet', 'total_stocks'));
        }elseif($dateId == 2){
            $yesterday = Carbon::yesterday()->format('Y-m-d');
            $shopsales = Transaction::where('trxtype_id', '=', 1)
                ->where('trx_date','=', $yesterday)
                ->selectRaw("SUM(total_amount) as total_amount")
                ->selectRaw('shop_id as shop_id')
                ->groupBy('shop_id')
                ->get();
            $data = Factorystore::where('date_of_supply', '=', $yesterday)->get();
            $production = Productionreport::where('date_of_ptn', '=', $yesterday)->latest()->take(5)->get();
            $sales = Transaction::where('trxtype_id', 1)->where('trx_date', '=', $yesterday)->get();
            $salesreturned = Transaction::where('trxtype_id', 2)->where('trx_date', '=', $yesterday)->get();
            $shops = Shop::all();
            $datefilters = Datefilter::all();

            $stocks = Shoptransaction::where('trxtype_id', '=', 1)->where('date_of_trx', 'LIKE', "%{$yesterday}%")->get();
            $stocksRet = Shoptransaction::where('trxtype_id', 2)->where('date_of_trx', 'LIKE', "%{$yesterday}%")->get();
            $allstocks = Stock::selectRaw("SUM(qty * cost_price) as total_amount")->where('created_at', 'LIKE', "%{$yesterday}%")->get();
            $shopstocks = $stocks->sum('total_price');
            $total_stocks = $allstocks->sum('total_amount') + $shopstocks;

            return view('reports.index', compact('resultdate', 'stocks', 'data', 'shops','production',
                'sales', 'salesreturned', 'datefilters', 'shopsales', 'stocksRet', 'total_stocks'));
        }elseif($dateId == 3){
            $date = Carbon::now()->subDays(7);
            $shopsales = Transaction::where('trxtype_id', '=', 1)
                ->where('trx_date','=', $date)
                ->selectRaw("SUM(total_amount) as total_amount")
                ->selectRaw('shop_id as shop_id')
                ->groupBy('shop_id')
                ->get();
            $data = Factorystore::where('date_of_supply', '>=', $date)->get();
            $production = Productionreport::where('date_of_ptn', '>=', $date)->latest()->take(5)->get();
            $sales = Transaction::where('trxtype_id','=', 1)->where('trx_date', '>=', $date)->get();
            $salesreturned = Transaction::where('trxtype_id','=', 2)->where('trx_date', '>=', $date)->get();
            $shops = Shop::all();
            $datefilters = Datefilter::all();
            $stocks = Shoptransaction::where('trxtype_id', '=', 1)->where('date_of_trx', 'LIKE', "%{$date}%")->get();
            $stocksRet = Shoptransaction::where('trxtype_id', 2)->where('date_of_trx', 'LIKE', "%{$date}%")->get();
            $allstocks = Stock::selectRaw("SUM(qty * cost_price) as total_amount")->where('created_at', 'LIKE', "%{$date}%")->get();
            $shopstocks = $stocks->sum('total_price');
            $total_stocks = $allstocks->sum('total_amount') + $shopstocks;

            return view('reports.index', compact('stocks','resultdate','data', 'shops','production',
                'sales', 'salesreturned', 'datefilters', 'shopsales', 'stocksRet', 'total_stocks'));
        }elseif($dateId == 4){
            $date = Carbon::now()->subDays(30);
            $shopsales = Transaction::where('trxtype_id', '=', 1)
                ->where('trx_date','=', $date)
                ->selectRaw("SUM(total_amount) as total_amount")
                ->selectRaw('shop_id as shop_id')
                ->groupBy('shop_id')
                ->get();
            $data = Factorystore::where('date_of_supply', '>=', $date)->get();
            $production = Productionreport::where('date_of_ptn', '>=', $date)->latest()->take(5)->get();
            $sales = Transaction::where('trxtype_id','=', 1)->where('trx_date', '>=', $date)->get();
            $salesreturned = Transaction::where('trxtype_id','=', 2)->where('trx_date', '>=', $date)->get();
            $shops = Shop::all();
            $datefilters = Datefilter::all();

            $stocks = Shoptransaction::where('trxtype_id', '=', 1)->where('date_of_trx', 'LIKE', "%{$date}%")->get();
            $stocksRet = Shoptransaction::where('trxtype_id', 2)->where('date_of_trx', 'LIKE', "%{$date}%")->get();
            $allstocks = Stock::selectRaw("SUM(qty * cost_price) as total_amount")->where('created_at', 'LIKE', "%{$date}%")->get();
            $shopstocks = $stocks->sum('total_price');
            $total_stocks = $allstocks->sum('total_amount') + $shopstocks;

            return view('reports.index', compact('stocks','resultdate','data', 'shops','production',
                'sales', 'salesreturned', 'datefilters', 'shopsales', 'stocksRet', 'total_stocks'));
        }elseif($dateId == 5){
            $data = Factorystore::whereMonth('date_of_supply', Carbon::now()->month)->get();
            $shopsales = Transaction::where('trxtype_id', '=', 1)
                ->whereMonth('trx_date','=', Carbon::now()->month)
                ->selectRaw("SUM(total_amount) as total_amount")
                ->selectRaw('shop_id as shop_id')
                ->groupBy('shop_id')
                ->get();
            $production = Productionreport::whereMonth('date_of_ptn','=', Carbon::now()->month)->latest()->take(5)->get();
            $sales = Transaction::where('trxtype_id','=', 1)->whereMonth('trx_date','=', Carbon::now()->month)->get();
            $salesreturned = Transaction::where('trxtype_id','=', 2)->whereMonth('trx_date', '=', Carbon::now()->month)->get();
            $shops = Shop::all();
            $datefilters = Datefilter::all();
            $stocks = Shoptransaction::where('trxtype_id', '=', 1)->whereMonth('date_of_trx', '=', Carbon::now()->month)->get();
            $stocksRet = Shoptransaction::where('trxtype_id', 2)->whereMonth('date_of_trx', '=', Carbon::now()->month)->get();
            $allstocks = Stock::selectRaw("SUM(qty * cost_price) as total_amount")->whereMonth('created_at', '=', Carbon::now()->month)->get();
            $shopstocks = $stocks->sum('total_price');
            $total_stocks = $allstocks->sum('total_amount') + $shopstocks;

            return view('reports.index', compact('stocks','resultdate','data', 'shops','production',
                'sales', 'salesreturned', 'datefilters', 'shopsales', 'stocksRet', 'total_stocks'));
        }elseif($dateId == 6){
            $shopsales = Transaction::where('trxtype_id', '=', 1)
                ->whereYear('trx_date','=', date('Y'))
                ->selectRaw("SUM(total_amount) as total_amount")
                ->selectRaw('shop_id as shop_id')
                ->groupBy('shop_id')
                ->get();
            $data = Factorystore::whereYear('date_of_supply','=', date('Y'))->get();
            $production = Productionreport::whereYear('date_of_ptn','=', date('Y'))->latest()->take(5)->get();
            $sales = Transaction::where('trxtype_id','=', 1)->whereYear('trx_date','=', date('Y'))->get();
            $salesreturned = Transaction::where('trxtype_id','=', 2)->whereYear('trx_date','=', date('Y'))->get();
            $shops = Shop::all();
            $datefilters = Datefilter::all();

            $stocks = Shoptransaction::where('trxtype_id', 1)->whereYear('date_of_trx','=', date('Y'))->get();
            $stocksRet = Shoptransaction::where('trxtype_id', 2)->whereYear('date_of_trx','=', date('Y'))->get();
            $allstocks = Stock::selectRaw("SUM(qty * cost_price) as total_amount")->whereYear('created_at','=', date('Y'))->get();
            $shopstocks = $stocks->sum('total_price');
            $total_stocks = $allstocks->sum('total_amount') + $shopstocks;

            return view('reports.index', compact('stocks','resultdate','data', 'shops','production',
                'sales', 'salesreturned', 'datefilters','shopsales', 'stocksRet', 'total_stocks'));
        }

    }

    public function searchshop(Request $request){
        $shopId = $request->shop_id;
        $dateId = $request->date_id;
        $resultdate = Datefilter::find($dateId);
        $dshop = Shop::find($shopId);

        if($dateId == 1){
            $today = Carbon::today()->format('Y-m-d');
            $shopsales = Transaction::where('trxtype_id', '=', 1)
                ->where('shop_id', '=', $shopId)
                ->where('trx_date','=', $today)
                ->selectRaw("SUM(total_amount) as total_amount")
                ->selectRaw('shop_id as shop_id')
                ->groupBy('shop_id')
                ->get();
            $production = Shoptransaction::where('shop_id', $shopId)
                ->where('date_of_trx', '=', $today)
                ->selectRaw("SUM(qty) as qty")
                ->selectRaw('product_id as product_id')
                ->groupBy('product_id')->get();
            // return response()->json($production);

            $stockSales = Orderdetail::where('shop_id', $shopId)
                ->where('created_at', 'LIKE', "%{$today}%")
                ->selectRaw("SUM(qty) as qty")->selectRaw('product_id as product_id')
                ->groupBy('product_id')->get();

            $stocks = Shoptransaction::where('trxtype_id', '=', 1)->where('shop_id', '=', $shopId)->where('created_at', 'LIKE', "%{$today}%")->get();
            $stocksRet = Shoptransaction::where('trxtype_id', 2)->where('shop_id', '=', $shopId)->where('created_at', 'LIKE', "%{$today}%")->get();

            $sales = Transaction::where('trxtype_id','=', 1)->where('trx_date','=', $today)->where('shop_id', '=', $shopId)->get();
            $salesreturned = Transaction::where('trxtype_id', 2)->where('trx_date', '=', $today)->where('shop_id', '=', $shopId)->get();
            $shops = Shop::all();
            $datefilters = Datefilter::all();

            return view('reports.searchresults', compact( 'dshop','production', 'stockSales', 'shops','resultdate',
                'sales', 'salesreturned', 'datefilters','stocks', 'stocksRet', 'shopsales'));
        }elseif($dateId == 2){
            $yesterday = Carbon::yesterday()->format('Y-m-d');
            $shopsales = Transaction::where('trxtype_id', '=', 1)
                ->where('trx_date','=', $yesterday)
                ->selectRaw("SUM(total_amount) as total_amount")
                ->selectRaw('shop_id as shop_id')
                ->groupBy('shop_id')
                ->get();
            $production = Shoptransaction::where('shop_id', $shopId)
                ->where('date_of_trx', '=', $yesterday)
                ->selectRaw("SUM(qty) as qty")
                ->selectRaw('product_id as product_id')
                ->groupBy('product_id')->get();
            // return response()->json($production);

            $stockSales = Orderdetail::where('shop_id', $shopId)
                ->where('created_at', 'LIKE', "%{$yesterday}%")
                ->selectRaw("SUM(qty) as qty")->selectRaw('product_id as product_id')
                ->groupBy('product_id')->get();

            $stocks = Shoptransaction::where('trxtype_id', '=', 1)->where('shop_id', '=', $shopId)->where('date_of_trx', '=', $yesterday)->get();
            $stocksRet = Shoptransaction::where('trxtype_id', 2)->where('shop_id', '=', $shopId)->where('date_of_trx', '=', $yesterday)->get();

            $sales = Transaction::where('trxtype_id', 1)->where('trx_date', '=', $yesterday)->where('shop_id', '=', $shopId)->get();
            $salesreturned = Transaction::where('trxtype_id', 2)->where('trx_date', '=', $yesterday)->where('shop_id', '=', $shopId)->get();
            $shops = Shop::all();
            $datefilters = Datefilter::all();

            return view('reports.searchresults', compact('dshop','stocks','production', 'stockSales', 'resultdate', 'shops','production',
                'sales', 'salesreturned', 'datefilters', 'shopsales', 'stocksRet'));
        }elseif($dateId == 3){
            $date = Carbon::now()->subDays(7)->format('Y-m-d');

            //return response()->json($date);
            $shopsales = Transaction::where('trxtype_id', '=', 1)
                ->where('trx_date', '>=', $date)
                ->selectRaw("SUM(total_amount) as total_amount")
                ->selectRaw('shop_id as shop_id')
                ->groupBy('shop_id')
                ->get();
            // return response()->json($shopsales);

            $production = Shoptransaction::where('shop_id', $shopId)
                ->where('date_of_trx', '>=', $date)
                ->selectRaw("SUM(qty) as qty")
                ->selectRaw('product_id as product_id')
                ->groupBy('product_id')->get();
            // return response()->json($production);

            $stockSales = Orderdetail::where('shop_id', $shopId)
                ->where('created_at', '>=', $date)
                ->selectRaw("SUM(qty) as qty")->selectRaw('product_id as product_id')
                ->groupBy('product_id')->get();

            $stocks = Shoptransaction::where('trxtype_id', '=', 1)->where('shop_id', '>=', $shopId)->where('date_of_trx', '=', $date)->get();
            $stocksRet = Shoptransaction::where('trxtype_id', 2)->where('shop_id', '>=', $shopId)->where('date_of_trx', '=', $date)->get();

            $sales = Transaction::where('trxtype_id', 1)->where('trx_date', '>=', $date)->where('shop_id', '=', $shopId)->get();
            $salesreturned = Transaction::where('trxtype_id', 2)->where('trx_date',  '>=', $date)->where('shop_id', '=', $shopId)->get();

            $shops = Shop::all();
            $datefilters = Datefilter::all();

            return view('reports.searchresults', compact('dshop','stocks', 'stocksRet','resultdate', 'shops','production',
                'sales', 'salesreturned', 'datefilters', 'shopsales', 'stockSales'));
        }elseif($dateId == 4){
            $date = Carbon::now()->subDays(30)->format('Y-m-d');
            $shopsales = Transaction::where('trxtype_id', '=', 1)
                ->where('trx_date','>=', $date)
                ->selectRaw("SUM(total_amount) as total_amount")
                ->selectRaw('shop_id as shop_id')
                ->groupBy('shop_id')
                ->get();

            $production = Shoptransaction::where('shop_id', $shopId)
                ->where('date_of_trx', '>=', $date)
                ->selectRaw("SUM(qty) as qty")
                ->selectRaw('product_id as product_id')
                ->groupBy('product_id')->get();

            $stockSales = Orderdetail::where('shop_id', $shopId)
                ->where('created_at', '>=', $date)
                ->selectRaw("SUM(qty) as qty")->selectRaw('product_id as product_id')
                ->groupBy('product_id')->get();
            $stocks = Shoptransaction::where('trxtype_id', '=', 1)->where('shop_id', '=', $shopId)->where('date_of_trx', '>=', $date)->get();
            $stocksRet = Shoptransaction::where('trxtype_id', 2)->where('shop_id', '=', $shopId)->where('date_of_trx', '>=', $date)->get();

            $sales = Transaction::where('trxtype_id', 1)->where('trx_date', '>=', $date)->where('shop_id', '=', $shopId)->get();
            $salesreturned = Transaction::where('trxtype_id', 2)->where('trx_date', '>=', $date)->where('shop_id', '=', $shopId)->get();


            $shops = Shop::all();
            $datefilters = Datefilter::all();

            return view('reports.searchresults', compact('dshop','stockSales','resultdate', 'shops','production',
                'sales', 'salesreturned', 'datefilters', 'shopsales', 'stocks', 'stocksRet'));
        }elseif($dateId == 5){
            $shopsales = Transaction::where('trxtype_id', '=', 1)
                ->whereMonth('trx_date','=', Carbon::now()->month)
                ->selectRaw("SUM(total_amount) as total_amount")
                ->selectRaw('shop_id as shop_id')
                ->groupBy('shop_id')
                ->get();

            $production = Shoptransaction::where('shop_id', $shopId)
                ->whereMonth('date_of_trx','=', Carbon::now()->month)
                ->selectRaw("SUM(qty) as qty")
                ->selectRaw('product_id as product_id')
                ->groupBy('product_id')->get();
            // return response()->json($production);

            $stockSales = Orderdetail::where('shop_id', $shopId)
                ->whereMonth('created_at','=', Carbon::now()->month)
                ->selectRaw("SUM(qty) as qty")->selectRaw('product_id as product_id')
                ->groupBy('product_id')->get();
            $stocks = Shoptransaction::where('trxtype_id', '=', 1)->where('shop_id', '=', $shopId)->whereMonth('date_of_trx','=', Carbon::now()->month)->get();
            $stocksRet = Shoptransaction::where('trxtype_id', 2)->where('shop_id', '=', $shopId)->whereMonth('date_of_trx','=', Carbon::now()->month)->get();

            $sales = Transaction::where('trxtype_id', 1)->whereMonth('trx_date','=', Carbon::now()->month)->where('shop_id', '=', $shopId)->get();
            $salesreturned = Transaction::where('trxtype_id', 2)->whereMonth('trx_date','=', Carbon::now()->month)->where('shop_id', '=', $shopId)->get();

            $shops = Shop::all();
            $datefilters = Datefilter::all();

            return view('reports.searchresults', compact('dshop','resultdate', 'shops','production',
                'sales', 'salesreturned', 'datefilters', 'shopsales', 'stockSales', 'stocks', 'stocksRet'));
        }elseif($dateId == 6){
            $shopsales = Transaction::where('trxtype_id', '=', 1)
                ->whereYear('trx_date','=', date('Y'))
                ->selectRaw("SUM(total_amount) as total_amount")
                ->selectRaw('shop_id as shop_id')
                ->groupBy('shop_id')
                ->get();

            $production = Shoptransaction::where('shop_id', $shopId)
                ->whereYear('date_of_trx','=', date('Y'))
                ->selectRaw("SUM(qty) as qty")
                ->selectRaw('product_id as product_id')
                ->groupBy('product_id')->get();
            // return response()->json($production);

            $stockSales = Orderdetail::where('shop_id', $shopId)
                ->whereYear('created_at','LIKE', date('Y'))
                ->selectRaw("SUM(qty) as qty")->selectRaw('product_id as product_id')
                ->groupBy('product_id')->get();
            $stocks = Shoptransaction::where('trxtype_id', '=', 1)->where('shop_id', '=', $shopId)->whereYear('date_of_trx','=', date('Y'))->get();
            $stocksRet = Shoptransaction::where('trxtype_id', 2)->where('shop_id', '=', $shopId)->whereYear('date_of_trx','=', date('Y'))->get();

            $sales = Transaction::where('trxtype_id', 1)->whereYear('trx_date','=', date('Y'))->where('shop_id', '=', $shopId)->get();
            $salesreturned = Transaction::where('trxtype_id', 2)->whereYear('trx_date','=', date('Y'))->where('shop_id', '=', $shopId)->get();

            $shops = Shop::all();
            $datefilters = Datefilter::all();

            return view('reports.searchresults', compact('dshop','resultdate', 'shops','production',
                'sales', 'salesreturned', 'datefilters','shopsales', 'stockSales', 'stocks', 'stocksRet'));
        }

    }


    public function productsreport(){
        $data = Productionreport::all();
        $toDate = "01/01/2022";
        $fromDate = "01/01/2022";
        return view('reports.productsreport', compact('data', 'toDate', 'fromDate'));
    }
    public function exportproduct(){
        //return response()->json('this is it');
        return Excel::download(new ProductExp(), 'product_report.xlsx');
    }
    public function rawmaterials(){
        $data = Factorystore::all();
        $toDate = "01/01/2022";
        $fromDate = "01/01/2022";
        return view('reports.rawmaterials', compact('data', 'toDate', 'fromDate'));
    }

    public function stockstransactions(){
        $data = Shoptransaction::all();
        $toDate = "01/01/2022";
        $fromDate = "01/01/2022";
        return view('reports.stockstransactions', compact('data', 'toDate', 'fromDate'));
    }
    public function exportstock(){
        //return response()->json('this is it');
        return Excel::download(new StockExp(), 'stocktransactions_report.xlsx');
    }

    public function salesreport(){
        $data = Transaction::where('trxtype_id', 1)->get();
        $toDate = "01/01/2022";
        $fromDate = "01/01/2022";
        return view('reports.salesreport', compact('data', 'toDate', 'fromDate'));
    }
    public function exportsales(){
        //return response()->json('this is it');
        return Excel::download(new SalesExp(), 'sales_report.xlsx');
    }

    public function salesreturned(){
        $data = Transaction::where('trxtype_id', 2)->get();
        $toDate = "01/01/2022";
        $fromDate = "01/01/2022";
        return view('reports.salesreturned', compact('data', 'toDate', 'fromDate'));
    }
    public function exportsalesret(){
        //return response()->json('this is it');
        return Excel::download(new SalesRetExp(), 'salesreturned_report.xlsx');
    }
    public function invoices(){
        $data = Transaction::all();
        $toDate = "01/01/2022";
        $fromDate = "01/01/2022";
        return view('reports.invoices', compact('data', 'toDate', 'fromDate'));
    }

    public function rawmatsearch(Request $request){
        $toDate = $request->to_date;
        $fromDate = $request->from_date;
        $data = Factorystore::whereBetween('date_of_supply', array($request->from_date, $request->to_date))
            ->get();
        return view('reports.rawmaterials', compact('data', 'toDate', 'fromDate'));
    }
    public function exportsupply(){
        //return response()->json('this is it');
        return Excel::download(new SupplyExp(), 'supply_report.xlsx');
    }

    public function prdsearch(Request $request){
        $toDate = $request->to_date;
        $fromDate = $request->from_date;
        $data = Productionreport::whereBetween('date_of_ptn', array($request->from_date, $request->to_date))
            ->get();
        return view('reports.productsreport', compact('data', 'toDate', 'fromDate'));
    }

    public function stocktransearch(Request $request){
        $toDate = $request->to_date;
        $fromDate = $request->from_date;
        $data = Shoptransaction::whereBetween('date_of_trx', array($request->from_date, $request->to_date))
            ->get();
        return view('reports.stockstransactions', compact('data', 'toDate', 'fromDate'));
    }

    public function salessearch(Request $request){
        $toDate = $request->to_date;
        $fromDate = $request->from_date;
        $data = Transaction::whereBetween('trx_date', array($request->from_date, $request->to_date))
            ->get();
        return view('reports.salesreport', compact('data', 'toDate', 'fromDate'));
    }

    public function returnedsearch(Request $request){
        $toDate = $request->to_date;
        $fromDate = $request->from_date;
        $data = Transaction::whereBetween('trx_date', array($request->from_date, $request->to_date))
            ->get();
        return view('reports.salesreturned', compact('data', 'toDate', 'fromDate'));
    }

    public function invoicesearch(Request $request){
        $toDate = $request->to_date;
        $fromDate = $request->from_date;
        $data = Transaction::whereBetween('trx_date', array($request->from_date, $request->to_date))
            ->get();
        return view('reports.invoices', compact('data', 'toDate', 'fromDate'));
    }

}
