@php
    $editing = $product->exists;
    $currentIcon = old('image_icon', ($product->image && str_starts_with($product->image, 'bi ')) ? $product->image : '');
@endphp

<form
    action="{{ $editing ? route('admin.products.update', $product) : route('admin.products.store') }}"
    method="post"
    enctype="multipart/form-data"
    class="grid grid-cols-1 gap-4 p-5 text-zinc-900 md:grid-cols-2">
    @csrf
    @if ($editing)
        @method('PUT')
    @endif

    <input type="hidden" name="type" value="{{ old('type', $product->type ?? $type) }}">

    <div>
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">หมวดหมู่</label>
        <select name="category_id"
            class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm font-semibold text-zinc-900 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10">
            <option value="">— ไม่ระบุ —</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">ชื่อ{{ $type === 'service' ? 'บริการ' : 'สินค้า' }}</label>
        <input name="name" type="text" value="{{ old('name', $product->name) }}" placeholder="ชื่อรายการ"
            class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
        @error('name')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">Slug</label>
        <input name="slug" type="text" value="{{ old('slug', $product->slug) }}" placeholder="เว้นว่างเพื่อสร้างอัตโนมัติ"
            class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
        @error('slug')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">คำอธิบายสั้น</label>
        <textarea name="short_description" rows="2" placeholder="แสดงบนการ์ดหน้าเว็บ"
            class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10">{{ old('short_description', $product->short_description) }}</textarea>
        @error('short_description')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">รายละเอียด</label>
        <textarea name="description" rows="4" placeholder="รายละเอียดเต็ม"
            class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10">{{ old('description', $product->description) }}</textarea>
        @error('description')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">รูปภาพหลัก</label>
        @if ($editing && $product->imageUrl())
            <div class="mb-3 flex items-start gap-4">
                <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}"
                    class="h-32 w-auto rounded-lg border border-zinc-200 object-cover">
                <p class="text-xs text-zinc-500">รูปปัจจุบัน: {{ $product->image }}</p>
            </div>
        @elseif ($editing && $product->image && str_starts_with($product->image, 'bi '))
            <div class="mb-3 flex items-center gap-3 rounded-lg border border-zinc-200 bg-zinc-50 px-4 py-3">
                <i class="{{ $product->image }} text-3xl text-zinc-700" aria-hidden="true"></i>
                <p class="text-xs text-zinc-500">ไอคอนปัจจุบัน: {{ $product->image }}</p>
            </div>
        @endif
        <input name="image_file" type="file" accept="image/jpeg,image/png,image/webp"
            class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 file:mr-3 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-zinc-700 hover:file:bg-zinc-200 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
        <p class="mt-1.5 text-xs text-zinc-500">รองรับ JPG, PNG, WEBP ขนาดไม่เกิน 5 MB{{ $editing ? ' — ไม่เลือกไฟล์จะใช้รูปเดิม' : '' }}</p>
        @error('image_file')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">ไอคอน Bootstrap (ทางเลือก)</label>
        <input name="image_icon" type="text" value="{{ $currentIcon }}" placeholder="เช่น bi bi-tools"
            class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
        <p class="mt-1.5 text-xs text-zinc-500">ใช้แทนรูปภาพได้ เช่น <code class="text-zinc-700">bi bi-wrench-adjustable</code> — ถ้าอัปโหลดรูป จะใช้รูปแทนไอคอน</p>
        @error('image_icon')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">ราคา (บาท)</label>
        <input name="price" type="number" step="0.01" min="0" value="{{ old('price', $product->price ?? 0) }}" placeholder="0 = ติดต่อขอราคา"
            class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
        @error('price')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">ราคาพิเศษ (บาท)</label>
        <input name="sale_price" type="number" step="0.01" min="0" value="{{ old('sale_price', $product->sale_price) }}" placeholder="เว้นว่างถ้าไม่มี"
            class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
        @error('sale_price')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">การแสดงผล</label>
        <select name="is_active"
            class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm font-semibold text-zinc-900 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10">
            <option value="1" @selected(old('is_active', $product->is_active ? '1' : '0') == '1')>แสดง</option>
            <option value="0" @selected(old('is_active', $product->is_active ? '1' : '0') == '0')>ซ่อน</option>
        </select>
        @error('is_active')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">แนะนำ (Featured)</label>
        <select name="is_featured"
            class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm font-semibold text-zinc-900 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10">
            <option value="0" @selected(old('is_featured', $product->is_featured ? '1' : '0') == '0')>ไม่แนะนำ</option>
            <option value="1" @selected(old('is_featured', $product->is_featured ? '1' : '0') == '1')>แนะนำ</option>
        </select>
        @error('is_featured')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">Meta Title</label>
        <input name="meta_title" type="text" value="{{ old('meta_title', $product->meta_title) }}"
            class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
        @error('meta_title')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">Meta Description</label>
        <input name="meta_description" type="text" value="{{ old('meta_description', $product->meta_description) }}"
            class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
        @error('meta_description')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    @if ($editing && $product->images->isNotEmpty())
        <div class="md:col-span-2">
            <label class="mb-1.5 block text-sm font-medium text-zinc-700">รูปแกลเลอรี</label>
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4">
                @foreach ($product->images as $galleryImage)
                    <label class="group relative overflow-hidden rounded-lg border border-zinc-200">
                        <img src="{{ $galleryImage->url() }}" alt="{{ $galleryImage->alt }}"
                            class="aspect-square w-full object-cover">
                        <div class="absolute inset-x-0 bottom-0 bg-black/60 px-2 py-1.5">
                            <span class="flex items-center gap-2 text-xs text-white">
                                <input type="checkbox" name="delete_gallery_ids[]" value="{{ $galleryImage->id }}"
                                    class="rounded border-zinc-300">
                                ลบ
                            </span>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>
    @endif

    <div class="md:col-span-2">
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">เพิ่มรูปแกลเลอรี</label>
        <input name="gallery_files[]" type="file" accept="image/jpeg,image/png,image/webp" multiple
            class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 file:mr-3 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-zinc-700 hover:file:bg-zinc-200 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
        <p class="mt-1.5 text-xs text-zinc-500">เลือกได้หลายไฟล์ สำหรับสินค้าที่มีรูปเพิ่มเติม</p>
        @error('gallery_files')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
        @error('gallery_files.*')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex flex-wrap gap-2 md:col-span-2">
        <button type="submit"
            class="min-w-32 rounded-lg bg-zinc-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-zinc-800">
            {{ $editing ? 'อัปเดต' : 'เพิ่ม' }}{{ $type === 'service' ? 'บริการ' : 'สินค้า' }}
        </button>
        @if ($editing)
            <a href="{{ route('admin.products.index', ['type' => $type]) }}"
                class="inline-flex min-w-24 items-center justify-center rounded-lg border border-zinc-300 bg-white px-4 py-2 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50">
                ยกเลิก
            </a>
        @endif
    </div>
</form>
