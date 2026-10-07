@extends('layout.frontend')

@php
  $gradients = [
    'bg-[linear-gradient(135deg,#0f2347_0%,#3d5a80_100%)]',
    'bg-[linear-gradient(135deg,#1e4a8a,#0f2347)]',
    'bg-[linear-gradient(135deg,#1a3a6b,#0d2b5e)]',
    'bg-[linear-gradient(135deg,#2a5298,#1a3a6b)]',
  ];
  $serviceCategoryIcons = [
    'motor' => 'bi-gear-wide-connected',
    'filter' => 'bi-funnel-fill',
    'electrical' => 'bi-lightning-charge-fill',
    'pipe' => 'bi-bezier2',
  ];
  $productCategoryIcons = [
    'industrial-vacuum' => 'bi-wind',
    'spare-parts' => 'bi-box-seam',
  ];
  $priceFrom = $minProductPrice
    ? number_format((float) $minProductPrice, 0)
    : null;
@endphp

@section('content')

  {{-- Hero --}}
  <section
    class="relative overflow-hidden py-12 md:py-16 bg-[linear-gradient(160deg,#0f2347_0%,#1a3a6b_55%,#1e4a8a_100%)]"
    aria-labelledby="page-title">
    <div
      class="pointer-events-none absolute inset-0 bg-[size:40px_40px] bg-[linear-gradient(rgba(255,255,255,.025)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,.025)_1px,transparent_1px)]">
    </div>
    <div class="absolute left-0 top-0 bottom-0 w-1 bg-[linear-gradient(to_bottom,#f26522,transparent)]"></div>

    <div class="relative w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
      <nav class="mb-4 text-sm text-white/50" aria-label="breadcrumb">
        <ol class="flex items-center gap-1.5 list-none">
          <li><a href="{{ route('home') }}" class="transition-colors hover:text-orange">หน้าแรก</a></li>
          <li><i class="bi bi-chevron-right text-[.65rem]" aria-hidden="true"></i></li>
          <li class="text-white/80">สินค้าและบริการ</li>
        </ol>
      </nav>

      <div data-reveal class="opacity-0 translate-y-6 transition duration-700 ease-out data-[show=true]:opacity-100 data-[show=true]:translate-y-0">
        <div class="font-display text-xs font-semibold tracking-[.14em] uppercase text-orange">
          <i class="bi bi-grid-3x3-gap-fill" aria-hidden="true"></i> สินค้าและบริการ
        </div>
        <h1
          class="font-display font-bold text-white leading-tight mt-2 text-[clamp(1.8rem,5vw,2.8rem)] max-w-4xl"
          id="page-title">
          {{ $serviceName }}
        </h1>
        <p class="max-w-[640px] mt-4 text-white/70 leading-relaxed">
          เครื่องดูดฝุ่นโรงงานอุตสาหกรรมจาก {{ $shop }} มีให้เลือกตั้งแต่ขนาดเล็ก 15 ลิตร ถึงขนาดใหญ่ 100 ลิตรขึ้นไป ทั้งรุ่นดูดแห้ง-เปียก รุ่นแรงดูดสูง และรุ่นไร้สาย เราช่วยเลือกรุ่นตามชนิดฝุ่นและชั่วโมงใช้งานจริงของโรงงาน พร้อมบริการซ่อมและอะไหล่หลังการขาย จัดส่งทั่วประเทศ บริการหน้างานใน {{ $areas }}
        </p>
        <p class="mt-3 text-sm text-white/45">
          โดยทีมงาน {{ $shop }} · อัปเดตล่าสุด 7 ตุลาคม 2569
        </p>
        <div class="mt-7 flex flex-col sm:flex-row gap-3">
          <a href="#quote"
            class="inline-flex items-center justify-center gap-2 min-h-[52px] px-7 py-3 rounded-xl font-bold text-white bg-orange shadow-[0_4px_16px_rgba(242,101,34,.35)] transition-all hover:bg-orange-dark hover:-translate-y-0.5">
            <i class="bi bi-file-earmark-text" aria-hidden="true"></i> ขอใบเสนอราคา
          </a>
          <a href="{{ config('data.line') }}" target="_blank" rel="noopener"
            class="inline-flex items-center justify-center gap-2 min-h-[52px] px-7 py-3 rounded-xl font-bold text-white bg-line shadow-[0_4px_16px_rgba(6,199,85,.35)] transition-all hover:bg-line-dark hover:-translate-y-0.5">
            <i class="bi bi-chat-dots-fill" aria-hidden="true"></i> ทัก LINE
          </a>
        </div>
      </div>
    </div>
  </section>

  {{-- What is industrial vacuum --}}
  <section class="py-14 bg-white" aria-labelledby="what-title">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
      <div data-reveal class="max-w-3xl opacity-0 translate-y-6 transition duration-700 ease-out data-[show=true]:opacity-100 data-[show=true]:translate-y-0">
        <h2 class="font-display font-bold leading-tight text-navy text-[clamp(1.4rem,3.5vw,2rem)]" id="what-title">
          เครื่องดูดฝุ่นโรงงานอุตสาหกรรมคืออะไร ต่างจากเครื่องดูดฝุ่นบ้านอย่างไร?
        </h2>
        <p class="mt-4 text-slate-600 leading-relaxed">
          เครื่องดูดฝุ่นโรงงานอุตสาหกรรมคือเครื่องดูดฝุ่นที่ออกแบบให้ดูดเศษวัสดุหนักและปริมาณมาก เช่น ผงโลหะ เศษไม้ ฝุ่นปูน น้ำ และน้ำมัน ต่างจากเครื่องดูดฝุ่นบ้านที่มอเตอร์ ถังเก็บ และระบบกรอง ซึ่งใหญ่และทนทานกว่าหลายเท่า
        </p>
        <p class="mt-4 text-navy font-semibold">จุดต่างหลักมี 4 ข้อ</p>
        <ul class="mt-3 space-y-3 text-slate-600 leading-relaxed">
          <li><strong class="text-navy">กำลังมอเตอร์</strong> รุ่นไฟ 220 V ใช้มอเตอร์ 1–3 ตัว รวม 1,000–3,600 วัตต์ รุ่น 3 เฟสใช้มอเตอร์เทอร์ไบน์ 2.2–7.5 กิโลวัตต์</li>
          <li><strong class="text-navy">ความจุถัง</strong> 15–100 ลิตรขึ้นไป ขณะที่เครื่องบ้านจุได้ราว 1–3 ลิตร</li>
          <li><strong class="text-navy">ดูดได้ทั้งแห้งและเปียก</strong> รุ่นส่วนใหญ่ดูดน้ำได้ และมีลูกลอยตัดการดูดเมื่อน้ำเต็มถัง</li>
          <li><strong class="text-navy">วัสดุตัวถัง</strong> เป็นสเตนเลสหรือพลาสติกหนาพิเศษ รับแรงกระแทกในหน้างานได้</li>
        </ul>
      </div>
    </div>
  </section>

  {{-- Sizes --}}
  <section class="py-14 bg-offwhite" id="sizes" aria-labelledby="sizes-title">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
      <div data-reveal class="mb-8 max-w-3xl opacity-0 translate-y-6 transition duration-700 ease-out data-[show=true]:opacity-100 data-[show=true]:translate-y-0">
        <h2 class="font-display font-bold leading-tight text-navy text-[clamp(1.4rem,3.5vw,2rem)]" id="sizes-title">
          เครื่องดูดฝุ่นโรงงานอุตสาหกรรมมีขนาดไหนบ้าง?
        </h2>
        <p class="mt-4 text-slate-600 leading-relaxed">
          เครื่องดูดฝุ่นโรงงานอุตสาหกรรมแบ่งตามความจุถังและจำนวนมอเตอร์ได้ 4 กลุ่ม คือ ขนาดเล็ก 15–30 ลิตร ขนาดกลาง 60–70 ลิตร ขนาดใหญ่ 80–100 ลิตร และรุ่น 3 เฟสสำหรับงานต่อเนื่อง ยิ่งพื้นที่กว้างและฝุ่นมาก ยิ่งต้องใช้ถังใหญ่และมอเตอร์หลายตัว
        </p>
      </div>

      <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm mb-10">
        <table class="w-full min-w-[640px] text-left text-sm">
          <thead class="bg-navy text-white">
            <tr>
              <th class="px-5 py-4 font-semibold">ขนาด</th>
              <th class="px-5 py-4 font-semibold">ความจุถัง</th>
              <th class="px-5 py-4 font-semibold">มอเตอร์</th>
              <th class="px-5 py-4 font-semibold">ไฟฟ้า</th>
              <th class="px-5 py-4 font-semibold">เหมาะกับ</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 text-slate-700">
            <tr>
              <td class="px-5 py-4 font-semibold text-navy">ขนาดเล็ก</td>
              <td class="px-5 py-4">15–30 ลิตร</td>
              <td class="px-5 py-4">1 ตัว 1,000–1,500 W</td>
              <td class="px-5 py-4">220 V</td>
              <td class="px-5 py-4">เวิร์กช็อป ไลน์ประกอบ งานเก็บจุดย่อย</td>
            </tr>
            <tr class="bg-offwhite/50">
              <td class="px-5 py-4 font-semibold text-navy">ขนาดกลาง</td>
              <td class="px-5 py-4">60–70 ลิตร</td>
              <td class="px-5 py-4">2 ตัว 2,000–2,400 W</td>
              <td class="px-5 py-4">220 V</td>
              <td class="px-5 py-4">คลังสินค้า พื้นโรงงานทั่วไป</td>
            </tr>
            <tr>
              <td class="px-5 py-4 font-semibold text-navy">ขนาดใหญ่</td>
              <td class="px-5 py-4">80–100 ลิตร</td>
              <td class="px-5 py-4">3 ตัว 3,000–3,600 W</td>
              <td class="px-5 py-4">220 V</td>
              <td class="px-5 py-4">พื้นที่กว้าง ฝุ่นและน้ำปริมาณมาก</td>
            </tr>
            <tr class="bg-offwhite/50">
              <td class="px-5 py-4 font-semibold text-navy">ขนาดใหญ่ 3 เฟส</td>
              <td class="px-5 py-4">100 ลิตรขึ้นไป</td>
              <td class="px-5 py-4">เทอร์ไบน์ 2.2–7.5 kW</td>
              <td class="px-5 py-4">380 V</td>
              <td class="px-5 py-4">ไลน์ผลิตที่เดินเครื่องต่อเนื่องทั้งกะ</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <article data-reveal class="opacity-0 translate-y-6 transition duration-700 ease-out data-[show=true]:opacity-100 data-[show=true]:translate-y-0">
          <h3 class="font-display font-bold text-navy text-xl mb-3">เครื่องดูดฝุ่นอุตสาหกรรม ขนาดเล็ก</h3>
          <p class="text-slate-600 leading-relaxed text-sm">
            เครื่องดูดฝุ่นอุตสาหกรรม ขนาดเล็ก มีถัง 15–30 ลิตร มอเตอร์ 1 ตัว เหมาะกับงานที่ต้องย้ายเครื่องบ่อย เช่น ทำความสะอาดโต๊ะงาน เครื่องจักรรายตัว หรือชั้นลอย ยกขึ้นรถได้คนเดียวและใช้ปลั๊กไฟบ้านทั่วไป
          </p>
          <p class="mt-3 text-slate-600 leading-relaxed text-sm">
            ข้อจำกัดคือถังเต็มเร็ว ถ้าฝุ่นหรือเศษวัสดุเกินครึ่งถังต่อวัน ควรขยับไปขนาดกลาง
          </p>
        </article>
        <article data-reveal class="opacity-0 translate-y-6 transition duration-700 ease-out delay-100 data-[show=true]:opacity-100 data-[show=true]:translate-y-0">
          <h3 class="font-display font-bold text-navy text-xl mb-3">เครื่องดูดฝุ่นอุตสาหกรรม ขนาดใหญ่</h3>
          <p class="text-slate-600 leading-relaxed text-sm">
            เครื่องดูดฝุ่นอุตสาหกรรม ขนาดใหญ่ มีถัง 80–100 ลิตร มอเตอร์ 3 ตัวแยกสวิตช์ เปิดทีละตัวตามปริมาณงานได้ จึงประหยัดไฟเมื่องานเบา รุ่น 80 ลิตร 3 มอเตอร์ในตลาดให้ปริมาณลมราว 120 ลิตรต่อวินาที และมักมีสายระบายน้ำทิ้งโดยไม่ต้องยกถังเท
          </p>
          <p class="mt-3 text-slate-600 leading-relaxed text-sm">
            โรงงานที่ต้องดูดต่อเนื่องทั้งกะควรใช้รุ่น 3 เฟส มอเตอร์เทอร์ไบน์ไม่มีแปรงถ่าน จึงเดินเครื่องได้นานโดยไม่ต้องพัก
          </p>
        </article>
        <article data-reveal class="opacity-0 translate-y-6 transition duration-700 ease-out delay-200 data-[show=true]:opacity-100 data-[show=true]:translate-y-0">
          <h3 class="font-display font-bold text-navy text-xl mb-3">เครื่องดูดฝุ่นอุตสาหกรรม ไร้สาย</h3>
          <p class="text-slate-600 leading-relaxed text-sm">
            เครื่องดูดฝุ่นอุตสาหกรรม ไร้สาย ใช้แบตเตอรี่ลิเธียม โดยทั่วไป 18–36 โวลต์ ใช้งานได้ราว 20–60 นาทีต่อการชาร์จ ขึ้นกับระดับแรงดูด เหมาะกับจุดที่ไม่มีปลั๊ก พื้นที่สูง ทางเดินรถโฟล์กลิฟต์ และงานเก็บเร็วระหว่างกะ
          </p>
          <p class="mt-3 text-slate-600 leading-relaxed text-sm">
            แรงดูดต่ำกว่ารุ่นมีสายในขนาดเดียวกัน จึงควรใช้เป็นเครื่องเสริม ไม่ใช่เครื่องหลักของไลน์ผลิต และควรมีแบตเตอรี่สำรองอย่างน้อย 1 ก้อน
          </p>
        </article>
      </div>
    </div>
  </section>

  {{-- Products catalog --}}
  <section class="py-18 bg-white" id="products" aria-labelledby="products-title">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
      <div data-reveal class="mb-10 opacity-0 translate-y-6 transition duration-700 ease-out data-[show=true]:opacity-100 data-[show=true]:translate-y-0">
        <div class="font-display text-xs font-semibold tracking-[.14em] uppercase text-orange">
          <i class="bi bi-box-seam" aria-hidden="true"></i> สินค้าที่จำหน่าย
        </div>
        <h2 class="font-display font-bold leading-tight text-navy mt-2 text-[clamp(1.6rem,4vw,2.4rem)]" id="products-title">
          เครื่องดูดฝุ่นและอะไหล่<br>
          <span class="text-orange">พร้อมสเปกและราคาจริง</span>
        </h2>
      </div>

      <div class="flex gap-2 overflow-x-auto pb-1 mb-8 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden" role="group" aria-label="กรองประเภทสินค้า">
        <button onclick="filterSection('products', 'all')" aria-pressed="true"
          class="filter-btn inline-flex items-center gap-1.5 min-h-[44px] px-[18px] py-2.5 rounded-full text-sm font-semibold shrink-0 whitespace-nowrap border-[1.5px] border-navy/10 bg-white text-navy/70 transition-all hover:border-navy hover:text-navy aria-pressed:bg-navy aria-pressed:border-navy aria-pressed:text-white aria-pressed:shadow">
          <i class="bi bi-grid-fill" aria-hidden="true"></i> ทั้งหมด
        </button>
        @foreach ($productCategories as $category)
          <button onclick="filterSection('products', '{{ $category->slug }}')" aria-pressed="false"
            class="filter-btn inline-flex items-center gap-1.5 min-h-[44px] px-[18px] py-2.5 rounded-full text-sm font-semibold shrink-0 whitespace-nowrap border-[1.5px] border-navy/10 bg-white text-navy/70 transition-all hover:border-navy hover:text-navy aria-pressed:bg-navy aria-pressed:border-navy aria-pressed:text-white aria-pressed:shadow">
            <i class="bi {{ $productCategoryIcons[$category->slug] ?? 'bi-box' }}" aria-hidden="true"></i> {{ $category->name }}
          </button>
        @endforeach
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse ($products as $index => $product)
          @php
            $delay = match ($index % 3) {
              1 => 'delay-100',
              2 => 'delay-200',
              default => '',
            };
            $gradient = $gradients[$index % count($gradients)];
          @endphp
          <article data-reveal data-category="{{ $product->category?->slug }}"
            class="catalog-card group relative overflow-hidden rounded-[20px] bg-offwhite shadow-sm transition-all opacity-0 translate-y-6 duration-700 ease-out {{ $delay }} data-[show=true]:opacity-100 data-[show=true]:translate-y-0 hover:shadow-lg hover:-translate-y-1.5">
            <div class="relative overflow-hidden aspect-video flex items-center justify-center px-4 text-[3.5rem] text-white/15 {{ $gradient }} after:content-[''] after:absolute after:inset-0 after:bg-[linear-gradient(to_top,rgba(15,35,71,.55),transparent_60%)] after:pointer-events-none after:z-[1]">
              @if ($product->imageUrl())
                <img
                  src="{{ $product->imageUrl() }}"
                  alt="{{ $product->name }}"
                  class="absolute inset-y-0 inset-x-4 z-0 w-[calc(100%-2rem)] h-full object-contain object-center transition-transform duration-500 group-hover:scale-105"
                  loading="lazy"
                >
              @else
                <i class="{{ $product->iconClass() }}" aria-hidden="true"></i>
              @endif
              @if ($product->category)
                <span class="absolute top-2.5 left-2.5 z-[2] px-2.5 py-[3px] rounded-full bg-navy/90 text-white text-[.68rem] font-bold tracking-wide uppercase">{{ $product->category->name }}</span>
              @endif
              @if ($product->is_featured)
                <span class="absolute top-2.5 right-2.5 z-[2] px-2.5 py-[3px] rounded-full bg-orange text-white text-[.68rem] font-bold tracking-wide uppercase">แนะนำ</span>
              @endif
            </div>
            <div class="p-5">
              <h3 class="font-display font-bold text-[1.05rem] text-navy leading-snug mb-2">
                <a href="{{ route('products.show', $product->slug) }}" class="hover:text-orange">{{ $product->name }}</a>
              </h3>
              <p class="text-sm text-slate-600 leading-relaxed mb-4 line-clamp-3">{{ $product->short_description }}</p>
              <div class="flex items-center justify-between pt-4 border-t border-navy/5">
                <div class="text-sm font-bold text-orange">
                  @if ($product->sale_price !== null)
                    <span class="block text-navy/40 line-through text-xs font-medium">฿{{ number_format((float) $product->price, 0) }}</span>
                    <span><i class="bi bi-tag-fill mr-1" aria-hidden="true"></i>฿{{ number_format((float) $product->sale_price, 0) }}</span>
                  @elseif ((float) $product->price > 0)
                    <span><i class="bi bi-tag-fill mr-1" aria-hidden="true"></i>฿{{ number_format((float) $product->price, 0) }}</span>
                  @else
                    <span><i class="bi bi-tag-fill mr-1" aria-hidden="true"></i>ติดต่อขอราคา</span>
                  @endif
                </div>
                <a href="{{ config('data.line') }}" target="_blank" rel="noopener"
                  class="inline-flex items-center justify-center gap-2 min-h-[40px] px-4 py-2 rounded-lg text-sm font-bold text-white bg-navy shadow transition-all hover:bg-navy-mid hover:-translate-y-0.5">
                  สอบถาม <i class="bi bi-chat-dots-fill" aria-hidden="true"></i>
                </a>
              </div>
            </div>
          </article>
        @empty
          <p class="col-span-full text-center text-slate-500 py-10">ยังไม่มีสินค้าในระบบ</p>
        @endforelse
      </div>
    </div>
  </section>

  {{-- High suction --}}
  <section class="py-14 bg-offwhite" aria-labelledby="suction-title">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
      <div data-reveal class="max-w-3xl opacity-0 translate-y-6 transition duration-700 ease-out data-[show=true]:opacity-100 data-[show=true]:translate-y-0">
        <h2 class="font-display font-bold leading-tight text-navy text-[clamp(1.4rem,3.5vw,2rem)]" id="suction-title">
          เครื่องดูดฝุ่น แรงดูดสูง ดูจากค่าอะไร?
        </h2>
        <p class="mt-4 text-slate-600 leading-relaxed">
          เครื่องดูดฝุ่น แรงดูดสูง ดูจาก 2 ค่า คือ แรงดันสุญญากาศ (kPa หรือ mmH₂O) ซึ่งบอกแรงยกวัสดุหนัก และปริมาณลม (ลิตรต่อวินาที) ซึ่งบอกปริมาณที่ดูดได้ต่อครั้ง จำนวนวัตต์บอกแค่การกินไฟ ไม่ใช่แรงดูด
        </p>
        <ul class="mt-4 space-y-3 text-slate-600 leading-relaxed">
          <li><strong class="text-navy">เศษหนัก</strong> เช่น เศษโลหะ ทราย น้ำ ให้เลือกแรงดันสุญญากาศสูง รุ่นไฟ 220 V ทั่วไปอยู่ที่ราว 2,000–2,400 mmH₂O (20–24 kPa)</li>
          <li><strong class="text-navy">ฝุ่นเบาปริมาณมาก</strong> เช่น ขี้เลื่อย ฝุ่นผ้า ให้เลือกปริมาณลมสูงและท่อดูดเส้นผ่านศูนย์กลางใหญ่</li>
          <li><strong class="text-navy">งานต่อเนื่องและท่อยาว</strong> ให้เลือกรุ่นเทอร์ไบน์ 3 เฟส ซึ่งรักษาแรงดูดได้คงที่กว่า</li>
        </ul>
        <p class="mt-4 text-slate-600 leading-relaxed">
          จากเครื่องที่ลูกค้าส่งซ่อมกับเรา อาการ “ดูดไม่แรง” ส่วนใหญ่มาจากไส้กรองตันหรือสายดูดรั่ว ไม่ใช่มอเตอร์เสีย การเลือกรุ่นที่ถอดล้างไส้กรองง่ายจึงสำคัญพอ ๆ กับตัวเลขแรงดูด
        </p>
      </div>
    </div>
  </section>

  {{-- Pricing --}}
  <section class="py-14 bg-white" id="pricing" aria-labelledby="pricing-title">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
      <div data-reveal class="mb-8 max-w-3xl opacity-0 translate-y-6 transition duration-700 ease-out data-[show=true]:opacity-100 data-[show=true]:translate-y-0">
        <h2 class="font-display font-bold leading-tight text-navy text-[clamp(1.4rem,3.5vw,2rem)]" id="pricing-title">
          เครื่องดูดฝุ่น โรงงาน อุตสาหกรรม ราคาเท่าไหร่?
        </h2>
        <p class="mt-4 text-slate-600 leading-relaxed">
          เครื่องดูดฝุ่น โรงงาน อุตสาหกรรม ราคาเริ่มต้นที่
          @if ($priceFrom)
            {{ $priceFrom }} บาท
          @else
            สอบถาม
          @endif
          สำหรับขนาดเล็ก และขยับตามจำนวนมอเตอร์ ขนาดถัง ระบบกรอง และยี่ห้อมอเตอร์ ราคาด้านล่างไม่รวม VAT
        </p>
      </div>

      <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-sm mb-8">
        <table class="w-full min-w-[560px] text-left text-sm">
          <thead class="bg-navy text-white">
            <tr>
              <th class="px-5 py-4 font-semibold">ขนาด</th>
              <th class="px-5 py-4 font-semibold">รุ่นที่จำหน่าย</th>
              <th class="px-5 py-4 font-semibold">ราคาเริ่มต้น (บาท ไม่รวม VAT)</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 text-slate-700">
            @foreach ($priceRows as $row)
              <tr class="{{ $loop->even ? 'bg-offwhite/50' : '' }}">
                <td class="px-5 py-4 font-semibold text-navy">{{ $row['size'] }}</td>
                <td class="px-5 py-4">{{ $row['model'] }}</td>
                <td class="px-5 py-4">{{ $row['price'] }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="max-w-3xl">
        <p class="text-navy font-semibold mb-3">ปัจจัยที่ทำให้ราคาต่างกันมี 5 ข้อ</p>
        <ul class="space-y-3 text-slate-600 leading-relaxed">
          <li><strong class="text-navy">จำนวนและยี่ห้อมอเตอร์</strong> มอเตอร์แบรนด์ยุโรปหรืออเมริกาแพงกว่า แต่หาอะไหล่ง่ายและอายุใช้งานยาวกว่า</li>
          <li><strong class="text-navy">วัสดุถัง</strong> สเตนเลสเกรด 304 แพงกว่าพลาสติก แต่ทนสนิมและสารเคมี</li>
          <li><strong class="text-navy">ระบบกรอง</strong> ไส้กรอง HEPA และระบบเขย่าไส้กรองเพิ่มต้นทุน แต่จำเป็นกับฝุ่นละเอียด</li>
          <li><strong class="text-navy">ระบบไฟฟ้า</strong> รุ่น 3 เฟสแพงกว่ารุ่น 220 V หลายเท่า แลกกับการเดินเครื่องต่อเนื่อง</li>
          <li><strong class="text-navy">การรับประกันและบริการ</strong> เครื่องที่มีศูนย์ซ่อมและอะไหล่ในประเทศคุ้มกว่าในระยะยาว</li>
        </ul>
      </div>
    </div>
  </section>

  {{-- How to choose --}}
  <section class="py-14 bg-offwhite" aria-labelledby="choose-title">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
      <div data-reveal class="max-w-3xl opacity-0 translate-y-6 transition duration-700 ease-out data-[show=true]:opacity-100 data-[show=true]:translate-y-0">
        <h2 class="font-display font-bold leading-tight text-navy text-[clamp(1.4rem,3.5vw,2rem)]" id="choose-title">
          เลือกเครื่องดูดฝุ่นโรงงานอุตสาหกรรมอย่างไรให้ตรงกับหน้างาน?
        </h2>
        <p class="mt-4 text-slate-600 leading-relaxed">
          เลือกเครื่องดูดฝุ่นโรงงานอุตสาหกรรมโดยดู 5 เรื่องตามลำดับ คือ ชนิดฝุ่น ปริมาณต่อวัน ชั่วโมงใช้งานต่อเนื่อง ระบบไฟฟ้าในโรงงาน และระดับการกรองที่ต้องการ ตอบครบ 5 ข้อนี้จะได้ขนาดและรุ่นที่เหมาะโดยไม่จ่ายเกินจำเป็น
        </p>
        <ol class="mt-5 space-y-4 text-slate-600 leading-relaxed list-decimal list-inside">
          <li><strong class="text-navy">ระบุชนิดฝุ่น</strong> แห้ง เปียก ผงละเอียด เศษคม หรือน้ำมัน ฝุ่นที่ติดไฟได้ เช่น ผงแป้ง ผงอะลูมิเนียม ต้องใช้รุ่นกันระเบิดเท่านั้น</li>
          <li><strong class="text-navy">ประเมินปริมาณต่อวัน</strong> เลือกถังที่รับได้อย่างน้อย 1 กะโดยไม่ต้องเท</li>
          <li><strong class="text-navy">นับชั่วโมงใช้งานต่อเนื่อง</strong> ใช้เป็นช่วงสั้น ๆ เลือกรุ่นมอเตอร์ 220 V ได้ ใช้ทั้งกะเลือกรุ่นเทอร์ไบน์ 3 เฟส</li>
          <li><strong class="text-navy">เช็กระบบไฟฟ้าหน้างาน</strong> มีไฟ 380 V ถึงจุดใช้งานหรือไม่ และเต้ารับรองรับกระแสของเครื่อง 3 มอเตอร์ได้หรือไม่</li>
          <li><strong class="text-navy">กำหนดระดับการกรอง</strong> โรงงานอาหาร ยา และอิเล็กทรอนิกส์ควรใช้ไส้กรอง HEPA</li>
        </ol>
        <p class="mt-5 text-slate-600 leading-relaxed">
          ส่งรูปหน้างานและชนิดฝุ่นมาทาง LINE ทีมงานจะแนะนำรุ่นให้ภายในเวลาทำการ
        </p>
      </div>
    </div>
  </section>

  {{-- After-sales --}}
  <section class="py-14 bg-white" aria-labelledby="aftercare-title">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
      <div data-reveal class="max-w-3xl mb-10 opacity-0 translate-y-6 transition duration-700 ease-out data-[show=true]:opacity-100 data-[show=true]:translate-y-0">
        <h2 class="font-display font-bold leading-tight text-navy text-[clamp(1.4rem,3.5vw,2rem)]" id="aftercare-title">
          บริการหลังการขาย ซ่อมและอะไหล่เครื่องดูดฝุ่นอุตสาหกรรม
        </h2>
        <p class="mt-4 text-slate-600 leading-relaxed">
          {{ $shop }} ดูแลเครื่องต่อหลังส่งมอบ ทั้งเครื่องที่ซื้อจากเราและเครื่องยี่ห้ออื่น
        </p>
        <ul class="mt-4 space-y-3 text-slate-600 leading-relaxed">
          <li><strong class="text-navy">ซ่อมมอเตอร์และระบบไฟ</strong> เปลี่ยนแปรงถ่าน ลูกปืน สวิตช์ และมอเตอร์ทั้งลูก</li>
          <li><strong class="text-navy">อะไหล่และวัสดุสิ้นเปลือง</strong> ไส้กรอง ถุงกรอง สายดูด หัวดูด ล้อ — ดูรายการบริการทั้งหมดด้านล่าง</li>
          <li><strong class="text-navy">ตรวจเช็กตามรอบ</strong> ล้างไส้กรองและวัดแรงดูดเทียบค่าตั้งต้น</li>
          <li><strong class="text-navy">รับประกันงานซ่อม</strong> 90 วัน หากอาการเดิมกลับมาจากงานที่เราทำ</li>
          <li><strong class="text-navy">ระยะเวลาซ่อม</strong> อาการทั่วไป 1–3 วันทำการ งานมอเตอร์ 2–5 วัน</li>
        </ul>
        <p class="mt-5">
          <a href="{{ route('pages.show', 'vacuum-repair') }}" class="inline-flex items-center gap-2 font-semibold text-orange hover:underline">
            รับซ่อมเครื่องดูดฝุ่นอุตสาหกรรม <i class="bi bi-arrow-right" aria-hidden="true"></i>
          </a>
        </p>
      </div>
    </div>
  </section>

  {{-- Services catalog --}}
  <section class="py-18 bg-offwhite" id="services" aria-labelledby="services-title">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
      <div data-reveal class="mb-10 opacity-0 translate-y-6 transition duration-700 ease-out data-[show=true]:opacity-100 data-[show=true]:translate-y-0">
        <div class="font-display text-xs font-semibold tracking-[.14em] uppercase text-orange">
          <i class="bi bi-tools" aria-hidden="true"></i> บริการ
        </div>
        <h2 class="font-display font-bold leading-tight text-navy mt-2 text-[clamp(1.6rem,4vw,2.4rem)]" id="services-title">
          บริการซ่อมครบวงจร<br>
          <span class="text-orange">เครื่องดูดฝุ่นอุตสาหกรรม</span>
        </h2>
      </div>

      <div class="flex gap-2 overflow-x-auto pb-1 mb-8 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden" role="group" aria-label="กรองประเภทบริการ">
        <button onclick="filterSection('services', 'all')" aria-pressed="true"
          class="filter-btn inline-flex items-center gap-1.5 min-h-[44px] px-[18px] py-2.5 rounded-full text-sm font-semibold shrink-0 whitespace-nowrap border-[1.5px] border-navy/10 bg-white text-navy/70 transition-all hover:border-navy hover:text-navy aria-pressed:bg-navy aria-pressed:border-navy aria-pressed:text-white aria-pressed:shadow">
          <i class="bi bi-grid-fill" aria-hidden="true"></i> ทั้งหมด
        </button>
        @foreach ($serviceCategories as $category)
          <button onclick="filterSection('services', '{{ $category->slug }}')" aria-pressed="false"
            class="filter-btn inline-flex items-center gap-1.5 min-h-[44px] px-[18px] py-2.5 rounded-full text-sm font-semibold shrink-0 whitespace-nowrap border-[1.5px] border-navy/10 bg-white text-navy/70 transition-all hover:border-navy hover:text-navy aria-pressed:bg-navy aria-pressed:border-navy aria-pressed:text-white aria-pressed:shadow">
            <i class="bi {{ $serviceCategoryIcons[$category->slug] ?? 'bi-tools' }}" aria-hidden="true"></i> {{ $category->name }}
          </button>
        @endforeach
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse ($services as $index => $service)
          @php
            $delay = match ($index % 3) {
              1 => 'delay-100',
              2 => 'delay-200',
              default => '',
            };
            $gradient = $gradients[$index % count($gradients)];
            $isHighlight = (float) $service->price <= 0;
          @endphp
          <article data-reveal data-category="{{ $service->category?->slug }}"
            class="catalog-card group relative overflow-hidden rounded-[20px] bg-white shadow-sm border border-navy/5 transition-all opacity-0 translate-y-6 duration-700 ease-out {{ $delay }} data-[show=true]:opacity-100 data-[show=true]:translate-y-0 hover:shadow-lg hover:-translate-y-1.5">
            <div class="relative overflow-hidden aspect-video flex items-center justify-center px-4 text-[3.5rem] text-white/15 {{ $gradient }} after:content-[''] after:absolute after:inset-0 after:bg-[linear-gradient(to_top,rgba(15,35,71,.55),transparent_60%)] after:pointer-events-none after:z-[1]">
              @if ($service->imageUrl())
                <img
                  src="{{ $service->imageUrl() }}"
                  alt="{{ $service->name }}"
                  class="absolute inset-y-0 inset-x-4 z-0 w-[calc(100%-2rem)] h-full object-contain object-center transition-transform duration-500 group-hover:scale-105"
                  loading="lazy"
                >
              @else
                <i class="{{ $service->iconClass() }}" aria-hidden="true"></i>
              @endif
              @if ($service->category)
                <span class="absolute top-2.5 left-2.5 z-[2] px-2.5 py-[3px] rounded-full bg-navy/90 text-white text-[.68rem] font-bold tracking-wide uppercase">{{ $service->category->name }}</span>
              @endif
              @if ($service->is_featured)
                <span class="absolute top-2.5 right-2.5 z-[2] px-2.5 py-[3px] rounded-full bg-orange text-white text-[.68rem] font-bold tracking-wide uppercase">แนะนำ</span>
              @endif
            </div>
            <div class="p-5">
              <h3 class="font-display font-bold text-[1.05rem] text-navy leading-snug mb-2">
                <a href="{{ route('services.show', $service->slug) }}" class="hover:text-orange">{{ $service->name }}</a>
              </h3>
              <p class="text-sm text-slate-600 leading-relaxed mb-4 line-clamp-3">{{ $service->short_description }}</p>
              <div class="flex items-center justify-between pt-4 border-t border-navy/5">
                <span class="text-sm font-bold text-orange"><i class="bi bi-tag-fill mr-1" aria-hidden="true"></i>{{ $service->priceLabel() }}</span>
                @if ($isHighlight)
                  <a href="{{ config('data.line') }}" target="_blank" rel="noopener"
                    class="inline-flex items-center justify-center gap-2 min-h-[40px] px-4 py-2 rounded-lg text-sm font-bold text-white bg-orange shadow-[0_4px_16px_rgba(242,101,34,.35)] transition-all hover:bg-orange-dark hover:-translate-y-0.5">
                    ติดต่อเลย <i class="bi bi-arrow-right" aria-hidden="true"></i>
                  </a>
                @else
                  <a href="{{ config('data.line') }}" target="_blank" rel="noopener"
                    class="inline-flex items-center justify-center gap-2 min-h-[40px] px-4 py-2 rounded-lg text-sm font-bold text-white bg-navy shadow transition-all hover:bg-navy-mid hover:-translate-y-0.5">
                    สอบถาม <i class="bi bi-arrow-right" aria-hidden="true"></i>
                  </a>
                @endif
              </div>
            </div>
          </article>
        @empty
          <p class="col-span-full text-center text-slate-500 py-10">ยังไม่มีบริการในระบบ</p>
        @endforelse
      </div>
    </div>
  </section>

  {{-- Why us --}}
  <section class="py-14 bg-white" aria-labelledby="why-title">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
      <div data-reveal class="max-w-3xl opacity-0 translate-y-6 transition duration-700 ease-out data-[show=true]:opacity-100 data-[show=true]:translate-y-0">
        <h2 class="font-display font-bold leading-tight text-navy text-[clamp(1.4rem,3.5vw,2rem)]" id="why-title">
          ทำไมโรงงานเลือกซื้อกับ {{ $shop }}
        </h2>
        <ul class="mt-5 space-y-3 text-slate-600 leading-relaxed">
          <li><strong class="text-navy">เป็นช่างซ่อมเอง</strong> ประสบการณ์กว่า 20 ปี จึงรู้ว่ารุ่นไหนทนและรุ่นไหนเสียบ่อย</li>
          <li><strong class="text-navy">แจ้งราคาเป็นลายลักษณ์อักษร</strong> ออกใบเสนอราคาและใบกำกับภาษีได้</li>
          <li><strong class="text-navy">มีอะไหล่ในสต็อก</strong> ไส้กรอง แปรงถ่าน สายดูด และมอเตอร์งานหนักที่ใช้บ่อย</li>
          <li><strong class="text-navy">ประเมินก่อนซื้อ</strong> ส่งรูปหน้างานและชนิดฝุ่นมาทาง LINE แนะนำรุ่นให้โดยไม่ผูกมัด</li>
          <li>
            <strong class="text-navy">ผลงานอ้างอิง</strong>
            <a href="{{ route('pages.show', 'portfolio') }}" class="text-orange hover:underline">ดูผลงานส่งมอบและงานซ่อม</a>
          </li>
        </ul>
      </div>
    </div>
  </section>

  {{-- FAQ --}}
  <x-frontend.page-faqs
    heading="คำถามที่พบบ่อยเกี่ยวกับเครื่องดูดฝุ่นโรงงานอุตสาหกรรม"
    :items="$faqs"
  />

  {{-- Quote CTA --}}
  <section class="py-14 bg-navy" id="quote" aria-labelledby="quote-title">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
      <div data-reveal class="opacity-0 translate-y-6 transition duration-700 ease-out data-[show=true]:opacity-100 data-[show=true]:translate-y-0">
        <h2 class="font-display font-bold text-white text-[clamp(1.4rem,3.5vw,2rem)] mb-3" id="quote-title">
          ขอใบเสนอราคาเครื่องดูดฝุ่นโรงงานอุตสาหกรรม
        </h2>
        <p class="text-white/70 mb-6 max-w-2xl leading-relaxed">
          แจ้งชนิดฝุ่น ขนาดพื้นที่ และจำนวนเครื่องที่ต้องการ ทีมงานจะส่งใบเสนอราคาพร้อมรุ่นที่แนะนำให้ภายในเวลาทำการ
        </p>
        <ul class="text-white/65 text-sm space-y-2 mb-8 max-w-xl">
          <li><i class="bi bi-telephone-fill text-orange mr-2" aria-hidden="true"></i> โทร <a href="tel:{{ config('data.phone') }}" class="text-white hover:text-orange">{{ $phone }}</a></li>
          <li><i class="bi bi-chat-dots-fill text-orange mr-2" aria-hidden="true"></i> LINE ประเมินฟรี</li>
          <li><i class="bi bi-geo-alt-fill text-orange mr-2" aria-hidden="true"></i> {{ config('data.address') }}</li>
          <li><i class="bi bi-truck text-orange mr-2" aria-hidden="true"></i> จัดส่งทั่วประเทศ · บริการหน้างาน {{ $areas }}</li>
          <li><i class="bi bi-clock-fill text-orange mr-2" aria-hidden="true"></i> จันทร์–เสาร์ 08:00–18:00 น.</li>
        </ul>
        <div class="flex flex-col sm:flex-row gap-3">
          <a href="{{ config('data.line') }}" target="_blank" rel="noopener"
            class="inline-flex items-center justify-center gap-2 min-h-[52px] px-7 py-3 rounded-xl font-bold text-white bg-line shadow-[0_4px_16px_rgba(6,199,85,.35)] transition-all hover:bg-line-dark hover:-translate-y-0.5">
            <i class="bi bi-chat-dots-fill" aria-hidden="true"></i> ทัก LINE ขอใบเสนอราคา
          </a>
          <a href="tel:{{ config('data.phone') }}"
            class="inline-flex items-center justify-center gap-2 min-h-[52px] px-7 py-3 rounded-xl font-bold text-white bg-transparent border-2 border-white/55 transition-all hover:bg-white/10 hover:border-white">
            <i class="bi bi-telephone-fill" aria-hidden="true"></i> {{ $phone }}
          </a>
        </div>
      </div>
    </div>
  </section>

@endsection

@push('jsonld')
  <x-schema-jsonld :graph="$schemaGraph" />
@endpush
