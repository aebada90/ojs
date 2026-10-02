<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class MatchmakingProfile extends Model
{
    protected $fillable = [
        'user_id',
        'slug',
        'display_name',
        'headline',
        'bio',
        'city',
        'country',
        'age',
        'intent',
        'interests',
        'languages',
        'avatar_url',
        'is_public',
        'open_to_connect',
        'company',
        'role_title',
        'linkedin_url',
        'nexora_url',
    ];

    protected function casts(): array
    {
        return [
            'interests' => 'array',
            'languages' => 'array',
            'is_public' => 'boolean',
            'open_to_connect' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $profile): void {
            if (blank($profile->slug)) {
                $base = Str::slug($profile->display_name ?: 'member');
                $profile->slug = $base.'-'.Str::lower(Str::random(5));
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sentConnections(): HasMany
    {
        return $this->hasMany(MatchmakingConnection::class, 'requester_profile_id');
    }

    public function receivedConnections(): HasMany
    {
        return $this->hasMany(MatchmakingConnection::class, 'receiver_profile_id');
    }

    public function ownedGroups(): HasMany
    {
        return $this->hasMany(MatchmakingGroup::class, 'owner_profile_id');
    }

    public function intentLabel(): string
    {
        return config('connect.intents.'.$this->intent, ucfirst((string) $this->intent));
    }
}
