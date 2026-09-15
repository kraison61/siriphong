<?php

namespace Tests\Feature\Admin;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_view_settings(): void
    {
        $this->get(route('admin.settings.edit'))
            ->assertRedirect(route('login'));
    }

    public function test_admin_can_view_settings_form(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.settings.edit'))
            ->assertOk()
            ->assertSee('ตั้งค่าเว็บไซต์')
            ->assertSee('ชื่อร้าน');
    }

    public function test_admin_can_update_settings(): void
    {
        $user = User::factory()->create();

        $payload = [
            'name' => 'ศิริพงษ์ ทดสอบ',
            'phone' => '+66810000000',
            'phone_formatted' => '081-000-0000',
            'email' => 'test@example.com',
            'address' => 'ที่อยู่ทดสอบ',
            'address_street' => 'ถนนทดสอบ',
            'address_locality' => 'ราษฎร์บูรณะ',
            'address_region' => 'กรุงเทพมหานคร',
            'address_postal' => '10140',
            'address_country' => 'TH',
            'taxid' => 'n/a',
            'facebook' => 'n/a',
            'line' => 'https://line.me/ti/p/test',
            'logo' => 'https://example.com/logo.webp',
            'logo_width' => 400,
            'logo_height' => 300,
            'favicon' => 'https://example.com/fav.ico',
            'hero_image' => 'hero.jpg',
            'line_qr' => 'qr.jpg',
            'open_hours' => 'จันทร์–ศุกร์ 09:00–17:00',
            'hero_title' => 'หัวข้อทดสอบ',
            'hero_subtitle' => 'คำโปรยทดสอบ',
            'meta_title' => 'Meta Title ทดสอบ',
            'meta_description' => 'Meta Description ทดสอบ',
        ];

        $response = $this->actingAs($user)->put(route('admin.settings.update'), $payload);

        $response->assertRedirect(route('admin.settings.edit'));
        $response->assertSessionHas('success');

        $this->assertSame('ศิริพงษ์ ทดสอบ', Setting::getValue('name'));
        $this->assertSame('+66810000000', Setting::getValue('phone'));
        $this->assertSame('https://line.me/ti/p/test', Setting::getValue('line'));

        Setting::applyToConfig();

        $this->assertSame('ศิริพงษ์ ทดสอบ', config('data.name'));
        $this->assertSame('+66810000000', config('data.phone'));
        $this->assertSame('ถนนทดสอบ', config('data.address_structured.streetAddress'));
    }
}
