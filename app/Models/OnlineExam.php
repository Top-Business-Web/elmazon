<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineExam extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function examable()
    {
        return $this->morphTo();
    }
}
