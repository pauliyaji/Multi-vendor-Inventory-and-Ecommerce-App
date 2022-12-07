<?php

namespace App\Exports;

use App\Models\Factorystore;
use App\Models\Shoptransaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class StockExp implements FromView
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
            $data = Shoptransaction::all();
            return view('excelfiles.stock_table', [
                'data' => Shoptransaction::all(),
            ]);

        }
    }
}
