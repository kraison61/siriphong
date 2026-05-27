<?php
use function Livewire\Volt\{state};

// 💡 สร้างข้อมูลจำลองของคำถาม-คำตอบ (ในอนาคตสามารถดึงจาก Database ได้)
state([
    'faqs' => [
        ['id' => 1, 'question' => 'ประเมินราคาฟรีจริงไหม มีค่าใช้จ่ายแอบแฝงหรือเปล่า?', 'answer' => 'ฟรี 100% ครับ เฮียต้อยจะประเมินจากรูป/คลิป หรือถ้าส่งเครื่องมาเช็คแล้วตกลงไม่ซ่อม ก็ส่งคืนให้ฟรี ไม่มีค่าตรวจเช็คใดๆ ทั้งสิ้นครับ'],
        ['id' => 2, 'question' => 'ใช้เวลาซ่อมนานแค่ไหน?', 'answer' => 'โดยปกติถ้ามีอะไหล่พร้อม จะใช้เวลาซ่อม 1-3 วันครับ แต่ถ้าต้องสั่งอะไหล่เฉพาะรุ่น อาจจะใช้เวลา 7-14 วัน ซึ่งเฮียต้อยจะแจ้งให้ทราบก่อนลงมือเสมอครับ'],
        ['id' => 3, 'question' => 'มีรับประกันหลังการซ่อมไหม?', 'answer' => 'มีครับ งานซ่อมทุกชิ้นรับประกันอาการเดิม 3 เดือนเต็ม หากมีปัญหาจากจุดที่ซ่อม เฮียต้อยดูแลแก้ไขให้ฟรีครับ'],
        ['id' => 4, 'question' => 'อยู่ต่างจังหวัด ส่งซ่อมได้ไหม?', 'answer' => 'ได้ครับ สามารถแพ็คลงกล่องกันกระแทกอย่างแน่นหนา แล้วส่งผ่านขนส่งเอกชน หรือไปรษณีย์ไทยมาได้เลยครับ พอซ่อมเสร็จเฮียจะจัดส่งกลับไปให้ถึงหน้าบ้านครับ'],
    ]
]);
?>

<section class="py-24 bg-white dark:bg-zinc-950" id="faq">
    <div class="max-w-3xl mx-auto px-6">

        {{-- หัวข้อ Section --}}
        <div class="text-center mb-16">
            <flux:heading level="2" class="text-3xl font-bold mb-4 text-zinc-900 dark:text-white">
                คำถามที่พบบ่อย (FAQ)
            </flux:heading>
            <flux:subheading class="text-zinc-600 dark:text-zinc-400">
                ข้อสงสัยก่อนส่งซ่อม เฮียต้อยรวบรวมคำตอบมาให้แล้วครับ
            </flux:subheading>
        </div>

        {{-- 💡 ระบบ Accordion ด้วย Alpine.js --}}
        {{-- x-data="{ active: null }" คือการสร้างตัวแปรมาจำว่า "ตอนนี้เปิดกล่องไหนอยู่" ถ้าเป็น null คือปิดหมด --}}
        <div x-data="{ active: null }" class="space-y-4">

            @foreach($faqs as $faq)
                <div
                    class="border border-zinc-200 dark:border-zinc-800 rounded-2xl bg-zinc-50 dark:bg-zinc-900/50 overflow-hidden shadow-sm">

                    {{-- 💡 ปุ่มกดคำถาม: พอกดปุ๊บ ให้เช็คว่ากล่องนี้เปิดอยู่ไหม ถ้าเปิดให้ปิด (null) ถ้าปิดให้เปิด (ใส่ ID
                    ของตัวเองลงไป) --}}
                    <button @click="active === {{ $faq['id'] }} ? active = null : active = {{ $faq['id'] }}"
                        class="w-full flex items-center justify-between p-6 text-left focus:outline-none hover:bg-zinc-100 dark:hover:bg-zinc-800/50 transition-colors">
                        <span class="font-bold text-zinc-900 dark:text-white text-lg">{{ $faq['question'] }}</span>

                        {{-- ไอคอนลูกศร: สั่งหมุน 180 องศาถ้ากล่องนี้กำลังเปิดอยู่ (active) --}}
                        <flux:icon.chevron-down class="w-5 h-5 text-zinc-400 transition-transform duration-300"
                            x-bind:class="active === {{ $faq['id'] }} ? 'rotate-180' : ''" />
                    </button>

                    {{-- 💡 กล่องคำตอบ: จะโชว์ (x-show) ก็ต่อเมื่อ ID ตรงกับตัวแปร active --}}
                    {{-- x-collapse คือคำสั่งสุดเจ๋งที่ทำให้มันยืด-หดแบบมีแอนิเมชันนุ่มนวล --}}
                    <div x-show="active === {{ $faq['id'] }}" x-collapse>
                        <div
                            class="p-6 pt-0 text-zinc-600 dark:text-zinc-400 border-t border-zinc-200/50 dark:border-zinc-800/50 mt-2">
                            {{ $faq['answer'] }}
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>