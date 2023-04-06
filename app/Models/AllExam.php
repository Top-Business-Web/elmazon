<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllExam extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function season(){

        return $this->belongsTo(Season::class,'season_id','id');
    }


    public function term(){

        return $this->belongsTo(Term::class,'term_id','id');
    }


    public function instruction(){

        return $this->hasOne(ExamInstruction::class,'all_exam_id', 'id');
    }


    public function questions(){

        return $this->belongsToMany(Question::class,'online_exam_questions', 'all_exam_id','question_id','id','id')->inRandomOrder();
    }

    public function degrees(){

        return $this->hasMany(Degree::class,'online_exam_id','id');
    }

    public function exam_degree_depends(){

        return $this->hasMany(ExamDegreeDepends::class,'all_exam_id','id');
    }


    public function subject_class(){

        return $this->belongsTo(SubjectClass::class,'subject_id','id');
    }
}
