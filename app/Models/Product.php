<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'stock',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Extra gallery images, in addition to the main "image" column
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('display_order');
    }

    // The image to show on cards/listings — the main image, or the first gallery image
    public function getCoverImageAttribute(): ?string
    {
        return $this->image ?? $this->images->first()?->image;
    }

    // All images together (main + gallery), for the product detail page
    public function getAllImagesAttribute(): array
    {
        $all = [];
        if ($this->image) {
            $all[] = $this->image;
        }
        foreach ($this->images as $img) {
            $all[] = $img->image;
        }
        return array_values(array_unique($all));
    }

    public function getFinalPriceAttribute(): float
    {
        return (float) ($this->sale_price ?? $this->price);
    }

    public function isInStock(): bool
    {
        return $this->stock > 0;
    }
}