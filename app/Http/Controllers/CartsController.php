<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Shop;
use App\Models\Shopinventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Keygen\Keygen;

class CartsController extends Controller
{
    public function add($id){

        $userid = Auth::user()->id;
        $cart_no = Keygen::numeric('5')->generate();
        $shop = Shop::where('user_id',$userid)->first();
        $data = Shopinventory::where('id', $id)->where('shop_id', $shop->id)->first();
        $cart = new Cart();
        $cart->cart_no = $cart_no;
        $cart->item = $data->product_id;
        $cart->qty = 1;
        $cart->selling_price = $data->selling_price;
        $cart->total_price = $data->selling_price * 1;
        $cart->save();


        return response()->json([
            'data'=>$cart,
        ]);

    }

}
