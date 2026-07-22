# 🎓 Course Outline: สร้างเว็บ "ระบบซ่อมเครื่องดูดฝุ่น"

## ด้วย Laravel 13 + Tailwind CSS 4 + Blade Components

---

**โปรเจกต์:** เว็บไซต์ "ศิริพงษ์ เซอร์วิส" — ระบบซ่อมเครื่องดูดฝุ่นครบวงจร  
**ระดับ:** มือใหม่ที่ไม่เคยใช้ Laravel มาก่อน  
**เป้าหมาย:** แปลง HTML สำเร็จรูปเป็น Laravel App ที่ทำงานได้จริง  
**ระยะเวลาประมาณ:** 10 Modules (เรียนทีละ Module ตามจังหวะตัวเอง)  
**สไตล์การสอน:** ทุกโค้ดอธิบายด้วยภาษาง่าย ๆ เปรียบกับชีวิตจริง

### Stack ที่ใช้ในโปรเจกต์นี้

| ใช้หลัก | ไม่ใช้ |
| -------- | ------ |
| Laravel 13 (PHP 8.4+) | Livewire, Inertia, Vue, React |
| Tailwind CSS 4.3 (`@theme` + utility classes) | Bootstrap CSS, Flux UI |
| Blade Components + Layout | ไฟล์ CSS แยกเพิ่ม |
| Eloquent + Migration | — |
| Vanilla JS (`resources/js/main.js`) | Alpine.js (ไม่จำเป็น) |
| Vite (build tool) | — |
| Bootstrap Icons CDN (icon เท่านั้น) | — |

---

## 🗺️ ภาพรวมเส้นทางทั้งหมด

```
Module 1 → 2 → 3 → 4 → 5 → 6 → 7 → 8 → 9 → 10
 ติดตั้ง   พื้นฐาน   Layout   หน้าเว็บ   ฟอร์ม   DB   Portfolio  FAQ   Admin   Deploy
 เตรียมบ้าน  Laravel   โครง    แต่ละหน้า   รับงาน  บันทึก  ผลงาน    คำถาม  หลังบ้าน  เปิดร้าน
```

---

## 📦 Module 1: ติดตั้งและเตรียมสนามเด็กเล่น

> 🏠 เปรียบเทียบ: "ซื้อที่ดิน สร้างบ้านโครงสร้าง ต่อไฟฟ้า ต่อประปา"

### 1.1 — ติดตั้ง Laravel 13

**สิ่งที่จะเรียนรู้:**

- Composer คืออะไร (ตัวจัดการแพ็กเกจ PHP)
- `composer create-project laravel/laravel siriphong` — สร้างโปรเจกต์
- โครงสร้างโฟลเดอร์หลัก: `app/`, `routes/`, `resources/`, `database/`, `config/`
- ไฟล์ `.env` — ตั้งค่า `APP_NAME`, `APP_URL`, Database

**ไฟล์ที่แก้ไข:**

- `.env` — ตั้งค่า DB (`sqlite` สำหรับ dev หรือ `mysql` สำหรับ production)

**✅ ทดสอบ:** รัน `php artisan serve` → เปิด `localhost:8000` ได้

### 1.2 — ติดตั้ง Tailwind CSS 4 + Vite

**สิ่งที่จะเรียนรู้:**

- Tailwind CSS 4 — เขียน style ด้วย utility class ใน Blade โดยตรง
- `@import 'tailwindcss'` — entry point ใน `resources/css/app.css`
- `@source` — บอก Tailwind ให้ scan ไฟล์ Blade/JS
- `@theme` — กำหนด design tokens (สี, ฟอนต์, animation) แทน `tailwind.config.js`
- `npm install` + `npm run dev` — compile CSS/JS ผ่าน Vite

**ไฟล์ที่สร้าง / แก้ไข:**

- `resources/css/app.css` — `@theme` สีแบรนด์ (`navy`, `orange`, `line` ฯลฯ)
- `vite.config.js` — ใช้ `@tailwindcss/vite` plugin
- `package.json` — `tailwindcss ^4.3`, `@tailwindcss/vite`

**ตัวอย่าง `@theme`:**

```css
@theme {
    --color-navy: #0f2347;
    --color-orange: #f26522;
    --font-sans: 'Sarabun', sans-serif;
    --font-display: 'Chakra Petch', sans-serif;
}
```

→ ใช้ใน Blade เป็น `bg-navy`, `text-orange`, `font-display`

**✅ ทดสอบ:** ใส่ `class="bg-navy text-white p-4"` ใน Blade → สีแสดงถูกต้องหลัง `npm run dev`

### 1.3 — Config ข้อมูลร่วม

**สิ่งที่จะเรียนรู้:**

- `config/data.php` — เก็บเบอร์โทร, LINE, logo, ที่อยู่ (ใช้ซ้ำทั้งเว็บ)
- `config('data.phone')` — อ่านค่าใน Blade
- `media_url()` helper — แปลง path รูปเป็น URL (รองรับ R2/CDN)

**ไฟล์ที่สร้าง:**

- `config/data.php`
- `app/helpers.php` + `app/Support/MediaUrl.php`

**✅ ทดสอบ:** เปิดหน้าเว็บ → เบอร์โทร/LINE ดึงจาก config ได้

---

## 🧱 Module 2: พื้นฐาน Laravel + Blade + Tailwind

> 🎨 เปรียบเทียบ: "หัดใช้เครื่องมือช่างทีละชิ้น ก่อนไปสร้างบ้านจริง"

### 2.1 — Routing + Controller

**สิ่งที่จะเรียนรู้:**

- Route คืออะไร — แผนที่ URL → ฟังก์ชัน
- `routes/web.php` — กำหนดเส้นทาง
- Controller — รับ request, ดึงข้อมูล, ส่งไป View
- `Route::get('/', [HomeController::class, 'index'])`

**ไฟล์ที่สร้าง:**

- `app/Http/Controllers/HomeController.php`
- `routes/web.php`

**✅ ทดสอบ:** `php artisan route:list` → เห็น route `home`

### 2.2 — Blade Template พื้นฐาน

**สิ่งที่จะเรียนรู้:**

- `@extends('layout.app')` — สืบทอด layout หลัก
- `@section` / `@yield` — แทรกเนื้อหา
- `{{ $variable }}` — แสดงค่า (escape HTML อัตโนมัติ)
- `@if`, `@foreach`, `@forelse` — เงื่อนไขและ loop
- `@csrf` — ป้องกัน CSRF ในฟอร์ม

**ไฟล์ที่สร้าง:**

- `resources/views/index.blade.php`
- `resources/views/layout/app.blade.php`

**✅ ทดสอบ:** หน้าแรก render ผ่าน layout ได้

### 2.3 — Blade Components

**สิ่งที่จะเรียนรู้:**

- `<x-frontend.hero />` — เรียก component แบบ reusable
- `app/View/Components/frontend/Hero.php` + `resources/views/components/frontend/hero.blade.php`
- Props — ส่งค่าเข้า component (ถ้าต้องการ)
- แยก section เป็นชิ้นเล็ก ๆ ดูแลง่าย

**✅ ทดสอบ:** สร้าง component ง่าย ๆ แล้วเรียกใน layout ได้

### 2.4 — Form + Validation (พื้นฐาน)

**สิ่งที่จะเรียนรู้:**

- HTML form + `method="POST"` + `@csrf`
- Form Request — แยก validation ออกจาก Controller
- `@error('field')` — แสดง error ใต้ช่อง
- `old('field')` — คืนค่าที่กรอกไว้หลัง validation fail

**ไฟล์ตัวอย่าง:**

- `app/Http/Requests/Admin/StoreUserRequest.php`

**✅ ทดสอบ:** ส่งฟอร์มเปล่า → เห็น error, กรอกครบ → redirect พร้อม flash message

### 2.5 — Tailwind Utility Workshop

**สิ่งที่จะเรียนรู้:**

- Layout: `flex`, `grid`, `gap`, `max-w-*`, `mx-auto`
- Responsive: `sm:`, `md:`, `lg:` prefix
- สีแบรนด์จาก `@theme`: `bg-navy`, `text-orange`, `bg-offwhite`
- Hover/Transition: `hover:bg-navy-mid`, `transition-all`
- Animation จาก `@theme`: `animate-fade-up`

**✅ ทดสอบ:** สร้าง card ด้วย Tailwind ล้วน ๆ ไม่เขียน CSS แยก

---

## 🏗️ Module 3: สร้าง Layout หลัก

> 🏗️ เปรียบเทียบ: "สร้างโครงบ้าน — หลังคา ผนัง ประตู ก่อนตกแต่งห้อง"

### 3.1 — Layout Template (`layout/app.blade.php`)

**สิ่งที่จะเรียนรู้:**

- Layout คือโครง HTML ที่ทุกหน้าใช้ร่วมกัน
- `@vite(['resources/css/app.css', 'resources/js/app.js'])` — โหลด asset
- Google Fonts (Sarabun + Chakra Petch)
- Bootstrap Icons CDN — icon เท่านั้น (ไม่ใช่ Bootstrap CSS)
- `@stack('jsonld')` — แทรก Schema.org JSON-LD

**ไฟล์หลัก:**

- `resources/views/layout/app.blade.php`

**✅ ทดสอบ:** ทุกหน้าโหลด CSS/JS + ฟอนต์ไทยถูกต้อง

### 3.2 — Navbar + Sticky Mobile CTA

**สิ่งที่จะเรียนรู้:**

- `<x-frontend.navbar />` — เมนู desktop + hamburger mobile
- `<x-frontend.sticky-mobile />` — ปุ่ม LINE ติดล่างจอมือถือ
- Vanilla JS ใน `main.js`: `toggleMenu()`, `closeMenu()`
- Sticky header: `sticky top-0 z-50`

**ไฟล์ที่สร้าง:**

- `resources/views/components/frontend/navbar.blade.php`
- `resources/views/components/frontend/sticky-mobile.blade.php`
- `resources/js/main.js`

**✅ ทดสอบ:** บนมือถือกด hamburger → เมนูเปิด/ปิด, ปุ่ม LINE ติดล่างจอ

### 3.3 — Footer

**สิ่งที่จะเรียนรู้:**

- `<x-frontend.footer />` — ข้อมูลติดต่อ, ลิงก์
- Tailwind: `bg-navy`, `text-white/70`, `grid md:grid-cols-3`

**✅ ทดสอบ:** ทุกหน้ามี footer เหมือนกัน

---

## 🎯 Module 4: สร้างหน้าเว็บแต่ละ Section

> 🎨 เปรียบเทียบ: "ตกแต่งแต่ละห้องในบ้าน — ห้องรับแขก ห้องครัว ห้องนอน"

หน้าแรกประกอบด้วย components เหล่านี้ (เรียงใน `layout/app.blade.php`):

| Component | ไฟล์ | หน้าที่ |
| --------- | ---- | ------- |
| Hero | `x-frontend.hero` | หัวข้อหลัก + CTA |
| Trust | `x-frontend.trust` | แถบความน่าเชื่อถือ |
| Services | `x-frontend.services` | บริการ + filter |
| Why Us | `x-frontend.why-us` | จุดเด่น |
| Portfolio | `x-frontend.portfolio` | ผลงานจาก DB |
| Testimonials | `x-frontend.testimonials` | รีวิวลูกค้า |
| Process | `x-frontend.process` | ขั้นตอนการซ่อม |
| Cal | `x-frontend.cal` | คำนวณค่าขนส่ง |
| Contact | `x-frontend.contact` | QR LINE + ข้อมูลติดต่อ |

### 4.1 — Hero Section

**สิ่งที่จะเรียนรู้:**

- Grid 2 คอลัมน์: `grid grid-cols-1 lg:grid-cols-2`
- Gradient background: `bg-[linear-gradient(...)]`
- รูป hero จาก `media_url(config('data.hero_image'))`
- CTA ปุ่ม: `bg-line`, `bg-orange`

**แปลงจาก HTML เดิม:**

```
HTML เดิม                    →  Tailwind 4
─────────────────────────────────────────────
class="hero"                 →  gradient + py-18
class="hero-grid"            →  grid lg:grid-cols-2 gap-10
class="trust-badge"          →  rounded-xl bg-white/10 p-4
class="btn-line"             →  bg-line hover:bg-line-dark rounded-xl
```

**✅ ทดสอบ:** Hero responsive — มือถือ 1 คอลัมน์, desktop 2 คอลัมน์

### 4.2 — Services + Filter

**สิ่งที่จะเรียนรู้:**

- Card grid: `grid sm:grid-cols-2 lg:grid-cols-3`
- Filter ด้วย vanilla JS: `filterServices(cat)` ใน `main.js`
- `data-category` attribute บน card

**✅ ทดสอบ:** กด filter → card แสดง/ซ่อนตามหมวด

### 4.3 — Portfolio Section (ดึงจาก DB)

**สิ่งที่จะเรียนรู้:**

- Query ใน component: `Portfolio::where('is_active', true)->orderBy('sort_order')`
- `@forelse` — loop + empty state
- Lightbox รูปด้วย `data-portfolio-photos` + JS

**✅ ทดสอบ:** เพิ่ม portfolio ใน admin → แสดงบนหน้าเว็บ

### 4.4 — Contact Section (QR LINE)

**สิ่งที่จะเรียนรู้:**

- โปรเจกต์ปัจจุบันใช้ QR Code แทนฟอร์มกรอกข้อมูล
- `media_url(config('data.line_qr'))` — แสดงรูป QR
- ปุ่ม CTA: แอด LINE / โทรเลย

**หมายเหตุ:** ฟอร์มรับงานซ่อม (Module 5) เป็น optional — สามารถเพิ่มทีหลังได้

**✅ ทดสอบ:** สแกน QR / กดปุ่ม LINE → เปิดแอปได้

---

## 📝 Module 5: ฟอร์มรับงานซ่อม (Optional)

> 📬 เปรียบเทียบ: "สร้างกล่องรับจดหมาย ที่คัดกรองจดหมายไม่สมบูรณ์ออก"

> **สถานะโปรเจกต์:** หน้า Contact ใช้ QR LINE เป็นหลัก — Module นี้สำหรับผู้ที่ต้องการเพิ่มฟอร์มกรอกข้อมูล

### 5.1 — Controller + Form Request

**สิ่งที่จะเรียนรู้:**

- `InquiryController@store` — รับ POST จากฟอร์ม
- `StoreInquiryRequest` — validate name, phone, brand, symptom
- Redirect กลับพร้อม `session('success')`

**Flux/Livewire ไม่ใช้** — ฟอร์ม HTML ล้วน:

```blade
<form action="{{ route('inquiries.store') }}" method="POST">
    @csrf
    <input name="name" value="{{ old('name') }}" class="rounded-lg border ...">
    @error('name') <p class="text-red-600 text-xs">{{ $message }}</p> @enderror
    <button type="submit" class="bg-orange text-white rounded-xl px-6 py-3">ส่งข้อมูล</button>
</form>
```

### 5.2 — Validation ภาษาไทย

**สิ่งที่จะเรียนรู้:**

- Custom messages ใน Form Request
- `lang/th/validation.php` — ข้อความ error ภาษาไทย

### 5.3 — Success State

**สิ่งที่จะเรียนรู้:**

- Flash message: `->with('success', 'รับเรื่องแล้ว')`
- แสดงใน Blade: `@if(session('success'))`

**✅ ทดสอบ:** กรอกฟอร์ม → บันทึก DB → admin เห็นใน `/admin/inquiries`

---

## 💾 Module 6: เชื่อมต่อ Database

> 🗄️ เปรียบเทียบ: "สร้างโกดังเก็บของ แล้วต่อท่อจากกล่องรับจดหมายเข้าโกดัง"

### 6.1 — Migration

**สิ่งที่จะเรียนรู้:**

- `php artisan make:migration create_inquiries_table`
- ชนิดข้อมูล: `string`, `text`, `boolean`, `timestamps`
- `php artisan migrate` — สร้างตาราง
- SQLite (dev) หรือ MySQL (production)

**ตารางหลักในโปรเจกต์:**

| ตาราง | ใช้ทำอะไร |
| ----- | --------- |
| `inquiries` | ใบรับงานซ่อมจากลูกค้า |
| `portfolios` | ผลงานแสดงหน้าเว็บ |
| `users` | ผู้ใช้ admin |

**ไฟล์:**

- `database/migrations/2026_05_28_105711_create_inquiries_table.php`
- `database/migrations/2026_07_21_074900_create_portfolios_table.php`

**✅ ทดสอบ:** `php artisan migrate` สำเร็จ + `php artisan tinker` สร้าง record ได้

### 6.2 — Model (Eloquent)

**สิ่งที่จะเรียนรู้:**

- `$fillable` — field ที่ mass assign ได้
- `casts()` — แปลง type (`boolean`, `integer`, `datetime`)
- `Portfolio::create()`, `::query()->where()->get()`

**ไฟล์:**

- `app/Models/Inquiry.php`
- `app/Models/Portfolio.php`

**✅ ทดสอบ:** Tinker → `Inquiry::create([...])` → `Inquiry::all()`

### 6.3 — Seeder

**สิ่งที่จะเรียนรู้:**

- `php artisan make:seeder VacuumSeeder`
- ใส่ข้อมูลตัวอย่าง portfolio / user admin

**✅ ทดสอบ:** `php artisan db:seed` → หน้าเว็บมีข้อมูลแสดง

---

## 🖼️ Module 7: Portfolio ผลงานซ่อม

> 📸 เปรียบเทียบ: "ติดรูปผลงานที่ผนังร้าน — ลูกค้าเห็นแล้วมั่นใจ"

### 7.1 — Migration + Model

**โครงสร้างตาราง `portfolios`:**

| Column | Type | คำอธิบาย |
| ------ | ---- | -------- |
| category_label | string | หมวดหมู่ |
| title | string | หัวข้อผลงาน |
| description | text | รายละเอียด |
| brands | string | ยี่ห้อเครื่อง |
| image | string | path รูป (R2/local) |
| year, duration | string | ปี / ระยะเวลา |
| status_label | string | สถานะงาน |
| sort_order | integer | ลำดับแสดง |
| is_active | boolean | แสดง/ซ่อน |
| map_coordinates | string | พิกัด Google Map (ใช้ใน JSON-LD) |

### 7.2 — แสดงผลบนหน้าเว็บ

**สิ่งที่จะเรียนรู้:**

- `x-frontend.portfolio` — query + render card grid
- `imageUrl()` method บน Model → `media_url()`
- Lightbox เปิดรูงใหญ่ด้วย vanilla JS

**✅ ทดสอบ:** Portfolio active แสดงเรียงตาม `sort_order`

### 7.3 — จัดการใน Admin

**สิ่งที่จะเรียนรู้:**

- `Admin\PortfolioController` — CRUD ผ่านฟอร์ม HTML
- `StorePortfolioRequest` / `UpdatePortfolioRequest`
- อัปโหลดรูป: กรอก path หรือเชื่อม R2 (`config/filesystems.php`)

**ไฟล์:**

- `resources/views/admin/portfolios/index.blade.php`
- `resources/views/admin/portfolios/_form.blade.php`

**✅ ทดสอบ:** เพิ่ม/แก้ไข/ลบ portfolio ใน `/admin/portfolios`

---

## ❓ Module 8: FAQ — Accordion ด้วย HTML + Tailwind

> 📖 เปรียบเทียบ: "สร้างหนังสือคำถามที่ถามบ่อย กดเปิดดูคำตอบทีละข้อ"

### 8.1 — Native `<details>` + Tailwind

**สิ่งที่จะเรียนรู้:**

- `<details>` / `<summary>` — accordion ในตัว browser ไม่ต้อง JS
- จัด style ด้วย Tailwind: `rounded-xl border`, `open:` variant
- `max-w-3xl mx-auto` — จำกัดความกว้าง

```blade
<details class="group rounded-xl border border-zinc-200 bg-white open:shadow-sm">
    <summary class="cursor-pointer px-5 py-4 font-semibold text-navy list-none">
        ซ่อมใช้เวลานานแค่ไหน?
    </summary>
    <p class="px-5 pb-4 text-steel">โดยทั่วไป 1–3 วันทำการ ขึ้นกับอาการและอะไหล่</p>
</details>
```

**✅ ทดสอบ:** คลิกคำถาม → คำตอบเปิด/ปิดได้

### 8.2 — Dynamic FAQ จาก Database (Optional)

**สิ่งที่จะเรียนรู้:**

- ตาราง `faqs` — question, answer, sort_order, is_active
- Loop `@foreach` ใน Blade component

---

## 🔐 Module 9: Admin Panel (หลังบ้าน)

> 🏢 เปรียบเทียบ: "สร้างห้องทำงานส่วนตัว — ติดตามงานซ่อมทั้งหมด"

### 9.1 — Authentication (แนะนำ — ยังไม่บังคับในโปรเจกต์)

**สิ่งที่จะเรียนรู้:**

- `php artisan install:breeze --stack=blade` — login แบบ Blade ล้วน (ไม่มี Livewire)
- `Route::middleware('auth')->group(...)` — ป้องกัน admin routes
- Seeder สร้าง admin user

**✅ ทดสอบ:** เข้า `/admin` โดยไม่ login → redirect ไป login

### 9.2 — Admin Layout + Routes

**สิ่งที่จะเรียนรู้:**

- `<x-layouts.admin>` — sidebar + `{{ $slot }}`
- Route group:

```php
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/inquiries', [InquiryController::class, 'index']);
    Route::resource('users', UserController::class)->except(['show', 'create']);
    Route::resource('portfolios', PortfolioController::class)->except(['show', 'create']);
});
```

**ไฟล์:**

- `resources/views/components/layouts/admin.blade.php`
- `app/Http/Controllers/Admin/*`

### 9.3 — Dashboard

**ไฟล์:** `resources/views/admin/dashboard.blade.php`

**✅ ทดสอบ:** เปิด `/admin/dashboard` → เห็นหน้าต้อนรับ

### 9.4 — Inquiry List (Read-only)

**สิ่งที่จะเรียนรู้:**

- `Inquiry::latest()->paginate(10)`
- ตาราง HTML + Tailwind
- `{{ $inquiries->links() }}` — pagination

**ไฟล์:** `resources/views/admin/inquiries/index.blade.php`

**✅ ทดสอบ:** เห็นรายการใบรับงาน + แบ่งหน้า

### 9.5 — User + Portfolio CRUD

**สิ่งที่จะเรียนรู้:**

- Form ด้านบน + ตารางด้านล่าง (หน้าเดียว)
- `edit` route — prefill ฟอร์มด้วย `old()` + model
- DELETE form + `confirm()` ยืนยันก่อนลบ

**ไฟล์:**

- `resources/views/admin/users/index.blade.php`
- `resources/views/admin/portfolios/index.blade.php`

**✅ ทดสอบ:** CRUD users และ portfolios ครบทุก action

---

## 🚀 Module 10: ปรับแต่งสุดท้าย + Deploy

> 🎀 เปรียบเทียบ: "ทาสี ติดป้าย เปิดร้านให้ลูกค้าเข้า"

### 10.1 — SEO + Schema.org JSON-LD

**สิ่งที่จะเรียนรู้:**

- `<title>`, `<meta name="description">` ใน layout
- JSON-LD LocalBusiness ใน `HomeController` → inject ผ่าน `@push('jsonld')`
- พิกัด map จาก portfolio แรกที่มี `map_coordinates`

**ไฟล์:**

- `app/Http/Controllers/HomeController.php`
- `resources/views/index.blade.php`

**✅ ทดสอบ:** View Source → เห็น `<script type="application/ld+json">`

### 10.2 — Responsive Final Check

**สิ่งที่จะเรียนรู้:**

- ทดสอบ 375px / 768px / 1280px
- Hamburger menu (`main.js`)
- Sticky mobile CTA, back-to-top button
- Touch target ขั้นต่ำ ~44px

**✅ ทดสอบ:** DevTools device mode → ทุก section แสดงผลดี

### 10.3 — Performance + Security

**สิ่งที่จะเรียนรู้:**

- `npm run build` — production assets
- `php artisan config:cache` + `route:cache`
- `@csrf` ทุกฟอร์ม POST
- Rate limiting บน route ฟอร์ม (optional)

**✅ ทดสอบ:** Lighthouse score ดีขึ้นหลัง build

### 10.4 — Deploy

**สิ่งที่จะเรียนรู้:**

- `.env` production: `APP_ENV=production`, `APP_DEBUG=false`
- Database MySQL บน server
- R2/S3 สำหรับรูป (`FILESYSTEM_DISK`, `AWS_*`)
- SSL (HTTPS)

**✅ ทดสอบ:** เปิด domain จริง → หน้าเว็บ + admin ทำงาน

---

## 📊 สรุปสิ่งที่ได้เรียนรู้ทั้งหมด

### เทคโนโลยี

| เทคโนโลยี | สิ่งที่ได้เรียน |
| --------- | -------------- |
| **Laravel 13** | Routing, Controller, Form Request, Migration, Eloquent, Middleware |
| **Tailwind CSS 4** | `@theme`, utility classes, responsive, animation tokens |
| **Blade** | Layout, Components, `@foreach`, `@error`, `@csrf` |
| **Vanilla JS** | Menu toggle, filter, scroll reveal, lightbox |
| **Database** | SQLite/MySQL, Migration, Seeder, Pagination |

### ทักษะ

| ทักษะ | Module |
| ----- | ------ |
| ติดตั้งโปรเจกต์ + Tailwind 4 | 1 |
| Laravel + Blade + Form | 2 |
| Layout + Navigation | 3 |
| Landing Page Components | 4 |
| ฟอร์มรับงาน (optional) | 5 |
| Database | 6 |
| Portfolio | 7 |
| FAQ | 8 |
| Admin Panel | 9 |
| SEO + Deploy | 10 |

### โครงสร้างไฟล์หลัก (โปรเจกต์จริง)

```
siriphong/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php
│   │   │   └── Admin/
│   │   │       ├── DashboardController.php
│   │   │       ├── InquiryController.php
│   │   │       ├── UserController.php
│   │   │       └── PortfolioController.php
│   │   └── Requests/Admin/
│   ├── Models/
│   │   ├── Inquiry.php
│   │   ├── Portfolio.php
│   │   └── User.php
│   ├── Support/MediaUrl.php
│   └── helpers.php
├── config/
│   └── data.php                       ← ข้อมูลร้าน (เบอร์, LINE, logo)
├── database/migrations/
│   ├── create_inquiries_table.php
│   └── create_portfolios_table.php
├── resources/
│   ├── css/app.css                    ← Tailwind 4 + @theme เท่านั้น
│   ├── js/
│   │   ├── app.js
│   │   └── main.js                    ← vanilla JS
│   └── views/
│       ├── layout/app.blade.php       ← Layout หน้าบ้าน
│       ├── index.blade.php
│       ├── components/
│       │   ├── layouts/admin.blade.php
│       │   └── frontend/              ← hero, services, portfolio, ...
│       └── admin/                     ← dashboard, inquiries, users, portfolios
└── routes/web.php
```

---

## 🛤️ แนะนำลำดับการเรียน

**MVP (เว็บขึ้นเร็ว):**  
Module 1 → 3 → 4.1 → 4.4 → 10

**เว็บครบฟีเจอร์หลัก:**  
Module 1 → 2 → 3 → 4 → 6 → 7 → 10

**Full Course:**  
Module 1 → 2 → 3 → 4 → 5 → 6 → 7 → 8 → 9 → 10

---

## 📌 กฎเหล็กของโปรเจกต์

1. **Stack:** Blade Component + Tailwind 4 เท่านั้น — ห้าม Livewire, Inertia, Vue, React, Bootstrap CSS
2. **CSS:** Config ผ่าน `@theme` ใน `app.css` — ห้ามสร้างไฟล์ CSS แยก
3. **Blade:** utility classes ใน template โดยตรง
4. **JS:** vanilla เท่าที่จำเป็น — อยู่ใน `main.js`
5. **Icon:** Bootstrap Icons CDN (ไม่ใช่ Bootstrap framework)

---

_สร้างด้วย ❤️ สำหรับมือใหม่ที่อยากเรียน Laravel ผ่านโปรเจกต์จริง — Pure Laravel 13 + Tailwind CSS 4_
