<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class VideoBasic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'background_color',
        'time',
        'video_link',
    ];


    public function videoBasicPdf(){
        return $this->hasMany(VideoBasicPdfUploads::class);
    }



    public function video_favorites(): HasMany{

        return $this->hasMany(VideoFavorite::class,'video_basic_id','id');
    }

    /*
   * start scopes
   */


    public function scopeBasicFavorite($query){

        return $query->whereHas('video_favorites', function ($q){
            $q->where('user_id','=',Auth::guard('user-api')->id())->where('action','=','favorite');
        })->get();
    }

    /*
     * end scopes
     */

}
