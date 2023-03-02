<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PapelSheetExam extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function papel_sheet_exam_time(){

        return $this->hasMany(PapelSheetExamTime::class,'papel_sheet_exam_id','id');
    }



    public function season(){

        return $this->belongsTo(Season::class,'season_id','id');
    }


    public function term(){

        return $this->belongsTo(Term::class,'term_id','id');
    }
}
