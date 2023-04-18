<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoBasicPdfUploads extends Model
{
    use HasFactory;

    protected $fillable = [

        'name_ar',
        'name_en',
        'pdf_links',
        'type',
        'video_basic_id',
        'video_resource_id'
    ];

    protected $casts = [
        'pdf_links' => 'array',
    ];

    public function videoBasic()
    {
        return $this->belongsTo(VideoBasic::class, 'video_basic_id', 'id');
    }
}
