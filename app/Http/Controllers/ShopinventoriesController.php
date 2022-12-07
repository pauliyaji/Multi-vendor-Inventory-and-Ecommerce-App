<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Shopinventory;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopinventoriesController extends Controller
{
    public function index(){
       $data = Shopinventory::all();
        return view('shopinventories.index', compact('data'));
    }

    public function myshop(){
        $id = Auth::user()->id;

        $shop = Shop::where('user_id',$id)->first();

        $data = Shopinventory::where('shop_id', $shop->id)->get();
        return view('shopinventories.myshop', compact('data'));
    }

}
