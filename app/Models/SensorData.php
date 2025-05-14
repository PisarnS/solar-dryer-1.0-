<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    use HasFactory;

    protected $table = 'sensor_data'; // ชื่อตารางในฐานข้อมูล
    protected $fillable = ['value'];  // ฟิลด์ที่สามารถเพิ่มข้อมูลได้
}

