@extends('layout.frontend')

@section('content')
  @php
    $publishedLabel = $blog->published_at?->timezone('Asia/Bangkok')->format('d/m/Y');
    $modifiedLabel = ($blog->content_updated_at ?: $blog->published_at)?->timezone('Asia/Bangkok')->format('d/m/Y');
    $faqItems = $blog->faqItems();
  @endphp

  <article>
    <header class="relative overflow-hidden bg-[linear-gradient(145deg,#0f2347_0%,#1a3a6b_55%,#0f2347_100%)] text-white">
      <div class="absolute inset-0 opacity-25 bg-[radial-gradient(ellipse_at_bottom_left,rgba(249,115,22,0.3),transparent_50%)]" aria-hidden="true"></div>
      <div class="relative w-full max-w-[800px] mx-auto px-4 md:px-6 xl:px-8 py-12 md:py-16">
        <nav class="text-sm text-white/60 mb-6" aria-label="breadcrumb">
          <ol class="flex flex-wrap items-center gap-2">
            <li><a href="{{ route('home') }}" class="hover:text-orange transition-colors">หน้าแรก</a></li>
            <li aria-hidden="true">/</li>
            <li><a href="{{ route('blogs.index') }}" class="hover:text-orange transition-colors">บทความ</a></li>
            <li aria-hidden="true">/</li>
            <li class="text-white/90 line-clamp-1">{{ $blog->title }}</li>
          </ol>
        </nav>

        <div class="font-display text-xs font-semibold tracking-[.14em] uppercase text-orange">บทความ</div>
        <h1 class="font-display font-bold mt-3 text-[clamp(1.5rem,3.8vw,2.35rem)] leading-tight">
          {{ $blog->title }}
        </h1>

        <p class="mt-5 text-sm text-white/70 leading-relaxed">
          เขียนโดย {{ $blog->authorName() }}
          @if ($blog->authorJobTitle())
            · {{ $blog->authorJobTitle() }}
          @endif
          @if ($publishedLabel)
            · เผยแพร่ <time datetime="{{ $blog->datePublished() }}">{{ $publishedLabel }}</time>
          @endif
          @if ($modifiedLabel)
            · อัปเดตล่าสุด <time datetime="{{ $blog->dateModified() }}">{{ $modifiedLabel }}</time>
          @endif
        </p>
      </div>
    </header>

    @if ($blog->imageUrl())
      <div class="w-full max-w-[960px] mx-auto px-4 md:px-6 xl:px-8 -mt-2 md:-mt-4">
        <figure class="overflow-hidden rounded-2xl border border-slate-200 shadow-sm bg-slate-100">
          <img
            src="{{ $blog->imageUrl() }}"
            alt="{{ $blog->image_alt ?: $blog->title }}"
            class="w-full max-h-[480px] object-cover"
            width="{{ $blog->image_width ?: 1200 }}"
            height="{{ $blog->image_height ?: 675 }}"
          >
        </figure>
      </div>
    @endif

    <div class="py-12 md:py-14 bg-white">
      <div class="w-full max-w-[720px] mx-auto px-4 md:px-6 xl:px-8">
        @if ($blog->excerpt)
          <p class="text-lg text-slate-700 leading-relaxed mb-8 border-l-4 border-orange pl-4">
            {{ $blog->excerpt }}
          </p>
        @endif

        <div class="blog-prose text-slate-700 leading-relaxed space-y-4
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
          {!! $blog->body !!}
        </div>

        @if ($blog->relatedPortfolio && $blog->relatedPortfolio->urlPath())
          <aside class="mt-10 rounded-2xl border border-orange/30 bg-orange/5 p-5 md:p-6">
            <div class="font-display text-xs font-semibold tracking-[.14em] uppercase text-orange">เคสจริงที่เกี่ยวข้อง</div>
            <p class="mt-2 font-display font-bold text-navy text-lg leading-snug">
              {{ $blog->relatedPortfolio->title }}
            </p>
            <a href="{{ url($blog->relatedPortfolio->urlPath()) }}"
              class="mt-3 inline-flex items-center gap-1.5 text-sm font-semibold text-orange hover:gap-2.5 transition-all">
              ดูรายละเอียดเคสซ่อม <i class="bi bi-arrow-right" aria-hidden="true"></i>
            </a>
          </aside>
        @endif
      </div>
    </div>

    <x-frontend.page-faqs
      heading="คำถามที่พบบ่อย"
      :items="$faqItems->map(fn ($f) => ['question' => $f->question, 'answer' => $f->answer])->all()"
    />

    @if ($related->isNotEmpty())
      <section class="py-14 bg-white border-t border-slate-100">
        <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
          <h2 class="font-display font-bold text-navy text-[clamp(1.3rem,3vw,1.75rem)] mb-8">บทความอื่นที่น่าสนใจ</h2>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach ($related as $item)
              <a href="{{ route('blogs.show', $item->slug) }}"
                class="rounded-xl border border-slate-200 bg-offwhite/50 p-5 transition-all hover:border-orange hover:-translate-y-0.5">
                <h3 class="font-display font-bold text-navy leading-snug">{{ $item->title }}</h3>
                @if ($item->excerpt)
                  <p class="mt-2 text-sm text-slate-600 line-clamp-2">{{ $item->excerpt }}</p>
                @endif
              </a>
            @endforeach
          </div>
        </div>
      </section>
    @endif

    <section class="py-12 bg-navy text-white">
      <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div>
          <h2 class="font-display font-bold text-xl md:text-2xl">ต้องการให้ช่างประเมินอาการ?</h2>
          <p class="mt-2 text-white/70 text-sm">ทักไลน์ส่งรูปได้เลย ประเมินฟรี แจ้งราคาก่อนซ่อมทุกครั้ง</p>
        </div>
        <x-frontend.page-cta />
      </div>
    </section>
  </article>
@endsection

@push('jsonld')
  <x-schema-jsonld :graph="$schemaGraph" />
@endpush
