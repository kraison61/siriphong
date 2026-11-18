@php $pageName = request()->routeIs('home') ? 'home' : 'site'; @endphp
<div class="md:hidden fixed bottom-0 inset-x-0 z-[200] flex gap-2.5 px-4 py-2.5 bg-navy border-t border-white/10 shadow-[0_-4px_20px_rgba(0,0,0,.25)]" role="complementary" aria-label="ติดต่อด่วน">
  <a href="{{ config('contact.line') }}" target="_blank" rel="noopener" data-cta="line" data-position="sticky" data-page="{{ $pageName }}" class="flex-1 inline-flex items-center justify-center gap-2 min-h-[52px] px-4 py-3 rounded-xl font-bold text-white bg-line shadow-[0_4px_16px_rgba(6,199,85,.35)] transition-all hover:bg-line-dark" aria-label="LINE ส่งรูปประเมินฟรี">
    <i class="bi bi-chat-dots-fill" aria-hidden="true"></i>
    LINE ส่งรูปประเมินฟรี
  </a>
  <a href="tel:{{ config('contact.phone') }}" data-cta="tel" data-position="sticky" data-page="{{ $pageName }}" class="shrink-0 inline-flex items-center justify-center gap-2 min-h-[52px] px-4 rounded-xl font-bold text-white bg-white/10 border border-white/15 transition-colors hover:bg-white/[.18]" aria-label="โทร {{ config('contact.phone_formatted') }}">
    <i class="bi bi-telephone-fill" aria-hidden="true"></i>
    โทร
  </a>
</div>
