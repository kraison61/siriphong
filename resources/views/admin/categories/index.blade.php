<x-layouts.admin>
    <div class="space-y-8">
        <div>
            <h1 class="text-3xl font-bold">จัดการหมวดหมู่</h1>
            <p class="text-zinc-500">หมวดหมู่สินค้าและบริการ</p>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex gap-2">
            <a href="{{ route('admin.categories.index', ['type' => 'product']) }}"
                class="rounded-lg px-4 py-2 text-sm font-semibold transition {{ $type === 'product' ? 'bg-zinc-900 text-white' : 'border border-zinc-300 text-zinc-700 hover:bg-zinc-50' }}">
                หมวดหมู่สินค้า
            </a>
            <a href="{{ route('admin.categories.index', ['type' => 'service']) }}"
                class="rounded-lg px-4 py-2 text-sm font-semibold transition {{ $type === 'service' ? 'bg-zinc-900 text-white' : 'border border-zinc-300 text-zinc-700 hover:bg-zinc-50' }}">
                หมวดหมู่บริการ
            </a>
        </div>

        <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm">
            <div class="border-b border-zinc-200 bg-gradient-to-r from-zinc-50 to-white px-5 py-4">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500">Category Form</p>
                        <h2 class="text-lg font-semibold text-zinc-900">
                            {{ $category->exists ? 'แก้ไขหมวดหมู่' : 'เพิ่มหมวดหมู่ใหม่' }}
                        </h2>
                    </div>
                    @if ($category->exists)
                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">
                            Editing #{{ $category->id }}
                        </span>
                    @endif
                </div>
            </div>

            @include('admin.categories._form', ['category' => $category, 'type' => $type])
        </div>

        <div class="overflow-x-auto rounded-2xl border border-zinc-200 bg-white shadow-sm">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-zinc-200 bg-zinc-50/80">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-zinc-700">ID</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">ชื่อ</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">Slug</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">ประเภท</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">ลำดับ</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($categories as $row)
                        <tr class="transition-colors hover:bg-zinc-50/70">
                            <td class="px-4 py-3 font-medium text-zinc-700">
                                #{{ str_pad((string) $row->id, 3, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-4 py-3 font-medium text-zinc-900">{{ $row->name }}</td>
                            <td class="px-4 py-3 text-zinc-600">{{ $row->slug }}</td>
                            <td class="px-4 py-3">
                                <span
                                    class="{{ $row->type === 'product' ? 'bg-blue-100 text-blue-700' : 'bg-violet-100 text-violet-700' }} inline-flex rounded-full px-2.5 py-1 text-xs font-semibold">
                                    {{ $row->type === 'product' ? 'สินค้า' : 'บริการ' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-medium text-zinc-700">{{ $row->sort_order }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.categories.edit', ['category' => $row, 'type' => $type]) }}"
                                        class="rounded-md border border-zinc-300 px-3 py-1.5 text-xs font-semibold text-zinc-700 transition hover:bg-zinc-50">
                                        แก้ไข
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $row) }}" method="post"
                                        onsubmit="return confirm('ยืนยันการลบหมวดหมู่นี้?')">
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
                            <td colspan="6" class="px-4 py-10 text-center text-zinc-500">ยังไม่มีหมวดหมู่</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="border-t border-zinc-200 p-4">
                {{ $categories->appends(['type' => $type])->links() }}
            </div>
        </div>
    </div>
</x-layouts.admin>
