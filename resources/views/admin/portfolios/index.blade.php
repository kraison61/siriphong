<x-layouts.admin>
    <div class="space-y-8">
        <div>
            <h1 class="text-3xl font-bold">จัดการผลงาน (Portfolio)</h1>
            <p class="text-zinc-500">เพิ่ม แก้ไข และลบรายการผลงาน — ข้อมูลเคสจริงจะแสดงบนหน้า /portfolio</p>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                <p class="font-semibold">กรุณาตรวจสอบฟอร์ม</p>
                <ul class="mt-1 list-inside list-disc text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm">
            <div class="border-b border-zinc-200 bg-gradient-to-r from-zinc-50 to-white px-5 py-4">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500">Portfolio Form</p>
                        <h2 class="text-lg font-semibold text-zinc-900">
                            {{ $portfolio->exists ? 'แก้ไขผลงาน' : 'เพิ่มผลงานใหม่' }}
                        </h2>
                    </div>
                    @if ($portfolio->exists)
                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">
                            Editing #{{ $portfolio->id }}
                        </span>
                    @endif
                </div>
            </div>

            @include('admin.portfolios._form', ['portfolio' => $portfolio])
        </div>

        <div class="overflow-x-auto rounded-2xl border border-zinc-200 bg-white shadow-sm">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-zinc-200 bg-zinc-50/80">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-zinc-700">ID</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">รูป</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">หัวข้อ</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">เนื้อหา</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">ราคา</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">สถานะ</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($portfolios as $row)
                        @php
                            $beforeThumb = $row->beforeImageUrl();
                            $afterThumb = $row->afterImageUrl();
                            $coverThumb = \App\Support\MediaUrl::resolve($row->image) ?: $afterThumb ?: $beforeThumb;
                        @endphp
                        <tr class="transition-colors hover:bg-zinc-50/70">
                            <td class="px-4 py-3 font-medium text-zinc-700">
                                #{{ str_pad((string) $row->id, 3, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-1.5">
                                    @if ($beforeThumb)
                                        <img src="{{ $beforeThumb }}" alt="" class="h-10 w-10 rounded-md object-cover border border-zinc-200" title="ก่อน">
                                    @endif
                                    @if ($afterThumb && $afterThumb !== $beforeThumb)
                                        <img src="{{ $afterThumb }}" alt="" class="h-10 w-10 rounded-md object-cover border border-zinc-200" title="หลัง">
                                    @elseif ($coverThumb && ! $beforeThumb)
                                        <img src="{{ $coverThumb }}" alt="" class="h-10 w-10 rounded-md object-cover border border-zinc-200">
                                    @elseif (! $beforeThumb && ! $afterThumb)
                                        <span class="text-xs text-zinc-400">—</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-zinc-900 line-clamp-2 max-w-xs">{{ $row->title }}</div>
                                <div class="mt-0.5 text-xs text-zinc-500">
                                    {{ $row->category?->name ?: $row->category_label ?: '—' }}
                                    @if ($row->category_label && $row->category?->name && $row->category_label !== $row->category->name)
                                        · {{ $row->category_label }}
                                    @endif
                                    @if ($row->slug)
                                        · <a href="{{ url($row->urlPath()) }}" target="_blank" class="text-orange-600 hover:underline">/portfolio/{{ $row->slug }}</a>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 text-zinc-600 text-xs max-w-[12rem]">
                                @if (filled($row->content))
                                    <span class="line-clamp-2">{{ \Illuminate\Support\Str::limit(strip_tags($row->content), 80) }}</span>
                                @else
                                    <span class="text-zinc-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-zinc-700 whitespace-nowrap">{{ $row->price ?: '—' }}</td>
                            <td class="px-4 py-3">
                                <span
                                    class="{{ $row->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-zinc-200 text-zinc-700' }} inline-flex rounded-full px-2.5 py-1 text-xs font-semibold">
                                    {{ $row->is_active ? 'แสดง' : 'ซ่อน' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.portfolios.edit', $row) }}"
                                        class="rounded-md border border-zinc-300 px-3 py-1.5 text-xs font-semibold text-zinc-700 transition hover:bg-zinc-50">
                                        แก้ไข
                                    </a>
                                    <form action="{{ route('admin.portfolios.destroy', $row) }}" method="post"
                                        onsubmit="return confirm('ยืนยันการลบผลงานนี้?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="rounded-md bg-red-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-red-500">
                                            ลบ
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-zinc-500">ยังไม่มีข้อมูลผลงาน</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="border-t border-zinc-200 p-4">
                {{ $portfolios->links() }}
            </div>
        </div>
    </div>
</x-layouts.admin>
