<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use phpDocumentor\Reflection\Types\Null_;

class ExportCustomExcel implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected  $exam_id;
    protected  $stream_id;
    protected  $values;
    public function __construct(int $form_id, int $stream_id, array $values)
    {
        $this->exam_id = $form_id;
        $this->stream_id = $stream_id;
        $this->values = $values;
    }
    public function collection()
    {

        $res = Student::where(["my_class_id" =>  $this->stream_id])->get();
        $newarr = [];
        $i = 0;
        foreach ($res as  $val) {

            $newarr[$i] = [];
            array_push($newarr[$i], $val->adm_no);
            array_push($newarr[$i], "");
            array_push($newarr[$i], $val->kcpe);
            array_push($newarr[$i], $val->user->gender);
            array_push($newarr[$i], "");  //Gurdain's Secondary
            array_push($newarr[$i], ""); //Is Day Scholar
            array_push($newarr[$i], $val->user->name); //name
            array_push($newarr[$i], "");//Primary School
            array_push($newarr[$i], "");//British Certificate
            array_push($newarr[$i], "");//House
            array_push($newarr[$i], "");//Gurdain's Email
            array_push($newarr[$i], "");//Has Passport
            array_push($newarr[$i], "");//UPI
            array_push($newarr[$i], "");//KCPE Index
            array_push($newarr[$i], "");//Date of Birth
            array_push($newarr[$i], "");//Gurdain's Name
            array_push($newarr[$i], "");//Relation to
            array_push($newarr[$i], "");//Stream
            array_push($newarr[$i], "");//KCPE Year
            array_push($newarr[$i], "");//Date of
            array_push($newarr[$i], "");//Gurdain's Primary
            array_push($newarr[$i], "");//Home Address
            $i++;
        }


        return  collect($newarr);
    }
    public function headings(): array
    {
        return  $this->values;
    }
}