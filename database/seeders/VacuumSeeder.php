<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VacuumSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        foreach ([
            ['key' => 'site_name',        'value' => 'ร้านรับซ่อมเครื่องดูดฝุ่นอุตสาหกรรม'],
            ['key' => 'site_phone',       'value' => '02-xxx-xxxx'],
            ['key' => 'site_line',        'value' => '@vacuum-service'],
            ['key' => 'site_address',     'value' => '123 ถ.พหลโยธิน แขวงลาดยาว เขตจตุจักร กรุงเทพฯ 10900'],
            ['key' => 'site_open_hours',  'value' => 'จันทร์–เสาร์ 08:00–18:00'],
            ['key' => 'hero_title',       'value' => 'รับซ่อมและจำหน่ายเครื่องดูดฝุ่นอุตสาหกรรม'],
            ['key' => 'hero_subtitle',    'value' => 'บริการซ่อมที่ร้านและหน้างาน ครอบคลุมทุกยี่ห้อ ทุกรุ่น'],
            ['key' => 'meta_title',       'value' => 'รับซ่อมเครื่องดูดฝุ่นอุตสาหกรรม ราคาถูก มีประกัน'],
            ['key' => 'meta_description', 'value' => 'บริการซ่อมเครื่องดูดฝุ่นอุตสาหกรรมทุกยี่ห้อ ซ่อมที่ร้านและหน้างาน จำหน่ายเครื่องและอะไหล่แท้'],
        ] as $row) {
            DB::table('settings')->updateOrInsert(['key' => $row['key']], ['value' => $row['value']]);
        }

        foreach ([
            ['name' => 'เครื่องดูดฝุ่นอุตสาหกรรม', 'slug' => 'industrial-vacuum', 'type' => 'product', 'sort_order' => 1],
            ['name' => 'อะไหล่และอุปกรณ์เสริม',    'slug' => 'spare-parts',       'type' => 'product', 'sort_order' => 2],
            ['name' => 'มอเตอร์',                   'slug' => 'motor',             'type' => 'service', 'sort_order' => 1],
            ['name' => 'ระบบกรอง',                  'slug' => 'filter',            'type' => 'service', 'sort_order' => 2],
            ['name' => 'ไฟฟ้า',                     'slug' => 'electrical',        'type' => 'service', 'sort_order' => 3],
            ['name' => 'ท่อดูด',                    'slug' => 'pipe',              'type' => 'service', 'sort_order' => 4],
        ] as $row) {
            DB::table('categories')->updateOrInsert(
                ['slug' => $row['slug']],
                array_merge($row, ['created_at' => $now, 'updated_at' => $now])
            );
        }

        $categories = DB::table('categories')->pluck('id', 'slug');

        foreach ([
            ['question' => 'รับซ่อมเครื่องดูดฝุ่นยี่ห้ออะไรบ้าง?',         'answer' => 'รับซ่อมทุกยี่ห้อ เช่น Nilfisk, Karcher, Makita, Bosch, Hitachi และยี่ห้ออื่น ๆ ทั้งรุ่นอุตสาหกรรมและรุ่นทั่วไป',                                                                             'category' => 'repair', 'sort_order' => 1],
            ['question' => 'ซ่อมหน้างานได้ไหม? มีค่าใช้จ่ายพิเศษไหม?',      'answer' => 'รับซ่อมหน้างานในเขตกรุงเทพฯ และปริมณฑล มีค่าเดินทางตามระยะทาง สอบถามล่วงหน้าได้ที่ LINE หรือโทรหาเราได้เลย',                                                                        'category' => 'repair', 'sort_order' => 2],
            ['question' => 'ระยะเวลาซ่อมนานแค่ไหน?',                        'answer' => 'อาการทั่วไป 1–3 วันทำการ อาการซับซ้อนหรือต้องสั่งอะไหล่นำเข้า 5–10 วันทำการ ทีมงานแจ้งก่อนลงมือซ่อมทุกครั้ง',                                                                         'category' => 'repair', 'sort_order' => 3],
            ['question' => 'มีการรับประกันงานซ่อมไหม?',                      'answer' => 'รับประกันงานซ่อม 90 วัน หากเกิดปัญหาจากการซ่อมซ้ำในระยะประกัน ซ่อมให้ฟรีโดยไม่มีค่าใช้จ่าย',                                                                                           'category' => 'repair', 'sort_order' => 4],
            ['question' => 'สินค้ามีการรับประกันหรือเปล่า?',                 'answer' => 'สินค้าทุกชิ้นมีรับประกันตามเงื่อนไขของผู้ผลิต โดยทั่วไป 1 ปี สอบถามรายละเอียดที่หน้าสินค้าหรือติดต่อทีมงาน',                                                                            'category' => 'sale',   'sort_order' => 1],
            ['question' => 'ส่งสินค้าได้ทั่วประเทศไหม?',                    'answer' => 'จัดส่งทั่วประเทศผ่าน Kerry และ Flash Express ค่าจัดส่งคิดตามน้ำหนักและระยะทาง กรุงเทพฯ ปริมณฑล มีบริการส่งด่วนภายในวัน',                                                                 'category' => 'sale',   'sort_order' => 2],
        ] as $row) {
            $exists = DB::table('faqs')
                ->where('question', $row['question'])
                ->exists();

            if (! $exists) {
                DB::table('faqs')->insert(array_merge($row, [
                    'is_active'  => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]));
            }
        }

        $services = [
            [
                'category_id'       => $categories['motor'],
                'type'              => 'service',
                'name'              => 'ซ่อมมอเตอร์เครื่องดูดฝุ่น',
                'slug'              => 'motor-repair',
                'short_description' => 'รับซ่อม/เปลี่ยน มอเตอร์ทุกขนาด แก้ปัญหามอเตอร์ไหม้ ได้กลิ่นเหม็นไหม้ เครื่องตัดการทำงาน หรือไม่หมุน พร้อมรับประกัน 3 เดือน',
                'description'       => 'รับซ่อมและเปลี่ยนมอเตอร์เครื่องดูดฝุ่นอุตสาหกรรมทุกยี่ห้อ ตรวจเช็คอาการ แจ้งราคาก่อนซ่อม รับประกัน 3 เดือน',
                'image'             => 'services/ametek-vacuum-motor.webp',
                'price'             => 0,
                'sale_price'        => null,
                'is_active'         => true,
                'is_featured'       => true,
                'meta_title'        => null,
                'meta_description'  => null,
            ],
            [
                'category_id'       => $categories['filter'],
                'type'              => 'service',
                'name'              => 'ซ่อมและเปลี่ยนไส้กรอง',
                'slug'              => 'filter-repair',
                'short_description' => 'เปลี่ยนไส้กรอง HEPA และกรองผ้า ทำความสะอาดระบบกรอง แก้ปัญหาประสิทธิภาพดูดฝุ่นลดลง ฝุ่นย้อนกลับ หรือมีกลิ่น',
                'description'       => 'บริการเปลี่ยนไส้กรอง HEPA และผ้ากรอง พร้อมทำความสะอาดระบบกรองทั้งชุด',
                'image'             => 'services/hepa-filter.webp',
                'price'             => 800,
                'sale_price'        => null,
                'is_active'         => true,
                'is_featured'       => false,
                'meta_title'        => null,
                'meta_description'  => null,
            ],
            [
                'category_id'       => $categories['electrical'],
                'type'              => 'service',
                'name'              => 'ซ่อมระบบไฟฟ้าและวงจร',
                'slug'              => 'electrical-repair',
                'short_description' => 'ซ่อมสวิตช์ บอร์ดควบคุม PCB ระบบ Inverter และอุปกรณ์ไฟฟ้าทุกชนิด แก้ปัญหาเครื่องไม่ติด ไฟกระพริบ Overload หรือน้ำเข้าตู้มอเตอร์จนช็อต',
                'description'       => 'ซ่อมระบบไฟฟ้า PCB Inverter และอุปกรณ์ควบคุมของเครื่องดูดฝุ่นอุตสาหกรรม',
                'image'             => 'services/electrolux-mainboard.webp',
                'price'             => 0,
                'sale_price'        => null,
                'is_active'         => true,
                'is_featured'       => false,
                'meta_title'        => null,
                'meta_description'  => null,
            ],
            [
                'category_id'       => $categories['pipe'],
                'type'              => 'service',
                'name'              => 'ซ่อมท่อดูดและหัวดูด',
                'slug'              => 'pipe-repair',
                'short_description' => 'ซ่อมและเปลี่ยนท่อดูด สายยาง และหัวดูดทุกรูปแบบ แก้ปัญหาท่อรั่ว แรงดูดอ่อน ดูดไม่เข้าถัง หรืออุดตัน',
                'description'       => 'ซ่อมและเปลี่ยนท่อดูด สายยาง หัวดูด สำหรับเครื่องดูดฝุ่นอุตสาหกรรม',
                'image'             => 'services/tube.webp',
                'price'             => 500,
                'sale_price'        => null,
                'is_active'         => true,
                'is_featured'       => false,
                'meta_title'        => null,
                'meta_description'  => null,
            ],
            [
                'category_id'       => $categories['motor'],
                'type'              => 'service',
                'name'              => 'Overhaul เครื่องดูดฝุ่นครบระบบ',
                'slug'              => 'full-overhaul',
                'short_description' => 'ถอดประกอบและบำรุงรักษาเครื่องดูดฝุ่นทั้งระบบ เปลี่ยนชิ้นส่วนสึกหรอ ทำความสะอาดภายใน ตรวจสอบตลับลูกปืน และทดสอบการทำงานทุกจุด',
                'description'       => 'บริการ Overhaul ครบระบบ ถอดประกอบ ทำความสะอาด เปลี่ยนชิ้นส่วนสึกหรอ และทดสอบการทำงาน',
                'image'             => 'services/overhaul.webp',
                'price'             => 3500,
                'sale_price'        => 3000,
                'is_active'         => true,
                'is_featured'       => false,
                'meta_title'        => null,
                'meta_description'  => null,
            ],
            [
                'category_id'       => $categories['electrical'],
                'type'              => 'service',
                'name'              => 'ตรวจสอบและวินิจฉัยอาการ',
                'slug'              => 'diagnosis',
                'short_description' => 'ตรวจวินิจฉัยอาการเสียอย่างละเอียด ระบุสาเหตุที่แท้จริง เช่น เสียงดังครืดๆ วี้ดๆ เครื่องตัดเอง หรือแรงดูดตก พร้อมประเมินราคาก่อนซ่อม',
                'description'       => 'ตรวจวินิจฉัยอาการเสียฟรี พร้อมใบเสนอราคาก่อนซ่อม',
                'image'             => 'services/inspect.webp',
                'price'             => 0,
                'sale_price'        => null,
                'is_active'         => true,
                'is_featured'       => false,
                'meta_title'        => null,
                'meta_description'  => null,
            ],
        ];

        $serviceSlugs = [];
        foreach ($services as $service) {
            $serviceSlugs[] = $service['slug'];
            DB::table('products')->updateOrInsert(
                ['slug' => $service['slug']],
                array_merge($service, ['updated_at' => $now, 'created_at' => $now])
            );
        }

        DB::table('products')
            ->where('type', 'service')
            ->whereNotIn('slug', $serviceSlugs)
            ->update(['is_active' => false, 'updated_at' => $now]);

        DB::table('categories')
            ->where('type', 'service')
            ->whereNotIn('slug', ['motor', 'filter', 'electrical', 'pipe'])
            ->delete();

        foreach ([
            [
                'category_label' => 'บุคคลทั่วไป - คอนโดมิเนียม',
                'title'          => 'ซ่อมเครื่องดูดฝุ่นแบบถังสแตนเลส น้ำเข้าตู้มอเตอร์จนช็อต เปลี่ยนมอเตอร์ใหม่ พร้อมทำความสะอาดระบบ',
                'description'    => null,
                'brands'         => 'Karcher, Nilfisk',
                'image'          => 'portfolio/1.JPG',
                'year'           => '2569',
                'duration'       => '1 วัน',
                'status_label'   => 'สำเร็จ',
                'sort_order'     => 1,
                'is_active'      => true,
            ],
            [
                'category_label' => 'ร้านคาร์แคร์',
                'title'          => 'Overhaul เครื่องดูดฝุ่นอุตสาหกรรมที่ใช้งานหนัก เปลี่ยนตลับลูกปืนและซีลกันฝุ่น แก้ปัญหาเสียงดังครืดๆ',
                'description'    => null,
                'brands'         => 'Roots, Numatic',
                'image'          => 'portfolio/2.JPG',
                'year'           => '2569',
                'duration'       => '1 วัน',
                'status_label'   => 'สำเร็จ',
                'sort_order'     => 2,
                'is_active'      => true,
            ],
            [
                'category_label' => 'โรงงานยา',
                'title'          => 'ซ่อมระบบไฟฟ้าและบอร์ดควบคุมเครื่องดูดฝุ่นแบบ HEPA Filter แก้ปัญหาเครื่องตัดการทำงานเอง',
                'description'    => null,
                'brands'         => 'Nilfisk, Cleanfix',
                'image'          => 'portfolio/3.JPG',
                'year'           => '2569',
                'duration'       => '1 วัน',
                'status_label'   => 'สำเร็จ',
                'sort_order'     => 3,
                'is_active'      => true,
            ],
        ] as $portfolio) {
            DB::table('portfolios')->updateOrInsert(
                ['title' => $portfolio['title']],
                array_merge($portfolio, ['updated_at' => $now, 'created_at' => $now])
            );
        }

        if (DB::table('products')->where('type', 'product')->exists()) {
            return;
        }

        $products = [
            [
                'category_id'       => $categories['industrial-vacuum'],
                'type'              => 'product',
                'name'              => 'Nilfisk GD930 Industrial Vacuum',
                'slug'              => 'nilfisk-gd930',
                'short_description' => 'เครื่องดูดฝุ่นอุตสาหกรรม 930W ถัง 15 ลิตร เหมาะกับโรงงานและคลังสินค้า',
                'description'       => 'Nilfisk GD930 เป็นเครื่องดูดฝุ่นอุตสาหกรรมคุณภาพสูง มอเตอร์ทนทาน ถังสแตนเลส 15 ลิตร พร้อมชุดอุปกรณ์ครบ',
                'image'             => 'images/products/nilfisk-gd930.jpg',
                'price'             => 18900,
                'sale_price'        => 16900,
                'is_active'         => true,
                'is_featured'       => true,
                'meta_title'        => 'Nilfisk GD930 เครื่องดูดฝุ่นอุตสาหกรรม',
                'meta_description'  => 'จำหน่าย Nilfisk GD930 ราคาถูก มีประกัน 1 ปี',
            ],
            [
                'category_id'       => $categories['industrial-vacuum'],
                'type'              => 'product',
                'name'              => 'Karcher NT 65/2 Tact',
                'slug'              => 'karcher-nt65-2-tact',
                'short_description' => 'เครื่องดูดฝุ่นเปียก-แห้ง 65 ลิตร มotor 2 ตัว สำหรับงานหนัก',
                'description'       => 'Karcher NT 65/2 Tact รองรับงานดูดฝุ่นและของเหลว ถังใหญ่ 65 ลิตร เหมาะกับโรงงานอาหารและโรงแรม',
                'image'             => 'images/products/karcher-nt65.jpg',
                'price'             => 45900,
                'sale_price'        => null,
                'is_active'         => true,
                'is_featured'       => true,
                'meta_title'        => 'Karcher NT 65/2 Tact ดูดฝุ่นเปียก-แห้ง',
                'meta_description'  => 'Karcher NT 65/2 Tact สำหรับงานอุตสาหกรรม',
            ],
            [
                'category_id'       => $categories['industrial-vacuum'],
                'type'              => 'product',
                'name'              => 'Makita VC3210L',
                'slug'              => 'makita-vc3210l',
                'short_description' => 'เครื่องดูดฝุ่นอุตสาหกรรม 32 ลิตร มotor 1,050W',
                'description'       => 'Makita VC3210L ถังความจุ 32 ลิตร ระบบกรอง HEPA ดูดฝุ่นละเอียดได้ดี',
                'image'             => 'images/products/makita-vc3210l.jpg',
                'price'             => 12500,
                'sale_price'        => 11200,
                'is_active'         => true,
                'is_featured'       => false,
                'meta_title'        => 'Makita VC3210L เครื่องดูดฝุ่นอุตสาหกรรม',
                'meta_description'  => 'Makita VC3210L ราคาพิเศษ มีประกันศูนย์',
            ],
            [
                'category_id'       => $categories['spare-parts'],
                'type'              => 'product',
                'name'              => 'ชุด HEPA Filter Nilfisk GD930',
                'slug'              => 'hepa-filter-nilfisk-gd930',
                'short_description' => 'ไส้กรอง HEPA แท้ Nilfisk สำหรับ GD930',
                'description'       => 'ไส้กรอง HEPA คุณภาพสูง กรองฝุ่นละเอียด 99.97% เปลี่ยนทุก 6–12 เดือน',
                'image'             => 'images/products/hepa-filter-gd930.jpg',
                'price'             => 890,
                'sale_price'        => null,
                'is_active'         => true,
                'is_featured'       => false,
                'meta_title'        => null,
                'meta_description'  => null,
            ],
            [
                'category_id'       => $categories['spare-parts'],
                'type'              => 'product',
                'name'              => 'สายดูดฝุ่น 32mm ยาว 3 เมตร',
                'slug'              => 'vacuum-hose-32mm-3m',
                'short_description' => 'สายดูดฝุ่นยางแข็ง 32mm ยาว 3 เมตร ใช้ได้กับหลายยี่ห้อ',
                'description'       => 'สายดูดฝุ่นคุณภาพสูง ทนทานต่อการเสียดสี ปลายมาตรฐาน 32mm',
                'image'             => 'images/products/vacuum-hose-32mm.jpg',
                'price'             => 650,
                'sale_price'        => 590,
                'is_active'         => true,
                'is_featured'       => false,
                'meta_title'        => null,
                'meta_description'  => null,
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert(array_merge($product, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }

        $productIds = DB::table('products')->pluck('id', 'slug');

        DB::table('product_images')->insert([
            ['product_id' => $productIds['nilfisk-gd930'],       'path' => 'images/products/nilfisk-gd930-1.jpg', 'alt' => 'Nilfisk GD930 ด้านหน้า',  'sort_order' => 1],
            ['product_id' => $productIds['nilfisk-gd930'],       'path' => 'images/products/nilfisk-gd930-2.jpg', 'alt' => 'Nilfisk GD930 ด้านข้าง', 'sort_order' => 2],
            ['product_id' => $productIds['karcher-nt65-2-tact'], 'path' => 'images/products/karcher-nt65-1.jpg',   'alt' => 'Karcher NT 65/2 Tact',    'sort_order' => 1],
            ['product_id' => $productIds['makita-vc3210l'],      'path' => 'images/products/makita-vc3210l-1.jpg', 'alt' => 'Makita VC3210L',       'sort_order' => 1],
        ]);

        DB::table('customers')->insert([
            [
                'name'      => 'บริษัท ไทยอุตสาหกรรม จำกัด',
                'phone'     => '02-555-1234',
                'email'     => 'contact@thai-industry.co.th',
                'company'   => 'ไทยอุตสาหกรรม จำกัด',
                'address'   => '88/1 ถ.วิภาวดีรังสิต แขวงลาดยาว เขตจตุจักร กรุงเทพฯ 10900',
                'latitude'  => 13.8196,
                'longitude' => 100.5671,
                'note'      => 'ลูกค้าประจำ สั่งซื้อเครื่องและอะไหล่เป็นประจำ',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'      => 'โรงงาน ABC Manufacturing',
                'phone'     => '081-234-5678',
                'email'     => 'maintenance@abc-mfg.com',
                'company'   => 'ABC Manufacturing',
                'address'   => 'นิคมอุตสาหกรรมบางปู สมุทรปราการ',
                'latitude'  => 13.6107,
                'longitude' => 100.7514,
                'note'      => 'ใช้บริการซ่อมหน้างาน 5 เครื่อง',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'      => 'คุณสมชาย ใจดี',
                'phone'     => '089-876-5432',
                'email'     => 'somchai.j@gmail.com',
                'company'   => null,
                'address'   => '456 ถ.ลาดพร้าว แขวงจอมพล เขตจตุจักร กรุงเทพฯ 10900',
                'latitude'  => 13.8302,
                'longitude' => 100.5695,
                'note'      => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        $customerIds = DB::table('customers')->orderBy('id')->pluck('id')->values();

        DB::table('orders')->insert([
            [
                'order_no'        => 'ORD-20260708-001',
                'customer_id'     => $customerIds[0],
                'type'            => 'sale',
                'status'          => 'completed',
                'service_type'    => null,
                'brand'           => null,
                'model'           => null,
                'problem'         => null,
                'diagnosis'       => null,
                'appointment_at'  => null,
                'site_latitude'   => null,
                'site_longitude'  => null,
                'site_address'    => null,
                'amount'          => 17490,
                'note'            => 'จัดส่ง Kerry ชำระเงินโอน',
                'created_at'      => $now->copy()->subDays(5),
                'updated_at'      => $now->copy()->subDays(3),
            ],
            [
                'order_no'        => 'REP-20260708-001',
                'customer_id'     => $customerIds[2],
                'type'            => 'repair',
                'status'          => 'repairing',
                'service_type'    => 'drop_off',
                'brand'           => 'Nilfisk',
                'model'           => 'GD930',
                'problem'         => 'มอเตอร์มีเสียงดัง แรงดูดลดลง',
                'diagnosis'       => 'ลูกปืนมอเตอร์สึกหรอ ต้องเปลี่ยนลูกปืนและทำความสะอาดถัง',
                'appointment_at'  => null,
                'site_latitude'   => null,
                'site_longitude'  => null,
                'site_address'    => null,
                'amount'          => 2500,
                'note'            => 'ลูกค้ารออะไหล่ 2 วัน',
                'created_at'      => $now->copy()->subDays(2),
                'updated_at'      => $now,
            ],
            [
                'order_no'        => 'REP-20260708-002',
                'customer_id'     => $customerIds[1],
                'type'            => 'repair',
                'status'          => 'confirmed',
                'service_type'    => 'on_site',
                'brand'           => 'Karcher',
                'model'           => 'NT 65/2',
                'problem'         => 'ดูดของเหลวไม่ได้ ถังรั่ว',
                'diagnosis'       => null,
                'appointment_at'  => $now->copy()->addDays(2)->setTime(10, 0),
                'site_latitude'   => 13.6107,
                'site_longitude'  => 100.7514,
                'site_address'    => 'นิคมอุตสาหกรรมบางปู สมุทรปราการ',
                'amount'          => 3500,
                'note'            => 'นัดช่างวันศุกร์ 10:00 น.',
                'created_at'      => $now->copy()->subDay(),
                'updated_at'      => $now,
            ],
        ]);

        $orderIds = DB::table('orders')->pluck('id', 'order_no');

        DB::table('order_items')->insert([
            [
                'order_id'   => $orderIds['ORD-20260708-001'],
                'product_id' => $productIds['nilfisk-gd930'],
                'name'       => 'Nilfisk GD930 Industrial Vacuum',
                'price'      => 16900,
                'qty'        => 1,
                'subtotal'   => 16900,
            ],
            [
                'order_id'   => $orderIds['ORD-20260708-001'],
                'product_id' => $productIds['hepa-filter-nilfisk-gd930'],
                'name'       => 'ชุด HEPA Filter Nilfisk GD930',
                'price'      => 890,
                'qty'        => 1,
                'subtotal'   => 590,
            ],
        ]);

        DB::table('reviews')->insert([
            [
                'product_id'    => $productIds['nilfisk-gd930'],
                'order_id'      => $orderIds['ORD-20260708-001'],
                'reviewer_name' => 'คุณวิชัย',
                'rating'        => 5,
                'comment'       => 'เครื่องดีมาก แรงดูดสูง ทีมงานแนะนำดี จัดส่งเร็ว',
                'image'         => null,
                'is_approved'   => true,
                'created_at'    => $now->copy()->subDays(2),
                'updated_at'    => $now->copy()->subDays(2),
            ],
            [
                'product_id'    => $productIds['karcher-nt65-2-tact'],
                'order_id'      => null,
                'reviewer_name' => 'คุณประเสริฐ',
                'rating'        => 4,
                'comment'       => 'ใช้งานในโรงงานได้ดี ถังใหญ่มาก แต่ราคาค่อนข้างสูง',
                'image'         => null,
                'is_approved'   => true,
                'created_at'    => $now->copy()->subDays(10),
                'updated_at'    => $now->copy()->subDays(10),
            ],
            [
                'product_id'    => null,
                'order_id'      => $orderIds['REP-20260708-001'],
                'reviewer_name' => 'คุณสมชาย',
                'rating'        => 5,
                'comment'       => 'ช่างซ่อมเก่ง อธิบายอาการชัดเจน ราคาเป็นธรรม',
                'image'         => null,
                'is_approved'   => true,
                'created_at'    => $now->copy()->subDay(),
                'updated_at'    => $now->copy()->subDay(),
            ],
        ]);
    }
}
