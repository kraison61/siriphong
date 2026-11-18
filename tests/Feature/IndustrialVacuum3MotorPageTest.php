<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class IndustrialVacuum3MotorPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_named_route_and_page_render_with_db_prices(): void
    {
        $this->assertTrue(Route::has('vacuum.3motor'));

        Category::query()->create([
            'name' => 'เครื่องดูดฝุ่นอุตสาหกรรม',
            'slug' => 'industrial-vacuum',
            'type' => 'product',
            'sort_order' => 1,
        ]);

        Product::query()->create([
            'category_id' => Category::query()->first()->id,
            'type' => 'product',
            'name' => 'เครื่องดูดฝุ่น 3 มอเตอร์ 60 ลิตร',
            'slug' => 'wp-bf-585-60',
            'price' => 6200,
            'sale_price' => 5600,
            'is_active' => true,
        ]);

        Product::query()->create([
            'category_id' => Category::query()->first()->id,
            'type' => 'product',
            'name' => 'เครื่องดูดฝุ่น 3 มอเตอร์ 80 ลิตร',
            'slug' => 'wp-bf-585-80',
            'price' => 12500,
            'sale_price' => 11200,
            'is_active' => true,
        ]);

        Page::query()->create([
            'slug' => 'industrial-vacuum-3-motor',
            'title' => 'เครื่องดูดฝุ่น 3 มอเตอร์ ราคา วิธีเลือก ซ่อม และอะไหล่ — คู่มือจากช่างซ่อม',
            'template' => 'three-motor',
            'primary_keyword' => 'เครื่องดูดฝุ่น 3 มอเตอร์',
            'intro' => 'ราคาเริ่ม {min_price} บาท',
            'meta_title' => 'เครื่องดูดฝุ่น 3 มอเตอร์ ราคา วิธีเลือก ซ่อม อะไหล่ | ศิริพงษ์',
            'meta_description' => 'ราคาเริ่ม {min_price} บาท วิธีเลือก เช็คมือสอง',
            'is_published' => true,
            'hero_image' => null,
            'blocks' => [
                'product_slugs' => ['wp-bf-585-60', 'wp-bf-585-80'],
                'summary' => [
                    'heading' => 'สรุปสั้น ๆ จากช่างต้อย',
                    'bullets' => ['ใช้ไฟบ้าน 220V'],
                ],
                'faqs' => [
                    'heading' => 'FAQ',
                    'items' => [
                        [
                            'question' => 'เครื่องดูดฝุ่น 3 มอเตอร์ ใช้ไฟบ้านได้ไหม?',
                            'answer' => 'ได้ ใช้ไฟบ้าน 220V',
                        ],
                    ],
                ],
                'schema' => [
                    'headline' => 'เครื่องดูดฝุ่น 3 มอเตอร์',
                    'description' => 'คู่มือจากช่างซ่อม',
                    'date_published' => '2026-11-18',
                    'date_modified' => '2026-11-18',
                ],
            ],
        ]);

        $response = $this->get(route('vacuum.3motor'));

        $response->assertOk()
            ->assertSee('เครื่องดูดฝุ่น 3 มอเตอร์ ราคา วิธีเลือก ซ่อม และอะไหล่', false)
            ->assertSee('ราคาเริ่ม 5,600 บาท', false)
            ->assertSee('products/wp-bf-585-80', false)
            ->assertSee('data-page="industrial-vacuum-3-motor"', false);
    }
}
