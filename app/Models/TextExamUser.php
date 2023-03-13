<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextExamUser extends Model
{
    use HasFactory;

    protected $fillable = [

        'user_id',
        'question_id',
        'online_exam_id',
        'all_exam_id',
        'answer',
        'image',
        'audio',
        'answer_type',
        'status',
    ];

    protected $appends = ["image", "audio"];
}
