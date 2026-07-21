<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="min-h-screen bg-zinc-50 text-zinc-900">
    <div class="min-h-screen md:flex">
        <aside class="w-full border-b border-zinc-200 bg-white p-5 md:w-72 md:border-b-0 md:border-r">
            <div class="mb-6">
                <p class="text-xs uppercase tracking-wider text-zinc-500">Admin</p>
                <h1 class="text-xl font-bold">Siriphong</h1>
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
                <a href="{{ route('admin.users') }}"
                    class="block rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.users') ? 'bg-zinc-900 text-white' : 'text-zinc-700 hover:bg-zinc-100' }}">
                    Users
                </a>
                <a href="{{ route('admin.portfolios') }}"
                    class="block rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.portfolios') ? 'bg-zinc-900 text-white' : 'text-zinc-700 hover:bg-zinc-100' }}">
                    Portfolios
                </a>
            </nav>
        </aside>

        <main class="flex-1 p-6 md:p-10">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>

</html>