<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyPlan extends Model
{
    use HasFactory;

    protected $fillable = ['title','start','end'];

    public function term(){

        return $this->belongsTo(Term::class,'term_id','id');
    }

}
