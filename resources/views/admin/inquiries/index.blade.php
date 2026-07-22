<x-layouts.admin>
    <div class="mb-8">
        <h1 class="text-3xl font-bold">ใบรับงานซ่อม</h1>
        <p class="text-zinc-500">รายการแจ้งซ่อมทั้งหมดจากลูกค้า</p>
    </div>

    <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-zinc-600 dark:text-zinc-400">
                <thead
                    class="border-b border-zinc-200 bg-zinc-50 text-zinc-900 dark:border-zinc-800 dark:bg-zinc-950/50 dark:text-white">
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
                    @forelse ($inquiries as $inquiry)
                        <tr class="transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="px-6 py-4 font-medium">#{{ str_pad((string) $inquiry->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-zinc-900 dark:text-white">{{ $inquiry->name }}</div>
                                <div class="mt-0.5 text-xs text-zinc-500">{{ $inquiry->phone }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center rounded-md border border-zinc-200 bg-zinc-100 px-2 py-1 text-xs font-medium text-zinc-800 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                    {{ $inquiry->brand }}
                                </span>
                            </td>
                            <td class="max-w-[200px] truncate px-6 py-4" title="{{ $inquiry->symptom }}">
                                {{ $inquiry->symptom }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($inquiry->status === 'pending')
                                    <span
                                        class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-1 text-xs font-bold text-amber-800 dark:bg-amber-500/20 dark:text-amber-400">
                                        <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                        รอดำเนินการ
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center rounded-full bg-zinc-100 px-2.5 py-1 text-xs font-bold text-zinc-800 dark:bg-zinc-800 dark:text-zinc-300">
                                        {{ $inquiry->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-xs">
                                {{ $inquiry->created_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-zinc-500">
                                ยังไม่มีข้อมูลใบรับงานซ่อมครับ
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-zinc-200 p-4 dark:border-zinc-800">
            {{ $inquiries->links() }}
        </div>
    </div>
</x-layouts.admin>
