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
@endphp

@section('content')

  {{-- Page hero --}}
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
          class="font-display font-bold text-white leading-tight mt-2 text-[clamp(1.8rem,5vw,2.8rem)]"
          id="page-title">
          เครื่องดูดฝุ่น · อะไหล่ · <span class="text-orange">บริการซ่อม</span>
        </h1>
        <p class="max-w-[560px] mt-4 text-white/70 leading-relaxed">
          จำหน่ายเครื่องดูดฝุ่นอุตสาหกรรมและอะไหล่แท้ พร้อมบริการซ่อมครบวงจร ตรวจเช็คฟรี รับประกันงาน
        </p>
      </div>
    </div>
  </section>

  {{-- Products --}}
  <section class="py-18 bg-offwhite" id="products" aria-labelledby="products-title">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
      <div data-reveal class="mb-10 opacity-0 translate-y-6 transition duration-700 ease-out data-[show=true]:opacity-100 data-[show=true]:translate-y-0">
        <div class="font-display text-xs font-semibold tracking-[.14em] uppercase text-orange">
          <i class="bi bi-box-seam" aria-hidden="true"></i> สินค้า
        </div>
        <h2 class="font-display font-bold leading-tight text-navy mt-2 text-[clamp(1.6rem,4vw,2.4rem)]" id="products-title">
          เครื่องดูดฝุ่นและอะไหล่<br>
          <span class="text-orange">คุณภาพมาตรฐานอุตสาหกรรม</span>
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
            class="catalog-card group relative overflow-hidden rounded-[20px] bg-white shadow-sm transition-all opacity-0 translate-y-6 duration-700 ease-out {{ $delay }} data-[show=true]:opacity-100 data-[show=true]:translate-y-0 hover:shadow-lg hover:-translate-y-1.5">
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

  {{-- Services --}}
  <section class="py-18 bg-white" id="services" aria-labelledby="services-title">
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

  {{-- CTA --}}
  <section class="py-14 bg-navy" aria-labelledby="cta-title">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8 text-center">
      <div data-reveal class="opacity-0 translate-y-6 transition duration-700 ease-out data-[show=true]:opacity-100 data-[show=true]:translate-y-0">
        <h2 class="font-display font-bold text-white text-[clamp(1.4rem,3.5vw,2rem)] mb-3" id="cta-title">
          สนใจสินค้าหรือต้องการให้ประเมินอาการ?
        </h2>
        <p class="text-white/60 mb-6 max-w-lg mx-auto">ติดต่อทีมงานได้ทันที ตรวจเช็คอาการฟรี ไม่ซ่อมไม่คิดค่าใช้จ่าย</p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
          <a href="{{ config('data.line') }}" target="_blank" rel="noopener"
            class="inline-flex items-center justify-center gap-2 min-h-[52px] px-7 py-3 rounded-xl font-bold text-white bg-line shadow-[0_4px_16px_rgba(6,199,85,.35)] transition-all hover:bg-line-dark hover:-translate-y-0.5">
            <i class="bi bi-chat-dots-fill" aria-hidden="true"></i> แอดไลน์สอบถาม
          </a>
          <a href="{{ route('home') }}#contact"
            class="inline-flex items-center justify-center gap-2 min-h-[52px] px-7 py-3 rounded-xl font-bold text-white bg-transparent border-2 border-white/55 transition-all hover:bg-white/10 hover:border-white">
            <i class="bi bi-telephone-fill" aria-hidden="true"></i> ติดต่อเรา
          </a>
        </div>
      </div>
    </div>
  </section>

@endsection

@push('jsonld')
  <x-schema-jsonld :graph="$schemaGraph" />
@endpush
