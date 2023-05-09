<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
{
    protected $guarded = ['id'];

    public function term()
    {
        return $this->belongsTo(Term::class,'term_id','id');
    } // end relation

    public function season()
    {
        return $this->belongsTo(Season::class,'season_id','id');
    } // end relation
}
