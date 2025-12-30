<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title',
        'image_url',
        'external_url',
        'category',
        'is_published',
        'display_order',
        'published_date',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'display_order' => 'integer',
        'published_date' => 'date',
    ];
}
