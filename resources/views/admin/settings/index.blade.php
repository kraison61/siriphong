<x-layouts.admin>
    <div class="space-y-8">
        <div>
            <h1 class="text-3xl font-bold">ตั้งค่าเว็บไซต์</h1>
            <p class="text-zinc-500">ข้อมูลติดต่อ แบรนด์ และ SEO พื้นฐาน</p>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                <ul class="list-disc space-y-1 pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm">
            <div class="border-b border-zinc-200 bg-gradient-to-r from-zinc-50 to-white px-5 py-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500">Settings Form</p>
                <h2 class="text-lg font-semibold text-zinc-900">แก้ไขการตั้งค่า</h2>
            </div>

            @include('admin.settings._form', ['settings' => $settings])
        </div>
    </div>
</x-layouts.admin>
