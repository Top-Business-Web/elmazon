<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoWatch extends Model
{
    use HasFactory;

    protected  $guarded = [];


    public function video(){
        return $this->belongsTo(VideoParts::class, 'video_part_id','id');
    }



}
