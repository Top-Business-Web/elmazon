<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class VideoParts extends Model
{
    use HasFactory;


protected $guarded = [];

//    public function exams()
//    {
//        return $this->morphMany(OnlineExam::class, 'examable');
//    }

    //start instruction for exams
    public function instruction()
    {
        return $this->morphOne(ExamInstruction::class, 'examable');
    }



    public function watches()
    {
        return $this->hasMany(VideoWatch::class, 'video_part_id','id');
    }


    public function watch()
    {
        return $this->hasOne(VideoWatch::class, 'video_part_id','id');
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id', 'id');
    }



    public function rate()
    {
        return $this->hasMany(VideoRate::class, 'video_id','id');
    }

    public function video_favorites(): HasMany{

        return $this->hasMany(VideoFavorite::class,'video_part_id','id');
    }

    /*
     * start scopes
     */


    public function scopeFavorite($query){

        return $query->whereHas('video_favorites', function ($q){
            $q->where('user_id','=',Auth::guard('user-api')->id())->where('action','=','favorite');
        })->get();
    }

    /*
     * end scopes
     */

}
