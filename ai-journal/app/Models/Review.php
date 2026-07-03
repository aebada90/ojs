<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';

    public const RECOMMEND_ACCEPT = 'accept';
    public const RECOMMEND_MINOR = 'minor_revision';
    public const RECOMMEND_MAJOR = 'major_revision';
    public const RECOMMEND_REJECT = 'reject';

    protected $fillable = [
        'article_id',
        'status',
        'recommendation',
        'overall_score',
        'criteria_scores',
        'feedback',
        'flags',
        'summary',
        'editor_notes',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'criteria_scores' => 'array',
            'feedback' => 'array',
            'flags' => 'array',
            'overall_score' => 'decimal:2',
            'completed_at' => 'datetime',
        ];
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function recommendationLabel(): string
    {
        return match ($this->recommendation) {
            self::RECOMMEND_ACCEPT => 'Accept',
            self::RECOMMEND_MINOR => 'Minor Revision',
            self::RECOMMEND_MAJOR => 'Major Revision',
            self::RECOMMEND_REJECT => 'Reject',
            default => 'Pending',
        };
    }

    public function recommendationColor(): string
    {
        return match ($this->recommendation) {
            self::RECOMMEND_ACCEPT => 'green',
            self::RECOMMEND_MINOR => 'amber',
            self::RECOMMEND_MAJOR => 'orange',
            self::RECOMMEND_REJECT => 'red',
            default => 'gray',
        };
    }
}
