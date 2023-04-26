<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'from_id',
        'file',
        'icon',
        'file_type',
        'background_color',
        'term_id',
        'season_id',
        'lesson_id',
        'subject_class_id',
        'answer_pdf_file',
        'answer_video_file',
        'answer_video_file',
    ];

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function childs() {
        return $this->hasMany(Guide::class,'from_id','id') ;
    }

    public function term(){

        return $this->belongsTo(Term::class,'term_id','id');
    }

    public function season(){

        return $this->belongsTo(Season::class,'season_id','id');
    }

    public function subjectClass(){

        return $this->belongsTo(SubjectClass::class,'subject_class_id','id');
    }

    public function lesson(){

        return $this->belongsTo(Lesson::class,'lesson_id','id');
    }

}
