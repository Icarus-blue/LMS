<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;
class Teacher extends Model
{
    use HasFactory;
    public function subjects() {
        return $this->hasMany(SubjectTeacher::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function group() {
        return $this->belongsTo(Group::class);
    }
    public function forms(){
        return $this->hasOne(Form::class);
    }
    public function class_subject(){
        return $this->hasOne(ClassSubject::class);
    }
}
