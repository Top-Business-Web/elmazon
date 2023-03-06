<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineExam extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function instruction(){

        return $this->hasOne(ExamInstruction::class,'online_exam_id', 'id');
    }

    public function questions(){

        return $this->belongsToMany(Question::class,'online_exam_questions', 'online_exam_id','question_id','id','id');
    }
}
