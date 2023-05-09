<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

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

    public function exams_favorites(): HasMany{

        return $this->hasMany(ExamsFavorite::class,'life_exam_id','id');
    }


    public function exams_degree_depends(): HasMany{

        return $this->hasMany(ExamDegreeDepends::class,'life_exam_id','id');
    }

    public function scopeLiveExamFavorite($query){

        return $query->whereHas('exams_favorites', fn(Builder $builder)=>
        $builder->where('user_id','=',Auth::guard('user-api')->id())
            ->where('action','=','favorite'))->whereHas('term', fn(Builder $builder)=>
        $builder->where('status', '=', 'active')
            ->where('season_id','=',auth('user-api')->user()->season_id))
            ->where('season_id','=',auth()->guard('user-api')->user()->season_id)
            ->get();
    }


}


