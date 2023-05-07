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


    protected $fillable = [
        'name_ar',
        'name_en',
        'background_color',
        'month',
        'note',
        'lesson_id',
        'link',
        'type',
        'video_time',
        'like_active',
        'video_time'

    ];

    //    public function exams()
    //    {
    //        return $this->morphMany(OnlineExam::class, 'examable');
    //    }


    public function comment()
    {
        return $this->hasMany(Comment::class, 'video_part_id', 'id');
    }

    //start instruction for exams
    public function instruction()
    {
        return $this->morphOne(ExamInstruction::class, 'examable');
    }



    public function watches()
    {
        return $this->hasMany(VideoOpened::class, 'video_part_id', 'id');
    }


    public function watch()
    {
        return $this->hasOne(VideoOpened::class, 'video_part_id', 'id');
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id', 'id');
    }

    public function report()
    {

        return $this->hasMany(Report::class,'video_part_id','id');
    }

    public function videoFileUpload()
    {

        return $this->hasMany(VideoFilesUploads::class,'video_part_id','id');
    }


    public function rate()
    {
        return $this->hasMany(VideoRate::class, 'video_id', 'id');
    }

    public function video_favorites(): HasMany
    {

        return $this->hasMany(VideoFavorite::class, 'video_part_id', 'id');
    }


    public function video_watches(): HasMany
    {

        return $this->hasMany(VideoOpened::class, 'video_part_id', 'id')
            ->where('status', '=', 'watched');
    }

    /*
     * start scopes
     */


    public function scopeFavorite($query)
    {

        return $query->whereHas('video_favorites', function ($q) {
            $q->where('user_id', '=', Auth::guard('user-api')->id())->where('action', '=', 'favorite');
        })->get();
    }

    /*
     * end scopes
     */
}
