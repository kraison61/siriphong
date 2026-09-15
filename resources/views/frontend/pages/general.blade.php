@extends('layout.frontend')

@section('content')
  <x-frontend.page-hero :page="$page" />

  @php
    $body = $page->block('body', '');
    $bridges = $page->block('bridge_sections', []);
    $faqs = $page->block('faqs', []);
  @endphp

  @if ($body)
    <section class="py-14 bg-white">
      <div class="w-full max-w-[720px] mx-auto px-4 md:px-6 xl:px-8 prose prose-slate max-w-none">
        <div class="text-slate-700 leading-relaxed whitespace-pre-line text-base md:text-lg">{{ $body }}</div>
      </div>
    </section>
  @endif

  @if ($children->isNotEmpty())
    <section class="py-14 bg-offwhite">
      <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
        <h2 class="font-display font-bold text-navy text-[clamp(1.4rem,3.5vw,2rem)] mb-8">หน้าที่เกี่ยวข้อง</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @foreach ($children as $child)
            <a href="{{ url($child->urlPath()) }}"
              class="rounded-2xl bg-white border border-slate-200 p-6 shadow-sm transition-all hover:border-orange hover:-translate-y-0.5">
              <h3 class="font-display font-bold text-navy">{{ $child->title }}</h3>
              @if ($child->intro)
                <p class="mt-2 text-sm text-slate-600 line-clamp-2">{{ $child->intro }}</p>
              @endif
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  @foreach ((is_array($bridges) ? $bridges : []) as $bridge)
    <x-frontend.page-bridge
      :heading="$bridge['heading'] ?? null"
      :body="$bridge['body'] ?? null"
      :cta-label="$bridge['cta_label'] ?? null"
      :cta-url="$bridge['cta_url'] ?? null"
      :tone="$bridge['tone'] ?? 'default'"
    />
  @endforeach

  <x-frontend.page-faqs
    :heading="$faqs['heading'] ?? 'คำถามที่พบบ่อย'"
    :items="$faqs['items'] ?? []"
  />
@endsection

@push('jsonld')
  <x-schema-jsonld :graph="$schemaGraph" />
@endpush
