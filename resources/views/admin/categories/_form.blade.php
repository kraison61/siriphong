@php
    $editing = $category->exists;
@endphp

<form
    action="{{ $editing ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
    method="post"
    class="grid grid-cols-1 gap-4 p-5 text-zinc-900 md:grid-cols-2">
    @csrf
    @if ($editing)
        @method('PUT')
    @endif

    <input type="hidden" name="type" value="{{ old('type', $category->type ?? $type) }}">

    <div>
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">ชื่อหมวดหมู่</label>
        <input name="name" type="text" value="{{ old('name', $category->name) }}" placeholder="เช่น มอเตอร์"
            class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
        @error('name')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">Slug</label>
        <input name="slug" type="text" value="{{ old('slug', $category->slug) }}" placeholder="เว้นว่างเพื่อสร้างอัตโนมัติ"
            class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
        @error('slug')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">ลำดับ</label>
        <input name="sort_order" type="number" value="{{ old('sort_order', $category->sort_order ?? 0) }}" placeholder="0"
            class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
        @error('sort_order')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex flex-wrap gap-2 md:col-span-2">
        <button type="submit"
            class="min-w-32 rounded-lg bg-zinc-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-zinc-800">
            {{ $editing ? 'อัปเดตหมวดหมู่' : 'เพิ่มหมวดหมู่' }}
        </button>
        @if ($editing)
            <a href="{{ route('admin.categories.index', ['type' => $type]) }}"
                class="inline-flex min-w-24 items-center justify-center rounded-lg border border-zinc-300 bg-white px-4 py-2 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50">
                ยกเลิก
            </a>
        @endif
    </div>
</form>
