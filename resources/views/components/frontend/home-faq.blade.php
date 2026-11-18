<section class="py-14 bg-offwhite" id="faq" aria-labelledby="faq-title">
  <div class="w-full max-w-[800px] mx-auto px-4 md:px-6 xl:px-8">
    <h2 id="faq-title" class="font-display font-bold leading-tight text-navy text-[clamp(1.6rem,4vw,2.4rem)]">
      คำถามที่พบบ่อยเกี่ยวกับเครื่องดูดฝุ่นอุตสาหกรรม
    </h2>
    <div class="mt-8 flex flex-col gap-3">
      @foreach (config('home.faqs') as $faq)
        <details class="group rounded-xl bg-white border border-slate-200 px-5 py-4">
          <summary class="cursor-pointer list-none">
            <h3 class="text-base font-display font-bold text-navy flex items-start justify-between gap-4">
              <span>{{ $faq['question'] }}</span>
              <i class="bi bi-plus-lg text-orange shrink-0 mt-1 group-open:hidden" aria-hidden="true"></i>
              <i class="bi bi-dash-lg text-orange shrink-0 mt-1 hidden group-open:inline" aria-hidden="true"></i>
            </h3>
          </summary>
          <p class="mt-3 text-sm text-slate-600 leading-relaxed">{{ $faq['answer'] }}</p>
        </details>
      @endforeach
    </div>
  </div>
</section>
