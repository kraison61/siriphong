{{-- =============== PROCESS & CONDITIONS =============== --}}
<section class="py-18 bg-offwhite" id="process" aria-labelledby="process-title">
    <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">

        {{-- Section heading --}}
        <div data-reveal
            class="opacity-0 translate-y-6 transition duration-700 ease-out data-[show=true]:opacity-100 data-[show=true]:translate-y-0 mb-12">
            <div class="font-display text-xs font-semibold tracking-[.14em] uppercase text-orange">Process &amp;
                Conditions</div>
            <h2 class="font-display font-bold leading-tight text-navy mt-2 text-[clamp(1.6rem,4vw,2.4rem)]"
                id="process-title">
                ขั้นตอนการส่งซ่อม<span class="text-orange">และเงื่อนไขบริการ</span>
            </h2>
            <p class="mt-2 text-sm text-slate-500">ชัดเจน โปร่งใส ตั้งแต่การประเมินจนถึงการรับเครื่องคืน</p>
        </div>

        <div class="flex flex-col gap-5">

            {{-- Phase 1 --}}
            <div data-reveal
                class="opacity-0 translate-y-6 transition duration-700 ease-out data-[show=true]:opacity-100 data-[show=true]:translate-y-0 rounded-xl bg-white border border-slate-200 p-6 md:p-7 shadow-sm">
                <div class="flex items-start gap-4 mb-5">
                    <div
                        class="shrink-0 w-10 h-10 rounded-full bg-orange flex items-center justify-center font-display font-bold text-white text-sm">
                        1</div>
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="font-display font-bold text-navy text-[1.05rem]">ประเมินเบื้องต้นออนไลน์</span>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-[#e6f9ed] border border-line/30 text-[#0a8f3c] text-xs font-semibold">ฟรี
                                100%</span>
                        </div>
                        <div class="text-xs text-slate-400 mt-0.5">Initial Online Screening</div>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-2 pl-14">
                    <span
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-slate-50 border border-slate-200 text-sm text-slate-600">
                        <i class="bi bi-chat-dots-fill text-line text-xs" aria-hidden="true"></i>
                        แอด LINE
                    </span>
                    <i class="bi bi-arrow-right text-slate-300 text-xs" aria-hidden="true"></i>
                    <span
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-slate-50 border border-slate-200 text-sm text-slate-600">
                        <i class="bi bi-camera-fill text-orange text-xs" aria-hidden="true"></i>
                        ส่งรูป / วิดีโออาการเสีย
                    </span>
                    <i class="bi bi-arrow-right text-slate-300 text-xs" aria-hidden="true"></i>
                    <span
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-slate-50 border border-slate-200 text-sm text-slate-600">
                        <i class="bi bi-check-circle-fill text-orange text-xs" aria-hidden="true"></i>
                        รับการประเมินเบื้องต้น
                    </span>
                </div>
            </div>

            {{-- Phase 2 --}}
            <div data-reveal
                class="opacity-0 translate-y-6 transition duration-700 ease-out delay-100 data-[show=true]:opacity-100 data-[show=true]:translate-y-0 rounded-xl bg-white border border-slate-200 p-6 md:p-7 shadow-sm">
                <div class="flex items-start gap-4 mb-5">
                    <div
                        class="shrink-0 w-10 h-10 rounded-full bg-orange flex items-center justify-center font-display font-bold text-white text-sm">
                        2</div>
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="font-display font-bold text-navy text-[1.05rem]">ค่าตรวจเช็คเครื่อง</span>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-orange/10 border border-orange/30 text-orange text-xs font-semibold">250
                                บาท</span>
                        </div>
                        <div class="text-xs text-slate-400 mt-0.5">Physical Inspection Fee —
                            มีผลเฉพาะเมื่อต้องนำเครื่องมาตรวจโดยตรง</div>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pl-0 sm:pl-14">
                    <div class="flex gap-3 p-4 rounded-lg bg-[#e6f9ed] border border-line/25">
                        <i class="bi bi-check-circle-fill text-line mt-0.5 shrink-0" aria-hidden="true"></i>
                        <div>
                            <div class="text-sm font-semibold text-navy mb-1">ตัดสินใจซ่อม</div>
                            <p class="text-xs text-slate-600 leading-relaxed">หัก <strong class="text-navy">250
                                    บาทออกจากค่าซ่อมทันที</strong> — ค่าตรวจฟรีโดยปริยาย</p>
                        </div>
                    </div>
                    <div class="flex gap-3 p-4 rounded-lg bg-slate-50 border border-slate-200">
                        <i class="bi bi-x-circle-fill text-slate-300 mt-0.5 shrink-0" aria-hidden="true"></i>
                        <div>
                            <div class="text-sm font-semibold text-navy mb-1">ไม่ซ่อม</div>
                            <p class="text-xs text-slate-600 leading-relaxed">ชำระเฉพาะ<strong class="text-navy">ค่าตรวจ
                                    250 บาท</strong>เท่านั้น ไม่มีค่าใช้จ่ายอื่น</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Phase 3 --}}
            <div data-reveal
                class="opacity-0 translate-y-6 transition duration-700 ease-out delay-200 data-[show=true]:opacity-100 data-[show=true]:translate-y-0 rounded-xl bg-white border border-slate-200 p-6 md:p-7 shadow-sm">
                <div class="flex items-start gap-4 mb-5">
                    <div
                        class="shrink-0 w-10 h-10 rounded-full bg-orange flex items-center justify-center font-display font-bold text-white text-sm">
                        3</div>
                    <div>
                        <span
                            class="font-display font-bold text-navy text-[1.05rem]">เงื่อนไขค่าขนส่งและค่าเดินทาง</span>
                        <div class="text-xs text-slate-400 mt-0.5">Delivery &amp; Return Shipping Conditions</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pl-0 sm:pl-14">

                    {{-- Option A --}}
                    <div class="rounded-lg border border-slate-200 overflow-hidden">
                        <div class="flex items-center gap-3 px-4 py-3 bg-slate-50 border-b border-slate-200">
                            <i class="bi bi-box-seam text-orange" aria-hidden="true"></i>
                            <div>
                                <span class="text-[.65rem] font-semibold tracking-widest uppercase text-orange">Option
                                    A</span>
                                <div class="text-sm font-semibold text-navy">ลูกค้าส่งพัสดุผ่านขนส่งเอกชน</div>
                                <div class="text-xs text-slate-400">Kerry · Flash · ไปรษณีย์ไทย ฯลฯ</div>
                            </div>
                        </div>
                        <div class="divide-y divide-slate-100">
                            <div class="flex items-start gap-3 px-4 py-3">
                                <i class="bi bi-check-circle-fill text-line text-sm mt-0.5 shrink-0"
                                    aria-hidden="true"></i>
                                <div class="text-xs text-slate-600 leading-relaxed">
                                    <span class="font-semibold text-navy">ค่าซ่อมตั้งแต่ 3,000 บาทขึ้นไป</span><br>
                                    <strong class="text-[#0a8f3c]">ร้านออกค่าส่งคืนให้ฟรี</strong> (ขากลับ)
                                </div>
                            </div>
                            <div class="flex items-start gap-3 px-4 py-3">
                                <i class="bi bi-dash-circle text-slate-300 text-sm mt-0.5 shrink-0"
                                    aria-hidden="true"></i>
                                <div class="text-xs text-slate-600 leading-relaxed">
                                    <span class="font-semibold text-navy">ค่าซ่อมต่ำกว่า 3,000 บาท
                                        หรือไม่ซ่อม</span><br>
                                    ลูกค้ารับผิดชอบ<strong class="text-navy">ค่าส่งคืนตามอัตราจริง</strong>ของขนส่ง
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Option B --}}
                    <div class="rounded-lg border border-slate-200 overflow-hidden">
                        <div class="flex items-center gap-3 px-4 py-3 bg-slate-50 border-b border-slate-200">
                            <i class="bi bi-truck text-orange" aria-hidden="true"></i>
                            <div>
                                <span class="text-[.65rem] font-semibold tracking-widest uppercase text-orange">Option
                                    B</span>
                                <div class="text-sm font-semibold text-navy">ร้านรับ-ส่ง หรือบริการนอกสถานที่ (ประเมิน)
                                </div>
                                <div class="text-xs text-slate-400">ค่าเดินทางขาไปคิดตามระยะทางจริง · <a
                                        href="#calculator" class="text-orange hover:underline">คำนวณ →</a></div>
                            </div>
                        </div>
                        <div class="divide-y divide-slate-100">
                            <div class="flex items-start gap-3 px-4 py-3">
                                <i class="bi bi-check-circle-fill text-line text-sm mt-0.5 shrink-0"
                                    aria-hidden="true"></i>
                                <div class="text-xs text-slate-600 leading-relaxed">
                                    <span class="font-semibold text-navy">ค่าซ่อมตั้งแต่ 3,000 บาทขึ้นไป</span><br>
                                    <strong class="text-[#0a8f3c]">ร้านออกค่าเดินทางส่งคืนให้ฟรี</strong> (ขากลับ)
                                </div>
                            </div>
                            <div class="flex items-start gap-3 px-4 py-3">
                                <i class="bi bi-dash-circle text-slate-300 text-sm mt-0.5 shrink-0"
                                    aria-hidden="true"></i>
                                <div class="text-xs text-slate-600 leading-relaxed">
                                    <span class="font-semibold text-navy">ค่าซ่อมต่ำกว่า 3,000 บาท
                                        หรือไม่ซ่อม</span><br>
                                    ค่าเดินทางส่งคืน<strong class="text-navy">คิดตามระยะทางจริง</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>