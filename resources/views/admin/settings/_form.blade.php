<form action="{{ route('admin.settings.update') }}" method="post" class="space-y-8 p-5 text-zinc-900">
    @csrf
    @method('PUT')

    <section class="space-y-4">
        <div>
            <h3 class="text-base font-semibold text-zinc-900">แบรนด์และโลโก้</h3>
            <p class="text-sm text-zinc-500">ชื่อร้านและไฟล์ภาพที่ใช้บนเว็บ</p>
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="md:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">ชื่อร้าน</label>
                <input name="name" type="text" value="{{ old('name', $settings['name']) }}"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="md:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">URL โลโก้</label>
                <input name="logo" type="text" value="{{ old('logo', $settings['logo']) }}"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('logo')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">ความกว้างโลโก้ (px)</label>
                <input name="logo_width" type="number" value="{{ old('logo_width', $settings['logo_width']) }}"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('logo_width')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">ความสูงโลโก้ (px)</label>
                <input name="logo_height" type="number" value="{{ old('logo_height', $settings['logo_height']) }}"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('logo_height')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">URL Favicon</label>
                <input name="favicon" type="text" value="{{ old('favicon', $settings['favicon']) }}"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('favicon')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">รูป Hero (path หรือ URL)</label>
                <input name="hero_image" type="text" value="{{ old('hero_image', $settings['hero_image']) }}"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('hero_image')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>

    <section class="space-y-4 border-t border-zinc-200 pt-8">
        <div>
            <h3 class="text-base font-semibold text-zinc-900">ข้อมูลติดต่อ</h3>
            <p class="text-sm text-zinc-500">เบอร์โทร อีเมล LINE และที่อยู่</p>
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">เบอร์โทร (tel:)</label>
                <input name="phone" type="text" value="{{ old('phone', $settings['phone']) }}" placeholder="+66817928148"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('phone')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">เบอร์โทร (แสดงผล)</label>
                <input name="phone_formatted" type="text" value="{{ old('phone_formatted', $settings['phone_formatted']) }}"
                    placeholder="081-792-8148"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('phone_formatted')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">อีเมล</label>
                <input name="email" type="email" value="{{ old('email', $settings['email']) }}"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('email')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">ลิงก์ LINE</label>
                <input name="line" type="text" value="{{ old('line', $settings['line']) }}"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('line')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">Facebook</label>
                <input name="facebook" type="text" value="{{ old('facebook', $settings['facebook']) }}"
                    placeholder="n/a หรือ URL"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('facebook')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">รูป QR LINE (path หรือ URL)</label>
                <input name="line_qr" type="text" value="{{ old('line_qr', $settings['line_qr']) }}"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('line_qr')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="md:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">ที่อยู่ (ข้อความเต็ม)</label>
                <textarea name="address" rows="2"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10">{{ old('address', $settings['address']) }}</textarea>
                @error('address')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">เลขประจำตัวผู้เสียภาษี</label>
                <input name="taxid" type="text" value="{{ old('taxid', $settings['taxid']) }}"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('taxid')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">เวลาทำการ</label>
                <input name="open_hours" type="text" value="{{ old('open_hours', $settings['open_hours']) }}"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('open_hours')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>

    <section class="space-y-4 border-t border-zinc-200 pt-8">
        <div>
            <h3 class="text-base font-semibold text-zinc-900">ที่อยู่แบบมีโครงสร้าง (Schema)</h3>
            <p class="text-sm text-zinc-500">ใช้สำหรับ JSON-LD LocalBusiness</p>
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="md:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">ถนน / ซอย</label>
                <input name="address_street" type="text" value="{{ old('address_street', $settings['address_street']) }}"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('address_street')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">เขต / อำเภอ</label>
                <input name="address_locality" type="text"
                    value="{{ old('address_locality', $settings['address_locality']) }}"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('address_locality')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">จังหวัด</label>
                <input name="address_region" type="text" value="{{ old('address_region', $settings['address_region']) }}"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('address_region')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">รหัสไปรษณีย์</label>
                <input name="address_postal" type="text" value="{{ old('address_postal', $settings['address_postal']) }}"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('address_postal')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">ประเทศ</label>
                <input name="address_country" type="text"
                    value="{{ old('address_country', $settings['address_country']) }}"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('address_country')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>

    <section class="space-y-4 border-t border-zinc-200 pt-8">
        <div>
            <h3 class="text-base font-semibold text-zinc-900">Hero และ SEO พื้นฐาน</h3>
            <p class="text-sm text-zinc-500">ข้อความหน้าแรกและเมตาเริ่มต้น</p>
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="md:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">หัวข้อ Hero</label>
                <input name="hero_title" type="text" value="{{ old('hero_title', $settings['hero_title']) }}"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('hero_title')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="md:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">คำโปรย Hero</label>
                <textarea name="hero_subtitle" rows="2"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10">{{ old('hero_subtitle', $settings['hero_subtitle']) }}</textarea>
                @error('hero_subtitle')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="md:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">Meta Title</label>
                <input name="meta_title" type="text" value="{{ old('meta_title', $settings['meta_title']) }}"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
                @error('meta_title')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="md:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-zinc-700">Meta Description</label>
                <textarea name="meta_description" rows="3"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-900 placeholder:text-zinc-600 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10">{{ old('meta_description', $settings['meta_description']) }}</textarea>
                @error('meta_description')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>

    <div class="flex flex-wrap gap-2 border-t border-zinc-200 pt-6">
        <button type="submit"
            class="min-w-32 rounded-lg bg-zinc-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-zinc-800">
            บันทึกการตั้งค่า
        </button>
    </div>
</form>
