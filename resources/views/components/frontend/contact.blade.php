<section class="relative overflow-hidden py-18 bg-[linear-gradient(160deg,#0f2347_0%,#1a3a6b_100%)]" id="contact" aria-labelledby="contact-title">
  <div class="absolute inset-0 bg-[size:40px_40px] bg-[linear-gradient(rgba(255,255,255,.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,.02)_1px,transparent_1px)]"></div>
  <div class="relative w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 md:items-center gap-10">
      <div data-reveal class="opacity-0 translate-y-6 transition duration-700 ease-out data-[show=true]:opacity-100 data-[show=true]:translate-y-0">
        <p class="font-display text-xs font-semibold tracking-[.14em] uppercase text-[#ffa070]">
          <i class="bi bi-telephone-fill" aria-hidden="true"></i> ติดต่อเรา
        </p>
        <h2 class="font-display font-bold text-white mb-3 mt-2 text-[clamp(1.6rem,4vw,2.4rem)]" id="contact-title">
          พร้อมช่วยคุณ<br>
          <span class="text-orange">ทุกวัน 8:00–18:00</span>
        </h2>
        <p class="text-white/70 mb-8 leading-relaxed">
          ส่งรูปเครื่องมาทาง LINE หรือโทรมาเลย
          ฟรีค่าตรวจสอบ พร้อมใบเสนอราคาทันที ไม่มีค่าใช้จ่ายซ่อนเร้น
        </p>

        <ul class="list-none flex flex-col gap-4 mb-8">
          <li class="flex items-center gap-3 text-[.95rem] text-white/85">
            <i class="bi bi-telephone-fill w-10 h-10 shrink-0 rounded-[10px] bg-white/10 flex items-center justify-center text-orange text-lg" aria-hidden="true"></i>
            <a href="tel:0812345678" class="text-inherit">081-234-5678</a>
          </li>
          <li class="flex items-center gap-3 text-[.95rem] text-white/85">
            <i class="bi bi-chat-dots-fill w-10 h-10 shrink-0 rounded-[10px] bg-white/10 flex items-center justify-center text-orange text-lg" aria-hidden="true"></i>
            <a href="https://line.me" target="_blank" rel="noopener" class="text-inherit">LINE: @siriphong</a>
          </li>
          <li class="flex items-center gap-3 text-[.95rem] text-white/85">
            <i class="bi bi-clock w-10 h-10 shrink-0 rounded-[10px] bg-white/10 flex items-center justify-center text-orange text-lg" aria-hidden="true"></i>
            จันทร์–เสาร์ 8:00–18:00 น.
          </li>
          <li class="flex items-center gap-3 text-[.95rem] text-white/85">
            <i class="bi bi-geo-alt-fill w-10 h-10 shrink-0 rounded-[10px] bg-white/10 flex items-center justify-center text-orange text-lg" aria-hidden="true"></i>
            กรุงเทพมหานครและปริมณฑล
          </li>
        </ul>

        <div class="flex flex-col min-[400px]:flex-row min-[400px]:flex-wrap gap-3">
          <a href="https://line.me" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 min-h-[52px] px-7 py-3 rounded-xl font-bold text-white bg-line shadow-[0_4px_16px_rgba(6,199,85,.35)] transition-all hover:bg-line-dark hover:-translate-y-0.5" aria-label="แอดไลน์เพื่อส่งรูปและปรึกษาฟรี">
            <i class="bi bi-chat-dots-fill" aria-hidden="true"></i>
            แอดไลน์ ปรึกษาฟรี
          </a>
          <a href="tel:0812345678" class="inline-flex items-center justify-center gap-2 min-h-[52px] px-7 py-3 rounded-xl font-bold text-white bg-transparent border-2 border-white/55 transition-all hover:bg-white/10 hover:border-white" aria-label="โทรหาเรา">
            <i class="bi bi-telephone-fill" aria-hidden="true"></i>
            โทรเลย
          </a>
        </div>
      </div>

      <!-- Contact form -->
      <div data-reveal class="opacity-0 translate-y-6 transition duration-700 ease-out data-[show=true]:opacity-100 data-[show=true]:translate-y-0">
        <div class="rounded-[20px] p-7 bg-white/[.07] border border-white/10 backdrop-blur-md">
          <h3 class="font-display font-bold text-[1.1rem] text-white mb-5">
            <i class="bi bi-send-fill text-orange mr-2" aria-hidden="true"></i>ส่งรายละเอียดเครื่อง
          </h3>
          <form onsubmit="handleSubmit(event)" novalidate>
            <div class="mb-4">
              <label class="block text-xs font-semibold text-white/75 mb-1.5" for="contact-name">ชื่อ-นามสกุล *</label>
              <input type="text" id="contact-name" placeholder="ชื่อของคุณ" required class="w-full min-h-[48px] px-3.5 py-3 rounded-xl bg-white/[.08] border border-white/20 text-white text-sm outline-none transition-colors placeholder:text-white/35 focus:border-orange focus:bg-white/[.12]">
            </div>
            <div class="mb-4">
              <label class="block text-xs font-semibold text-white/75 mb-1.5" for="contact-phone">เบอร์โทรศัพท์ *</label>
              <input type="tel" id="contact-phone" placeholder="0xx-xxx-xxxx" required class="w-full min-h-[48px] px-3.5 py-3 rounded-xl bg-white/[.08] border border-white/20 text-white text-sm outline-none transition-colors placeholder:text-white/35 focus:border-orange focus:bg-white/[.12]">
            </div>
            <div class="mb-4">
              <label class="block text-xs font-semibold text-white/75 mb-1.5" for="contact-machine">ยี่ห้อ/รุ่นเครื่อง</label>
              <input type="text" id="contact-machine" placeholder="เช่น Nilfisk IVB 3/1" class="w-full min-h-[48px] px-3.5 py-3 rounded-xl bg-white/[.08] border border-white/20 text-white text-sm outline-none transition-colors placeholder:text-white/35 focus:border-orange focus:bg-white/[.12]">
            </div>
            <div class="mb-4">
              <label class="block text-xs font-semibold text-white/75 mb-1.5" for="contact-problem">อาการเสีย *</label>
              <textarea id="contact-problem" placeholder="อธิบายอาการเสียโดยย่อ..." required class="w-full min-h-25 px-3.5 py-3 rounded-xl bg-white/[.08] border border-white/20 text-white text-sm outline-none resize-y transition-colors placeholder:text-white/35 focus:border-orange focus:bg-white/[.12]"></textarea>
            </div>
            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 min-h-[52px] px-7 py-3 rounded-xl font-bold text-white bg-orange shadow-[0_4px_16px_rgba(242,101,34,.35)] transition-all hover:bg-orange-dark hover:-translate-y-0.5">
              <i class="bi bi-send-fill" aria-hidden="true"></i>
              ส่งรายละเอียด
            </button>
          </form>
          <p class="text-xs text-white/40 text-center mt-3">
            <i class="bi bi-lock" aria-hidden="true"></i> ข้อมูลของคุณปลอดภัย 100%
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
