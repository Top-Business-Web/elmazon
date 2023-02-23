<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamInstruction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function examable()
    {
        return $this->morphTo();
    }


//    public function all_exam(){
//
//        return $this->belongsTo(AllExam::class,'all_exam_id','id');
//    }
//
//
//    public function lesson(){
//
//        return $this->belongsTo(Lesson::class,'lesson_id','id');
//    }
//
//
//    public function video_part(){
//
//        return $this->belongsTo(VideoParts::class,'video_part_id','id');
//    }
//
//    public function subject_class(){
//
//        return $this->belongsTo(SubjectClass::class,'subject_class_id','id');
//    }

}
