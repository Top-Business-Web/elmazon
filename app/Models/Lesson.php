<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'background_color',
        'title_ar',
        'title_en',
        'name_ar',
        'name_en',
        'note',
        'subject_class_id',
    ];

    public function exams()
    {
        return $this->morphMany(OnlineExam::class, 'examable');
    }


    public function subject_class(){

        return $this->belongsTo(SubjectClass::class,'subject_class_id','id');
    }


    public function open_lessons(){

        return $this->hasMany(OpenLesson::class,'lesson_id','id');
    }


    public function videos(){

        return $this->hasMany(VideoParts::class,'lesson_id','id');
    }



}
