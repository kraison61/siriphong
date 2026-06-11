<section class="relative overflow-hidden py-14 md:py-20 md:pb-24 bg-[linear-gradient(160deg,#0f2347_0%,#1a3a6b_55%,#1e4a8a_100%)]" aria-labelledby="hero-title">
  <!-- industrial grid overlay -->
  <div class="pointer-events-none absolute inset-0 bg-[size:40px_40px] bg-[linear-gradient(rgba(255,255,255,.025)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,.025)_1px,transparent_1px)]"></div>
  <!-- orange accent bar -->
  <div class="absolute left-0 top-0 bottom-0 w-1 bg-[linear-gradient(to_bottom,#f26522,transparent)]"></div>

  <div class="relative w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
    <div class="md:grid md:grid-cols-[1fr_auto] md:gap-12 md:items-center">
      <div>
        <div class="animate-fade-down inline-flex items-center gap-2 mb-5 px-3.5 py-1.5 rounded-full bg-orange/15 border border-orange/40 text-sm font-semibold tracking-wide text-[#ffa070]">
          <i class="bi bi-patch-check-fill text-orange" aria-hidden="true"></i>
          ประสบการณ์กว่า 20 ปี · ไว้ใจได้
        </div>
        <h1 class="animate-fade-up [animation-delay:.1s] font-display font-bold text-white leading-[1.1] mb-4 text-[clamp(2rem,7vw,3.8rem)]" id="hero-title">
          ผู้เชี่ยวชาญ
          <span class="block text-orange pt-4">ซ่อมเครื่องดูดฝุ่น<br>อุตสาหกรรม</span>
        </h1>
        <p class="animate-fade-up [animation-delay:.2s] max-w-[520px] mb-8 leading-[1.7] text-white/[.78] text-[clamp(1rem,2.5vw,1.15rem)]">
          รับซ่อมทุกยี่ห้อ ทุกรุ่น ด้วยความซื่อสัตย์และตรงไปตรงมา
          ราคายุติธรรม รับประกันงาน บริการถึงที่
        </p>
        <div class="animate-fade-up [animation-delay:.3s] flex flex-col sm:flex-row gap-3">
          <a href="https://line.me/ti/p/Kqsti_kwU9" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 min-h-[52px] px-7 py-3 rounded-xl font-bold text-white bg-line shadow-[0_4px_16px_rgba(6,199,85,.35)] transition-all hover:bg-line-dark hover:-translate-y-0.5" aria-label="แอดไลน์เพื่อส่งรูปเครื่องและปรึกษาฟรี">
            <i class="bi bi-chat-dots-fill" aria-hidden="true"></i>
            แอดไลน์ ส่งรูปเครื่อง
          </a>
          <a href="tel:0812345678" class="inline-flex items-center justify-center gap-2 min-h-[52px] px-7 py-3 rounded-xl font-bold text-white bg-transparent border-2 border-white/55 transition-all hover:bg-white/10 hover:border-white" aria-label="โทรหาเรา 081-234-5678">
            <i class="bi bi-telephone-fill" aria-hidden="true"></i>
            081-234-5678
          </a>
        </div>

        <div class="animate-fade-up [animation-delay:.4s] grid grid-cols-3 gap-3 mt-12" aria-label="สถิติผลงาน">
          <div class="text-center py-4 px-2 rounded-xl bg-white/[.07] border border-white/10 backdrop-blur-sm">
            <span class="block font-display font-bold text-orange leading-none text-[clamp(1.5rem,5vw,2rem)]">20+</span>
            <span class="block mt-1 text-[.72rem] text-white/60">ปีประสบการณ์</span>
          </div>
          <div class="text-center py-4 px-2 rounded-xl bg-white/[.07] border border-white/10 backdrop-blur-sm">
            <span class="block font-display font-bold text-orange leading-none text-[clamp(1.5rem,5vw,2rem)]">500+</span>
            <span class="block mt-1 text-[.72rem] text-white/60">ลูกค้าที่เคยบริการ</span>
          </div>
          <div class="text-center py-4 px-2 rounded-xl bg-white/[.07] border border-white/10 backdrop-blur-sm">
            <span class="block font-display font-bold text-orange leading-none text-[clamp(1.5rem,5vw,2rem)]">98%</span>
            <span class="block mt-1 text-[.72rem] text-white/60">ลูกค้าพึงพอใจ</span>
          </div>
        </div>
      </div>

      <div class="hidden md:flex justify-end" aria-hidden="true">
        <div class="relative overflow-hidden w-80 h-[380px] rounded-[20px] bg-white/5 border border-white/10 flex flex-col items-center justify-center gap-4">
          <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_30%,rgba(242,101,34,.15),transparent_70%)]"></div>
          <!-- <i class="bi bi-wind text-[5rem] text-white/20"></i>
          <span class="font-display text-xs tracking-[.12em] uppercase text-white/35">Industrial Vacuum System</span> -->
          <img src="{{ asset('storage/siriphong.jpg') }}" alt="Hero" class="w-full h-full object-cover" >
          <div class="absolute inset-0 bg-navy/50 mix-blend-multiply"></div>
          <div class="absolute bottom-5 right-5 w-3 h-3 rounded-full bg-line animate-status"></div>
        </div>
      </div>
    </div>
  </div>
</section>
