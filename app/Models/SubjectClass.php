<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stripe\ApiOperations\All;

class SubjectClass extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function lessons(){

        return $this->hasMany(Lesson::class,'subject_class_id','id');
    }

    public function season(){

        return $this->belongsTo(Season::class,'season_id','id');
    }


    public function term(){

        return $this->belongsTo(Term::class,'term_id','id');
    }

//    public function exams()
//    {
//        return $this->morphMany(OnlineExam::class, 'examable');
//    }


    public function exams()
    {
        return $this->hasMany(OnlineExam::class,'class_id','id');
    }


    //start instruction for exams
    public function instruction()
    {
        return $this->morphOne(ExamInstruction::class, 'examable');
    }


    public function all_exams(){

        return $this->hasMany(AllExam::class,'subject_class_id','id')->whereHas('questions');
    }



    public function videos(){

        return $this->hasManyThrough(VideoParts::class,Lesson::class,'subject_class_id','lesson_id','id','id');
    }

}
