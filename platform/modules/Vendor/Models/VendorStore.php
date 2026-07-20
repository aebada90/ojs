<?php

namespace Modules\Vendor\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorStore extends Model
{
    protected $fillable = [
        'vendor_id',
        'name',
        'slug',
        'store_url',
        'tagline',
        'about',
        'logo',
        'banner',
        'is_active',
        'seo',
        'settings',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'seo' => 'array',
            'settings' => 'array',
        ];
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}
