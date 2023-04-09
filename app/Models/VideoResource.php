<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoResource extends Model
{
    use HasFactory;

    protected $fillable = [

        'name_ar',
        'name_en',
        'time',
        'video_link',
        'season_id',
        'term_id'
    ];

    public function season(){

        return $this->belongsTo(Season::class,'season_id','id');
    }


    public function term(){

        return $this->belongsTo(Term::class,'term_id','id');
    }
}
