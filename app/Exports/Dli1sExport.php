<?php

namespace App\Exports;

use App\Models\Dli1;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class Dli1sExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Dli1::all();
    }
    public function headings(): array
    {
        return [
            'jugunu',
            'f_mined',
            'm_mined',
            'tot_mined',
            'aged_mined',
            'chro_mined',
            'urban_mined',
            'needs_mined',
            'f_validated',
            'm_validated',
            'tot_validated',
            'att_fmined',
            'att_mmined',
            'att_totmined',
            'att_minedpercent',
            'fenrolled',
            'menrolled',
            'tot_enrolled',
            'att_perenrolled',
            'aged_fenrolled',
            'aged_menrolled',
            'chro_fenrolled',
            'chro_menrolled',
            'urban_fenrolled',
            'urban_menrolled',
            'needs_fenrolled',
            'needs_menrolled',
            'att_fval_enr',
            'att_mval_enr',
            'att_totval_enr',
            'amt_transpsp',
            'tot_fbeneforpsppay',
            'tot_mbeneforpsppay',
            'tot_beneforpsppay',
            'tot_agedfbeneforpsppay',
            'tot_agedmbeneforpsppay',
            'tot_chrofbeneforpsppay',
            'tot_chrombeneforpsppay',
            'tot_urbanfbeneforpsppay',
            'tot_urbanmbeneforpsppay',
            'tot_needsfbeneforpsppay',
            'tot_needsmbeneforpsppay',
            'tot_numbenepaid',
            'attrition_ntpaid',
            'attrition_ntpaid_percent',
            'dli_id',
            'state_id',
            'user_id',
            'status_id',
            'dp_id',

            'comment1',
            'comment2',
            'comment3',
            'comment4',
            'created_at',
            'updated_at',
        ];
    }

    public function export()
    {
        return Excel::download(new Dli1sExport, 'dli1s.xlsx');
    }


}
