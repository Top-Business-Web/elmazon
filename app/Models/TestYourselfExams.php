<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestYourselfExams extends Model{


    use HasFactory;
    protected $fillable = [
        'questions_type',
        'user_id',
        'lesson_id',
        'subject_class_id',
        'total_time',
        'num_of_questions',
    ];


    public function user(): BelongsTo{

        return $this->belongsTo(User::class,'user_id','id');
    }

    public function lesson(): BelongsTo{

        return $this->belongsTo(Lesson::class,'lesson_id','id');
    }

    public function subject_class(): BelongsTo{

        return $this->belongsTo(SubjectClass::class,'subject_class_id','id');
    }
}
