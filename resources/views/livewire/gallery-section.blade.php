<?php
use function Livewire\Volt\{state};

// 💡 1. เพิ่มลิงก์รูปภาพจำลอง (img) เข้ามาในข้อมูลของเรา
state([
    'photos' => [
        ['id' => 1, 'title' => 'ซ่อมบอร์ด Dyson V11', 'desc' => 'เปิดไม่ติด เปลี่ยนชิปไอซีแท้ใหม่', 'img' => 'https://placehold.co/800x600/1e293b/fde047?text=Dyson+V11'],
        ['id' => 2, 'title' => 'เปลี่ยนแบต Roomba i7', 'desc' => 'วิ่งได้ 10 นาทีแบตหมด เปลี่ยนเซลล์ใหม่', 'img' => 'https://placehold.co/800x600/1e293b/fde047?text=Roomba+i7'],
        ['id' => 3, 'title' => 'ล้างระบบ Electrolux', 'desc' => 'ฝุ่นอุดตัน มอเตอร์ไหม้ ล้างใหม่ทั้งระบบ', 'img' => 'https://placehold.co/800x600/1e293b/fde047?text=Electrolux'],
        ['id' => 4, 'title' => 'ซ่อมมอเตอร์ดูดฝุ่น', 'desc' => 'เสียงดังผิดปกติ เปลี่ยนลูกปืนมอเตอร์', 'img' => 'https://placehold.co/800x600/1e293b/fde047?text=Motor+Repair'],
    ]
]);
?>

{{-- 💡 2. ใช้ x-data เพื่อประกาศตัวแปรและฟังก์ชันของ Alpine.js คลุมทั้ง Section --}}
<section class="py-24 bg-white dark:bg-zinc-950" id="gallery" x-data="{
        isOpen: false,
        currentIndex: 0,
        photos: @js($photos), // โยนข้อมูลจาก PHP มาให้ JavaScript ใช้
        
        get currentPhoto() { return this.photos[this.currentIndex]; },
        
        openGallery(index) {
            this.currentIndex = index;
            this.isOpen = true;
            document.body.classList.add('overflow-hidden'); // ล็อกไม่ให้หน้าเว็บข้างหลังเลื่อนได้
        },
        closeGallery() {
            this.isOpen = false;
            document.body.classList.remove('overflow-hidden');
        },
        next() {
            this.currentIndex = this.currentIndex === this.photos.length - 1 ? 0 : this.currentIndex + 1;
        },
        prev() {
            this.currentIndex = this.currentIndex === 0 ? this.photos.length - 1 : this.currentIndex - 1;
        }
    }" {{-- รองรับการกดปุ่มบนคีย์บอร์ด (Esc เพื่อปิด, ลูกศรซ้าย-ขวาเพื่อเปลี่ยนรูป) --}}
    @keydown.window.escape="closeGallery()" @keydown.window.arrow-right="next()" @keydown.window.arrow-left="prev()">
    <div class="max-w-7xl mx-auto px-6">

        {{-- หัวข้อ Section --}}
        <div class="text-center mb-16">
            <flux:heading level="2" class="text-3xl font-bold mb-4 text-zinc-900 dark:text-white">
                ผลงานซ่อมที่ผ่านมา
            </flux:heading>
            <flux:subheading class="max-w-2xl mx-auto text-zinc-600 dark:text-zinc-400">
                ภาพบางส่วนจากเครื่องดูดฝุ่นกว่า 1,000 เครื่องที่ผ่านมือเฮียต้อย
            </flux:subheading>
        </div>

        {{-- ตารางกริดแสดงรูปภาพ --}}
        {{-- ==========================================
        แบบใหม่: Carousel + ปุ่มเลื่อนซ้ายขวาสำหรับ Desktop
        ========================================== --}}

        {{-- 💡 1. เพิ่มกล่องคลุม (wrapper) และใช้ Alpine.js กำหนดฟังก์ชันเลื่อนรูป --}}
        <div class="relative group" x-data="{
            scrollAmount: 350, // ระยะที่จะเลื่อนในแต่ละครั้ง (อิงตามความกว้างรูป)
            scrollLeft() {
                this.$refs.carousel.scrollBy({ left: -this.scrollAmount, behavior: 'smooth' });
            },
            scrollRight() {
                this.$refs.carousel.scrollBy({ left: this.scrollAmount, behavior: 'smooth' });
            }
        }">

            {{-- 💡 2. ปุ่มเลื่อนซ้าย (ซ่อนในมือถือ โชว์ในจอ md ขึ้นไป) --}}
            {{-- opacity-0 group-hover:opacity-100 จะทำให้ปุ่มโชว์ขึ้นมาเฉพาะตอนเอาเมาส์ไปชี้แถวๆ รูปภาพครับ --}}
            <button @click="scrollLeft()"
                class="hidden md:flex absolute -left-4 top-[40%] -translate-y-1/2 z-10 w-12 h-12 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-full items-center justify-center text-zinc-600 dark:text-zinc-400 shadow-lg hover:bg-zinc-50 dark:hover:bg-zinc-700 hover:text-amber-500 transition-all opacity-0 group-hover:opacity-100">
                <flux:icon.chevron-left class="w-6 h-6" />
            </button>

            {{-- 💡 3. ใส่ x-ref="carousel" ให้ตัวเลื่อน เพื่อให้ Alpine.js รู้จัก --}}
            <div x-ref="carousel" class="flex overflow-x-auto snap-x snap-mandatory gap-6 pb-8 scroll-smooth"
                style="scrollbar-width: none; -ms-overflow-style: none;">
                @foreach($photos as $index => $photo)
                    <div @click="openGallery({{ $index }})"
                        class="flex-none w-[280px] sm:w-[320px] lg:w-[350px] snap-center group/card relative overflow-hidden rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50 hover:border-amber-500/50 transition-all cursor-pointer shadow-sm hover:shadow-md">
                        <div class="aspect-square bg-zinc-200 dark:bg-zinc-800 overflow-hidden">
                            <img src="{{ $photo['img'] }}" alt="{{ $photo['title'] }}"
                                class="w-full h-full object-cover group-hover/card:scale-110 transition-transform duration-500 opacity-80 group-hover/card:opacity-100">
                        </div>
                        <div
                            class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-zinc-900/90 via-zinc-900/60 to-transparent p-6 pt-12">
                            <div class="text-white font-bold text-lg">{{ $photo['title'] }}</div>
                            <div class="text-zinc-300 text-sm mt-1 line-clamp-1">{{ $photo['desc'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- 💡 4. ปุ่มเลื่อนขวา --}}
            <button @click="scrollRight()"
                class="hidden md:flex absolute -right-4 top-[40%] -translate-y-1/2 z-10 w-12 h-12 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-full items-center justify-center text-zinc-600 dark:text-zinc-400 shadow-lg hover:bg-zinc-50 dark:hover:bg-zinc-700 hover:text-amber-500 transition-all opacity-0 group-hover:opacity-100">
                <flux:icon.chevron-right class="w-6 h-6" />
            </button>

        </div>

        <div class="flex justify-center mt-2 lg:hidden text-zinc-400 text-sm">
            <flux:icon.chevron-left class="w-4 h-4 mr-1" />
            <span>ปัดซ้าย-ขวา เพื่อดูรูปเพิ่มเติม</span>
            <flux:icon.chevron-right class="w-4 h-4 ml-1" />
        </div>

    </div>

    {{-- ==========================================
    💡 4. ระบบ Lightbox (ตู้โชว์ภาพขนาดใหญ่)
    ส่วนนี้จะถูกซ่อนไว้ (display: none) จนกว่า isOpen จะเป็น true
    ========================================== --}}
    <div x-show="isOpen" style="display: none;"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/95 backdrop-blur-sm"
        x-transition.opacity.duration.300ms>
        {{-- ปุ่มปิด (กากบาท) มุมขวาบน --}}
        <button @click="closeGallery()"
            class="absolute top-6 right-6 text-white/70 hover:text-white bg-white/10 hover:bg-white/20 rounded-full p-2 transition-colors z-50">
            <flux:icon.x-mark class="w-8 h-8" />
        </button>

        {{-- ปุ่มเลื่อนซ้าย --}}
        <button @click.stop="prev()"
            class="absolute left-4 md:left-10 text-white/70 hover:text-white bg-white/5 hover:bg-white/20 rounded-full p-3 transition-colors z-50">
            <flux:icon.chevron-left class="w-8 h-8" />
        </button>

        {{-- กล่องแสดงรูปภาพใหญ่ตรงกลาง --}}
        <div class="w-full max-w-5xl px-4 md:px-24 flex flex-col items-center" @click.outside="closeGallery()">
            {{-- รูปภาพ (ดึงจาก currentPhoto.img) --}}
            <img :src="currentPhoto.img" :alt="currentPhoto.title"
                class="w-full max-h-[75vh] object-contain rounded-lg shadow-2xl" x-transition>

            {{-- ข้อความอธิบายใต้รูปภาพ --}}
            <div class="text-center mt-6">
                <h3 class="text-2xl font-bold text-white mb-2" x-text="currentPhoto.title"></h3>
                <p class="text-zinc-400 text-lg" x-text="currentPhoto.desc"></p>
                <div class="text-amber-500 font-medium mt-3 text-sm" x-text="`${currentIndex + 1} / ${photos.length}`">
                </div>
            </div>
        </div>

        {{-- ปุ่มเลื่อนขวา --}}
        <button @click.stop="next()"
            class="absolute right-4 md:right-10 text-white/70 hover:text-white bg-white/5 hover:bg-white/20 rounded-full p-3 transition-colors z-50">
            <flux:icon.chevron-right class="w-8 h-8" />
        </button>
    </div>

</section>