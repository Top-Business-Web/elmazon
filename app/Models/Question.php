<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function answers(){

        return $this->hasMany(Answer::class,'question_id','id')->inRandomOrder();
    }


    public function season(){

        return $this->belongsTo(Season::class,'season_id','id');
    }


    public function term(){

        return $this->belongsTo(Term::class,'term_id','id');
    }


    //start relations of exams (relation many to many)

    public function online_exams(){

        return $this->belongsToMany(OnlineExam::class,'online_exam_questions', 'question_id','online_exam_id','id','id');
    }

    public function all_exams(){

        return $this->belongsToMany(OnlineExam::class,'online_exam_questions', 'question_id','all_exam_id','id','id');
    }


    public function life_exams(){

        return $this->belongsToMany(OnlineExam::class,'online_exam_questions', 'question_id','life_exam_id','id','id');
    }



}
