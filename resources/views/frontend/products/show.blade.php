@extends('layout.frontend')

@section('content')
  <section class="py-12 md:py-16 bg-[linear-gradient(160deg,#0f2347_0%,#1a3a6b_55%,#1e4a8a_100%)]">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
      <nav class="mb-4 text-sm text-white/50" aria-label="breadcrumb">
        <ol class="flex flex-wrap items-center gap-1.5 list-none">
          <li><a href="{{ route('home') }}" class="hover:text-orange">หน้าแรก</a></li>
          <li><i class="bi bi-chevron-right text-[.65rem]" aria-hidden="true"></i></li>
          <li><a href="{{ route('products.index') }}" class="hover:text-orange">สินค้าและบริการ</a></li>
          @if ($product->category)
            <li><i class="bi bi-chevron-right text-[.65rem]" aria-hidden="true"></i></li>
            <li><a href="{{ route('products.category', $product->category->slug) }}" class="hover:text-orange">{{ $product->category->name }}</a></li>
          @endif
          <li><i class="bi bi-chevron-right text-[.65rem]" aria-hidden="true"></i></li>
          <li class="text-white/80">{{ $product->name }}</li>
        </ol>
      </nav>

      <h1 class="font-display font-bold text-white text-[clamp(1.8rem,5vw,2.8rem)]">{{ $product->name }}</h1>
      @if ($product->brand)
        <p class="mt-2 text-white/70">แบรนด์ {{ $product->brand }}</p>
      @endif
    </div>
  </section>

  <section class="py-14 bg-white">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <div class="rounded-2xl bg-offwhite aspect-square flex items-center justify-center overflow-hidden">
          @if ($product->imageUrl())
            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="max-h-full max-w-full object-contain p-6">
          @else
            <i class="{{ $product->iconClass() }} text-8xl text-navy/20" aria-hidden="true"></i>
          @endif
        </div>

        <div>
          <p class="text-slate-600 leading-relaxed mb-6">{{ $product->short_description }}</p>

          @if (is_array($product->specs) && count($product->specs))
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
              @foreach ($product->specs as $spec)
                <div class="rounded-lg bg-offwhite px-4 py-3">
                  <dt class="text-xs text-slate-500">{{ $spec['name'] ?? '' }}</dt>
                  <dd class="font-semibold text-navy">
                    {{ $spec['value'] ?? '' }}@if (! empty($spec['unitText'])) {{ $spec['unitText'] }}@endif
                  </dd>
                </div>
              @endforeach
            </dl>
          @endif

          <div class="mb-6">
            @if ($product->sale_price !== null)
              <span class="block text-navy/40 line-through">฿{{ number_format((float) $product->price, 0) }}</span>
              <span class="font-display text-3xl font-bold text-orange">฿{{ number_format((float) $product->sale_price, 0) }}</span>
            @elseif ((float) $product->price > 0)
              <span class="font-display text-3xl font-bold text-orange">฿{{ number_format((float) $product->price, 0) }}</span>
            @else
              <span class="font-display text-2xl font-bold text-orange">ติดต่อขอราคา</span>
            @endif
          </div>

          <a href="{{ config('data.line') }}" target="_blank" rel="noopener"
            class="inline-flex items-center justify-center gap-2 min-h-[52px] px-7 py-3 rounded-xl font-bold text-white bg-line">
            <i class="bi bi-chat-dots-fill" aria-hidden="true"></i> สอบถาม / สั่งซื้อ
          </a>
        </div>
      </div>

      @if ($product->description)
        <div class="mt-12 prose max-w-none text-slate-600 leading-relaxed">
          {!! nl2br(e($product->description)) !!}
        </div>
      @endif

      @if ($reviews->isNotEmpty())
        <div class="mt-12">
          <h2 class="font-display font-bold text-navy text-2xl mb-6">รีวิวจากลูกค้า</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($reviews as $review)
              <blockquote class="rounded-xl p-5 bg-offwhite border-l-4 border-orange">
                <div class="text-[#f4b400] text-sm mb-2" aria-label="คะแนน {{ $review->rating }} ดาว">
                  @for ($i = 0; $i < $review->rating; $i++) ★ @endfor
                </div>
                <p class="text-sm text-slate-700 leading-relaxed mb-3">{{ $review->comment }}</p>
                <footer class="text-sm font-semibold text-navy">{{ $review->reviewer_name }}</footer>
              </blockquote>
            @endforeach
          </div>
        </div>
      @endif
    </div>
  </section>

  @if ($faqs->isNotEmpty())
    <x-frontend.faq-list :faqs="$faqs" />
  @endif
@endsection

@push('jsonld')
  <x-schema-jsonld :graph="$schemaGraph" />
@endpush
