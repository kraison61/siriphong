@php
    $editing = $portfolio->exists;
    $input = 'w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10';
@endphp

<form
    action="{{ $editing ? route('admin.portfolios.update', $portfolio) : route('admin.portfolios.store') }}"
    method="post"
    enctype="multipart/form-data"
    class="space-y-6 p-5 text-zinc-900">
    @csrf
    @if ($editing)
        @method('PUT')
    @endif

    {{-- ข้อมูลหลัก --}}
    <section class="space-y-4">
        <div>
            <h3 class="text-sm font-semibold text-zinc-900">ข้อมูลหลัก</h3>
            <p class="mt-0.5 text-xs text-zinc-500">หัวข้อและหมวดที่แสดงบนหน้าผลงาน</p>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="md:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">หัวข้อผลงาน <span class="text-red-500">*</span></label>
                <input name="title" type="text" value="{{ old('title', $portfolio->title) }}"
                    placeholder="เช่น ซ่อมมอเตอร์ Nilfisk หลังใช้งานต่อเนื่อง"
                    class="{{ $input }}" required>
                @error('title')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">Slug (หน้าเคส)</label>
                <input name="slug" type="text" value="{{ old('slug', $portfolio->slug) }}"
                    placeholder="เช่น vacuum-repair-cat-cafe-silom"
                    class="{{ $input }}">
                <p class="mt-1 text-xs text-zinc-500">ถ้ากรอก จะมีหน้า /portfolio/{slug} แยกจากหน้าแกลเลอรี</p>
                @error('slug')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">หมวดหมู่ <span class="text-red-500">*</span></label>
                <select name="category_id" class="{{ $input }}" required>
                    <option value="">เลือกหมวดหมู่ผลงาน</option>
                    @foreach ($categories ?? [] as $category)
                        <option value="{{ $category->id }}" @selected((string) old('category_id', $portfolio->category_id) === (string) $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-zinc-500">ใช้กรองบนหน้า /portfolio — จัดการที่ <a href="{{ route('admin.categories.index', ['type' => 'portfolio']) }}" class="underline hover:text-zinc-800">หมวดหมู่ผลงาน</a></p>
                @error('category_id')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">ป้ายลูกค้า / สถานที่ (ไม่บังคับ)</label>
                <input name="category_label" type="text" value="{{ old('category_label', $portfolio->category_label) }}"
                    placeholder="เช่น iCarWash / คอนโดมิเนียมสีลม"
                    class="{{ $input }}">
                <p class="mt-1 text-xs text-zinc-500">แสดงรายละเอียดเพิ่มบนการ์ดถ้าต้องการเจาะจงกว่าหมวดหมู่</p>
                @error('category_label')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">แบรนด์ / รุ่น</label>
                <input name="brands" type="text" value="{{ old('brands', $portfolio->brands) }}"
                    placeholder="เช่น Karcher, Nilfisk"
                    class="{{ $input }}">
                @error('brands')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">สรุปรายละเอียด (ไม่บังคับ)</label>
                <textarea name="description" rows="2" placeholder="ข้อความสรุปสั้น ๆ แสดงในแกลเลอรีและส่วนหัวหน้าเคส"
                    class="{{ $input }}">{{ old('description', $portfolio->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">เนื้อหาหน้าเคส (HTML)</label>
                <textarea name="content" rows="10" placeholder="รายละเอียดยาวสำหรับหน้า /portfolio/{slug} — รองรับ HTML เช่น &lt;p&gt; &lt;h2&gt; &lt;ul&gt;"
                    class="{{ $input }} font-mono text-xs leading-relaxed">{{ old('content', $portfolio->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>

    <hr class="border-zinc-200">

    {{-- รายละเอียดเคสจริง --}}
    <section class="space-y-4">
        <div>
            <h3 class="text-sm font-semibold text-zinc-900">รายละเอียดเคสจริง</h3>
            <p class="mt-0.5 text-xs text-zinc-500">แสดงใน section เคสจริงบนหน้าเว็บ — กรอกให้ครบจะอ่านง่ายกว่า</p>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">อาการเสีย</label>
                <input name="fault" type="text" value="{{ old('fault', $portfolio->fault) }}"
                    placeholder="เช่น มอเตอร์ไหม้ / แรงดูดตก / สายไฟช็อต"
                    class="{{ $input }}">
                @error('fault')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">อาการที่ลูกค้าแจ้ง</label>
                <textarea name="symptom" rows="2" placeholder="ลูกค้าบอกอาการอย่างไรก่อนส่งซ่อม"
                    class="{{ $input }}">{{ old('symptom', $portfolio->symptom) }}</textarea>
                @error('symptom')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">สิ่งที่ตรวจเจอ</label>
                <textarea name="found" rows="2" placeholder="ผลตรวจหน้างานหรือในร้าน"
                    class="{{ $input }}">{{ old('found', $portfolio->found) }}</textarea>
                @error('found')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">สิ่งที่เปลี่ยน / ซ่อม</label>
                <textarea name="fixed" rows="2" placeholder="งานที่ทำและอะไหล่ที่เปลี่ยน"
                    class="{{ $input }}">{{ old('fixed', $portfolio->fixed) }}</textarea>
                @error('fixed')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">ระยะเวลาซ่อม</label>
                <input name="duration" type="text" value="{{ old('duration', $portfolio->duration) }}"
                    placeholder="เช่น 1–2 วัน"
                    class="{{ $input }}">
                @error('duration')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">ราคา</label>
                <input name="price" type="text" value="{{ old('price', $portfolio->price) }}"
                    placeholder="เช่น ประมาณ 4,200 บาท"
                    class="{{ $input }}">
                @error('price')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">ปีที่ซ่อม</label>
                <input name="year" type="text" value="{{ old('year', $portfolio->year) }}"
                    placeholder="เช่น 2569"
                    class="{{ $input }}">
                @error('year')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>

    <hr class="border-zinc-200">

    {{-- รูปภาพ --}}
    <section class="space-y-4">
        <div>
            <h3 class="text-sm font-semibold text-zinc-900">รูปภาพ</h3>
            <p class="mt-0.5 text-xs text-zinc-500">รูปปกใช้ในแกลเลอรี · รูปก่อน/หลังแสดงเปรียบเทียบบนหน้าเคส — JPG / PNG / WEBP ไม่เกิน 5 MB</p>
        </div>

        <div class="grid grid-cols-1 gap-6">
            {{-- Cover --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-[180px_1fr] md:items-start">
                <div class="flex h-40 items-center justify-center overflow-hidden rounded-xl border border-dashed border-zinc-300 bg-zinc-50">
                    @if ($editing && $portfolio->imageUrl() && filled($portfolio->image))
                        <img src="{{ \App\Support\MediaUrl::resolve($portfolio->image) }}" alt="{{ $portfolio->title }}"
                            class="h-full w-full object-contain p-2">
                    @else
                        <span class="px-3 text-center text-xs text-zinc-400">รูปปก (แกลเลอรี)</span>
                    @endif
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-zinc-700">รูปปก / แกลเลอรี</label>
                    <input name="image_file" type="file" accept="image/jpeg,image/png,image/webp"
                        class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 file:mr-3 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-zinc-700 hover:file:bg-zinc-200 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10">
                    @if ($editing && $portfolio->image)
                        <p class="mt-1.5 text-xs text-zinc-500">ไฟล์ปัจจุบัน: <span class="font-mono">{{ $portfolio->image }}</span></p>
                    @endif
                    @error('image_file')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Before / After --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="space-y-3 rounded-xl border border-zinc-200 bg-zinc-50/50 p-4">
                    <div class="flex h-36 items-center justify-center overflow-hidden rounded-lg border border-dashed border-zinc-300 bg-white">
                        @if ($editing && $portfolio->beforeImageUrl())
                            <img src="{{ $portfolio->beforeImageUrl() }}" alt="ก่อนซ่อม — {{ $portfolio->title }}"
                                class="h-full w-full object-contain p-2">
                        @else
                            <span class="px-3 text-center text-xs text-zinc-400">รูปก่อนซ่อม</span>
                        @endif
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-zinc-700">รูปก่อนซ่อม</label>
                        <input name="before_image_file" type="file" accept="image/jpeg,image/png,image/webp"
                            class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 file:mr-3 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-zinc-700 hover:file:bg-zinc-200 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10">
                        @if ($editing && $portfolio->before_image)
                            <p class="mt-1.5 text-xs text-zinc-500 font-mono truncate">{{ $portfolio->before_image }}</p>
                        @endif
                        @error('before_image_file')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-3 rounded-xl border border-zinc-200 bg-zinc-50/50 p-4">
                    <div class="flex h-36 items-center justify-center overflow-hidden rounded-lg border border-dashed border-zinc-300 bg-white">
                        @if ($editing && $portfolio->afterImageUrl() && (filled($portfolio->after_image) || filled($portfolio->image)))
                            <img src="{{ $portfolio->afterImageUrl() }}" alt="หลังซ่อม — {{ $portfolio->title }}"
                                class="h-full w-full object-contain p-2">
                        @else
                            <span class="px-3 text-center text-xs text-zinc-400">รูปหลังซ่อม</span>
                        @endif
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-zinc-700">รูปหลังซ่อม</label>
                        <input name="after_image_file" type="file" accept="image/jpeg,image/png,image/webp"
                            class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 file:mr-3 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-zinc-700 hover:file:bg-zinc-200 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10">
                        <p class="mt-1 text-xs text-zinc-500">ถ้าไม่ใส่ จะใช้รูปปกแทน (ถ้ามี)</p>
                        @if ($editing && $portfolio->after_image)
                            <p class="mt-1.5 text-xs text-zinc-500 font-mono truncate">{{ $portfolio->after_image }}</p>
                        @endif
                        @error('after_image_file')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="border-zinc-200">

    {{-- SEO + Blog link --}}
    <section class="space-y-4">
        <div>
            <h3 class="text-sm font-semibold text-zinc-900">SEO หน้าเคส + ลิงก์บทความ</h3>
            <p class="mt-0.5 text-xs text-zinc-500">Keyword ของเคสต้องไม่ชนกับ Blog (เช่น ซ่อมเครื่องดูดฝุ่น คาเฟ่แมว)</p>
        </div>
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">Meta Title</label>
                <input name="meta_title" type="text" value="{{ old('meta_title', $portfolio->meta_title) }}"
                    placeholder="หัวข้อ SEO ของหน้าเคส"
                    class="{{ $input }}">
                @error('meta_title')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">Meta Description</label>
                <textarea name="meta_description" rows="2" class="{{ $input }}"
                    placeholder="คำอธิบายสั้น ๆ">{{ old('meta_description', $portfolio->meta_description) }}</textarea>
                @error('meta_description')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">บทความ Blog ที่เกี่ยวข้อง</label>
                @php $blogs = \App\Models\Blog::query()->orderBy('title')->get(['id', 'title', 'slug']); @endphp
                <select name="related_blog_id" class="{{ $input }}">
                    <option value="">— ไม่ผูก —</option>
                    @foreach ($blogs as $relatedBlog)
                        <option value="{{ $relatedBlog->id }}" @selected(old('related_blog_id', $portfolio->related_blog_id) == $relatedBlog->id)>
                            {{ $relatedBlog->title }}
                        </option>
                    @endforeach
                </select>
                @error('related_blog_id')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>

    <hr class="border-zinc-200">

    {{-- การแสดงผล --}}
    <section class="space-y-4">
        <div>
            <h3 class="text-sm font-semibold text-zinc-900">การแสดงผล</h3>
            <p class="mt-0.5 text-xs text-zinc-500">ลำดับน้อยกว่าแสดงก่อน · พิกัดใช้กับ JSON-LD schema</p>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">สถานะงาน <span class="text-red-500">*</span></label>
                <input name="status_label" type="text" value="{{ old('status_label', $portfolio->status_label ?: 'สำเร็จ') }}"
                    placeholder="สำเร็จ"
                    class="{{ $input }}" required>
                @error('status_label')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">ลำดับ <span class="text-red-500">*</span></label>
                <input name="sort_order" type="number" value="{{ old('sort_order', $portfolio->sort_order ?? 0) }}"
                    placeholder="0"
                    class="{{ $input }}" required>
                @error('sort_order')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">การเผยแพร่ <span class="text-red-500">*</span></label>
                <select name="is_active" class="{{ $input }}" required>
                    <option value="1" @selected(old('is_active', $portfolio->is_active ? '1' : '0') == '1')>แสดงบนเว็บ</option>
                    <option value="0" @selected(old('is_active', $portfolio->is_active ? '1' : '0') == '0')>ซ่อน</option>
                </select>
                @error('is_active')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-2 lg:col-span-1">
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">พิกัดแผนที่</label>
                <input name="map_coordinates" type="text" value="{{ old('map_coordinates', $portfolio->map_coordinates) }}"
                    placeholder="13.754198, 100.501705"
                    class="{{ $input }}">
                @error('map_coordinates')
                    <p class="mt-1 text-xs text-red-600">กรุณากรอกในรูปแบบ 13.754198, 100.501705</p>
                @enderror
            </div>
        </div>
    </section>

    <div class="flex flex-wrap gap-2 border-t border-zinc-200 pt-5">
        <button type="submit"
            class="min-w-32 rounded-lg bg-zinc-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-zinc-800">
            {{ $editing ? 'บันทึกการแก้ไข' : 'เพิ่มผลงาน' }}
        </button>
        @if ($editing)
            <a href="{{ route('admin.portfolios.index') }}"
                class="inline-flex min-w-24 items-center justify-center rounded-lg border border-zinc-300 bg-white px-4 py-2.5 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50">
                ยกเลิก
            </a>
        @endif
    </div>
</form>
