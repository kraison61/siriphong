@php
    $editing = $portfolio->exists;
@endphp

<form
    action="{{ $editing ? route('admin.portfolios.update', $portfolio) : route('admin.portfolios.store') }}"
    method="post"
    enctype="multipart/form-data"
    class="grid grid-cols-1 gap-4 p-5 text-zinc-900 md:grid-cols-2">
    @csrf
    @if ($editing)
        @method('PUT')
    @endif

    <div>
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">หมวดหมู่</label>
        <input name="category_label" type="text" value="{{ old('category_label', $portfolio->category_label) }}"
            placeholder="เช่น โรงงาน / บ้านพักอาศัย"
            class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
        @error('category_label')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">หัวข้อผลงาน</label>
        <input name="title" type="text" value="{{ old('title', $portfolio->title) }}" placeholder="ชื่อเคสงานซ่อม"
            class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
        @error('title')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">รายละเอียด</label>
        <textarea name="description" rows="3" placeholder="รายละเอียดงานซ่อม"
            class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10">{{ old('description', $portfolio->description) }}</textarea>
        @error('description')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">แบรนด์</label>
        <input name="brands" type="text" value="{{ old('brands', $portfolio->brands) }}"
            placeholder="เช่น Karcher, Nilfisk"
            class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
        @error('brands')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">รูปภาพ</label>
        @if ($editing && $portfolio->imageUrl())
            <div class="mb-3 flex items-start gap-4">
                <img src="{{ $portfolio->imageUrl() }}" alt="{{ $portfolio->title }}"
                    class="h-32 w-auto rounded-lg border border-zinc-200 object-cover">
                <p class="text-xs text-zinc-500">รูปปัจจุบัน: {{ $portfolio->image }}</p>
            </div>
        @endif
        <input name="image_file" type="file" accept="image/jpeg,image/png,image/webp"
            class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 file:mr-3 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-zinc-700 hover:file:bg-zinc-200 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
        <p class="mt-1.5 text-xs text-zinc-500">รองรับ JPG, PNG, WEBP ขนาดไม่เกิน 5 MB{{ $editing ? ' — ไม่เลือกไฟล์จะใช้รูปเดิม' : '' }}</p>
        @error('image_file')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">ปี</label>
        <input name="year" type="text" value="{{ old('year', $portfolio->year) }}" placeholder="2026"
            class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
        @error('year')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">ระยะเวลา</label>
        <input name="duration" type="text" value="{{ old('duration', $portfolio->duration) }}" placeholder="3 วัน"
            class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
        @error('duration')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">สถานะ</label>
        <input name="status_label" type="text" value="{{ old('status_label', $portfolio->status_label) }}"
            placeholder="สำเร็จ"
            class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
        @error('status_label')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">ลำดับ</label>
        <input name="sort_order" type="number" value="{{ old('sort_order', $portfolio->sort_order) }}" placeholder="0"
            class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
        @error('sort_order')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">การแสดงผล</label>
        <select name="is_active"
            class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm font-semibold text-zinc-900 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10">
            <option value="1" @selected(old('is_active', $portfolio->is_active ? '1' : '0') == '1')>แสดง</option>
            <option value="0" @selected(old('is_active', $portfolio->is_active ? '1' : '0') == '0')>ซ่อน</option>
        </select>
        @error('is_active')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">พิกัด Google Map (Latitude, Longitude)</label>
        <input name="map_coordinates" type="text" value="{{ old('map_coordinates', $portfolio->map_coordinates) }}"
            placeholder="13.754198, 100.501705"
            class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
        @error('map_coordinates')
            <p class="mt-1 text-xs text-red-600">กรุณากรอกในรูปแบบ 13.754198, 100.501705</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <p class="text-xs font-medium text-zinc-700">
            * รายการที่ลำดับน้อยกว่า จะแสดงก่อนในหน้าเว็บไซต์ และพิกัดจะถูกนำไปใช้อ้างอิง JSON-LD schema
        </p>
    </div>

    <div class="flex flex-wrap gap-2 md:col-span-2">
        <button type="submit"
            class="min-w-32 rounded-lg bg-zinc-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-zinc-800">
            {{ $editing ? 'อัปเดตผลงาน' : 'เพิ่มผลงาน' }}
        </button>
        @if ($editing)
            <a href="{{ route('admin.portfolios.index') }}"
                class="inline-flex min-w-24 items-center justify-center rounded-lg border border-zinc-300 bg-white px-4 py-2 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50">
                ยกเลิก
            </a>
        @endif
    </div>
</form>
