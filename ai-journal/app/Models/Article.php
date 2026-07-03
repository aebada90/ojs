<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Article extends Model
{
    public const STATUS_DRAFT = 'draft';
    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_UNDER_REVIEW = 'under_review';
    public const STATUS_REVIEWED = 'reviewed';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_REVISION = 'revision_required';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'journal_id',
        'user_id',
        'title',
        'abstract',
        'content',
        'keywords',
        'authors',
        'status',
        'manuscript_file',
        'word_count',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'keywords' => 'array',
            'authors' => 'array',
            'submitted_at' => 'datetime',
        ];
    }

    public function journal(): BelongsTo
    {
        return $this->belongsTo(Journal::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class)->latestOfMany();
    }

    public function reviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_SUBMITTED => 'Submitted',
            self::STATUS_UNDER_REVIEW => 'Under AI Review',
            self::STATUS_REVIEWED => 'Review Complete',
            self::STATUS_ACCEPTED => 'Accepted',
            self::STATUS_REVISION => 'Revision Required',
            self::STATUS_REJECTED => 'Rejected',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            self::STATUS_ACCEPTED => 'green',
            self::STATUS_REJECTED => 'red',
            self::STATUS_REVISION => 'amber',
            self::STATUS_UNDER_REVIEW => 'blue',
            self::STATUS_REVIEWED => 'indigo',
            default => 'gray',
        };
    }
}
