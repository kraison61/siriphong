@props([
  'heading' => 'เราไม่รับเครื่องแบบไหน',
  'accept' => null,
  'reject' => null,
])

@if ($accept || $reject)
<section class="py-14 bg-offwhite" aria-labelledby="machine-filter-title">
  <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
    <div class="mb-8 max-w-2xl">
      <div class="font-display text-xs font-semibold tracking-[.14em] uppercase text-orange">คัดกรองเครื่อง</div>
      <h2 id="machine-filter-title" class="font-display font-bold text-navy mt-2 text-[clamp(1.4rem,3.5vw,2rem)]">
        {{ $heading }}
      </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
      @if ($accept)
        <div class="rounded-2xl bg-white border border-emerald-200 p-6 shadow-sm">
          <div class="flex items-center gap-2 font-display font-bold text-emerald-700 mb-3">
            <i class="bi bi-check-circle-fill" aria-hidden="true"></i> รับซ่อม
          </div>
          <p class="text-slate-700 leading-relaxed whitespace-pre-line">{{ $accept }}</p>
        </div>
      @endif
      @if ($reject)
        <div class="rounded-2xl bg-white border border-slate-200 p-6 shadow-sm">
          <div class="flex items-center gap-2 font-display font-bold text-slate-600 mb-3">
            <i class="bi bi-info-circle-fill" aria-hidden="true"></i> ไม่รับ / แนะนำต่อ
          </div>
          <p class="text-slate-700 leading-relaxed whitespace-pre-line">{{ $reject }}</p>
        </div>
      @endif
    </div>
  </div>
</section>
@endif
