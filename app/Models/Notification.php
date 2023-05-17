<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'season_id',
        'term_id',
        'type',
        'video_id',
        'exam_id',
        'image',
        'user_id',
    ];

    public function term(): BelongsTo
    {

        return $this->belongsTo(Term::class, 'term_id', 'id');
    }

    public function season(): BelongsTo
    {

        return $this->belongsTo(Season::class, 'season_id', 'id');
    }

    public function user(): BelongsTo
    {

        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function notification_seen_student(): HasOne
    {
        return $this->hasOne(NotificationSeenStudent::class,'notification_id', 'id');

    }

}
