@extends('layout')
@section('title')
หน้าแรก
@endsection
@section('content')

<div class="contianer mt-3 rounded-3 table-responsive vh-100 shadow d-flex flex-column">
    <div class="m-4">
        <ul class="nav fs-3 d-flex align-items-center">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ route('display') }}">
                    <i class="bi bi-arrow-left-circle-fill text-dark"></i>
                </a>
            </li>
            <li class="nav-item d-flex align-items-center">
                <p class="mb-0">ตั้งค่าการแสดงผล</p>
            </li>
        </ul>
        <hr>
        <form>
            <p>แจ้งเตือนหลังอบเสร็จ</p>
            <div class="d-flex">
                <div class="form-check ms-3">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                    <label class="form-check-label" for="flexRadioDefault1">
                        5 นาที
                    </label>
                </div>
                <div class="form-check ms-3">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                    <label class="form-check-label" for="flexRadioDefault2">
                        10 นาที
                    </label>
                </div>
                <div class="form-check ms-3">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3">
                    <label class="form-check-label" for="flexRadioDefault3">
                        15 นาที
                    </label>
                </div>
            </div>
            <p class="my-2">กราฟแสดงผล</p>
            <div class="d-flex">
                <div class="form-check ms-3">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault5">
                    <label class="form-check-label" for="flexRadioDefault5">
                        2 นาที
                    </label>
                </div>
                <div class="form-check ms-3">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault6">
                    <label class="form-check-label" for="flexRadioDefault6">
                        3 นาที
                    </label>
                </div>
                <div class="form-check ms-3">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault7">
                    <label class="form-check-label" for="flexRadioDefault7">
                        5 นาที
                    </label>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection