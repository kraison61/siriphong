<!DOCTYPE html>
<html
    lang="th"
    class="scroll-smooth"
    x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
    x-init="$watch('darkMode', v => localStorage.setItem('darkMode', v))"
    :class="{ 'dark': darkMode }"
>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    {{--
        $title ?? 'ค่าตั้งต้น'
        คือ: ถ้า component ส่ง $title มา → ใช้ค่านั้น
              ถ้าไม่ส่งมา → ใช้ "ศิริพงษ์ เซอร์วิส" แทน
        เหมือน: "ถ้าไม่บอกชื่อห้อง ก็ใช้ชื่อบ้านแทน"
    --}}
    <title>{{ $title ?? 'ศิริพงษ์ เซอร์วิส' }} | ช่างซ่อมเครื่องดูดฝุ่น</title>
    <meta
        name="description"
        content="{{ $description ?? 'ช่างศิริพงษ์ (เฮียต้อย) ช่างซ่อมเครื่องดูดฝุ่นทุกยี่ห้อ ประสบการณ์กว่า 20 ปี บริการทั่วกรุงเทพและปริมณฑล' }}"
    />

    {{-- Google Fonts: Kanit (หัวข้อ) + Sarabun (เนื้อหา) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;600;700;800&family=Sarabun:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    />

    {{--
        @vite([...]) — โหลด CSS/JS ที่ผ่านการ build ด้วย Vite
        เหมือน: "เปิดไฟฟ้าในบ้านจาก control panel"
    --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{--
        $head — ช่องเสริม ถ้า component ต้องการใส่ <script> หรือ <style> พิเศษ
        เหมือน: "ประตูทางเข้าพิเศษสำหรับแขก VIP"
    --}}
    {{ $head ?? '' }}
</head>

{{--
    Alpine.js x-data / :class คือ: ตัวควบคุม Dark Mode ระดับ HTML
    darkMode เก็บใน localStorage ของ browser
    เหมือน: "สวิตช์ไฟที่จดจำว่าเปิดหรือปิดค้างไว้"
--}}
<body class="bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 antialiased transition-colors duration-200">

    {{-- ============ HEADER ============ --}}
    {{--
        flux:header — แถบเมนูบนสุด (Sticky = ติดหน้าจอเมื่อ scroll)
        เหมือน: "ป้ายชื่อร้านที่แขวนตรึงไว้เหนือประตู ไม่ว่าจะเดินไปไหนก็เห็น"
    --}}
    <flux:header class="border-b border-zinc-200 dark:border-zinc-700 bg-white/90 dark:bg-zinc-900/90 backdrop-blur-md sticky top-0 z-50">

        <div class="max-w-6xl mx-auto w-full flex items-center gap-4 px-4 py-3">

            {{-- โลโก้ + ชื่อร้าน --}}
            <a href="/" class="flex items-center gap-2 font-display font-semibold text-zinc-900 dark:text-white">
                {{--
                    จุดสีทอง — สัญลักษณ์ของร้าน
                    w-2.5 h-2.5 = ขนาด 10px × 10px
                    ring-2 ring-amber-600/20 = วงแหวนรอบจุด
                --}}
                <span class="w-2.5 h-2.5 rounded-full bg-amber-600 ring-2 ring-amber-600/20 shrink-0"></span>
                <span class="font-kanit text-[1.05rem]">ศิริพงษ์ เซอร์วิส</span>
            </a>

            {{--
                flux:navbar — กลุ่มลิงก์เมนู
                จะซ่อนตัวเองบนหน้าจอเล็ก (มือถือ) โดยอัตโนมัติ
            --}}
            <flux:navbar class="hidden md:flex">
                <flux:navbar.item href="/#process">ขั้นตอน</flux:navbar.item>
                <flux:navbar.item href="/#services">บริการ</flux:navbar.item>
                <flux:navbar.item href="/#gallery">ผลงาน</flux:navbar.item>
                <flux:navbar.item href="/#faq">FAQ</flux:navbar.item>
                <flux:navbar.item href="/#contact">ติดต่อ</flux:navbar.item>

                {{-- เมนู Workshop (แสดงเฉพาะ dev — ลบออกเมื่อ deploy จริง) --}}
                @if(app()->isLocal())
                    <flux:separator vertical class="mx-1 h-5" />
                    <flux:navbar.item href="/workshop/buttons" class="text-amber-600 dark:text-amber-400">
                        🧪 Workshop
                    </flux:navbar.item>
                @endif
            </flux:navbar>

            {{--
                flux:spacer — ดัน element ข้างหลังไปชิดขวา
                เหมือน: "สปริงที่ดันของไปชิดขอบกล่อง"
            --}}
            <flux:spacer />

            {{-- ปุ่ม Dark Mode Toggle --}}
            {{--
                x-on:click คือ Alpine.js — รันโค้ด JS เมื่อคลิก
                เหมือน: "สวิตช์ไฟที่กดแล้วเปลี่ยนโหมดทันที"
            --}}
            <button
                x-on:click="darkMode = !darkMode"
                class="w-9 h-9 flex items-center justify-center rounded-lg text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                aria-label="สลับโหมดสว่าง/มืด"
            >
                {{-- ไอคอน Moon — แสดงตอน Light Mode --}}
                <svg x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/>
                </svg>
                {{-- ไอคอน Sun — แสดงตอน Dark Mode --}}
                <svg x-show="darkMode" xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>
                </svg>
            </button>

            {{-- ปุ่มโทรหาช่าง (CTA หลักใน Header) --}}
            <flux:button
                href="tel:+66612345678"
                icon="phone"
                variant="primary"
                size="sm"
                class="hidden sm:inline-flex"
            >
                061-234-5678
            </flux:button>

        </div>
    </flux:header>

    {{-- ============ MAIN CONTENT ============ --}}
    {{--
        $slot — "ช่องว่างกลางบ้าน"
        ทุก component ที่ใช้ layout นี้ จะเอาเนื้อหามาวางตรงนี้
        เหมือน: "กรอบรูปที่เปลี่ยนรูปได้ แต่กรอบเหมือนเดิม"
    --}}
    <main>
        {{ $slot }}
    </main>

    {{-- ============ FOOTER ============ --}}
    <footer class="bg-zinc-950 text-white mt-auto">
        <div class="max-w-6xl mx-auto px-4 py-8 flex flex-col sm:flex-row items-center justify-between gap-4">

            {{-- โลโก้ + tagline --}}
            <div>
                <div class="flex items-center gap-2 font-semibold text-white mb-1">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <span class="font-kanit">ศิริพงษ์ เซอร์วิส</span>
                </div>
                <p class="text-zinc-400 text-sm">ช่างซ่อมเครื่องดูดฝุ่นอิสระ · กรุงเทพและปริมณฑล · ประสบการณ์ 20 ปี</p>
            </div>

            {{-- Copyright --}}
            <p class="text-zinc-500 text-sm">© {{ date('Y') }} ศิริพงษ์ เซอร์วิส (เฮียต้อย)</p>

        </div>
    </footer>

    {{--
        @fluxScripts — โหลด JavaScript ของ Flux UI + Livewire + Alpine.js
        ต้องอยู่ก่อนปิด </body> เสมอ
        เหมือน: "เปิดระบบไฟฟ้าหลังติดตั้งเสร็จ"
    --}}
    @fluxScripts

</body>
</html>