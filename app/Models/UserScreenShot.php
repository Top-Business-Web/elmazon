<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserScreenShot extends Model{

    use HasFactory;

    protected $fillable = ['user_id','count_screen_shots'];

    public function user(){

        return $this->belongsTo(User::class,'user_id','id');
    }
}
