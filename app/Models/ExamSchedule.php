<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamSchedule extends Model
{
    protected $guarded = ['id'];

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class,'term_id','id');
    } // end relation

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class,'season_id','id');
    } // end relation
}
