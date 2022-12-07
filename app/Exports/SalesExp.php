<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SalesExp implements FromView
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
            $data = Transaction::where('trxtype_id', '=', 1)->get();
            return view('excelfiles.sales_table', [
                'data' => Transaction::where('trxtype_id', '=', 1)->get(),
            ]);

        }
    }
}
