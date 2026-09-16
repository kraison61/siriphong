<?php

namespace App\Models;

use App\Support\MediaUrl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Portfolio extends Model
{
    protected $fillable = [
        'category_id',
        'category_label',
        'title',
        'slug',
        'description',
        'content',
        'fault',
        'symptom',
        'found',
        'fixed',
        'brands',
        'image',
        'before_image',
        'after_image',
        'year',
        'duration',
        'price',
        'status_label',
        'sort_order',
        'is_active',
        'meta_title',
        'meta_description',
        'related_blog_id',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function relatedBlog(): BelongsTo
    {
        return $this->belongsTo(Blog::class, 'related_blog_id');
    }

    public function categoryName(): string
    {
        return $this->category?->name
            ?: (string) ($this->category_label ?: '');
    }

    public function categorySlug(): ?string
    {
        return $this->category?->slug;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function imageUrl(): ?string
    {
        return MediaUrl::resolve($this->image)
            ?: $this->afterImageUrl()
            ?: $this->beforeImageUrl();
    }

    public function beforeImageUrl(): ?string
    {
        return MediaUrl::resolve($this->before_image);
    }

    public function afterImageUrl(): ?string
    {
        return MediaUrl::resolve($this->after_image)
            ?: MediaUrl::resolve($this->image);
    }

    public function seoTitle(): string
    {
        return $this->meta_title ?: $this->title.' | ศิริพงษ์ เซอร์วิส';
    }

    public function seoDescription(): string
    {
        return $this->meta_description
            ?: Str::limit(strip_tags((string) ($this->description ?: $this->content ?: $this->symptom ?: $this->title)), 160);
    }

    public function urlPath(): ?string
    {
        if (! filled($this->slug)) {
            return null;
        }

        return '/portfolio/'.$this->slug;
    }

    /**
     * @return array<string, mixed>
     */
    public function toCaseItem(): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'url' => $this->urlPath(),
            'category' => $this->categoryName(),
            'category_slug' => $this->categorySlug(),
            'category_label' => $this->category_label,
            'description' => $this->description,
            'content' => $this->content,
            'fault' => $this->fault,
            'symptom' => $this->symptom,
            'found' => $this->found,
            'fixed' => $this->fixed,
            'image' => $this->image ?: $this->after_image ?: $this->before_image,
            'before_image' => $this->before_image,
            'after_image' => $this->after_image ?: $this->image,
            'brands' => $this->brands,
            'days' => $this->duration,
            'year' => $this->year,
            'price' => $this->price,
            'status' => $this->status_label,
        ];
    }
}
