{{-- resources/views/partials/landing/brands.blade.php --}}
<section class="py-8 bg-zinc-900 border-y border-zinc-800">
    <div class="max-w-7xl mx-auto px-6">
        <p class="text-center text-sm font-medium text-zinc-400 mb-6 font-kanit">
            ประสบการณ์ซ่อมจริงจากแบรนด์ชั้นนำ
        </p>

        {{-- ใช้ Flexbox เรียงชื่อแบรนด์แนวนอน ถ้าหน้าจอเล็กจะปัดลงบรรทัดใหม่ให้อัตโนมัติ --}}
        <div class="flex flex-wrap justify-center items-center gap-x-12 gap-y-6 opacity-60">
            <div class="text-2xl font-bold text-white font-sans tracking-wider">dyson</div>
            <div class="text-xl font-bold text-white font-sans">Roomba</div>
            <div class="text-xl font-bold text-white font-sans italic">Electrolux</div>
            <div class="text-2xl font-bold text-white font-sans">PHILIPS</div>
            <div class="text-xl font-bold text-white font-sans tracking-tight">HITACHI</div>
            <div class="text-2xl font-bold text-white font-sans">Xiaomi</div>
        </div>
    </div>
</section>