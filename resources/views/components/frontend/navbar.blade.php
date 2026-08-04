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
          <li><a href="{{ route('products.index') }}"
              @if (request()->routeIs('products.index')) data-active="true" @endif
              class="flex items-center min-h-[44px] px-3.5 py-2 rounded-lg text-sm font-medium text-white/75 transition-colors hover:text-white hover:bg-white/10 data-[active=true]:text-orange data-[active=true]:bg-white/10">สินค้าและบริการ</a>
          </li>
          <li><a href="{{ route('home') }}#portfolio" data-nav
              class="flex items-center min-h-[44px] px-3.5 py-2 rounded-lg text-sm font-medium text-white/75 transition-colors hover:text-white hover:bg-white/10 data-[active=true]:text-orange data-[active=true]:bg-white/10">ผลงาน</a>
          </li>
          <li><a href="{{ route('home') }}#why-us" data-nav
              class="flex items-center min-h-[44px] px-3.5 py-2 rounded-lg text-sm font-medium text-white/75 transition-colors hover:text-white hover:bg-white/10 data-[active=true]:text-orange data-[active=true]:bg-white/10">ทำไมต้องเรา</a>
          </li>
          <li><a href="{{ route('home') }}#contact" data-nav
              class="flex items-center min-h-[44px] px-3.5 py-2 rounded-lg text-sm font-medium text-white/75 transition-colors hover:text-white hover:bg-white/10 data-[active=true]:text-orange data-[active=true]:bg-white/10">ติดต่อ</a>
          </li>
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

    <!-- Mobile menu -->
    <div class="hidden flex-col bg-navy-mid px-4 pt-2 pb-4 border-t border-white/10" id="mobile-menu" role="menu">
      <a href="{{ route('products.index') }}" onclick="closeMenu()"
        class="flex items-center gap-2.5 py-3.5 text-base font-medium text-white/85 border-b border-white/5 transition-colors hover:text-orange"><i
          class="bi bi-grid-3x3-gap-fill" aria-hidden="true"></i>สินค้าและบริการ</a>
      <a href="{{ route('home') }}#portfolio" onclick="closeMenu()"
        class="flex items-center gap-2.5 py-3.5 text-base font-medium text-white/85 border-b border-white/5 transition-colors hover:text-orange"><i
          class="bi bi-images" aria-hidden="true"></i>ผลงาน</a>
      <a href="{{ route('home') }}#why-us" onclick="closeMenu()"
        class="flex items-center gap-2.5 py-3.5 text-base font-medium text-white/85 border-b border-white/5 transition-colors hover:text-orange"><i
          class="bi bi-star" aria-hidden="true"></i>ทำไมต้องเรา</a>
      <a href="{{ route('home') }}#testimonials" onclick="closeMenu()"
        class="flex items-center gap-2.5 py-3.5 text-base font-medium text-white/85 border-b border-white/5 transition-colors hover:text-orange"><i
          class="bi bi-chat-quote" aria-hidden="true"></i>รีวิวลูกค้า</a>
      <a href="{{ route('home') }}#contact" onclick="closeMenu()"
        class="flex items-center gap-2.5 py-3.5 text-base font-medium text-white/85 transition-colors hover:text-orange"><i
          class="bi bi-telephone" aria-hidden="true"></i>ติดต่อเรา</a>
    </div>
  </nav>
</header>