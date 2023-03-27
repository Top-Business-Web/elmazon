<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function seasons()
    {
        return $this->belongsTo(Season::class, 'season_id', 'id');
    }
}
