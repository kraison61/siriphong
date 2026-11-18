<section
  class="relative overflow-hidden py-14 md:py-20 md:pb-24 bg-[linear-gradient(160deg,#0f2347_0%,#1a3a6b_55%,#1e4a8a_100%)]"
  aria-labelledby="hero-title">
  <div
    class="pointer-events-none absolute inset-0 bg-[size:40px_40px] bg-[linear-gradient(rgba(255,255,255,.025)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,.025)_1px,transparent_1px)]">
  </div>
  <div class="absolute left-0 top-0 bottom-0 w-1 bg-[linear-gradient(to_bottom,#f26522,transparent)]"></div>

  <div class="relative w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
    <div class="md:grid md:grid-cols-[1fr_auto] md:gap-12 md:items-center">
      <div>
        <div
          class="animate-fade-down inline-flex items-center gap-2 mb-5 px-3.5 py-1.5 rounded-full bg-orange/15 border border-orange/40 text-sm font-semibold tracking-wide text-[#ffa070]">
          <i class="bi bi-patch-check-fill text-orange" aria-hidden="true"></i>
          ซ่อมมาตั้งแต่ปี {{ config('contact.founding_year_be') }} · ช่างต้อยซ่อมเองทุกเครื่อง
        </div>
        <h1
          class="animate-fade-up [animation-delay:.1s] font-display font-bold text-white leading-[1.15] mb-4 text-[clamp(1.7rem,5.5vw,3.1rem)]"
          id="hero-title">
          เครื่องดูดฝุ่นอุตสาหกรรม ซ่อม ขาย เช่า ทุกยี่ห้อ
        </h1>
        <p
          class="animate-fade-up [animation-delay:.2s] max-w-[640px] mb-8 leading-[1.7] text-white/[.78] text-[clamp(1rem,2.5vw,1.15rem)]">
          ศิริพงษ์ เซอร์วิส คือร้านซ่อมเครื่องดูดฝุ่นอุตสาหกรรมของช่างต้อย ที่ราษฎร์บูรณะ กรุงเทพฯ รับซ่อมเครื่องดูดฝุ่นโรงงาน เครื่องคาร์แคร์ และเครื่องดูดน้ำงานหนักทุกยี่ห้อ ค่าซ่อมประมาณ 300–8,000 บาท แจ้งราคาก่อนซ่อมทุกครั้ง พร้อมขายเครื่องและอะไหล่ และมีเครื่องสำรองให้เช่าระหว่างซ่อม แค่ส่งรูปเครื่องทาง LINE ช่างต้อยประเมินให้ฟรี
        </p>
        <div class="animate-fade-up [animation-delay:.3s] flex flex-col sm:flex-row gap-3">
          <a href="{{ config('contact.line') }}" target="_blank" rel="noopener"
            data-cta="line" data-position="hero" data-page="home"
            class="inline-flex items-center justify-center gap-2 min-h-[52px] px-7 py-3 rounded-xl font-bold text-white bg-line shadow-[0_4px_16px_rgba(6,199,85,.35)] transition-all hover:bg-line-dark hover:-translate-y-0.5"
            aria-label="ส่งรูปเครื่องทาง LINE ประเมินฟรี">
            <i class="bi bi-chat-dots-fill" aria-hidden="true"></i>
            ส่งรูปเครื่องทาง LINE ประเมินฟรี
          </a>
          <a href="tel:{{ config('contact.phone') }}"
            data-cta="tel" data-position="hero" data-page="home"
            class="inline-flex items-center justify-center gap-2 min-h-[52px] px-7 py-3 rounded-xl font-bold text-white bg-transparent border-2 border-white/55 transition-all hover:bg-white/10 hover:border-white"
            aria-label="โทรหาเรา {{ config('contact.phone_formatted') }}">
            <i class="bi bi-telephone-fill" aria-hidden="true"></i>
            {{ config('contact.phone_formatted') }}
          </a>
        </div>

        <div class="animate-fade-up [animation-delay:.4s] grid grid-cols-3 gap-3 mt-12" aria-label="สถิติผลงาน">
          <div class="text-center py-4 px-2 rounded-xl bg-white/[.07] border border-white/10 backdrop-blur-sm">
            <span class="block font-display font-bold text-orange leading-none text-[clamp(1.35rem,4vw,1.8rem)]">ตั้งแต่ปี {{ config('contact.founding_year_be') }}</span>
            <span class="block mt-1 text-[.72rem] text-white/60">{{ date('Y') + 543 - config('contact.founding_year_be') }} ปีบนโต๊ะซ่อม</span>
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

      <div class="mt-8 md:mt-0 flex justify-center md:justify-end">
        <div class="relative overflow-hidden w-full max-w-xs md:w-80 h-[320px] md:h-[380px] rounded-[20px] bg-white/5 border border-white/10">
          <img
            src="{{ media_url(config('data.hero_image')) }}"
            alt="เจ้าของร้านศิริพงษ์ เซอร์วิสกับเด็กสองคน"
            width="1279"
            height="1280"
            fetchpriority="high"
            decoding="async"
            class="w-full h-full object-cover">
          <div class="absolute inset-0 bg-navy/30 mix-blend-multiply pointer-events-none"></div>
          <div class="absolute bottom-5 right-5 w-3 h-3 rounded-full bg-line animate-status"></div>
        </div>
      </div>
    </div>
  </div>
</section>
