<?php

namespace App\Models;

use App\Repositories\ExamRepo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    public function subject_type() {
        return $this->belongsTo(SubjectType::class);
    }
    public function class_subject() {
        return $this->hasOne(ClassSubject::class);
    }
    public function exam_record(){
        return $this->hasMany(ExamRecord::class,'af', 'id');
    }
}
