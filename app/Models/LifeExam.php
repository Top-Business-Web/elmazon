<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LifeExam extends Model
{
    use HasFactory;

    protected $fillable = [
       'name_ar',
       'name_en',
       'date_exam',
       'time_start',
       'time_end',
        'quiz_minute',
        'trying',
        'degree',
        'season_id',
        'term_id',
        'note',

    ];


    public function season(){

        return $this->belongsTo(Season::class,'season_id','id');
    }


    public function term(){

        return $this->belongsTo(Term::class,'term_id','id');
    }

    //start relation many to many life exam has many questions

    public function questions(){

        return $this->belongsToMany(Question::class,'online_exam_questions', 'life_exam_id','question_id','id','id');
    }

}


