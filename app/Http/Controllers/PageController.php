<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Product;
use App\Support\Schema\JsonLdBuilder;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class PageController extends Controller
{
    public function __construct(private JsonLdBuilder $schema) {}

    public function showThreeMotor(): View
    {
        $page = Page::query()
            ->with('parent')
            ->published()
            ->whereNull('parent_id')
            ->where('slug', 'industrial-vacuum-3-motor')
            ->firstOrFail();

        return $this->render($page);
    }

    public function show(string $slug): View
    {
        $page = Page::query()
            ->with('parent')
            ->published()
            ->whereNull('parent_id')
            ->where('slug', $slug)
            ->firstOrFail();

        return $this->render($page);
    }

    public function showChild(string $parentSlug, string $slug): View
    {
        $parent = Page::query()
            ->published()
            ->whereNull('parent_id')
            ->where('slug', $parentSlug)
            ->firstOrFail();

        $page = Page::query()
            ->with('parent')
            ->published()
            ->where('parent_id', $parent->id)
            ->where('slug', $slug)
            ->firstOrFail();

        return $this->render($page);
    }

    private function render(Page $page): View
    {
        $children = $page->children()->published()->get();
        $title = $page->seoTitle();
        $description = $page->seoDescription();
        $products = collect();
        $minPrice = null;

        if ($page->template === 'three-motor') {
            $slugs = $page->block('product_slugs', ['wp-bf-585-60', 'wp-bf-585-80']);
            $products = Product::query()
                ->where('type', 'product')
                ->where('is_active', true)
                ->whereIn('slug', is_array($slugs) ? $slugs : [])
                ->get()
                ->sortBy(fn (Product $product) => $product->slug === 'wp-bf-585-60' ? 0 : 1)
                ->values();

            $minPrice = $this->minProductPrice($products);
            $minLabel = $minPrice !== null ? number_format($minPrice, 0) : null;
            if ($minLabel !== null) {
                $description = str_replace('{min_price}', $minLabel, $description);
            }

            $schemaGraph = $this->schema->buildThreeMotorPageSchema($page, $products);
        } else {
            $schemaGraph = $this->schema->buildPageSchema($page);
        }

        return view($page->templateView(), compact(
            'page',
            'children',
            'schemaGraph',
            'title',
            'description',
            'products',
            'minPrice',
        ));
    }

    /**
     * @param  Collection<int, Product>  $products
     */
    private function minProductPrice(Collection $products): ?float
    {
        $prices = $products->map(function (Product $product): ?float {
            $sale = $product->sale_price !== null ? (float) $product->sale_price : null;
            $base = (float) $product->price;
            if ($sale !== null && $sale > 0 && ($base <= 0 || $sale < $base)) {
                return $sale;
            }

            return $base > 0 ? $base : null;
        })->filter();

        return $prices->isEmpty() ? null : (float) $prices->min();
    }
}
