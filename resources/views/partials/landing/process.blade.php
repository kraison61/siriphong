{{-- resources/views/partials/landing/process.blade.php --}}
<section class="py-24 bg-white dark:bg-zinc-950" id="process">
    <div class="max-w-7xl mx-auto px-6">

        {{-- หัวข้อ Section --}}
        <div class="text-center mb-16">
            <flux:heading level="2" class="text-3xl font-bold mb-4 text-zinc-900 dark:text-white">
                ซ่อมง่ายๆ ใน 3 ขั้นตอน
            </flux:heading>
            <flux:subheading class="max-w-2xl mx-auto text-zinc-600 dark:text-zinc-400">
                ไม่ต้องยกเครื่องมาให้เหนื่อย แค่ถ่ายรูปส่งมา เราจัดการประเมินให้ก่อน ไม่มีค่าใช้จ่ายแอบแฝง
            </flux:subheading>
        </div>

        {{-- กล่อง 3 ขั้นตอน (Grid) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- Step 1 --}}
            <div
                class="text-center p-8 border border-zinc-200 dark:border-zinc-800 rounded-2xl bg-zinc-50 dark:bg-zinc-900/50 hover:border-amber-500/50 transition-colors">
                <div
                    class="w-16 h-16 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6">
                    1
                </div>
                <flux:heading level="3" class="text-xl font-bold mb-3 text-zinc-900 dark:text-white">แอดไลน์
                    ถ่ายรูปอาการ</flux:heading>
                <p class="text-zinc-600 dark:text-zinc-400 text-sm">ถ่ายคลิปหรือรูปจุดที่พัง ส่งมาทาง Line
                    เพื่อให้เฮียต้อยดูอาการเบื้องต้น</p>
            </div>

            {{-- Step 2 --}}
            <div
                class="text-center p-8 border border-zinc-200 dark:border-zinc-800 rounded-2xl bg-zinc-50 dark:bg-zinc-900/50 hover:border-amber-500/50 transition-colors relative">
                {{-- ลูกศรชี้ (แสดงเฉพาะหน้าจอใหญ่) --}}
                <div class="hidden md:block absolute top-1/3 -left-8 text-zinc-300 dark:text-zinc-700">
                    <flux:icon.chevron-right class="w-10 h-10" />
                </div>

                <div
                    class="w-16 h-16 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6">
                    2
                </div>
                <flux:heading level="3" class="text-xl font-bold mb-3 text-zinc-900 dark:text-white">ประเมินราคาฟรี
                </flux:heading>
                <p class="text-zinc-600 dark:text-zinc-400 text-sm">แจ้งราคาค่าอะไหล่และค่าแรงให้ทราบก่อน
                    หากตกลงซ่อมค่อยนัดหมายส่งเครื่อง</p>
            </div>

            {{-- Step 3 --}}
            <div
                class="text-center p-8 border border-zinc-200 dark:border-zinc-800 rounded-2xl bg-zinc-50 dark:bg-zinc-900/50 hover:border-amber-500/50 transition-colors relative">
                <div class="hidden md:block absolute top-1/3 -left-8 text-zinc-300 dark:text-zinc-700">
                    <flux:icon.chevron-right class="w-10 h-10" />
                </div>

                <div
                    class="w-16 h-16 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6">
                    3
                </div>
                <flux:heading level="3" class="text-xl font-bold mb-3 text-zinc-900 dark:text-white">ซ่อมเสร็จ
                    รับประกันงาน</flux:heading>
                <p class="text-zinc-600 dark:text-zinc-400 text-sm">รับเครื่องคืนพร้อมใช้งานจริง มีรับประกันงานซ่อม 3
                    เดือนเต็ม</p>
            </div>

        </div>
    </div>
</section>