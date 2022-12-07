<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use App\Models\Shopinventory;
use App\Models\Shoptransaction;
use App\Models\Stock;
use App\Models\Trxtype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Keygen\Keygen;
use RealRashid\SweetAlert\Facades\Alert;

class ShoptransactionsController extends Controller
{
    public function index(){
        $data = Shoptransaction::all();
        return view('shoptransactions.index', compact('data'));
    }

    public function create(){
        $shops = Shop::all();
        $trxtypes = Trxtype::all();
        $products = Product::all();

        return view('shoptransactions.create', compact('shops', 'trxtypes', 'products'));
    }

    public function restock($id){
        $shops = Shop::all();
        $trxtypes = Trxtype::all();
        $products = Product::all();
        $prd = Product::find($id);

        return view('shoptransactions.restock', compact( 'trxtypes', 'products', 'shops',
        'prd'));

    }

    public function store(Request $request){
        $alertqty = Stock::where('product_id', $request->product_id)->first();
        if($alertqty->cost_price == '0.00'){
            return redirect()->back()->with('error', 'Requested Product is not ready for sale, please contact manager');
        }
        $reqqty = $request->qty;
                if($request->trxtype_id == 1){
                    if($alertqty->qty < $request->qty){
                        return redirect()->back()->with('message', 'We do not have enough product for this transaction');
                    }
                    //Storing a new shop transaction for collected / returned
                    $prdBarcode = Product::where('id', $request->product_id)->first();
                    $data = new Shoptransaction();
                    $data->trx_no = Keygen::numeric(5)->generate();
                    $data->shop_id = $request->shop_id;
                    $data->product_id = $request->product_id;
                    $data->qty = $request->qty;
                    $data->cost_price = $alertqty->cost_price;
                    $data->total_price = $alertqty->cost_price * $request->qty;
                    $data->trxtype_id = $request->trxtype_id;
                    $data->date_of_trx = $request->date_of_trx;
                    $data->authorized_by = Auth::user()->id;
                    $data->save();

                    //  storing or adding to shop inventory
                    $oldstock = Shopinventory::where('product_id', $data->product_id)
                        ->where('shop_id', $data->shop_id)->first();
                    //dd($oldstock);
                    if($oldstock == null){
                        $newstock = new Shopinventory();
                        $newstock->shop_id = $data->shop_id;
                        $newstock->product_id = $data->product_id;
                        $newstock->barcode = $prdBarcode->product_code;
                        $newstock->qty = $data->qty;
                        $newstock->cost_price = $alertqty->cost_price;
                        $newstock->selling_price = $alertqty->selling_price;
                        $newstock->alert_qty = $alertqty->alert_qty;

                        $newstock->save();
                    }else{
                        $oldstock->qty = $data->qty + $oldstock->qty;
                        $oldstock->barcode = $prdBarcode->product_code;
                        $oldstock->cost_price = $alertqty->cost_price;
                        $oldstock->selling_price = $alertqty->selling_price;
                        $oldstock->update();
                    }
                    //updating the stock table
                    $stocks = Stock::where('product_id', $data->product_id)->first();
                    $stocks->qty = $stocks->qty - $data->qty;
                    $stocks->update();

                    return redirect()->route('shoptransactions.index')->with('success', 'Record successfully added');

                }else{
                    $alertqty = Stock::where('product_id', $request->product_id)->first();
                    $prdBarcode = Product::where('id', $request->product_id)->first();
                    //Storing a new shop transaction for collected / returned
                    $data = new Shoptransaction();
                    $data->trx_no = Keygen::numeric(5)->generate();
                    $data->shop_id = $request->shop_id;
                    $data->product_id = $request->product_id;
                    $data->qty = $request->qty;
                    $data->cost_price = $alertqty->cost_price;
                    $data->total_price = $request->qty * $alertqty->cost_price;
                    $data->trxtype_id = $request->trxtype_id;
                    $data->date_of_trx = $request->date_of_trx;
                    $data->authorized_by = Auth::user()->id;
                    $data->save();

                    //  storing or adding to shop inventory
                    $oldstock = Shopinventory::where('product_id', $data->product_id)
                        ->where('shop_id', $data->shop_id)->first();

                    $oldstock->qty = $oldstock->qty - $data->qty;
                    $oldstock->barcode = $prdBarcode->product_code;
                    $oldstock->update();

                    //updating the stock table
                    $stocks = Stock::where('product_id', $data->product_id)->first();
                    $stocks->qty = $stocks->qty + $data->qty;
                    $stocks->update();

                    return redirect()->route('shoptransactions.index')->with('success', 'Record successfully added');

                }



        }


    public function edit($id){
        $data = Shoptransaction::find($id);
        $shops = Shop::all();
        $trxtypes = Trxtype::all();
        $products = Product::all();
        $prd = Product::find($id);

        return view('shoptransactions.edit', compact('data',
            'trxtypes', 'products', 'shops',
            'prd'));
    }

    public function update(Request $request, $id){
       //
    }

}
