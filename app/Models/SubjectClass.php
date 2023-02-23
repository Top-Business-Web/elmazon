<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectClass extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function term(){

        return $this->belongsTo(Term::class,'term_id','id');
    }


    public function lessons(){

        return $this->hasMany(Lesson::class,'subject_class_id','id');
    }

    public function season(){

        return $this->belongsTo(Season::class,'season_id','id');
    }


    public function exams()
    {
        return $this->morphMany(OnlineExam::class, 'examable');
    }


}
