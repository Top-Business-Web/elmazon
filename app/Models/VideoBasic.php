<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoBasic extends Model
{
    use HasFactory;

    protected $fillable = [

        'name_ar',
        'name_en',
        'time',
        'video_link'

    ];
}
