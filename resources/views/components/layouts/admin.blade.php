<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-zinc-50 text-zinc-900">
    <div class="min-h-screen md:flex">
        <aside class="w-full border-b border-zinc-200 bg-white p-5 md:w-72 md:border-b-0 md:border-r">
            <div class="mb-6">
                <p class="text-xs uppercase tracking-wider text-zinc-500">Admin</p>
                <h1 class="text-xl font-bold">Siriphong</h1>
                <p class="mt-1 text-xs text-zinc-500">{{ auth()->user()?->email }}</p>
            </div>

            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="block rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-zinc-900 text-white' : 'text-zinc-700 hover:bg-zinc-100' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.inquiries') }}"
                    class="block rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.inquiries') ? 'bg-zinc-900 text-white' : 'text-zinc-700 hover:bg-zinc-100' }}">
                    Inquiries
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="block rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'bg-zinc-900 text-white' : 'text-zinc-700 hover:bg-zinc-100' }}">
                    Users
                </a>
                <a href="{{ route('admin.portfolios.index') }}"
                    class="block rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.portfolios.*') ? 'bg-zinc-900 text-white' : 'text-zinc-700 hover:bg-zinc-100' }}">
                    Portfolios
                </a>
                <a href="{{ route('admin.products.index', ['type' => 'product']) }}"
                    class="block rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.products.*') ? 'bg-zinc-900 text-white' : 'text-zinc-700 hover:bg-zinc-100' }}">
                    สินค้าและบริการ
                </a>
                <a href="{{ route('admin.categories.index', ['type' => 'product']) }}"
                    class="block rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.categories.*') ? 'bg-zinc-900 text-white' : 'text-zinc-700 hover:bg-zinc-100' }}">
                    หมวดหมู่
                </a>
            </nav>

            <form action="{{ route('logout') }}" method="post" class="mt-6">
                @csrf
                <button type="submit"
                    class="inline-flex min-h-10 w-full items-center justify-center rounded-lg border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-100">
                    ออกจากระบบ
                </button>
            </form>
        </aside>

        <main class="flex-1 p-6 md:p-10">
            {{ $slot }}
        </main>
    </div>
</body>

</html>