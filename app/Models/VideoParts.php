<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoParts extends Model
{
    use HasFactory;

//    protected $guarded = [];

    protected $fillable = [
        'name_ar',
        'name_en',
        'note',
        'lesson_id',
        'video_link',
        'video_time'
    ];
}
