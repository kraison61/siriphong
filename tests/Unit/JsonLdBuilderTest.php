<?php

namespace Tests\Unit;

use App\Models\Faq;
use App\Models\Product;
use App\Support\Schema\JsonLdBuilder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JsonLdBuilderTest extends TestCase
{
    use RefreshDatabase;

    private JsonLdBuilder $builder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->builder = new JsonLdBuilder;
    }

    public function test_product_schema_is_valid_json_with_required_fields(): void
    {
        $product = Product::factory()->create([
            'type' => 'product',
            'name' => 'Nilfisk GD930 Industrial Vacuum',
            'slug' => 'nilfisk-gd930',
            'sku' => 'GD930',
            'brand' => 'Nilfisk',
            'short_description' => 'เครื่องดูดฝุ่นอุตสาหกรรม 930W ถัง 15 ลิตร',
            'price' => 18900,
            'sale_price' => 16900,
            'is_active' => true,
            'specs' => [
                ['name' => 'กำลังไฟ', 'value' => '930', 'unitText' => 'W'],
                ['name' => 'น้ำหนัก', 'value' => '7.5', 'unitText' => 'kg'],
            ],
        ]);

        Faq::query()->create([
            'question' => 'สินค้ามีการรับประกันหรือเปล่า?',
            'answer' => 'สินค้าทุกชิ้นมีรับประกันตามเงื่อนไขของผู้ผลิต โดยทั่วไป 1 ปี สอบถามรายละเอียดที่หน้าสินค้าหรือติดต่อทีมงาน',
            'category' => 'sale',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $schema = $this->builder->buildProductSchema($product, Faq::query()->get());
        $json = json_encode($schema);
        $this->assertNotFalse($json);

        $decoded = json_decode($json, true);
        $this->assertIsArray($decoded);
        $this->assertSame('https://schema.org', $decoded['@context']);
        $this->assertGreaterThanOrEqual(4, count($decoded['@graph']));

        $productNode = collect($decoded['@graph'])->firstWhere('@type', 'Product');
        $this->assertNotNull($productNode);
        $this->assertSame($product->name, $productNode['name']);
        $this->assertNotEmpty($productNode['image']);
        $this->assertSame('16900', $productNode['offers']['price']);
        $this->assertSame('THB', $productNode['offers']['priceCurrency']);
        $this->assertSame('https://schema.org/InStock', $productNode['offers']['availability']);
    }

    public function test_service_schema_is_valid_json(): void
    {
        $service = Product::factory()->create([
            'type' => 'service',
            'name' => 'ซ่อมมอเตอร์เครื่องดูดฝุ่น',
            'slug' => 'motor-repair',
            'short_description' => 'รับซ่อม/เปลี่ยน มอเตอร์ทุกขนาด',
            'price' => 0,
            'is_active' => true,
        ]);

        $schema = $this->builder->buildServiceSchema($service, collect([$service]), collect());
        $decoded = json_decode(json_encode($schema), true);

        $this->assertIsArray($decoded);
        $serviceNode = collect($decoded['@graph'])->firstWhere('@type', 'Service');
        $this->assertNotNull($serviceNode);
        $this->assertSame($service->name, $serviceNode['name']);
    }

    public function test_home_schema_has_single_graph_without_duplicate_product_nodes(): void
    {
        $schema = $this->builder->buildHomeSchema(collect());
        $decoded = json_decode(json_encode($schema), true);

        $productNodes = collect($decoded['@graph'])->where('@type', 'Product');
        $this->assertCount(0, $productNodes);
        $this->assertNotNull(collect($decoded['@graph'])->firstWhere('@type', 'Organization'));
        $this->assertNotNull(collect($decoded['@graph'])->firstWhere('@type', 'WebSite'));
        $this->assertNotNull(collect($decoded['@graph'])->firstWhere('@type', 'LocalBusiness'));
    }

    public function test_price_format_has_no_currency_symbol_or_commas(): void
    {
        $product = Product::factory()->create([
            'type' => 'product',
            'price' => 12500.50,
            'sale_price' => null,
            'is_active' => true,
        ]);

        $schema = $this->builder->buildProductSchema($product, collect());
        $productNode = collect($schema['@graph'])->firstWhere('@type', 'Product');

        $this->assertSame('12501', $productNode['offers']['price']);
        $this->assertStringNotContainsString('฿', $productNode['offers']['price']);
        $this->assertStringNotContainsString(',', $productNode['offers']['price']);
    }

    public function test_blog_schema_has_article_person_and_faq_without_howto(): void
    {
        $blog = \App\Models\Blog::query()->create([
            'title' => 'เครื่องดูดฝุ่นไม่มีแรงดูด เกิดจากอะไร?',
            'slug' => 'vacuum-no-suction-fix',
            'excerpt' => 'เช็คเอง 3 จุด',
            'body' => '<p>เนื้อหา</p>',
            'author_name' => 'ช่างเอ',
            'author_job_title' => 'ช่างซ่อมเครื่องใช้ไฟฟ้า',
            'faqs' => [
                ['question' => 'ราคาเท่าไหร่', 'answer' => 'เริ่ม 300 บาท'],
            ],
            'is_published' => true,
            'published_at' => now()->subDays(2),
            'content_updated_at' => now()->subDay(),
            'sort_order' => 1,
        ]);

        $schema = $this->builder->buildBlogSchema($blog);
        $graph = collect($schema['@graph']);

        $this->assertNotNull($graph->firstWhere('@type', 'Article'));
        $this->assertNotNull($graph->firstWhere('@type', 'Person'));
        $this->assertNotNull($graph->firstWhere('@type', 'LocalBusiness'));
        $this->assertNotNull($graph->firstWhere('@type', 'FAQPage'));
        $this->assertNotNull($graph->firstWhere('@type', 'BreadcrumbList'));
        $this->assertNull($graph->firstWhere('@type', 'HowTo'));

        $article = $graph->firstWhere('@type', 'Article');
        $this->assertSame($blog->title, $article['headline']);
        $this->assertArrayHasKey('datePublished', $article);
        $this->assertArrayHasKey('dateModified', $article);
        $this->assertSame(['@id' => $this->builder->authorId()], $article['author']);
    }
}
