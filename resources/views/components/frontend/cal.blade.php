{{-- =============== SHIPPING CALCULATOR =============== --}}
<section class="py-12 bg-white" id="calculator" aria-labelledby="calc-title">
  <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">

    <div class="mb-10 text-center md:text-left">
      <div class="text-xs font-semibold tracking-[.14em] uppercase text-orange-500">เครื่องมือคำนวณ</div>
      <h2 class="font-bold leading-tight text-slate-900 mt-2 text-2xl md:text-3xl" id="calc-title">
        ส่งพัสดุ หรือให้ช่างไปรับ-ส่ง<span class="text-orange-500"> แบบไหนคุ้มกว่ากัน?</span>
      </h2>
      <p class="mt-2 text-sm text-slate-500">ระบุระยะทางจากร้าน เพื่อประเมินค่าใช้จ่ายในการให้ช่างไปรับ-ส่งเครื่อง</p>
    </div>

    <div
      class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 rounded-2xl bg-slate-50 border border-slate-200 p-6 lg:p-8 shadow-sm">

      {{-- ฝั่งซ้าย: ระบุระยะทาง (ใส่ h-fit เพื่อไม่ให้กล่องยืดตามความสูงฝั่งขวา) --}}
      <div
        class="lg:col-span-5 h-fit flex flex-col justify-center bg-white border border-slate-200 rounded-xl p-6 shadow-xs">
        <label for="calc-km"
          class="block font-semibold text-slate-900 mb-4 text-base flex justify-between items-center">
          <span>📍 ระยะทางจากร้านถึงบ้าน</span>
          <span id="calc-km-val" class="text-xl font-bold text-orange-500 bg-orange-50 px-3 py-1 rounded-md">0
            กม.</span>
        </label>

        <input type="range" id="calc-km" min="0" max="50" value="10"
          class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500">

        <div class="flex justify-between text-xs text-slate-400 mt-3 px-1">
          <span>0 กม. (ในพื้นที่)</span>
          <span>50+ กม.</span>
        </div>
      </div>

      {{-- ฝั่งขวา: ผลลัพธ์ (เปลี่ยนเป็น List แนวตั้ง) --}}
      <div class="lg:col-span-7 flex flex-col gap-4">
        {{-- บัตรเลือกช่างไปรับ-ส่ง (เน้นขอบสีส้ม) --}}
        <div
          class="relative overflow-hidden bg-white border-2 border-orange-500 rounded-xl p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-5 shadow-sm">
          {{-- ริบบิ้นมุมขวาบน --}}
          <div
            class="absolute top-0 right-0 bg-orange-500 text-white text-[10px] font-bold px-3 py-1 rounded-bl-lg tracking-wide">
            แนะนำ
          </div>

          <div class="flex-1">
            <div class="text-orange-500 text-xs font-bold mb-1">รูปแบบที่ 2</div>
            <h3 class="font-bold text-slate-900 text-base mb-1.5 flex items-center gap-2">
              🚐 บริการรับ-ส่งเครื่องโดยช่าง
            </h3>
            <p class="text-sm text-slate-500 leading-relaxed pr-4">
              ช่างเดินทางไปรับเครื่องเสียถึงหน้าบ้าน และนำกลับไปส่งคืนให้เมื่อซ่อมเสร็จ (คิดแบบไป-กลับ)
            </p>
          </div>
          <div
            class="sm:text-right shrink-0 bg-orange-50 sm:bg-transparent p-4 sm:p-0 rounded-lg border border-orange-100 sm:border-none mt-2 sm:mt-0">
            <div class="text-xs text-slate-500 mb-1">ค่าเดินทางโดยประมาณ</div>
            <div class="mt-1">
              <span id="res-travel" class="text-3xl font-black text-orange-600 tracking-tight">0</span>
              <span class="text-base font-medium text-slate-500 ml-1">บาท</span>
            </div>
          </div>
        </div>

        {{-- บัตรเลือกส่งพัสดุ --}}
        <div
          class="bg-white border border-slate-200 rounded-xl p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-5 transition-all hover:border-slate-300">
          <div class="flex-1">
            <div class="text-slate-500 text-xs font-medium mb-1">รูปแบบที่ 1</div>
            <h3 class="font-bold text-slate-900 text-base mb-1.5 flex items-center gap-2">
              📦 ส่งพัสดุผ่านขนส่งเอกชน
            </h3>
            <p class="text-sm text-slate-500 leading-relaxed">
              ลูกค้าแพ็คเครื่องจัดส่งมาเอง และร้านจัดส่งกลับให้เมื่อซ่อมเสร็จ
            </p>
          </div>
          <div
            class="sm:text-right shrink-0 bg-slate-50 sm:bg-transparent p-4 sm:p-0 rounded-lg border border-slate-100 sm:border-none">
            <div class="text-xs text-slate-500 mb-1">ค่าจัดส่งโดยประมาณ</div>
            <div class="text-sm font-bold text-slate-900 mt-2 sm:mt-1">ขึ้นอยู่กับบริษัทขนส่ง</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- สคริปต์คำนวณ Logic --}}
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const kmInput = document.getElementById('calc-km');
    const kmVal = document.getElementById('calc-km-val');
    const travelEl = document.getElementById('res-travel');

    // 🚐 ฟังก์ชันคิดค่าเดินทางเที่ยวเดียว
    function calculateSingleTripCost(km) {
      let cost = 50; // ค่าบริการเริ่มต้น
      if (km <= 10) {
        cost += km * 5;
      } else if (km <= 20) {
        cost += (10 * 18) + ((km - 10) * 7);
      } else {
        cost += (10 * 18) + (10 * 20) + ((km - 20) * 9);
      }
      return Math.round(cost);
    }

    function updateCalculator() {
      const km = parseInt(kmInput.value, 10);

      // 1. คำนวณค่าบริการช่างไปรับ-ส่ง (คิดแบบไป-กลับ จึงคูณ 2)
      const totalTravelCost = calculateSingleTripCost(km);

      // 2. อัปเดตการแสดงผลตัวเลขบนหน้าจอ
      kmVal.textContent = km + ' กม.';
      travelEl.textContent = totalTravelCost.toLocaleString('th-TH');
    }

    if (kmInput) {
      kmInput.addEventListener('input', updateCalculator);
      updateCalculator();
    }
  });
</script>