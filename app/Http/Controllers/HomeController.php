<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Product;
use App\Support\Schema\JsonLdBuilder;

class HomeController extends Controller
{
    public function __construct(private JsonLdBuilder $schema) {}

    public function index()
    {
        $mapReference = Portfolio::query()
            ->whereNotNull('map_coordinates')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->first();

        [$latitude, $longitude] = $this->extractCoordinates(
            (string) ($mapReference?->map_coordinates ?? '13.754198, 100.501705')
        );

        $services = Product::query()
            ->where('type', 'service')
            ->where('is_active', true)
            ->orderBy('id')
            ->get();

        $schemaGraph = $this->schema->buildHomeSchema($services, [
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);

        return view('index', compact('schemaGraph'));
    }

    private function extractCoordinates(string $coordinates): array
    {
        $parts = array_map('trim', explode(',', $coordinates, 2));

        if (count($parts) !== 2 || ! is_numeric($parts[0]) || ! is_numeric($parts[1])) {
            return ['13.754198', '100.501705'];
        }

        return [(string) $parts[0], (string) $parts[1]];
    }
}
