<?php

namespace App\Models;

use App\Support\MediaUrl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'type',
        'name',
        'slug',
        'sku',
        'brand',
        'mpn',
        'gtin13',
        'short_description',
        'description',
        'image',
        'price',
        'sale_price',
        'is_active',
        'is_featured',
        'meta_title',
        'meta_description',
        'specs',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'specs' => 'array',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews(): HasMany
    {
        return $this->reviews()->approved();
    }

    public function priceLabel(): string
    {
        if ((float) $this->price <= 0) {
            return $this->slug === 'diagnosis' ? 'ฟรี!' : 'ติดต่อขอราคา';
        }

        if ($this->sale_price !== null) {
            return 'ราคาพิเศษ';
        }

        return 'เริ่มต้น ฿'.number_format((float) $this->price, 0);
    }

    public function hasImage(): bool
    {
        return filled($this->image) && ! str_starts_with($this->image, 'bi ');
    }

    public function imageUrl(): ?string
    {
        if (! $this->hasImage()) {
            return null;
        }

        return MediaUrl::resolve($this->image);
    }

    public function iconClass(): string
    {
        if ($this->image && str_starts_with($this->image, 'bi ')) {
            return $this->image;
        }

        return match ($this->category?->slug) {
            'motor' => 'bi bi-gear-wide-connected',
            'filter' => 'bi bi-funnel-fill',
            'electrical' => 'bi bi-lightning-charge-fill',
            'pipe' => 'bi bi-bezier2',
            'maintenance' => 'bi bi-clipboard2-pulse-fill',
            default => 'bi bi-wrench-adjustable',
        };
    }
}
