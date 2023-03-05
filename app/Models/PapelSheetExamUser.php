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
}
