@props([
  'heading' => 'ค่าซ่อมประมาณเท่าไร',
  'intro' => null,
  'rows' => [],
  'note' => null,
])

@php $rows = is_array($rows) ? $rows : []; @endphp

@if (count($rows) > 0)
<section class="py-14 bg-white" aria-labelledby="price-table-title">
  <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
    <div class="mb-8 max-w-2xl">
      <div class="font-display text-xs font-semibold tracking-[.14em] uppercase text-orange">ช่วงราคา</div>
      <h2 id="price-table-title" class="font-display font-bold text-navy mt-2 text-[clamp(1.4rem,3.5vw,2rem)]">
        {{ $heading }}
      </h2>
      @if ($intro)
        <p class="mt-3 text-slate-600 leading-relaxed">{{ $intro }}</p>
      @endif
    </div>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-sm">
      <table class="w-full min-w-[640px] text-left text-sm">
        <thead class="bg-navy text-white">
          <tr>
            <th class="px-5 py-4 font-semibold">อาการ</th>
            <th class="px-5 py-4 font-semibold">สิ่งที่ต้องทำ</th>
            <th class="px-5 py-4 font-semibold">ช่วงราคา</th>
            <th class="px-5 py-4 font-semibold">ระยะเวลา</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @foreach ($rows as $row)
            <tr class="align-top hover:bg-offwhite/50">
              <td class="px-5 py-4 font-medium text-navy">{{ $row['symptom'] ?? '-' }}</td>
              <td class="px-5 py-4 text-slate-700">{{ $row['action'] ?? '-' }}</td>
              <td class="px-5 py-4 font-display font-bold text-orange whitespace-nowrap">{{ $row['price'] ?? '-' }}</td>
              <td class="px-5 py-4 text-slate-600 whitespace-nowrap">{{ $row['duration'] ?? '-' }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    @if ($note)
      <p class="mt-4 text-sm text-slate-500 leading-relaxed">{{ $note }}</p>
    @endif

    <div class="mt-6">
      <x-frontend.page-cta label="ส่งรูปเครื่องมาประเมินราคา" />
    </div>
  </div>
</section>
@endif
