<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id(); // รหัสใบงาน (รันอัตโนมัติ 1, 2, 3...)

            // 💡 สิ่งที่เราต้องเพิ่มเข้าไป เพื่อรับข้อมูลจากฟอร์ม:
            $table->string('name');             // ชื่อลูกค้า
            $table->string('phone');            // เบอร์โทร
            $table->string('brand');            // ยี่ห้อเครื่องดูดฝุ่น
            $table->text('symptom');            // อาการที่เสีย (ใช้ text เพราะอาจจะพิมพ์ยาว)
            $table->string('status')->default('pending'); // สถานะงาน (ตั้งค่าเริ่มต้นเป็น pending = รอดำเนินการ)

            $table->timestamps(); // วันที่สร้างและแก้ไข (Laravel จัดการให้อัตโนมัติ)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
