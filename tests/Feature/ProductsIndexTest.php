<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_hub_shows_seo_content_and_real_prices(): void
    {
        $category = Category::query()->create([
            'name' => 'เครื่องดูดฝุ่นอุตสาหกรรม',
            'slug' => 'industrial-vacuum',
            'type' => 'product',
            'sort_order' => 1,
        ]);

        Product::query()->create([
            'category_id' => $category->id,
            'type' => 'product',
            'name' => 'WP-BF-575-30',
            'slug' => 'wp-bf-575-30',
            'short_description' => 'เครื่องดูดฝุ่นอุตสาหกรรมถัง 30 ลิตร',
            'description' => 'รายละเอียด',
            'price' => 5600,
            'is_active' => true,
            'is_featured' => true,
        ]);

        Product::query()->create([
            'category_id' => $category->id,
            'type' => 'product',
            'name' => 'WP-BF-585-80',
            'slug' => 'wp-bf-585-80',
            'short_description' => 'เครื่องดูดฝุ่นอุตสาหกรรมถัง 80 ลิตร',
            'description' => 'รายละเอียด',
            'price' => 12500,
            'is_active' => true,
            'is_featured' => false,
        ]);

        $response = $this->get('/products');

        $response->assertOk();
        $response->assertSee('เครื่องดูดฝุ่นโรงงานอุตสาหกรรม แรงดูดสูง ครบทุกขนาด พร้อมบริการซ่อมหลังการขาย', false);
        $response->assertSee('เครื่องดูดฝุ่นโรงงานอุตสาหกรรมคืออะไร', false);
        $response->assertSee('เครื่องดูดฝุ่นอุตสาหกรรม ขนาดเล็ก', false);
        $response->assertSee('เครื่องดูดฝุ่น แรงดูดสูง', false);
        $response->assertSee('เครื่องดูดฝุ่น โรงงาน อุตสาหกรรม ราคาเท่าไหร่?', false);
        $response->assertSee('5,600 บาท', false);
        $response->assertSee('12,500 บาท', false);
        $response->assertSee('คำถามที่พบบ่อยเกี่ยวกับเครื่องดูดฝุ่นโรงงานอุตสาหกรรม', false);
        $response->assertSee('ขอใบเสนอราคาเครื่องดูดฝุ่นโรงงานอุตสาหกรรม', false);
        $response->assertSee('"@type":"FAQPage"', false);
        $response->assertSee('"@type":"Service"', false);
        $response->assertSee('"@type":"Product"', false);
        $response->assertSee('"priceCurrency":"THB"', false);
        $response->assertSee('"dateModified":"2026-10-07"', false);

        preg_match('/<script type="application\/ld\+json">\s*(.*?)\s*<\/script>/s', $response->getContent(), $matches);
        $this->assertNotEmpty($matches[1] ?? null);
        $decoded = json_decode($matches[1], true);
        $this->assertIsArray($decoded);
        $this->assertSame(JSON_ERROR_NONE, json_last_error());

        $graph = collect($decoded['@graph']);
        $productNodes = $graph->where('@type', 'Product')->values();
        $this->assertCount(2, $productNodes);
        $this->assertEqualsCanonicalizing(
            ['WP-BF-575-30', 'WP-BF-585-80'],
            $productNodes->pluck('name')->all()
        );
        foreach ($productNodes as $productNode) {
            $this->assertArrayHasKey('offers', $productNode);
            $this->assertSame('Offer', $productNode['offers']['@type']);
            $this->assertSame('THB', $productNode['offers']['priceCurrency']);
            $this->assertArrayNotHasKey('aggregateRating', $productNode);
        }

        $serviceNode = $graph->firstWhere('@type', 'Service');
        $catalogItems = collect($serviceNode['hasOfferCatalog']['itemListElement'] ?? []);
        $this->assertTrue($catalogItems->every(
            fn (array $offer) => ($offer['itemOffered']['@type'] ?? null) === 'Service'
        ));
        $this->assertFalse($catalogItems->contains(
            fn (array $offer) => ($offer['itemOffered']['@type'] ?? null) === 'Product'
        ));
    }
}
