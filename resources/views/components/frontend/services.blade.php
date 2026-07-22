@php
  $categories = $categories ?? \App\Models\Category::query()->where('type', 'service')->orderBy('sort_order')->get();
  $services = $services ?? \App\Models\Product::query()
    ->with('category')
    ->where('type', 'service')
    ->where('is_active', true)
    ->orderByDesc('is_featured')
    ->orderBy('id')
    ->get();
  $categoryIcons = $categoryIcons ?? [];
  $gradients = $gradients ?? [
    'bg-[linear-gradient(135deg,#0f2347_0%,#3d5a80_100%)]',
    'bg-[linear-gradient(135deg,#1e4a8a,#0f2347)]',
    'bg-[linear-gradient(135deg,#1a3a6b,#0d2b5e)]',
    'bg-[linear-gradient(135deg,#2a5298,#1a3a6b)]',
  ];
@endphp

<section class="py-18 bg-offwhite" id="services" aria-labelledby="services-title">
  <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
    <div data-reveal class="mb-10 opacity-0 translate-y-6 transition duration-700 ease-out data-[show=true]:opacity-100 data-[show=true]:translate-y-0">
      <div class="font-display text-xs font-semibold tracking-[.14em] uppercase text-orange">
        <i class="bi bi-tools" aria-hidden="true"></i> บริการของเรา
      </div>
      <h2 class="font-display font-bold leading-tight text-navy mt-2 text-[clamp(1.6rem,4vw,2.4rem)]" id="services-title">
        ซ่อมครบ ทุกประเภท<br>
        <span class="text-orange">เครื่องดูดฝุ่นอุตสาหกรรม</span>
      </h2>
    </div>

    <!-- Filter bar -->
    <div class="flex gap-2 overflow-x-auto pb-1 mb-8 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden" role="group" aria-label="กรองประเภทบริการ">
      <button onclick="filterServices('all')" aria-pressed="true" class="filter-btn inline-flex items-center gap-1.5 min-h-[44px] px-[18px] py-2.5 rounded-full text-sm font-semibold shrink-0 whitespace-nowrap border-[1.5px] border-navy/10 bg-white text-navy/70 transition-all hover:border-navy hover:text-navy aria-pressed:bg-navy aria-pressed:border-navy aria-pressed:text-white aria-pressed:shadow">
        <i class="bi bi-grid-fill" aria-hidden="true"></i> ทั้งหมด
      </button>
      @foreach ($categories as $category)
        <button onclick="filterServices('{{ $category->slug }}')" aria-pressed="false" class="filter-btn inline-flex items-center gap-1.5 min-h-[44px] px-[18px] py-2.5 rounded-full text-sm font-semibold shrink-0 whitespace-nowrap border-[1.5px] border-navy/10 bg-white text-navy/70 transition-all hover:border-navy hover:text-navy aria-pressed:bg-navy aria-pressed:border-navy aria-pressed:text-white aria-pressed:shadow">
          <i class="bi {{ $categoryIcons[$category->slug] ?? 'bi-tools' }}" aria-hidden="true"></i> {{ $category->name }}
        </button>
      @endforeach
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" id="services-grid">
      @forelse ($services as $index => $service)
        @php
          $delay = match ($index % 3) {
            1 => 'delay-100',
            2 => 'delay-200',
            default => '',
          };
          $gradient = $gradients[$index % count($gradients)];
          $isHighlight = $loop->last && (float) $service->price <= 0;
        @endphp
        <article data-reveal data-category="{{ $service->category?->slug }}" class="service-card group relative overflow-hidden rounded-[20px] bg-white shadow-sm cursor-pointer transition-all opacity-0 translate-y-6 duration-700 ease-out {{ $delay }} data-[show=true]:opacity-100 data-[show=true]:translate-y-0 hover:shadow-lg hover:-translate-y-1.5">
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
            <h3 class="font-display font-bold text-[1.05rem] text-navy leading-snug mb-2">{{ $service->name }}</h3>
            <p class="text-sm text-slate-600 leading-relaxed mb-4 line-clamp-3">{{ $service->short_description }}</p>
            <div class="flex items-center justify-between pt-4 border-t border-navy/5">
              <span class="text-sm font-bold text-orange"><i class="bi bi-tag-fill mr-1" aria-hidden="true"></i>{{ $service->priceLabel() }}</span>
              @if ($isHighlight)
                <a href="#contact" class="inline-flex items-center justify-center gap-2 min-h-[40px] px-4 py-2 rounded-lg text-sm font-bold text-white bg-orange shadow-[0_4px_16px_rgba(242,101,34,.35)] transition-all hover:bg-orange-dark hover:-translate-y-0.5">ติดต่อเลย <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
              @else
                <a href="#contact" class="inline-flex items-center justify-center gap-2 min-h-[40px] px-4 py-2 rounded-lg text-sm font-bold text-white bg-navy shadow transition-all hover:bg-navy-mid hover:-translate-y-0.5">ดูรายละเอียด <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
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
