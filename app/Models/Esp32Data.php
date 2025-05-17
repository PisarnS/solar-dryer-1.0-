<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Esp32Data extends Model
{
    // use HasFactory; กำหนดชื่อตารางในฐานข้อมูล
    protected $table = "esp32_data";

    // กำหนดว่า field ไหนบ้างที่สามารถกรอกข้อมูลได้ (Mass assignment) แล้วถ้าต้องการเพิ่มการเก็บข้อมูลเซนเซอร์ให้เพิ่มตรงนี้ด้วย
    protected $fillable = ['temperature', 'humidity','LightIntensity','weight'];
}
