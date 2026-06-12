<?php
use function Livewire\Volt\{layout};

// 💡 สั่งให้หน้านี้ไปใช้ Layout ของหลังบ้าน (ที่เราเพิ่งสร้าง) แทนหน้าลูกค้าครับ
layout('components.layouts.admin');

?>

<div>
    <flux:heading level="1" class="text-3xl font-display font-bold mb-2">ยินดีต้อนรับสู่ระบบจัดการร้าน</flux:heading>
    <flux:subheading class="text-zinc-500 mb-8">สวัสดีครับเฮียต้อย!
        เลือกเมนูจากแถบด้านซ้ายเพื่อเริ่มจัดการข้อมูลได้เลยครับ</flux:subheading>

    {{-- กล่องข้อความต้อนรับ --}}
    <div
        class="bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20 rounded-xl p-6 flex items-start gap-4">
        <div class="p-3 bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 rounded-lg">
            <flux:icon.sparkles class="w-6 h-6" />
        </div>
        <div>
            <h3 class="text-lg font-bold text-amber-800 dark:text-amber-400">ระบบหลังบ้านพร้อมใช้งาน</h3>
            <p class="text-amber-700/80 dark:text-amber-400/80 mt-1">
                ในบทเรียนต่อไป เราจะนำข้อมูล "ใบรับงานซ่อม" ที่ลูกค้ากรอกไว้ มาแสดงผลเป็นตารางในหน้านี้กันครับ
            </p>
        </div>
    </div>
</div>