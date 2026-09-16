<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\Schema\JsonLdBuilder;

class HomeController extends Controller
{
    public function __construct(private JsonLdBuilder $schema) {}

    public function index()
    {
        $services = Product::query()
            ->where('type', 'service')
            ->where('is_active', true)
            ->orderBy('id')
            ->get();

        $schemaGraph = $this->schema->buildHomeSchema($services);

        return view('index', compact('schemaGraph'));
    }
}
