<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VideoBasic extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function videoBasicPdf(){
        return $this->hasMany(VideoBasicPdfUploads::class);
    }



    public function video_favorites(): HasMany{

        return $this->hasMany(VideoFavorite::class,'video_basic_id','id');
    }

}
