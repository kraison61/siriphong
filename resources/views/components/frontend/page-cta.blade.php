@props([
  'label' => 'สอบถามทางไลน์',
])

<div class="flex flex-wrap gap-3">
  <a href="{{ config('data.line') }}" target="_blank" rel="noopener"
    class="inline-flex items-center justify-center gap-2 min-h-[48px] px-6 py-2.5 rounded-xl font-bold text-white bg-line transition-all hover:bg-line-dark hover:-translate-y-0.5">
    <i class="bi bi-chat-dots-fill" aria-hidden="true"></i> {{ $label }}
  </a>
  <a href="tel:{{ config('data.phone') }}"
    class="inline-flex items-center justify-center gap-2 min-h-[48px] px-6 py-2.5 rounded-xl font-bold text-navy border border-navy/20 bg-white transition-all hover:border-orange hover:text-orange">
    <i class="bi bi-telephone-fill" aria-hidden="true"></i> โทร {{ config('data.phone_formatted') }}
  </a>
</div>
