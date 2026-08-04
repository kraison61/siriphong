@extends('layout.frontend')

@section('content')
  <section class="py-12 md:py-16 bg-[linear-gradient(160deg,#0f2347_0%,#1a3a6b_55%,#1e4a8a_100%)]">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
      <nav class="mb-4 text-sm text-white/50" aria-label="breadcrumb">
        <ol class="flex flex-wrap items-center gap-1.5 list-none">
          <li><a href="{{ route('home') }}" class="hover:text-orange">หน้าแรก</a></li>
          <li><i class="bi bi-chevron-right text-[.65rem]" aria-hidden="true"></i></li>
          <li><a href="{{ route('products.index') }}#services" class="hover:text-orange">บริการ</a></li>
          @if ($service->category)
            <li><i class="bi bi-chevron-right text-[.65rem]" aria-hidden="true"></i></li>
            <li class="text-white/60">{{ $service->category->name }}</li>
          @endif
          <li><i class="bi bi-chevron-right text-[.65rem]" aria-hidden="true"></i></li>
          <li class="text-white/80">{{ $service->name }}</li>
        </ol>
      </nav>

      <h1 class="font-display font-bold text-white text-[clamp(1.8rem,5vw,2.8rem)]">{{ $service->name }}</h1>
      <p class="mt-3 max-w-2xl text-white/70">{{ $service->short_description }}</p>
    </div>
  </section>

  <section class="py-14 bg-white">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
        <div class="rounded-2xl bg-offwhite aspect-video flex items-center justify-center overflow-hidden">
          @if ($service->imageUrl())
            <img src="{{ $service->imageUrl() }}" alt="{{ $service->name }}" class="max-h-full max-w-full object-contain p-6">
          @else
            <i class="{{ $service->iconClass() }} text-8xl text-navy/20" aria-hidden="true"></i>
          @endif
        </div>

        <div>
          <p class="text-slate-600 leading-relaxed mb-6">{{ $service->description ?: $service->short_description }}</p>
          <div class="mb-6 font-display text-2xl font-bold text-orange">{{ $service->priceLabel() }}</div>
          <a href="{{ config('data.line') }}" target="_blank" rel="noopener"
            class="inline-flex items-center justify-center gap-2 min-h-[52px] px-7 py-3 rounded-xl font-bold text-white bg-line">
            <i class="bi bi-chat-dots-fill" aria-hidden="true"></i> นัดหมาย / สอบถาม
          </a>
        </div>
      </div>
    </div>
  </section>

  @if ($faqs->isNotEmpty())
    <x-frontend.faq-list :faqs="$faqs" />
  @endif
@endsection

@push('jsonld')
  <x-schema-jsonld :graph="$schemaGraph" />
@endpush
