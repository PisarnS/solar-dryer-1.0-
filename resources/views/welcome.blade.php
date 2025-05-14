@extends('layout')
@section('title')
    หน้าแรก
@endsection
@section('content')
    <div class="contianer mt-3 rounded-3 table-responsive vh-100 shadow d-flex flex-column border border-primary">
        <table class="table table-border align-middle text-center">
            <thead class="table-secondary" style="background-color:#97CADB;">
                <tr>
                    <th class="col-1">หมายเลข</th>
                    <th><i class="bi bi-device-ssd col-2"></i></th>
                    <th class="col-7 text-start">สถานะการทำงาน</th>
                    <th class="col-2">ดู</th>
                    <th class="col-2">ลบ</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <th><i class="bi bi-device-ssd"></i></th>
                    <td class="text-start">กำลังทำงาน</td>
                    <td><a href="{{ route('display') }}"><i class="bi bi-eye-fill"></i></a></td>
                    <td><i class="bi bi-dash-circle-fill text-danger"></i></td>
                </tr>
                <tr>
                    <td>2</td>
                    <th><i class="bi bi-device-ssd"></i></th>
                    <td class="text-start">กำลังทำงาน</td>
                    <td><a href="{{ route('display') }}"><i class="bi bi-eye-fill"></i></a></td>
                    <td><i class="bi bi-dash-circle-fill text-danger"></i></td>
                </tr>
                <tr>
                    <td>3</td>
                    <th><i class="bi bi-device-ssd"></i></th>
                    <td class="text-start">พักเครื่อง</td>
                    <td><a href="{{ route('display') }}"><i class="bi bi-eye-fill"></i></a></td>
                    <td><i class="bi bi-dash-circle-fill text-danger"></i></td>
                </tr>
                <tr>
                    <td>4</td>
                    <th><i class="bi bi-device-ssd"></i></th>
                    <td class="text-start">กำลังทำงาน</td>
                    <td><a href="{{ route('display') }}"><i class="bi bi-eye-fill"></i></a></td>
                    <td><i class="bi bi-dash-circle-fill text-danger"></i></td>
                </tr>
            </tbody>
        </table>
        <div class="mt-auto text-center m-3">
            <a href="{{ route('esp32-data') }}"><i class="bi bi-plus-circle-fill fs-3 text-primary"></i></a>
        </div>
    </div>
@endsection
