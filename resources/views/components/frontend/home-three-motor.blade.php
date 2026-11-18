@php
  $case = \App\Models\Portfolio::query()->where('slug', 'case-repair-vacuum-3-motors-carwash')->first();
  $caseImage = $case?->imageUrl();
  $products = \App\Models\Product::query()
      ->where('type', 'product')
      ->where('is_active', true)
      ->whereIn('slug', ['wp-bf-585-60', 'wp-bf-585-80'])
      ->get()
      ->sortBy(fn ($product) => $product->slug === 'wp-bf-585-60' ? 0 : 1)
      ->values();
@endphp

<section class="py-14 bg-white" aria-labelledby="three-motor-title">
  <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-[1.2fr_.8fr] gap-8 items-start">
      <div>
        <h2 id="three-motor-title" class="font-display font-bold leading-tight text-navy text-[clamp(1.6rem,4vw,2.4rem)]">
          เครื่องดูดฝุ่น 3 มอเตอร์ ร้านซ่อมได้ไหม มีขายไหม?
        </h2>
        <p class="mt-4 text-slate-600 leading-relaxed">
          ได้ทั้งซ่อมและขายครับ เครื่องดูดฝุ่น 3 มอเตอร์เป็นเครื่องดูดฝุ่นอุตสาหกรรมหนักที่คาร์แคร์และโรงงานใช้กันมาก เพราะมีมอเตอร์ 3 ตัวรวมประมาณ 3,000 วัตต์ เลือกเปิดทีละตัวได้ และยังใช้ไฟบ้าน 220V ร้านรับซ่อมทุกยี่ห้อ และมีขายรุ่นถัง 60 กับ 80 ลิตร
        </p>
        <p class="mt-4 rounded-xl bg-orange/[.08] border border-orange/25 px-4 py-3 text-slate-700 leading-relaxed">
          <strong>"3 มอเตอร์" ไม่ใช่ "ไฟ 3 เฟส"</strong> — เครื่อง 3 มอเตอร์คือเครื่องที่มีมอเตอร์ 3 ตัวและเสียบไฟบ้านได้ <strong>ร้านรับซ่อม</strong> ส่วนเครื่องที่ใช้ไฟโรงงาน 3 เฟส (380V) <strong>ร้านไม่รับซ่อม</strong> ถ้าไม่แน่ใจ ให้ถ่ายรูปป้ายรุ่นหลังเครื่องส่งมาทาง LINE ได้เลยครับ
        </p>
        <p class="mt-4 text-slate-600 leading-relaxed">
          <strong>เคสจริง:</strong> ร้านล้างรถย่านงามวงศ์วาน เครื่อง 3 มอเตอร์เสีย ช่างต้อยไปซ่อมที่ร้านลูกค้า จบในวันเดียว →
          <a href="{{ route('portfolio.cases.show', 'case-repair-vacuum-3-motors-carwash') }}" class="font-semibold text-navy underline decoration-orange/50 underline-offset-2 hover:text-orange">เคสซ่อมเครื่อง 3 มอเตอร์ ร้านล้างรถงามวงศ์วาน</a>
        </p>
      </div>

      @if ($caseImage)
        <figure class="overflow-hidden rounded-2xl border border-slate-200 bg-offwhite">
          <img
            src="{{ $caseImage }}"
            alt="{{ $case->title }}"
            width="1200"
            height="800"
            class="w-full h-full object-cover"
            loading="lazy">
        </figure>
      @endif
    </div>

    @if ($products->isNotEmpty())
      <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
        @foreach ($products as $product)
          @php
            $sale = $product->sale_price !== null ? (float) $product->sale_price : null;
            $base = (float) $product->price;
            $current = ($sale !== null && $sale > 0 && ($base <= 0 || $sale < $base)) ? $sale : ($base > 0 ? $base : null);
          @endphp
          <a href="{{ route('products.show', $product->slug) }}" class="group flex gap-4 rounded-2xl border border-slate-200 bg-offwhite p-4 transition-all hover:border-orange hover:shadow-md">
            @if ($product->imageUrl())
              <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" width="120" height="120" class="w-24 h-24 object-contain rounded-xl bg-white" loading="lazy">
            @endif
            <span>
              <span class="block font-display font-bold text-navy group-hover:text-orange">{{ $product->name }}</span>
              @if ($product->short_description)
                <span class="mt-1 block text-sm text-slate-600 line-clamp-2">{{ $product->short_description }}</span>
              @endif
              @if ($current)
                <span class="mt-2 block text-sm font-bold text-orange">฿{{ number_format($current, 0) }}</span>
              @endif
            </span>
          </a>
        @endforeach
      </div>
    @endif

    <a href="{{ three_motor_url() }}" class="mt-8 inline-flex items-center gap-2 font-bold text-navy hover:text-orange">
      ดูทุกเรื่องของเครื่องดูดฝุ่น 3 มอเตอร์ — ซ่อม ราคา วิธีเลือก →
    </a>
  </div>
</section>
