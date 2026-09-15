<?php

namespace App\Models;

use App\Support\MediaUrl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'primary_keyword',
        'excerpt',
        'body',
        'image',
        'image_alt',
        'image_width',
        'image_height',
        'author_name',
        'author_job_title',
        'author_description',
        'faqs',
        'meta_title',
        'meta_description',
        'related_portfolio_id',
        'is_published',
        'published_at',
        'content_updated_at',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'faqs' => 'array',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'content_updated_at' => 'datetime',
            'image_width' => 'integer',
            'image_height' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function relatedPortfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class, 'related_portfolio_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function imageUrl(): ?string
    {
        return MediaUrl::resolve($this->image);
    }

    public function seoTitle(): string
    {
        return $this->meta_title ?: $this->title.' | ศิริพงษ์ เซอร์วิส';
    }

    public function seoDescription(): string
    {
        return $this->meta_description
            ?: Str::limit(strip_tags((string) ($this->excerpt ?: $this->body)), 160);
    }

    public function urlPath(): string
    {
        return '/blog/'.$this->slug;
    }

    public function authorName(): string
    {
        return $this->author_name
            ?: (string) config('schema.author.name', 'ทีมช่างศิริพงษ์');
    }

    public function authorJobTitle(): string
    {
        return $this->author_job_title
            ?: (string) config('schema.author.job_title', 'ช่างซ่อมเครื่องใช้ไฟฟ้า');
    }

    public function authorDescription(): string
    {
        return $this->author_description
            ?: (string) config('schema.author.description', 'ช่างซ่อมเครื่องดูดฝุ่นและเครื่องใช้ไฟฟ้าในบ้าน');
    }

    public function datePublished(): ?string
    {
        return $this->published_at?->timezone('Asia/Bangkok')->format('Y-m-d');
    }

    /**
     * Manual content revision date for schema dateModified — never auto-bump.
     */
    public function dateModified(): ?string
    {
        $date = $this->content_updated_at ?: $this->published_at;

        return $date?->timezone('Asia/Bangkok')->format('Y-m-d');
    }

    /**
     * @return Collection<int, object{question: string, answer: string}>
     */
    public function faqItems(): Collection
    {
        $items = is_array($this->faqs) ? $this->faqs : [];

        return collect($items)
            ->filter(fn ($item) => filled($item['question'] ?? null) && filled($item['answer'] ?? null))
            ->map(fn (array $item) => (object) [
                'question' => $item['question'],
                'answer' => $item['answer'],
            ])
            ->values();
    }
}
