@extends('layout')
@section('title')
    หน้าแรก
@endsection
@section('content')
    <div class="contianer mt-3 w-100">

        <ul class="nav border border-1 shadow-sm rounded-3 fs-3 mb-3 d-flex align-items-center">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ route('display') }}">
                    <i class="bi bi-arrow-left-circle-fill text-dark"></i>
                </a>
            </li>
            <li class="nav-item d-flex align-items-center">
                <p class="mb-0">ประวัติย้อนหลัง</p>
            </li>
        </ul>

        <form action="" class="shadow-sm mb-3 border rounded p-2">
            <div class="row align-items-end">
                <div class="col-md-6">
                    <label class="form-label">เลือกวัน:</label>
                    <select class="form-select" aria-label="Default select example">
                        <option selected>วันนี้</option>
                        <option value="1">เมื่อวาน</option>
                        <option value="2">สองวันที่แล้ว</option>
                        <option value="3">สามวันที่แล้ว</option>
                    </select>
                </div>
                {{-- <div class="col-md-6">
                    <label for="historyTimeRange" class="form-label">เลือกช่วงเวลา:</label>
                    <select id="historyTimeRange" class="form-select">
                        <option value="30">30 นาที</option>
                        <option value="60">1 ชั่วโมง</option>
                        <option value="120">2 ชั่วโมง</option>
                        <option value="360">6 ชั่วโมง</option>
                    </select>
                </div> --}}
            </div>
        </form>

        <div class="card mb-3 shadow-sm">
            <div class="card-header">
                <div class="row p-2">
                    <div class="col-12">
                        น้ำหนักของผลิตภัณฑ์
                        <i class="bi bi-train-lightrail-front-fill"></i>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="w-100 ">
                    <div class="position-relative" style="aspect-ratio: 16/6;">
                        <canvas id="weightChart" class="position-absolute top-0 start-0 w-100 h-100"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3 shadow-sm">
            <div class="card-header">
                <div class="row p-2">
                    <div class="col-12">
                        อุณหภูมิภายในตู้
                        <i class="bi bi-thermometer-sun"></i>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="w-100">
                    <div class="position-relative" style="aspect-ratio: 16/6;">
                        <canvas id="tempChart" class="position-absolute top-0 start-0 w-100 h-100"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3 shadow-sm">
            <div class="card-header">
                <div class="row p-2">
                    <div class="col-12">
                        ความชื้นสัมพัทธ์
                        <i class="bi bi-droplet-half"></i>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="w-100">
                    <div class="position-relative" style="aspect-ratio: 16/6;">
                        <canvas id="humidityChart" class="position-absolute top-0 start-0 w-100 h-100"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3 shadow-sm">
            <div class="card-header">
                <div class="row p-2">
                    <div class="col-12">
                        ความเข้มแสง
                        <i class="bi bi-brightness-high-fill"></i>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="w-100">
                    <div class="position-relative" style="aspect-ratio: 16/6;">
                        <canvas id="lightChart" class="position-absolute top-0 start-0 w-100 h-100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // ส่งข้อมูลจาก Blade ไปยัง JavaScript
        window.historyData = {
            labels: @json($labels),
            temperature: @json($temperature),
            humidity: @json($humidity),
            weight: @json($weight),
            light: @json($light)
        };
    </script>
    <!-- โหลดไฟล์ display.js -->
    <script src="{{ asset('js/history.js') }}"></script>
@endsection

