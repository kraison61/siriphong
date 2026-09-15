@extends('layout.frontend')

@section('content')
  <x-frontend.page-hero :page="$page" />

  @php
    $prices = $page->block('price_table', []);
    $bridges = $page->block('bridge_sections', []);
    $faqs = $page->block('faqs', []);
    $source = $page->block('price_source', []);

    $priceRows = \App\Models\Product::query()
      ->with('category')
      ->where('type', 'service')
      ->where('is_active', true)
      ->orderByDesc('is_featured')
      ->orderBy('id')
      ->get()
      ->map(fn (\App\Models\Product $service) => $service->toPriceRow())
      ->all();
  @endphp

  {{-- ตารางราคาจาก products (type=service) — heading/intro/note จาก page blocks --}}
  <x-frontend.page-price-table
    :heading="$prices['heading'] ?? 'ตารางราคาซ่อม'"
    :intro="$prices['intro'] ?? null"
    :rows="$priceRows"
    :note="$prices['note'] ?? null"
  />

  @foreach ((is_array($bridges) ? $bridges : []) as $bridge)
    <x-frontend.page-bridge
      :heading="$bridge['heading'] ?? null"
      :body="$bridge['body'] ?? null"
      :cta-label="$bridge['cta_label'] ?? null"
      :cta-url="$bridge['cta_url'] ?? null"
      :tone="$bridge['tone'] ?? 'default'"
    />
  @endforeach

  @if (!empty($source['heading']) || !empty($source['body']))
    <section class="py-14 bg-offwhite" aria-labelledby="price-source-title">
      <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8 max-w-3xl">
        <div class="font-display text-xs font-semibold tracking-[.14em] uppercase text-orange">ที่มาของตัวเลข</div>
        <h2 id="price-source-title" class="font-display font-bold text-navy mt-2 text-[clamp(1.4rem,3.5vw,2rem)]">
          {{ $source['heading'] ?? 'ตัวเลขนี้มาจากไหน' }}
        </h2>
        <p class="mt-4 text-slate-600 leading-relaxed whitespace-pre-line">{{ $source['body'] ?? '' }}</p>
      </div>
    </section>
  @endif

  <x-frontend.page-faqs
    :heading="$faqs['heading'] ?? 'คำถามที่พบบ่อยเรื่องราคา'"
    :items="$faqs['items'] ?? []"
  />

  <section class="py-12 bg-navy">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
      <div>
        <p class="font-display font-bold text-white text-xl">อยากรู้ราคาเคสของคุณ?</p>
        <p class="mt-1 text-white/60 text-sm">ส่งรูปป้ายเครื่อง + อาการ เราประเมินช่วงราคาให้ภายในวันทำการ</p>
      </div>
      <x-frontend.page-cta label="ส่งรูปมาประเมิน" />
    </div>
  </section>
@endsection

@push('jsonld')
  <x-schema-jsonld :graph="$schemaGraph" />
@endpush
