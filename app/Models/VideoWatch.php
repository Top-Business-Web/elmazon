<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VideoWatch extends Model
{
    use HasFactory;

    protected  $guarded = [];


    public function video(): BelongsTo{
        return $this->belongsTo(VideoParts::class, 'video_part_id','id');
    }



}
