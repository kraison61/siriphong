@extends('layout.frontend')

@section('content')
  <section class="relative overflow-hidden bg-[linear-gradient(145deg,#0f2347_0%,#1a3a6b_55%,#0f2347_100%)] text-white">
    <div class="absolute inset-0 opacity-30 bg-[radial-gradient(ellipse_at_top_right,rgba(249,115,22,0.35),transparent_55%)]" aria-hidden="true"></div>
    <div class="relative w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8 py-14 md:py-20">
      <nav class="text-sm text-white/60 mb-6" aria-label="breadcrumb">
        <ol class="flex flex-wrap items-center gap-2">
          <li><a href="{{ route('home') }}" class="hover:text-orange transition-colors">หน้าแรก</a></li>
          <li aria-hidden="true">/</li>
          <li class="text-white/90">บทความ</li>
        </ol>
      </nav>
      <div class="font-display text-xs font-semibold tracking-[.14em] uppercase text-orange">Blog</div>
      <h1 class="font-display font-bold mt-2 text-[clamp(1.75rem,4vw,2.75rem)] leading-tight max-w-3xl">
        บทความซ่อมเครื่องดูดฝุ่น จากงานหน้างานจริง
      </h1>
      <p class="mt-4 max-w-2xl text-white/75 text-base md:text-lg leading-relaxed">
        เช็คอาการ ราคาถอดล้าง และวิธีดูแลเครื่อง — เรียบเรียงโดยช่างที่ซ่อมเอง ไม่ใช่บทความขายของทั่วไป
      </p>
    </div>
  </section>

  <section class="py-14 bg-offwhite">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
      @if ($blogs->isEmpty())
        <p class="text-slate-600 text-center py-16">ยังไม่มีบทความเผยแพร่</p>
      @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
          @foreach ($blogs as $item)
            <article class="group flex flex-col rounded-2xl bg-white border border-slate-200 overflow-hidden shadow-sm transition-all hover:border-orange/50 hover:-translate-y-0.5 hover:shadow-md">
              <a href="{{ route('blogs.show', $item->slug) }}" class="block aspect-[16/10] overflow-hidden bg-[linear-gradient(135deg,#0f2347,#2a5298)]">
                @if ($item->imageUrl())
                  <img
                    src="{{ $item->imageUrl() }}"
                    alt="{{ $item->image_alt ?: $item->title }}"
                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                    loading="lazy"
                    width="{{ $item->image_width ?: 640 }}"
                    height="{{ $item->image_height ?: 400 }}"
                  >
                @else
                  <div class="h-full w-full flex items-center justify-center text-white/40">
                    <i class="bi bi-journal-text text-4xl" aria-hidden="true"></i>
                  </div>
                @endif
              </a>
              <div class="flex flex-1 flex-col p-5 md:p-6">
                @if ($item->published_at)
                  <time datetime="{{ $item->datePublished() }}" class="text-xs font-medium text-slate-400">
                    {{ $item->published_at->timezone('Asia/Bangkok')->format('d/m/Y') }}
                  </time>
                @endif
                <h2 class="font-display font-bold text-navy mt-2 text-lg leading-snug">
                  <a href="{{ route('blogs.show', $item->slug) }}" class="hover:text-orange transition-colors">
                    {{ $item->title }}
                  </a>
                </h2>
                @if ($item->excerpt)
                  <p class="mt-2 text-sm text-slate-600 leading-relaxed line-clamp-3">{{ $item->excerpt }}</p>
                @endif
                <a href="{{ route('blogs.show', $item->slug) }}"
                  class="mt-auto pt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-orange hover:gap-2.5 transition-all">
                  อ่านต่อ <i class="bi bi-arrow-right" aria-hidden="true"></i>
                </a>
              </div>
            </article>
          @endforeach
        </div>

        <div class="mt-10">
          {{ $blogs->links() }}
        </div>
      @endif
    </div>
  </section>

  <section class="py-12 bg-navy text-white">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
      <div>
        <h2 class="font-display font-bold text-xl md:text-2xl">เครื่องมีอาการ? ประเมินฟรีทางไลน์</h2>
        <p class="mt-2 text-white/70 text-sm">ถ่ายรูปฟิลเตอร์กับถังฝุ่นส่งมาได้เลย ช่างแจ้งราคาก่อนซ่อม</p>
      </div>
      <x-frontend.page-cta />
    </div>
  </section>
@endsection

@push('jsonld')
  <x-schema-jsonld :graph="$schemaGraph" />
@endpush
