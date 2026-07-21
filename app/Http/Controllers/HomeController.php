<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;

class HomeController extends Controller
{
    public function index()
    {
        $mapReference = Portfolio::query()
            ->whereNotNull('map_coordinates')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->first();

        [$latitude, $longitude] = $this->extractCoordinates(
            (string) ($mapReference?->map_coordinates ?? '13.754198, 100.501705')
        );

        $schemaData = [
            '@context' => 'https://schema.org',
            '@type' => ['LocalBusiness', 'RepairService'],
            'name' => 'ศิริพงษ์ vacuum',
            'alternateName' => 'Siriphong Industrial Vacuum Repair',
            'description' => 'ผู้เชี่ยวชาญด้านการซ่อมและบริการรักษาเครื่องดูดฝุ่นอุตสาหกรรมทุกยี่ห้อ ให้บริการแบบ C2B รวดเร็ว ตรวจสอบอาการฟรี พร้อมใบรับประกันงานซ่อม เพิ่มอายุการใช้งานเครื่องจักรและลดต้นทุนให้ธุรกิจของคุณ',
            'url' => 'https://www.siriphong-vacuum.com', // ⚠️ แก้เป็น URL จริงของคุณ
            'telephone' => '+66-81-792-8148', // ⚠️ แก้เป็นเบอร์โทรจริง
            'email' => 'oun.cav@gmail.com', // ⚠️ แก้เป็นอีเมลจริง
            'priceRange' => 'เริ่มต้น 300-5,000 บาท',
            'image' => 'https://www.siriphong-vacuum.com/images/logo.jpg', // ⚠️ แก้เป็น URL รูปจริง
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => '69 ซอยสุขสวัสดิ์ 26 แยก 10-5` ', // ⚠️ แก้เป็นที่อยู่จริง
                'addressLocality' => 'ราษร์บูรณะ',
                'addressRegion' => 'กรุงเทพมหานคร',
                'postalCode' => '10140',
                'addressCountry' => 'TH'
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $latitude, // อ้างอิงจากพิกัดที่กรอกใน admin portfolio
                'longitude' => (string) $longitude,
            ],
            'areaServed' => [
                [
                    '@type' => 'Place',
                    'name' => 'กรุงเทพมหานคร'
                ],
                [
                    '@type' => 'Place',
                    'name' => 'ปริมณฑล'
                ],
                [
                    '@type' => 'Place',
                    'name' => 'ทั่วประเทศ (บริการส่งซ่อม)'
                ]
            ],
            'openingHoursSpecification' => [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday','Saturday','Sunday'],
                'opens' => '08:00',
                'closes' => '18:00'
            ],
            'serviceType' => [
                'ซ่อมเครื่องดูดฝุ่นอุตสาหกรรม',
                'เปลี่ยนมอเตอร์เครื่องดูดฝุ่นโรงงาน',
                'บำรุงรักษาเครื่องดูดฝุ่นเชิงป้องกัน',
                'บริการซ่อมเครื่องดูดฝุ่นถึงที่',
                'รับซื้อเครื่องดูดฝุ่นอุตสาหกรรมมือสอง'
            ],
            'makesOffer' => [
                [
                    '@type' => 'Offer',
                    'itemOffered' => [
                        '@type' => 'Service',
                        'name' => 'บริการตรวจสอบและประเมินอาการซ่อมเครื่องดูดฝุ่นอุตสาหกรรม',
                        'description' => 'รับประเมินอาการฟรี ไม่ซ่อมไม่คิดค่าใช้จ่าย พร้อมใบเสนอราคาโปร่งใส'
                    ],
                    'availability' => 'https://schema.org/InStock',
                    'priceSpecification' => [
                        '@type' => 'PriceSpecification',
                        'priceCurrency' => 'THB',
                        'minPrice' => '0',
                        'priceValidUntil' => '2027-12-31'
                    ]
                ],
                [
        '@type' => 'Offer',
        'itemOffered' => [
            '@type' => 'Service',
            'name' => 'บริการซ่อมเครื่องดูดฝุ่นอุตสาหกรรมถึงที่โรงงาน',
            'description' => 'ช่างเข้าซ่อมถึงหน้างาน ลดเวลา Downtime ของสายการผลิต ไม่ต้องขนย้ายเครื่องจักรหนัก พร้อมอุปกรณ์ครบครัน'
        ],
        'priceSpecification' => [
            '@type' => 'PriceSpecification',
            'priceCurrency' => 'THB',
            'minPrice' => '300',
            'maxPrice' => '15000'
        ],
        'availability' => 'https://schema.org/InStock'
    ],
    [
        '@type' => 'Offer',
        'itemOffered' => [
            '@type' => 'Service',
            'name' => 'บริการเปลี่ยนมอเตอร์และอะไหล่เครื่องดูดฝุ่นโรงงาน',
            'description' => 'เปลี่ยนมอเตอร์และอะไหล่ทุกยี่ห้อ ใช้อะไหล่เกรดมาตรฐานโรงงาน พร้อมรับประกันงานซ่อมและอะไหล่ยาวนาน 3-6 เดือน'
        ],
        'priceSpecification' => [
            '@type' => 'PriceSpecification',
            'priceCurrency' => 'THB',
            'minPrice' => '300',
            'maxPrice' => '15000'
        ],
        'availability' => 'https://schema.org/InStock'
    ]
            ],
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => '4.9',
                'reviewCount' => '150',
                'bestRating' => '5',
                'worstRating' => '1'
            ],
            'potentialAction' => [
                [
                    '@type' => 'ReserveAction',
                    'target' => [
                        '@type' => 'EntryPoint',
                        'urlTemplate' => 'https://www.siriphong-vacuum.com/#contact', // ⚠️ แก้เป็นหน้าติดต่อจริง
                        'actionPlatform' => [
                            'http://schema.org/DesktopWebPlatform',
                            'http://schema.org/MobileWebPlatform'
                        ]
                    ],
                    'result' => [
                        '@type' => 'Reservation',
                        'name' => 'จองคิวตรวจซ่อมเครื่องดูดฝุ่นอุตสาหกรรม'
                    ]
                ],
                [
                    '@type' => 'ContactAction',
                    'target' => [
                        '@type' => 'EntryPoint',
                        'urlTemplate' => 'https://line.me/ti/p/Kqsti_kwU9', // ⚠️ แก้เป็น Line ID จริง
                        'actionPlatform' => [
                            'http://schema.org/DesktopWebPlatform',
                            'http://schema.org/MobileWebPlatform'
                        ]
                    ],
                    'result' => [
                        '@type' => 'ContactPoint',
                        'name' => 'แชท Line เพื่อสอบถามอาการและนัดหมาย'
                    ]
                ]
            ],
            'sameAs' => [
                // 'https://www.facebook.com/siriphongvacuum', // ⚠️ แก้เป็นเพจจริง
                'https://line.me/ti/p/Kqsti_kwU9', // ⚠️ แก้เป็น Line ID จริง
                // 'https://www.youtube.com/@siriphongvacuum' // ⚠️ แก้เป็น Channel จริง (ถ้ามี)
            ]
        ];

        return view('index', compact('schemaData'));
    }

    private function extractCoordinates(string $coordinates): array
    {
        $parts = array_map('trim', explode(',', $coordinates, 2));

        if (count($parts) !== 2 || ! is_numeric($parts[0]) || ! is_numeric($parts[1])) {
            return ['13.754198', '100.501705'];
        }

        return [(string) $parts[0], (string) $parts[1]];
    }
}
