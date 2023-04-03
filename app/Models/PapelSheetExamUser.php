<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PapelSheetExamUser extends Model
{
    use HasFactory;

    protected $fillable = [

        'user_id',
        'section_id',
        'papel_sheet_exam_id',
        'papel_sheet_exam_time_id'

    ];

    public function user(){

        return $this->belongsTo(User::class,'user_id','id');
    }

    public function papelSheetExam(){

        return $this->belongsTo(PapelSheetExam::class,'papel_sheet_exam_id','id');
    }

    public function papelSheetExamTime(){

        return $this->belongsTo(PapelSheetExamTime::class,'papel_sheet_exam_time_id','id');
    }
    public function sections(){

        return $this->belongsTo(Section::class,'section_id','id');
    }

}
