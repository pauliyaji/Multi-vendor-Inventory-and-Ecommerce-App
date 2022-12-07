<?php

namespace App\Exports;

use App\Models\Factorystore;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SupplyExp implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = Factorystore::all();
    }

    public function view(): View
    {
        {
            $data = Factorystore::all();
            //$data = Factorystore::all();
            return view('excelfiles.supplytable', [
                'data' => Factorystore::all(),
            ]);

        }
    }
}
