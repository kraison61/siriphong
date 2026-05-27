{{-- resources/views/partials/landing/hero.blade.php --}}
<section class="relative overflow-hidden bg-zinc-950 text-white py-24" id="hero">
    {{-- วงกลมตกแต่งฉากหลัง (แปลงจาก CSS เดิมมาใช้ Tailwind) --}}
    <div
        class="absolute -top-32 -right-32 w-[440px] h-[440px] rounded-full bg-amber-600/20 blur-3xl pointer-events-none">
    </div>
    <div
        class="absolute -bottom-32 -left-20 w-[320px] h-[320px] rounded-full bg-amber-500/10 blur-3xl pointer-events-none">
    </div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 items-center">

            {{-- ฝั่งซ้าย: ข้อความและปุ่ม --}}
            <div>
                <flux:heading level="1" class="text-4xl lg:text-5xl font-bold text-white mb-4">
                    อย่าเพิ่งทิ้ง! <span class="text-amber-400">เครื่องดูดฝุ่นพัง</span><br />
                    ให้เฮียต้อยดูแลก่อน
                </flux:heading>

                <flux:subheading class="text-lg text-white/75 mb-8 max-w-lg">
                    รับซ่อมเครื่องดูดฝุ่นทุกยี่ห้อ (Dyson, Roomba, Electrolux ฯลฯ) <strong
                        class="text-amber-300">ประเมินอาการฟรีผ่าน Line</strong> ก่อนตัดสินใจ ไม่มีค่าตรวจเช็คซ่อน
                    ทุกขั้นตอนโปร่งใส ตรวจสอบได้
                </flux:subheading>

                <div class="flex flex-wrap gap-4">
                    {{-- ปุ่ม Add Line: ลบ size="lg" ออก แล้วเสริมความใหญ่ด้วยคลาสของ Tailwind (px-6 py-3 text-base)
                    --}}
                    <flux:button href="#contact"
                        class="!bg-[#06c755] !border-[#06c755] hover:!bg-[#05a847] text-white px-6 py-3 text-base"
                        icon="chat-bubble-left-ellipsis">
                        Add Line ประเมินฟรี
                    </flux:button>

                    {{-- ปุ่มโทรหาช่าง: ลบ size="lg" ออกเช่นกัน --}}
                    <flux:button href="tel:+66612345678" variant="ghost"
                        class="text-white border-white/20 hover:bg-white/10 px-6 py-3 text-base" icon="phone">
                        โทรหาช่าง
                    </flux:button>
                </div>
            </div>

            {{-- ฝั่งขวา: นามบัตรช่าง (แปลงจาก Hero Card เดิม) --}}
            <div class="bg-white/5 border border-white/10 rounded-2xl p-8 backdrop-blur-md shadow-2xl relative">
                {{-- เส้นขอบบนตกแต่ง --}}
                <div
                    class="absolute top-0 left-8 right-8 h-px bg-gradient-to-r from-transparent via-amber-500 to-transparent">
                </div>

                <div class="flex items-center gap-4 mb-6">
                    <div
                        class="w-14 h-14 rounded-full bg-gradient-to-br from-amber-600 to-amber-400 flex items-center justify-center text-white shadow-lg">
                        <flux:icon.user class="w-6 h-6" />
                    </div>
                    <div>
                        <div class="font-bold text-lg">ช่างศิริพงษ์</div>
                        <div class="text-sm text-white/70">เฮียต้อย · ช่างซ่อมเครื่องดูดฝุ่นอิสระ</div>
                    </div>
                </div>

                <flux:separator variant="subtle" class="my-4 border-white/10" />

                <div class="flex items-center gap-4">
                    <div class="text-3xl font-bold text-amber-400">20+</div>
                    <div class="text-sm text-white/70">ปี ที่อยู่กับเครื่องดูดฝุ่นทุกยี่ห้อ</div>
                </div>
            </div>

        </div>
    </div>
</section>