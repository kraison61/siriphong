@php
  $portfolios = $portfolios ?? \App\Models\Portfolio::query()
    ->with('category')
    ->where('is_active', true)
    ->orderBy('sort_order')
    ->orderBy('id')
    ->get();
  $gradients = $gradients ?? [
    'bg-[linear-gradient(135deg,#0f2347,#2a5298)]',
    'bg-[linear-gradient(135deg,#1a3a6b,#0f2347)]',
    'bg-[linear-gradient(135deg,#2a5298,#1a3a6b)]',
  ];
  $portfolioPhotos = $portfolios
    ->filter(fn ($p) => $p->imageUrl())
    ->values()
    ->map(fn ($p) => [
      'src' => $p->imageUrl(),
      'title' => $p->title,
      'category' => $p->categoryName(),
    ])
    ->all();
  $photoIndex = 0;
  $totalSlides = $portfolios->count();
@endphp

<section
  class="py-18 bg-offwhite"
  id="portfolio"
  aria-labelledby="portfolio-title"
  data-portfolio-photos='@json($portfolioPhotos)'
>
  <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-5">
      <div data-reveal class="opacity-0 translate-y-6 transition duration-700 ease-out data-[show=true]:opacity-100 data-[show=true]:translate-y-0">
        <div class="font-display text-xs font-semibold tracking-[.14em] uppercase text-orange"><i class="bi bi-images" aria-hidden="true"></i> ผลงานที่ผ่านมา</div>
        <h2 class="font-display font-bold leading-tight text-navy mt-2 text-[clamp(1.6rem,4vw,2.4rem)]" id="portfolio-title">
          Case Studies <span class="text-orange">จากประสบการณ์จริง</span>
        </h2>
        @if ($totalSlides > 0)
          <p class="mt-2 text-sm text-slate-500">เลื่อนดูงานซ่อมจริงจากลูกค้า — กดรูปเพื่อขยาย</p>
        @endif
      </div>

      @if ($totalSlides > 1)
        <div
          data-reveal
          class="flex items-center gap-3 shrink-0 opacity-0 translate-y-6 transition duration-700 ease-out delay-100 data-[show=true]:opacity-100 data-[show=true]:translate-y-0"
          id="portfolio-carousel-controls"
        >
          <span id="portfolio-carousel-counter" class="font-display text-sm font-semibold text-navy tabular-nums min-w-[3.5rem] text-center" aria-live="polite"></span>
          <div class="flex items-center gap-2">
            <button
              type="button"
              id="portfolio-carousel-prev"
              class="portfolio-carousel-nav w-11 h-11 flex items-center justify-center rounded-full border border-slate-200 bg-white text-navy shadow-sm transition-all hover:border-orange hover:text-orange hover:shadow-md disabled:opacity-35 disabled:pointer-events-none disabled:hover:border-slate-200 disabled:hover:text-navy disabled:hover:shadow-sm"
              aria-label="ผลงานก่อนหน้า"
            >
              <i class="bi bi-chevron-left text-xl" aria-hidden="true"></i>
            </button>
            <button
              type="button"
              id="portfolio-carousel-next"
              class="portfolio-carousel-nav w-11 h-11 flex items-center justify-center rounded-full border border-slate-200 bg-white text-navy shadow-sm transition-all hover:border-orange hover:text-orange hover:shadow-md disabled:opacity-35 disabled:pointer-events-none disabled:hover:border-slate-200 disabled:hover:text-navy disabled:hover:shadow-sm"
              aria-label="ผลงานถัดไป"
            >
              <i class="bi bi-chevron-right text-xl" aria-hidden="true"></i>
            </button>
          </div>
        </div>
      @endif
    </div>

    @if ($totalSlides > 0)
      <div class="relative mt-10" id="portfolio-carousel">
        <div class="portfolio-carousel-viewport overflow-hidden" tabindex="0" aria-roledescription="carousel" aria-label="ผลงานที่ผ่านมา">
          <div class="portfolio-carousel-track flex gap-4 transition-transform duration-500 ease-[cubic-bezier(0.22,1,0.36,1)] will-change-transform">
            @foreach ($portfolios as $index => $item)
              @php
                $gradient = $gradients[$index % count($gradients)];
              @endphp
              <article
                class="portfolio-carousel-slide group shrink-0 w-full sm:w-[calc(50%-0.5rem)] lg:w-[calc(33.333%-0.667rem)] rounded-[20px] bg-white shadow-sm overflow-hidden transition-all duration-500 hover:shadow-lg hover:-translate-y-1.5"
                data-slide-index="{{ $index }}"
                aria-roledescription="slide"
              >
                <div class="relative overflow-hidden aspect-video flex items-center justify-center px-4 text-[3.5rem] text-white/15 {{ $gradient }} after:content-[''] after:absolute after:inset-0 after:bg-[linear-gradient(to_top,rgba(15,35,71,.55),transparent_60%)] after:pointer-events-none after:z-[1]">
                  @if ($item->imageUrl())
                    <button
                      type="button"
                      class="portfolio-lightbox-trigger absolute inset-0 z-[2] flex items-center justify-center cursor-zoom-in group/img"
                      data-portfolio-index="{{ $photoIndex }}"
                      aria-label="ดูรูป {{ $item->title }}"
                    >
                      <img
                        src="{{ $item->imageUrl() }}"
                        alt="{{ $item->title }}"
                        class="absolute inset-y-0 inset-x-4 z-0 w-[calc(100%-2rem)] h-full object-contain object-center pointer-events-none transition-transform duration-500 group-hover/img:scale-105"
                        loading="lazy"
                      >
                      <span class="absolute inset-0 z-[1] bg-navy/0 group-hover/img:bg-navy/10 transition-colors pointer-events-none" aria-hidden="true"></span>
                      <span class="absolute z-[3] w-10 h-10 flex items-center justify-center rounded-full bg-white/90 text-navy shadow-lg opacity-0 scale-75 group-hover/img:opacity-100 group-hover/img:scale-100 transition-all duration-300 pointer-events-none" aria-hidden="true">
                        <i class="bi bi-zoom-in text-lg"></i>
                      </span>
                    </button>
                    @php $photoIndex++; @endphp
                  @else
                    <i class="bi bi-tools text-white/20 relative z-[2]" aria-hidden="true"></i>
                  @endif
                  <span class="absolute bottom-2.5 right-2.5 z-[3] px-2.5 py-[3px] rounded-full bg-line/90 text-white text-[.68rem] font-bold tracking-wide">✓ {{ $item->status_label }}</span>
                </div>
                <div class="p-5">
                  <div class="text-[.72rem] font-bold text-orange uppercase tracking-[.1em] mb-1.5">{{ $item->categoryName() }}</div>
                  <h3 class="font-display font-bold text-[1.05rem] text-navy leading-snug mb-2">{{ $item->title }}</h3>
                  <div class="flex flex-wrap gap-x-4 gap-y-1.5 text-sm text-slate-500">
                    @if ($item->brands)
                      <span class="flex items-center gap-1.5"><i class="bi bi-tools text-orange/70" aria-hidden="true"></i>{{ $item->brands }}</span>
                    @endif
                    @if ($item->year)
                      <span class="flex items-center gap-1.5"><i class="bi bi-calendar3 text-orange/70" aria-hidden="true"></i>{{ $item->year }}</span>
                    @endif
                    @if ($item->duration)
                      <span class="flex items-center gap-1.5"><i class="bi bi-clock text-orange/70" aria-hidden="true"></i>{{ $item->duration }}</span>
                    @endif
                  </div>
                </div>
              </article>
            @endforeach
          </div>
        </div>

        @if ($totalSlides > 1)
          <div class="mt-8 flex flex-col items-center gap-4">
            <div id="portfolio-carousel-dots" class="flex flex-wrap justify-center gap-2" role="tablist" aria-label="เลือกผลงาน"></div>
            <div class="w-full max-w-xs h-1 rounded-full bg-slate-200/80 overflow-hidden" aria-hidden="true">
              <div id="portfolio-carousel-progress" class="h-full rounded-full bg-gradient-to-r from-orange to-orange-dark transition-[width] duration-300 ease-out" style="width: 0%"></div>
            </div>
          </div>
        @endif
      </div>
    @else
      <p class="mt-10 text-center text-slate-500 py-10 rounded-2xl border border-dashed border-slate-200 bg-white/60">ยังไม่มีผลงานในระบบ</p>
    @endif
  </div>

  {{-- Lightbox --}}
  <div
    id="portfolio-lightbox"
    class="fixed inset-0 z-[200] flex items-center justify-center bg-navy/95 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 data-[open=true]:opacity-100 data-[open=true]:pointer-events-auto"
    role="dialog"
    aria-modal="true"
    aria-label="ดูรูปผลงาน"
    hidden
  >
    <button
      type="button"
      id="portfolio-lightbox-close"
      class="absolute top-4 right-4 md:top-6 md:right-6 z-[3] w-11 h-11 flex items-center justify-center rounded-full text-white/80 hover:text-white bg-white/10 hover:bg-white/20 transition-colors"
      aria-label="ปิด"
    >
      <i class="bi bi-x-lg text-xl" aria-hidden="true"></i>
    </button>

    <button
      type="button"
      id="portfolio-lightbox-prev"
      class="absolute left-3 md:left-8 z-[3] w-11 h-11 flex items-center justify-center rounded-full text-white/80 hover:text-white bg-white/10 hover:bg-white/20 transition-colors"
      aria-label="รูปก่อนหน้า"
    >
      <i class="bi bi-chevron-left text-2xl" aria-hidden="true"></i>
    </button>

    <button
      type="button"
      id="portfolio-lightbox-next"
      class="absolute right-3 md:right-8 z-[3] w-11 h-11 flex items-center justify-center rounded-full text-white/80 hover:text-white bg-white/10 hover:bg-white/20 transition-colors"
      aria-label="รูปถัดไป"
    >
      <i class="bi bi-chevron-right text-2xl" aria-hidden="true"></i>
    </button>

    <div class="w-full max-w-5xl px-4 md:px-20 flex flex-col items-center" id="portfolio-lightbox-content">
      <img
        id="portfolio-lightbox-image"
        src=""
        alt=""
        class="w-full max-h-[75vh] object-contain rounded-lg shadow-2xl"
      >
      <div class="text-center mt-5">
        <div id="portfolio-lightbox-category" class="text-xs font-bold text-orange uppercase tracking-[.1em] mb-1"></div>
        <h3 id="portfolio-lightbox-title" class="font-display font-bold text-white text-xl md:text-2xl"></h3>
        <div id="portfolio-lightbox-counter" class="text-white/50 text-sm mt-2"></div>
      </div>
    </div>
  </div>
</section>
