@extends('layout.frontend')

@section('content')
  <section class="py-12 md:py-16 bg-[linear-gradient(160deg,#0f2347_0%,#1a3a6b_55%,#1e4a8a_100%)]">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
      <nav class="mb-4 text-sm text-white/50" aria-label="breadcrumb">
        <ol class="flex flex-wrap items-center gap-1.5 list-none">
          <li><a href="{{ route('home') }}" class="hover:text-orange">หน้าแรก</a></li>
          <li><i class="bi bi-chevron-right text-[.65rem]" aria-hidden="true"></i></li>
          <li><a href="{{ route('products.index') }}" class="hover:text-orange">สินค้าและบริการ</a></li>
          <li><i class="bi bi-chevron-right text-[.65rem]" aria-hidden="true"></i></li>
          <li class="text-white/80">{{ $category->name }}</li>
        </ol>
      </nav>

      <h1 class="font-display font-bold text-white text-[clamp(1.8rem,5vw,2.8rem)]">{{ $category->name }}</h1>
    </div>
  </section>

  <section class="py-14 bg-white">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse ($items as $item)
          <article class="rounded-[20px] bg-offwhite p-5 shadow-sm">
            <h2 class="font-display font-bold text-navy mb-2">
              <a href="{{ $item->type === 'service' ? route('services.show', $item->slug) : route('products.show', $item->slug) }}" class="hover:text-orange">
                {{ $item->name }}
              </a>
            </h2>
            <p class="text-sm text-slate-600 line-clamp-3">{{ $item->short_description }}</p>
          </article>
        @empty
          <p class="col-span-full text-center text-slate-500 py-10">ยังไม่มีรายการในหมวดนี้</p>
        @endforelse
      </div>
    </div>
  </section>
@endsection

@push('jsonld')
  <x-schema-jsonld :graph="$schemaGraph" />
@endpush
