<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\Esp32Data;

// เส้นทาง API สำหรับรับข้อมูลจากเซนเซอร์ ESP32
Route::post('/data', function (Request $request) {
    try {
        // ตรวจสอบความถูกต้องของข้อมูลที่ส่งเข้ามา
        $data = $request->validate([
            'temperature' => 'required|numeric',       // อุณหภูมิ ต้องเป็นตัวเลข
            'humidity' => 'required|numeric',          // ความชื้น ต้องเป็นตัวเลข
            'LightIntensity' => 'required|numeric',    // ความเข้มแสง ต้องเป็นตัวเลข
            'weight' => 'required|numeric',            // น้ำหนัก ต้องเป็นตัวเลข
            // หากมีเซนเซอร์อื่นสามารถเพิ่มได้ที่นี่
        ]);

        // บันทึกข้อมูลลงฐานข้อมูลในตาราง esp32_data
        Esp32Data::create($data);
    } catch (\Exception $e) {
        // หากเกิดข้อผิดพลาดให้แสดงข้อความ
        response()->json(['message' => $e->getMessage()]);
    }

    // ส่งกลับว่าได้รับข้อมูลและบันทึกเรียบร้อยแล้ว
    return response()->json(['message' => 'Data saved successfully']);
});
