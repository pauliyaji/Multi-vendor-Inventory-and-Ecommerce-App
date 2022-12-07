<?php

namespace App\Exports;

use App\Models\Shop;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class ShopsalesretExp implements FromView
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
            $data = Transaction::where('trxtype_id', 2)->where('shop_id', '=', $shopId->id)->get();
            return view('excelfiles.shopsalesreturned_table', [
                'data' =>Transaction::where('trxtype_id', 2)->where('shop_id', '=', $shopId->id)->get(),
            ]);

        }
    }
}
