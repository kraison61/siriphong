<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('เครื่องดูดฝุ่นอุตสาหกรรม ซ่อม ขาย เช่า ทุกยี่ห้อ', false);
        $response->assertSee('rel="canonical" href="https://siriphong-vacuum.com/"', false);
        $response->assertSee('ซ่อมเครื่องดูดฝุ่นอุตสาหกรรม ราคาเท่าไหร่?', false);
        $response->assertDontSee('ฟรีค่าตรวจสอบ', false);
        $response->assertDontSee('จันทร์–เสาร์', false);
        $response->assertDontSee('รับประกัน 3 เดือน', false);
        $response->assertDontSee('ดึกๆ', false);
    }
}
