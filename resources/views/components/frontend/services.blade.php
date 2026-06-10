<section class="py-18 bg-white" id="services" aria-labelledby="services-title">
  <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6 xl:px-8">
    <div data-reveal class="mb-10 opacity-0 translate-y-6 transition duration-700 ease-out data-[show=true]:opacity-100 data-[show=true]:translate-y-0">
      <div class="font-display text-xs font-semibold tracking-[.14em] uppercase text-orange">
        <i class="bi bi-tools" aria-hidden="true"></i> บริการของเรา
      </div>
      <h2 class="font-display font-bold leading-tight text-navy mt-2 text-[clamp(1.6rem,4vw,2.4rem)]" id="services-title">
        ซ่อมครบ ทุกประเภท<br>
        <span class="text-orange">เครื่องดูดฝุ่นอุตสาหกรรม</span>
      </h2>
    </div>

    <!-- Filter bar -->
    <div class="flex gap-2 overflow-x-auto pb-1 mb-8 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden" role="group" aria-label="กรองประเภทบริการ">
      <button onclick="filterServices('all')" aria-pressed="true" class="filter-btn inline-flex items-center gap-1.5 min-h-[44px] px-[18px] py-2.5 rounded-full text-sm font-semibold shrink-0 whitespace-nowrap border-[1.5px] border-slate-200 bg-white text-slate-700 transition-all hover:border-navy hover:text-navy aria-pressed:bg-navy aria-pressed:border-navy aria-pressed:text-white aria-pressed:shadow">
        <i class="bi bi-grid-fill" aria-hidden="true"></i> ทั้งหมด
      </button>
      <button onclick="filterServices('motor')" aria-pressed="false" class="filter-btn inline-flex items-center gap-1.5 min-h-[44px] px-[18px] py-2.5 rounded-full text-sm font-semibold shrink-0 whitespace-nowrap border-[1.5px] border-slate-200 bg-white text-slate-700 transition-all hover:border-navy hover:text-navy aria-pressed:bg-navy aria-pressed:border-navy aria-pressed:text-white aria-pressed:shadow">
        <i class="bi bi-cpu" aria-hidden="true"></i> มอเตอร์
      </button>
      <button onclick="filterServices('filter')" aria-pressed="false" class="filter-btn inline-flex items-center gap-1.5 min-h-[44px] px-[18px] py-2.5 rounded-full text-sm font-semibold shrink-0 whitespace-nowrap border-[1.5px] border-slate-200 bg-white text-slate-700 transition-all hover:border-navy hover:text-navy aria-pressed:bg-navy aria-pressed:border-navy aria-pressed:text-white aria-pressed:shadow">
        <i class="bi bi-funnel" aria-hidden="true"></i> ระบบกรอง
      </button>
      <button onclick="filterServices('electrical')" aria-pressed="false" class="filter-btn inline-flex items-center gap-1.5 min-h-[44px] px-[18px] py-2.5 rounded-full text-sm font-semibold shrink-0 whitespace-nowrap border-[1.5px] border-slate-200 bg-white text-slate-700 transition-all hover:border-navy hover:text-navy aria-pressed:bg-navy aria-pressed:border-navy aria-pressed:text-white aria-pressed:shadow">
        <i class="bi bi-lightning" aria-hidden="true"></i> ไฟฟ้า
      </button>
      <button onclick="filterServices('pipe')" aria-pressed="false" class="filter-btn inline-flex items-center gap-1.5 min-h-[44px] px-[18px] py-2.5 rounded-full text-sm font-semibold shrink-0 whitespace-nowrap border-[1.5px] border-slate-200 bg-white text-slate-700 transition-all hover:border-navy hover:text-navy aria-pressed:bg-navy aria-pressed:border-navy aria-pressed:text-white aria-pressed:shadow">
        <i class="bi bi-bezier2" aria-hidden="true"></i> ท่อดูด
      </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" id="services-grid">
      <!-- Card 1 -->
      <article data-reveal data-category="motor" class="service-card group relative overflow-hidden rounded-xl bg-white border border-slate-200 cursor-pointer transition-all opacity-0 translate-y-6 duration-700 ease-out data-[show=true]:opacity-100 data-[show=true]:translate-y-0 hover:border-navy-light hover:shadow-md hover:-translate-y-1">
        <div class="relative overflow-hidden aspect-video flex items-center justify-center text-[3.5rem] text-white/20 bg-[linear-gradient(135deg,#0f2347_0%,#3d5a80_100%)] after:content-[''] after:absolute after:inset-0 after:bg-[linear-gradient(to_bottom_right,rgba(242,101,34,.18),transparent)]">
          <i class="bi bi-gear-wide-connected" aria-hidden="true"></i>
          <span class="absolute top-2.5 left-2.5 z-[1] px-2.5 py-[3px] rounded-full bg-navy text-white text-[.68rem] font-bold tracking-wide uppercase">มอเตอร์</span>
          <span class="absolute top-2.5 right-2.5 z-[1] px-2.5 py-[3px] rounded-full bg-orange text-white text-[.68rem] font-bold tracking-wide uppercase">แนะนำ</span>
        </div>
        <div class="p-5">
          <h3 class="font-display font-bold text-[1.05rem] text-navy leading-snug mb-2">ซ่อมมอเตอร์เครื่องดูดฝุ่น</h3>
          <p class="text-sm text-slate-700 leading-relaxed mb-4 line-clamp-3">รับซ่อม/เปลี่ยน มอเตอร์ทุกขนาด แก้ปัญหามอเตอร์ไหม้ ได้กลิ่นเหม็นไหม้ เครื่องตัดการทำงาน หรือไม่หมุน พร้อมรับประกัน 3 เดือน</p>
          <div class="flex flex-wrap gap-1.5 mb-4">
            <span class="px-2.5 py-[3px] rounded bg-slate-100 text-navy-mid text-[.72rem] font-semibold">Nilfisk</span>
            <span class="px-2.5 py-[3px] rounded bg-slate-100 text-navy-mid text-[.72rem] font-semibold">Karcher</span>
            <span class="px-2.5 py-[3px] rounded bg-slate-100 text-navy-mid text-[.72rem] font-semibold">Roots</span>
            <span class="px-2.5 py-[3px] rounded bg-slate-100 text-navy-mid text-[.72rem] font-semibold">Numatic</span>
            <span class="px-2.5 py-[3px] rounded bg-slate-100 text-navy-mid text-[.72rem] font-semibold">Cleanfix</span>
          </div>
          <div class="flex items-center justify-between pt-4 border-t border-slate-100">
            <span class="text-sm font-bold text-orange"><i class="bi bi-tag-fill mr-1" aria-hidden="true"></i>ติดต่อขอราคา</span>
            <a href="#contact" class="inline-flex items-center justify-center gap-2 min-h-[40px] px-4 py-2 rounded-lg text-sm font-bold text-white bg-navy shadow transition-all hover:bg-navy-mid hover:-translate-y-0.5">ดูรายละเอียด <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
          </div>
        </div>
      </article>

      <!-- Card 2 -->
      <article data-reveal data-category="filter" class="service-card group relative overflow-hidden rounded-xl bg-white border border-slate-200 cursor-pointer transition-all opacity-0 translate-y-6 duration-700 ease-out delay-100 data-[show=true]:opacity-100 data-[show=true]:translate-y-0 hover:border-navy-light hover:shadow-md hover:-translate-y-1">
        <div class="relative overflow-hidden aspect-video flex items-center justify-center text-[3.5rem] text-white/20 bg-[linear-gradient(135deg,#1e4a8a,#0f2347)] after:content-[''] after:absolute after:inset-0 after:bg-[linear-gradient(to_bottom_right,rgba(242,101,34,.18),transparent)]">
          <i class="bi bi-funnel-fill" aria-hidden="true"></i>
          <span class="absolute top-2.5 left-2.5 z-[1] px-2.5 py-[3px] rounded-full bg-navy text-white text-[.68rem] font-bold tracking-wide uppercase">ระบบกรอง</span>
        </div>
        <div class="p-5">
          <h3 class="font-display font-bold text-[1.05rem] text-navy leading-snug mb-2">ซ่อมและเปลี่ยนไส้กรอง</h3>
          <p class="text-sm text-slate-700 leading-relaxed mb-4 line-clamp-3">เปลี่ยนไส้กรอง HEPA และกรองผ้า ทำความสะอาดระบบกรอง แก้ปัญหาประสิทธิภาพดูดฝุ่นลดลง ฝุ่นย้อนกลับ หรือมีกลิ่น</p>
          <div class="flex flex-wrap gap-1.5 mb-4">
            <span class="px-2.5 py-[3px] rounded bg-slate-100 text-navy-mid text-[.72rem] font-semibold">HEPA Filter</span>
            <span class="px-2.5 py-[3px] rounded bg-slate-100 text-navy-mid text-[.72rem] font-semibold">ผ้ากรอง</span>
          </div>
          <div class="flex items-center justify-between pt-4 border-t border-slate-100">
            <span class="text-sm font-bold text-orange"><i class="bi bi-tag-fill mr-1" aria-hidden="true"></i>เริ่มต้น ฿800</span>
            <a href="#contact" class="inline-flex items-center justify-center gap-2 min-h-[40px] px-4 py-2 rounded-lg text-sm font-bold text-white bg-navy shadow transition-all hover:bg-navy-mid hover:-translate-y-0.5">ดูรายละเอียด <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
          </div>
        </div>
      </article>

      <!-- Card 3 -->
      <article data-reveal data-category="electrical" class="service-card group relative overflow-hidden rounded-xl bg-white border border-slate-200 cursor-pointer transition-all opacity-0 translate-y-6 duration-700 ease-out delay-200 data-[show=true]:opacity-100 data-[show=true]:translate-y-0 hover:border-navy-light hover:shadow-md hover:-translate-y-1">
        <div class="relative overflow-hidden aspect-video flex items-center justify-center text-[3.5rem] text-white/20 bg-[linear-gradient(135deg,#1a3a6b,#0d2b5e)] after:content-[''] after:absolute after:inset-0 after:bg-[linear-gradient(to_bottom_right,rgba(242,101,34,.18),transparent)]">
          <i class="bi bi-lightning-charge-fill" aria-hidden="true"></i>
          <span class="absolute top-2.5 left-2.5 z-[1] px-2.5 py-[3px] rounded-full bg-navy text-white text-[.68rem] font-bold tracking-wide uppercase">ระบบไฟฟ้า</span>
        </div>
        <div class="p-5">
          <h3 class="font-display font-bold text-[1.05rem] text-navy leading-snug mb-2">ซ่อมระบบไฟฟ้าและวงจร</h3>
          <p class="text-sm text-slate-700 leading-relaxed mb-4 line-clamp-3">ซ่อมสวิตช์ บอร์ดควบคุม PCB ระบบ Inverter และอุปกรณ์ไฟฟ้าทุกชนิด แก้ปัญหาเครื่องไม่ติด ไฟกระพริบ Overload หรือน้ำเข้าตู้มอเตอร์จนช็อต</p>
          <div class="flex flex-wrap gap-1.5 mb-4">
            <span class="px-2.5 py-[3px] rounded bg-slate-100 text-navy-mid text-[.72rem] font-semibold">PCB</span>
            <span class="px-2.5 py-[3px] rounded bg-slate-100 text-navy-mid text-[.72rem] font-semibold">Inverter</span>
            <span class="px-2.5 py-[3px] rounded bg-slate-100 text-navy-mid text-[.72rem] font-semibold">Switch</span>
            <span class="px-2.5 py-[3px] rounded bg-slate-100 text-navy-mid text-[.72rem] font-semibold">Control Board</span>
          </div>
          <div class="flex items-center justify-between pt-4 border-t border-slate-100">
            <span class="text-sm font-bold text-orange"><i class="bi bi-tag-fill mr-1" aria-hidden="true"></i>ติดต่อขอราคา</span>
            <a href="#contact" class="inline-flex items-center justify-center gap-2 min-h-[40px] px-4 py-2 rounded-lg text-sm font-bold text-white bg-navy shadow transition-all hover:bg-navy-mid hover:-translate-y-0.5">ดูรายละเอียด <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
          </div>
        </div>
      </article>

      <!-- Card 4 -->
      <article data-reveal data-category="pipe" class="service-card group relative overflow-hidden rounded-xl bg-white border border-slate-200 cursor-pointer transition-all opacity-0 translate-y-6 duration-700 ease-out data-[show=true]:opacity-100 data-[show=true]:translate-y-0 hover:border-navy-light hover:shadow-md hover:-translate-y-1">
        <div class="relative overflow-hidden aspect-video flex items-center justify-center text-[3.5rem] text-white/20 bg-[linear-gradient(135deg,#2a5298,#1a3a6b)] after:content-[''] after:absolute after:inset-0 after:bg-[linear-gradient(to_bottom_right,rgba(242,101,34,.18),transparent)]">
          <i class="bi bi-bezier2" aria-hidden="true"></i>
          <span class="absolute top-2.5 left-2.5 z-[1] px-2.5 py-[3px] rounded-full bg-navy text-white text-[.68rem] font-bold tracking-wide uppercase">ท่อดูด</span>
        </div>
        <div class="p-5">
          <h3 class="font-display font-bold text-[1.05rem] text-navy leading-snug mb-2">ซ่อมท่อดูดและหัวดูด</h3>
          <p class="text-sm text-slate-700 leading-relaxed mb-4 line-clamp-3">ซ่อมและเปลี่ยนท่อดูด สายยาง และหัวดูดทุกรูปแบบ แก้ปัญหาท่อรั่ว แรงดูดอ่อน ดูดไม่เข้าถัง หรืออุดตัน</p>
          <div class="flex flex-wrap gap-1.5 mb-4">
            <span class="px-2.5 py-[3px] rounded bg-slate-100 text-navy-mid text-[.72rem] font-semibold">ท่อ PVC</span>
            <span class="px-2.5 py-[3px] rounded bg-slate-100 text-navy-mid text-[.72rem] font-semibold">สายยาง</span>
            <span class="px-2.5 py-[3px] rounded bg-slate-100 text-navy-mid text-[.72rem] font-semibold">หัวดูด</span>
          </div>
          <div class="flex items-center justify-between pt-4 border-t border-slate-100">
            <span class="text-sm font-bold text-orange"><i class="bi bi-tag-fill mr-1" aria-hidden="true"></i>เริ่มต้น ฿500</span>
            <a href="#contact" class="inline-flex items-center justify-center gap-2 min-h-[40px] px-4 py-2 rounded-lg text-sm font-bold text-white bg-navy shadow transition-all hover:bg-navy-mid hover:-translate-y-0.5">ดูรายละเอียด <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
          </div>
        </div>
      </article>

      <!-- Card 5 -->
      <article data-reveal data-category="motor" class="service-card group relative overflow-hidden rounded-xl bg-white border border-slate-200 cursor-pointer transition-all opacity-0 translate-y-6 duration-700 ease-out delay-100 data-[show=true]:opacity-100 data-[show=true]:translate-y-0 hover:border-navy-light hover:shadow-md hover:-translate-y-1">
        <div class="relative overflow-hidden aspect-video flex items-center justify-center text-[3.5rem] text-white/20 bg-[linear-gradient(135deg,#0f2347,#1e4a8a)] after:content-[''] after:absolute after:inset-0 after:bg-[linear-gradient(to_bottom_right,rgba(242,101,34,.18),transparent)]">
          <i class="bi bi-wrench-adjustable-circle-fill" aria-hidden="true"></i>
          <span class="absolute top-2.5 left-2.5 z-[1] px-2.5 py-[3px] rounded-full bg-navy text-white text-[.68rem] font-bold tracking-wide uppercase">Overhaul</span>
        </div>
        <div class="p-5">
          <h3 class="font-display font-bold text-[1.05rem] text-navy leading-snug mb-2">Overhaul เครื่องดูดฝุ่นครบระบบ</h3>
          <p class="text-sm text-slate-700 leading-relaxed mb-4 line-clamp-3">ถอดประกอบและบำรุงรักษาเครื่องดูดฝุ่นทั้งระบบ เปลี่ยนชิ้นส่วนสึกหรอ ทำความสะอาดภายใน ตรวจสอบตลับลูกปืน และทดสอบการทำงานทุกจุด</p>
          <div class="flex flex-wrap gap-1.5 mb-4">
            <span class="px-2.5 py-[3px] rounded bg-slate-100 text-navy-mid text-[.72rem] font-semibold">ครบระบบ</span>
            <span class="px-2.5 py-[3px] rounded bg-slate-100 text-navy-mid text-[.72rem] font-semibold">PM Service</span>
          </div>
          <div class="flex items-center justify-between pt-4 border-t border-slate-100">
            <span class="text-sm font-bold text-orange"><i class="bi bi-tag-fill mr-1" aria-hidden="true"></i>ราคาพิเศษ</span>
            <a href="#contact" class="inline-flex items-center justify-center gap-2 min-h-[40px] px-4 py-2 rounded-lg text-sm font-bold text-white bg-navy shadow transition-all hover:bg-navy-mid hover:-translate-y-0.5">ดูรายละเอียด <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
          </div>
        </div>
      </article>

      <!-- Card 6 -->
      <article data-reveal data-category="electrical" class="service-card group relative overflow-hidden rounded-xl bg-white border border-slate-200 cursor-pointer transition-all opacity-0 translate-y-6 duration-700 ease-out delay-200 data-[show=true]:opacity-100 data-[show=true]:translate-y-0 hover:border-navy-light hover:shadow-md hover:-translate-y-1">
        <div class="relative overflow-hidden aspect-video flex items-center justify-center text-[3.5rem] text-white/20 bg-[linear-gradient(135deg,#1a3a6b,#2a5298)] after:content-[''] after:absolute after:inset-0 after:bg-[linear-gradient(to_bottom_right,rgba(242,101,34,.18),transparent)]">
          <i class="bi bi-clipboard2-pulse-fill" aria-hidden="true"></i>
          <span class="absolute top-2.5 left-2.5 z-[1] px-2.5 py-[3px] rounded-full bg-navy text-white text-[.68rem] font-bold tracking-wide uppercase">ตรวจสอบ</span>
        </div>
        <div class="p-5">
          <h3 class="font-display font-bold text-[1.05rem] text-navy leading-snug mb-2">ตรวจสอบและวินิจฉัยอาการ</h3>
          <p class="text-sm text-slate-700 leading-relaxed mb-4 line-clamp-3">ตรวจวินิจฉัยอาการเสียอย่างละเอียด ระบุสาเหตุที่แท้จริง เช่น เสียงดังครืดๆ วี้ดๆ เครื่องตัดเอง หรือแรงดูดตก พร้อมประเมินราคาก่อนซ่อม</p>
          <div class="flex flex-wrap gap-1.5 mb-4">
            <span class="px-2.5 py-[3px] rounded bg-slate-100 text-navy-mid text-[.72rem] font-semibold">ฟรีตรวจสอบ</span>
            <span class="px-2.5 py-[3px] rounded bg-slate-100 text-navy-mid text-[.72rem] font-semibold">มีใบเสนอราคา</span>
          </div>
          <div class="flex items-center justify-between pt-4 border-t border-slate-100">
            <span class="text-sm font-bold text-orange"><i class="bi bi-tag-fill mr-1" aria-hidden="true"></i>ฟรี!</span>
            <a href="#contact" class="inline-flex items-center justify-center gap-2 min-h-[40px] px-4 py-2 rounded-lg text-sm font-bold text-white bg-orange shadow-[0_4px_16px_rgba(242,101,34,.35)] transition-all hover:bg-orange-dark hover:-translate-y-0.5">ติดต่อเลย <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
          </div>
        </div>
      </article>
    </div>
  </div>
</section>
