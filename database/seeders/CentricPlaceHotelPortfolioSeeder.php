<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * เคสผลงาน: ตรวจเช็ค ล้างเครื่อง เปลี่ยนมอเตอร์ — โรงแรม Centric Place
 * /portfolio/pm-replace-motor-centric-place-hotel
 */
class CentricPlaceHotelPortfolioSeeder extends Seeder
{
    private const SLUG = 'pm-replace-motor-centric-place-hotel';

    private const IMAGE_BASE = 'https://pub-a9d72b3edcf74bf293a84deb6ffa217b.r2.dev/portfolio/pm-replace-motor-centric-place-hotel';

    /** รอบที่ 2 ซ่อนจนกว่า admin จะส่งข้อมูล */
    private bool $showRound2 = false;

    public function run(): void
    {
        $now = now();
        $shop = (string) config('contact.name', config('data.name'));
        $phone = (string) config('contact.phone', config('data.phone'));
        $phoneDisplay = (string) config('contact.phone_formatted', config('data.phone_formatted'));
        $line = (string) config('contact.line', config('data.line'));
        $address = (string) (config('contact.address_short') ?: config('data.address'));
        $area = (string) config('contact.area_served', 'กทม. สมุทรปราการ สมุทรสาคร นครปฐม นนทบุรี ปทุมธานี');
        $travelFree = (int) config('contact.travel_free_km', 10);

        $categoryId = DB::table('categories')
            ->where('type', 'portfolio')
            ->where('slug', 'hotel')
            ->value('id');

        if (! $categoryId) {
            $categoryId = DB::table('categories')
                ->where('type', 'portfolio')
                ->where('slug', 'company')
                ->value('id');
        }

        $payload = $this->casePayload(
            $shop,
            $phone,
            $phoneDisplay,
            $line,
            $address,
            $area,
            $travelFree,
            $categoryId ? (int) $categoryId : null
        );

        $existingId = DB::table('portfolios')->where('slug', self::SLUG)->value('id');

        if ($existingId) {
            DB::table('portfolios')->where('id', $existingId)->update(array_merge($payload, [
                'updated_at' => $now,
            ]));
        } else {
            DB::table('portfolios')->insert(array_merge($payload, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }

        $this->appendVacuumRepairCaseCard($now);
    }

    /**
     * @return array<string, mixed>
     */
    private function casePayload(
        string $shop,
        string $phone,
        string $phoneDisplay,
        string $line,
        string $address,
        string $area,
        int $travelFree,
        ?int $categoryId
    ): array {
        $img = self::IMAGE_BASE;
        $pageSlug = self::SLUG;
        $about = '/about-us';
        $deepClean = '/services/deep-clean';
        $motorRepair = '/services/motor-repair';
        $burntMotor = '/vacuum-repair/burnt-motor';
        $carbonBrush = '/services/carbon-brush';
        $schoolCase = '/portfolio/school-vacuum-wont-turn-on';
        $serviceRates = '/service-rates';
        $portfolio = '/portfolio';
        $contact = '/contact-us';

        $title = 'ซ่อมเครื่องดูดฝุ่น Electrolux และเปลี่ยนมอเตอร์ Karcher — โรงแรม Centric Place ดินแดง กรุงเทพฯ';

        $description = 'เคสโรงแรม Centric Place: ล้าง Electrolux 2 + เครื่องอุตสาหกรรม 1 รวม 700 บาท เปลี่ยนมอเตอร์ Karcher เปิดไม่ติด 1,050 บาท ประกัน 90 วัน ทัก LINE ประเมินฟรี';

        $metaTitle = 'ซ่อมเครื่องดูดฝุ่น Electrolux Karcher โรงแรม | ศิริพงษ์ เซอร์วิส';

        $round2Html = '';
        if ($this->showRound2) {
            $round2Html = <<<HTML
<h2>รอบที่ 2: เปลี่ยนมอเตอร์เครื่องดูดฝุ่นอุตสาหกรรม 4 ตัว</h2>
<p>รายละเอียดรอบที่ 2 จะเพิ่มภายหลังเมื่อได้รับข้อมูลจากงานจริง</p>
<figure>
<img src="{$img}/197982_0.webp" alt="มอเตอร์เครื่องดูดฝุ่นอุตสาหกรรม 4 ลูก วางเรียงก่อนเปลี่ยน" width="1200" height="900" loading="lazy">
</figure>
HTML;
        }

        $content = <<<HTML
<p>โรงแรม Centric Place ย่านดินแดง กรุงเทพฯ ให้<strong>{$shop}</strong>ตรวจเช็คเครื่องดูดฝุ่นที่ฝ่ายแม่บ้านใช้ทุกวัน รอบละ 4 เครื่อง ในรอบแรกช่างต้อยถอดทำความสะอาด 3 เครื่อง (Electrolux 2 เครื่อง และเครื่องดูดฝุ่นอุตสาหกรรม 1 เครื่อง) ค่าบริการ 700 บาท และ<a href="{$motorRepair}">เปลี่ยนมอเตอร์</a>เครื่อง Karcher ที่เปิดไม่ติด 1,050 บาท รวม 1,750 บาท รับประกันงานซ่อม 90 วัน</p>

<blockquote>
<p><strong>สรุปจากช่างต้อย</strong></p>
<ul>
<li>ลูกค้า: โรงแรม Centric Place ถนนอโศก-ดินแดง เขตดินแดง กรุงเทพฯ</li>
<li>รอบที่ 1: ตรวจ 4 เครื่อง → ถอดทำความสะอาด 3 เครื่อง + เปลี่ยนมอเตอร์ 1 เครื่อง</li>
<li>ค่าบริการรวม <strong>1,750 บาท</strong> (ล้าง 3 เครื่อง 700 บาท • เปลี่ยนมอเตอร์ Karcher 1,050 บาท)</li>
<li>Karcher เปิดไม่ติดเพราะมอเตอร์เสื่อมสภาพตามการใช้งาน ส่วนอีก 3 เครื่อง มอเตอร์ยังใช้ได้ แค่ล้างก็พอ</li>
<li>ระยะเวลา: ดำเนินการ 1 วัน</li>
</ul>
</blockquote>

<p><em>เขียนโดย <a href="{$about}">ศิริพงษ์ ชาศรพิทักษ์ (ช่างต้อย)</a> • ช่างซ่อมเครื่องดูดฝุ่นอุตสาหกรรมตั้งแต่ปี 2545 • อัปเดตล่าสุด 24 พฤศจิกายน 2569</em></p>

<table>
<thead>
<tr><th>สรุปงาน</th><th>รายละเอียด</th></tr>
</thead>
<tbody>
<tr><td>ประเภทลูกค้า</td><td>โรงแรม (ฝ่ายแม่บ้าน)</td></tr>
<tr><td>พื้นที่</td><td>ดินแดง กรุงเทพฯ</td></tr>
<tr><td>เครื่อง</td><td>Electrolux 2 เครื่อง • เครื่องดูดฝุ่นอุตสาหกรรม (ไม่ทราบยี่ห้อ) 1 เครื่อง • Karcher 1 เครื่อง</td></tr>
<tr><td>อาการ</td><td>Karcher เปิดไม่ติด • อีก 3 เครื่องเข้ารอบตรวจเช็ค</td></tr>
<tr><td>งานที่ทำ</td><td>ถอดทำความสะอาด 3 เครื่อง • เปลี่ยนมอเตอร์ 1 เครื่อง</td></tr>
<tr><td>ค่าบริการ</td><td>1,750 บาท</td></tr>
<tr><td>ระยะเวลา</td><td>ดำเนินการ 1 วัน</td></tr>
<tr><td>ปี</td><td>2569</td></tr>
</tbody>
</table>

<h2>ลูกค้าเจอปัญหาอะไร</h2>
<p>ในโรงแรม เครื่องดูดฝุ่นทำงานแทบทั้งวัน ทั้งดูดพรมห้องพัก ทางเดิน และล็อบบี้ ฝุ่น ขุยผ้า และเส้นผมจึงสะสมในเครื่องเร็วมาก ฝ่ายแม่บ้านแจ้งว่าเครื่อง Karcher เปิดไม่ติด และให้ช่างต้อยตรวจเครื่องที่เหลือไปพร้อมกัน เพื่อไม่ให้มีเครื่องเสียตอนทำห้อง</p>

<h2>ช่างต้อยตรวจเจออะไร</h2>
<figure>
<img src="{$img}/electrolux-01.webp" alt="ชิ้นส่วนเครื่องดูดฝุ่น Electrolux ตัวถังสีแดงที่ช่างต้อยถอดออกทีละชิ้นเพื่อทำความสะอาด" width="1200" height="900" loading="eager">
</figure>
<ul>
<li><strong>Electrolux 2 เครื่อง:</strong> ถอดออกมาแล้ว มอเตอร์ยังหมุนได้ แต่มีฝุ่นเกาะรอบตัวมอเตอร์และในตัวถัง เคสแบบนี้ไม่ต้องเปลี่ยนอะไหล่ ถอดล้างก็พอ</li>
<li><strong>เครื่องดูดฝุ่นอุตสาหกรรม (ไม่ทราบยี่ห้อ) 1 เครื่อง:</strong> ฝุ่นอัดเป็นก้อนรอบมอเตอร์และฐานเครื่อง ลมระบายความร้อนผ่านไม่สะดวก ถ้าปล่อยไว้ มอเตอร์จะร้อนจัดจนไหม้ได้</li>
<li><strong>Karcher 1 เครื่อง (เปิดไม่ติด):</strong> ตรวจแล้วพบว่ามอเตอร์เสื่อมสภาพตามการใช้งาน ซ่อมไม่คุ้ม จึงเปลี่ยนมอเตอร์ใหม่</li>
</ul>
<figure>
<img src="{$img}/electrolux-03.webp" alt="ฝุ่นอัดเป็นก้อนรอบมอเตอร์ของเครื่องดูดฝุ่นอุตสาหกรรมถังสีน้ำเงินในโรงแรม" width="1200" height="900" loading="lazy">
</figure>
<figure>
<img src="{$img}/197984_0.webp" alt="มอเตอร์เครื่องดูดฝุ่น Karcher ที่เสื่อมสภาพตามการใช้งาน สาเหตุที่เครื่องเปิดไม่ติด" width="1200" height="900" loading="lazy">
</figure>
<p>หลักของช่างต้อยคือ แยกให้ชัดว่าเครื่องไหน "แค่สกปรก" และเครื่องไหน "อะไหล่พังจริง" ในรอบนี้ 3 ใน 4 เครื่องแค่ล้าง ลูกค้าจึงจ่ายค่าเปลี่ยนอะไหล่แค่เครื่องเดียว</p>

<h2>ซ่อมยังไง</h2>
<p><strong><a href="{$deepClean}">ถอดทำความสะอาด</a> 3 เครื่อง (Electrolux 2 + เครื่องอุตสาหกรรม 1)</strong></p>
<figure>
<img src="{$img}/electrolux-02.webp" alt="ชิ้นส่วนเครื่องดูดฝุ่น Electrolux ทั้งตัวถัง ฝาครอบมอเตอร์ และสายไฟ วางเรียงระหว่างถอดล้าง" width="1200" height="900" loading="lazy">
</figure>
<ol>
<li>ถอดตัวถัง ฝาครอบ ไส้กรอง และท่อดูด ออกทีละชิ้น</li>
<li>ถอดมอเตอร์ออกมาเป่าฝุ่นที่เกาะรอบตัวมอเตอร์และช่องลม</li>
<li>ล้างตัวถังและท่อ ทำความสะอาดไส้กรอง</li>
<li>เช็ค<a href="{$carbonBrush}">แปรงถ่าน</a> (ชิ้นส่วนที่ส่งไฟเข้ามอเตอร์) และสายไฟ</li>
<li>ประกอบกลับ แล้วทดสอบแรงดูดก่อนส่งคืน</li>
</ol>
<figure>
<img src="{$img}/197980_0.webp" alt="ช่างต้อยถือมอเตอร์ที่ถอดจากเครื่องดูดฝุ่น Electrolux มีฝุ่นเกาะรอบตัวมอเตอร์" width="1200" height="900" loading="lazy">
</figure>
<figure>
<img src="{$img}/197981_0.webp" alt="มอเตอร์เครื่องดูดฝุ่นที่ถอดออกมาแล้ว ก่อนทำความสะอาดรอบตัวมอเตอร์" width="1200" height="900" loading="lazy">
</figure>

<p><strong><a href="{$motorRepair}">เปลี่ยนมอเตอร์ Karcher</a> (1 เครื่อง)</strong></p>
<ol>
<li>ถอดมอเตอร์ตัวเดิมออก แล้วเลือกมอเตอร์ใหม่ที่ขนาดและกำลังไฟเข้ากับเครื่อง</li>
<li>ใส่มอเตอร์ใหม่ เดินสายไฟ และยึดฐานให้แน่น</li>
<li>เปิดทดสอบต่อเนื่อง ฟังเสียง เช็คความร้อน และแรงดูด</li>
</ol>
<figure>
<img src="{$img}/197983_0.webp" alt="มอเตอร์เครื่องดูดฝุ่นถอดฝาครอบออก เห็นแกนและใบพัด ระหว่างเปลี่ยนมอเตอร์" width="1200" height="900" loading="lazy">
</figure>

<h2>ค่าซ่อมเท่าไหร่</h2>
<table>
<thead>
<tr><th>งาน</th><th>จำนวน</th><th>ค่าบริการ</th></tr>
</thead>
<tbody>
<tr><td>ถอดทำความสะอาดเครื่องดูดฝุ่น (Electrolux 2 + อุตสาหกรรม 1)</td><td>3 เครื่อง</td><td>700 บาท</td></tr>
<tr><td>เปลี่ยนมอเตอร์เครื่องดูดฝุ่น Karcher (เปิดไม่ติด)</td><td>1 เครื่อง</td><td>1,050 บาท</td></tr>
<tr><td><strong>รวม</strong></td><td><strong>4 เครื่อง</strong></td><td><strong>1,750 บาท</strong></td></tr>
</tbody>
</table>
<p>ค่าซ่อมของแต่ละเครื่องขึ้นกับรุ่น อาการ และอะไหล่ ช่างต้อยแจ้งราคาพร้อมใบเสนอราคาก่อนซ่อมทุกครั้ง ถ้าโรงแรมหรือบริษัทต้องการใบกำกับภาษี ขอได้โดยออกในนามบริษัทพาร์ทเนอร์ ให้แจ้งตอนขอใบเสนอราคาครับ</p>
<p>ราคาเคสนี้เป็นราคาเหมาดูแลหลายเครื่องในรอบเดียวกัน — <a href="{$serviceRates}">ดูราคาซ่อมทั้งหมด</a></p>
<p data-cta-wrap="mid"><a href="{$line}" data-cta="line" data-position="mid" data-page="{$pageSlug}">💬 เครื่องดูดฝุ่นในโรงแรมหรือออฟฟิศเปิดไม่ติด หรือแรงตก? ส่งรูปป้ายรุ่นทาง LINE ช่างต้อยประเมินให้ฟรี</a></p>

<h2>ผลลัพธ์</h2>
<figure>
<img src="{$img}/197979_0.webp" alt="ชิ้นส่วนเครื่องดูดฝุ่น Electrolux หลังทำความสะอาด พร้อมประกอบกลับ" width="1200" height="900" loading="lazy">
</figure>
<p>เครื่อง Karcher กลับมาเปิดติดและดูดได้ปกติ ส่วนอีก 3 เครื่องแรงดูดกลับมาหลังล้าง ส่งคืนฝ่ายแม่บ้านพร้อมประกันงานซ่อม 90 วัน หลังจากรอบแรก โรงแรมเรียกช่างต้อยกลับไปตรวจอีกรอบ</p>
{$round2Html}

<h2>บทเรียนจากเคสนี้</h2>
<p>เครื่องดูดฝุ่นที่แรงตกส่วนใหญ่ยังไม่ได้แปลว่ามอเตอร์พัง แต่ถ้าฝุ่นอัดรอบมอเตอร์นาน ๆ มอเตอร์จะร้อนจัดและเสื่อมเร็วขึ้น จนกลายเป็นอาการ "เปิดไม่ติด" แบบเครื่อง Karcher ในเคสนี้ที่มอเตอร์เสื่อมสภาพตามการใช้งาน โรงแรมที่ใช้เครื่องทุกวันจึงควรเรียกช่างเข้าไปถอดล้างเป็นรอบ ๆ ตามที่สะดวก ค่าล้างถูกกว่าค่าเปลี่ยนมอเตอร์มาก ถ้าได้กลิ่นไหม้ร่วมด้วย ดูอาการ <a href="{$burntMotor}">มอเตอร์ไหม้</a> เพิ่มได้</p>

<h2>คำถามที่พบบ่อย</h2>
<h3>ร้านซ่อมเครื่องดูดฝุ่น Electrolux ที่รับงานโรงแรมและบริษัทมีที่ไหน?</h3>
<p>ศิริพงษ์ เซอร์วิส ราษฎร์บูรณะ กรุงเทพฯ รับซ่อมเครื่องดูดฝุ่น Electrolux และเครื่องดูดฝุ่นงานหนักทุกยี่ห้อ ไฟ 1 เฟส ช่างไปหน้างานได้ในกรุงเทพฯ สมุทรปราการ สมุทรสาคร นครปฐม นนทบุรี และปทุมธานี จังหวัดอื่นส่งเครื่องมาทางขนส่งได้ ร้านไม่รับเครื่องไร้สายและหุ่นยนต์ดูดฝุ่นครับ</p>
<h3>เครื่องดูดฝุ่นอีเลคโทรลักซ์ ราคาซ่อมเท่าไหร่ คุ้มกว่าซื้อใหม่ไหม?</h3>
<p>ส่วนใหญ่คุ้มกว่า ถ้ามอเตอร์ยังดี ในเคสโรงแรมนี้ ค่าถอดทำความสะอาด 3 เครื่องรวม 700 บาท ซึ่งถูกกว่าซื้อเครื่องใหม่มาก ส่งรูปป้ายรุ่นกับคลิปอาการทาง LINE ได้ ช่างต้อยจะบอกตรง ๆ ว่าคุ้มซ่อมไหม ถ้าไม่คุ้มก็จะไม่ฝืนซ่อมครับ</p>
<h3>เครื่องดูดฝุ่น Karcher เปิดไม่ติด เปลี่ยนมอเตอร์ได้ไหม?</h3>
<p>เปลี่ยนได้ ถ้าตรวจแล้วพบว่ามอเตอร์เสื่อมหรือเสีย ในเคสนี้มอเตอร์ Karcher เสื่อมสภาพตามการใช้งาน ค่าเปลี่ยน 1,050 บาท ราคาจริงขึ้นกับรุ่นและกำลังมอเตอร์ ก่อนเปลี่ยนช่างต้อยจะเช็คสายไฟ สวิตช์ และแปรงถ่านก่อน เพราะบางครั้งเปิดไม่ติดแค่เพราะจุดเหล่านี้ ทุกงานแจ้งราคาก่อนซ่อม และรับประกันงานซ่อม 90 วันครับ <a href="{$schoolCase}">อีกเคสเครื่องเปิดไม่ติด</a></p>

<h2>เครื่องดูดฝุ่นในโรงแรม ออฟฟิศ หรือร้านของคุณเริ่มมีอาการ? ทักช่างต้อยได้เลย</h2>
<ul>
<li>💬 ส่งรูปป้ายรุ่น + คลิปอาการทาง LINE ช่างต้อยประเมินให้ฟรี → <a href="{$line}" data-cta="line" data-position="end" data-page="{$pageSlug}">ทักไลน์ประเมินฟรี</a></li>
<li>📞 โทร <a href="tel:{$phone}" data-cta="tel" data-position="end" data-page="{$pageSlug}">{$phoneDisplay}</a> (เปิดทุกวัน 08:00–18:00 • เครื่องเสียด่วน ทักไว้ได้ 24 ชม.)</li>
<li>📍 {$address} • ช่างไปหน้างาน {$area} (ฟรี {$travelFree} กม.แรก) • ส่งขนส่งได้ทุกจังหวัด • <a href="{$contact}">ติดต่อเรา</a></li>
</ul>
<p><a href="{$portfolio}">← กลับไปหน้าผลงานทั้งหมด</a></p>
HTML;

        return [
            'category_id' => $categoryId,
            'category_label' => 'Electrolux / Karcher',
            'title' => $title,
            'slug' => self::SLUG,
            'description' => $description,
            'content' => $content,
            'fault' => 'Karcher มอเตอร์เสื่อมสภาพตามการใช้งาน • อีก 3 เครื่องฝุ่นอัดรอบมอเตอร์',
            'symptom' => 'Karcher เปิดไม่ติด • ฝ่ายแม่บ้านให้ตรวจเครื่องที่เหลือพร้อมกัน',
            'found' => 'Karcher มอเตอร์เสื่อมสภาพตามการใช้งาน — Electrolux 2 + เครื่องอุตสาหกรรม 1 มอเตอร์ยังใช้ได้ แค่ล้างก็พอ',
            'fixed' => 'ถอดทำความสะอาด 3 เครื่อง 700 บาท + เปลี่ยนมอเตอร์ Karcher 1,050 บาท รวม 1,750 บาท ประกันงานซ่อม 90 วัน',
            'brands' => 'Electrolux / Karcher',
            'image' => $img.'/electrolux-01.webp',
            'before_image' => null,
            'after_image' => $img.'/197979_0.webp',
            'year' => '2569',
            'duration' => 'ดำเนินการ 1 วัน',
            'price' => '1,750 บาท',
            'status_label' => 'สำเร็จ',
            'sort_order' => 0,
            'is_active' => true,
            'meta_title' => $metaTitle,
            'meta_description' => $description,
            'related_blog_id' => null,
        ];
    }

    private function appendVacuumRepairCaseCard(\DateTimeInterface|string $now): void
    {
        $page = DB::table('pages')
            ->whereNull('parent_id')
            ->where('slug', 'vacuum-repair')
            ->first();

        if (! $page) {
            return;
        }

        $blocks = json_decode((string) $page->blocks, true);
        if (! is_array($blocks)) {
            return;
        }

        $items = $blocks['cases']['items'] ?? [];
        if (! is_array($items)) {
            $items = [];
        }

        $hotelCase = [
            'title' => 'โรงแรม Centric Place ดินแดง — ล้าง 3 เปลี่ยนมอเตอร์ 1',
            'category' => 'โรงแรม',
            'symptom' => 'Karcher เปิดไม่ติด และให้ตรวจเครื่อง Electrolux / อุตสาหกรรมไปพร้อมกัน',
            'found' => 'มอเตอร์ Karcher เสื่อมสภาพตามการใช้งาน ส่วนอีก 3 เครื่องแค่ฝุ่นอัดรอบมอเตอร์',
            'fixed' => 'ถอดล้าง 3 เครื่อง + เปลี่ยนมอเตอร์ Karcher รวม 1,750 บาท',
            'days' => 'ดำเนินการ 1 วัน',
            'price' => '1,750 บาท',
            'image' => self::IMAGE_BASE.'/electrolux-01.webp',
            'url' => '/portfolio/'.self::SLUG,
        ];

        $replaced = false;
        foreach ($items as $index => $item) {
            if (($item['url'] ?? null) === $hotelCase['url']
                || str_contains((string) ($item['title'] ?? ''), 'Centric Place')) {
                $items[$index] = $hotelCase;
                $replaced = true;
                break;
            }
        }

        if (! $replaced) {
            array_unshift($items, $hotelCase);
        }

        $blocks['cases']['items'] = $items;
        $blocks['cases']['heading'] = $blocks['cases']['heading'] ?? 'ตัวอย่างงานที่ซ่อมไปแล้ว';

        DB::table('pages')->where('id', $page->id)->update([
            'blocks' => json_encode($blocks, JSON_UNESCAPED_UNICODE),
            'updated_at' => $now,
        ]);
    }
}
