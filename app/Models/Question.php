<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function answers(){

        return $this->hasMany(Answer::class,'question_id','id');
    }


    public function season(){

        return $this->belongsTo(Season::class,'season_id','id');
    }


    public function term(){

        return $this->belongsTo(Term::class,'term_id','id');
    }


    public function online_exams(){

        return $this->belongsToMany(OnlineExam::class,'online_exam_questions', 'question_id','online_exam_id','id','id');
    }
}
