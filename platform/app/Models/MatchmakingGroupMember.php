<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatchmakingGroupMember extends Model
{
    protected $fillable = [
        'group_id',
        'profile_id',
        'role',
        'status',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(MatchmakingGroup::class, 'group_id');
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(MatchmakingProfile::class, 'profile_id');
    }
}
