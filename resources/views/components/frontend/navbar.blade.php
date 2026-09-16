@php
  $items = [
      [
          'label' => 'บริการซ่อม',
          'url' => route('pages.show', 'vacuum-repair'),
          'active' => request()->is('vacuum-repair', 'vacuum-repair/*'),
          'icon' => 'bi-tools',
      ],
      [
          'label' => 'ราคาซ่อม',
          'url' => route('pages.show', 'service-rates'),
          'active' => request()->is('service-rates'),
          'icon' => 'bi-tags-fill',
      ],
      [
          'label' => 'ผลงาน',
          'url' => route('pages.show', 'portfolio'),
          'active' => request()->is('portfolio', 'portfolio/*'),
          'icon' => 'bi-images',
      ],
      [
          'label' => 'บทความ',
          'url' => route('blogs.index'),
          'active' => request()->routeIs('blogs.*'),
          'icon' => 'bi-journal-text',
      ],
      [
          'label' => 'สินค้า',
          'url' => route('products.index'),
          'active' => request()->routeIs('products.*') || request()->routeIs('services.*'),
          'icon' => 'bi-box-seam',
      ],
      [
          'label' => 'ติดต่อ',
          'url' => route('pages.show', 'contact-us'),
          'active' => request()->is('contact-us', 'about-us'),
          'icon' => 'bi-telephone',
      ],
  ];
@endphp

<header>
  <nav class="sticky top-0 z-[100] bg-navy border-b border-white/10 shadow-[0_2px_20px_rgba(0,0,0,.25)]"
    role="navigation" aria-label="เมนูหลัก">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
      <div class="flex items-center justify-between h-16">
        <a href="{{ route('home') }}" class="flex items-center shrink-0" aria-label="ศิริพงษ์ เซอร์วิส - หน้าแรก">
          <img
            src="{{ config('data.logo') }}"
            alt="SIRIPHONG-VACUUM"
            class="h-10 md:h-11 w-auto max-w-[200px] object-contain"
            width="200"
            height="44"
          >
        </a>

        <ul class="hidden md:flex list-none gap-1" role="list">
          @foreach ($items as $item)
            <li>
              <a href="{{ $item['url'] }}"
                @if ($item['active']) data-active="true" @endif
                class="flex items-center min-h-[44px] px-3.5 py-2 rounded-lg text-sm font-medium text-white/75 transition-colors hover:text-white hover:bg-white/10 data-[active=true]:text-orange data-[active=true]:bg-white/10">{{ $item['label'] }}</a>
            </li>
          @endforeach
        </ul>

        <div class="flex items-center gap-2.5">
          <a href="{{ config('data.line') }}" target="_blank" rel="noopener"
            class="hidden md:inline-flex items-center justify-center gap-2 min-h-[40px] px-[18px] py-2 rounded-xl text-sm font-bold text-white bg-line shadow-[0_4px_16px_rgba(6,199,85,.35)] transition-all hover:bg-line-dark hover:-translate-y-0.5"
            aria-label="แอดไลน์">
            <i class="bi bi-chat-dots-fill" aria-hidden="true"></i> แอดไลน์
          </a>
          <button
            class="md:hidden w-11 h-11 flex items-center justify-center rounded-lg text-2xl text-white transition-colors hover:bg-white/10"
            onclick="toggleMenu()" aria-label="เปิดเมนู" aria-expanded="false" id="hamburger">
            <i class="bi bi-list" id="ham-icon" aria-hidden="true"></i>
          </button>
        </div>
      </div>
    </div>

    <div class="hidden flex-col bg-navy-mid px-4 pt-2 pb-4 border-t border-white/10" id="mobile-menu" role="menu">
      @foreach ($items as $item)
        <a href="{{ $item['url'] }}" onclick="closeMenu()"
          @if ($item['active']) data-active="true" @endif
          class="flex items-center gap-2.5 py-3.5 text-base font-medium text-white/85 border-b border-white/5 last:border-b-0 transition-colors hover:text-orange data-[active=true]:text-orange">
          <i class="bi {{ $item['icon'] }}" aria-hidden="true"></i>{{ $item['label'] }}
        </a>
      @endforeach
    </div>
  </nav>
</header>
