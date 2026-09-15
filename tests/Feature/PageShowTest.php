<?php

namespace Tests\Feature;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_hub_and_child_pages_render(): void
    {
        $hub = Page::query()->create([
            'slug' => 'vacuum-repair',
            'title' => 'รับซ่อมเครื่องดูดฝุ่นอุตสาหกรรม ทุกยี่ห้อ',
            'template' => 'service',
            'primary_keyword' => 'ซ่อมเครื่องดูดฝุ่นอุตสาหกรรม',
            'intro' => "รับซ่อมงานหนัก\nช่วงราคา 1,500–12,000\n1–3 วัน",
            'is_published' => true,
            'sort_order' => 1,
            'blocks' => [
                'symptoms' => ['items' => []],
                'faqs' => ['items' => []],
            ],
        ]);

        Page::query()->create([
            'parent_id' => $hub->id,
            'slug' => 'car-care',
            'title' => 'รับซ่อมเครื่องดูดฝุ่นคาร์แคร์ ทุกยี่ห้อ',
            'template' => 'service',
            'primary_keyword' => 'ซ่อมเครื่องดูดฝุ่นคาร์แคร์',
            'intro' => "รับซ่อมเครื่องดูดน้ำคาร์แคร์\nช่วงราคา 1,800–9,500 บาท\nได้คืน 1–2 วัน",
            'is_published' => true,
            'sort_order' => 1,
            'blocks' => [
                'symptoms' => [
                    'heading' => 'อาการที่เจอบ่อย',
                    'items' => [
                        [
                            'symptom' => 'ไม่มีแรงดูด',
                            'cause' => 'กรองตัน',
                            'repairable' => 'ซ่อมได้',
                            'price' => '1,800–3,500',
                        ],
                    ],
                ],
                'service_options' => [
                    'drop_off' => ['fee' => 'ตามอาการ', 'time' => '1 วัน', 'suitable' => 'ส่งได้', 'area' => 'ทั่วประเทศ'],
                    'onsite' => ['fee' => '+ ค่าเดินทาง', 'time' => 'นัดหมาย', 'suitable' => 'หยุดไม่ได้', 'area' => 'กทม.'],
                ],
                'price_table' => [
                    'rows' => [
                        ['symptom' => 'แรงดูดตก', 'action' => 'ล้างกรอง', 'price' => '1,800', 'duration' => '1 วัน'],
                    ],
                ],
                'machine_filter' => [
                    'accept' => 'เครื่องคาร์แคร์',
                    'reject' => 'เครื่องบ้าน',
                ],
                'cases' => [
                    'items' => [
                        [
                            'title' => 'เคสทดสอบ',
                            'symptom' => 'แรงดูดตก',
                            'found' => 'กรองตัน',
                            'fixed' => 'เปลี่ยนกรอง',
                            'days' => '1 วัน',
                            'price' => '2,000',
                        ],
                    ],
                ],
                'faqs' => [
                    'items' => [
                        ['question' => 'พรุ่งนี้ทันไหม?', 'answer' => 'อาการทั่วไปทันใน 1 วัน'],
                    ],
                ],
            ],
        ]);

        $this->get('/vacuum-repair')->assertOk()->assertSee('รับซ่อมเครื่องดูดฝุ่นอุตสาหกรรม', false);

        $child = $this->get('/vacuum-repair/car-care');
        $child->assertOk();
        $child->assertSee('รับซ่อมเครื่องดูดฝุ่นคาร์แคร์ ทุกยี่ห้อ', false);
        $child->assertSee('ไม่มีแรงดูด', false);
        $child->assertSee('ส่งเข้าร้าน', false);
        $child->assertSee('เคสทดสอบ', false);
        $child->assertSee('application/ld+json', false);
    }

    public function test_legacy_thai_slug_redirects_to_english_silo(): void
    {
        $this->get('/'.rawurlencode('ซ่อมเครื่องดูดฝุ่นคาร์แคร์'))
            ->assertRedirect('/vacuum-repair/car-care');
    }

    public function test_draft_page_returns_404(): void
    {
        Page::query()->create([
            'slug' => 'draft-page',
            'title' => 'ร่าง',
            'template' => 'general',
            'is_published' => false,
            'blocks' => [],
        ]);

        $this->get('/draft-page')->assertNotFound();
    }

    public function test_service_rates_page_uses_services_from_products_table(): void
    {
        Page::query()->create([
            'slug' => 'service-rates',
            'title' => 'ราคาซ่อมเครื่องดูดฝุ่นอุตสาหกรรม',
            'template' => 'pricing',
            'intro' => 'ช่วงราคาซ่อมจากงานจริง',
            'is_published' => true,
            'sort_order' => 1,
            'blocks' => [
                'price_table' => [
                    'heading' => 'ตารางราคาหลักตามอาการ',
                    'intro' => 'ราคาเป็นช่วง',
                    'note' => 'ยังไม่รวมค่าเดินทาง',
                ],
                'faqs' => ['items' => []],
            ],
        ]);

        \App\Models\Product::query()->create([
            'type' => 'service',
            'name' => 'ซ่อมมอเตอร์เครื่องดูดฝุ่น',
            'slug' => 'motor-repair-test',
            'short_description' => 'พันใหม่หรือเปลี่ยนลูก',
            'price' => 3500,
            'is_active' => true,
            'is_featured' => true,
            'specs' => [['name' => 'ระยะเวลา', 'value' => '2–5', 'unitText' => 'วัน']],
        ]);

        $response = $this->get('/service-rates');
        $response->assertOk();
        $response->assertSee('ตารางราคาหลักตามอาการ', false);
        $response->assertSee('ซ่อมมอเตอร์เครื่องดูดฝุ่น', false);
        $response->assertSee('พันใหม่หรือเปลี่ยนลูก', false);
        $response->assertSee('เริ่มต้น ฿3,500', false);
        $response->assertSee('2–5 วัน', false);
        $response->assertDontSee('แรงดูดตก / กรองตัน', false);
    }

    public function test_portfolio_page_uses_gallery_layout_from_portfolios_table(): void
    {
        Page::query()->create([
            'slug' => 'portfolio',
            'title' => 'ผลงานซ่อมเครื่องดูดฝุ่นอุตสาหกรรม',
            'template' => 'portfolio',
            'intro' => 'ตัวอย่างงานซ่อมจริง',
            'is_published' => true,
            'sort_order' => 1,
            'blocks' => [
                'cases' => ['heading' => 'ตัวอย่างงานที่ซ่อมไปแล้ว'],
                'faqs' => [
                    'items' => [
                        ['question' => 'รูปทั้งหมดเป็นงานจริงไหม?', 'answer' => 'ใช่'],
                    ],
                ],
            ],
        ]);

        $factory = \App\Models\Category::query()->create([
            'name' => 'โรงงาน',
            'slug' => 'factory',
            'type' => 'portfolio',
            'sort_order' => 1,
        ]);
        $carcare = \App\Models\Category::query()->create([
            'name' => 'คาร์แคร์',
            'slug' => 'carcare',
            'type' => 'portfolio',
            'sort_order' => 2,
        ]);

        \App\Models\Portfolio::query()->create([
            'category_id' => $factory->id,
            'category_label' => 'อาหารและเครื่องดื่ม',
            'title' => 'ซ่อมมอเตอร์ Nilfisk IVB 3 ตัว หลังไฟไหม้จากการทำงานต่อเนื่อง',
            'description' => 'เคสโรงงานอาหาร',
            'fault' => 'มอเตอร์ไหม้จากการใช้งานต่อเนื่อง',
            'symptom' => 'ลูกค้าแจ้งมอเตอร์ไหม้หลังใช้งานต่อเนื่อง มีกลิ่นไหม้',
            'found' => 'คอยล์ไหม้บางส่วน แบริ่งเริ่มฝืด',
            'fixed' => 'พันมอเตอร์ใหม่ เปลี่ยนแบริ่ง และทดสอบโหลด',
            'brands' => 'Nilfisk IVB',
            'year' => '2567',
            'duration' => '2 วัน',
            'price' => 'ประมาณ 8,500 บาท',
            'status_label' => 'สำเร็จ',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        \App\Models\Portfolio::query()->create([
            'category_id' => $carcare->id,
            'category_label' => null,
            'title' => 'เปลี่ยนแปรงถ่านเครื่องดูดน้ำ',
            'fault' => 'แปรงถ่านหมด',
            'symptom' => 'ดับเอง',
            'found' => 'แปรงถ่านสึก',
            'fixed' => 'เปลี่ยนแปรงถ่าน',
            'brands' => 'Karcher',
            'year' => '2567',
            'duration' => '1 วัน',
            'price' => 'ประมาณ 1,800 บาท',
            'status_label' => 'สำเร็จ',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $response = $this->get('/portfolio');
        $response->assertOk();
        $response->assertSee('เคสจริง', false);
        $response->assertSee('ตัวอย่างงานที่ซ่อมไปแล้ว', false);
        $response->assertSee('portfolio-gallery', false);
        $response->assertSee('ดูรายละเอียด', false);
        $response->assertSee('ทั้งหมด', false);
        $response->assertSee('data-filter="factory"', false);
        $response->assertSee('data-filter="carcare"', false);
        $response->assertSee('data-category="factory"', false);
        $response->assertSee('data-category="carcare"', false);
        $response->assertSee('โรงงาน', false);
        $response->assertSee('คาร์แคร์', false);
        $response->assertSee('อาหารและเครื่องดื่ม', false);
        $response->assertSee('ซ่อมมอเตอร์ Nilfisk IVB 3 ตัว', false);
        $response->assertSee('อาการเสีย', false);
        $response->assertSee('มอเตอร์ไหม้จากการใช้งานต่อเนื่อง', false);
        $response->assertSee('อาการที่ลูกค้าแจ้ง', false);
        $response->assertSee('ลูกค้าแจ้งมอเตอร์ไหม้หลังใช้งานต่อเนื่อง', false);
        $response->assertSee('สิ่งที่ตรวจเจอ', false);
        $response->assertSee('คอยล์ไหม้บางส่วน', false);
        $response->assertSee('สิ่งที่เปลี่ยน / ซ่อม', false);
        $response->assertSee('พันมอเตอร์ใหม่', false);
        $response->assertSee('Nilfisk IVB', false);
        $response->assertSee('2 วัน', false);
        $response->assertSee('ประมาณ 8,500 บาท', false);
        $response->assertDontSee('Case Studies', false);
    }
}
