<!DOCTYPE html>
{{-- 💡 scroll-smooth คือเวทมนตร์ของ Tailwind ที่ทำให้เวลากดเมนูแล้วหน้าเว็บค่อยๆ ไถลลงมาแบบนุ่มนวลครับ --}}
<html lang="th" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'ศิริพงษ์ เซอร์วิส | ช่างซ่อมเครื่องดูดฝุ่นประสบการณ์ 20 ปี' }}</title>

    {{-- 💡 ฟอนต์ที่เราเพิ่งตั้งค่ากันไป --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;600;700;800&family=Sarabun:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    {{-- 💡 ระบบจัดการ Dark/Light Mode ของ Flux UI (เอามาแทน Alpine.js เดิมให้โค้ดคลีนขึ้น) --}}
    @fluxAppearance

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- 💡 flex flex-col และ min-h-screen ช่วยบังคับให้ Footer ดันไปอยู่ล่างสุดเสมอ แม้เนื้อหาตรงกลางจะน้อยก็ตาม --}}

<body class="min-h-screen bg-white dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 flex flex-col font-sans">

    {{-- ==========================================
    ส่วนหัว (Navbar) - ป้ายบอกทางเข้าบ้าน
    ========================================== --}}
    <flux:header container class="bg-zinc-950 border-b border-zinc-800 text-white sticky top-0 z-50">
        <flux:navbar class="w-full flex justify-between items-center py-4">

            {{-- 1. โลโก้ และ ชื่อร้าน --}}
            <a href="/"
                class="flex items-center gap-3 text-xl font-display font-bold text-white hover:text-amber-400 transition-colors">
                <div
                    class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-600 rounded-lg flex items-center justify-center text-zinc-950 shadow-lg">
                    <flux:icon.wrench-screwdriver class="w-6 h-6" />
                </div>
                ศิริพงษ์ เซอร์วิส
            </a>

            {{-- 2. เมนูนำทาง (ซ่อนในมือถือ โชว์ในจอใหญ่) --}}
            {{-- 💡 สังเกต href="#..." มันจะวิ่งไปหา ID ของแต่ละ Section ที่เราทำไว้ในตอนที่แล้วครับ --}}
            {{-- 2. เมนูนำทาง (ซ่อนในมือถือ โชว์ในจอใหญ่) --}}
            {{-- 💡 แก้ไขโดยการใช้ <div> ธรรมดาในการจัดกลุ่มแทนครับ --}}
                <div class="hidden md:flex gap-8">
                    <flux:navbar.item href="#process" class="text-zinc-300 hover:text-white transition-colors">ขั้นตอน
                    </flux:navbar.item>
                    <flux:navbar.item href="#services" class="text-zinc-300 hover:text-white transition-colors">
                        บริการและราคา</flux:navbar.item>
                    <flux:navbar.item href="#gallery" class="text-zinc-300 hover:text-white transition-colors">ผลงาน
                    </flux:navbar.item>
                    <flux:navbar.item href="#faq" class="text-zinc-300 hover:text-white transition-colors">
                        คำถามที่พบบ่อย</flux:navbar.item>
                </div>

                {{-- 3. ปุ่มติดต่อด่วน --}}
                <flux:button href="#contact" variant="primary"
                    class="hidden md:flex !bg-amber-600 hover:!bg-amber-700 text-white font-display">
                    ประเมินราคาฟรี
                </flux:button>

                {{-- 💡 ปุ่มเมนูแฮมเบอร์เกอร์สำหรับมือถือ (แสดงเฉพาะหน้าจอเล็ก) --}}
                <div class="md:hidden">
                    <flux:button href="#contact" variant="ghost" class="text-amber-500">
                        ติดต่อช่าง
                    </flux:button>
                </div>

        </flux:navbar>
    </flux:header>

    {{-- ==========================================
    ส่วนเนื้อหาหลัก (Main Content) - ตัวบ้าน
    ========================================== --}}
    {{-- 💡 {{ $slot }} คือพื้นที่ว่างตรงกลางที่ Livewire จะเอาหน้า home.blade.php ของเรามาหยอดใส่ตรงนี้ --}}
    <main class="flex-grow">
        {{ $slot }}
    </main>

    {{-- ==========================================
    ส่วนท้าย (Footer) - รั้วหลังบ้าน
    ========================================== --}}
    <footer class="bg-zinc-950 text-white py-12 border-t border-zinc-900 mt-auto">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-center md:text-left">
                <div
                    class="font-display font-bold text-xl text-white mb-2 flex items-center justify-center md:justify-start gap-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    ศิริพงษ์ เซอร์วิส
                </div>
                <p class="text-zinc-400 text-sm">ช่างซ่อมเครื่องดูดฝุ่นอิสระ · กรุงเทพและปริมณฑล · ประสบการณ์ 20 ปี</p>
            </div>
            <div class="text-zinc-500 text-sm">
                &copy; {{ date('Y') }} ศิริพงษ์ เซอร์วิส. สงวนลิขสิทธิ์
            </div>
        </div>
    </footer>

    {{-- 💡 สคริปต์ของ Flux UI ที่จำเป็นต้องใส่ไว้ก่อนปิด body --}}
    @fluxScripts
</body>

</html>