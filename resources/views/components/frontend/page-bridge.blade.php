@props([
  'heading' => null,
  'body' => null,
  'ctaLabel' => null,
  'ctaUrl' => null,
  'tone' => 'default', // default | accent
])

@if ($heading || $body)
@php
  $bg = $tone === 'accent'
    ? 'bg-[linear-gradient(135deg,#0f2347_0%,#1a3a6b_100%)] text-white'
    : 'bg-offwhite text-navy';
  $bodyClass = $tone === 'accent' ? 'text-white/80' : 'text-slate-600';
@endphp
<section class="py-14 {{ $tone === 'accent' ? '' : 'bg-white' }}">
  <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
    <div class="rounded-2xl {{ $bg }} p-7 md:p-10">
      @if ($heading)
        <h2 class="font-display font-bold text-[clamp(1.3rem,3vw,1.85rem)] leading-tight max-w-2xl">
          {{ $heading }}
        </h2>
      @endif
      @if ($body)
        <p class="mt-4 max-w-2xl leading-relaxed {{ $bodyClass }} whitespace-pre-line">{{ $body }}</p>
      @endif
      @if ($ctaLabel && $ctaUrl)
        <div class="mt-6">
          <a href="{{ $ctaUrl }}"
            class="inline-flex items-center gap-2 min-h-[48px] px-6 py-2.5 rounded-xl font-bold {{ $tone === 'accent' ? 'bg-orange text-white hover:brightness-110' : 'bg-navy text-white hover:bg-navy-mid' }} transition-all">
            {{ $ctaLabel }} <i class="bi bi-arrow-right" aria-hidden="true"></i>
          </a>
        </div>
      @elseif ($ctaLabel)
        <div class="mt-6">
          <x-frontend.page-cta :label="$ctaLabel" />
        </div>
      @endif
    </div>
  </div>
</section>
@endif
