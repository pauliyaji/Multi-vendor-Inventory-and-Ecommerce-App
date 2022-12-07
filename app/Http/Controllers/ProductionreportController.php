<?php

namespace App\Http\Controllers;

use App\Models\Barcode;
use App\Models\Product;
use App\Models\Productionreport;
use App\Models\Productionstatus;
use App\Models\Stock;
use App\Models\Storetrx;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductionreportController extends Controller
{
    public function index(){
        $data = Productionreport::latest('id')->get();
        return view('productionreports.index', ['data'=>$data]);
    }

    public function create(){
        $barcodes = Barcode::all();
        $products = Product::all();
        $productionstatuses = Productionstatus::all();
        return view('productionreports.create', compact('barcodes', 'products',
        'productionstatuses'));
    }

    public function rawmatprice($id){
        //$data = $id;
        $data = Storetrx::where('barcode_id', $id)->where('trxtype_id', 1)->sum('total_price');

            return response()->json([
                'status'=>200,
                'data'=>$data,
            ]);

    }

    public function store(Request $request){
        //dd($request->all());
        $data = new Productionreport();
        $data->product_id = $request->product_id;
        $data->ptn_no = $request->barcode_id;
        $data->total_qty = $request->total_qty;
        $data->total_price = $request->total_price;
        $data->date_of_ptn = $request->date_of_ptn;
        $data->status = $request->status;
        $data->remarks = $request->remarks;
        $data->user_id = Auth::user()->id;
        $data->save();

            //updating the stock inventory by adding,
        $stock = Stock::where('product_id', $data->product_id)->first();
        if($stock != null){
            $oldqty = $stock->qty;
            $newqty = $oldqty + $data->total_qty;
            $stock->qty = $newqty;
            $stock->cost_price = $stock->qty * $stock->cost_price;
            $stock->selling_price = $stock->qty * $stock->selling_price;
            $stock->update();
        }else{
            $stock = new Stock();
            $stock->product_id = $data->product_id;
            $stock->qty = $data->total_qty;
            $stock->sku = $data->product_id;
            $stock->save();
        }

        return redirect()->route('productionreports.index')->with('success', 'Record successfully added');
    }

    public function show($id){
        $data = Productionreport::find($id);
        return view('productionreports.show', compact('data'));
    }

    public function edit($id){
        $data = Productionreport::find($id);
        $barcodes = Barcode::all();
        $products = Product::all();
        $productionstatuses = Productionstatus::all();

        return view('productionreports.edit', compact('data', 'barcodes', 'products',
        'productionstatuses'));

    }

    public function update(Request $request, $id){
        $data = Productionreport::find($id);
        $data->product_id = $request->product_id;
        $data->ptn_no = $request->barcode_id;
        //can not update qty and total price as it will affect the record in stocks
        //$data->total_qty = $request->total_qty;
        //$data->total_price = $request->total_price;
        $data->date_of_ptn = $request->date_of_ptn;
        $data->user_id = Auth::user()->id;
        $data->update();
        return redirect()->route('productionreports.index')->with('success', 'Record updated successfully');

    }

    public function destroy($id){
        $data = Productionreport::find($id);
        $data->delete();

        //removing the qty and total price deleted from stocks
        $stock = Stock::where('product_id', $data->product_id)->first();
        $qty = $stock->qty;
        $stock->qty = $qty - $data->total_qty;

        $stock->update();

        return redirect()->back()->with('success', 'Record deleted successfully');
    }


}
