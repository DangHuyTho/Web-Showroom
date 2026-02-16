<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'brand_id',
        'category_id',
        'name',
        'slug',
        'short_description',
        'description',
        'sku',
        'price',
        'unit',
        'material',
        'size',
        'surface_type',
        'water_absorption',
        'hardness',
        'glaze_technology',
        'features',
        'applications',
        'view_3d_url',
        'meta_title',
        'meta_description',
        'sort_order',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'applications' => 'array',
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    /**
     * Get all spaces for this product
     */
    public function spaces()
    {
        return \Illuminate\Support\Facades\DB::table('product_space')
            ->where('product_id', $this->id)
            ->pluck('space_type')
            ->toArray();
    }

    /**
     * Check if product belongs to a space
     */
    public function hasSpace($space): bool
    {
        return in_array($space, $this->spaces());
    }
}
