<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>เข้าสู่ระบบ | Siriphong Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-offwhite text-ink">
    <main class="mx-auto flex min-h-screen w-full max-w-md items-center px-4">
        <section class="w-full rounded-2xl border border-zinc-200 bg-white p-7 shadow-sm">
            <div class="mb-6 text-center">
                <p class="text-xs font-semibold uppercase tracking-[.14em] text-orange">Admin Login</p>
                <h1 class="mt-2 text-2xl font-bold text-navy">เข้าสู่ระบบหลังบ้าน</h1>
                <p class="mt-1 text-sm text-steel">ใช้บัญชีผู้ดูแลระบบเพื่อจัดการข้อมูลเว็บไซต์</p>
            </div>

            <form action="{{ route('login.store') }}" method="post" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-zinc-700">อีเมล</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email"
                        required
                        class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm text-zinc-900 placeholder:text-zinc-500 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/15" />
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-zinc-700">รหัสผ่าน</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                        class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm text-zinc-900 placeholder:text-zinc-500 focus:border-navy focus:outline-none focus:ring-2 focus:ring-navy/15" />
                </div>

                <label class="flex items-center gap-2 text-sm text-zinc-600">
                    <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-zinc-300">
                    จดจำการเข้าสู่ระบบ
                </label>

                <button type="submit"
                    class="inline-flex min-h-11 w-full items-center justify-center rounded-xl bg-navy px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-navy-mid">
                    เข้าสู่ระบบ
                </button>
            </form>
        </section>
    </main>
</body>

</html>
