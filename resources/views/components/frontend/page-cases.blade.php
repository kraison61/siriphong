@props([
  'heading' => 'ตัวอย่างงานที่ซ่อมไปแล้ว',
  'items' => [],
])

@php $items = is_array($items) ? $items : []; @endphp

@if (count($items) > 0)
<section class="py-14 bg-white" aria-labelledby="cases-title">
  <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
    <div class="mb-8 max-w-2xl">
      <div class="font-display text-xs font-semibold tracking-[.14em] uppercase text-orange">เคสจริง</div>
      <h2 id="cases-title" class="font-display font-bold text-navy mt-2 text-[clamp(1.4rem,3.5vw,2rem)]">
        {{ $heading }}
      </h2>
    </div>

    <div class="space-y-8">
      @foreach ($items as $case)
        @php
          $before = $case['before_image'] ?? null;
          $after = $case['after_image'] ?? ($case['image'] ?? null);
          $hasDetailFields = filled($case['fault'] ?? null)
            || filled($case['symptom'] ?? null)
            || filled($case['found'] ?? null)
            || filled($case['fixed'] ?? null);
          $singleImage = filled($after) && blank($before);
        @endphp
        <article class="rounded-2xl border border-slate-200 overflow-hidden shadow-sm bg-offwhite/40">
          <div class="grid grid-cols-1 lg:grid-cols-5 gap-0 items-stretch">
            @if ($singleImage)
              <div class="lg:col-span-2 bg-slate-100 flex items-center justify-center p-4 md:p-5 lg:p-6 min-h-[200px] lg:min-h-0 relative">
                <img
                  src="{{ \App\Support\MediaUrl::resolve($after) }}"
                  alt="{{ $case['title'] ?? 'เคสซ่อม' }}"
                  class="w-full h-auto max-h-[220px] md:max-h-[260px] lg:max-h-[300px] object-contain"
                  loading="lazy"
                >
                @if (!empty($case['status']))
                  <span class="absolute left-3 bottom-3 text-[11px] font-bold uppercase tracking-wide bg-line/90 text-white px-2 py-1 rounded">✓ {{ $case['status'] }}</span>
                @endif
              </div>
            @else
              <div class="lg:col-span-2 grid grid-cols-2 gap-px bg-slate-200 self-start lg:self-stretch">
                <div class="bg-slate-100 aspect-[4/3] lg:aspect-auto lg:h-full lg:min-h-[200px] lg:max-h-[300px] flex items-center justify-center relative overflow-hidden px-3">
                  @if (filled($before))
                    <img src="{{ \App\Support\MediaUrl::resolve($before) }}" alt="ก่อนซ่อม — {{ $case['title'] ?? '' }}" class="max-h-full max-w-full w-auto h-auto object-contain object-center" loading="lazy">
                  @else
                    <span class="text-slate-400 text-sm">รูปก่อนซ่อม</span>
                  @endif
                  <span class="absolute left-2 bottom-2 text-[11px] font-bold uppercase tracking-wide bg-navy/80 text-white px-2 py-1 rounded">ก่อน</span>
                </div>
                <div class="bg-slate-100 aspect-[4/3] lg:aspect-auto lg:h-full lg:min-h-[200px] lg:max-h-[300px] flex items-center justify-center relative overflow-hidden px-3">
                  @if (filled($after))
                    <img src="{{ \App\Support\MediaUrl::resolve($after) }}" alt="หลังซ่อม — {{ $case['title'] ?? '' }}" class="max-h-full max-w-full w-auto h-auto object-contain object-center" loading="lazy">
                  @else
                    <span class="text-slate-400 text-sm">รูปหลังซ่อม</span>
                  @endif
                  <span class="absolute left-2 bottom-2 text-[11px] font-bold uppercase tracking-wide bg-orange/90 text-white px-2 py-1 rounded">หลัง</span>
                </div>
              </div>
            @endif

            <div class="lg:col-span-3 p-6 md:p-8">
              @if (!empty($case['category']))
                <div class="text-[.72rem] font-bold text-orange uppercase tracking-[.1em] mb-1.5">{{ $case['category'] }}</div>
              @endif
              <h3 class="font-display font-bold text-navy text-xl">{{ $case['title'] ?? 'เคสซ่อม' }}</h3>

              @if ($hasDetailFields)
                <dl class="mt-4 space-y-3 text-sm">
                  @if (filled($case['fault'] ?? null))
                    <div>
                      <dt class="text-slate-400 font-medium">อาการเสีย</dt>
                      <dd class="text-slate-700 leading-relaxed">{{ $case['fault'] }}</dd>
                    </div>
                  @endif
                  <div>
                    <dt class="text-slate-400 font-medium">อาการที่ลูกค้าแจ้ง</dt>
                    <dd class="text-slate-700 leading-relaxed">{{ $case['symptom'] ?? '-' }}</dd>
                  </div>
                  <div>
                    <dt class="text-slate-400 font-medium">สิ่งที่ตรวจเจอ</dt>
                    <dd class="text-slate-700 leading-relaxed">{{ $case['found'] ?? '-' }}</dd>
                  </div>
                  <div>
                    <dt class="text-slate-400 font-medium">สิ่งที่เปลี่ยน / ซ่อม</dt>
                    <dd class="text-slate-700 leading-relaxed">{{ $case['fixed'] ?? '-' }}</dd>
                  </div>
                </dl>
              @elseif (!empty($case['description']))
                <p class="mt-4 text-sm text-slate-700 leading-relaxed">{{ $case['description'] }}</p>
              @endif

              <div class="mt-5 flex flex-wrap gap-x-4 gap-y-2 text-sm">
                @if (!empty($case['brands']))
                  <span class="inline-flex items-center gap-1.5 font-medium text-navy">
                    <i class="bi bi-tools text-orange" aria-hidden="true"></i> {{ $case['brands'] }}
                  </span>
                @endif
                @if (!empty($case['days']))
                  <span class="inline-flex items-center gap-1.5 font-medium text-navy">
                    <i class="bi bi-clock text-orange" aria-hidden="true"></i> {{ $case['days'] }}
                  </span>
                @endif
                @if (!empty($case['year']))
                  <span class="inline-flex items-center gap-1.5 font-medium text-navy">
                    <i class="bi bi-calendar3 text-orange" aria-hidden="true"></i> {{ $case['year'] }}
                  </span>
                @endif
                @if (!empty($case['price']))
                  <span class="inline-flex items-center gap-1.5 font-display font-bold text-orange">
                    <i class="bi bi-tag-fill" aria-hidden="true"></i> {{ $case['price'] }}
                  </span>
                @endif
              </div>
            </div>
          </div>
        </article>
      @endforeach
    </div>
  </div>
</section>
@endif
