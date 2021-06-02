@extends('feedback.layouts.main')

@section('css')
<link rel="stylesheet" href="feedback/css/index.css">
@endsection

@section('content')
<div class="main-content">
    <div class="box container">
        <div class="box-header">
            <h3>Chào mừng bạn đến với hệ thống Đánh giá Giảng viên</h3>
            <div class="box-hr"></div>
        </div>
        <div class="box-body">
            <h3 class="text-info">
                Thông tin học viên
            </h3>
            <div class="user-info">
                <p class="info-item">
                    <i class="fas fa-user"></i>
                    <span>Họ tên học viên: </span>
                    <span class="">Đặng Đức Huy</span>
                </p>
                <p class="info-item">
                    <i class="fas fa-envelope"></i>
                    <span>Email: </span>
                    <span class="">example@gmail.com</span>
                </p>
                <p class="info-item">
                    <i class="fas fa-bell"></i>
                    <span>Trạng thái: </span>
                    <span class="">Đang học</span>
                </p>
            </div>
        </div>
    </div>
</div>

@endsection
