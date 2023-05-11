<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'qualifications_title_ar',
        'qualifications_title_en',
        'qualifications_description_ar',
        'qualifications_description_en',
        'qualifications_year',
        'experience_title_ar',
        'experience_title_en',
        'experience_description_ar',
        'experience_description_en',
        'experience_year',
        'skills_title_ar',
        'skills_title_en',
        'skills_description_ar',
        'skills_description_en',
        'skills_year',
        'facebook_link',
        'youtube_link',
        'instagram_link'


    ];


}
