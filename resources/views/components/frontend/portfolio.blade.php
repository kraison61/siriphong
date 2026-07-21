@php
  $portfolios = $portfolios ?? \App\Models\Portfolio::query()
    ->where('is_active', true)
    ->orderBy('sort_order')
    ->orderBy('id')
    ->get();
  $gradients = $gradients ?? [
    'bg-[linear-gradient(135deg,#0f2347,#2a5298)]',
    'bg-[linear-gradient(135deg,#1a3a6b,#0f2347)]',
    'bg-[linear-gradient(135deg,#2a5298,#1a3a6b)]',
  ];
@endphp

<section class="py-18 bg-offwhite" id="portfolio" aria-labelledby="portfolio-title">
  <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
    <div data-reveal class="opacity-0 translate-y-6 transition duration-700 ease-out data-[show=true]:opacity-100 data-[show=true]:translate-y-0">
      <div class="font-display text-xs font-semibold tracking-[.14em] uppercase text-orange"><i class="bi bi-images" aria-hidden="true"></i> ผลงานที่ผ่านมา</div>
      <h2 class="font-display font-bold leading-tight text-navy mt-2 text-[clamp(1.6rem,4vw,2.4rem)]" id="portfolio-title">
        Case Studies <span class="text-orange">จากประสบการณ์จริง</span>
      </h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-10">
      @forelse ($portfolios as $index => $item)
        @php
          $delay = match ($index % 3) {
            1 => 'delay-100',
            2 => 'delay-200',
            default => '',
          };
          $gradient = $gradients[$index % count($gradients)];
        @endphp
        <article data-reveal class="overflow-hidden rounded-[20px] bg-white shadow-sm transition-all opacity-0 translate-y-6 duration-700 ease-out {{ $delay }} data-[show=true]:opacity-100 data-[show=true]:translate-y-0 hover:shadow-lg hover:-translate-y-1.5">
          <div class="relative h-45 flex items-center justify-center px-4 text-[4rem] text-white/15 {{ $gradient }} after:content-[''] after:absolute after:inset-0 after:bg-[linear-gradient(to_top,rgba(15,35,71,.45),transparent_60%)] after:pointer-events-none after:z-[1]">
            @if ($item->imageUrl())
              <img
                src="{{ asset($item->imageUrl()) }}"
                alt="{{ $item->title }}"
                class="absolute inset-y-0 inset-x-4 z-0 w-[calc(100%-2rem)] h-full object-contain object-center"
                loading="lazy"
              >
            @endif
            <span class="absolute bottom-2.5 right-2.5 z-[2] px-2.5 py-[3px] rounded-full bg-line/90 text-white text-[.68rem] font-bold tracking-wide">✓ {{ $item->status_label }}</span>
          </div>
          <div class="p-5">
            <div class="text-[.72rem] font-bold text-orange uppercase tracking-[.1em] mb-1.5">{{ $item->category_label }}</div>
            <h3 class="font-display font-bold text-navy leading-snug mb-2">{{ $item->title }}</h3>
            <div class="flex flex-wrap gap-x-4 gap-y-1 text-sm text-slate-500">
              @if ($item->brands)
                <span class="flex items-center gap-1"><i class="bi bi-tools" aria-hidden="true"></i>{{ $item->brands }}</span>
              @endif
              @if ($item->year)
                <span class="flex items-center gap-1"><i class="bi bi-calendar3" aria-hidden="true"></i> {{ $item->year }}</span>
              @endif
              @if ($item->duration)
                <span class="flex items-center gap-1"><i class="bi bi-clock" aria-hidden="true"></i> {{ $item->duration }}</span>
              @endif
            </div>
          </div>
        </article>
      @empty
        <p class="col-span-full text-center text-slate-500 py-10">ยังไม่มีผลงานในระบบ</p>
      @endforelse
    </div>
  </div>
</section>
