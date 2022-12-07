<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderdetailsController extends Controller
{
    public function index(){
        $data = Orderdetail::all();
        return view('orderdetails.index', compact('data'));
    }

    public function myorderdetails(){
        $user = Auth::user()->id;
        $shop = Shop::where('user_id', $user)->first();

        $data = Orderdetail::where('shop_id', $shop->id)->get();
        return view('orderdetails.myorderdetails', compact('data'));
    }

    public function edit($id){
        $data = Orderdetail::find($id);
        return view('orderdetails.edit', compact('data'));
    }
}
