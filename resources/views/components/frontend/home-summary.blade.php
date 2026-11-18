@php
  $tank = \App\Models\Product::query()
      ->where('slug', 'wp-bf-585-60')
      ->where('type', 'product')
      ->where('is_active', true)
      ->first();
  $startPrice = null;
  if ($tank) {
      $sale = $tank->sale_price !== null ? (float) $tank->sale_price : null;
      $base = (float) $tank->price;
      if ($sale !== null && $sale > 0 && ($base <= 0 || $sale < $base)) {
          $startPrice = $sale;
      } elseif ($base > 0) {
          $startPrice = $base;
      }
  }
@endphp

<section class="py-10 bg-white" aria-labelledby="summary-title">
  <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
    <div class="rounded-2xl border border-orange/30 bg-orange/[.06] p-6 md:p-8">
      <h2 id="summary-title" class="font-display font-bold text-navy text-xl md:text-2xl">สรุปสั้น ๆ จากช่างต้อย</h2>
      <ul class="mt-4 space-y-2 text-slate-700 leading-relaxed">
        <li>ซ่อมเครื่องดูดฝุ่นอุตสาหกรรมไฟบ้าน 1 เฟส ขนาด 30 ลิตรขึ้นไป <strong>ทุกยี่ห้อ</strong> รวมรุ่น 1–3 มอเตอร์</li>
        <li>ค่าซ่อมประมาณ <strong>300–8,000 บาท</strong> • ค่าตรวจเช็ค 250 บาท <strong>หักคืนเต็มถ้าซ่อมต่อ</strong></li>
        <li>รับประกันงานซ่อม <strong>90 วัน</strong> อาการเดิมกลับมา ซ่อมให้ฟรี</li>
        <li>ช่างไปหน้างาน {{ config('contact.area_served') }} (<strong>ฟรี {{ config('contact.travel_free_km') }} กม.แรก</strong>) • จังหวัดอื่นส่งขนส่งมาได้</li>
        <li>
          ขายเครื่องดูดฝุ่นโรงงาน 3 มอเตอร์
          @if ($startPrice)
            เริ่ม <strong>{{ number_format($startPrice, 0) }} บาท</strong>
          @else
            รุ่นถัง 60 และ 80 ลิตร
          @endif
          • เช่าเครื่องสำรองระหว่างซ่อม <strong>500 บาท/เดือน</strong>
        </li>
      </ul>
      <p class="mt-5 text-xs text-slate-500 leading-relaxed">
        ดูแลเนื้อหาโดย
        <a href="{{ route('pages.show', 'about-us') }}" class="font-semibold text-navy underline decoration-orange/50 underline-offset-2 hover:text-orange">{{ config('contact.owner_name') }} ({{ config('contact.nickname') }})</a>
        • ช่างซ่อมเครื่องดูดฝุ่นอุตสาหกรรมตั้งแต่ปี {{ config('contact.founding_year_be') }} • อัปเดตล่าสุด 18 พฤศจิกายน 2569
      </p>
    </div>
  </div>
</section>
