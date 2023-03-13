<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    use HasFactory;

    protected $fillable = ['price_in_center','price_out_center','month','free'];
}
