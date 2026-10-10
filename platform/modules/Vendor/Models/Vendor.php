<?php

namespace Modules\Vendor\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'business_name',
        'slug',
        'legal_name',
        'tax_id',
        'email',
        'phone',
        'description',
        'logo',
        'banner',
        'status',
        'is_verified',
        'rating',
        'review_count',
        'commission_rate',
        'policies',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'is_verified' => 'boolean',
            'rating' => 'decimal:2',
            'commission_rate' => 'decimal:2',
            'policies' => 'array',
            'metadata' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function stores(): HasMany
    {
        return $this->hasMany(VendorStore::class);
    }
}
