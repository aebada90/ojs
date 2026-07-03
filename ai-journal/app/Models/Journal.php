<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Journal extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'issn',
        'description',
        'subject_area',
        'website',
        'is_active',
        'review_settings',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'review_settings' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Journal $journal) {
            if (empty($journal->slug)) {
                $journal->slug = Str::slug($journal->name);
            }
        });
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function defaultReviewSettings(): array
    {
        return [
            'check_plagiarism' => true,
            'check_methodology' => true,
            'check_ethics' => true,
            'check_references' => true,
            'min_word_count' => 3000,
            'min_abstract_words' => 150,
        ];
    }

    public function reviewSettings(): array
    {
        return array_merge($this->defaultReviewSettings(), $this->review_settings ?? []);
    }
}
