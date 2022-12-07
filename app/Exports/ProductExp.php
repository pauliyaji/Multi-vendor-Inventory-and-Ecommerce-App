<?php

namespace App\Exports;

use App\Models\Productionreport;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductExp implements FromView
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
            $data = Productionreport::all();
            return view('excelfiles.product_table', [
                'data' => Productionreport::all(),
            ]);

        }
    }
}
