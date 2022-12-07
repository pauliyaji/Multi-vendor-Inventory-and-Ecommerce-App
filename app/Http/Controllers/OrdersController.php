<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Orderdetail;
use App\Models\Paymentmethod;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Shopinventory;
use App\Models\Transaction;
use App\Models\Trxtype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Keygen\Keygen;


class OrdersController extends Controller
{
    public function index(){
        $customers = Customer::all();

        $id = Auth::user()->id;
        $shop = Shop::where('user_id',$id)->first();
        $myproducts = Shopinventory::where('shop_id', $shop->id)->get();
        $paymentmethods = Paymentmethod::all();
        $trxtypes = Trxtype::all();
        //Last order details
        $lastID = Orderdetail::max('order_id');
        $order_receipt = Orderdetail::where('order_id', $lastID)->get();

        return view('pos.create', compact('customers', 'myproducts',
            'paymentmethods', 'trxtypes', 'order_receipt'));
    }

    public function store(Request $request){
       // return $request->all();

        $id = Auth::user()->id;
        $shop = Shop::where('user_id',$id)->first();

        //Order model
        $orders = new Order();
        $orders->trx_no = Keygen::numeric('5')->generate();
        $orders->shop_id = $shop->id;
        $orders->customer_id = $request->customer_id;
        $orders->save();
        $order_id = $orders->id;

        //Order details model
        for($product_id = 0; $product_id < count($request->product_id); $product_id++){
           $order_details = new Orderdetail();
           $order_details->shop_id = $orders->shop_id;
            $order_details->trx_no = $orders->trx_no;
            $order_details->order_id = $order_id;
           $order_details->product_id = $request->product_id[$product_id];
           $order_details->unitprice = $request->selling_price[$product_id];
           $order_details->qty = $request->qty[$product_id];
           $order_details->discount = $request->discount[$product_id];
           $order_details->amount = $request->total_price[$product_id];
           $order_details->save();

           // Removing from the shop inventory

                $mystock = Shopinventory::where('product_id', $request->product_id[$product_id])
                    ->where('shop_id', $request->shop_id[$product_id])->first();
                $mystock->qty = $mystock->qty - $request->qty[$product_id];
                $mystock->update();

        }
        // Transaction model
        $transaction = new Transaction();
        $transaction->trx_no = $orders->trx_no;
        $transaction->order_id = $order_id;
        $transaction->amount_paid = $request->amount_paid;
        $transaction->balance = $request->balance;
        $transaction->total_amount = $request->total_amount;
        $transaction->paymentmethod_id = $request->paymentmethod_id;
        $transaction->trxtype_id = 1;
        $transaction->user_id = Auth::user()->id;
        $transaction->shop_id = $shop->id;
        $transaction->trx_date = date('Y-m-d');
        $transaction->save();


        //emptying the cart
        Cart::where('user_id', Auth::user()->id)->delete();

        //Order history
        $products = Product::all();
        $order_details = Orderdetail::where('order_id', $order_id)->get();
        $orderedBy = Order::where('id', $order_id)->get();
        $customers = Customer::all();
        $myproducts = Shopinventory::where('shop_id', $shop->id)->get();

        $paymentmethods = Paymentmethod::all();
        $trxtypes = Trxtype::all();

        //Last order details
        $lastID = Orderdetail::max('order_id');
        $order_receipt = Orderdetail::where('order_id', $lastID)->get();

        //return redirect()->route('pos.create');
       return view('pos.create', [
            'products'=>$products,
            'order_details'=>$order_details,
            'customer_orders'=>$orderedBy,
            'customers'=>$customers,
            'myproducts'=>$myproducts,
            'paymentmethods'=>$paymentmethods,
            'trxtypes'=>$trxtypes,
           'order_receipt'=>$order_receipt,
        ])->with('success', 'Orders successfully recorded');

    }

    public function returnAdd(Request $request){
        $data = $request->all();
      //  dd($data);
        // return $request->all();
        $userid = Auth::user()->id;
       $shop = Shop::where('user_id',$userid)->first();

        //Order model
        $orders = new Order();
        $orders->trx_no = Keygen::numeric('5')->generate();
        $orders->shop_id = $shop->id;
        $orders->customer_id = $request->customer_id;
        $orders->save();
        $order_id = $orders->id;

        //Order details model
        for($product_id = 0; $product_id < count($request->product_id); $product_id++){
            $order_details = new Orderdetail();
            $order_details->shop_id = $orders->shop_id;
            $order_details->trx_no = $orders->trx_no;
            $order_details->order_id = $order_id;
            $order_details->product_id = $request->product_id[$product_id];
            $order_details->unitprice = $request->selling_price[$product_id];
            $order_details->qty = $request->qty[$product_id];
            $order_details->discount = $request->discount[$product_id];
            $order_details->amount = $request->total_price[$product_id];
            $order_details->save();

            // Removing from the shop inventory

                $mystock = Shopinventory::where('product_id', $request->product_id[$product_id])
                    ->where('shop_id', $request->shop_id[$product_id])->first();
                $mystock->qty = $mystock->qty + $request->qty[$product_id];
                $mystock->update();

        }
        // Transaction model
        $transaction = new Transaction();
        $transaction->trx_no = $orders->trx_no;
        $transaction->order_id = $order_id;
        $transaction->amount_paid = $request->amount_paid;
        $transaction->balance = $request->balance;
        $transaction->total_amount = $request->total_amount;
        $transaction->paymentmethod_id = $request->paymentmethod_id;
        $transaction->trxtype_id = 2;
        $transaction->user_id = Auth::user()->id;
        $transaction->shop_id = $shop->id;
        $transaction->trx_date = date('Y-m-d');
        $transaction->save();


        //emptying the cart
        Cart::where('user_id', Auth::user()->id)->delete();

        //Order history
        $products = Product::all();
        $order_details = Orderdetail::where('order_id', $order_id)->get();
        $orderedBy = Order::where('id', $order_id)->get();
        $customers = Customer::all();
        $myproducts = Shopinventory::where('shop_id', $shop->id)->get();

        $paymentmethods = Paymentmethod::all();
        $trxtypes = Trxtype::all();

        //Last order details
        $lastID = Orderdetail::max('order_id');
        $order_receipt = Orderdetail::where('order_id', $lastID)->get();

        //return redirect()->route('pos.create');
        return view('pos.create', [
            'products'=>$products,
            'order_details'=>$order_details,
            'customer_orders'=>$orderedBy,
            'customers'=>$customers,
            'myproducts'=>$myproducts,
            'paymentmethods'=>$paymentmethods,
            'trxtypes'=>$trxtypes,
            'order_receipt'=>$order_receipt,
        ])->with('success', 'Orders successfully recorded');


    }
}
