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
    }
}
