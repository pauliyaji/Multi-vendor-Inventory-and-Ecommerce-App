<?php

namespace App\Http\Controllers;

use App\Models\Orderdetail;
use App\Models\Shop;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionsController extends Controller
{
    public function index(){
        $data = Transaction::where('trxtype_id',1)->get();
        return view('transactions.index', compact('data'));
    }

    public function myshop(){
        $user = Auth::user()->id;
        $shop = Shop::where('user_id', $user)->first();
        $data = Transaction::where('shop_id', $shop->id)->where('trxtype_id',1)->get();

        return view('transactions.myshop', compact('data'));
    }

    public function returns(){
        $data = Transaction::where('trxtype_id', 2)->get();
        return view('transactions.index', compact('data'));
    }

    public function myreturns(){
        $user = Auth::user()->id;
        $shop = Shop::where('user_id', $user)->first();
        $data = Transaction::where('shop_id', $shop->id)->where('trxtype_id',2)->get();

        return view('transactions.myreturns', compact('data'));
    }

    public function paybalance($id){
        $data = Transaction::where('order_id', $id)->first();
        return view('transactions.paybalance', compact('data',));
    }


    public function edit($id){
        $order_receipt = Orderdetail::where('order_id', $id)->get();
        $invoice_no = Orderdetail::where('order_id', $id)->first();
        $transaction = Transaction::where('order_id', $id)->first();
        return view('transactions.edit', compact('order_receipt',
            'invoice_no', 'transaction'));
    }

    public function update(Request $request,$id){
        $data = Transaction::find($id);
        $data->amount_paid = $request->amount_to_pay;
        $data->balance = $request->balance;
        $data->update();
        return redirect()->route('transactions.myshop')->with('message', 'Record updated successfully');
    }

}
