<header>
  <nav class="sticky top-0 z-[100] bg-navy border-b border-white/10 shadow-[0_2px_20px_rgba(0,0,0,.25)]"
    role="navigation" aria-label="เมนูหลัก">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
      <div class="flex items-center justify-between h-16">
        <a href="#" class="flex items-center gap-2.5" aria-label="ศิริพงษ์ เซอร์วิส - หน้าแรก">
          <div class="w-10 h-10 shrink-0 bg-orange rounded-[10px] flex items-center justify-center text-xl text-white">
            <i class="bi bi-tools" aria-hidden="true"></i>
          </div>
          <div class="flex flex-col leading-tight">
            <span class="font-display font-bold text-base text-white">ศิริพงษ์ vacuum</span>
            <span class="text-[.68rem] tracking-wide text-white/55">SIRIPHONG VACUUM</span>
          </div>
        </a>

        <ul class="hidden md:flex list-none gap-1" role="list">
          <li><a href="#services" data-nav data-active="true"
              class="flex items-center min-h-[44px] px-3.5 py-2 rounded-lg text-sm font-medium text-white/75 transition-colors hover:text-white hover:bg-white/10 data-[active=true]:text-orange data-[active=true]:bg-white/10">บริการ</a>
          </li>
          <li><a href="#portfolio" data-nav
              class="flex items-center min-h-[44px] px-3.5 py-2 rounded-lg text-sm font-medium text-white/75 transition-colors hover:text-white hover:bg-white/10 data-[active=true]:text-orange data-[active=true]:bg-white/10">ผลงาน</a>
          </li>
          <li><a href="#why-us" data-nav
              class="flex items-center min-h-[44px] px-3.5 py-2 rounded-lg text-sm font-medium text-white/75 transition-colors hover:text-white hover:bg-white/10 data-[active=true]:text-orange data-[active=true]:bg-white/10">ทำไมต้องเรา</a>
          </li>
          <li><a href="#contact" data-nav
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
      <a href="#services" onclick="closeMenu()"
        class="flex items-center gap-2.5 py-3.5 text-base font-medium text-white/85 border-b border-white/5 transition-colors hover:text-orange"><i
          class="bi bi-tools" aria-hidden="true"></i>บริการซ่อม</a>
      <a href="#portfolio" onclick="closeMenu()"
        class="flex items-center gap-2.5 py-3.5 text-base font-medium text-white/85 border-b border-white/5 transition-colors hover:text-orange"><i
          class="bi bi-images" aria-hidden="true"></i>ผลงาน</a>
      <a href="#why-us" onclick="closeMenu()"
        class="flex items-center gap-2.5 py-3.5 text-base font-medium text-white/85 border-b border-white/5 transition-colors hover:text-orange"><i
          class="bi bi-star" aria-hidden="true"></i>ทำไมต้องเรา</a>
      <a href="#testimonials" onclick="closeMenu()"
        class="flex items-center gap-2.5 py-3.5 text-base font-medium text-white/85 border-b border-white/5 transition-colors hover:text-orange"><i
          class="bi bi-chat-quote" aria-hidden="true"></i>รีวิวลูกค้า</a>
      <a href="#contact" onclick="closeMenu()"
        class="flex items-center gap-2.5 py-3.5 text-base font-medium text-white/85 transition-colors hover:text-orange"><i
          class="bi bi-telephone" aria-hidden="true"></i>ติดต่อเรา</a>
    </div>
  </nav>
</header>