<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamDegreeDepends extends Model
{
    use HasFactory;

    protected $fillable = [

        'user_id',
        'online_exam_id',
        'all_exam_id',
        'full_degree',
        'exam_depends'
    ];

    public function online_exam(){

        return $this->belongsTo(OnlineExam::class,'online_exam_id','id');
    }


    public function all_exam(){

        return $this->belongsTo(AllExam::class,'all_exam_id','id');
    }


    public function user(){

        return $this->belongsTo(User::class,'user_id','id');
    }

}
