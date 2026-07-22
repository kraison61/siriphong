<?php
use App\Models\Portfolio;
use function Livewire\Volt\{layout, state, rules, usesPagination, with};

layout('components.layouts.admin');
usesPagination();

state([
    'editingId' => null,
    'category_label' => '',
    'title' => '',
    'description' => '',
    'brands' => '',
    'image' => '',
    'year' => '',
    'duration' => '',
    'status_label' => 'สำเร็จ',
    'sort_order' => 0,
    'is_active' => true,
    'map_coordinates' => '',
]);

rules([
    'category_label' => ['required', 'string', 'max:255'],
    'title' => ['required', 'string', 'max:255'],
    'description' => ['nullable', 'string'],
    'brands' => ['nullable', 'string', 'max:255'],
    'image' => ['nullable', 'string', 'max:255'],
    'year' => ['nullable', 'string', 'max:255'],
    'duration' => ['nullable', 'string', 'max:255'],
    'status_label' => ['required', 'string', 'max:255'],
    'sort_order' => ['required', 'integer'],
    'is_active' => ['required', 'boolean'],
    'map_coordinates' => ['nullable', 'regex:/^\s*-?\d{1,2}(?:\.\d+)?,\s*-?\d{1,3}(?:\.\d+)?\s*$/'],
]);

with(fn() => [
    'portfolios' => Portfolio::query()->latest()->paginate(10),
]);

$edit = function (int $id) {
    $row = Portfolio::findOrFail($id);

    $this->editingId = $row->id;
    $this->category_label = $row->category_label;
    $this->title = $row->title;
    $this->description = (string) $row->description;
    $this->brands = (string) $row->brands;
    $this->image = (string) $row->image;
    $this->year = (string) $row->year;
    $this->duration = (string) $row->duration;
    $this->status_label = $row->status_label;
    $this->sort_order = $row->sort_order;
    $this->is_active = (bool) $row->is_active;
    $this->map_coordinates = (string) ($row->map_coordinates ?? '');
};

$cancel = function () {
    $this->reset(
        'editingId',
        'category_label',
        'title',
        'description',
        'brands',
        'image',
        'year',
        'duration',
        'status_label',
        'sort_order',
        'is_active',
        'map_coordinates'
    );

    $this->status_label = 'สำเร็จ';
    $this->sort_order = 0;
    $this->is_active = true;
    $this->map_coordinates = '';
};

$save = function () {
    $validated = $this->validate();

    if ($this->editingId) {
        Portfolio::whereKey($this->editingId)->update($validated);
    } else {
        Portfolio::create($validated);
    }

    $this->cancel();
};

$delete = function (int $id) {
    Portfolio::whereKey($id)->delete();
};
?>

<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold">จัดการผลงาน (Portfolio)</h1>
        <p class="text-zinc-500">เพิ่ม แก้ไข และลบรายการผลงาน</p>
    </div>

    <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm">
        <div class="border-b border-zinc-200 bg-gradient-to-r from-zinc-50 to-white px-5 py-4">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500">Portfolio Form</p>
                    <h2 class="text-lg font-semibold text-zinc-900">
                        {{ $editingId ? 'แก้ไขผลงาน' : 'เพิ่มผลงานใหม่' }}
                    </h2>
                </div>
                @if($editingId)
                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">Editing #{{ $editingId }}</span>
                @endif
            </div>
        </div>

        <form wire:submit="save" class="grid grid-cols-1 gap-4 p-5 text-zinc-900 md:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">หมวดหมู่</label>
                <input wire:model="category_label" type="text" placeholder="เช่น โรงงาน / บ้านพักอาศัย"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 placeholder:opacity-100 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('category_label') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">หัวข้อผลงาน</label>
                <input wire:model="title" type="text" placeholder="ชื่อเคสงานซ่อม"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 placeholder:opacity-100 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('title') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="md:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">รายละเอียด</label>
                <textarea wire:model="description" rows="3" placeholder="รายละเอียดงานซ่อม"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 placeholder:opacity-100 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10"></textarea>
                @error('description') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">แบรนด์</label>
                <input wire:model="brands" type="text" placeholder="เช่น Karcher, Nilfisk"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 placeholder:opacity-100 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('brands') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">รูปภาพ (path)</label>
                <input wire:model="image" type="text" placeholder="service/ametek-vacuum-motor.webp หรือ portfolio/1.JPG"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 placeholder:opacity-100 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('image') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">ปี</label>
                <input wire:model="year" type="text" placeholder="2026"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 placeholder:opacity-100 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('year') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">ระยะเวลา</label>
                <input wire:model="duration" type="text" placeholder="3 วัน"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 placeholder:opacity-100 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('duration') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">สถานะ</label>
                <input wire:model="status_label" type="text" placeholder="สำเร็จ"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 placeholder:opacity-100 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('status_label') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">ลำดับ</label>
                <input wire:model="sort_order" type="number" placeholder="0"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 placeholder:opacity-100 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('sort_order') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">การแสดงผล</label>
                <select wire:model="is_active"
                    class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm font-semibold text-zinc-900 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10">
                    <option value="1">แสดง</option>
                    <option value="0">ซ่อน</option>
                </select>
                @error('is_active') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="md:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">พิกัด Google Map (Latitude, Longitude)</label>
                <input wire:model="map_coordinates" type="text" placeholder="13.754198, 100.501705"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 placeholder:opacity-100 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('map_coordinates') <p class="mt-1 text-xs text-red-600">กรุณากรอกในรูปแบบ 13.754198, 100.501705</p> @enderror
            </div>

            <div class="md:col-span-2">
                <p class="text-xs font-medium text-zinc-700">* รายการที่ลำดับน้อยกว่า จะแสดงก่อนในหน้าเว็บไซต์ และพิกัดจะถูกนำไปใช้อ้างอิง JSON-LD schema</p>
            </div>

            <div class="md:col-span-2 flex flex-wrap gap-2">
                <button type="submit"
                    class="min-w-32 rounded-lg bg-zinc-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-zinc-800">
                    {{ $editingId ? 'อัปเดตผลงาน' : 'เพิ่มผลงาน' }}
                </button>
                @if($editingId)
                    <button type="button" wire:click="cancel"
                        class="min-w-24 rounded-lg border border-zinc-300 bg-white px-4 py-2 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50">ยกเลิก</button>
                @endif
            </div>
        </form>
    </div>

    <div class="overflow-x-auto rounded-2xl border border-zinc-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-zinc-200 bg-zinc-50/80">
                <tr>
                    <th class="px-4 py-3 font-semibold text-zinc-700">ID</th>
                    <th class="px-4 py-3 font-semibold text-zinc-700">หัวข้อ</th>
                    <th class="px-4 py-3 font-semibold text-zinc-700">หมวดหมู่</th>
                    <th class="px-4 py-3 font-semibold text-zinc-700">สถานะ</th>
                    <th class="px-4 py-3 font-semibold text-zinc-700">ลำดับ</th>
                    <th class="px-4 py-3 font-semibold text-zinc-700">พิกัดแผนที่</th>
                    <th class="px-4 py-3 font-semibold text-zinc-700">จัดการ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100">
                @forelse($portfolios as $portfolio)
                    <tr class="transition-colors hover:bg-zinc-50/70">
                        <td class="px-4 py-3 font-medium text-zinc-700">#{{ str_pad((string) $portfolio->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-4 py-3 font-medium text-zinc-900">{{ $portfolio->title }}</td>
                        <td class="px-4 py-3 text-zinc-700">{{ $portfolio->category_label }}</td>
                        <td class="px-4 py-3">
                            <span
                                class="{{ $portfolio->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-zinc-200 text-zinc-700' }} inline-flex rounded-full px-2.5 py-1 text-xs font-semibold">
                                {{ $portfolio->is_active ? 'แสดง' : 'ซ่อน' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 font-medium text-zinc-700">{{ $portfolio->sort_order }}</td>
                        <td class="px-4 py-3 text-xs text-zinc-600">
                            {{ $portfolio->map_coordinates ?: '-' }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <button type="button" wire:click="edit({{ $portfolio->id }})"
                                    class="rounded-md border border-zinc-300 px-3 py-1.5 text-xs font-semibold text-zinc-700 transition hover:bg-zinc-50">แก้ไข</button>
                                <button type="button" wire:click="delete({{ $portfolio->id }})"
                                    wire:confirm="ยืนยันการลบผลงานนี้?"
                                    class="rounded-md bg-red-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-red-500">
                                    ลบ
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-10 text-center text-zinc-500">ยังไม่มีข้อมูลผลงาน</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="border-t border-zinc-200 p-4">
            {{ $portfolios->links() }}
        </div>
    </div>
</div>
