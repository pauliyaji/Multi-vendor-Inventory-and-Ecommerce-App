<?php

namespace App\Http\Livewire;


use App\Models\Cart;
use App\Models\Customer;
use App\Models\Orderdetail;
use App\Models\Paymentmethod;
use App\Models\Shop;
use App\Models\Shopinventory;
use App\Models\Trxtype;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Order extends Component
{

    public $orders, $products, $customers, $paymentmethods, $trxtypes, $order_receipt, $trx_date = [], $product_code, $message = '', $productIncart;

    public $amount_paid = 0, $balance = '';
    public $discountAdd= 0;

    public function mount(){
        $userid = Auth::user()->id;
        $shop = Shop::where('user_id',$userid)->first();
        $this->products = Shopinventory::where('shop_id', $shop->id)->get();
        $this->customers = Customer::orderBy('id', 'DESC')->get();
        $this->paymentmethods = Paymentmethod::all();
        $this->trxtypes = Trxtype::all();
        $this->productIncart = Cart::where('user_id', $userid)->orderBy('id','DESC')->get();

        //Last order details
        $lastID = Orderdetail::latest('id')->first();
        if($lastID){
        $this->order_receipt = Orderdetail::where('order_id', $lastID->order_id)->get();
        $this->trx_date = Orderdetail::where('order_id', $lastID->order_id)->first();
        }
    }

    public function InsertoCart(){
       $barC = ltrim($this->product_code, 'g');
        $shop = Shop::where('user_id',Auth::user()->id)->first();
            $countProduct = Shopinventory::where('product_id', $this->product_code)
                ->orWhere('barcode', $barC)
                ->where('shop_id', $shop->id)->first();

        if($countProduct == null){
            return session()->flash('error', 'Product not found.');
        //    return $this->message = 'Product not found';
        }elseif($countProduct->qty == 0){
            return session()->flash('error', 'Product not available.');
            //return $this->message = 'Product not available';
        }
        $countCartProduct = Cart::where('product_id', $this->product_code)->count();
        if($countCartProduct > 0){
            return $this->message =  'Product '.$countProduct->products->name. ' already exist in cart please add qty';
        }
            $add_to_cart = new Cart;
            $add_to_cart->product_id = $countProduct->product_id;
            $add_to_cart->qty = 1;
            $add_to_cart->selling_price = $countProduct->selling_price;
            $add_to_cart->discount = 0;
            $add_to_cart->total_price = 1 * $countProduct->selling_price;
            $add_to_cart->user_id = Auth::user()->id;
            $add_to_cart->shop_id = $countProduct->shop_id;
            $add_to_cart->save();

            $this->productIncart->prepend( $add_to_cart);
            //$this->productIncart->push($add_to_cart);
            $this->product_code = '';
            return $this->message = 'Product Added Successfully';
    }

    public function incrementQty($cartId){
       $carts = Cart::find($cartId);
       $mystock = Shopinventory::where('product_id', $carts->product_id)
           ->where('shop_id', $carts->shop_id)->first();
       $carts->increment('qty', 1);
       if($carts->qty < $mystock->qty){
           $updatePrice = $carts->qty * $carts->selling_price;
           $carts->update(['total_price'=>$updatePrice, 'discount'=>0]);
       }else{
           session()->flash('error', 'Total available qty is '.$mystock->qty);
           //return $this->message = 'Total available qty is '.$mystock->qty;
       }

       $this->mount();
    }

    public function mQty($cartId){
        $carts = Cart::find($cartId);
        dd($carts);
        $mystock = Shopinventory::where('product_id', $carts->product_id)
            ->where('shop_id', $carts->shop_id)->first();
        $carts->increment('qty', 1);
        if($carts->qty < $mystock->qty){
            $updatePrice = $carts->qty * $carts->selling_price;
            $carts->update(['total_price'=>$updatePrice, 'discount'=>0]);
        }else{
            session()->flash('error', 'Total available qty is '.$mystock->qty);
            //return $this->message = 'Total available qty is '.$mystock->qty;
        }

        $this->mount();
    }

    public function decrementQty($cartId){
        $carts = Cart::find($cartId);
        if($carts->qty == 1){
            return session()->flash('info', 'Product '. $carts->products->name. ' Qty can not be less than 1, add qty or remove product from cart');
        }
        $carts->decrement('qty', 1);
        $updatePrice = $carts->qty * $carts->selling_price;
        $carts->update(['total_price'=>$updatePrice, 'discount'=>0]);
        $this->mount();
    }

    public function incrementDisc($cartId){
        $carts = Cart::find($cartId);
        $carts->increment('discount', 0.5);
        $newTotal_price = $carts->qty * $carts->selling_price;
        $amount = (($newTotal_price * $carts->discount) / 100);
        $updatePrice = round($newTotal_price - $amount, 2);
        $carts->update(['total_price'=>$updatePrice]);
        $this->mount();
    }

    public function decrementDisc($cartId){
        $carts = Cart::find($cartId);
        if($carts->discount == 0){
            return session()->flash('info', 'Product '. $carts->products->name. ' Qty can not be less than 1, add qty or remove product from cart');
        }
        $carts->decrement('discount', 0.5);
        $amount = (($carts->selling_price * $carts->discount) / 100);
        $updatePrice = round($carts->total_price + $amount, 2);
        $carts->update(['total_price'=>$updatePrice]);
        $this->mount();
    }

    public function disc($cartId){
        if($this->discountAdd > 0){
            $carts = Cart::find($cartId);
            $amount = (($carts->total_price * $this->discountAdd) / 100);
            $updatePrice = $carts->total_price - $amount;
            $carts->update(['total_price'=>$updatePrice, 'discount'=>$this->discountAdd]);
            $this->mount();
        }
    }

    public function removeProduct($cartId){
        $deleteCart = Cart::find($cartId);
        $deleteCart->delete();
        $this->message = 'Product removed from cart successfully';

        $this->productIncart = $this->productIncart->except($cartId);
    }

    public function doCancel(){
        //emptying the cart
        Cart::where('user_id', Auth::user()->id)->delete();
    }

    public function render()
    {
       if($this->amount_paid != ''){
           $remainder = $this->productIncart->sum('total_price') - $this->amount_paid;
           $this->balance = $remainder;
       }

        return view('livewire.order');
    }



}
