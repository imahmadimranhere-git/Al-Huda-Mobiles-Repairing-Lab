<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsUpdate extends Model
{
    protected $fillable = [
        'title',
        'content',
        'published_date',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'published_date' => 'date',
    ];
}