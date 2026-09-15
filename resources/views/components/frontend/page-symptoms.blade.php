@props([
  'heading' => 'อาการที่เจอบ่อย',
  'items' => [],
])

@php $items = is_array($items) ? $items : []; @endphp

@if (count($items) > 0)
<section class="py-14 bg-offwhite" aria-labelledby="symptoms-title">
  <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
    <div class="mb-8 max-w-2xl">
      <div class="font-display text-xs font-semibold tracking-[.14em] uppercase text-orange">วินิจฉัยเบื้องต้น</div>
      <h2 id="symptoms-title" class="font-display font-bold text-navy mt-2 text-[clamp(1.4rem,3.5vw,2rem)]">
        {{ $heading }}
      </h2>
    </div>

    <div class="space-y-4">
      @foreach ($items as $item)
        <article class="rounded-2xl bg-white border border-slate-200 p-5 md:p-6 shadow-sm">
          <h3 class="font-display font-bold text-navy text-lg">{{ $item['symptom'] ?? '' }}</h3>
          <dl class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div>
              <dt class="text-slate-400 font-medium mb-1">สาเหตุที่เป็นไปได้</dt>
              <dd class="text-slate-700 leading-relaxed">{{ $item['cause'] ?? '-' }}</dd>
            </div>
            <div>
              <dt class="text-slate-400 font-medium mb-1">ซ่อมได้ไหม</dt>
              <dd class="text-slate-700 leading-relaxed">{{ $item['repairable'] ?? '-' }}</dd>
            </div>
            <div>
              <dt class="text-slate-400 font-medium mb-1">ประมาณราคา</dt>
              <dd class="font-display font-bold text-orange">{{ $item['price'] ?? '-' }}</dd>
            </div>
          </dl>
        </article>
      @endforeach
    </div>
  </div>
</section>
@endif
