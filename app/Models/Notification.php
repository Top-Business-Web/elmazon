<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'season_id',
        'term_id',
        'image',
        'user_id',
    ];

    public function term(){

        return $this->belongsTo(Term::class,'term_id','id');
    }

    public function season(){

        return $this->belongsTo(Season::class,'season_id','id');
    }

    public function user(){

        return $this->belongsTo(User::class,'user_id','id');
    }


}
