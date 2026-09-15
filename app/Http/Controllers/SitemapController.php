<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Page;
use App\Models\Portfolio;
use App\Models\Product;
use Carbon\CarbonInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = collect()
            ->merge($this->staticUrls())
            ->merge($this->pageUrls())
            ->merge($this->blogUrls())
            ->merge($this->productUrls())
            ->merge($this->serviceUrls())
            ->merge($this->categoryUrls())
            ->merge($this->portfolioUrls())
            ->unique('loc')
            ->values();

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    /**
     * @return Collection<int, array{loc: string, lastmod: ?string, changefreq: string, priority: string}>
     */
    private function staticUrls(): Collection
    {
        return collect([
            $this->entry(route('home'), null, 'daily', '1.0'),
            $this->entry(route('products.index'), null, 'weekly', '0.9'),
            $this->entry(route('blogs.index'), null, 'daily', '0.8'),
        ]);
    }

    /**
     * @return Collection<int, array{loc: string, lastmod: ?string, changefreq: string, priority: string}>
     */
    private function pageUrls(): Collection
    {
        return Page::query()
            ->published()
            ->with('parent')
            ->orderBy('sort_order')
            ->get()
            ->map(fn (Page $page) => $this->entry(
                url($page->urlPath()),
                $page->content_updated_at ?? $page->updated_at,
                'monthly',
                '0.8',
            ));
    }

    /**
     * @return Collection<int, array{loc: string, lastmod: ?string, changefreq: string, priority: string}>
     */
    private function blogUrls(): Collection
    {
        return Blog::query()
            ->published()
            ->orderByDesc('published_at')
            ->get()
            ->map(fn (Blog $blog) => $this->entry(
                url($blog->urlPath()),
                $blog->content_updated_at ?? $blog->published_at ?? $blog->updated_at,
                'weekly',
                '0.7',
            ));
    }

    /**
     * @return Collection<int, array{loc: string, lastmod: ?string, changefreq: string, priority: string}>
     */
    private function productUrls(): Collection
    {
        return Product::query()
            ->where('type', 'product')
            ->where('is_active', true)
            ->orderBy('id')
            ->get()
            ->map(fn (Product $product) => $this->entry(
                route('products.show', $product->slug),
                $product->updated_at,
                'weekly',
                '0.7',
            ));
    }

    /**
     * @return Collection<int, array{loc: string, lastmod: ?string, changefreq: string, priority: string}>
     */
    private function serviceUrls(): Collection
    {
        return Product::query()
            ->where('type', 'service')
            ->where('is_active', true)
            ->orderBy('id')
            ->get()
            ->map(fn (Product $service) => $this->entry(
                route('services.show', $service->slug),
                $service->updated_at,
                'weekly',
                '0.7',
            ));
    }

    /**
     * @return Collection<int, array{loc: string, lastmod: ?string, changefreq: string, priority: string}>
     */
    private function categoryUrls(): Collection
    {
        return Category::query()
            ->where('type', 'product')
            ->orderBy('sort_order')
            ->get()
            ->map(fn (Category $category) => $this->entry(
                route('products.category', $category->slug),
                $category->updated_at,
                'weekly',
                '0.6',
            ));
    }

    /**
     * @return Collection<int, array{loc: string, lastmod: ?string, changefreq: string, priority: string}>
     */
    private function portfolioUrls(): Collection
    {
        return Portfolio::query()
            ->active()
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->orderBy('sort_order')
            ->get()
            ->map(fn (Portfolio $portfolio) => $this->entry(
                url($portfolio->urlPath()),
                $portfolio->updated_at,
                'monthly',
                '0.6',
            ));
    }

    /**
     * @return array{loc: string, lastmod: ?string, changefreq: string, priority: string}
     */
    private function entry(
        string $loc,
        CarbonInterface|string|null $lastmod,
        string $changefreq,
        string $priority,
    ): array {
        return [
            'loc' => $loc,
            'lastmod' => $lastmod
                ? ($lastmod instanceof CarbonInterface
                    ? $lastmod->timezone('Asia/Bangkok')->toAtomString()
                    : (string) $lastmod)
                : null,
            'changefreq' => $changefreq,
            'priority' => $priority,
        ];
    }
}
