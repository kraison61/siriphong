<x-layouts.admin>
    <div class="space-y-8">
        <div>
            <h1 class="text-3xl font-bold">จัดการผู้ใช้งาน</h1>
            <p class="text-zinc-500">เพิ่ม แก้ไข และลบผู้ใช้งานระบบ</p>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm">
            <div class="border-b border-zinc-200 bg-gradient-to-r from-zinc-50 to-white px-5 py-4">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500">User Form</p>
                        <h2 class="text-lg font-semibold text-zinc-900">
                            {{ $user->exists ? 'แก้ไขข้อมูลผู้ใช้งาน' : 'เพิ่มผู้ใช้งานใหม่' }}
                        </h2>
                    </div>
                    @if ($user->exists)
                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">
                            Editing #{{ $user->id }}
                        </span>
                    @endif
                </div>
            </div>

            @include('admin.users._form', ['user' => $user])
        </div>

        <div class="overflow-x-auto rounded-2xl border border-zinc-200 bg-white shadow-sm">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-zinc-200 bg-zinc-50/80">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-zinc-700">ID</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">ชื่อ</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">อีเมล</th>
                        <th class="px-4 py-3 font-semibold text-zinc-700">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($users as $row)
                        <tr class="transition-colors hover:bg-zinc-50/70">
                            <td class="px-4 py-3 font-medium text-zinc-700">
                                #{{ str_pad((string) $row->id, 3, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-4 py-3 font-medium text-zinc-900">{{ $row->name }}</td>
                            <td class="px-4 py-3 text-zinc-600">{{ $row->email }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.users.edit', $row) }}"
                                        class="rounded-md border border-zinc-300 px-3 py-1.5 text-xs font-semibold text-zinc-700 transition hover:bg-zinc-50">
                                        แก้ไข
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $row) }}" method="post"
                                        onsubmit="return confirm('ยืนยันการลบผู้ใช้นี้?')">
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
                            <td colspan="4" class="px-4 py-10 text-center text-zinc-500">ยังไม่มีผู้ใช้งาน</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="border-t border-zinc-200 p-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-layouts.admin>
