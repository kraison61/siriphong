@extends('layout.frontend')

@section('content')
  @php
    $descriptionHtml = null;
    if (filled($product->description)) {
        $sections = preg_split("/\n{2,}/", trim($product->description)) ?: [];
        $blocks = [];

        foreach ($sections as $section) {
            $lines = preg_split("/\n/", trim($section)) ?: [];
            if ($lines === []) {
                continue;
            }

            $heading = array_shift($lines);
            $items = [];
            $paragraphs = [];

            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '') {
                    continue;
                }

                if (str_starts_with($line, '•') || str_starts_with($line, '-')) {
                    $items[] = ltrim($line, "•- \t");
                    continue;
                }

                $paragraphs[] = $line;
            }

            $html = '<section class="rounded-2xl border border-slate-200 bg-offwhite/40 p-5 sm:p-6">';
            $html .= '<h3>'.e($heading).'</h3>';

            if ($items !== []) {
                $html .= '<ul>';
                foreach ($items as $item) {
                    $html .= '<li>'.e($item).'</li>';
                }
                $html .= '</ul>';
            }

            foreach ($paragraphs as $paragraph) {
                $html .= '<p class="text-sm sm:text-base text-slate-600 leading-relaxed'.($items !== [] ? ' mt-3' : '').'">'.e($paragraph).'</p>';
            }

            $html .= '</section>';
            $blocks[] = $html;
        }

        $descriptionHtml = implode('', $blocks);
    }
  @endphp

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

  <section class="py-10 md:py-14 bg-white">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-start">
        {{-- Mobile: image → buy box → specs. Desktop: sticky image+buy | specs+features --}}
        <div class="space-y-6 lg:space-y-8 lg:sticky lg:top-24">
          <div class="rounded-2xl bg-offwhite aspect-[4/5] max-h-[380px] sm:max-h-[420px] lg:max-h-none lg:aspect-square flex items-center justify-center overflow-hidden w-full">
            @if ($product->imageUrl())
              <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="max-h-full max-w-full object-contain p-4 sm:p-6" width="600" height="600">
            @else
              <i class="{{ $product->iconClass() }} text-7xl sm:text-8xl text-navy/20" aria-hidden="true"></i>
            @endif
          </div>

          <div>
            @if ($product->short_description)
              <p class="text-slate-600 leading-relaxed mb-5">{{ $product->short_description }}</p>
            @endif

            <div class="mb-5">
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
              class="inline-flex w-full sm:w-auto items-center justify-center gap-2 min-h-[52px] px-7 py-3 rounded-xl font-bold text-white bg-line">
              <i class="bi bi-chat-dots-fill" aria-hidden="true"></i> สอบถาม / สั่งซื้อ
            </a>
          </div>
        </div>

        <div class="min-w-0 space-y-6 sm:space-y-8">
          @if (is_array($product->specs) && count($product->specs))
            <div>
              <h2 class="font-display font-bold text-navy text-xl sm:text-2xl mb-1">
                ข้อมูลทางเทคนิค (Specifications)
              </h2>
              <p class="text-slate-500 text-sm mb-4">รายละเอียดทางเทคนิคของรุ่นนี้</p>

              <div class="overflow-x-auto -mx-4 px-4 sm:mx-0 sm:px-0">
                <div class="rounded-2xl border border-slate-200 overflow-hidden min-w-[288px]">
                  <table class="w-full text-sm sm:text-base">
                    <caption class="sr-only">ข้อมูลทางเทคนิค (Specifications) ของ {{ $product->name }}</caption>
                    <tbody class="divide-y divide-slate-100">
                      @foreach ($product->specs as $spec)
                        <tr class="align-top">
                          <th scope="row" class="w-[36%] sm:w-[40%] px-3 py-3 sm:px-5 sm:py-3.5 text-left font-medium text-slate-500 bg-offwhite/80">
                            {{ $spec['name'] ?? '' }}
                          </th>
                          <td class="px-3 py-3 sm:px-5 sm:py-3.5 font-semibold text-navy leading-snug">
                            {{ $spec['value'] ?? '' }}@if (! empty($spec['unitText'])) <span class="font-medium text-slate-500">{{ $spec['unitText'] }}</span>@endif
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          @endif

          @if ($descriptionHtml)
            <div class="product-detail-copy space-y-4 sm:space-y-5
              [&_h3]:font-display [&_h3]:font-bold [&_h3]:text-navy [&_h3]:text-lg [&_h3]:sm:text-xl [&_h3]:mb-3
              [&_ul]:space-y-2.5 [&_ul]:list-none
              [&_li]:relative [&_li]:pl-5 [&_li]:text-sm [&_li]:sm:text-base [&_li]:leading-relaxed [&_li]:text-slate-700
              [&_li]:before:content-[''] [&_li]:before:absolute [&_li]:before:left-0 [&_li]:before:top-[0.55em]
              [&_li]:before:w-2 [&_li]:before:h-2 [&_li]:before:rounded-full [&_li]:before:bg-orange">
              {!! $descriptionHtml !!}
            </div>
          @endif
        </div>
      </div>

      @if ($reviews->isNotEmpty())
        <div class="mt-12 md:mt-16">
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
