<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Faq;
use App\Models\Product;
use App\Support\Schema\JsonLdBuilder;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(private JsonLdBuilder $schema) {}

    public function index(): View
    {
        $productCategories = Category::query()
            ->where('type', 'product')
            ->orderBy('sort_order')
            ->get();

        $serviceCategories = Category::query()
            ->where('type', 'service')
            ->orderBy('sort_order')
            ->get();

        $products = Product::query()
            ->with('category')
            ->where('type', 'product')
            ->where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('id')
            ->get();

        $services = Product::query()
            ->with('category')
            ->where('type', 'service')
            ->where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('id')
            ->get();

        $phone = (string) config('data.phone_formatted');
        $shop = (string) config('data.name');
        $areas = implode(' ', config('schema.local_business.area_served', [
            'กรุงเทพมหานคร',
            'นนทบุรี',
            'ปทุมธานี',
            'สมุทรปราการ',
        ]));

        $minProductPrice = $products
            ->filter(fn (Product $p) => (float) $p->price > 0)
            ->min(fn (Product $p) => (float) ($p->sale_price ?? $p->price));

        $priceRows = $this->industrialVacuumPriceRows($products);
        $faqs = $this->industrialVacuumFaqs();

        $pageUrl = route('products.index');
        $title = 'เครื่องดูดฝุ่นโรงงานอุตสาหกรรม แรงดูดสูง ขนาดเล็ก-ใหญ่ พร้อมราคา';
        $description = 'จำหน่ายเครื่องดูดฝุ่นโรงงานอุตสาหกรรม ขนาดเล็กถึงขนาดใหญ่ แรงดูดสูง ดูดแห้ง-เปียก มีรุ่นไร้สาย พร้อมบริการซ่อมและอะไหล่ ขอใบเสนอราคาฟรี โทร '.$phone;
        $serviceName = 'เครื่องดูดฝุ่นโรงงานอุตสาหกรรม แรงดูดสูง ครบทุกขนาด พร้อมบริการซ่อมหลังการขาย';
        $serviceDescription = 'เครื่องดูดฝุ่นโรงงานอุตสาหกรรม ขนาดเล็ก 15 ลิตร ถึงขนาดใหญ่ 100 ลิตรขึ้นไป ทั้งรุ่นดูดแห้ง-เปียก รุ่นแรงดูดสูง และรุ่นไร้สาย พร้อมบริการซ่อมและอะไหล่หลังการขาย';

        $schemaGraph = $this->schema->buildProductsHubSchema(
            $products->concat($services),
            $pageUrl,
            $title,
            [
                ['name' => 'หน้าแรก', 'url' => route('home')],
                ['name' => 'สินค้าและบริการ', 'url' => null],
            ],
            collect($faqs),
            $serviceName,
            $serviceDescription,
        );

        return view('frontend.products.index', compact(
            'productCategories',
            'serviceCategories',
            'products',
            'services',
            'title',
            'description',
            'schemaGraph',
            'phone',
            'shop',
            'areas',
            'minProductPrice',
            'priceRows',
            'faqs',
            'serviceName',
        ));
    }

    /**
     * @param  \Illuminate\Support\Collection<int, Product>  $products
     * @return list<array{size: string, model: string, price: string}>
     */
    private function industrialVacuumPriceRows($products): array
    {
        $format = function (?Product $product, string $fallbackModel): array {
            if ($product === null) {
                return [
                    'size' => '',
                    'model' => $fallbackModel,
                    'price' => 'สอบถามรุ่นที่เหมาะกับหน้างาน',
                ];
            }

            $amount = (float) ($product->sale_price ?? $product->price);

            return [
                'size' => '',
                'model' => $product->name,
                'price' => $amount > 0
                    ? number_format($amount, 0).' บาท'
                    : 'สอบถามราคา',
            ];
        };

        $byCapacity = $products->filter(function (Product $p) {
            $haystack = $p->name.' '.$p->short_description;

            return $p->category?->slug === 'industrial-vacuum'
                || str_contains($haystack, 'ลิตร');
        });

        $small = $byCapacity->first(function (Product $p) {
            return (bool) preg_match('/(?:15|20|25|30)\s*ลิตร/u', $p->name.' '.$p->short_description);
        });
        $medium = $byCapacity->first(function (Product $p) {
            return (bool) preg_match('/(?:60|65|70)\s*ลิตร/u', $p->name.' '.$p->short_description);
        });
        $large = $byCapacity->first(function (Product $p) {
            return (bool) preg_match('/(?:80|90|100)\s*ลิตร/u', $p->name.' '.$p->short_description);
        });

        return [
            array_merge($format($small, 'รุ่นขนาดเล็ก'), ['size' => 'ขนาดเล็ก 15–30 ลิตร']),
            array_merge($format($medium, 'รุ่นขนาดกลาง'), ['size' => 'ขนาดกลาง 60–70 ลิตร']),
            array_merge($format($large, 'รุ่นขนาดใหญ่'), ['size' => 'ขนาดใหญ่ 80–100 ลิตร']),
            [
                'size' => 'ขนาดใหญ่ 3 เฟส',
                'model' => 'เทอร์ไบน์ 380 V',
                'price' => 'สอบถามตามหน้างาน',
            ],
            [
                'size' => 'รุ่นไร้สาย',
                'model' => 'แบตเตอรี่ลิเธียม',
                'price' => 'สอบถามรุ่นที่เหมาะกับหน้างาน',
            ],
        ];
    }

    /**
     * @return list<array{question: string, answer: string}>
     */
    private function industrialVacuumFaqs(): array
    {
        return [
            [
                'question' => 'เครื่องดูดฝุ่นโรงงานอุตสาหกรรมต่างจากเครื่องดูดฝุ่นบ้านอย่างไร?',
                'answer' => 'เครื่องดูดฝุ่นโรงงานอุตสาหกรรมมีมอเตอร์แรงกว่า ถังใหญ่กว่า และทนกว่าเครื่องดูดฝุ่นบ้าน รุ่นไฟ 220 V ใช้มอเตอร์ 1–3 ตัว รวม 1,000–3,600 วัตต์ ถังจุ 15–100 ลิตร ดูดได้ทั้งฝุ่นแห้ง เศษวัสดุหนัก และน้ำ ขณะที่เครื่องบ้านจุได้ราว 1–3 ลิตร และไม่ได้ออกแบบมาสำหรับเศษโลหะ ฝุ่นปูน หรือของเหลว',
            ],
            [
                'question' => 'เครื่องดูดฝุ่นอุตสาหกรรม ขนาดเล็ก กับขนาดใหญ่ ควรเลือกแบบไหน?',
                'answer' => 'เลือกตามปริมาณฝุ่นต่อวันและความถี่ในการย้ายเครื่อง เครื่องดูดฝุ่นอุตสาหกรรม ขนาดเล็ก 15–30 ลิตร เหมาะกับงานเก็บจุดย่อยและต้องยกย้ายบ่อย เครื่องดูดฝุ่นอุตสาหกรรม ขนาดใหญ่ 80–100 ลิตร 3 มอเตอร์ เหมาะกับพื้นที่กว้างและฝุ่นหรือน้ำปริมาณมาก หากฝุ่นเกินครึ่งถังเล็กต่อวัน ควรเลือกขนาดที่ใหญ่ขึ้น',
            ],
            [
                'question' => 'เครื่องดูดฝุ่นอุตสาหกรรม ไร้สาย ใช้งานได้นานแค่ไหน?',
                'answer' => 'เครื่องดูดฝุ่นอุตสาหกรรม ไร้สาย โดยทั่วไปใช้งานได้ราว 20–60 นาทีต่อการชาร์จ 1 ครั้ง ขึ้นกับความจุแบตเตอรี่และระดับแรงดูดที่เปิด เหมาะกับจุดที่ไม่มีปลั๊ก พื้นที่สูง และงานเก็บเร็วระหว่างกะ หากต้องใช้ต่อเนื่องควรมีแบตเตอรี่สำรองอย่างน้อย 1 ก้อน หรือใช้รุ่นมีสายเป็นเครื่องหลัก',
            ],
            [
                'question' => 'เครื่องดูดฝุ่น แรงดูดสูง ดูที่จำนวนวัตต์ได้ไหม?',
                'answer' => 'ดูที่วัตต์อย่างเดียวไม่ได้ เพราะวัตต์บอกการกินไฟ ไม่ใช่แรงดูด เครื่องดูดฝุ่น แรงดูดสูง ต้องดู 2 ค่า คือ แรงดันสุญญากาศ หน่วย kPa หรือ mmH₂O ซึ่งบอกแรงยกวัสดุหนัก และปริมาณลม หน่วยลิตรต่อวินาที ซึ่งบอกปริมาณที่ดูดได้ รุ่นไฟ 220 V ทั่วไปมีแรงดันสุญญากาศราว 2,000–2,400 mmH₂O',
            ],
            [
                'question' => 'เครื่องดูดฝุ่นโรงงานอุตสาหกรรมดูดน้ำได้ไหม?',
                'answer' => 'รุ่นดูดแห้ง-เปียกดูดน้ำได้ แต่ต้องถอดถุงกรองหรือไส้กรองกระดาษออกก่อนทุกครั้ง และตรวจว่าลูกลอยตัดการดูดทำงานปกติ เพื่อไม่ให้น้ำเข้ามอเตอร์ รุ่นขนาดใหญ่ 80 ลิตรขึ้นไปมักมีสายระบายน้ำทิ้งที่ก้นถัง จึงไม่ต้องยกถังเท ส่วนรุ่นดูดแห้งอย่างเดียวห้ามใช้ดูดของเหลว',
            ],
            [
                'question' => 'ต้องบำรุงรักษาเครื่องดูดฝุ่นอุตสาหกรรมอย่างไร?',
                'answer' => 'งานบำรุงรักษาหลักมี 3 อย่าง คือ เทถังและเคาะหรือล้างไส้กรองหลังใช้งานทุกวัน ตรวจสายดูดและข้อต่อว่าไม่รั่วทุกสัปดาห์ และตรวจแปรงถ่านมอเตอร์ตามชั่วโมงใช้งานที่ผู้ผลิตกำหนด ไส้กรองที่ตันทำให้แรงดูดตกและมอเตอร์ร้อนจัด ซึ่งเป็นสาเหตุที่พบบ่อยของมอเตอร์ไหม้',
            ],
        ];
    }

    public function show(string $slug): View
    {
        $product = Product::query()
            ->with(['category', 'images', 'approvedReviews'])
            ->where('type', 'product')
            ->where('is_active', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $faqs = Faq::query()->active()->forCategory('sale')->ordered()->get();
        $reviews = $product->approvedReviews;

        $relatedService = Product::query()
            ->where('type', 'service')
            ->where('is_active', true)
            ->where('slug', 'diagnosis')
            ->first();

        $schemaGraph = $this->schema->buildProductSchema(
            $product,
            $faqs,
            $reviews,
            $relatedService ? route('services.show', $relatedService->slug) : null,
        );

        $title = ($product->meta_title ?: $product->name).' | ศิริพงษ์ เซอร์วิส';
        $description = $product->meta_description ?: $product->short_description;

        return view('frontend.products.show', compact(
            'product',
            'faqs',
            'reviews',
            'schemaGraph',
            'title',
            'description',
        ));
    }

    public function category(string $slug): View
    {
        $category = Category::query()
            ->where('type', 'product')
            ->where('slug', $slug)
            ->firstOrFail();

        $items = Product::query()
            ->where('category_id', $category->id)
            ->where('type', 'product')
            ->where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('id')
            ->get();

        $pageUrl = route('products.category', $category->slug);
        $schemaGraph = $this->schema->buildCatalogSchema(
            $items,
            $pageUrl,
            $category->name,
            [
                ['name' => 'หน้าแรก', 'url' => route('home')],
                ['name' => 'สินค้าและบริการ', 'url' => route('products.index')],
                ['name' => $category->name, 'url' => null],
            ],
        );

        $title = $category->name.' | ศิริพงษ์ เซอร์วิส';
        $description = 'รายการ'.$category->name.' เครื่องดูดฝุ่นอุตสาหกรรมและอะไหล่';

        return view('frontend.products.category', compact(
            'category',
            'items',
            'schemaGraph',
            'title',
            'description',
        ));
    }

    public function showService(string $slug): View
    {
        $service = Product::query()
            ->with('category')
            ->where('type', 'service')
            ->where('is_active', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $faqs = Faq::query()->active()->forCategory('repair')->ordered()->get();

        $serviceOffers = Product::query()
            ->where('type', 'service')
            ->where('is_active', true)
            ->orderBy('id')
            ->get();

        $schemaGraph = $this->schema->buildServiceSchema($service, $serviceOffers, $faqs);

        $title = ($service->meta_title ?: $service->name).' | ศิริพงษ์ เซอร์วิส';
        $description = $service->meta_description ?: $service->short_description;

        return view('frontend.services.show', compact(
            'service',
            'faqs',
            'schemaGraph',
            'title',
            'description',
        ));
    }
}
