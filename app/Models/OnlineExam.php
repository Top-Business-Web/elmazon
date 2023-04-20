<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class OnlineExam extends Model
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

        return $this->hasOne(ExamInstruction::class,'online_exam_id', 'id');
    }

    public function questions(){

        return $this->belongsToMany(Question::class,'online_exam_questions', 'online_exam_id','question_id','id','id')->inRandomOrder();
    }


    public function degrees(){

        return $this->hasMany(Degree::class,'online_exam_id','id');
    }



    public function exam_degree_depends(){

        return $this->hasMany(ExamDegreeDepends::class,'online_exam_id','id');
    }



    //relation online_exams  with user
    public function users(){

        return $this->belongsToMany(User::class,'online_exam_users','online_exam_id','user_id','id','id');

    }


    public function exams_favorites(): HasMany{

        return $this->hasMany(ExamsFavorite::class,'online_exam_id','id');
    }

}
