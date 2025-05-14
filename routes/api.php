<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\Esp32Data;

Route::post('/data', function (Request $request) {
    try {
        $data = $request->validate([
            'temperature' => 'required|numeric',
            'humidity' => 'required|numeric',
            'LightIntensity' => 'required|numeric',
            'weight' => 'required|numeric',
        ]);

        // บันทึกข้อมูลในฐานข้อมูล
        Esp32Data::create($data);
    } catch (\Exception $e) {
        response()->json(['message' => $e->getMessage()]);
    }
    return response()->json(['message' => 'Data saved successfully']);
});
