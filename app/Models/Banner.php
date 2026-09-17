<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'image_desktop',
        'image_tablet',
        'image_mobile',
        'url',
        'display_order',
        'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];
}