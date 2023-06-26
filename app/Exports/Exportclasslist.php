<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class Exportclasslist implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected  $exam_id;
    protected  $stream_id;
    public function __construct(int $form_id, int $stream_id)
    {
        $this->exam_id = $form_id;
        $this->stream_id = $stream_id;
    }
    public function collection()
    {
        $res = Student::where(["my_class_id" =>  $this->stream_id])->get();
        $newarr = [];
        $i = 0;
        foreach ($res as  $val) {
            $newarr[$i] = [];
            array_push($newarr[$i], $i + 1);
            array_push($newarr[$i],"");
            array_push($newarr[$i], $val->adm_no);
            array_push($newarr[$i], $val->user->name);
            array_push($newarr[$i], $val->kcpe);
            array_push($newarr[$i],"");
            array_push($newarr[$i],"");
            array_push($newarr[$i],"");
            array_push($newarr[$i],"");
            $i++;
        }
        return  collect($newarr);
    }
    public function headings(): array
    {

        $head_arr = ['#', 'IMAGE','ADMNO', 'NAME','KCPE', '', '', '', ''];
        return  $head_arr;
    }
}