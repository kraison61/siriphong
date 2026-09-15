<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Support\Schema\JsonLdBuilder;
use Illuminate\View\View;

class PortfolioCaseController extends Controller
{
    public function __construct(private JsonLdBuilder $schema) {}

    public function show(string $slug): View
    {
        $portfolio = Portfolio::query()
            ->with('relatedBlog')
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();

        $schemaGraph = $this->schema->buildPortfolioCaseSchema($portfolio);

        return view('frontend.portfolios.show', [
            'portfolio' => $portfolio,
            'schemaGraph' => $schemaGraph,
            'title' => $portfolio->seoTitle(),
            'description' => $portfolio->seoDescription(),
        ]);
    }
}
