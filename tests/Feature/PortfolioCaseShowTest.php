<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioCaseShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_showroom_onsite_repair_lives_on_portfolio_not_blog(): void
    {
        $this->seed(\Database\Seeders\PortfolioCategorySeeder::class);
        $this->seed(\Database\Seeders\ShowroomVacuumOnsiteRepairPortfolioSeeder::class);

        $show = $this->get('/portfolio/showroom-vacuum-onsite-repair');
        $show->assertOk();
        $show->assertSee('โชว์รูมรถยนต์นำเข้า ย่านพัฒนาการ', false);
        $show->assertSee('แก้สายไฟ 300 บาท', false);
        $show->assertSee('รวมอยู่ในค่าซ่อมมอเตอร์ 1,750 บาทแล้ว', false);
        $show->assertSee('ประมาณครึ่งวันเช้า', false);
        $show->assertSee('200 บาท', false);
        $show->assertSee('ไม่รวมค่าติดตั้งและค่าส่ง', false);
        $show->assertSee('เครื่องดูดฝุ่นมีกลิ่นไหม้ ยังใช้ต่อได้ไหม?', false);
        $show->assertSee('href="/vacuum-repair"', false);
        $show->assertSee('href="/service-rates"', false);

        $this->get('/blog/showroom-vacuum-onsite-repair')->assertNotFound();
    }

    public function test_school_vacuum_wont_turn_on_case_page(): void
    {
        $this->seed(\Database\Seeders\PortfolioCategorySeeder::class);
        $this->seed(\Database\Seeders\MotorRepairBlogSeeder::class);
        $this->seed(\Database\Seeders\SchoolVacuumWontTurnOnPortfolioSeeder::class);

        $show = $this->get('/portfolio/school-vacuum-wont-turn-on');
        $show->assertOk();
        $show->assertSee('เปลี่ยนมอเตอร์ใหม่ให้วิทยาลัย', false);
        $show->assertSee('1,650 บาท', false);
        $show->assertSee('300 วัตต์', false);
        $show->assertSee('ท่อดูดยาว 1.5–1.8 ม.', false);
        $show->assertSee('แจ้งทาง LINE', false);
        $show->assertSee('มอเตอร์ไหม้', false);
        $show->assertSee('href="/vacuum-repair"', false);
        $show->assertSee('href="/service-rates"', false);
        $show->assertSee('href="/products"', false);
        $show->assertSee('เครื่องดูดฝุ่นเปิดไม่ติด มีกลิ่นไหม้ ยังใช้ต่อได้ไหม?', false);
    }

    public function test_centric_place_hotel_case_page(): void
    {
        $this->seed(\Database\Seeders\PortfolioCategorySeeder::class);
        $this->seed(\Database\Seeders\CentricPlaceHotelPortfolioSeeder::class);

        $show = $this->get('/portfolio/pm-replace-motor-centric-place-hotel');
        $show->assertOk();
        $show->assertSee('โรงแรม Centric Place', false);
        $show->assertSee('1,750 บาท', false);
        $show->assertSee('Electrolux', false);
        $show->assertSee('Karcher', false);
        $show->assertSee('เปลี่ยนมอเตอร์', false);
        $show->assertSee('ถอดทำความสะอาด', false);
        $show->assertSee('ดำเนินการ 1 วัน', false);
        $show->assertSee('เสื่อมสภาพตามการใช้งาน', false);
        $show->assertSee('ร้านซ่อมเครื่องดูดฝุ่น Electrolux ที่รับงานโรงแรมและบริษัทมีที่ไหน?', false);
        $show->assertSee('href="/services/deep-clean"', false);
        $show->assertSee('href="/services/motor-repair"', false);
        $show->assertSee('href="/service-rates"', false);
        $show->assertDontSee('[ต้องยืนยัน]', false);
        $show->assertDontSee('[ต้องเติม]', false);
        $show->assertDontSee('รอบที่ 2: เปลี่ยนมอเตอร์เครื่องดูดฝุ่นอุตสาหกรรม 4 ตัว', false);

        $html = $show->getContent();
        $this->assertStringContainsString('"@type":"Article"', $html);
        $this->assertStringContainsString('"@type":"FAQPage"', $html);
    }
}
