<?php

namespace App\Exports;

use App\Models\Factorystore;
use App\Models\Shop;
use App\Models\Shoptransaction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class ShopstockExp implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }

    public function view(): View
    {
        {
            $shopId = Shop::where('user_id', Auth::user()->id)->first();
            $data = Shoptransaction::where('shop_id', $shopId->id)->get();
            //$data = Factorystore::all();
            return view('excelfiles.shopstock_table', [
                'data' => Shoptransaction::where('shop_id', $shopId->id)->get(),
            ]);

        }
    }
}
