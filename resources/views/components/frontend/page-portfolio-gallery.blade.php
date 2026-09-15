@props([
  'heading' => 'ตัวอย่างงานที่ซ่อมไปแล้ว',
  'items' => [],
])

@php
  $items = is_array($items) ? $items : [];
  $gradients = [
    'bg-[linear-gradient(135deg,#0f2347,#2a5298)]',
    'bg-[linear-gradient(135deg,#1a3a6b,#0f2347)]',
    'bg-[linear-gradient(135deg,#2a5298,#1a3a6b)]',
  ];
  $categories = collect($items)
    ->map(fn ($case) => [
      'slug' => $case['category_slug'] ?? null,
      'name' => $case['category'] ?? null,
    ])
    ->filter(fn ($c) => filled($c['slug']) && filled($c['name']))
    ->unique('slug')
    ->values()
    ->all();
  $photos = [];
  $photoIndexByItem = [];
  foreach ($items as $i => $case) {
    $src = \App\Support\MediaUrl::resolve($case['image'] ?? null);
    if ($src) {
      $photoIndexByItem[$i] = count($photos);
      $photos[] = [
        'src' => $src,
        'title' => $case['title'] ?? 'เคสซ่อม',
        'category' => $case['category'] ?? '',
      ];
    }
  }
@endphp

@if (count($items) > 0)
<section
  class="py-14 bg-white"
  id="portfolio-gallery"
  aria-labelledby="cases-title"
  data-portfolio-photos='@json($photos)'
>
  <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
    <div class="mb-8 max-w-2xl">
      <div class="font-display text-xs font-semibold tracking-[.14em] uppercase text-orange">เคสจริง</div>
      <h2 id="cases-title" class="font-display font-bold text-navy mt-2 text-[clamp(1.4rem,3.5vw,2rem)]">
        {{ $heading }}
      </h2>
      <p class="mt-2 text-sm text-slate-500">เลือกหมวดที่สนใจ กดการ์ดเพื่อดูรายละเอียด หรือกดรูปเพื่อขยาย</p>
    </div>

    @if (count($categories) > 1)
      <div
        class="flex gap-2 overflow-x-auto pb-1 mb-8 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden"
        role="group"
        aria-label="กรองหมวดผลงาน"
      >
        <button
          type="button"
          data-filter="all"
          aria-pressed="true"
          class="portfolio-gallery-filter filter-btn inline-flex items-center gap-1.5 min-h-[44px] px-[18px] py-2.5 rounded-full text-sm font-semibold shrink-0 whitespace-nowrap border-[1.5px] border-navy/10 bg-white text-navy/70 transition-all hover:border-navy hover:text-navy aria-pressed:bg-navy aria-pressed:border-navy aria-pressed:text-white aria-pressed:shadow"
        >
          <i class="bi bi-grid-fill" aria-hidden="true"></i> ทั้งหมด
        </button>
        @foreach ($categories as $category)
          <button
            type="button"
            data-filter="{{ $category['slug'] }}"
            aria-pressed="false"
            class="portfolio-gallery-filter filter-btn inline-flex items-center gap-1.5 min-h-[44px] px-[18px] py-2.5 rounded-full text-sm font-semibold shrink-0 whitespace-nowrap border-[1.5px] border-navy/10 bg-white text-navy/70 transition-all hover:border-navy hover:text-navy aria-pressed:bg-navy aria-pressed:border-navy aria-pressed:text-white aria-pressed:shadow"
          >
            {{ $category['name'] }}
          </button>
        @endforeach
      </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" id="portfolio-gallery-grid">
      @foreach ($items as $index => $case)
        @php
          $gradient = $gradients[$index % count($gradients)];
          $imageUrl = \App\Support\MediaUrl::resolve($case['image'] ?? null);
          $hasDetailFields = filled($case['fault'] ?? null)
            || filled($case['symptom'] ?? null)
            || filled($case['found'] ?? null)
            || filled($case['fixed'] ?? null);
          $hasExpandable = $hasDetailFields || filled($case['description'] ?? null);
          $photoIndex = $photoIndexByItem[$index] ?? null;
          $categorySlug = $case['category_slug'] ?? '';
          $categoryName = $case['category'] ?? '';
          $categoryDetail = $case['category_label'] ?? null;
        @endphp

        <article
          class="portfolio-case-card group flex flex-col rounded-[20px] bg-white shadow-sm overflow-hidden border border-slate-100 transition-all duration-300 hover:shadow-lg hover:-translate-y-1"
          data-category="{{ $categorySlug }}"
        >
          <div class="relative overflow-hidden aspect-video flex items-center justify-center {{ $gradient }} after:content-[''] after:absolute after:inset-0 after:bg-[linear-gradient(to_top,rgba(15,35,71,.55),transparent_60%)] after:pointer-events-none after:z-[1]">
            @if ($imageUrl && $photoIndex !== null)
              <button
                type="button"
                class="portfolio-gallery-lightbox-trigger absolute inset-0 z-[2] flex items-center justify-center cursor-zoom-in group/img"
                data-portfolio-index="{{ $photoIndex }}"
                aria-label="ดูรูป {{ $case['title'] ?? 'เคสซ่อม' }}"
              >
                <img
                  src="{{ $imageUrl }}"
                  alt="{{ $case['title'] ?? 'เคสซ่อม' }}"
                  class="absolute inset-y-0 inset-x-4 z-0 w-[calc(100%-2rem)] h-full object-contain object-center pointer-events-none transition-transform duration-500 group-hover/img:scale-105"
                  loading="lazy"
                >
                <span class="absolute inset-0 z-[1] bg-navy/0 group-hover/img:bg-navy/10 transition-colors pointer-events-none" aria-hidden="true"></span>
                <span class="absolute z-[3] w-10 h-10 flex items-center justify-center rounded-full bg-white/90 text-navy shadow-lg opacity-0 scale-75 group-hover/img:opacity-100 group-hover/img:scale-100 transition-all duration-300 pointer-events-none" aria-hidden="true">
                  <i class="bi bi-zoom-in text-lg"></i>
                </span>
              </button>
            @elseif ($imageUrl)
              <img
                src="{{ $imageUrl }}"
                alt="{{ $case['title'] ?? 'เคสซ่อม' }}"
                class="absolute inset-y-0 inset-x-4 z-[2] w-[calc(100%-2rem)] h-full object-contain object-center"
                loading="lazy"
              >
            @else
              <i class="bi bi-tools text-white/20 relative z-[2] text-4xl" aria-hidden="true"></i>
            @endif

            @if (!empty($case['status']))
              <span class="absolute bottom-2.5 right-2.5 z-[3] px-2.5 py-[3px] rounded-full bg-line/90 text-white text-[.68rem] font-bold tracking-wide">✓ {{ $case['status'] }}</span>
            @endif
          </div>

          <div class="flex flex-col flex-1 p-5">
            @if (filled($categoryName))
              <div class="text-[.72rem] font-bold text-orange uppercase tracking-[.1em] mb-1.5">
                {{ $categoryName }}
                @if (filled($categoryDetail) && $categoryDetail !== $categoryName)
                  <span class="font-medium text-slate-400 normal-case tracking-normal">· {{ $categoryDetail }}</span>
                @endif
              </div>
            @endif

            <h3 class="font-display font-bold text-[1.05rem] text-navy leading-snug line-clamp-2">
              @if (!empty($case['url']))
                <a href="{{ url($case['url']) }}" class="hover:text-orange transition-colors">{{ $case['title'] ?? 'เคสซ่อม' }}</a>
              @else
                {{ $case['title'] ?? 'เคสซ่อม' }}
              @endif
            </h3>

            @if (filled($case['fault'] ?? null))
              <p class="mt-2 text-sm text-slate-600 line-clamp-2">
                <span class="font-medium text-slate-400">อาการเสีย:</span> {{ $case['fault'] }}
              </p>
            @endif

            <div class="mt-3 flex flex-wrap gap-x-3 gap-y-1.5 text-sm text-slate-500">
              @if (!empty($case['brands']))
                <span class="inline-flex items-center gap-1"><i class="bi bi-tools text-orange/70" aria-hidden="true"></i>{{ $case['brands'] }}</span>
              @endif
              @if (!empty($case['days']))
                <span class="inline-flex items-center gap-1"><i class="bi bi-clock text-orange/70" aria-hidden="true"></i>{{ $case['days'] }}</span>
              @endif
              @if (!empty($case['year']))
                <span class="inline-flex items-center gap-1"><i class="bi bi-calendar3 text-orange/70" aria-hidden="true"></i>{{ $case['year'] }}</span>
              @endif
              @if (!empty($case['price']))
                <span class="inline-flex items-center gap-1 font-display font-bold text-orange"><i class="bi bi-tag-fill" aria-hidden="true"></i>{{ $case['price'] }}</span>
              @endif
            </div>

            @if ($hasExpandable)
              <button
                type="button"
                class="portfolio-case-toggle mt-4 inline-flex items-center justify-center gap-2 min-h-[40px] w-full rounded-xl text-sm font-bold text-navy bg-offwhite border border-slate-200 transition-colors hover:border-orange hover:text-orange"
                aria-expanded="false"
                aria-controls="portfolio-case-detail-{{ $index }}"
              >
                <span class="portfolio-case-toggle-label">ดูรายละเอียด</span>
                <i class="bi bi-chevron-down portfolio-case-toggle-icon transition-transform duration-300" aria-hidden="true"></i>
              </button>

              <div
                id="portfolio-case-detail-{{ $index }}"
                class="portfolio-case-detail hidden mt-4 pt-4 border-t border-slate-100"
                hidden
              >
                @if ($hasDetailFields)
                  <dl class="space-y-3 text-sm">
                    @if (filled($case['fault'] ?? null))
                      <div>
                        <dt class="text-slate-400 font-medium">อาการเสีย</dt>
                        <dd class="text-slate-700 leading-relaxed">{{ $case['fault'] }}</dd>
                      </div>
                    @endif
                    @if (filled($case['symptom'] ?? null))
                      <div>
                        <dt class="text-slate-400 font-medium">อาการที่ลูกค้าแจ้ง</dt>
                        <dd class="text-slate-700 leading-relaxed">{{ $case['symptom'] }}</dd>
                      </div>
                    @endif
                    @if (filled($case['found'] ?? null))
                      <div>
                        <dt class="text-slate-400 font-medium">สิ่งที่ตรวจเจอ</dt>
                        <dd class="text-slate-700 leading-relaxed">{{ $case['found'] }}</dd>
                      </div>
                    @endif
                    @if (filled($case['fixed'] ?? null))
                      <div>
                        <dt class="text-slate-400 font-medium">สิ่งที่เปลี่ยน / ซ่อม</dt>
                        <dd class="text-slate-700 leading-relaxed">{{ $case['fixed'] }}</dd>
                      </div>
                    @endif
                  </dl>
                @elseif (!empty($case['description']))
                  <p class="text-sm text-slate-700 leading-relaxed">{{ $case['description'] }}</p>
                @endif
              </div>
            @endif
          </div>
        </article>
      @endforeach
    </div>

    <p id="portfolio-gallery-empty" class="hidden mt-10 text-center text-slate-500 py-10 rounded-2xl border border-dashed border-slate-200 bg-offwhite/60">
      ไม่พบผลงานในหมวดนี้
    </p>
  </div>

  {{-- Lightbox --}}
  <div
    id="portfolio-gallery-lightbox"
    class="fixed inset-0 z-[200] flex items-center justify-center bg-navy/95 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 data-[open=true]:opacity-100 data-[open=true]:pointer-events-auto"
    role="dialog"
    aria-modal="true"
    aria-label="ดูรูปผลงาน"
    hidden
  >
    <button
      type="button"
      id="portfolio-gallery-lightbox-close"
      class="absolute top-4 right-4 md:top-6 md:right-6 z-[3] w-11 h-11 flex items-center justify-center rounded-full text-white/80 hover:text-white bg-white/10 hover:bg-white/20 transition-colors"
      aria-label="ปิด"
    >
      <i class="bi bi-x-lg text-xl" aria-hidden="true"></i>
    </button>

    <button
      type="button"
      id="portfolio-gallery-lightbox-prev"
      class="absolute left-3 md:left-8 z-[3] w-11 h-11 flex items-center justify-center rounded-full text-white/80 hover:text-white bg-white/10 hover:bg-white/20 transition-colors"
      aria-label="รูปก่อนหน้า"
    >
      <i class="bi bi-chevron-left text-2xl" aria-hidden="true"></i>
    </button>

    <button
      type="button"
      id="portfolio-gallery-lightbox-next"
      class="absolute right-3 md:right-8 z-[3] w-11 h-11 flex items-center justify-center rounded-full text-white/80 hover:text-white bg-white/10 hover:bg-white/20 transition-colors"
      aria-label="รูปถัดไป"
    >
      <i class="bi bi-chevron-right text-2xl" aria-hidden="true"></i>
    </button>

    <div class="w-full max-w-5xl px-4 md:px-20 flex flex-col items-center" id="portfolio-gallery-lightbox-content">
      <img
        id="portfolio-gallery-lightbox-image"
        src=""
        alt=""
        class="w-full max-h-[75vh] object-contain rounded-lg shadow-2xl"
      >
      <div class="text-center mt-5">
        <div id="portfolio-gallery-lightbox-category" class="text-xs font-bold text-orange uppercase tracking-[.1em] mb-1"></div>
        <h3 id="portfolio-gallery-lightbox-title" class="font-display font-bold text-white text-xl md:text-2xl"></h3>
        <div id="portfolio-gallery-lightbox-counter" class="text-white/50 text-sm mt-2"></div>
      </div>
    </div>
  </div>
</section>
@endif
