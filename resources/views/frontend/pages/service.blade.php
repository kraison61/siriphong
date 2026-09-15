@extends('layout.frontend')

@section('content')
  <x-frontend.page-hero :page="$page" />

  <x-frontend.page-silo-nav :children="$children" />

  @php
    $symptoms = $page->block('symptoms', []);
    $options = $page->block('service_options', []);
    $bridges = $page->block('bridge_sections', []);
    $prices = $page->block('price_table', []);
    $filter = $page->block('machine_filter', []);
    $cases = $page->block('cases', []);
    $faqs = $page->block('faqs', []);
    $compare = $page->block('compare_table', []);
  @endphp

  <x-frontend.page-symptoms
    :heading="$symptoms['heading'] ?? 'อาการที่เจอบ่อย และแปลว่าอะไร'"
    :items="$symptoms['items'] ?? []"
  />

  @if (!empty($options['drop_off']) || !empty($options['onsite']))
    <x-frontend.page-service-options
      :heading="$options['heading'] ?? 'ส่งเข้าร้าน หรือให้ช่างไปหาที่ร้าน'"
      :drop-off="$options['drop_off'] ?? []"
      :onsite="$options['onsite'] ?? []"
    />
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

  @if (!empty($compare['rows']))
    <section class="py-14 bg-white" aria-labelledby="compare-title">
      <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
        <div class="mb-8 max-w-2xl">
          <div class="font-display text-xs font-semibold tracking-[.14em] uppercase text-orange">เปรียบเทียบ</div>
          <h2 id="compare-title" class="font-display font-bold text-navy mt-2 text-[clamp(1.4rem,3.5vw,2rem)]">
            {{ $compare['heading'] ?? 'เปรียบเทียบทางเลือก' }}
          </h2>
        </div>
        <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-sm">
          <table class="w-full min-w-[560px] text-left text-sm">
            <thead class="bg-navy text-white">
              <tr>
                @foreach ($compare['columns'] ?? ['หัวข้อ', 'ทางเลือก A', 'ทางเลือก B'] as $col)
                  <th class="px-5 py-4 font-semibold">{{ $col }}</th>
                @endforeach
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              @foreach ($compare['rows'] as $row)
                <tr class="align-top">
                  @foreach ($row as $cell)
                    <td class="px-5 py-4 text-slate-700 leading-relaxed {{ $loop->first ? 'font-semibold text-navy bg-offwhite/60' : '' }}">
                      {{ $cell }}
                    </td>
                  @endforeach
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </section>
  @endif

  <x-frontend.page-price-table
    :heading="$prices['heading'] ?? 'ค่าซ่อมประมาณเท่าไร'"
    :intro="$prices['intro'] ?? null"
    :rows="$prices['rows'] ?? []"
    :note="$prices['note'] ?? null"
  />

  <x-frontend.page-machine-filter
    :heading="$filter['heading'] ?? 'เราไม่รับเครื่องแบบไหน'"
    :accept="$filter['accept'] ?? null"
    :reject="$filter['reject'] ?? null"
  />

  <x-frontend.page-cases
    :heading="$cases['heading'] ?? 'ตัวอย่างงานที่ซ่อมไปแล้ว'"
    :items="$cases['items'] ?? []"
  />

  <x-frontend.page-faqs
    :heading="$faqs['heading'] ?? 'คำถามที่พบบ่อย'"
    :items="$faqs['items'] ?? []"
  />

  <section class="py-12 bg-navy">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
      <div>
        <p class="font-display font-bold text-white text-xl">เครื่องพังอยู่ตอนนี้? ทักมาเลย</p>
        <p class="mt-1 text-white/60 text-sm">ส่งรูปเครื่อง + อาการมาทางไลน์ ประเมินเบื้องต้นให้ฟรี</p>
      </div>
      <x-frontend.page-cta label="แอดไลน์เลย" />
    </div>
  </section>
@endsection

@push('jsonld')
  <x-schema-jsonld :graph="$schemaGraph" />
@endpush
