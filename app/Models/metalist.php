<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class metalist extends Model
{
    use HasFactory;
    protected $fillable = ['stream_id', 'exam_id', 'adm_no', 'Name', 'stream_name', 'subject_name', 'marks_new', 'sbj', 'kcpe', 'vap', 'mn_mks', 'dev', 'over_grad', 'total_mark', 'Total_pts', 'stream_order', 'order_form'];
}
