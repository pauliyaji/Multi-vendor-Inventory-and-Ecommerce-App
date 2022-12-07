<?php

namespace App\Exports;

use App\Models\Factorystore;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InvoiceExp implements FromView
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
            $data = Transaction::select('');
            //$data = Factorystore::all();
            return view('excelfiles.supplytable', [
                'data' => Factorystore::all(),
            ]);

        }
    }
}
