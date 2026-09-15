<x-layouts.admin>
    <div class="space-y-8">
        <div>
            <h1 class="text-3xl font-bold">จัดการหน้าเนื้อหา (Pages)</h1>
            <p class="text-zinc-500">หน้าบริการ SEO แบบไดนามิก ตามโครงสร้าง Content Brief</p>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                <ul class="list-disc pl-4 space-y-1">
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
                        <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500">Page Form</p>
                        <h2 class="text-lg font-semibold text-zinc-900">
                            {{ $page->exists ? 'แก้ไขหน้า' : 'เพิ่มหน้าใหม่' }}
                        </h2>
                    </div>
                    @if ($page->exists)
                        <a href="{{ url($page->urlPath()) }}" target="_blank" rel="noopener"
                            class="rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-800 hover:bg-sky-200">
                            ดูหน้าเว็บ →
                        </a>
                    @endif
                </div>
            </div>

            @include('admin.pages._form', ['page' => $page, 'parents' => $parents])
        </div>

        <div class="overflow-x-auto rounded-2xl border border-zinc-200 bg-white shadow-sm">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-zinc-200 bg-zinc-50/80">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-zinc-700">ลำดับ</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">หัวข้อ</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">Slug / URL</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">Template</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">สถานะ</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($pages as $row)
                        <tr class="transition-colors hover:bg-zinc-50/70">
                            <td class="px-4 py-3 text-zinc-700">{{ $row->sort_order }}</td>
                            <td class="px-4 py-3 font-medium text-zinc-900">
                                {{ $row->title }}
                                @if ($row->parent)
                                    <span class="mt-0.5 block text-xs font-normal text-zinc-500">ลูกของ: {{ $row->parent->title }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-xs text-zinc-600 font-mono">{{ $row->urlPath() }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full bg-zinc-100 px-2.5 py-1 text-xs font-semibold text-zinc-700">{{ $row->template }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span
                                    class="{{ $row->is_published ? 'bg-emerald-100 text-emerald-700' : 'bg-zinc-200 text-zinc-700' }} inline-flex rounded-full px-2.5 py-1 text-xs font-semibold">
                                    {{ $row->is_published ? 'เผยแพร่' : 'ร่าง' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.pages.edit', $row) }}"
                                        class="rounded-md border border-zinc-300 px-3 py-1.5 text-xs font-semibold text-zinc-700 transition hover:bg-zinc-50">
                                        แก้ไข
                                    </a>
                                    <form action="{{ route('admin.pages.destroy', $row) }}" method="post"
                                        onsubmit="return confirm('ยืนยันการลบหน้านี้?')">
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
                            <td colspan="6" class="px-4 py-8 text-center text-zinc-500">ยังไม่มีหน้า — รัน PageSeeder หรือเพิ่มด้านบน</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="border-t border-zinc-200 px-4 py-3">{{ $pages->links() }}</div>
        </div>
    </div>
</x-layouts.admin>
