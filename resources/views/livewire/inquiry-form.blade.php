<?php
use function Livewire\Volt\{state, rules};

state([
    'name' => '',
    'phone' => '',
    'brand' => '',
    'symptom' => '',
]);

rules([
    'name' => 'required|min:2',
    'phone' => 'required|numeric|digits_between:9,10',
    'brand' => 'required',
    'symptom' => 'required|min:10',
])->messages([
            'required' => 'กรุณากรอกข้อมูลช่องนี้',
            'phone.numeric' => 'กรุณากรอกเฉพาะตัวเลขเท่านั้น',
            'phone.digits_between' => 'เบอร์โทรศัพท์ต้องมี 9 หรือ 10 หลัก',
            'symptom.min' => 'ช่วยอธิบายอาการสักนิดนะครับ (อย่างน้อย 10 ตัวอักษร)',
        ]);

$save = function () {
    $this->validate();

    $this->dispatch(
        'notify',
        heading: 'ได้รับข้อมูลเรียบร้อยครับ',
        text: 'เฮียต้อยจะรีบประเมินอาการและติดต่อกลับไปหาคุณ ' . $this->name . ' โดยเร็วที่สุดครับ',
        variant: 'success'
    );

    $this->reset();
};
?>

<section class="py-24 bg-slate-50 dark:bg-slate-900/50" id="contact">
    {{-- 💡 ปรับให้กว้างขึ้นเป็น max-w-6xl เพื่อรองรับ 2 ฝั่ง --}}
    <div class="max-w-6xl mx-auto px-6">

        {{-- กล่องใหญ่ แบ่ง 2 ฝั่งเมื่อเป็นหน้าจอคอม (lg:flex-row) --}}
        <div
            class="bg-white dark:bg-slate-800 rounded-3xl overflow-hidden shadow-xl border border-slate-100 dark:border-slate-700 flex flex-col lg:flex-row">

            {{-- ==========================================
            ฝั่งซ้าย: ข้อมูลติดต่อ & QR Code (พื้นที่สีดำ)
            ========================================== --}}
            <div
                class="w-full lg:w-5/12 bg-zinc-900 text-white p-8 md:p-12 flex flex-col justify-between relative overflow-hidden">
                {{-- วงกลมสีๆ ตกแต่งพื้นหลัง --}}
                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none">
                </div>

                <div class="relative z-10">
                    <flux:heading level="2" class="text-3xl font-bold mb-4 text-white">
                        ติดต่อเฮียต้อย
                    </flux:heading>
                    <p class="text-zinc-400 mb-8 leading-relaxed">
                        สะดวกส่งรูปประเมินอาการทางไลน์ หรือโทรสอบถามเบื้องต้นได้เลยครับ ยินดีให้คำปรึกษาฟรี
                        ไม่มีค่าใช้จ่ายแอบแฝง
                    </p>

                    <div class="space-y-6 mb-8">
                        {{-- เบอร์โทร --}}
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center text-amber-400">
                                <flux:icon.phone class="w-6 h-6" />
                            </div>
                            <div>
                                <div class="text-sm text-zinc-400 font-medium">โทรศัพท์</div>
                                <div class="text-lg font-bold text-white tracking-wider">061-234-5678</div>
                            </div>
                        </div>

                        {{-- Line ID --}}
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-full bg-[#06c755]/20 flex items-center justify-center text-[#06c755]">
                                <flux:icon.chat-bubble-left-ellipsis class="w-6 h-6" />
                            </div>
                            <div>
                                <div class="text-sm text-zinc-400 font-medium">Line ID</div>
                                <div class="text-lg font-bold text-white">@siripong.service</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- กล่อง QR Code --}}
                <div
                    class="relative z-10 bg-white/5 rounded-2xl p-6 border border-white/10 text-center backdrop-blur-sm mt-4 lg:mt-8">
                    <p class="text-sm text-zinc-300 mb-4 font-medium">สแกน QR Code เพื่อแอดไลน์</p>
                    <div class="inline-block p-3 bg-white rounded-xl shadow-lg">
                        {{-- 💡 ใช้ API สร้าง QR Code จำลองชั่วคราว คุณสามารถนำรูป QR Code จริงของร้านมาใส่แทนลิงก์ src
                        นี้ได้เลยครับ --}}
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://line.me/R/ti/p/@siripong.service"
                            alt="Line QR Code" class="w-32 h-32">
                    </div>
                </div>
            </div>

            {{-- ==========================================
            ฝั่งขวา: ฟอร์มรับงาน (พื้นที่สีขาว/เทา)
            ========================================== --}}
            <div class="w-full lg:w-7/12 p-8 md:p-12">
                <div class="mb-8">
                    <flux:heading level="3" class="text-2xl font-bold mb-2 text-slate-900 dark:text-white">
                        ส่งอาการให้ประเมินฟรี
                    </flux:heading>
                    <p class="text-slate-600 dark:text-slate-400 text-sm">
                        กรอกข้อมูลด้านล่างให้ครบถ้วน เฮียต้อยจะรีบติดต่อกลับครับ
                    </p>
                </div>

                <form wire:submit="save" class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <flux:input wire:model="name" label="ชื่อ-นามสกุล / ชื่อเล่น" placeholder="เช่น คุณเอ" />
                        <flux:input wire:model="phone" label="เบอร์โทรศัพท์ติดต่อ" placeholder="08xxxxxxxx" />
                    </div>

                    <flux:select wire:model="brand" label="ยี่ห้อเครื่องดูดฝุ่น" placeholder="เลือกยี่ห้อ">
                        <flux:select.option value="Dyson">Dyson</flux:select.option>
                        <flux:select.option value="Roomba">Roomba (iRobot)</flux:select.option>
                        <flux:select.option value="Electrolux">Electrolux</flux:select.option>
                        <flux:select.option value="Philips">Philips</flux:select.option>
                        <flux:select.option value="Hitachi">Hitachi</flux:select.option>
                        <flux:select.option value="Xiaomi">Xiaomi</flux:select.option>
                        <flux:select.option value="Other">อื่นๆ (ระบุในรายละเอียด)</flux:select.option>
                    </flux:select>

                    <flux:textarea wire:model="symptom" label="อาการที่เสีย (อธิบายคร่าวๆ)"
                        placeholder="เช่น เปิดไม่ติด, ชาร์จแบตไม่เข้า, มีกลิ่นไหม้, ดูดฝุ่นไม่ขึ้น..." rows="4" />

                    <div class="pt-2">
                        <flux:button type="submit"
                            class="w-full !bg-amber-600 hover:!bg-amber-700 text-white py-3 text-base">
                            <span wire:loading.remove>ส่งข้อมูลให้ประเมินฟรี</span>
                            <span wire:loading>กำลังส่งข้อมูล...</span>
                        </flux:button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>