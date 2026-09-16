<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_page_shows_machine_specs_section(): void
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
            'brand' => 'WP-WELLPUMP',
            'short_description' => 'เครื่องดูดฝุ่นอุตสาหกรรมถัง 30 ลิตร',
            'description' => 'รายละเอียดสินค้า',
            'price' => 0,
            'is_active' => true,
            'is_featured' => true,
            'description' => "จุดเด่นและคุณสมบัติพิเศษ (Key Features)\n• มอเตอร์ทรงพลังแต่เสียงเงียบ\n\nอุปกรณ์มาตรฐานภายในชุด (Standard Accessories)\n• สายดูดฝุ่น-ดูดน้ำแบบยืดหยุ่น (ขนาด 40 mm)",
            'specs' => [
                ['name' => 'รุ่นสินค้า', 'value' => 'BF-575 (WP-BF-575-30 / LP-BF575)'],
                ['name' => 'กำลังมอเตอร์', 'value' => '1,200 วัตต์'],
                ['name' => 'ความจุถังเก็บ', 'value' => '30', 'unitText' => 'ลิตร'],
            ],
        ]);

        $response = $this->get('/products/wp-bf-575-30');

        $response->assertOk();
        $response->assertSee('ข้อมูลทางเทคนิค (Specifications)', false);
        $response->assertSee('รุ่นสินค้า', false);
        $response->assertSee('BF-575 (WP-BF-575-30 / LP-BF575)', false);
        $response->assertSee('กำลังมอเตอร์', false);
        $response->assertSee('1,200 วัตต์', false);
        $response->assertSee('ความจุถังเก็บ', false);
        $response->assertSee('30', false);
        $response->assertSee('ลิตร', false);
        $response->assertSee('จุดเด่นและคุณสมบัติพิเศษ (Key Features)', false);
        $response->assertSee('มอเตอร์ทรงพลังแต่เสียงเงียบ', false);
        $response->assertSee('อุปกรณ์มาตรฐานภายในชุด (Standard Accessories)', false);
        $response->assertSee('สายดูดฝุ่น-ดูดน้ำแบบยืดหยุ่น (ขนาด 40 mm)', false);
        $response->assertSee('แบรนด์ WP-WELLPUMP', false);
    }

    public function test_product_page_hides_specs_section_when_empty(): void
    {
        Product::query()->create([
            'type' => 'product',
            'name' => 'ไม่มีสเปก',
            'slug' => 'no-specs',
            'short_description' => 'ทดสอบ',
            'price' => 1000,
            'is_active' => true,
            'is_featured' => false,
            'specs' => null,
        ]);

        $response = $this->get('/products/no-specs');

        $response->assertOk();
        $response->assertDontSee('ข้อมูลทางเทคนิค (Specifications)', false);
    }
}
