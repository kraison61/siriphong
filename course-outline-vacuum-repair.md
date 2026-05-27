# 🎓 Course Outline: สร้างเว็บ "ระบบซ่อมเครื่องดูดฝุ่น"

## ด้วย Laravel 13 + Livewire 3 (Volt) + Flux UI + MySQL

---

**โปรเจกต์:** เว็บไซต์ "ศิริพงษ์ เซอร์วิส" — ระบบซ่อมเครื่องดูดฝุ่นครบวงจร
**ระดับ:** มือใหม่ที่ไม่เคยใช้ Laravel มาก่อน
**เป้าหมาย:** แปลง HTML สำเร็จรูปเป็น Laravel App ที่ทำงานได้จริง
**ระยะเวลาประมาณ:** 10 Modules (เรียนทีละ Module ตามจังหวะตัวเอง)
**สไตล์การสอน:** ทุกโค้ดอธิบายด้วยภาษาง่าย ๆ เปรียบกับชีวิตจริง

---

## 🗺️ ภาพรวมเส้นทางทั้งหมด

```
Module 1 → 2 → 3 → 4 → 5 → 6 → 7 → 8 → 9 → 10
 ติดตั้ง   พื้นฐาน   Layout   หน้าเว็บ   ฟอร์ม   DB   Gallery   FAQ   Admin   Deploy
 เตรียมบ้าน  เรียนรู้   โครง    แต่ละหน้า   รับงาน  บันทึก  รูปภาพ   คำถาม  หลังบ้าน  เปิดร้าน
```

---

## 📦 Module 1: ติดตั้งและเตรียมสนามเด็กเล่น

> 🏠 เปรียบเทียบ: "ซื้อที่ดิน สร้างบ้านโครงสร้าง ต่อไฟฟ้า ต่อประปา"

### 1.1 — ติดตั้ง Laravel 13

**สิ่งที่จะเรียนรู้:**

- Composer คืออะไร (ตัวจัดการแพ็กเกจ PHP เหมือน App Store สำหรับโปรแกรมเมอร์)
- คำสั่ง `composer create-project laravel/laravel vacuum-repair` — สร้างโปรเจกต์
- โครงสร้างโฟลเดอร์หลัก 6 โฟลเดอร์ที่ใช้จริง
- ไฟล์ `.env` คืออะไร ทำไมสำคัญ

**ไฟล์ที่สร้าง / แก้ไข:**

- `.env` — ตั้งค่า MySQL (DB_CONNECTION, DB_HOST, DB_DATABASE ฯลฯ)

**✅ ทดสอบ:** รัน `php artisan serve` → เห็นหน้า Welcome ที่ `localhost:8000`

### 1.2 — ติดตั้ง Livewire 3 + Volt

**สิ่งที่จะเรียนรู้:**

- Livewire คืออะไร (ทำให้ PHP คุยกับ browser แบบ real-time ไม่ต้องเขียน JS)
- Volt Syntax คืออะไร (เขียน PHP + HTML ในไฟล์เดียว เหมือน Vue Single File Component)
- `composer require livewire/livewire` — ติดตั้ง Livewire
- `composer require livewire/volt` + `php artisan volt:install` — ติดตั้ง Volt

**_ Done - 2026-05-26 _**

**✅ ทดสอบ:** สร้าง component ตัวเลขนับ กดปุ่ม +/- แล้วตัวเลขเปลี่ยนโดยไม่ reload

### 1.3 — ติดตั้ง Flux UI Free + Tailwind CSS

**สิ่งที่จะเรียนรู้:**

- Flux UI คืออะไร (เฟอร์นิเจอร์สำเร็จรูป — Button, Card, Input ที่ออกแบบมาแล้ว)
- Tailwind CSS คืออะไร (เขียน CSS โดยใส่ class แทนเขียน style เอง)
- `composer require livewire/flux` — ติดตั้ง Flux
- `npm install` + `npm run dev` — เตรียม CSS/JS

**✅ ทดสอบ:** ใช้ `<flux:button>` แสดงปุ่มสวยโดยไม่เขียน CSS แม้แต่บรรทัดเดียว

---

## 🧱 Module 2: พื้นฐาน Livewire + Flux UI (Workshop สนามเด็กเล่น)

> 🎨 เปรียบเทียบ: "หัดใช้เครื่องมือช่างทีละชิ้น ก่อนไปสร้างบ้านจริง"

### 2.1 — Flux Components พื้นฐาน

**สิ่งที่จะเรียนรู้:**

- `<flux:button>` — variant (primary, filled, outline, ghost, danger) + size (sm, base, lg) + icon
- `<flux:card>` — กล่องใส่เนื้อหา
- `<flux:badge>` — ป้ายแสดงสถานะ + สี (green, amber, blue, red)
- `<flux:heading>` + `<flux:subheading>` + `<flux:text>` — หัวข้อ
- `<flux:callout>` — กล่องข้อความสำคัญ

**ไฟล์ที่สร้าง:**

- `resources/views/livewire/workshop-buttons.blade.php`
- `resources/views/livewire/workshop-cards.blade.php`

**✅ ทดสอบ:** เปิด `/workshop/buttons` และ `/workshop/cards` → เห็นทุก Component แสดงผลถูกต้อง

### 2.2 — Livewire State + Events

**สิ่งที่จะเรียนรู้:**

- `state()` — ตัวแปรที่ Livewire จดจำ (เหมือนกระดานไวท์บอร์ด)
- `wire:click` — กดปุ่มแล้วรัน PHP ทันที (เหมือนกดกริ่ง)
- `wire:model` — ผูกค่า input กับตัวแปร PHP (เหมือนกระจกสองด้าน)
- `wire:model.live` — อัปเดตทันทีขณะพิมพ์
- `$this->reset()` — รีเซ็ตค่าทั้งหมด

**ไฟล์ที่สร้าง:**

- `resources/views/livewire/workshop-counter.blade.php` — ตัวนับเลข
- `resources/views/livewire/workshop-greeting.blade.php` — พิมพ์ชื่อแล้วทักทาย

**✅ ทดสอบ:** กดปุ่มเพิ่ม/ลดตัวเลข + พิมพ์ชื่อแล้วข้อความเปลี่ยนทันที

### 2.3 — Form + Validation

**สิ่งที่จะเรียนรู้:**

- `<flux:input>` — ช่องกรอกข้อมูล + label + placeholder + description
- `<flux:textarea>` — ช่องข้อความยาว
- `<flux:radio.group>` — ตัวเลือก radio
- `<flux:select>` — dropdown เลือกค่า
- `wire:submit` — ส่งฟอร์ม
- `$this->validate()` — ตรวจสอบข้อมูล + ข้อความ error ภาษาไทย
- `@error('field')` — แสดง error ใต้ช่อง

**ไฟล์ที่สร้าง:**

- `resources/views/livewire/workshop-form.blade.php`

**✅ ทดสอบ:** กดส่งฟอร์มเปล่า → เห็น error ไทย, กรอกครบ → เห็นข้อมูลที่กรอกแสดงกลับ

### 2.4 — Dark Mode + Theme

**สิ่งที่จะเรียนรู้:**

- Flux จัดการ Dark Mode อัตโนมัติ ทุก Component เปลี่ยนสีเอง
- `dark:` prefix ของ Tailwind — ใช้กับ class ที่ต้องการปรับเอง
- Alpine.js `x-on:click` — JavaScript สั้น ๆ สำหรับ toggle
- `<flux:button icon="moon">` — ปุ่มเปลี่ยนธีม

**ไฟล์ที่สร้าง:**

- `resources/views/livewire/workshop-darkmode.blade.php`

**✅ ทดสอบ:** กดปุ่ม Dark Mode → ทุก Component เปลี่ยนสีอัตโนมัติ

---

## 🏗️ Module 3: สร้าง Layout หลัก

> 🏗️ เปรียบเทียบ: "สร้างโครงบ้าน — หลังคา ผนัง ประตู ก่อนตกแต่งห้อง"

### 3.1 — Layout Template (app.blade.php)

**สิ่งที่จะเรียนรู้:**

- Blade Layout คืออะไร (โครง HTML ที่ทุกหน้าใช้ร่วมกัน เหมือนโครงบ้าน)
- `{{ $slot }}` — ช่องว่างที่หน้าต่าง ๆ มาแทรกเนื้อหา (เหมือนกรอบรูป)
- `@fluxStyles` / `@fluxScripts` — โหลด Flux UI
- `@vite()` — โหลด Tailwind CSS ผ่าน Vite (เครื่องมือ build)
- การใส่ Google Fonts (Kanit + Sarabun) สำหรับภาษาไทย

**ไฟล์ที่สร้าง:**

- `resources/views/components/layouts/app.blade.php`

**✅ ทดสอบ:** ทุก component ที่ใช้ `<x-layouts.app>` แสดง Flux UI ถูกต้อง

### 3.2 — Header + Navigation

**สิ่งที่จะเรียนรู้:**

- `<flux:header>` — แถบเมนูบนสุด (sticky)
- `<flux:navbar>` + `<flux:navbar.item>` — เมนู navigation
- `<flux:brand>` — โลโก้ "ศิริพงษ์ เซอร์วิส"
- `<flux:spacer>` — ดันปุ่มไปชิดขวา
- `<flux:button>` สำหรับ Dark Mode toggle + ปุ่มโทร

**แปลงจาก HTML เดิม:**

```
HTML เดิม                          →  Flux UI ใหม่
─────────────────────────────────────────────────────
<header class="flux-header">       →  <flux:header>
<nav class="flux-navbar">          →  <flux:navbar>
<a class="flux-navbar-item">       →  <flux:navbar.item href="#">
<div class="flux-spacer">          →  <flux:spacer />
<a class="flux-btn flux-btn-amber">→  <flux:button variant="primary">
```

**ไฟล์ที่สร้าง:**

- `resources/views/components/layouts/app.blade.php` (เพิ่ม header)

**✅ ทดสอบ:** Scroll ลงแล้ว Header ติดอยู่ด้านบน + เมนูคลิกได้ + Dark Mode toggle ทำงาน

### 3.3 — Footer

**สิ่งที่จะเรียนรู้:**

- สร้าง footer ด้วย Tailwind — `bg-zinc-950 text-white`
- ไม่ต้องเขียน CSS เอง ใช้ Tailwind class: `flex`, `justify-between`, `py-8`
- การใช้ Component ซ้ำ — footer อยู่ใน layout ใช้ได้ทุกหน้า

**ไฟล์ที่แก้ไข:**

- `resources/views/components/layouts/app.blade.php` (เพิ่ม footer)

**✅ ทดสอบ:** ทุกหน้ามี footer เหมือนกัน + แสดงผลถูกต้องทั้ง Light/Dark

---

## 🎯 Module 4: สร้างหน้าเว็บแต่ละ Section

> 🎨 เปรียบเทียบ: "ตกแต่งแต่ละห้องในบ้าน — ห้องรับแขก ห้องครัว ห้องนอน"

### 4.1 — Hero Section (หน้าแรก)

**สิ่งที่จะเรียนรู้:**

- การจัด Layout 2 คอลัมน์ด้วย Tailwind: `grid grid-cols-1 lg:grid-cols-2`
- Responsive Design — `lg:` prefix (แสดงเมื่อจอใหญ่กว่า 1024px)
- การสร้าง Trust Badge ด้วย `<flux:badge>`
- Hero Card ด้วย `<flux:card>`
- Background gradient ด้วย Tailwind: `bg-gradient-to-br from-slate-800 to-slate-900`

**แปลงจาก HTML เดิม:**

```
HTML เดิม                          →  Tailwind + Flux
─────────────────────────────────────────────────────
class="hero"                       →  class="bg-slate-800 text-white py-24"
class="hero-grid"                  →  class="grid lg:grid-cols-2 gap-14"
class="trust-badges"               →  class="grid grid-cols-2 lg:grid-cols-4 gap-3"
class="trust-badge"                →  <flux:card> + Tailwind
class="hero-card"                  →  <flux:card> + backdrop-blur
class="hc-tag"                     →  <flux:badge color="amber" variant="pill">
class="flux-btn flux-btn-line"     →  <flux:button> custom สี LINE
```

**ไฟล์ที่สร้าง:**

- `resources/views/livewire/pages/home.blade.php`

**✅ ทดสอบ:** หน้า Hero แสดงถูกต้อง + Responsive (ย่อจอแล้วเรียงเป็น 1 คอลัมน์)

### 4.2 — Transparency Section (ความโปร่งใส)

**สิ่งที่จะเรียนรู้:**

- การสร้าง Quote Card ด้วย `<flux:card>` + Tailwind
- `border-l-4 border-amber-600` — เส้นข้างซ้ายแบบเน้น
- Signature block — Avatar + ชื่อ + ตำแหน่ง

**ไฟล์ที่แก้ไข:**

- `resources/views/livewire/pages/home.blade.php` (เพิ่ม section)

**✅ ทดสอบ:** Quote card แสดงสวยงาม + border สีทองด้านซ้าย

### 4.3 — Process Section (6 ขั้นตอน)

**สิ่งที่จะเรียนรู้:**

- สร้าง Step indicators (วงกลมมีเลข) ด้วย Tailwind
- `grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6` — responsive grid
- Heroicons — ไอคอนที่ Flux UI ใช้ในตัว
- Dark section — `bg-slate-800 text-white`
- เส้นเชื่อมระหว่าง step (optional advanced)

**ไฟล์ที่แก้ไข:**

- `resources/views/livewire/pages/home.blade.php` (เพิ่ม section)

**✅ ทดสอบ:** 6 ขั้นตอนแสดงเรียงกัน + responsive บนมือถือ

### 4.4 — Services Section (บริการ 6 อย่าง)

**สิ่งที่จะเรียนรู้:**

- Card Grid — `grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4`
- `<flux:card>` + hover effect: `hover:border-amber-600 hover:-translate-y-1 transition`
- `<flux:badge variant="pill" color="amber">` — ป้ายท้าย card
- Icon ในกล่อง — `<flux:icon name="magnifying-glass">`

**แปลงจาก HTML เดิม:**

```
HTML เดิม                          →  Flux + Tailwind
─────────────────────────────────────────────────────
class="services-grid"              →  class="grid md:grid-cols-2 lg:grid-cols-3 gap-4"
class="flux-card service-card"     →  <flux:card class="hover:border-amber-600...">
class="service-icon"               →  <div class="w-12 h-12 rounded-lg ...">
class="flux-badge flux-badge-pill" →  <flux:badge variant="pill" color="amber">
```

**ไฟล์ที่แก้ไข:**

- `resources/views/livewire/pages/home.blade.php` (เพิ่ม section)

**✅ ทดสอบ:** Hover แต่ละ card แล้วเลื่อนขึ้นเล็กน้อย + Badge สีทองท้าย card

### 4.5 — Brands Section (ยี่ห้อที่รับซ่อม)

**สิ่งที่จะเรียนรู้:**

- `<flux:badge variant="pill">` — pill badge สำหรับแต่ละยี่ห้อ
- `flex flex-wrap justify-center gap-3` — จัด badge ให้ตัดบรรทัดเอง
- hover effect บน badge

**ไฟล์ที่แก้ไข:**

- `resources/views/livewire/pages/home.blade.php` (เพิ่ม section)

**✅ ทดสอบ:** เห็น pill แต่ละยี่ห้อ + Hover เปลี่ยนสี

---

## 📝 Module 5: สร้างฟอร์มรับงานซ่อม (Livewire Form)

> 📬 เปรียบเทียบ: "สร้างกล่องรับจดหมาย ที่คัดกรองจดหมายไม่สมบูรณ์ออก"

### 5.1 — สร้าง Inquiry Form Component

**สิ่งที่จะเรียนรู้:**

- Volt Component แบบ Full Form
- `state()` สำหรับทุก field — name, phone, brand, symptom, channel
- `wire:model` ผูกแต่ละ input
- `wire:submit` — ส่งฟอร์มโดยไม่ reload
- Layout 2 คอลัมน์ ชื่อ+เบอร์โทร

**Flux Components ที่ใช้:**

- `<flux:input>` — ชื่อ, เบอร์โทร, ยี่ห้อ
- `<flux:textarea>` — อาการ
- `<flux:radio.group>` — ช่องทาง (Line / โทรกลับ / นัดรับเครื่อง)
- `<flux:button type="submit">` — ปุ่มส่ง

**ไฟล์ที่สร้าง:**

- `resources/views/livewire/inquiry-form.blade.php`

**✅ ทดสอบ:** กรอกข้อมูลแล้วกดส่ง → เห็นข้อมูลแสดงกลับมา (ยังไม่ save DB)

### 5.2 — Validation ภาษาไทย

**สิ่งที่จะเรียนรู้:**

- `$this->validate()` — กฎ: required, min, regex
- Custom error messages ภาษาไทย
- Flux UI แสดง error ใต้ input อัตโนมัติ (ไม่ต้องเขียน `@error` เอง)
- Real-time validation ด้วย `wire:model.blur` — เช็คเมื่อคลิกออกจากช่อง

**ไฟล์ที่แก้ไข:**

- `resources/views/livewire/inquiry-form.blade.php`

**✅ ทดสอบ:** กดส่งฟอร์มเปล่า → error ภาษาไทยขึ้นใต้ทุกช่อง

### 5.3 — Success State + Toast

**สิ่งที่จะเรียนรู้:**

- `$this->saved = true` — flag เปลี่ยนหน้าจอ
- `<flux:callout variant="success">` — กล่องสำเร็จ
- Flux Toast (ถ้า Flux Free รองรับ) หรือสร้าง Toast Component เอง
- `$this->reset()` — ล้างฟอร์ม
- ปุ่ม "กรอกใหม่"

**ไฟล์ที่แก้ไข:**

- `resources/views/livewire/inquiry-form.blade.php`

**✅ ทดสอบ:** กรอกข้อมูลครบ กดส่ง → เห็น Callout สีเขียว "รับเรื่องแล้ว" + Toast pop-up

---

## 💾 Module 6: เชื่อมต่อ MySQL (เก็บข้อมูลจริง)

> 🗄️ เปรียบเทียบ: "สร้างโกดังเก็บของ แล้วต่อท่อจากกล่องรับจดหมายเข้าโกดัง"

### 6.1 — Migration (แบบแปลนตาราง)

**สิ่งที่จะเรียนรู้:**

- Migration คืออะไร (แบบแปลนที่บอกว่าตารางมี column อะไรบ้าง)
- `php artisan make:migration create_inquiries_table` — สร้างแบบแปลน
- ชนิดข้อมูล: `string`, `text`, `boolean`, `timestamps`, `nullable()`
- `php artisan migrate` — สร้างตารางจริงใน MySQL
- `php artisan migrate:rollback` — ย้อนกลับ (ลบตาราง)

**ไฟล์ที่สร้าง:**

- `database/migrations/xxxx_create_inquiries_table.php`

**โครงสร้างตาราง `inquiries`:**

| Column     | Type              | คำอธิบาย                         |
| ---------- | ----------------- | -------------------------------- |
| id         | bigint (auto)     | เลข ID อัตโนมัติ                 |
| name       | string            | ชื่อลูกค้า                       |
| phone      | string            | เบอร์โทร                         |
| brand      | string (nullable) | ยี่ห้อ/รุ่นเครื่อง               |
| symptom    | text              | อาการเครื่อง                     |
| channel    | string            | ช่องทางติดต่อ (line/call/pickup) |
| status     | string            | สถานะ (pending/in_progress/done) |
| created_at | timestamp         | วันที่สร้าง                      |
| updated_at | timestamp         | วันที่แก้ไข                      |

**✅ ทดสอบ:** เปิด MySQL client → เห็นตาราง `inquiries` พร้อม columns ครบ

### 6.2 — Model (ตัวแทนตาราง)

**สิ่งที่จะเรียนรู้:**

- Model คืออะไร (ตัวแทนของตาราง — ใช้ PHP คุยกับ Database แทน SQL)
- `php artisan make:model Inquiry` — สร้าง Model
- `$fillable` — รายการ field ที่อนุญาตให้บันทึก (ลิสต์ขาวกันคนไม่ดี)
- `Inquiry::create()` — บันทึกข้อมูลใหม่
- `Inquiry::all()` — ดึงข้อมูลทั้งหมด
- `Inquiry::find($id)` — ค้นหาตาม ID

**ไฟล์ที่สร้าง:**

- `app/Models/Inquiry.php`

**✅ ทดสอบ:** ใช้ `php artisan tinker` → `Inquiry::create([...])` → `Inquiry::all()` เห็นข้อมูล

### 6.3 — เชื่อม Form กับ Database

**สิ่งที่จะเรียนรู้:**

- แก้ `$submit` function ใน inquiry-form.blade.php
- `Inquiry::create()` ภายใน Livewire
- ตัด flow: validate → save DB → reset form → แสดง success
- ทำไมต้อง validate ก่อน save (ป้องกันข้อมูลขยะ)

**ไฟล์ที่แก้ไข:**

- `resources/views/livewire/inquiry-form.blade.php`

**✅ ทดสอบ:** กรอกฟอร์ม กดส่ง → เช็คใน Tinker ว่าข้อมูลอยู่ใน DB จริง

---

## 🖼️ Module 7: Gallery ผลงานซ่อม

> 📸 เปรียบเทียบ: "ติดรูปผลงานที่ผนังร้าน — ลูกค้าเห็นแล้วมั่นใจ"

### 7.1 — Migration + Model สำหรับ Gallery

**สิ่งที่จะเรียนรู้:**

- ตาราง `gallery_items` — title, description, image_path, category, is_featured
- การเก็บรูปภาพ — บันทึก path ไม่ใช่ตัวรูปใน DB
- `php artisan storage:link` — เชื่อมโฟลเดอร์ storage เข้า public

**ไฟล์ที่สร้าง:**

- `database/migrations/xxxx_create_gallery_items_table.php`
- `app/Models/GalleryItem.php`

**✅ ทดสอบ:** Tinker สร้าง GalleryItem ได้ + ดึงข้อมูลได้

### 7.2 — Gallery Component (แสดงผลงาน)

**สิ่งที่จะเรียนรู้:**

- ดึงข้อมูลจาก DB ด้วย `GalleryItem::where('is_featured', true)->get()`
- CSS Grid Layout ด้วย Tailwind: `grid-cols-2 md:grid-cols-3 lg:grid-cols-4`
- `<flux:card>` + overflow-hidden สำหรับ thumbnail
- Image tag ใน Blade: `<img src="{{ Storage::url($item->image_path) }}">`
- Empty state — แสดงข้อความเมื่อยังไม่มีรูป

**ไฟล์ที่สร้าง:**

- `resources/views/livewire/gallery-section.blade.php`

**✅ ทดสอบ:** เห็น grid รูปภาพผลงาน + Responsive บนมือถือ

### 7.3 — Upload รูปภาพ (Admin Feature)

**สิ่งที่จะเรียนรู้:**

- Livewire File Upload: `WithFileUploads` trait
- `wire:model="photo"` — เลือกไฟล์รูป
- `$this->photo->store('gallery', 'public')` — บันทึกไฟล์
- Validation รูป: `image|max:2048|mimes:jpg,png,webp`
- Preview รูปก่อนอัปโหลด: `$this->photo->temporaryUrl()`

**ไฟล์ที่สร้าง:**

- `resources/views/livewire/admin/gallery-upload.blade.php`

**✅ ทดสอบ:** เลือกรูป → เห็น preview → กดบันทึก → รูปขึ้นใน Gallery

---

## ❓ Module 8: FAQ — Accordion + Dynamic Content

> 📖 เปรียบเทียบ: "สร้างหนังสือคำถามที่ถามบ่อย กดเปิดดูคำตอบทีละข้อ"

### 8.1 — Accordion ด้วย Flux UI

**สิ่งที่จะเรียนรู้:**

- `<flux:accordion>` — คำถามพับเก็บได้
- `<flux:accordion.item>` — แต่ละคำถาม
- Static FAQ — Hard-code คำถามใน Blade (เหมาะกับ FAQ ที่ไม่ค่อยเปลี่ยน)
- Tailwind styling: `max-w-3xl mx-auto` — จำกัดความกว้าง

**แปลงจาก HTML เดิม:**

```
HTML เดิม                          →  Flux UI
─────────────────────────────────────────────────
<details class="accordion-item">   →  <flux:accordion.item>
<summary>คำถาม</summary>           →  heading="คำถาม"
<div class="accordion-content">    →  เนื้อหาภายใน tag
```

**ไฟล์ที่สร้าง:**

- `resources/views/livewire/faq-section.blade.php`

**✅ ทดสอบ:** คลิกคำถาม → คำตอบเลื่อนออกมา + คลิกอีกที → พับกลับ

### 8.2 — Dynamic FAQ จาก Database (Optional)

**สิ่งที่จะเรียนรู้:**

- ตาราง `faqs` — question, answer, sort_order, is_active
- Model `Faq.php`
- ดึงคำถามจาก DB: `Faq::where('is_active', true)->orderBy('sort_order')->get()`
- Loop ใน Blade: `@foreach($faqs as $faq)`

**ไฟล์ที่สร้าง:**

- `database/migrations/xxxx_create_faqs_table.php`
- `app/Models/Faq.php`
- Seeder สำหรับใส่คำถามตัวอย่าง

**✅ ทดสอบ:** เพิ่มคำถามผ่าน Tinker → คำถามใหม่ขึ้นบนหน้าเว็บทันที

---

## 🔐 Module 9: Admin Dashboard (หลังบ้าน)

> 🏢 เปรียบเทียบ: "สร้างห้องทำงานส่วนตัว — มีจอ Monitor ติดตามงานซ่อมทั้งหมด"

### 9.1 — Authentication (ระบบ Login)

**สิ่งที่จะเรียนรู้:**

- Laravel Auth Scaffolding: `php artisan make:auth` หรือ Breeze
- Route Middleware: `auth` — ปิดกั้นคนที่ไม่ได้ login
- `Route::middleware('auth')->group(...)` — กลุ่ม route ที่ต้อง login
- สร้าง Admin user ผ่าน Seeder

**ไฟล์ที่แก้ไข:**

- `routes/web.php`
- `database/seeders/DatabaseSeeder.php`

**✅ ทดสอบ:** เข้า `/admin` โดยไม่ login → โดนเด้งไปหน้า Login

### 9.2 — Dashboard Overview

**สิ่งที่จะเรียนรู้:**

- Stat Cards — จำนวนงานวันนี้, กำลังซ่อม, เสร็จแล้ว
- `Inquiry::where('status', 'pending')->count()` — นับจำนวน
- `Inquiry::whereDate('created_at', today())->count()` — นับวันนี้
- Flux UI สำหรับ Dashboard: Card + Badge + Heading

**ไฟล์ที่สร้าง:**

- `resources/views/livewire/admin/dashboard.blade.php`

**✅ ทดสอบ:** Login แล้วเห็น Dashboard พร้อมตัวเลขสรุป

### 9.3 — Inquiry List (รายการงานซ่อม)

**สิ่งที่จะเรียนรู้:**

- `<flux:table>` — ตารางแสดงข้อมูล
- Pagination (แบ่งหน้า): `Inquiry::latest()->paginate(10)`
- `<flux:badge>` — สถานะสีต่าง ๆ (pending=เหลือง, in_progress=ฟ้า, done=เขียว)
- ปุ่มเปลี่ยนสถานะ — `wire:click="updateStatus($id, 'in_progress')"`
- ค้นหา — `wire:model.live="search"` + query filter

**ไฟล์ที่สร้าง:**

- `resources/views/livewire/admin/inquiry-list.blade.php`

**✅ ทดสอบ:** เห็นรายการงานซ่อม + เปลี่ยนสถานะได้ + ค้นหาทำงาน + แบ่งหน้าได้

### 9.4 — Inquiry Detail (รายละเอียดงาน)

**สิ่งที่จะเรียนรู้:**

- Route parameter: `/admin/inquiries/{id}`
- `Inquiry::findOrFail($id)` — ค้นหาหรือ 404
- แสดงรายละเอียด — ชื่อ, เบอร์, อาการ, สถานะ, วันที่
- ปุ่ม Action — โทรกลับ, เปิด Line, เปลี่ยนสถานะ
- ใส่บันทึกช่าง (notes field เพิ่มเติม)

**ไฟล์ที่สร้าง:**

- `resources/views/livewire/admin/inquiry-detail.blade.php`

**✅ ทดสอบ:** คลิกรายการ → เห็นรายละเอียดครบ + เปลี่ยนสถานะได้

---

## 🚀 Module 10: ปรับแต่งสุดท้าย + Deploy

> 🎀 เปรียบเทียบ: "ทาสี ติดป้าย เปิดร้านให้ลูกค้าเข้า"

### 10.1 — SEO + Meta Tags

**สิ่งที่จะเรียนรู้:**

- `<title>` + `<meta description>` — สำคัญสำหรับ Google
- Schema.org JSON-LD — ข้อมูล LocalBusiness (ย้ายจาก HTML เดิม)
- Open Graph tags — สำหรับ share บน Facebook/Line
- `@section('title')` / `@section('description')` — ส่งค่า SEO แต่ละหน้า

**ไฟล์ที่แก้ไข:**

- `resources/views/components/layouts/app.blade.php`

**✅ ทดสอบ:** ตรวจ View Source → เห็น meta tags ครบ

### 10.2 — Responsive Final Check

**สิ่งที่จะเรียนรู้:**

- ทดสอบ Mobile (375px), Tablet (768px), Desktop (1280px)
- Tailwind Responsive: `sm:`, `md:`, `lg:`, `xl:` prefix
- เมนู Mobile — Hamburger menu (flux:navbar ซ่อนบนมือถือ)
- Touch-friendly — ปุ่มใหญ่พอสำหรับนิ้วแตะ (min 44px)

**✅ ทดสอบ:** เปิด DevTools → Toggle Device → ทุกหน้าแสดงผลสวยทุกขนาดจอ

### 10.3 — Performance + Security

**สิ่งที่จะเรียนรู้:**

- `npm run build` — build CSS/JS สำหรับ production (ไฟล์เล็กลง)
- `php artisan config:cache` — cache config ให้เร็วขึ้น
- `php artisan route:cache` — cache routes
- CSRF Protection — Laravel ใส่ให้อัตโนมัติ ทุกฟอร์ม
- Rate Limiting — ป้องกัน spam submit

**✅ ทดสอบ:** Lighthouse score > 80 ทุกหมวด

### 10.4 — Deploy (แนะนำ)

**สิ่งที่จะเรียนรู้:**

- ทางเลือก: Shared Hosting, VPS (DigitalOcean), PaaS (Laravel Forge)
- ตั้งค่า `.env` สำหรับ production
- `APP_ENV=production`, `APP_DEBUG=false`
- Domain name + SSL (HTTPS)

**✅ ทดสอบ:** เปิดเว็บจาก domain จริง → ทุกอย่างทำงาน + HTTPS ขึ้นล็อคสีเขียว

---

## 📊 สรุปสิ่งที่ได้เรียนรู้ทั้งหมด

### เทคโนโลยี

| เทคโนโลยี           | สิ่งที่ได้เรียน                                               |
| ------------------- | ------------------------------------------------------------- |
| **Laravel 13**      | Routing, MVC, Migration, Model, Middleware, Artisan CLI       |
| **Livewire 3 Volt** | State, wire:click, wire:model, wire:submit, Validation        |
| **Flux UI**         | Button, Card, Badge, Input, Textarea, Radio, Table, Accordion |
| **Tailwind CSS**    | Utility classes, Responsive, Dark mode, Grid, Flex            |
| **MySQL**           | CREATE DATABASE, Migration, CRUD, Query                       |

### ทักษะ

| ทักษะ                       | Module ที่ได้ฝึก |
| --------------------------- | ---------------- |
| ติดตั้งโปรเจกต์ตั้งแต่ศูนย์ | Module 1         |
| ใช้ UI Component สำเร็จรูป  | Module 2, 4      |
| สร้าง Layout + Navigation   | Module 3         |
| สร้าง Landing Page          | Module 4         |
| สร้าง Form + Validation     | Module 5         |
| เชื่อมต่อ Database          | Module 6         |
| จัดการรูปภาพ + Upload       | Module 7         |
| Dynamic Content             | Module 8         |
| สร้าง Admin Panel           | Module 9         |
| Deploy เว็บจริง             | Module 10        |

### ไฟล์ทั้งหมดที่จะสร้าง

```
vacuum-repair-system/
├── app/Models/
│   ├── Inquiry.php
│   ├── GalleryItem.php
│   └── Faq.php
├── database/migrations/
│   ├── xxxx_create_inquiries_table.php
│   ├── xxxx_create_gallery_items_table.php
│   └── xxxx_create_faqs_table.php
├── resources/views/
│   ├── components/layouts/
│   │   └── app.blade.php              ← Layout หลัก
│   └── livewire/
│       ├── pages/
│       │   └── home.blade.php         ← หน้าแรก (Hero+Process+Services+...)
│       ├── inquiry-form.blade.php     ← ฟอร์มรับงาน
│       ├── gallery-section.blade.php  ← แสดงผลงาน
│       ├── faq-section.blade.php      ← คำถามที่พบบ่อย
│       ├── admin/
│       │   ├── dashboard.blade.php    ← Dashboard
│       │   ├── inquiry-list.blade.php ← รายการงาน
│       │   ├── inquiry-detail.blade.php← รายละเอียดงาน
│       │   └── gallery-upload.blade.php← อัปโหลดรูป
│       └── workshop/                  ← ไฟล์ฝึกหัด (ลบทิ้งได้)
│           ├── workshop-buttons.blade.php
│           ├── workshop-cards.blade.php
│           ├── workshop-form.blade.php
│           └── workshop-darkmode.blade.php
└── routes/
    └── web.php                        ← เส้นทาง URL ทั้งหมด
```

---

## 🛤️ แนะนำลำดับการเรียน

**ถ้ามีเวลาน้อย (MVP — เว็บขึ้นได้เร็วที่สุด):**
Module 1 → 3 → 4.1 → 5 → 6 → 10

**ถ้ามีเวลาปานกลาง (เว็บครบฟีเจอร์หลัก):**
Module 1 → 2 → 3 → 4 → 5 → 6 → 8 → 10

**ถ้าอยากเรียนครบ (Full Course):**
Module 1 → 2 → 3 → 4 → 5 → 6 → 7 → 8 → 9 → 10

---

_สร้างด้วย ❤️ สำหรับมือใหม่ที่อยากเรียน Laravel ผ่านโปรเจกต์จริง_
