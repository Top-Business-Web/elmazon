<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class VideoResource extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function season(){

        return $this->belongsTo(Season::class,'season_id','id');
    }


    public function term(){

        return $this->belongsTo(Term::class,'term_id','id');
    }

    public function video_favorites(): HasMany{

        return $this->hasMany(VideoFavorite::class,'video_resource_id','id');
    }

    /*
    * start scopes
    */


    public function scopeResourceFavorite($query){

        return $query->whereHas('video_favorites', function ($q){
            $q->where('user_id','=',Auth::guard('user-api')->id())->where('action','=','favorite');
        })->whereHas('term', function ($term){
            $term->where('status', '=', 'active')->where('season_id','=',auth('user-api')->user()->season_id);
        })->where('season_id','=',auth()->guard('user-api')->user()->season_id)->get();
    }

    /*
     * end scopes
     */
}
