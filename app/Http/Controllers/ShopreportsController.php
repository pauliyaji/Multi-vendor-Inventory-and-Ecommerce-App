<?php

namespace App\Http\Controllers;

use App\Exports\ShopsalesExp;
use App\Exports\ShopsalesretExp;
use App\Exports\ShopstockExp;
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
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use Maatwebsite\Excel\Facades\Excel;

class ShopreportsController extends Controller
{
    public function generalshopreports(){
        $shopId = Shop::where('user_id', Auth::user()->id)->first();
        //return response()->json($shopId->id);
        $sales = Transaction::where('trxtype_id', 1)->where('shop_id','=', $shopId->id)->get();
        $salesreturned = Transaction::where('trxtype_id', 2)->where('shop_id','=', $shopId->id)->get();
        $datefilters = Datefilter::all();
        $resultdate = '';
        $shops = Shop::all();
        $shopsales = Transaction::where('trxtype_id', 1)
            ->where('shop_id','=', $shopId->id)
            ->selectRaw("SUM(total_amount) as total_amount")
            ->selectRaw('shop_id as shop_id')
            ->groupBy('shop_id')
            ->get();
        $totalstockreturned = Shoptransaction::where('trxtype_id', 2)
            ->where('shop_id','=', $shopId->id)
            ->selectRaw("SUM(qty) as qty")->selectRaw('product_id as product_id')
            ->groupBy('product_id')->get();
        $totalstockcollected = Shoptransaction::where('trxtype_id', 1)
            ->where('shop_id','=', $shopId->id)
            ->selectRaw("SUM(qty) as qty")->selectRaw('product_id as product_id')
            ->groupBy('product_id')->get();
        // return response()->json($stockSales);
        $stocks = Shoptransaction::where('trxtype_id', 1)->where('shop_id','=', $shopId->id)->get();
        $stocksRet = Shoptransaction::where('trxtype_id', 2)->where('shop_id','=', $shopId->id)->get();

        return view('reports.generalshopreports', compact('stocks','resultdate', 'shops',
            'sales', 'salesreturned', 'datefilters', 'shopsales', 'stocksRet', 'totalstockcollected',
        'totalstockreturned'));

    }

    public function shopsearchdate(Request $request){
        $shopId = Shop::where('user_id', Auth::user()->id)->first();
        $dateId = $request->date_id;
        $resultdate = Datefilter::find($dateId);

        if($dateId == 1){
            $today = Carbon::today()->format('Y-m-d');
            $shopsales = Transaction::where('trxtype_id', '=', 1)
                ->where('trx_date','=', $today)
                ->where('shop_id','=', $shopId->id)
                ->selectRaw("SUM(total_amount) as total_amount")
                ->selectRaw('shop_id as shop_id')
                ->groupBy('shop_id')
                ->get();

            $sales = Transaction::where('trxtype_id','=', 1)->where('shop_id','=', $shopId->id)
                ->where('trx_date','=', $today)->get();
            $salesreturned = Transaction::where('trxtype_id', 2)->where('shop_id','=', $shopId->id)
                ->where('trx_date', '=', $today)->get();
            $shops = Shop::all();
            $datefilters = Datefilter::all();
            $totalstockreturned = Shoptransaction::where('trxtype_id', 2)
                ->where('shop_id','=', $shopId->id)
                ->where('date_of_trx', 'LIKE', "%{$today}%")
                ->selectRaw("SUM(qty) as qty")->selectRaw('product_id as product_id')
                ->groupBy('product_id')->get();
            $totalstockcollected = Shoptransaction::where('trxtype_id', 1)
                ->where('shop_id','=', $shopId->id)
                ->where('date_of_trx', 'LIKE', "%{$today}%")
                ->selectRaw("SUM(qty) as qty")->selectRaw('product_id as product_id')
                ->groupBy('product_id')->get();
            // return response()->json($stockSales);

            $stocks = Shoptransaction::where('trxtype_id', '=', 1)
                ->where('shop_id','=', $shopId->id)
                ->where('date_of_trx', 'LIKE', "%{$today}%")->get();
            $stocksRet = Shoptransaction::where('trxtype_id', 2)
                ->where('shop_id','=', $shopId->id)
                ->where('date_of_trx', 'LIKE', "%{$today}%")->get();

            return view('reports.generalshopreports', compact('stocks', 'stocksRet','shopsales','resultdate', 'shops',
                'sales', 'salesreturned', 'datefilters', 'totalstockcollected',
                'totalstockreturned'));

        }elseif($dateId == 2){
            $yesterday = Carbon::yesterday()->format('Y-m-d');
            $shopsales = Transaction::where('trxtype_id', '=', 1)
                ->where('trx_date','=', $yesterday)
                ->selectRaw("SUM(total_amount) as total_amount")
                ->selectRaw('shop_id as shop_id')
                ->groupBy('shop_id')
                ->get();
            $sales = Transaction::where('trxtype_id', 1)
                ->where('shop_id','=', $shopId->id)
                ->where('trx_date', '=', $yesterday)->get();
            $salesreturned = Transaction::where('trxtype_id', 2)
                ->where('shop_id','=', $shopId->id)
                ->where('trx_date', '=', $yesterday)->get();
            $shops = Shop::all();
            $datefilters = Datefilter::all();

            $totalstockreturned = Shoptransaction::where('trxtype_id', 2)
                ->where('shop_id','=', $shopId->id)
                ->where('date_of_trx', 'LIKE', "%{$yesterday}%")
                ->selectRaw("SUM(qty) as qty")->selectRaw('product_id as product_id')
                ->groupBy('product_id')->get();
            $totalstockcollected = Shoptransaction::where('trxtype_id', 1)
                ->where('shop_id','=', $shopId->id)
                ->where('date_of_trx', 'LIKE', "%{$yesterday}%")
                ->selectRaw("SUM(qty) as qty")->selectRaw('product_id as product_id')
                ->groupBy('product_id')->get();
            // return response()->json($stockSales);

            $stocks = Shoptransaction::where('trxtype_id', '=', 1)
                ->where('shop_id','=', $shopId->id)
                ->where('date_of_trx', 'LIKE', "%{$yesterday}%")->get();
            $stocksRet = Shoptransaction::where('trxtype_id', 2)
                ->where('shop_id','=', $shopId->id)
                ->where('date_of_trx', 'LIKE', "%{$yesterday}%")->get();

            return view('reports.generalshopreports', compact('stocks', 'stocksRet','shopsales','resultdate', 'shops',
                'sales', 'salesreturned', 'datefilters', 'totalstockcollected',
                'totalstockreturned'));

        }elseif($dateId == 3){
            $date = Carbon::now()->subDays(7);
            $shopsales = Transaction::where('trxtype_id', '=', 1)
                ->where('trx_date','=', $date)
                ->selectRaw("SUM(total_amount) as total_amount")
                ->selectRaw('shop_id as shop_id')
                ->groupBy('shop_id')
                ->get();
            $sales = Transaction::where('trxtype_id','=', 1)
                ->where('shop_id','=', $shopId->id)
                ->where('trx_date', '>=', $date)->get();
            $salesreturned = Transaction::where('trxtype_id','=', 2)
                ->where('shop_id','=', $shopId->id)
                ->where('trx_date', '>=', $date)->get();
            $shops = Shop::all();
            $datefilters = Datefilter::all();
            $totalstockreturned = Shoptransaction::where('trxtype_id', 2)
                ->where('shop_id','=', $shopId->id)
                ->where('date_of_trx', 'LIKE', "%{$date}%")
                ->selectRaw("SUM(qty) as qty")->selectRaw('product_id as product_id')
                ->groupBy('product_id')->get();
            $totalstockcollected = Shoptransaction::where('trxtype_id', 1)
                ->where('shop_id','=', $shopId->id)
                ->where('date_of_trx', 'LIKE', "%{$date}%")
                ->selectRaw("SUM(qty) as qty")->selectRaw('product_id as product_id')
                ->groupBy('product_id')->get();
            // return response()->json($stockSales);

            $stocks = Shoptransaction::where('trxtype_id', '=', 1)
                ->where('shop_id','=', $shopId->id)
                ->where('date_of_trx', 'LIKE', "%{$date}%")->get();
            $stocksRet = Shoptransaction::where('trxtype_id', 2)
                ->where('shop_id','=', $shopId->id)
                ->where('date_of_trx', 'LIKE', "%{$date}%")->get();

            return view('reports.generalshopreports', compact('stocks', 'stocksRet','shopsales','resultdate', 'shops',
                'sales', 'salesreturned', 'datefilters', 'totalstockcollected',
                'totalstockreturned'));

        }elseif($dateId == 4){
            $date = Carbon::now()->subDays(30);
            $shopsales = Transaction::where('trxtype_id', '=', 1)
                ->where('trx_date','=', $date)
                ->selectRaw("SUM(total_amount) as total_amount")
                ->selectRaw('shop_id as shop_id')
                ->groupBy('shop_id')
                ->get();
            $sales = Transaction::where('trxtype_id','=', 1)
                ->where('shop_id','=', $shopId->id)
                ->where('trx_date', '>=', $date)->get();
            $salesreturned = Transaction::where('trxtype_id','=', 2)
                ->where('shop_id','=', $shopId->id)
                ->where('trx_date', '>=', $date)->get();
            $shops = Shop::all();
            $datefilters = Datefilter::all();

            $totalstockreturned = Shoptransaction::where('trxtype_id', 2)
                ->where('shop_id','=', $shopId->id)
                ->where('date_of_trx', 'LIKE', "%{$date}%")
                ->selectRaw("SUM(qty) as qty")->selectRaw('product_id as product_id')
                ->groupBy('product_id')->get();
            $totalstockcollected = Shoptransaction::where('trxtype_id', 1)
                ->where('shop_id','=', $shopId->id)
                ->where('date_of_trx', 'LIKE', "%{$date}%")
                ->selectRaw("SUM(qty) as qty")->selectRaw('product_id as product_id')
                ->groupBy('product_id')->get();
            // return response()->json($stockSales);

            $stocks = Shoptransaction::where('trxtype_id', '=', 1)
                ->where('shop_id','=', $shopId->id)
                ->where('date_of_trx', 'LIKE', "%{$date}%")->get();
            $stocksRet = Shoptransaction::where('trxtype_id', 2)
                ->where('shop_id','=', $shopId->id)
                ->where('date_of_trx', 'LIKE', "%{$date}%")->get();

            return view('reports.generalshopreports', compact('stocks', 'stocksRet','shopsales','resultdate', 'shops',
                'sales', 'salesreturned', 'datefilters', 'totalstockcollected',
                'totalstockreturned'));

        }elseif($dateId == 5){
            $shopsales = Transaction::where('trxtype_id', '=', 1)
                ->whereMonth('trx_date','=', Carbon::now()->month)
                ->selectRaw("SUM(total_amount) as total_amount")
                ->selectRaw('shop_id as shop_id')
                ->groupBy('shop_id')
                ->get();
            $sales = Transaction::where('trxtype_id','=', 1)
                ->where('shop_id','=', $shopId->id)
                ->whereMonth('trx_date','=', Carbon::now()->month)->get();
            $salesreturned = Transaction::where('trxtype_id','=', 2)
                ->where('shop_id','=', $shopId->id)
                ->whereMonth('trx_date', '=', Carbon::now()->month)->get();
            $shops = Shop::all();
            $datefilters = Datefilter::all();
            $totalstockreturned = Shoptransaction::where('trxtype_id', 2)
                ->where('shop_id','=', $shopId->id)
                ->whereMonth('date_of_trx','=', Carbon::now()->month)
                ->selectRaw("SUM(qty) as qty")->selectRaw('product_id as product_id')
                ->groupBy('product_id')->get();
            $totalstockcollected = Shoptransaction::where('trxtype_id', 1)
                ->where('shop_id','=', $shopId->id)
                ->whereMonth('date_of_trx','=', Carbon::now()->month)
                ->selectRaw("SUM(qty) as qty")->selectRaw('product_id as product_id')
                ->groupBy('product_id')->get();
            // return response()->json($stockSales);

            $stocks = Shoptransaction::where('trxtype_id', '=', 1)
                ->where('shop_id','=', $shopId->id)
                ->whereMonth('date_of_trx','=', Carbon::now()->month)->get();
            $stocksRet = Shoptransaction::where('trxtype_id', 2)
                ->where('shop_id','=', $shopId->id)
                ->whereMonth('date_of_trx','=', Carbon::now()->month)->get();

            return view('reports.generalshopreports', compact('stocks', 'stocksRet','shopsales','resultdate', 'shops',
                'sales', 'salesreturned', 'datefilters', 'totalstockcollected',
                'totalstockreturned'));
        }elseif($dateId == 6){
            $shopsales = Transaction::where('trxtype_id', '=', 1)
                ->whereYear('trx_date','=', date('Y'))
                ->selectRaw("SUM(total_amount) as total_amount")
                ->selectRaw('shop_id as shop_id')
                ->groupBy('shop_id')
                ->get();
            $sales = Transaction::where('trxtype_id','=', 1)
                ->where('shop_id','=', $shopId->id)
                ->whereYear('trx_date','=', date('Y'))->get();
            $salesreturned = Transaction::where('trxtype_id','=', 2)
                ->where('shop_id','=', $shopId->id)
                ->whereYear('trx_date','=', date('Y'))->get();
            $shops = Shop::all();
            $datefilters = Datefilter::all();

            $totalstockreturned = Shoptransaction::where('trxtype_id', 2)
                ->where('shop_id','=', $shopId->id)
                ->whereYear('date_of_trx','=', date('Y'))
                ->selectRaw("SUM(qty) as qty")->selectRaw('product_id as product_id')
                ->groupBy('product_id')->get();
            $totalstockcollected = Shoptransaction::where('trxtype_id', 1)
                ->where('shop_id','=', $shopId->id)
                ->whereYear('date_of_trx','=', date('Y'))
                ->selectRaw("SUM(qty) as qty")->selectRaw('product_id as product_id')
                ->groupBy('product_id')->get();

            $stocks = Shoptransaction::where('trxtype_id', '=', 1)
                ->where('shop_id','=', $shopId->id)
                ->whereYear('date_of_trx','=', date('Y'))->get();
            $stocksRet = Shoptransaction::where('trxtype_id', 2)
                ->where('shop_id','=', $shopId->id)
                ->whereYear('date_of_trx','=', date('Y'))->get();
           // return response()->json($stocksRet);

            return view('reports.generalshopreports', compact('stocks', 'stocksRet','shopsales','resultdate', 'shops',
                'sales', 'salesreturned', 'datefilters', 'totalstockcollected',
                'totalstockreturned'));
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


    public function shopstockstransactions(){
        $shopId = Shop::where('user_id', Auth::user()->id)->first();
        $data = Shoptransaction::where('shop_id', $shopId->id)->get();
        $toDate = "01/01/2022";
        $fromDate = "01/01/2022";
        return view('reports.shopstockstransactions', compact('data', 'toDate', 'fromDate'));
    }
    public function exportshopstock(){
        return Excel::download(new ShopstockExp(), 'shopstock_report.xlsx');
    }

    public function shopsalesreport(){
        $shopId = Shop::where('user_id', Auth::user()->id)->first();
        $data = Transaction::where('trxtype_id', 1)->where('shop_id','=', $shopId->id)->get();
        $toDate = "01/01/2022";
        $fromDate = "01/01/2022";
        return view('reports.shopsalesreport', compact('data', 'toDate', 'fromDate'));
    }
    public function exportshopsales(){
        return Excel::download(new ShopsalesExp(), 'shopsales_report.xlsx');
    }

    public function shopsalesreturned(){
        $shopId = Shop::where('user_id', Auth::user()->id)->first();
        $data = Transaction::where('trxtype_id', 2)->where('shop_id', '=', $shopId->id)->get();
        $toDate = "01/01/2022";
        $fromDate = "01/01/2022";
        return view('reports.shopsalesreturned', compact('data', 'toDate', 'fromDate'));
    }
    public function exportshopsalesret(){
        return Excel::download(new ShopsalesretExp(), 'shopsalesreturned_report.xlsx');
    }

    public function shopinvoices(){
        $shopId = Shop::where('user_id', Auth::user()->id)->first();
        $data = Transaction::where('shop_id', '=', $shopId->id);
        $toDate = "01/01/2022";
        $fromDate = "01/01/2022";
        return view('reports.shopinvoices', compact('data', 'toDate', 'fromDate'));
    }

    public function shopstocktransearch(Request $request){
        $shopId = Shop::where('user_id', Auth::user()->id)->first();
        $toDate = $request->to_date;
        $fromDate = $request->from_date;
        $data = Shoptransaction::where('shop_id', '=', $shopId->id)->whereBetween('date_of_trx', array($request->from_date, $request->to_date))
            ->get();
        return view('reports.shopstockstransactions', compact('data', 'toDate', 'fromDate'));
    }

    public function shopsalessearch(Request $request){
        $shopId = Shop::where('user_id', Auth::user()->id)->first();

        $toDate = $request->to_date;
        $fromDate = $request->from_date;
        $data = Transaction::where('shop_id', '=', $shopId->id)->whereBetween('trx_date', array($request->from_date, $request->to_date))
            ->get();
        return view('reports.shopsalesreport', compact('data', 'toDate', 'fromDate'));
    }

    public function shopreturnedsearch(Request $request){
        $shopId = Shop::where('user_id', Auth::user()->id)->first();

        $toDate = $request->to_date;
        $fromDate = $request->from_date;
        $data = Transaction::where('shop_id', '=', $shopId->id)->whereBetween('trx_date', array($request->from_date, $request->to_date))
            ->get();
        return view('reports.shopsalesreturned', compact('data', 'toDate', 'fromDate'));
    }

    public function shopinvoicesearch(Request $request){
        $shopId = Shop::where('user_id', Auth::user()->id)->first();

        $toDate = $request->to_date;
        $fromDate = $request->from_date;
        $data = Transaction::whereBetween('trx_date', array($request->from_date, $request->to_date))->where('shop_id', $shopId->id)
            ->get();
        return view('reports.shopinvoices', compact('data', 'toDate', 'fromDate'));
    }

}
