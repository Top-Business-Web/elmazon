<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function exams()
    {
        return $this->morphMany(OnlineExam::class, 'examable');
    }


    public function subject_class(){

        return $this->belongsTo(SubjectClass::class,'subject_class_id','id');
    }


    public function open_lessons(){

        return $this->hasMany(OpenLesson::class,'lesson_id','id');
    }


}
