<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;
class UploadStudent extends Model
{
    protected $fillable = ['adm_no', 'name', 'adm_no', 'adm_no', 'upi', 'kcpe',
         'destination_class_id'];

    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function my_class() {
        return $this->belongsTo(MyClass::class);
    }

    public function destination_class() {
        return $this->belongsTo(MyClass::class, 'destination_class_id', 'id');
    }

    public function exam_record(){
        return $this->hasOne(ExamRecord::class);
    }
}
