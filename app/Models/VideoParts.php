<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoParts extends Model
{
    use HasFactory;


protected $guarded = [];

    public function exams()
    {
        return $this->morphMany(OnlineExam::class, 'examable');
    }

    //start instruction for exams
    public function instruction()
    {
        return $this->morphOne(ExamInstruction::class, 'examable');
    }



    public function watches()
    {
        return $this->hasMany(VideoWatch::class, 'video_part_id','id');
    }


}
