@extends('layout.frontend')

@section('content')
  <x-frontend.page-hero :page="$page" />

  @php
    $cases = $page->block('cases', []);
    $faqs = $page->block('faqs', []);

    $caseItems = \App\Models\Portfolio::query()
      ->with('category')
      ->where('is_active', true)
      ->orderBy('sort_order')
      ->orderBy('id')
      ->get()
      ->map(fn (\App\Models\Portfolio $item) => $item->toCaseItem())
      ->all();
  @endphp

  {{-- กริดผลงาน + filter + accordion + lightbox — ข้อมูลจากตาราง portfolios --}}
  <x-frontend.page-portfolio-gallery
    :heading="$cases['heading'] ?? 'ตัวอย่างงานที่ซ่อมไปแล้ว'"
    :items="$caseItems"
  />

  @if ($children->isNotEmpty())
    <section class="py-14 bg-offwhite">
      <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
        <h2 class="font-display font-bold text-navy text-[clamp(1.4rem,3.5vw,2rem)] mb-8">เคสรายละเอียด</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
          @foreach ($children as $child)
            <a href="{{ url($child->urlPath()) }}"
              class="group rounded-2xl overflow-hidden border border-slate-200 bg-white shadow-sm transition-all hover:border-orange hover:-translate-y-0.5">
              <div class="aspect-video bg-slate-100 flex items-center justify-center">
                @if ($child->heroImageUrl())
                  <img src="{{ $child->heroImageUrl() }}" alt="{{ $child->title }}" class="w-full h-full object-cover">
                @else
                  <i class="bi bi-images text-4xl text-navy/20" aria-hidden="true"></i>
                @endif
              </div>
              <div class="p-5">
                <h3 class="font-display font-bold text-navy group-hover:text-orange transition-colors">{{ $child->title }}</h3>
                @if ($child->intro)
                  <p class="mt-2 text-sm text-slate-600 line-clamp-2">{{ $child->intro }}</p>
                @endif
              </div>
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  <x-frontend.page-faqs
    :heading="$faqs['heading'] ?? 'คำถามเกี่ยวกับผลงาน'"
    :items="$faqs['items'] ?? []"
  />

  <section class="py-12 bg-navy">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
      <div>
        <p class="font-display font-bold text-white text-xl">มีเครื่องอาการคล้ายกัน?</p>
        <p class="mt-1 text-white/60 text-sm">ส่งรูปมาทางไลน์ เราดูให้ว่าซ่อมได้ไหมและประมาณเท่าไร</p>
      </div>
      <x-frontend.page-cta label="ส่งรูปมาประเมิน" />
    </div>
  </section>
@endsection

@push('jsonld')
  <x-schema-jsonld :graph="$schemaGraph" />
@endpush
