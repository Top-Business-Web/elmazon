<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PapelSheetExamTime extends Model
{
    use HasFactory;

    protected $fillable  = [
        'from',
        'to',
        'papel_sheet_exam_id'
    ];

    public function papel_sheet_exam(){

        return $this->belongsTo(PapelSheetExam::class,'papel_sheet_exam_id','id');
    }
}
