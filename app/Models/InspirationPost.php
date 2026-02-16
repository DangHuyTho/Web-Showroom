<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspirationPost extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'post_type',
        'related_products',
        'project_location',
        'project_date',
        'meta_title',
        'meta_description',
        'sort_order',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'related_products' => 'array',
        'project_date' => 'date',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];
}
