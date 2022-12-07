<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shopinventory;
use App\Models\Shoptransaction;
use App\Models\Stock;
use Illuminate\Http\Request;

class StocksController extends Controller
{
    public function index(){
        $data = Stock::all();
        return view('stocks.index', compact('data'));
    }

    public function create(){
        return view('stocks.create');
    }

    public function checkqty($id){
        $data = Stock::where('product_id', $id)->first();
        if($data != null){
            return response()->json([
                'status'=>200,
                'data'=>$data,
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Product not Available!',
            ]);
        }

    }

    public function store(Request $request){
        $data = new Stock();
        $data->product_id = $request->product_id;
        $data->qty = $request->qty;
        $data->sku = $request->product_id;
        $data->cost_price = $request->cost_price;
        $data->selling_price = $request->selling_price;
        $data->update();

        return redirect()->route('stocks.index')->with('success', 'record added successfully');
    }

    public function edit($id){
        $data = Stock::find($id);
        $products = Product::all();
        return view('stocks.edit', compact('data', 'products'));
    }

    public function update(Request $request, $id){
        $data = Stock::find($id);
        $data->cost_price = $request->cost_price;
        $data->selling_price = $request->selling_price;
        $data->alert_qty = $request->alert_qty;
        $data->update();

        //UPDATING RECORDS IN ANOTHER TABLE USING A WHERE CLAUSE
        $shops = Shopinventory::where('product_id', $data->product_id)->update([
            'cost_price' => $request->cost_price,
            'selling_price' => $request->selling_price,
            'alert_qty' => $request->alert_qty,
        ]);

        $shops = Shoptransaction::where('product_id', $data->product_id)->update([
            'cost_price' => $request->cost_price,
        ]);

        return redirect()->route('stocks.index')->with('success', 'Record updated successfully');

    }

    public function show($id){
        $data = Stock::find($id);
        return view('stocks.show', compact('data'));
    }

    public function destroy($id){
        $data = Stock::find($id);
        $data->delete();

        return redirect()->back()->with('success', 'Record deleted successfully');
    }

}
