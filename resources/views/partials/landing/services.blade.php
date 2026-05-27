{{-- resources/views/partials/landing/services.blade.php --}}
<section class="py-24 bg-slate-50 dark:bg-slate-900/50" id="services">
    <div class="max-w-7xl mx-auto px-6">

        {{-- หัวข้อ Section --}}
        <div class="text-center mb-16">
            <flux:heading level="2" class="text-3xl font-bold mb-4 text-slate-900 dark:text-white">
                บริการและราคาเบื้องต้น
            </flux:heading>
            <flux:subheading class="max-w-2xl mx-auto text-slate-600 dark:text-slate-400">
                ราคาจริงขึ้นอยู่กับยี่ห้อและรุ่นของเครื่องดูดฝุ่น เฮียต้อยจะประเมินราคาให้ทราบก่อนลงมือซ่อมจริงเสมอครับ
            </flux:subheading>
        </div>

        {{-- กล่องการ์ดบริการ 3 หมวด (Grid) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- Service 1: มอเตอร์/วงจร --}}
            <div
                class="bg-white dark:bg-slate-800 p-8 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow">
                <div
                    class="w-12 h-12 bg-amber-100 dark:bg-slate-700 text-amber-600 dark:text-amber-400 rounded-lg flex items-center justify-center mb-6">
                    <flux:icon.wrench-screwdriver class="w-6 h-6" />
                </div>
                <flux:heading level="3" class="text-xl font-bold mb-2 text-slate-900 dark:text-white">เปลี่ยนมอเตอร์ /
                    แผงวงจร</flux:heading>
                <p class="text-slate-600 dark:text-slate-400 text-sm mb-6 min-h-[60px]">
                    เครื่องดูดไม่ขึ้น มีกลิ่นเหม็นไหม้ หรือเปิดไม่ติด เรามีอะไหล่แท้และเทียบคุณภาพสูงรองรับ
                </p>
                <div
                    class="text-amber-600 dark:text-amber-400 font-bold text-lg border-t border-slate-100 dark:border-slate-700 pt-4">
                    เริ่มต้น 800.-
                </div>
            </div>

            {{-- Service 2: แบตเตอรี่ (ติดป้ายยอดฮิต) --}}
            <div
                class="bg-white dark:bg-slate-800 p-8 rounded-2xl border border-amber-200 dark:border-amber-700/50 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                {{-- ป้าย Tag มุมขวาบน --}}
                <div
                    class="absolute top-0 right-0 bg-amber-500 text-white text-xs font-bold px-3 py-1 rounded-bl-lg shadow-sm">
                    ยอดฮิต
                </div>

                <div
                    class="w-12 h-12 bg-amber-100 dark:bg-slate-700 text-amber-600 dark:text-amber-400 rounded-lg flex items-center justify-center mb-6">
                    <flux:icon.bolt class="w-6 h-6" />
                </div>
                <flux:heading level="3" class="text-xl font-bold mb-2 text-slate-900 dark:text-white">เปลี่ยนแบตเตอรี่
                </flux:heading>
                <p class="text-slate-600 dark:text-slate-400 text-sm mb-6 min-h-[60px]">
                    แบตเสื่อม ชาร์จไม่เข้า ดับกลางอากาศ (Dyson, Roomba) เปลี่ยนเซลล์แบตใหม่ใช้ได้ยาวๆ
                </p>
                <div
                    class="text-amber-600 dark:text-amber-400 font-bold text-lg border-t border-slate-100 dark:border-slate-700 pt-4">
                    เริ่มต้น 1,200.-
                </div>
            </div>

            {{-- Service 3: ทำความสะอาด --}}
            <div
                class="bg-white dark:bg-slate-800 p-8 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow">
                <div
                    class="w-12 h-12 bg-amber-100 dark:bg-slate-700 text-amber-600 dark:text-amber-400 rounded-lg flex items-center justify-center mb-6">
                    <flux:icon.sparkles class="w-6 h-6" />
                </div>
                <flux:heading level="3" class="text-xl font-bold mb-2 text-slate-900 dark:text-white">ล้างเครื่อง
                    (Overhaul)</flux:heading>
                <p class="text-slate-600 dark:text-slate-400 text-sm mb-6 min-h-[60px]">
                    แกะล้างทุกชิ้นส่วน กำจัดฝุ่นฝังลึก เชื้อรา แบคทีเรีย คืนชีพเครื่องดูดฝุ่นให้สะอาดเหมือนใหม่
                </p>
                <div
                    class="text-amber-600 dark:text-amber-400 font-bold text-lg border-t border-slate-100 dark:border-slate-700 pt-4">
                    เริ่มต้น 500.-
                </div>
            </div>

        </div>
    </div>
</section>