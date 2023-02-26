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


    //start instruction for exams
    public function instruction()
    {
        return $this->morphOne(ExamInstruction::class, 'examable');
    }

}
