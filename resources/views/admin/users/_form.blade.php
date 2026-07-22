@php
    $editing = $user->exists;
@endphp

<form
    action="{{ $editing ? route('admin.users.update', $user) : route('admin.users.store') }}"
    method="post"
    class="grid grid-cols-1 gap-4 p-5 md:grid-cols-3">
    @csrf
    @if ($editing)
        @method('PUT')
    @endif

    <div>
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">ชื่อ</label>
        <input name="name" type="text" value="{{ old('name', $user->name) }}" placeholder="เช่น Siriphong Admin"
            class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm text-zinc-900 placeholder:text-zinc-500 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
        @error('name')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">อีเมล</label>
        <input name="email" type="email" value="{{ old('email', $user->email) }}" placeholder="name@example.com"
            class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm text-zinc-900 placeholder:text-zinc-500 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
        @error('email')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-zinc-700">
            {{ $editing ? 'รหัสผ่านใหม่ (ไม่กรอก = ไม่เปลี่ยน)' : 'รหัสผ่าน' }}
        </label>
        <input name="password" type="password" placeholder="อย่างน้อย 8 ตัวอักษร"
            class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm text-zinc-900 placeholder:text-zinc-500 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
        @error('password')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-3">
        <p class="text-xs text-zinc-500">* แนะนำใช้อีเมลที่ไม่ซ้ำกัน และตั้งรหัสผ่านให้คาดเดายาก</p>
    </div>

    <div class="flex flex-wrap gap-2 md:col-span-3">
        <button type="submit"
            class="min-w-32 rounded-lg bg-zinc-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-zinc-800">
            {{ $editing ? 'อัปเดตผู้ใช้' : 'เพิ่มผู้ใช้' }}
        </button>
        @if ($editing)
            <a href="{{ route('admin.users.index') }}"
                class="inline-flex min-w-24 items-center justify-center rounded-lg border border-zinc-300 bg-white px-4 py-2 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50">
                ยกเลิก
            </a>
        @endif
    </div>
</form>
