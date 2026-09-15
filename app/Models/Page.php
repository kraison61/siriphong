<?php

namespace App\Models;

use App\Support\MediaUrl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'slug',
        'title',
        'template',
        'primary_keyword',
        'intro',
        'hero_image',
        'blocks',
        'meta_title',
        'meta_description',
        'sort_order',
        'is_published',
        'content_updated_at',
    ];

    protected function casts(): array
    {
        return [
            'blocks' => 'array',
            'is_published' => 'boolean',
            'content_updated_at' => 'datetime',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeRoots(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    public function block(string $key, mixed $default = null): mixed
    {
        return data_get($this->blocks, $key, $default);
    }

    /**
     * @return Collection<int, object{question: string, answer: string}>
     */
    public function faqItems(): Collection
    {
        $items = $this->block('faqs.items', []);

        return collect(is_array($items) ? $items : [])
            ->filter(fn ($item) => filled($item['question'] ?? null) && filled($item['answer'] ?? null))
            ->map(fn (array $item) => (object) [
                'question' => $item['question'],
                'answer' => $item['answer'],
            ])
            ->values();
    }

    public function heroImageUrl(): ?string
    {
        if (! filled($this->hero_image)) {
            return null;
        }

        return MediaUrl::resolve($this->hero_image);
    }

    public function urlPath(): string
    {
        if ($this->parent) {
            return '/'.$this->parent->slug.'/'.$this->slug;
        }

        return '/'.$this->slug;
    }

    public function templateView(): string
    {
        return match ($this->template) {
            'pricing' => 'frontend.pages.pricing',
            'portfolio' => 'frontend.pages.portfolio',
            'general' => 'frontend.pages.general',
            default => 'frontend.pages.service',
        };
    }

    public function seoTitle(): string
    {
        return $this->meta_title ?: $this->title.' | ศิริพงษ์ เซอร์วิส';
    }

    public function seoDescription(): string
    {
        return $this->meta_description
            ?: \Illuminate\Support\Str::limit(strip_tags((string) $this->intro), 160);
    }
}
