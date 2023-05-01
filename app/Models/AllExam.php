<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class AllExam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'exam_type',
        'background_color',
        'pdf_file_upload',
        'pdf_num_questions',
        'answer_pdf_file',
        'answer_video_file',
        'date_exam',
        'quize_minute',
        'trying_number',
        'degree',
        'season_id',
        'term_id',
        'instruction_ar',
        'instruction_en',
    ];

    protected $casts = ['instruction_ar'=> 'json','instruction_en' => 'json'];


    public function season(){

        return $this->belongsTo(Season::class,'season_id','id');
    }


    public function term(){

        return $this->belongsTo(Term::class,'term_id','id');
    }


    public function instruction(){

        return $this->hasOne(ExamInstruction::class,'all_exam_id', 'id');
    }


    public function questions(){

        return $this->belongsToMany(Question::class,'online_exam_questions', 'all_exam_id','question_id','id','id')->inRandomOrder();
    }

    public function degrees(){

        return $this->hasMany(Degree::class,'online_exam_id','id');
    }

    public function exam_degree_depends(){

        return $this->hasMany(ExamDegreeDepends::class,'all_exam_id','id');
    }


    public function subject_class(){

        return $this->belongsTo(SubjectClass::class,'subject_id','id');
    }

    public function exams_favorites(): HasMany{

        return $this->hasMany(ExamsFavorite::class,'all_exam_id','id');
    }


    /*
    * start scopes
    */

    public function scopeAllExamFavorite($query){

        return $query->whereHas('exams_favorites', function ($q){
            $q->where('user_id','=',Auth::guard('user-api')->id())->where('action','=','favorite');
        })->whereHas('term', function ($term){
            $term->where('status', '=', 'active')->where('season_id','=',auth('user-api')->user()->season_id);
        })->where('season_id','=',auth()->guard('user-api')->user()->season_id)->get();
    }

    /*
     * end scopes
     */
}
