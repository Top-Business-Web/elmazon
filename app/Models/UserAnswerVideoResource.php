<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswerVideoResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'video_resource_id',
        'pdf_link'

    ];
}
