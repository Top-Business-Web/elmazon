<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'term_id'


    ];
}


