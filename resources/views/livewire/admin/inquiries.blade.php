<?php
use function Livewire\Volt\{layout, with, usesPagination};
use App\Models\Inquiry;

// 1. บอกให้หน้านี้ใช้ Layout ของหลังบ้าน
layout('components.layouts.admin');

// 2. เปิดใช้งานระบบแบ่งหน้า (Pagination) เผื่อในอนาคตมีงานซ่อมเยอะๆ
usesPagination();

// 3. ดึงข้อมูลจากตาราง Inquiry เรียงจากใหม่ไปเก่า (latest) หน้าละ 10 รายการ
with(fn() => [
    'inquiries' => Inquiry::latest()->paginate(10)
]);
?>

<div>
    {{-- ส่วนหัวข้อ --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold">ใบรับงานซ่อม</h1>
        <p class="text-zinc-500">รายการแจ้งซ่อมทั้งหมดจากลูกค้า</p>
    </div>

    {{-- ส่วนตารางแสดงข้อมูล --}}
    <div
        class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-zinc-600 dark:text-zinc-400">
                <thead
                    class="bg-zinc-50 dark:bg-zinc-950/50 border-b border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-white">
                    <tr>
                        <th class="px-6 py-4 font-medium">รหัสใบงาน</th>
                        <th class="px-6 py-4 font-medium">ชื่อลูกค้า / เบอร์โทร</th>
                        <th class="px-6 py-4 font-medium">ยี่ห้อ</th>
                        <th class="px-6 py-4 font-medium">อาการเบื้องต้น</th>
                        <th class="px-6 py-4 font-medium">สถานะ</th>
                        <th class="px-6 py-4 font-medium">วันที่แจ้ง</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">

                    {{-- วนลูปแสดงข้อมูล --}}
                    @forelse($inquiries as $inquiry)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            {{-- รหัสใบงาน: ใช้ str_pad เติมเลข 0 ข้างหน้าให้ดูสวยงาม เช่น #0001 --}}
                            <td class="px-6 py-4 font-medium">#{{ str_pad($inquiry->id, 4, '0', STR_PAD_LEFT) }}</td>

                            <td class="px-6 py-4">
                                <div class="font-bold text-zinc-900 dark:text-white">{{ $inquiry->name }}</div>
                                <div class="text-zinc-500 text-xs mt-0.5">{{ $inquiry->phone }}</div>
                            </td>

                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700">
                                    {{ $inquiry->brand }}
                                </span>
                            </td>

                            {{-- อาการ: ถ้าข้อความยาวไปจะใช้ truncate ตัดจบด้วย ... --}}
                            <td class="px-6 py-4 max-w-[200px] truncate" title="{{ $inquiry->symptom }}">
                                {{ $inquiry->symptom }}
                            </td>

                            <td class="px-6 py-4">
                                @if($inquiry->status === 'pending')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span>
                                        รอดำเนินการ
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-300">
                                        {{ $inquiry->status }}
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-xs">
                                {{ $inquiry->created_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        {{-- กรณีที่ยังไม่มีลูกค้าส่งข้อมูลมาเลย --}}
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-zinc-500">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="mx-auto mb-3 h-12 w-12 text-zinc-300 dark:text-zinc-700" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M20.25 13.5v3.75A2.25 2.25 0 0 1 18 19.5H6a2.25 2.25 0 0 1-2.25-2.25V13.5m16.5 0-2.636-7.03A2.25 2.25 0 0 0 15.507 5H8.493a2.25 2.25 0 0 0-2.107 1.47L3.75 13.5m16.5 0h-4.34a.75.75 0 0 0-.53.22l-1.16 1.159a.75.75 0 0 1-.53.221h-3.38a.75.75 0 0 1-.53-.22l-1.16-1.16a.75.75 0 0 0-.53-.22H3.75" />
                                </svg>
                                ยังไม่มีข้อมูลใบรับงานซ่อมครับ
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- ปุ่มกดเปลี่ยนหน้า (ถ้าข้อมูลมีมากกว่า 10 รายการ) --}}
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-800">
            {{ $inquiries->links() }}
        </div>
    </div>
</div>