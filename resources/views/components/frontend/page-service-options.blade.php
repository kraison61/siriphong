@props([
  'heading' => 'ส่งเข้าร้าน หรือเรียกช่างไปหน้างาน',
  'dropOff' => [],
  'onsite' => [],
])

@php
  $dropOff = is_array($dropOff) ? $dropOff : [];
  $onsite = is_array($onsite) ? $onsite : [];
  $rows = [
    ['label' => 'ค่าบริการ', 'drop' => $dropOff['fee'] ?? '-', 'site' => $onsite['fee'] ?? '-'],
    ['label' => 'ใช้เวลา', 'drop' => $dropOff['time'] ?? '-', 'site' => $onsite['time'] ?? '-'],
    ['label' => 'เหมาะกับ', 'drop' => $dropOff['suitable'] ?? '-', 'site' => $onsite['suitable'] ?? '-'],
    ['label' => 'พื้นที่', 'drop' => $dropOff['area'] ?? 'ทุกจังหวัด (ส่งขนส่งได้)', 'site' => $onsite['area'] ?? 'กทม. และปริมณฑล'],
  ];
@endphp

<section class="py-14 bg-white" aria-labelledby="service-options-title">
  <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
    <div class="mb-8">
      <div class="font-display text-xs font-semibold tracking-[.14em] uppercase text-orange">เลือกทาง</div>
      <h2 id="service-options-title" class="font-display font-bold text-navy mt-2 text-[clamp(1.4rem,3.5vw,2rem)]">
        {{ $heading }}
      </h2>
    </div>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-sm">
      <table class="w-full min-w-[560px] text-left text-sm">
        <thead class="bg-navy text-white">
          <tr>
            <th class="px-5 py-4 font-semibold w-[22%]"></th>
            <th class="px-5 py-4 font-semibold">
              <i class="bi bi-box-seam me-1.5" aria-hidden="true"></i> ส่งเข้าร้าน
            </th>
            <th class="px-5 py-4 font-semibold">
              <i class="bi bi-truck me-1.5" aria-hidden="true"></i> ช่างไปหน้างาน
            </th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 bg-white">
          @foreach ($rows as $row)
            <tr class="align-top">
              <th scope="row" class="px-5 py-4 font-semibold text-navy bg-offwhite/60">{{ $row['label'] }}</th>
              <td class="px-5 py-4 text-slate-700 leading-relaxed">{{ $row['drop'] }}</td>
              <td class="px-5 py-4 text-slate-700 leading-relaxed">{{ $row['site'] }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-6">
      <x-frontend.page-cta label="สอบถามว่าควรส่งหรือเรียกช่าง" />
    </div>
  </div>
</section>
