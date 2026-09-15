@php
    $editing = $blog->exists;
    $input = 'w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10';
    $faqsJson = old('faqs_json', $blog->faqs ? json_encode($blog->faqs, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) : "[\n  {\"question\": \"\", \"answer\": \"\"}\n]");
    $portfolios = \App\Models\Portfolio::query()->orderBy('title')->get(['id', 'title', 'slug']);
@endphp

<form
    action="{{ $editing ? route('admin.blogs.update', $blog) : route('admin.blogs.store') }}"
    method="post"
    enctype="multipart/form-data"
    class="space-y-6 p-5 text-zinc-900">
    @csrf
    @if ($editing)
        @method('PUT')
    @endif

    <section class="space-y-4">
        <div>
            <h3 class="text-sm font-semibold text-zinc-900">ข้อมูลบทความ</h3>
            <p class="mt-0.5 text-xs text-zinc-500">หัวข้อ สรุป และเนื้อหาหลัก — FAQ แยกช่องด้านล่างให้ตรงกับ JSON-LD</p>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="md:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">หัวข้อ <span class="text-red-500">*</span></label>
                <input name="title" type="text" value="{{ old('title', $blog->title) }}"
                    placeholder="เช่น เครื่องดูดฝุ่นไม่มีแรงดูด เกิดจากอะไร?"
                    class="{{ $input }}" required>
                @error('title')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">Slug <span class="text-red-500">*</span></label>
                <input name="slug" type="text" value="{{ old('slug', $blog->slug) }}"
                    placeholder="เช่น vacuum-no-suction-fix"
                    class="{{ $input }}" required>
                @error('slug')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">Primary Keyword</label>
                <input name="primary_keyword" type="text" value="{{ old('primary_keyword', $blog->primary_keyword) }}"
                    placeholder="เช่น เครื่องดูดฝุ่นไม่มีแรงดูด"
                    class="{{ $input }}">
                @error('primary_keyword')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">ลำดับ <span class="text-red-500">*</span></label>
                <input name="sort_order" type="number" value="{{ old('sort_order', $blog->sort_order ?? 0) }}"
                    placeholder="0"
                    class="{{ $input }}" required>
                @error('sort_order')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">ลิงก์เคส Portfolio</label>
                <select name="related_portfolio_id" class="{{ $input }}">
                    <option value="">— ไม่ผูก —</option>
                    @foreach ($portfolios as $case)
                        <option value="{{ $case->id }}" @selected(old('related_portfolio_id', $blog->related_portfolio_id) == $case->id)>
                            {{ $case->title }}{{ $case->slug ? ' (/portfolio/'.$case->slug.')' : '' }}
                        </option>
                    @endforeach
                </select>
                @error('related_portfolio_id')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">สรุปสั้น (Excerpt)</label>
                <textarea name="excerpt" rows="2" placeholder="ข้อความสรุปสำหรับรายการบทความและ meta fallback"
                    class="{{ $input }}">{{ old('excerpt', $blog->excerpt) }}</textarea>
                @error('excerpt')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">เนื้อหา (HTML)</label>
                <textarea name="body" rows="12" placeholder="เนื้อหาบทความ — ไม่ต้องใส่ FAQ ในนี้ ใช้ช่อง FAQ ด้านล่าง"
                    class="{{ $input }} font-mono text-xs leading-relaxed">{{ old('body', $blog->body) }}</textarea>
                @error('body')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>

    <hr class="border-zinc-200">

    <section class="space-y-4">
        <div>
            <h3 class="text-sm font-semibold text-zinc-900">ผู้เขียน (Person schema)</h3>
            <p class="mt-0.5 text-xs text-zinc-500">ถ้าเว้นว่างจะใช้ค่า default จาก config/schema.php</p>
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">ชื่อผู้เขียน</label>
                <input name="author_name" type="text" value="{{ old('author_name', $blog->author_name) }}"
                    placeholder="{{ config('schema.author.name') }}"
                    class="{{ $input }}">
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">ตำแหน่ง</label>
                <input name="author_job_title" type="text" value="{{ old('author_job_title', $blog->author_job_title) }}"
                    placeholder="{{ config('schema.author.job_title') }}"
                    class="{{ $input }}">
            </div>
            <div class="md:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">คำอธิบายผู้เขียน</label>
                <input name="author_description" type="text" value="{{ old('author_description', $blog->author_description) }}"
                    placeholder="{{ config('schema.author.description') }}"
                    class="{{ $input }}">
            </div>
        </div>
    </section>

    <hr class="border-zinc-200">

    <section class="space-y-4">
        <div>
            <h3 class="text-sm font-semibold text-zinc-900">รูปปก</h3>
            <p class="mt-0.5 text-xs text-zinc-500">แนะนำ 1200×675 สำหรับ Article image ใน JSON-LD</p>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-[180px_1fr] md:items-start">
            <div class="flex h-40 items-center justify-center overflow-hidden rounded-xl border border-dashed border-zinc-300 bg-zinc-50">
                @if ($editing && $blog->imageUrl())
                    <img src="{{ $blog->imageUrl() }}" alt="{{ $blog->image_alt ?: $blog->title }}"
                        class="h-full w-full object-contain p-2">
                @else
                    <span class="px-3 text-center text-xs text-zinc-400">ยังไม่มีรูป</span>
                @endif
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-zinc-700">อัปโหลดรูป</label>
                    <input name="image_file" type="file" accept="image/jpeg,image/png,image/webp"
                        class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 file:mr-3 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-zinc-700 hover:file:bg-zinc-200 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10">
                    @if ($editing && $blog->image)
                        <p class="mt-1.5 text-xs text-zinc-500">ไฟล์ปัจจุบัน: <span class="font-mono">{{ $blog->image }}</span></p>
                    @endif
                    @error('image_file')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-zinc-700">Alt text</label>
                    <input name="image_alt" type="text" value="{{ old('image_alt', $blog->image_alt) }}"
                        placeholder="เช่น ช่างถอดเครื่องดูดฝุ่นตรวจสอบภายในที่ย่านสีลม"
                        class="{{ $input }}">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-zinc-700">ความกว้าง (px)</label>
                    <input name="image_width" type="number" value="{{ old('image_width', $blog->image_width) }}"
                        placeholder="1200" class="{{ $input }}">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-zinc-700">ความสูง (px)</label>
                    <input name="image_height" type="number" value="{{ old('image_height', $blog->image_height) }}"
                        placeholder="675" class="{{ $input }}">
                </div>
            </div>
        </div>
    </section>

    <hr class="border-zinc-200">

    <section class="space-y-4">
        <div>
            <h3 class="text-sm font-semibold text-zinc-900">FAQ (ต้องตรงกับ FAQPage schema)</h3>
            <p class="mt-0.5 text-xs text-zinc-500">JSON array ของ question/answer — ข้อความบนหน้าต้องตรงทุกตัวอักษร</p>
        </div>
        <textarea name="faqs_json" rows="10" class="{{ $input }} font-mono text-xs leading-relaxed">{{ $faqsJson }}</textarea>
        @error('faqs_json')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
        @error('faqs')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </section>

    <hr class="border-zinc-200">

    <section class="space-y-4">
        <div>
            <h3 class="text-sm font-semibold text-zinc-900">SEO</h3>
            <p class="mt-0.5 text-xs text-zinc-500">ถ้าเว้นว่างจะใช้หัวข้อและสรุปอัตโนมัติ</p>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">Meta Title</label>
                <input name="meta_title" type="text" value="{{ old('meta_title', $blog->meta_title) }}"
                    placeholder="หัวข้อสำหรับ SEO (~60 ตัวอักษร)"
                    class="{{ $input }}">
                @error('meta_title')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">Meta Description</label>
                <textarea name="meta_description" rows="2" placeholder="คำอธิบายสั้น ๆ สำหรับผลการค้นหา (~140–155 ตัวอักษร)"
                    class="{{ $input }}">{{ old('meta_description', $blog->meta_description) }}</textarea>
                @error('meta_description')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>

    <hr class="border-zinc-200">

    <section class="space-y-4">
        <div>
            <h3 class="text-sm font-semibold text-zinc-900">การเผยแพร่</h3>
            <p class="mt-0.5 text-xs text-zinc-500">content_updated_at ใช้เป็น dateModified ใน schema — อย่าตั้ง cron ให้เด้งอัตโนมัติ</p>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">สถานะ <span class="text-red-500">*</span></label>
                <select name="is_published" class="{{ $input }}" required>
                    <option value="0" @selected(old('is_published', $blog->is_published ? '1' : '0') == '0')>ฉบับร่าง</option>
                    <option value="1" @selected(old('is_published', $blog->is_published ? '1' : '0') == '1')>เผยแพร่</option>
                </select>
                @error('is_published')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">วันที่เผยแพร่</label>
                <input name="published_at" type="datetime-local"
                    value="{{ old('published_at', $blog->published_at?->format('Y-m-d\TH:i')) }}"
                    class="{{ $input }}">
                @error('published_at')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">อัปเดตเนื้อหาล่าสุด</label>
                <input name="content_updated_at" type="datetime-local"
                    value="{{ old('content_updated_at', $blog->content_updated_at?->format('Y-m-d\TH:i')) }}"
                    class="{{ $input }}">
                @error('content_updated_at')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>

    <div class="flex flex-wrap gap-2 border-t border-zinc-200 pt-5">
        <button type="submit"
            class="min-w-32 rounded-lg bg-zinc-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-zinc-800">
            {{ $editing ? 'บันทึกการแก้ไข' : 'เพิ่มบทความ' }}
        </button>
        @if ($editing)
            <a href="{{ route('admin.blogs.index') }}"
                class="inline-flex min-w-24 items-center justify-center rounded-lg border border-zinc-300 bg-white px-4 py-2.5 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50">
                ยกเลิก
            </a>
            @if ($blog->is_published)
                <a href="{{ route('blogs.show', $blog->slug) }}" target="_blank" rel="noopener"
                    class="inline-flex min-w-24 items-center justify-center rounded-lg border border-zinc-300 bg-white px-4 py-2.5 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50">
                    ดูหน้าเว็บ
                </a>
            @endif
        @endif
    </div>
</form>
