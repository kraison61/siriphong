<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Support\Schema\JsonLdBuilder;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function __construct(private JsonLdBuilder $schema) {}

    public function index(): View
    {
        $blogs = Blog::query()
            ->published()
            ->orderByDesc('published_at')
            ->orderBy('sort_order')
            ->paginate(9);

        $schemaGraph = $this->schema->buildBlogIndexSchema($blogs->getCollection());

        return view('frontend.blogs.index', [
            'blogs' => $blogs,
            'schemaGraph' => $schemaGraph,
            'title' => 'บทความซ่อมเครื่องดูดฝุ่น | ศิริพงษ์ เซอร์วิส',
            'description' => 'รวมบทความจากงานซ่อมจริง วิธีเช็คอาการ ราคาถอดล้าง และเคล็ดลับดูแลเครื่องดูดฝุ่นจากช่างศิริพงษ์',
        ]);
    }

    public function show(string $slug): View
    {
        $blog = Blog::query()
            ->with('relatedPortfolio')
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Blog::query()
            ->published()
            ->where('id', '!=', $blog->id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        $schemaGraph = $this->schema->buildBlogSchema($blog);

        return view('frontend.blogs.show', [
            'blog' => $blog,
            'related' => $related,
            'schemaGraph' => $schemaGraph,
            'title' => $blog->seoTitle(),
            'description' => $blog->seoDescription(),
        ]);
    }
}
