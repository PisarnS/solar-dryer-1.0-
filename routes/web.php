<?php

use Illuminate\Support\Facades\Route;
use App\Models\Esp32Data;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\HistoryController;

// แสดงหน้า welcome
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// แสดงหน้า setting
Route::get('setting', function () {
    return view('setting');
})->name('setting');

// แสดงหน้า login
Route::get('login', function () {
    return view('login');
})->name('login');

// แสดงหน้าจอแสดงผลข้อมูล (กราฟหรือ table)
Route::get('/display', function () {
    return view('display');
})->name('display');

// API สำหรับดึงข้อมูลจากฐานข้อมูลล่าสุด โดยกำหนดจำนวนที่ต้องการผ่าน URL เช่น /get-esp32-data?limit=50
Route::get('/get-esp32-data', function (Request $request) {
    $limit = $request->query('limit', 100); // ดึงค่าจาก URL ถ้าไม่มีให้ใช้ 100
    return response()->json(Esp32Data::latest()->take($limit)->get());
})->name('get-esp32-data');

// แสดงหน้าผู้ใช้งาน
Route::get('/user-page', function () {
    return view('user-page');
})->name('user-page');

// กรณีเข้า URL ที่ไม่มี route ตรงกัน
Route::fallback(function(){
    return"ไม่พบหน้าเว็บ";
});

//------------------------------------- esp32 controller -------------------------------------

// route แสดงหน้าแรก (home) โดยดึงข้อมูลล่าสุด 100 รายการจาก esp32_data
Route::get('/', function () {
    $data = Esp32Data::latest()->take(100)->get(); // ดึงข้อมูล 10 รายการล่าสุด
    return view('welcome', ['data' => $data]);
})->name('home');

// route สำหรับแสดงข้อมูลทั้งหมดในหน้า esp32-data
Route::get('/esp32-data', function () {
    $data = Esp32Data::latest()->take(100)->get(); // ดึงข้อมูล 10 รายการล่าสุด
    return view('esp32-data', ['data' => $data]);
})->name('esp32-data');

// route แสดงประวัติข้อมูล โดยใช้ Controller แยกเพื่อจัดการ
Route::get('/history', [HistoryController::class, 'index'])->name('history');

//------------------------------------- ดาวน์โหลดข้อมูลเป็นไฟล์ CSV -------------------------------------

Route::get('/download-csv', function () {
    $data = Esp32Data::all(); // ดึงข้อมูลทั้งหมดจากตาราง

    // ตั้งชื่อไฟล์ CSV ตามวันที่/เวลา
    $filename = "esp32_data_" . now()->format('Y-m-d_H-i-s') . ".csv";
    $handle = fopen('php://temp', 'w'); // สร้างไฟล์ CSV ชั่วคราวใน memory

    // เขียนหัวตาราง (column names)
    fputcsv($handle, ['ID', 'Temperature', 'Humidity', 'LightIntensity', 'Weight', 'Created At']);//เกี่ยวเซนเซอร์ ถ้าต้องการเพิ่มให้เพิ่มตรงนี้

    // เขียนข้อมูลแต่ละแถวลงไฟล์
    foreach ($data as $row) {
        fputcsv($handle, [
            //เกี่ยวเซนเซอร์ ถ้าต้องการเพิ่มให้เพิ่มตรงนี้
            $row->id,
            $row->temperature,
            $row->humidity,
            $row->LightIntensity,
            $row->weight,
            $row->created_at,
        ]);
    }

    rewind($handle); // กลับไปจุดเริ่มต้นของไฟล์
    $csv = stream_get_contents($handle); // อ่านข้อมูลทั้งหมดในไฟล์
    fclose($handle);

    // ส่งไฟล์ CSV กลับไปให้ดาวน์โหลด
    return Response::make($csv, 200, [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ]);
})->name('download-csv');