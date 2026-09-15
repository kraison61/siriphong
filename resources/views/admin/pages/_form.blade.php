@php
    $editing = $page->exists;
    $blocksJson = old('blocks_json', $page->blocks
        ? json_encode($page->blocks, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        : "{\n  \"symptoms\": { \"heading\": \"\", \"items\": [] },\n  \"service_options\": {},\n  \"bridge_sections\": [],\n  \"price_table\": { \"heading\": \"\", \"rows\": [] },\n  \"machine_filter\": {},\n  \"cases\": { \"items\": [] },\n  \"faqs\": { \"items\": [] }\n}");
@endphp

<form method="post"
    action="{{ $editing ? route('admin.pages.update', $page) : route('admin.pages.store') }}"
    class="space-y-5 p-5">
    @csrf
    @if ($editing)
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div>
            <label class="mb-1 block text-sm font-medium text-zinc-700">หัวข้อ (H1)</label>
            <input type="text" name="title" value="{{ old('title', $page->title) }}" required
                class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-zinc-700">Slug (ไม่มี /)</label>
            <input type="text" name="slug" value="{{ old('slug', $page->slug) }}" required
                class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-mono"
                placeholder="ซ่อมเครื่องดูดฝุ่นคาร์แคร์">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-zinc-700">Template</label>
            <select name="template" class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm">
                @foreach (['service' => 'Service (ซ่อม)', 'pricing' => 'Pricing (ราคา)', 'portfolio' => 'Portfolio (ผลงาน)', 'general' => 'General'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('template', $page->template) === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-zinc-700">หน้าแม่ (ถ้ามี)</label>
            <select name="parent_id" class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm">
                <option value="">— ไม่มี (หน้าหลัก) —</option>
                @foreach ($parents as $parent)
                    <option value="{{ $parent->id }}" @selected((string) old('parent_id', $page->parent_id) === (string) $parent->id)>
                        {{ $parent->title }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-zinc-700">Primary Keyword</label>
            <input type="text" name="primary_keyword" value="{{ old('primary_keyword', $page->primary_keyword) }}"
                class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-zinc-700">ลำดับ</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $page->sort_order ?? 0) }}" required
                class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm">
        </div>
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-zinc-700">Intro 3 บรรทัดแรก (ตอบให้จบ)</label>
        <textarea name="intro" rows="3" class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm"
            placeholder="รับซ่อมอะไร / ช่วงราคา / กี่วันได้คืน">{{ old('intro', $page->intro) }}</textarea>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div>
            <label class="mb-1 block text-sm font-medium text-zinc-700">Meta Title</label>
            <input type="text" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}"
                class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-zinc-700">Hero Image path</label>
            <input type="text" name="hero_image" value="{{ old('hero_image', $page->hero_image) }}"
                class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm" placeholder="optional">
        </div>
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-zinc-700">Meta Description</label>
        <textarea name="meta_description" rows="2" class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm">{{ old('meta_description', $page->meta_description) }}</textarea>
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-zinc-700">Content Blocks (JSON)</label>
        <p class="mb-2 text-xs text-zinc-500">
            คีย์ที่ใช้: symptoms, service_options, bridge_sections, price_table, machine_filter, cases, faqs, compare_table, price_source, body
        </p>
        <textarea name="blocks_json" rows="18"
            class="w-full rounded-lg border border-zinc-300 px-3 py-2 font-mono text-xs leading-relaxed">{{ $blocksJson }}</textarea>
    </div>

    <div class="flex flex-wrap items-center gap-4">
        <label class="inline-flex items-center gap-2 text-sm font-medium text-zinc-700">
            <input type="hidden" name="is_published" value="0">
            <input type="checkbox" name="is_published" value="1"
                @checked(old('is_published', $page->is_published))
                class="rounded border-zinc-300">
            เผยแพร่
        </label>

        <button type="submit"
            class="rounded-lg bg-zinc-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-zinc-700">
            {{ $editing ? 'บันทึกการแก้ไข' : 'เพิ่มหน้า' }}
        </button>

        @if ($editing)
            <a href="{{ route('admin.pages.index') }}"
                class="rounded-lg border border-zinc-300 px-5 py-2.5 text-sm font-semibold text-zinc-700 hover:bg-zinc-50">
                ยกเลิก
            </a>
        @endif
    </div>
</form>
