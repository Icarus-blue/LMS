<?php

namespace App\Exports;

use App\Models\metalist;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportMetalist implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected  $exam_id;
    protected  $stream_id;
    public function __construct(int $exam_id, int $stream_id)
    {
        $this->exam_id = $exam_id;
        $this->stream_id = $stream_id;
    }
    public function collection()
    {
        $res = metalist::where(["stream_id" =>  $this->stream_id, "exam_id" => $this->exam_id])->get();
        $newarr = [];
        $i = 0;
        foreach ($res as  $val) {
            $newarr[$i] = [];
            array_push($newarr[$i], $i + 1);
            foreach (json_decode(json_encode($val), true) as $x_key => $each_val) {
                if ($x_key == "stream_id" || $x_key == "subject_name" || $x_key == "id" || $x_key == "exam_id" || $x_key == "created_at" || $x_key == "updated_at") {
                    continue;
                } else if ($x_key == "marks_new") {
                    $subject_arr = explode(",", $each_val);
                    foreach ($subject_arr as $value) {
                        array_push($newarr[$i], $value);
                    }
                } else {
                    array_push($newarr[$i], $each_val);
                }
            }
            $i++;
        }

        return  collect($newarr);
    }

    public function headings(): array
    {
        $res = metalist::where(["stream_id" => $this->stream_id, "exam_id" => $this->exam_id])->first()->subject_name;
        $subject_str = substr($res, 0, strlen($res) - 1);
        $subject_arr = explode(",", $subject_str);
        $head_arr = ['#', 'adm_no', 'Name', 'stream_name'];
        foreach ($subject_arr  as $val) {
            array_push($head_arr, $val);
        }
        array_push($head_arr, 'sbj', 'kcpe', 'vap', 'mn_mks', 'dev', 'over_grad', 'total_mark', 'Total_pts', 'stream_order', 'order_form');
        return  $head_arr;
    }
}
