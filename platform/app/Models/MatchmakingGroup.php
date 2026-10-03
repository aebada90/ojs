<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class MatchmakingGroup extends Model
{
    protected $fillable = [
        'owner_profile_id',
        'slug',
        'title',
        'description',
        'intent',
        'city',
        'meets_at',
        'capacity',
        'is_public',
    ];

    protected function casts(): array
    {
        return [
            'meets_at' => 'datetime',
            'is_public' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $group): void {
            if (blank($group->slug)) {
                $group->slug = Str::slug($group->title).'-'.Str::lower(Str::random(4));
            }
        });
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(MatchmakingProfile::class, 'owner_profile_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(MatchmakingGroupMember::class, 'group_id');
    }
}
