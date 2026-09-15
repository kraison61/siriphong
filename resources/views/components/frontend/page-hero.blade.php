@props([
    'page',
])

<section class="py-12 md:py-16 bg-[linear-gradient(160deg,#0f2347_0%,#1a3a6b_55%,#1e4a8a_100%)]">
  <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
    <nav class="mb-4 text-sm text-white/50" aria-label="breadcrumb">
      <ol class="flex flex-wrap items-center gap-1.5 list-none">
        <li><a href="{{ route('home') }}" class="hover:text-orange">หน้าแรก</a></li>
        @if ($page->parent)
          <li><i class="bi bi-chevron-right text-[.65rem]" aria-hidden="true"></i></li>
          <li><a href="{{ url($page->parent->urlPath()) }}" class="hover:text-orange">{{ $page->parent->title }}</a></li>
        @endif
        <li><i class="bi bi-chevron-right text-[.65rem]" aria-hidden="true"></i></li>
        <li class="text-white/80">{{ $page->title }}</li>
      </ol>
    </nav>

    @if ($page->primary_keyword)
      <p class="font-display text-xs font-semibold tracking-[.14em] uppercase text-orange mb-3">
        {{ $page->primary_keyword }}
      </p>
    @endif

    <h1 class="font-display font-bold text-white text-[clamp(1.8rem,5vw,2.8rem)] leading-tight max-w-3xl">
      {{ $page->title }}
    </h1>

    @if ($page->intro)
      <p class="mt-4 max-w-2xl text-white/80 text-base md:text-lg leading-relaxed whitespace-pre-line">{{ $page->intro }}</p>
    @endif

    <div class="mt-7 flex flex-wrap gap-3">
      <a href="{{ config('data.line') }}" target="_blank" rel="noopener"
        class="inline-flex items-center justify-center gap-2 min-h-[52px] px-7 py-3 rounded-xl font-bold text-white bg-line shadow-[0_4px_16px_rgba(6,199,85,.35)] transition-all hover:bg-line-dark hover:-translate-y-0.5">
        <i class="bi bi-chat-dots-fill" aria-hidden="true"></i> แอดไลน์สอบถาม
      </a>
      <a href="tel:{{ config('data.phone') }}"
        class="inline-flex items-center justify-center gap-2 min-h-[52px] px-7 py-3 rounded-xl font-bold text-white border border-white/30 bg-white/10 transition-all hover:bg-white/20">
        <i class="bi bi-telephone-fill" aria-hidden="true"></i> {{ config('data.phone_formatted') }}
      </a>
    </div>

    @if ($page->content_updated_at)
      <p class="mt-5 text-xs text-white/40">อัปเดตเนื้อหา {{ $page->content_updated_at->timezone('Asia/Bangkok')->format('d/m/Y') }}</p>
    @endif
  </div>
</section>
