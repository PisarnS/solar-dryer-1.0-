@extends('layout')
@section('title')
    หน้าแรก
@endsection
@section('content')
    <div class="contianer mt-3 rounded-3 table-responsive vh-100 shadow d-flex flex-column">
        <div class="m-4">
            <h3>บัญชีผู้ใช้</h3>
            <hr>
            <form>
                <div class="row align-items-center mb-3">
                    <div class="col-auto">
                        <i class="bi bi-google fs-1 text-danger"></i>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0 text-danger">เชื่อมต่อด้วย google</p>
                            <a href="{{ route('login') }}" class="text-primary mb-0 text-decoration-none">สลับบัญชี</a>
                        </div>
                        <p class="fs-5 mb-0">
                            sumpong@gmail.com
                        </p>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-telegram fs-1 text-primary"></i>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0 text-primary">เชื่อมต่อด้วย Telegram</p>
                            <a href="#" class="text-primary mb-0 text-decoration-none">สลับบัญชี</a>
                        </div>
                        <p class="fs-5 mb-0">
                            sumpong@gmail.com
                        </p>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection
