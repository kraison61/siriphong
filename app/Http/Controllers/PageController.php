<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Support\Schema\JsonLdBuilder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function __construct(private JsonLdBuilder $schema) {}

    public function show(Request $request, string $slug): View
    {
        $page = Page::query()
            ->with('parent')
            ->published()
            ->whereNull('parent_id')
            ->where('slug', $slug)
            ->firstOrFail();

        return $this->render($page);
    }

    public function showChild(Request $request, string $parentSlug, string $slug): View
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
        $schemaGraph = $this->schema->buildPageSchema($page);
        $title = $page->seoTitle();
        $description = $page->seoDescription();

        return view($page->templateView(), compact(
            'page',
            'children',
            'schemaGraph',
            'title',
            'description',
        ));
    }
}
