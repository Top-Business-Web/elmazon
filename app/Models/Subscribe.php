<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    use HasFactory;

    protected $fillable = ['price_in_center','price_out_center','month','term_id','season_id','free'];


    public function season(){

        return $this->belongsTo(Season::class,'season_id','id');
    }

    public function term(){

        return $this->belongsTo(Term::class,'term_id','id');
    }


}
