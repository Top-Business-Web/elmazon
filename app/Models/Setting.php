<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_lang',
        'facebook_link',
        'youtube_link',
        'twitter_link',
        'instagram_link',
        'website_link',
        'share_ar',
        'share_en',
        'videos_resource_active',
    ];


    protected $casts = [
        'share_ar' => 'json',
        'share_en' => 'json',
    ];

}
