<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->string('fault')->nullable()->after('description');
            $table->text('symptom')->nullable()->after('fault');
            $table->text('found')->nullable()->after('symptom');
            $table->text('fixed')->nullable()->after('found');
            $table->string('price')->nullable()->after('duration');
        });

        $mocks = [
            [
                'title' => 'ซ่อมเครื่องดูดฝุ่นแบบถังสแตนเลส น้ำเข้าตู้มอเตอร์จนช็อต เปลี่ยนมอเตอร์ใหม่ พร้อมทำความสะอาดระบบ',
                'fault' => 'มอเตอร์ช็อตจากน้ำเข้า',
                'symptom' => 'ลูกค้าแจ้งว่าเครื่องดับและมีอาการช็อตหลังใช้งานดูดน้ำ',
                'found' => 'น้ำเข้าตู้มอเตอร์ คอยล์เสีย ไม่สามารถใช้ต่อได้',
                'fixed' => 'เปลี่ยนมอเตอร์ใหม่ พร้อมทำความสะอาดระบบทั้งชุด',
                'duration' => '1 วัน',
                'price' => 'ประมาณ 4,500 บาท',
            ],
            [
                'title' => 'Overhaul เครื่องดูดฝุ่นอุตสาหกรรมที่ใช้งานหนัก เปลี่ยนตลับลูกปืนและซีลกันฝุ่น แก้ปัญหาเสียงดังครืดๆ',
                'fault' => 'แบริ่งเสื่อม / เสียงดังผิดปกติ',
                'symptom' => 'ใช้งานหนักแล้วมีเสียงดังครืดๆ แรงดูดเริ่มไม่นิ่ง',
                'found' => 'ตลับลูกปืนและซีลกันฝุ่นเสื่อมจากการใช้งานต่อเนื่อง',
                'fixed' => 'Overhaul เปลี่ยนแบริ่งและซีลกันฝุ่น ทดสอบโหลดหลังซ่อม',
                'duration' => '2 วัน',
                'price' => 'ประมาณ 6,200 บาท',
            ],
            [
                'title' => 'ซ่อมระบบไฟฟ้าและบอร์ดควบคุมเครื่องดูดฝุ่นแบบ HEPA Filter แก้ปัญหาเครื่องตัดการทำงานเอง',
                'fault' => 'บอร์ดควบคุมผิดปกติ / ตัดเอง',
                'symptom' => 'เครื่องตัดการทำงานเองเป็นระยะ โดยเฉพาะตอนใช้งานต่อเนื่อง',
                'found' => 'บอร์ดควบคุมและจุดต่อระบบไฟฟ้าผิดปกติ',
                'fixed' => 'ซ่อม/เปลี่ยนบอร์ดควบคุม ตรวจระบบกรอง HEPA และทดสอบการทำงาน',
                'duration' => '2 วัน',
                'price' => 'ประมาณ 5,800 บาท',
            ],
            [
                'title' => 'ลูกค้าแจ้งมีไฟแลบจากตัวเครื่อง เบื้องต้นสันนิษฐานว่ามอเตอร์ช็อต เมื่อเข้าตรวจสอบหน้างานพบว่าสายไฟช็อต จึงดำเนินการเปลี่ยนสายไฟและทดสอบการทำงานจนเป็นปกติ',
                'fault' => 'สายไฟช็อต / มีไฟแลบ',
                'symptom' => 'มีไฟแลบจากตัวเครื่อง ลูกค้ากังวลว่ามอเตอร์ช็อต',
                'found' => 'สายไฟช็อต — มอเตอร์ยังใช้งานได้',
                'fixed' => 'เปลี่ยนสายไฟและทดสอบการทำงานจนเป็นปกติ',
                'duration' => '1 วัน',
                'price' => 'ประมาณ 2,500 บาท',
            ],
            [
                'title' => 'ลูกค้าแจ้งเครื่องมีเสียงผิดปกติแล้วดับเอง ไม่มีกลิ่นไหม้ ตรวจสอบพบแปรงถ่านสึกหรอจนหมด ส่งผลให้มอเตอร์สูญเสียกำลังและหยุดทำงาน ดำเนินการเปลี่ยนแปรงถ่านใหม่ เครื่องกลับมาทำงานเป็นปกติ',
                'fault' => 'แปรงถ่านหมด / มอเตอร์ดับ',
                'symptom' => 'มีเสียงผิดปกติแล้วดับเอง ไม่มีกลิ่นไหม้',
                'found' => 'แปรงถ่านสึกหรอจนหมด มอเตอร์สูญเสียกำลัง',
                'fixed' => 'เปลี่ยนแปรงถ่านใหม่ ทดสอบจนเครื่องกลับมาทำงานปกติ',
                'duration' => '1 วัน',
                'price' => 'ประมาณ 1,800 บาท',
            ],
        ];

        foreach ($mocks as $mock) {
            $title = $mock['title'];
            unset($mock['title']);

            DB::table('portfolios')
                ->where('title', $title)
                ->update(array_merge($mock, ['updated_at' => now()]));
        }

        // Fallback mock for any remaining rows without case details
        DB::table('portfolios')
            ->where(function ($query) {
                $query->whereNull('fault')->orWhere('fault', '');
            })
            ->update([
                'fault' => 'อาการเสียจากงานซ่อมจริง',
                'symptom' => 'ลูกค้าแจ้งเครื่องใช้งานผิดปกติ ส่งเข้าตรวจ',
                'found' => 'พบชิ้นส่วนเสื่อมตามอายุการใช้งาน',
                'fixed' => 'ซ่อม/เปลี่ยนชิ้นส่วนที่เกี่ยวข้องและทดสอบก่อนส่งคืน',
                'price' => 'ประมาณ 3,500 บาท',
                'updated_at' => now(),
            ]);

        DB::table('portfolios')
            ->where(function ($query) {
                $query->whereNull('duration')->orWhere('duration', '');
            })
            ->update([
                'duration' => '1–2 วัน',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn(['fault', 'symptom', 'found', 'fixed', 'price']);
        });
    }
};
