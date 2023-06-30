<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportTemplate implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $newarr = [];
        return collect( $newarr);
    }
    public function headings(): array
    {

        $head_arr = ['ADMNO', 'NAME','TERM_BALANCE', 'NEXT_TERM_FEES',];
        return  $head_arr;
    }
}