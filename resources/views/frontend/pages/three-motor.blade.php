@extends('layout.frontend')

@php
  $fmt = function (?float $amount): ?string {
      if ($amount === null || $amount <= 0) {
          return null;
      }

      return number_format($amount, 0);
  };

  $currentPrice = function ($product): ?float {
      if (! $product) {
          return null;
      }
      $sale = $product->sale_price !== null ? (float) $product->sale_price : null;
      $base = (float) $product->price;
      if ($sale !== null && $sale > 0 && ($base <= 0 || $sale < $base)) {
          return $sale;
      }

      return $base > 0 ? $base : null;
  };

  $rich = function (?string $text): string {
      $escaped = e((string) $text);

      return preg_replace('/\*\*(.+?)\*\*/u', '<strong>$1</strong>', $escaped) ?? $escaped;
  };

  $minPriceLabel = $fmt($minPrice);
  $intro = str_replace('{min_price}', $minPriceLabel ?? '—', (string) $page->intro);
  $summary = $page->block('summary', []);
  $author = $page->block('author', []);
  $whatIs = $page->block('what_is', []);
  $pricing = $page->block('pricing', []);
  $sizeCompare = $page->block('size_compare', []);
  $brandTips = $page->block('brand_tips', []);
  $used = $page->block('used_checklist', []);
  $failures = $page->block('failures', []);
  $repair = $page->block('repair', []);
  $parts = $page->block('parts', []);
  $care = $page->block('care', []);
  $faqs = $page->block('faqs', []);
  $endCta = $page->block('end_cta', []);
  $pageKey = 'industrial-vacuum-3-motor';
  $heroAlt = $page->block('hero_image_alt', $page->title);
  $productsBySlug = $products->keyBy('slug');
@endphp

@section('content')
  <section class="py-12 md:py-16 bg-[linear-gradient(160deg,#0f2347_0%,#1a3a6b_55%,#1e4a8a_100%)]">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
      <nav class="mb-4 text-sm text-white/50" aria-label="breadcrumb">
        <ol class="flex flex-wrap items-center gap-1.5 list-none">
          <li><a href="{{ route('home') }}" class="hover:text-orange">หน้าแรก</a></li>
          <li><i class="bi bi-chevron-right text-[.65rem]" aria-hidden="true"></i></li>
          <li class="text-white/80">เครื่องดูดฝุ่น 3 มอเตอร์</li>
        </ol>
      </nav>

      <h1 class="font-display font-bold text-white text-[clamp(1.8rem,5vw,2.8rem)] leading-tight max-w-4xl">
        {{ $page->title }}
      </h1>

      <p class="mt-4 max-w-3xl text-white/80 text-base md:text-lg leading-relaxed">{{ $intro }}</p>

      <div class="mt-7 flex flex-wrap gap-3">
        <a href="{{ config('contact.line') }}" target="_blank" rel="noopener"
          data-cta="line" data-position="hero" data-page="{{ $pageKey }}"
          class="inline-flex items-center justify-center gap-2 min-h-[52px] px-7 py-3 rounded-xl font-bold text-white bg-line shadow-[0_4px_16px_rgba(6,199,85,.35)] transition-all hover:bg-line-dark hover:-translate-y-0.5">
          <i class="bi bi-chat-dots-fill" aria-hidden="true"></i> ส่งรูปเครื่องทาง LINE ประเมินฟรี
        </a>
        <a href="tel:{{ config('contact.phone') }}"
          data-cta="tel" data-position="hero" data-page="{{ $pageKey }}"
          class="inline-flex items-center justify-center gap-2 min-h-[52px] px-7 py-3 rounded-xl font-bold text-white border border-white/30 bg-white/10 transition-all hover:bg-white/20">
          <i class="bi bi-telephone-fill" aria-hidden="true"></i> {{ config('contact.phone_formatted') }}
        </a>
      </div>
    </div>
  </section>

  <section class="py-10 bg-white">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
      @if (!empty($summary['bullets']))
        <div class="rounded-2xl border border-orange/25 bg-orange/[.06] p-5 md:p-6">
          <h2 class="font-display font-bold text-navy text-lg md:text-xl">{{ $summary['heading'] ?? 'สรุปสั้น ๆ' }}</h2>
          <ul class="mt-4 space-y-2.5 text-slate-700 leading-relaxed">
            @foreach ($summary['bullets'] as $bullet)
              <li class="flex gap-2"><span class="text-orange font-bold">•</span><span>{!! $rich($bullet) !!}</span></li>
            @endforeach
          </ul>
        </div>
      @endif

      @if (!empty($author))
        <p class="mt-5 text-sm text-slate-500">
          เขียนโดย
          <a href="{{ url($author['about_url'] ?? '/about-us') }}" class="font-semibold text-navy underline decoration-orange/50 underline-offset-2 hover:text-orange">
            {{ $author['name'] ?? '' }} ({{ $author['nickname'] ?? '' }})
          </a>
          • {{ $author['bio'] ?? '' }}
          @if (!empty($author['updated_label']))
            • อัปเดตล่าสุด {{ $author['updated_label'] }}
          @endif
        </p>
      @endif

      @if ($page->heroImageUrl())
        <figure class="mt-8 overflow-hidden rounded-2xl border border-slate-200 bg-offwhite">
          <img
            src="{{ $page->heroImageUrl() }}"
            alt="{{ $heroAlt }}"
            width="1200"
            height="800"
            class="w-full h-auto object-cover">
        </figure>
      @endif
    </div>
  </section>

  @if (!empty($whatIs))
    <section class="py-14 bg-offwhite" aria-labelledby="what-is-title">
      <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
        <h2 id="what-is-title" class="font-display font-bold text-navy text-[clamp(1.4rem,3.5vw,2rem)] max-w-3xl">
          {{ $whatIs['heading'] }}
        </h2>
        <p class="mt-4 max-w-3xl text-slate-600 leading-relaxed">{{ $whatIs['body'] ?? '' }}</p>
        @if (!empty($whatIs['audiences']))
          <p class="mt-6 font-semibold text-navy">{{ $whatIs['audiences_intro'] ?? '' }}</p>
          <ul class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($whatIs['audiences'] as $audience)
              <li class="rounded-2xl bg-white border border-slate-200 p-5">
                <p class="font-display font-bold text-navy">{{ $audience['title'] }}</p>
                <p class="mt-2 text-sm text-slate-600 leading-relaxed">{{ $audience['body'] }}</p>
              </li>
            @endforeach
          </ul>
        @endif
        @if (!empty($whatIs['warning_title']))
          <div class="mt-6 rounded-xl border border-orange/30 bg-white px-4 py-3 text-slate-700 leading-relaxed">
            <strong>{{ $whatIs['warning_title'] }}</strong>
            <span class="mt-1 block">{!! $rich($whatIs['warning_body'] ?? '') !!}</span>
          </div>
        @endif
      </div>
    </section>
  @endif

  @if (!empty($pricing))
    <section class="py-14 bg-white" aria-labelledby="pricing-title">
      <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
        <h2 id="pricing-title" class="font-display font-bold text-navy text-[clamp(1.4rem,3.5vw,2rem)]">
          {{ $pricing['heading'] }}
        </h2>
        <p class="mt-4 max-w-3xl text-slate-600 leading-relaxed">{{ $pricing['intro'] ?? '' }}</p>

        <div class="mt-8 overflow-x-auto rounded-2xl border border-slate-200 shadow-sm">
          <table class="w-full min-w-[640px] text-left text-sm">
            <thead class="bg-navy text-white">
              <tr>
                <th class="px-5 py-4 font-semibold">รายการ</th>
                <th class="px-5 py-4 font-semibold">ราคาที่ศิริพงษ์ เซอร์วิส</th>
                <th class="px-5 py-4 font-semibold">หมายเหตุ</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              @foreach (($pricing['rows'] ?? []) as $row)
                @php
                  $product = !empty($row['product_slug']) ? $productsBySlug->get($row['product_slug']) : null;
                  $sale = $product ? $currentPrice($product) : null;
                  $base = $product ? (float) $product->price : null;
                @endphp
                <tr class="align-top">
                  <td class="px-5 py-4 font-semibold text-navy">
                    @if ($product)
                      <a href="{{ route('products.show', $product->slug) }}" class="hover:text-orange underline decoration-orange/40 underline-offset-2">
                        {{ $row['item'] }}
                      </a>
                    @else
                      {{ $row['item'] }}
                    @endif
                  </td>
                  <td class="px-5 py-4 text-slate-700">
                    @if ($product && $sale)
                      <strong class="text-orange">{{ $fmt($sale) }} บาท</strong>
                      @if ($base && $base > $sale)
                        <span class="text-slate-400 line-through ml-1">(ปกติ {{ $fmt($base) }})</span>
                      @endif
                    @else
                      {{ $row['price'] }}
                    @endif
                  </td>
                  <td class="px-5 py-4 text-slate-600">{{ $row['note'] ?? '' }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @if (!empty($pricing['note']))
          <p class="mt-3 text-xs text-slate-500">{{ $pricing['note'] }}</p>
        @endif

        @if (!empty($pricing['cta']))
          <div class="mt-8 rounded-2xl bg-offwhite border border-slate-200 p-5 md:p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <p class="text-slate-700 leading-relaxed">{{ $pricing['cta'] }}</p>
            <a href="{{ config('contact.line') }}" target="_blank" rel="noopener"
              data-cta="line" data-position="mid" data-page="{{ $pageKey }}"
              class="inline-flex items-center justify-center gap-2 min-h-[48px] px-6 py-2.5 rounded-xl font-bold text-white bg-line shrink-0">
              <i class="bi bi-chat-dots-fill" aria-hidden="true"></i> ส่งรูปทาง LINE
            </a>
          </div>
        @endif
      </div>
    </section>
  @endif

  @if (!empty($sizeCompare))
    <section class="py-14 bg-offwhite" aria-labelledby="size-title">
      <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
        <h2 id="size-title" class="font-display font-bold text-navy text-[clamp(1.4rem,3.5vw,2rem)]">
          {{ $sizeCompare['heading'] }}
        </h2>
        <p class="mt-4 max-w-3xl text-slate-600 leading-relaxed">{{ $sizeCompare['intro'] ?? '' }}</p>

        <div class="mt-8 overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
          <table class="w-full min-w-[640px] text-left text-sm">
            <thead class="bg-navy text-white">
              <tr>
                @foreach (($sizeCompare['columns'] ?? []) as $col)
                  <th class="px-5 py-4 font-semibold">{{ $col }}</th>
                @endforeach
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              @foreach (($sizeCompare['rows'] ?? []) as $row)
                <tr class="align-top">
                  @foreach ($row as $cell)
                    <td class="px-5 py-4 text-slate-700 leading-relaxed {{ $loop->first ? 'font-semibold text-navy bg-offwhite/60' : '' }}">
                      @if ($loop->parent->last && ! $loop->first)
                        @php
                          $slug = $loop->iteration === 2 ? 'wp-bf-585-60' : 'wp-bf-585-80';
                          $p = $productsBySlug->get($slug);
                          $price = $currentPrice($p);
                        @endphp
                        @if ($price)
                          {{ $fmt($price) }} บาท
                        @else
                          {{ $cell }}
                        @endif
                      @else
                        {{ $cell }}
                      @endif
                    </td>
                  @endforeach
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @if (!empty($sizeCompare['note']))
          <p class="mt-3 text-xs text-slate-500">{{ $sizeCompare['note'] }}</p>
        @endif

        @if ($products->isNotEmpty())
          <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach ($products as $product)
              @php $price = $currentPrice($product); @endphp
              <a href="{{ route('products.show', $product->slug) }}"
                class="group flex gap-4 rounded-2xl border border-slate-200 bg-white p-4 transition-all hover:border-orange hover:shadow-md">
                @if ($product->imageUrl())
                  <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" width="120" height="120"
                    class="w-24 h-24 object-contain rounded-xl bg-offwhite" loading="lazy">
                @endif
                <span class="min-w-0">
                  <span class="block font-display font-bold text-navy group-hover:text-orange">{{ $product->name }}</span>
                  @if ($product->short_description)
                    <span class="mt-1 block text-sm text-slate-600 line-clamp-2">{{ $product->short_description }}</span>
                  @endif
                  @if ($price)
                    <span class="mt-2 block text-sm font-bold text-orange">฿{{ $fmt($price) }}</span>
                  @endif
                  <span class="mt-2 inline-flex text-sm font-semibold text-navy group-hover:text-orange">ดูรายละเอียด →</span>
                </span>
              </a>
            @endforeach
          </div>
        @endif
      </div>
    </section>
  @endif

  @if (!empty($brandTips))
    <section class="py-14 bg-white" aria-labelledby="brand-title">
      <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
        <h2 id="brand-title" class="font-display font-bold text-navy text-[clamp(1.4rem,3.5vw,2rem)] max-w-3xl">
          {{ $brandTips['heading'] }}
        </h2>
        <p class="mt-4 max-w-3xl text-slate-600 leading-relaxed">{!! $rich($brandTips['intro'] ?? '') !!}</p>
        <ol class="mt-6 space-y-4 max-w-3xl">
          @foreach (($brandTips['items'] ?? []) as $item)
            <li class="flex gap-3">
              <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-navy text-sm font-bold text-white">{{ $loop->iteration }}</span>
              <div>
                <p class="font-semibold text-navy">{{ $item['title'] }}</p>
                <p class="mt-1 text-slate-600 leading-relaxed">{{ $item['body'] }}</p>
              </div>
            </li>
          @endforeach
        </ol>
        @if (!empty($brandTips['note']))
          <p class="mt-6 max-w-3xl text-sm text-slate-500">{!! $rich($brandTips['note']) !!}</p>
        @endif
      </div>
    </section>
  @endif

  @if (!empty($used))
    <section class="py-14 bg-offwhite" aria-labelledby="used-title">
      <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
        <h2 id="used-title" class="font-display font-bold text-navy text-[clamp(1.4rem,3.5vw,2rem)]">
          {{ $used['heading'] }}
        </h2>
        <p class="mt-4 max-w-3xl text-slate-600 leading-relaxed">{!! $rich($used['intro'] ?? '') !!}</p>
        <ol class="mt-6 space-y-3 max-w-3xl">
          @foreach (($used['items'] ?? []) as $item)
            <li class="flex gap-3 text-slate-700 leading-relaxed">
              <span class="font-bold text-orange shrink-0">{{ $loop->iteration }}.</span>
              <span>{!! $rich($item) !!}</span>
            </li>
          @endforeach
        </ol>
        @if (!empty($used['tip']))
          <div class="mt-6 rounded-xl border border-orange/25 bg-white px-4 py-3 text-slate-700 leading-relaxed max-w-3xl">
            {!! $rich($used['tip']) !!}
          </div>
        @endif
        @if (!empty($used['stock_note']))
          <p class="mt-4 max-w-3xl text-slate-600 leading-relaxed">{{ $used['stock_note'] }}</p>
        @endif
        <a href="{{ config('contact.line') }}" target="_blank" rel="noopener"
          data-cta="line" data-position="used" data-page="{{ $pageKey }}"
          class="mt-6 inline-flex items-center justify-center gap-2 min-h-[48px] px-6 py-2.5 rounded-xl font-bold text-white bg-line">
          <i class="bi bi-chat-dots-fill" aria-hidden="true"></i> {{ $used['cta_label'] ?? 'ถามเครื่องมือสอง' }}
        </a>
      </div>
    </section>
  @endif

  @if (!empty($failures))
    <section class="py-14 bg-white" aria-labelledby="failures-title">
      <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
        <h2 id="failures-title" class="font-display font-bold text-navy text-[clamp(1.4rem,3.5vw,2rem)]">
          {{ $failures['heading'] }}
        </h2>
        <p class="mt-4 max-w-3xl text-slate-600 leading-relaxed">{!! $rich($failures['intro'] ?? '') !!}</p>

        <div class="mt-8 overflow-x-auto rounded-2xl border border-slate-200 shadow-sm">
          <table class="w-full min-w-[720px] text-left text-sm">
            <thead class="bg-navy text-white">
              <tr>
                <th class="px-5 py-4 font-semibold">อาการ</th>
                <th class="px-5 py-4 font-semibold">สาเหตุที่พบบ่อย</th>
                <th class="px-5 py-4 font-semibold">ค่าซ่อมเริ่มต้น</th>
                <th class="px-5 py-4 font-semibold">อ่านเพิ่ม</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              @foreach (($failures['rows'] ?? []) as $row)
                <tr class="align-top">
                  <td class="px-5 py-4 font-semibold text-navy">{{ $row['symptom'] }}</td>
                  <td class="px-5 py-4 text-slate-700">{{ $row['cause'] }}</td>
                  <td class="px-5 py-4 text-slate-700">{{ $row['price'] }}</td>
                  <td class="px-5 py-4">
                    @if (!empty($row['link_url']))
                      <a href="{{ url($row['link_url']) }}" class="font-semibold text-navy underline decoration-orange/50 underline-offset-2 hover:text-orange">
                        {{ $row['link_label'] }}
                      </a>
                    @else
                      —
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        @if (!empty($failures['water_warning']))
          <p class="mt-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-slate-700 leading-relaxed">
            {{ $failures['water_warning'] }}
          </p>
        @endif
        @if (!empty($failures['breaker_tip']))
          <p class="mt-4 max-w-3xl text-slate-600 leading-relaxed">{{ $failures['breaker_tip'] }}</p>
        @endif
      </div>
    </section>
  @endif

  @if (!empty($repair))
    <section class="py-14 bg-offwhite" aria-labelledby="repair-title">
      <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
        <h2 id="repair-title" class="font-display font-bold text-navy text-[clamp(1.4rem,3.5vw,2rem)]">
          {{ $repair['heading'] }}
        </h2>
        <p class="mt-4 max-w-3xl text-slate-600 leading-relaxed">{{ $repair['intro'] ?? '' }}</p>

        @if (!empty($repair['case']))
          <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-5 md:p-6 max-w-3xl">
            <h3 class="font-display font-bold text-navy text-lg">{{ $repair['case']['heading'] }}</h3>
            <p class="mt-3 text-slate-700 leading-relaxed">{!! $rich($repair['case']['body'] ?? '') !!}</p>
            @if (!empty($repair['case']['link_url']))
              <a href="{{ url($repair['case']['link_url']) }}" class="mt-4 inline-flex font-semibold text-navy underline decoration-orange/50 underline-offset-2 hover:text-orange">
                {{ $repair['case']['link_label'] }} →
              </a>
            @endif
          </div>
        @endif

        @if (!empty($repair['steps']))
          <ol class="mt-8 space-y-4 max-w-3xl">
            @foreach ($repair['steps'] as $step)
              <li class="flex gap-3">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-orange text-sm font-bold text-white">{{ $loop->iteration }}</span>
                <p class="text-slate-700 leading-relaxed pt-1">{{ $step }}</p>
              </li>
            @endforeach
          </ol>
        @endif

        @if (!empty($repair['links']))
          <div class="mt-6 flex flex-wrap gap-4">
            @foreach ($repair['links'] as $link)
              <a href="{{ url($link['url']) }}" class="font-semibold text-navy underline decoration-orange/50 underline-offset-2 hover:text-orange">
                {{ $link['label'] }}
              </a>
            @endforeach
          </div>
        @endif
      </div>
    </section>
  @endif

  @if (!empty($parts))
    <section class="py-14 bg-white" aria-labelledby="parts-title">
      <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
        <h2 id="parts-title" class="font-display font-bold text-navy text-[clamp(1.4rem,3.5vw,2rem)]">
          {{ $parts['heading'] }}
        </h2>
        <p class="mt-4 max-w-3xl text-slate-600 leading-relaxed">{{ $parts['intro'] ?? '' }}</p>

        <div class="mt-8 overflow-x-auto rounded-2xl border border-slate-200 shadow-sm">
          <table class="w-full min-w-[640px] text-left text-sm">
            <thead class="bg-navy text-white">
              <tr>
                <th class="px-5 py-4 font-semibold">อะไหล่</th>
                <th class="px-5 py-4 font-semibold">สัญญาณว่าต้องเปลี่ยน</th>
                <th class="px-5 py-4 font-semibold">ร้านเปลี่ยนให้ / ราคาเริ่ม</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              @foreach (($parts['rows'] ?? []) as $row)
                <tr class="align-top">
                  <td class="px-5 py-4 font-semibold text-navy">{{ $row['name'] }}</td>
                  <td class="px-5 py-4 text-slate-700">{{ $row['signal'] }}</td>
                  <td class="px-5 py-4 text-slate-700">{{ $row['price'] }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <a href="{{ config('contact.line') }}" target="_blank" rel="noopener"
          data-cta="line" data-position="parts" data-page="{{ $pageKey }}"
          class="mt-6 inline-flex items-center justify-center gap-2 min-h-[48px] px-6 py-2.5 rounded-xl font-bold text-white bg-line">
          <i class="bi bi-chat-dots-fill" aria-hidden="true"></i> {{ $parts['cta_label'] ?? 'ถามอะไหล่ทาง LINE' }}
        </a>

        @if (!empty($parts['hose']))
          <div class="mt-12 max-w-3xl">
            <h3 class="font-display font-bold text-navy text-xl">{{ $parts['hose']['heading'] }}</h3>
            <p class="mt-3 text-slate-600 leading-relaxed">{!! $rich($parts['hose']['intro'] ?? '') !!}</p>
            <ul class="mt-4 space-y-3">
              @foreach (($parts['hose']['items'] ?? []) as $item)
                <li class="text-slate-700 leading-relaxed">
                  <strong>{{ $item['title'] }}</strong> — {!! $rich($item['body']) !!}
                </li>
              @endforeach
            </ul>
          </div>
        @endif

        @if (!empty($parts['nozzle']))
          <div class="mt-10 max-w-3xl">
            <h3 class="font-display font-bold text-navy text-xl">{{ $parts['nozzle']['heading'] }}</h3>
            <p class="mt-3 text-slate-600 leading-relaxed">{{ $parts['nozzle']['intro'] ?? '' }}</p>
            <ol class="mt-4 space-y-3 list-decimal pl-5">
              @foreach (($parts['nozzle']['items'] ?? []) as $item)
                <li class="text-slate-700 leading-relaxed">{!! $rich($item) !!}</li>
              @endforeach
            </ol>
          </div>
        @endif
      </div>
    </section>
  @endif

  @if (!empty($care))
    <section class="py-14 bg-offwhite" aria-labelledby="care-title">
      <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
        <h2 id="care-title" class="font-display font-bold text-navy text-[clamp(1.4rem,3.5vw,2rem)]">
          {{ $care['heading'] }}
        </h2>
        <p class="mt-4 max-w-3xl text-slate-600 leading-relaxed">{{ $care['intro'] ?? '' }}</p>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl">
          @foreach (['daily', 'weekly'] as $key)
            @if (!empty($care[$key]))
              <div class="rounded-2xl bg-white border border-slate-200 p-5">
                <h3 class="font-display font-bold text-navy">{{ $care[$key]['heading'] }}</h3>
                <ul class="mt-3 space-y-2">
                  @foreach (($care[$key]['items'] ?? []) as $item)
                    <li class="flex gap-2 text-slate-700 leading-relaxed">
                      <span class="text-orange">•</span><span>{{ $item }}</span>
                    </li>
                  @endforeach
                </ul>
              </div>
            @endif
          @endforeach
        </div>

        @if (!empty($care['warning']))
          <p class="mt-6 max-w-3xl text-slate-700 leading-relaxed">{{ $care['warning'] }}</p>
        @endif
        @if (!empty($care['link_url']))
          <a href="{{ url($care['link_url']) }}" class="mt-4 inline-flex font-semibold text-navy underline decoration-orange/50 underline-offset-2 hover:text-orange">
            {{ $care['link_label'] }} →
          </a>
        @endif
      </div>
    </section>
  @endif

  <x-frontend.page-faqs
    :heading="$faqs['heading'] ?? 'คำถามที่พบบ่อย'"
    :items="$faqs['items'] ?? []"
  />

  <section class="py-12 bg-navy">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
      <h2 class="font-display font-bold text-white text-xl md:text-2xl">
        {{ $endCta['heading'] ?? 'ทักช่างต้อยได้เลย' }}
      </h2>
      <p class="mt-3 max-w-3xl text-white/70 leading-relaxed">{{ $endCta['body'] ?? '' }}</p>
      <div class="mt-6 flex flex-wrap gap-3">
        <a href="{{ config('contact.line') }}" target="_blank" rel="noopener"
          data-cta="line" data-position="end" data-page="{{ $pageKey }}"
          class="inline-flex items-center justify-center gap-2 min-h-[48px] px-6 py-2.5 rounded-xl font-bold text-white bg-line">
          <i class="bi bi-chat-dots-fill" aria-hidden="true"></i> ส่งรูปป้ายรุ่น + คลิปอาการทาง LINE
        </a>
        <a href="tel:{{ config('contact.phone') }}"
          data-cta="tel" data-position="end" data-page="{{ $pageKey }}"
          class="inline-flex items-center justify-center gap-2 min-h-[48px] px-6 py-2.5 rounded-xl font-bold text-white border border-white/30 bg-white/10">
          <i class="bi bi-telephone-fill" aria-hidden="true"></i> โทร {{ config('contact.phone_formatted') }}
        </a>
      </div>
      <ul class="mt-6 space-y-1.5 text-sm text-white/55">
        <li>เปิด {{ config('contact.hours') }} • {{ config('contact.hours_note') }}</li>
        <li>{{ config('contact.address_short') }}</li>
        <li>ช่างไปหน้างาน {{ config('contact.area_served') }} (ฟรี {{ config('contact.travel_free_km') }} กม.แรก) • ส่งขนส่งได้ทุกจังหวัด</li>
      </ul>
    </div>
  </section>
@endsection

@push('head')
  @php
    $og = $page->block('og', []);
    $canonical = rtrim((string) config('contact.url'), '/').'/industrial-vacuum-3-motor';
    $ogTitle = $og['title'] ?? $title;
    $ogImage = $page->heroImageUrl();
  @endphp
  <link rel="canonical" href="{{ $canonical }}">
  <meta property="og:type" content="{{ $og['type'] ?? 'article' }}">
  <meta property="og:title" content="{{ $ogTitle }}">
  <meta property="og:description" content="{{ $description }}">
  <meta property="og:url" content="{{ $canonical }}">
  @if ($ogImage)
    <meta property="og:image" content="{{ $ogImage }}">
  @endif
@endpush

@push('jsonld')
  <x-schema-jsonld :graph="$schemaGraph" />
@endpush
