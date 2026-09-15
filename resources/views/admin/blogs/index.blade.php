<x-layouts.admin>
    <div class="space-y-8">
        <div>
            <h1 class="text-3xl font-bold">จัดการบทความ (Blog)</h1>
            <p class="text-zinc-500">เพิ่ม แก้ไข และลบบทความ — ใช้สำหรับเนื้อหา SEO และอัปเดตข่าวสาร</p>
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
                        <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500">Blog Form</p>
                        <h2 class="text-lg font-semibold text-zinc-900">
                            {{ $blog->exists ? 'แก้ไขบทความ' : 'เพิ่มบทความใหม่' }}
                        </h2>
                    </div>
                    @if ($blog->exists)
                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">
                            Editing #{{ $blog->id }}
                        </span>
                    @endif
                </div>
            </div>

            @include('admin.blogs._form', ['blog' => $blog])
        </div>

        <div class="overflow-x-auto rounded-2xl border border-zinc-200 bg-white shadow-sm">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-zinc-200 bg-zinc-50/80">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-zinc-700">ID</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">หัวข้อ</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">Slug</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">ลำดับ</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">สถานะ</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">เผยแพร่เมื่อ</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($blogs as $row)
                        <tr class="transition-colors hover:bg-zinc-50/70">
                            <td class="px-4 py-3 font-medium text-zinc-700">
                                #{{ str_pad((string) $row->id, 3, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-zinc-900 line-clamp-2 max-w-xs">{{ $row->title }}</div>
                                @if ($row->excerpt)
                                    <div class="mt-0.5 text-xs text-zinc-500 line-clamp-1 max-w-xs">{{ $row->excerpt }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-mono text-xs text-zinc-600">{{ $row->slug }}</td>
                            <td class="px-4 py-3 font-medium text-zinc-700">{{ $row->sort_order }}</td>
                            <td class="px-4 py-3">
                                <span
                                    class="{{ $row->is_published ? 'bg-emerald-100 text-emerald-700' : 'bg-zinc-200 text-zinc-700' }} inline-flex rounded-full px-2.5 py-1 text-xs font-semibold">
                                    {{ $row->is_published ? 'เผยแพร่' : 'ฉบับร่าง' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-zinc-700 whitespace-nowrap">
                                {{ $row->published_at?->format('d/m/Y H:i') ?: '—' }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.blogs.edit', $row) }}"
                                        class="rounded-md border border-zinc-300 px-3 py-1.5 text-xs font-semibold text-zinc-700 transition hover:bg-zinc-50">
                                        แก้ไข
                                    </a>
                                    <form action="{{ route('admin.blogs.destroy', $row) }}" method="post"
                                        onsubmit="return confirm('ยืนยันการลบบทความนี้?')">
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
                            <td colspan="7" class="px-4 py-10 text-center text-zinc-500">ยังไม่มีบทความ</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="border-t border-zinc-200 p-4">
                {{ $blogs->links() }}
            </div>
        </div>
    </div>
</x-layouts.admin>
