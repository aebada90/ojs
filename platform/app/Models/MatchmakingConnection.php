<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatchmakingConnection extends Model
{
    protected $fillable = [
        'requester_profile_id',
        'receiver_profile_id',
        'status',
        'message',
    ];

    public function requester(): BelongsTo
    {
        return $this->belongsTo(MatchmakingProfile::class, 'requester_profile_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(MatchmakingProfile::class, 'receiver_profile_id');
    }
}
