<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Faq;
use App\Models\Product;
use App\Support\Schema\JsonLdBuilder;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(private JsonLdBuilder $schema) {}

    public function index(): View
    {
        $productCategories = Category::query()
            ->where('type', 'product')
            ->orderBy('sort_order')
            ->get();

        $serviceCategories = Category::query()
            ->where('type', 'service')
            ->orderBy('sort_order')
            ->get();

        $products = Product::query()
            ->with('category')
            ->where('type', 'product')
            ->where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('id')
            ->get();

        $services = Product::query()
            ->with('category')
            ->where('type', 'service')
            ->where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('id')
            ->get();

        $pageUrl = route('products.index');
        $schemaGraph = $this->schema->buildCatalogSchema(
            $products->concat($services),
            $pageUrl,
            'สินค้าและบริการเครื่องดูดฝุ่น',
            [
                ['name' => 'หน้าแรก', 'url' => route('home')],
                ['name' => 'สินค้าและบริการ', 'url' => null],
            ],
        );

        $title = 'สินค้าและบริการ | ศิริพงษ์ เซอร์วิส';
        $description = 'จำหน่ายเครื่องดูดฝุ่นอุตสาหกรรม อะไหล่แท้ และบริการซ่อมครบวงจร ทุกยี่ห้อ รับประกันงาน';

        return view('frontend.products.index', compact(
            'productCategories',
            'serviceCategories',
            'products',
            'services',
            'title',
            'description',
            'schemaGraph',
        ));
    }

    public function show(string $slug): View
    {
        $product = Product::query()
            ->with(['category', 'images', 'approvedReviews'])
            ->where('type', 'product')
            ->where('is_active', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $faqs = Faq::query()->active()->forCategory('sale')->ordered()->get();
        $reviews = $product->approvedReviews;

        $relatedService = Product::query()
            ->where('type', 'service')
            ->where('is_active', true)
            ->where('slug', 'diagnosis')
            ->first();

        $schemaGraph = $this->schema->buildProductSchema(
            $product,
            $faqs,
            $reviews,
            $relatedService ? route('services.show', $relatedService->slug) : null,
        );

        $title = ($product->meta_title ?: $product->name).' | ศิริพงษ์ เซอร์วิส';
        $description = $product->meta_description ?: $product->short_description;

        return view('frontend.products.show', compact(
            'product',
            'faqs',
            'reviews',
            'schemaGraph',
            'title',
            'description',
        ));
    }

    public function category(string $slug): View
    {
        $category = Category::query()
            ->where('type', 'product')
            ->where('slug', $slug)
            ->firstOrFail();

        $items = Product::query()
            ->where('category_id', $category->id)
            ->where('type', 'product')
            ->where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('id')
            ->get();

        $pageUrl = route('products.category', $category->slug);
        $schemaGraph = $this->schema->buildCatalogSchema(
            $items,
            $pageUrl,
            $category->name,
            [
                ['name' => 'หน้าแรก', 'url' => route('home')],
                ['name' => 'สินค้าและบริการ', 'url' => route('products.index')],
                ['name' => $category->name, 'url' => null],
            ],
        );

        $title = $category->name.' | ศิริพงษ์ เซอร์วิส';
        $description = 'รายการ'.$category->name.' เครื่องดูดฝุ่นอุตสาหกรรมและอะไหล่';

        return view('frontend.products.category', compact(
            'category',
            'items',
            'schemaGraph',
            'title',
            'description',
        ));
    }

    public function showService(string $slug): View
    {
        $service = Product::query()
            ->with('category')
            ->where('type', 'service')
            ->where('is_active', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $faqs = Faq::query()->active()->forCategory('repair')->ordered()->get();

        $serviceOffers = Product::query()
            ->where('type', 'service')
            ->where('is_active', true)
            ->orderBy('id')
            ->get();

        $schemaGraph = $this->schema->buildServiceSchema($service, $serviceOffers, $faqs);

        $title = ($service->meta_title ?: $service->name).' | ศิริพงษ์ เซอร์วิส';
        $description = $service->meta_description ?: $service->short_description;

        return view('frontend.services.show', compact(
            'service',
            'faqs',
            'schemaGraph',
            'title',
            'description',
        ));
    }
}
