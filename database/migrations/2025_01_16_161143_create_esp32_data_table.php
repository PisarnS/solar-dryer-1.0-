<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. สร้างตาราง esp32_data
     */
    public function up()
{
    //ตรงนี้คือตารางฐานข้อมูล ถ้าต้องการเพิ่มการเก็บข้อมูลเซนเซอร์ ให้เพิ่มตรงนี้
    Schema::create('esp32_data', function (Blueprint $table) {
        $table->id();                        // Primary key แบบ auto increment
        $table->float('temperature');        // เก็บค่าอุณหภูมิ (ทศนิยมได้)
        $table->float('humidity');           // เก็บค่าความชื้น
        $table->float('LightIntensity');     // เก็บค่าความเข้มแสง
        $table->float('weight');             // เก็บค่าน้ำหนัก
        $table->timestamps();                // created_at และ updated_at
    });
}

    /**
     * Reverse the migrations. ลบตาราง (เมื่อ rollback migration แต่ถ้าไม่ต้องการลบอย่ากดคำสั่งนี้เป็นอันขาด เพราะเวลาเกิดปัญหามันแก้ยากมากๆ) 
     */
    public function down(): void
    {
        Schema::dropIfExists('esp32_data');
    }

};
