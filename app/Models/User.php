<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
     *
     *
     */

    protected $fillable = [
        'name',
        'birth_date',
        'email',
        'password',
        'birth_date',
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




    public function season(): BelongsTo{

        return $this->belongsTo(Season::class,'season_id','id');
    }


    public function country(): BelongsTo{

        return $this->belongsTo(Country::class,'country_id','id');
    }

    public function suggestion(): HasMany
    {
        return $this->hasMany(Suggestion::class, 'user_id', 'id');
    }

    public function onlineExam(): BelongsToMany{

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

    public function getJWTCustomClaims():array
    {
        return [];
    }

    public function subscriptions()
    {
        return $this->hasMany(UserSubscribe::class);
    }

    public function papel_sheet_exam_degree(): HasOne{

        return $this->hasOne(PapelSheetExamDegree::class,'user_id','id');
    }


    public function exam_degree_depends(): HasMany{

        return $this->hasMany(ExamDegreeDepends::class,'user_id','id');
    }


    public function exam_degree_depends_user(): HasOne{

        return $this->hasOne(ExamDegreeDepends::class,'user_id','id');
    }



    //relation user with online_exams
    public function online_exams(): BelongsToMany{

        return $this->belongsToMany(OnlineExam::class,'online_exam_users','user_id','online_exam_id','id','id');

    }


    public function exams_favorites(): HasMany{

        return $this->hasMany(ExamsFavorite::class,'user_id','id');
    }



}
