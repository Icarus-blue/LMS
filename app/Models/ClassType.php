<?php

namespace App\Models;

use Eloquent;

class ClassType extends Eloquent
{
    //
    protected $fillable = ['name', 'code'];

    public function exam_record(){
        return $this->hasMany(ExamRecord::class);
    }

    public function grades(){
        return $this->hasMany(Grade::class);
    }
}
