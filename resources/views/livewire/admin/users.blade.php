<?php
use App\Models\User;
use function Livewire\Volt\{layout, state, rules, usesPagination, with};

layout('components.layouts.admin');
usesPagination();

state([
    'editingId' => null,
    'name' => '',
    'email' => '',
    'password' => '',
]);

rules(fn() => [
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'email', 'max:255', 'unique:users,email,'.($this->editingId ?? 'NULL')],
    'password' => [($this->editingId ? 'nullable' : 'required'), 'min:8'],
]);

with(fn() => [
    'users' => User::latest()->paginate(10),
]);

$edit = function (int $id) {
    $user = User::findOrFail($id);

    $this->editingId = $user->id;
    $this->name = $user->name;
    $this->email = $user->email;
    $this->password = '';
};

$cancel = function () {
    $this->reset('editingId', 'name', 'email', 'password');
};

$save = function () {
    $validated = $this->validate();

    if ($this->editingId) {
        $user = User::findOrFail($this->editingId);
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (filled($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();
    } else {
        User::create($validated);
    }

    $this->reset('editingId', 'name', 'email', 'password');
};

$delete = function (int $id) {
    User::whereKey($id)->delete();
};
?>

<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold">จัดการผู้ใช้งาน</h1>
        <p class="text-zinc-500">เพิ่ม แก้ไข และลบผู้ใช้งานระบบ</p>
    </div>

    <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm">
        <div class="border-b border-zinc-200 bg-gradient-to-r from-zinc-50 to-white px-5 py-4">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500">User Form</p>
                    <h2 class="text-lg font-semibold text-zinc-900">
                        {{ $editingId ? 'แก้ไขข้อมูลผู้ใช้งาน' : 'เพิ่มผู้ใช้งานใหม่' }}
                    </h2>
                </div>
                @if($editingId)
                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">Editing #{{ $editingId }}</span>
                @endif
            </div>
        </div>

        <form wire:submit="save" class="grid grid-cols-1 gap-4 p-5 md:grid-cols-3">
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">ชื่อ</label>
                <input wire:model="name" type="text" placeholder="เช่น Siriphong Admin"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm text-zinc-900 placeholder:text-zinc-500 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">อีเมล</label>
                <input wire:model="email" type="email" placeholder="name@example.com"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm text-zinc-900 placeholder:text-zinc-500 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">
                    {{ $editingId ? 'รหัสผ่านใหม่ (ไม่กรอก = ไม่เปลี่ยน)' : 'รหัสผ่าน' }}
                </label>
                <input wire:model="password" type="password" placeholder="อย่างน้อย 8 ตัวอักษร"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm text-zinc-900 placeholder:text-zinc-500 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-3">
                <p class="text-xs text-zinc-500">* แนะนำใช้อีเมลที่ไม่ซ้ำกัน และตั้งรหัสผ่านให้คาดเดายาก</p>
            </div>

            <div class="md:col-span-3 flex flex-wrap gap-2">
                <button type="submit"
                    class="min-w-32 rounded-lg bg-zinc-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-zinc-800">
                    {{ $editingId ? 'อัปเดตผู้ใช้' : 'เพิ่มผู้ใช้' }}
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
                    <th class="px-4 py-3 font-semibold text-zinc-700">ชื่อ</th>
                    <th class="px-4 py-3 font-semibold text-zinc-700">อีเมล</th>
                    <th class="px-4 py-3 font-semibold text-zinc-700">จัดการ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100">
                @forelse($users as $user)
                    <tr class="transition-colors hover:bg-zinc-50/70">
                        <td class="px-4 py-3 font-medium text-zinc-700">#{{ str_pad((string) $user->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-4 py-3 font-medium text-zinc-900">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-zinc-600">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <button type="button" wire:click="edit({{ $user->id }})"
                                    class="rounded-md border border-zinc-300 px-3 py-1.5 text-xs font-semibold text-zinc-700 transition hover:bg-zinc-50">แก้ไข</button>
                                <button type="button" wire:click="delete({{ $user->id }})" wire:confirm="ยืนยันการลบผู้ใช้นี้?"
                                    class="rounded-md bg-red-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-red-500">
                                    ลบ
                                </button>
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
