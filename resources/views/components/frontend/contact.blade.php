<section class="relative overflow-hidden py-18 bg-[linear-gradient(160deg,#0f2347_0%,#1a3a6b_100%)]" id="contact"
  aria-labelledby="contact-title">
  <div
    class="absolute inset-0 bg-[size:40px_40px] bg-[linear-gradient(rgba(255,255,255,.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,.02)_1px,transparent_1px)]">
  </div>
  <div class="relative w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 md:items-center gap-10">
      <div data-reveal
        class="opacity-0 translate-y-6 transition duration-700 ease-out data-[show=true]:opacity-100 data-[show=true]:translate-y-0">
        <p class="font-display text-xs font-semibold tracking-[.14em] uppercase text-[#ffa070]">
          <i class="bi bi-telephone-fill" aria-hidden="true"></i> ติดต่อเรา
        </p>
        <h2 class="font-display font-bold text-white mb-3 mt-2 text-[clamp(1.6rem,4vw,2.4rem)]" id="contact-title">
          เครื่องดูดฝุ่นอุตสาหกรรมเสียอยู่?<br>
          <span class="text-orange">ทักช่างต้อยได้เลย</span>
        </h2>
        <p class="text-white/70 mb-8 leading-relaxed">
          ส่งรูปป้ายรุ่น + คลิปอาการทาง LINE ช่างต้อยประเมินให้ฟรี และแจ้งราคาก่อนซ่อมทุกครั้ง ไม่มีค่าใช้จ่ายซ่อนเร้น
        </p>

        <ul class="list-none flex flex-col gap-4 mb-8">
          <li class="flex items-center gap-3 text-[.95rem] text-white/85">
            <i class="bi bi-telephone-fill w-10 h-10 shrink-0 rounded-[10px] bg-white/10 flex items-center justify-center text-orange text-lg"
              aria-hidden="true"></i>
            <a href="tel:{{ config('contact.phone') }}" data-cta="tel" data-position="end" data-page="home" class="text-inherit">โทร {{ config('contact.phone_formatted') }} (เปิดทุกวัน 08:00–18:00 • เครื่องเสียด่วน ทักไว้ได้ 24 ชม.)</a>
          </li>
          <li class="flex items-center gap-3 text-[.95rem] text-white/85">
            <i class="bi bi-chat-dots-fill w-10 h-10 shrink-0 rounded-[10px] bg-white/10 flex items-center justify-center text-orange text-lg"
              aria-hidden="true"></i>
            <a href="{{ config('contact.line') }}" target="_blank" rel="noopener" data-cta="line" data-position="end" data-page="home" class="text-inherit">ส่งรูปป้ายรุ่น + คลิปอาการทาง LINE ช่างต้อยประเมินให้ฟรี</a>
          </li>
          <li class="flex items-start gap-3 text-[.95rem] text-white/85">
            <i class="bi bi-clock w-10 h-10 shrink-0 rounded-[10px] bg-white/10 flex items-center justify-center text-orange text-lg"
              aria-hidden="true"></i>
            <span>{{ config('contact.hours') }} • {{ config('contact.hours_note') }}</span>
          </li>
          <li class="flex items-start gap-3 text-[.95rem] text-white/85">
            <i class="bi bi-geo-alt-fill w-10 h-10 shrink-0 rounded-[10px] bg-white/10 flex items-center justify-center text-orange text-lg"
              aria-hidden="true"></i>
            <span>
              {{ config('contact.address_short') }}
              <span class="block text-sm text-white/60 mt-1">ช่างไปหน้างาน {{ config('contact.area_served') }} (ฟรี {{ config('contact.travel_free_km') }} กม.แรก) • ส่งขนส่งได้ทุกจังหวัด</span>
            @if (filled(config('contact.google_maps_url')))
              <a href="{{ config('contact.google_maps_url') }}" target="_blank" rel="noopener" class="block text-sm text-orange mt-1">เปิดแผนที่</a>
            @endif
            </span>
          </li>
        </ul>

        <div class="flex flex-col min-[400px]:flex-row min-[400px]:flex-wrap gap-3">
          <a href="{{ config('contact.line') }}" target="_blank" rel="noopener"
            data-cta="line" data-position="end" data-page="home"
            class="inline-flex items-center justify-center gap-2 min-h-[52px] px-7 py-3 rounded-xl font-bold text-white bg-line shadow-[0_4px_16px_rgba(6,199,85,.35)] transition-all hover:bg-line-dark hover:-translate-y-0.5"
            aria-label="ส่งรูปทาง LINE ประเมินฟรี">
            <i class="bi bi-chat-dots-fill" aria-hidden="true"></i>
            ส่งรูปทาง LINE ประเมินฟรี
          </a>
          <a href="tel:{{ config('contact.phone') }}"
            data-cta="tel" data-position="end" data-page="home"
            class="inline-flex items-center justify-center gap-2 min-h-[52px] px-7 py-3 rounded-xl font-bold text-white bg-transparent border-2 border-white/55 transition-all hover:bg-white/10 hover:border-white"
            aria-label="โทร {{ config('contact.phone_formatted') }}">
            <i class="bi bi-telephone-fill" aria-hidden="true"></i>
            โทร {{ config('contact.phone_formatted') }}
          </a>
        </div>
      </div>

      <div class="bg-white p-8 md:p-10 rounded-2xl shadow-sm border border-gray-100 text-center">
        <h3 class="font-display font-bold text-navy text-xl mb-2">สแกนเพิ่มเพื่อนทาง LINE</h3>
        <p class="text-steel text-sm mb-6">ใช้กล้องมือถือสแกน เพื่อส่งรูปเครื่องและอาการเสียให้ช่างประเมินราคาได้ทันที
        </p>

        <div
          class="w-64 h-64 mx-auto bg-offwhite border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center mb-6 group hover:border-[#06c755] transition-colors">
          <img src="{{ media_url(config('data.line_qr')) }}" alt="QR Code สำหรับเพิ่มเพื่อน LINE ศิริพงษ์ เซอร์วิส"
            width="256" height="256" class="rounded-lg" loading="lazy">
        </div>

        <p class="text-xs text-steel flex items-center justify-center">
          <i class="bi bi-shield-lock-fill text-orange mr-1.5" aria-hidden="true"></i> ข้อมูลของคุณปลอดภัย 100%
        </p>
      </div>
    </div>
  </div>
</section>