<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function term(){

        return $this->belongsTo(Term::class,'term_id','id');
    }

    public function season(){

        return $this->belongsTo(Season::class,'season_id','id');
    }

    public function papel_sheet(){

        return $this->belongsTo(PapelSheetExam::class,'papel_sheet_exam_id','id');
    }
}
