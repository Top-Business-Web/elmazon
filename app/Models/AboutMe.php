<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutMe extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_name_ar',
        'teacher_name_en',
        'department_ar',
        'department_en',
        'qualifications_ar',
        'qualifications_en',
        'experience_ar',
        'experience_en',
        'skills_ar',
        'skills_en',
        'social'


    ];

    protected $casts = [
        'qualifications_ar' =>'json',
        'qualifications_en' =>'json',
        'experience_ar' =>'json',
        'experience_en' =>'json',
        'skills_ar' =>'json',
        'skills_en' =>'json',
        ];

}

