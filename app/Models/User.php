<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'season_id',
        'group_id',
        'country_id',
        'phone',
        'father_phone',
        'image',
        'user_status',
        'code',
        'date_start_code',
        'date_end_code',
        'login_status'
    ];




    public function season(){

        return $this->belongsTo(Season::class,'season_id','id');
    }


    public function country(){

        return $this->belongsTo(Country::class,'country_id','id');
    }

    public function suggestion()
    {
        return $this->hasMany(Suggestion::class, 'user_id', 'id');
    }

    public function onlineExam()
    {
        return $this->belongsToMany(OnlineExam::class, 'online_exam_users');
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function papel_sheet_exam_degree(){

        return $this->hasOne(PapelSheetExamDegree::class,'user_id','id');
    }


    public function exam_degree_depends(){

        return $this->hasMany(ExamDegreeDepends::class,'user_id','id');
    }


    public function exam_degree_depends_user(){

        return $this->hasOne(ExamDegreeDepends::class,'user_id','id');
    }
}
