<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoParts extends Model
{
    use HasFactory;

    public function exams()
    {
        return $this->morphMany(OnlineExam::class, 'examable');
    }

}
