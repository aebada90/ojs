<?php

namespace Modules\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Vendor\Models\Vendor;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'category_id',
        'name',
        'slug',
        'sku',
        'summary',
        'description',
        'price',
        'compare_at_price',
        'currency',
        'stock',
        'track_inventory',
        'status',
        'is_featured',
        'rating',
        'review_count',
        'images',
        'variations',
        'shipping',
        'seo',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'compare_at_price' => 'decimal:2',
            'track_inventory' => 'boolean',
            'is_featured' => 'boolean',
            'rating' => 'decimal:2',
            'images' => 'array',
            'variations' => 'array',
            'shipping' => 'array',
            'seo' => 'array',
            'metadata' => 'array',
        ];
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}
