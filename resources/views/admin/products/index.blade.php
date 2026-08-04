<x-layouts.admin>
    <div class="space-y-8">
        <div>
            <h1 class="text-3xl font-bold">จัดการสินค้าและบริการ</h1>
            <p class="text-zinc-500">เพิ่ม แก้ไข และลบรายการสินค้า/บริการ</p>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.products.index', ['type' => 'product']) }}"
                class="rounded-lg px-4 py-2 text-sm font-semibold transition {{ $type === 'product' ? 'bg-zinc-900 text-white' : 'border border-zinc-300 text-zinc-700 hover:bg-zinc-50' }}">
                สินค้า
            </a>
            <a href="{{ route('admin.products.index', ['type' => 'service']) }}"
                class="rounded-lg px-4 py-2 text-sm font-semibold transition {{ $type === 'service' ? 'bg-zinc-900 text-white' : 'border border-zinc-300 text-zinc-700 hover:bg-zinc-50' }}">
                บริการ
            </a>
            <a href="{{ route('admin.categories.index', ['type' => $type]) }}"
                class="ml-auto rounded-lg border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50">
                จัดการหมวดหมู่
            </a>
        </div>

        <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm">
            <div class="border-b border-zinc-200 bg-gradient-to-r from-zinc-50 to-white px-5 py-4">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500">
                            {{ $type === 'service' ? 'Service Form' : 'Product Form' }}
                        </p>
                        <h2 class="text-lg font-semibold text-zinc-900">
                            @if ($product->exists)
                                แก้ไข{{ $type === 'service' ? 'บริการ' : 'สินค้า' }}
                            @else
                                เพิ่ม{{ $type === 'service' ? 'บริการ' : 'สินค้า' }}ใหม่
                            @endif
                        </h2>
                    </div>
                    @if ($product->exists)
                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">
                            Editing #{{ $product->id }}
                        </span>
                    @endif
                </div>
            </div>

            @include('admin.products._form', [
                'product' => $product,
                'type' => $type,
                'categories' => $categories,
            ])
        </div>

        <div class="overflow-x-auto rounded-2xl border border-zinc-200 bg-white shadow-sm">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-zinc-200 bg-zinc-50/80">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-zinc-700">ID</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">ชื่อ</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">หมวดหมู่</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">ราคา</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">สถานะ</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">แนะนำ</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($products as $row)
                        <tr class="transition-colors hover:bg-zinc-50/70">
                            <td class="px-4 py-3 font-medium text-zinc-700">
                                #{{ str_pad((string) $row->id, 3, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-zinc-900">{{ $row->name }}</div>
                                <div class="text-xs text-zinc-500">{{ $row->slug }}</div>
                            </td>
                            <td class="px-4 py-3 text-zinc-700">{{ $row->category?->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-zinc-700">{{ $row->priceLabel() }}</td>
                            <td class="px-4 py-3">
                                <span
                                    class="{{ $row->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-zinc-200 text-zinc-700' }} inline-flex rounded-full px-2.5 py-1 text-xs font-semibold">
                                    {{ $row->is_active ? 'แสดง' : 'ซ่อน' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span
                                    class="{{ $row->is_featured ? 'bg-amber-100 text-amber-700' : 'bg-zinc-100 text-zinc-600' }} inline-flex rounded-full px-2.5 py-1 text-xs font-semibold">
                                    {{ $row->is_featured ? 'แนะนำ' : '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.products.edit', ['product' => $row, 'type' => $type]) }}"
                                        class="rounded-md border border-zinc-300 px-3 py-1.5 text-xs font-semibold text-zinc-700 transition hover:bg-zinc-50">
                                        แก้ไข
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $row) }}" method="post"
                                        onsubmit="return confirm('ยืนยันการลบรายการนี้?')">
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
                            <td colspan="7" class="px-4 py-10 text-center text-zinc-500">
                                ยังไม่มี{{ $type === 'service' ? 'บริการ' : 'สินค้า' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="border-t border-zinc-200 p-4">
                {{ $products->appends(['type' => $type])->links() }}
            </div>
        </div>
    </div>
</x-layouts.admin>
