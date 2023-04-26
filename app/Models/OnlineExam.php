<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class OnlineExam extends Model
{
    use HasFactory;
    public int $id;

    protected $fillable = [
        'exam_type',
        'pdf_file_upload',
        'pdf_num_questions',
        'answer_pdf_file',
        'answer_video_file',
        'name_ar',
        'name_en',
        'date_exam',
        'quize_minute',
        'trying_number',
        'degree',
        'type',
        'video_id',
        'lesson_id',
        'class_id',
        'term_id',
        'season_id',
        'instruction_ar',
        'instruction_en',
    ];

    protected $casts = [
        'instruction_ar' => 'json',
        'instruction_en' => 'json',
    ];


    public function season(){

        return $this->belongsTo(Season::class,'season_id','id');
    }


    public function term(){

        return $this->belongsTo(Term::class,'term_id','id');
    }

    public function instruction(){

        return $this->hasOne(ExamInstruction::class,'online_exam_id', 'id');
    }

    public function questions(){

        return $this->belongsToMany(Question::class,'online_exam_questions', 'online_exam_id','question_id','id','id')->inRandomOrder();
    }


    public function degrees(){

        return $this->hasMany(Degree::class,'online_exam_id','id');
    }



    public function exam_degree_depends(){

        return $this->hasMany(ExamDegreeDepends::class,'online_exam_id','id');
    }



    //relation online_exams  with user
    public function users(){

        return $this->belongsToMany(User::class,'online_exam_users','online_exam_id','user_id','id','id');

    }

}
