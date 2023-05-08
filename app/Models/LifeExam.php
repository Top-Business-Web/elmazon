<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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


    public function season(): BelongsTo{

        return $this->belongsTo(Season::class,'season_id','id');
    }


    public function term(): BelongsTo{

        return $this->belongsTo(Term::class,'term_id','id');
    }

    //start relation many to many life exam has many questions

    public function questions(): BelongsToMany{

        return $this->belongsToMany(Question::class,'online_exam_questions', 'life_exam_id','question_id','id','id')->inRandomOrder();
    }

}


