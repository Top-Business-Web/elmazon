<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoRate extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','video_id','action'];

    public function user(){

        return $this->belongsTo(User::class,'user_id','id');
    }

    public function video(){

        return $this->belongsTo(VideoParts::class,'video_id','id');
    }
}
