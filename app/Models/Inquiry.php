<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    // 💡 อนุญาตให้บันทึกข้อมูลเหล่านี้ผ่านฟอร์มได้
    protected $fillable = [
        'name',
        'phone',
        'brand',
        'symptom',
        'status',
    ];
}