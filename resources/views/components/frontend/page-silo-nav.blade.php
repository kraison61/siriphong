@props(['children'])

@if ($children->isNotEmpty())
<section class="py-10 bg-white border-b border-slate-100" aria-label="บริการในหมวดนี้">
  <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
    <p class="font-display text-xs font-semibold tracking-[.14em] uppercase text-orange mb-4">ในหมวดนี้</p>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
      @foreach ($children as $child)
        <a href="{{ url($child->urlPath()) }}"
          class="group flex items-start gap-3 rounded-xl border border-slate-200 bg-offwhite/50 p-4 transition-all hover:border-orange hover:bg-white hover:-translate-y-0.5">
          <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-navy text-white group-hover:bg-orange transition-colors">
            <i class="bi bi-arrow-right" aria-hidden="true"></i>
          </span>
          <span>
            <span class="block font-display font-bold text-navy group-hover:text-orange transition-colors">{{ $child->title }}</span>
            @if ($child->intro)
              <span class="mt-1 block text-sm text-slate-600 line-clamp-2">{{ \Illuminate\Support\Str::before($child->intro, "\n") }}</span>
            @endif
          </span>
        </a>
      @endforeach
    </div>
  </div>
</section>
@endif
