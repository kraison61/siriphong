<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WpBfProductSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $categoryId = DB::table('categories')
            ->where('slug', 'industrial-vacuum')
            ->where('type', 'product')
            ->value('id');

        if (! $categoryId) {
            $categoryId = DB::table('categories')->insertGetId([
                'name' => 'เครื่องดูดฝุ่นอุตสาหกรรม',
                'slug' => 'industrial-vacuum',
                'type' => 'product',
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $products = [
            [
                'slug' => 'wp-bf-575-30',
                'name' => 'WP-BF-575-30',
                'sku' => 'WP-BF-575-30',
                'brand' => 'WP-WELLPUMP',
                'short_description' => 'เครื่องดูดฝุ่นอุตสาหกรรม WP-WELLPUMP รุ่น BF-575 ดูดฝุ่นแห้งและดูดน้ำ มอเตอร์ 1,200 วัตต์ ถังสเตนเลส 30 ลิตร',
                'description' => implode("\n\n", [
                    "จุดเด่นและคุณสมบัติพิเศษ (Key Features)\n".
                    "• มอเตอร์ทรงพลังแต่เสียงเงียบ: ให้แรงดูดสุญญากาศสูง จัดการสิ่งสกปรกฝังลึกได้ดี แต่ไร้เสียงรบกวนที่รุนแรงขณะทำงาน\n".
                    "• ตัวถังสเตนเลสแท้ 100%: แข็งแกร่ง ทนทานต่อแรงกระแทกและสารเคมีบางชนิด ไม่เกิดสนิมแม้ใช้งานดูดน้ำเป็นประจำ\n".
                    "• ฟังก์ชันอเนกประสงค์ ครบจบในเครื่องเดียว: ทำความสะอาดได้ทุกสภาพพื้นผิว ทั้งพื้นแห้ง พื้นเปียก หรือแม้แต่ดูดเศษขยะชิ้นใหญ่\n".
                    "• ทำความสะอาดง่าย: ถุงกรองผ้าไฟเบอร์ถอดซักได้ ช่วยประหยัดค่าใช้จ่ายในการเปลี่ยนฟิลเตอร์",
                    "อุปกรณ์มาตรฐานภายในชุด (Standard Accessories)\n".
                    "• สายดูดฝุ่น-ดูดน้ำแบบยืดหยุ่น (ขนาด 40 mm)\n".
                    "• ท่อต่อสเตนเลส / ท่อพลาสติก 2 ท่อน\n".
                    "• หัวดูดฝุ่นหน้ากว้าง (สำหรับพื้นที่ทั่วไป)\n".
                    "• หัวดูดน้ำ (รีดน้ำบนพื้นผิว)\n".
                    "• หัวดูดตามซอก (สำหรับมุมแคบ)\n".
                    "• หัวดูดแปรงกลม (สำหรับปัดฝุ่นตามเฟอร์นิเจอร์)",
                ]),
                'is_featured' => true,
                'specs' => [
                    ['name' => 'รุ่นสินค้า', 'value' => 'BF-575 (WP-BF-575-30 / LP-BF575)'],
                    ['name' => 'ประเภทการใช้งาน', 'value' => 'ดูดฝุ่นแห้ง และ ดูดน้ำ (Wet & Dry)'],
                    ['name' => 'กำลังมอเตอร์', 'value' => '1,200 วัตต์ (บางแบรนด์นำเข้าสเปค 1,500W)'],
                    ['name' => 'ระบบไฟฟ้า', 'value' => '220-240 V / 50 Hz'],
                    ['name' => 'ความจุถังเก็บ', 'value' => '30', 'unitText' => 'ลิตร'],
                    ['name' => 'วัสดุตัวถัง', 'value' => 'สเตนเลสคุณภาพสูง (Stainless Steel) ไม่เป็นสนิม'],
                    ['name' => 'ระบบกรองฝุ่น', 'value' => 'ถุงผ้าไฟเบอร์ แข็งแรง ทนทาน ถอดซักได้ง่าย'],
                    ['name' => 'ขนาดตัวเครื่อง (ก x ย x ส)', 'value' => 'ประมาณ 43 x 43 x 78', 'unitText' => 'ซม.'],
                    ['name' => 'เส้นผ่านศูนย์กลางถัง', 'value' => '34.5', 'unitText' => 'ซม.'],
                    ['name' => 'ความยาวสายไฟ', 'value' => '7 เมตร (ช่วยให้ทำงานในพื้นที่กว้างได้สะดวก)'],
                ],
            ],
            [
                'slug' => 'wp-bf-585-60',
                'name' => 'WP-BF-585-60',
                'sku' => 'WP-BF-585-60',
                'brand' => 'WP-WELLPUMP',
                'short_description' => 'เครื่องดูดฝุ่นอุตสาหกรรม WP-WELLPUMP รุ่น BF585 มอเตอร์ 3 ตัว ถัง 60 ลิตร สำหรับงานหนัก',
                'description' => 'เครื่องดูดฝุ่นอุตสาหกรรม ยี่ห้อ WP-WELLPUMP รุ่น BF585 จำนวน 3 มอเตอร์ ขนาด 60 ลิตร',
                'is_featured' => false,
                'specs' => [
                    ['name' => 'ยี่ห้อ', 'value' => 'WP-WELLPUMP'],
                    ['name' => 'รุ่น', 'value' => 'BF585'],
                    ['name' => 'จำนวนมอเตอร์', 'value' => '3', 'unitText' => 'ตัว'],
                    ['name' => 'ความจุถัง', 'value' => '60', 'unitText' => 'L'],
                    ['name' => 'ประเภท', 'value' => 'เครื่องดูดฝุ่นอุตสาหกรรม'],
                ],
            ],
            [
                'slug' => 'wp-bf-585-80',
                'name' => 'WP-BF-585-80',
                'sku' => 'WP-BF-585-80',
                'brand' => 'WP-WELLPUMP',
                'short_description' => 'เครื่องดูดฝุ่นอุตสาหกรรม WP-WELLPUMP รุ่น BF585 มอเตอร์ 3 ตัว ถัง 80 ลิตร',
                'description' => 'เครื่องดูดฝุ่นอุตสาหกรรม ยี่ห้อ WP-WELLPUMP รุ่น BF585 จำนวน 3 มอเตอร์ ขนาด 80 ลิตร',
                'is_featured' => false,
                'specs' => [
                    ['name' => 'ยี่ห้อ', 'value' => 'WP-WELLPUMP'],
                    ['name' => 'รุ่น', 'value' => 'BF585'],
                    ['name' => 'จำนวนมอเตอร์', 'value' => '3', 'unitText' => 'ตัว'],
                    ['name' => 'ความจุถัง', 'value' => '80', 'unitText' => 'L'],
                    ['name' => 'ประเภท', 'value' => 'เครื่องดูดฝุ่นอุตสาหกรรม'],
                ],
            ],
        ];

        foreach ($products as $product) {
            $existing = DB::table('products')->where('slug', $product['slug'])->first();

            $payload = [
                'category_id' => $categoryId,
                'type' => 'product',
                'name' => $product['name'],
                'sku' => $product['sku'],
                'brand' => $product['brand'],
                'short_description' => $product['short_description'],
                'description' => $product['description'],
                'specs' => json_encode($product['specs'], JSON_UNESCAPED_UNICODE),
                'is_active' => true,
                'is_featured' => $product['is_featured'],
                'updated_at' => $now,
            ];

            if ($existing) {
                DB::table('products')->where('id', $existing->id)->update($payload);
                continue;
            }

            DB::table('products')->insert(array_merge($payload, [
                'price' => 0,
                'sale_price' => null,
                'created_at' => $now,
            ]));
        }
    }
}
