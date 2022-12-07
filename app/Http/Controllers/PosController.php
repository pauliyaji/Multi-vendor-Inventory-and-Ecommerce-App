<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Paymentmethod;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Shopinventory;
use App\Models\Transaction;
use App\Models\Trxtype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PosController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        $customers = Customer::all();

        $userid = Auth::user()->id;
        $shop = Shop::where('user_id', $userid)->first();
        if(!$shop){
            return redirect()->back()->with('message', 'You do not own a shop');
        }
        $myproducts = Shopinventory::where('shop_id', $shop->id)->get();
        $paymentmethods = Paymentmethod::all();
        $trxtypes = Trxtype::all();
        $cartitems = Cart::where('user_id', $userid)->get();
        if($myproducts)
        return view('pos.create', compact('customers', 'myproducts',
            'paymentmethods', 'trxtypes', 'cartitems'));
        else{
            return redirect()->back()->with('message', 'Sorry this shop has no stock to trade');
        }

    }

    public function store(Request $request)
    {
        dd($request->all());
    }

    public function edit($id)
    {
        //$id = Auth::user()->id;
        $shop = Shop::where('user_id', $id)->first();
        $paymentmethods = Paymentmethod::all();
        $trxtypes = Trxtype::all();

        $trxId = Transaction::find($id);
        Session::put('trx_no', $trxId->trx_no);
        $cus = Order::where('trx_no', $trxId->trx_no)->first();

        $myproducts = Orderdetail::where('trx_no', $trxId->trx_no)->get();
        //dd($products->product_id);
        foreach($myproducts as $products) {
            $add_to_cart = new Cart;
            $add_to_cart->product_id = $products->product_id;
            $add_to_cart->qty = $products->qty;
            $add_to_cart->selling_price = $products->unitprice;
            $add_to_cart->discount = 0;
            $add_to_cart->total_price = $products->qty * $products->unitprice;
            $add_to_cart->user_id = Auth::user()->id;
            $add_to_cart->shop_id = $products->shop_id;
            $add_to_cart->save();
        }
        $cartitems = Cart::all();

        return view('pos.edit', compact('cus', 'myproducts',
            'paymentmethods', 'trxtypes', 'cartitems'));


    }

    public function destroy($id){
        $data = Cart::where('user_id', $id)->delete();

        return redirect()->route('transactions.index');
    }

}
