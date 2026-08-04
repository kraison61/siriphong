<section class="py-14 bg-offwhite" id="faq" aria-labelledby="faq-title">
  <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
    <div class="mb-8">
      <div class="font-display text-xs font-semibold tracking-[.14em] uppercase text-orange">
        <i class="bi bi-question-circle" aria-hidden="true"></i> คำถามที่พบบ่อย
      </div>
      <h2 class="font-display font-bold leading-tight text-navy mt-2 text-[clamp(1.4rem,3.5vw,2rem)]" id="faq-title">
        FAQ
      </h2>
    </div>

    <div class="space-y-3">
      @foreach ($faqs as $faq)
        <details class="group rounded-xl bg-white border border-slate-200 p-5 shadow-sm">
          <summary class="cursor-pointer font-semibold text-navy list-none flex items-center justify-between gap-4">
            <span>{{ $faq->question }}</span>
            <i class="bi bi-chevron-down text-orange transition-transform group-open:rotate-180" aria-hidden="true"></i>
          </summary>
          <p class="mt-4 text-sm text-slate-600 leading-relaxed">{{ $faq->answer }}</p>
        </details>
      @endforeach
    </div>
  </div>
</section>
