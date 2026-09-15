@extends('layout.frontend')

@section('content')
  @php
    $beforeUrl = $portfolio->beforeImageUrl();
    $afterUrl = $portfolio->afterImageUrl();
    $hasBeforeAfter = filled($beforeUrl) && filled($afterUrl);
    $singleImageUrl = $hasBeforeAfter ? null : ($afterUrl ?: $portfolio->imageUrl());
  @endphp

  <article>
    <header class="relative overflow-hidden bg-[linear-gradient(145deg,#0f2347_0%,#1a3a6b_55%,#0f2347_100%)] text-white">
      <div class="absolute inset-0 opacity-25 bg-[radial-gradient(ellipse_at_top_right,rgba(249,115,22,0.28),transparent_50%)]" aria-hidden="true"></div>
      <div class="relative w-full max-w-[800px] mx-auto px-4 md:px-6 xl:px-8 py-12 md:py-16">
        <nav class="text-sm text-white/60 mb-6" aria-label="breadcrumb">
          <ol class="flex flex-wrap items-center gap-2">
            <li><a href="{{ route('home') }}" class="hover:text-orange transition-colors">หน้าแรก</a></li>
            <li aria-hidden="true">/</li>
            <li><a href="{{ route('pages.show', 'portfolio') }}" class="hover:text-orange transition-colors">ผลงาน</a></li>
            <li aria-hidden="true">/</li>
            <li class="text-white/90 line-clamp-1">{{ $portfolio->title }}</li>
          </ol>
        </nav>

        <div class="font-display text-xs font-semibold tracking-[.14em] uppercase text-orange">
          {{ $portfolio->categoryName() ?: 'เคสซ่อม' }}
          @if (filled($portfolio->category_label) && $portfolio->category_label !== $portfolio->categoryName())
            <span class="font-medium text-white/50 normal-case tracking-normal">· {{ $portfolio->category_label }}</span>
          @endif
        </div>
        <h1 class="font-display font-bold mt-3 text-[clamp(1.45rem,3.6vw,2.2rem)] leading-tight">
          {{ $portfolio->title }}
        </h1>
        @if ($portfolio->description)
          <p class="mt-5 text-white/75 leading-relaxed whitespace-pre-line">{{ \Illuminate\Support\Str::limit($portfolio->description, 280) }}</p>
        @endif
      </div>
    </header>

    <div class="py-12 md:py-14 bg-white">
      <div class="w-full max-w-[800px] mx-auto px-4 md:px-6 xl:px-8">
        @if ($hasBeforeAfter)
          <div class="mb-10 grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
            <figure class="relative aspect-[4/3] overflow-hidden rounded-2xl border border-slate-200 bg-slate-100 flex items-center justify-center px-4">
              <img src="{{ $beforeUrl }}" alt="ก่อนซ่อม — {{ $portfolio->title }}" class="max-h-full max-w-full w-auto h-auto object-contain object-center" loading="lazy">
              <figcaption class="absolute left-3 bottom-3 text-[11px] font-bold uppercase tracking-wide bg-navy/85 text-white px-2.5 py-1 rounded">ก่อนซ่อม</figcaption>
            </figure>
            <figure class="relative aspect-[4/3] overflow-hidden rounded-2xl border border-slate-200 bg-slate-100 flex items-center justify-center px-4">
              <img src="{{ $afterUrl }}" alt="หลังซ่อม — {{ $portfolio->title }}" class="max-h-full max-w-full w-auto h-auto object-contain object-center" loading="lazy">
              <figcaption class="absolute left-3 bottom-3 text-[11px] font-bold uppercase tracking-wide bg-orange/90 text-white px-2.5 py-1 rounded">หลังซ่อม</figcaption>
            </figure>
          </div>
        @elseif ($singleImageUrl)
          <figure class="mb-10 aspect-video max-h-[420px] overflow-hidden rounded-2xl border border-slate-200 bg-slate-100 flex items-center justify-center px-4 sm:px-6">
            <img src="{{ $singleImageUrl }}" alt="{{ $portfolio->title }}" class="max-h-full max-w-full w-auto h-auto object-contain object-center" loading="lazy">
          </figure>
        @endif

        <h2 class="font-display font-bold text-navy text-xl mb-4">สรุปงาน</h2>
        <div class="overflow-hidden rounded-2xl border border-slate-200 mb-10">
          <table class="w-full text-sm text-left">
            <tbody class="divide-y divide-slate-100">
              @foreach ([
                'หมวด' => $portfolio->categoryName() ?: $portfolio->category_label,
                'อาการที่ลูกค้าแจ้ง' => $portfolio->symptom,
                'สาเหตุที่พบจริง' => $portfolio->found,
                'วิธีแก้ไข' => $portfolio->fixed,
                'อาการเสีย (สรุป)' => $portfolio->fault,
                'แบรนด์/รุ่น' => $portfolio->brands,
                'ค่าบริการ' => $portfolio->price,
                'ระยะเวลา' => $portfolio->duration,
                'ปี' => $portfolio->year,
                'สถานะ' => $portfolio->status_label,
              ] as $label => $value)
                @if (filled($value))
                  <tr>
                    <th class="w-[38%] px-4 py-3.5 font-semibold text-navy bg-offwhite/70 align-top">{{ $label }}</th>
                    <td class="px-4 py-3.5 text-slate-700 leading-relaxed whitespace-pre-line">{{ $value }}</td>
                  </tr>
                @endif
              @endforeach
            </tbody>
          </table>
        </div>

        @if (filled($portfolio->content))
          <h2 class="font-display font-bold text-navy text-xl mb-4">รายละเอียดเคส</h2>
          <div class="portfolio-prose text-slate-700 leading-relaxed space-y-4 mb-10
            [&_h2]:font-display [&_h2]:font-bold [&_h2]:text-navy [&_h2]:text-[clamp(1.25rem,3vw,1.65rem)] [&_h2]:mt-10 [&_h2]:mb-3
            [&_h3]:font-display [&_h3]:font-bold [&_h3]:text-navy [&_h3]:text-lg [&_h3]:mt-6 [&_h3]:mb-2
            [&_p]:text-base [&_p]:md:text-[1.05rem] [&_p]:leading-relaxed
            [&_ul]:list-disc [&_ul]:pl-5 [&_ul]:space-y-2
            [&_ol]:list-decimal [&_ol]:pl-5 [&_ol]:space-y-3
            [&_li]:leading-relaxed
            [&_strong]:text-navy [&_strong]:font-semibold
            [&_a]:text-orange [&_a]:font-semibold [&_a]:underline-offset-2 hover:[&_a]:underline
            [&_table]:w-full [&_table]:text-sm [&_table]:border [&_table]:border-slate-200 [&_table]:rounded-xl [&_table]:overflow-hidden
            [&_thead]:bg-navy [&_thead]:text-white
            [&_th]:px-4 [&_th]:py-3 [&_th]:text-left [&_th]:font-semibold
            [&_td]:px-4 [&_td]:py-3 [&_td]:border-t [&_td]:border-slate-100
            [&_tbody_tr:nth-child(even)]:bg-offwhite/60">
            {!! $portfolio->content !!}
          </div>
        @elseif ($portfolio->description && \Illuminate\Support\Str::length($portfolio->description) > 280)
          <h2 class="font-display font-bold text-navy text-xl mb-4">รายละเอียดเพิ่มเติม</h2>
          <div class="text-slate-700 leading-relaxed whitespace-pre-line mb-10">{{ $portfolio->description }}</div>
        @endif

        @if ($portfolio->relatedBlog)
          <aside class="rounded-2xl border border-navy/15 bg-offwhite p-5 md:p-6 mb-8">
            <div class="font-display text-xs font-semibold tracking-[.14em] uppercase text-orange">อ่านต่อ</div>
            <p class="mt-2 font-display font-bold text-navy leading-snug">
              {{ $portfolio->relatedBlog->title }}
            </p>
            <a href="{{ route('blogs.show', $portfolio->relatedBlog->slug) }}"
              class="mt-3 inline-flex items-center gap-1.5 text-sm font-semibold text-orange hover:gap-2.5 transition-all">
              ไปบทความอธิบายอาการและวิธีเช็คเอง <i class="bi bi-arrow-right" aria-hidden="true"></i>
            </a>
          </aside>
        @endif

        <div class="flex flex-wrap gap-3 pt-2">
          <a href="{{ route('pages.show', 'portfolio') }}"
            class="inline-flex items-center gap-2 min-h-[44px] px-5 rounded-xl text-sm font-semibold text-navy border border-navy/20 hover:border-orange hover:text-orange transition-colors">
            ← กลับไปหน้าผลงานทั้งหมด
          </a>
        </div>
      </div>
    </div>

    <section class="py-12 bg-navy text-white">
      <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div>
          <h2 class="font-display font-bold text-xl md:text-2xl">มีเคสคล้ายกัน? ทักไลน์ได้เลย</h2>
          <p class="mt-2 text-white/70 text-sm">โทร {{ config('data.phone_formatted') }} | LINE ประเมินอาการฟรี</p>
        </div>
        <x-frontend.page-cta />
      </div>
    </section>
  </article>
@endsection

@push('jsonld')
  <x-schema-jsonld :graph="$schemaGraph" />
@endpush
