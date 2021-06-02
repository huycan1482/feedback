@extends('feedback.layouts.main')

@section('css')
<!-- Box -->
<link rel="stylesheet" href="feedback/css/box.css">
<!-- Css Layout -->
<link rel="stylesheet" href="feedback/css/checkIn.css">
@endsection

@section('content')
<div class="main-content">
    <div class="row">
        <div class="col-lg-4">
            <div class="box">
                <div class="drop-box-header">
                    <p>Chọn lớp học</p>
                    <i class="fas fa-minus"></i>
                </div>
                <div class="box-body">
                    <a class="class-item" href="#">
                        <div>
                            <i class="fas fa-chalkboard"></i>
                            <span>Tên lớp học (Mã lớp)</span>
                        </div>
                        <i class="fas fa-check"></i>
                    </a>
                    <a class="class-item" href="#">
                        <div>
                            <i class="fas fa-chalkboard"></i>
                            <span>Tên lớp học (Mã lớp)</span>
                        </div>
                        <i class="fas fa-check"></i>
                    </a>
                    <a class="class-item" href="#">
                        <div>
                            <i class="fas fa-chalkboard"></i>
                            <span>Tên lớp học (Mã lớp)</span>
                        </div>
                        <i class="fas fa-check"></i>
                    </a>

                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="box">
                <div class="box-header">
                    <p class="box-title">Điểm danh Học viên</p>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="box-info">
                                <i class="fas fa-book-open"></i>
                                <span>Lớp học: </span>
                                <span>Lớp học / Mã lớp</span>
                            </div>
                            <div class="box-info">
                                <i class="fas fa-bookmark"></i>
                                <span>Khóa học: </span>
                                <span>Khóa học / Mã khóa</span>
                            </div>
                            <div class="box-info">
                                <i class="fas fa-book"></i>
                                <span>Môn học: </span>
                                <span>Môn học / Mã môn</span>
                            </div>
                            <div class="box-info">
                                <i class="fas fa-concierge-bell"></i>
                                <span>Tống số buổi: </span>
                                <span>20</span>
                            </div>
                            <div class="box-info">
                                <i class="fas fa-users"></i>
                                <span>Tổng số học viên: </span>
                                <span>20</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="box-info">
                                <i class="fas fa-bell"></i>
                                <span>Trạng thái: </span>
                                <span>Đang học</span>
                            </div>
                            <div class="box-info">
                                <i class="fas fa-hourglass-start"></i>
                                <span>Ngày bắt đầu: </span>
                                <span>00/00/0000</span>
                            </div>
                            <div class="box-info">
                                <i class="fas fa-hourglass-end"></i>
                                <span>Ngày kết thúc: </span>
                                <span>00/00/0000</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-hr"></div>
                <div class="box-body">
                    <div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center col">STT</th>
                                    <th scope="col" class="text-center col">Họ và tên</th>
                                    <th scope="col" class="text-center col">Ngày sinh</th>
                                    <th scope="col" class="text-center col">1/2</th>
                                    <th scope="col" class="text-center col">1/2</th>
                                    <th scope="col" class="text-center col">1/2</th>
                                    <th scope="col" class="text-center col">1/2</th>
                                    <th scope="col" class="text-center col">1/2</th>
                                    <th scope="col" class="text-center col">1/2</th>
                                    <th scope="col" class="text-center col">1/2</th>
                                    <th scope="col" class="text-center col">1/2</th>
                                    <th scope="col" class="text-center col">1/2</th>
                                    <th scope="col" class="text-center col">1/2</th>
                                    <th scope="col" class="text-center col">1/2</th>
                                    <th scope="col" class="text-center col">1/2</th>
                                    <th scope="col" class="text-center col">1/2</th>
                                    <th scope="col" class="text-center col">1/2</th>
                                    <th scope="col" class="text-center col">1/2</th>
                                    <th scope="col" class="text-center col">30/12</th>
                                    <th scope="col" class="text-center col">30/12</th>
                                    <th scope="col" class="text-center col">30/12</th>
                                    <th scope="col" class="text-center col">30/12</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td scope="row" class="text-center table-stt">1</td>
                                    <td class=" table-name">Mark</td>
                                    <td class=" table-date">00/00/0000</td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="text-center table-stt">1</td>
                                    <td class=" table-name">Mark</td>
                                    <td class=" table-date">00/00/0000</td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="text-center table-stt">1</td>
                                    <td class=" table-name">Mark</td>
                                    <td class=" table-date">00/00/0000</td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="text-center table-stt">1</td>
                                    <td class=" table-name">Mark</td>
                                    <td class=" table-date">00/00/0000</td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="text-center table-stt">1</td>
                                    <td class=" table-name">Mark</td>
                                    <td class=" table-date">00/00/0000</td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="text-center table-stt">1</td>
                                    <td class=" table-name">Mark</td>
                                    <td class=" table-date">00/00/0000</td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="text-center table-stt">1</td>
                                    <td class=" table-name">Mark</td>
                                    <td class=" table-date">00/00/0000</td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="text-center table-stt">1</td>
                                    <td class=" table-name">Mark</td>
                                    <td class=" table-date">00/00/0000</td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="text-center table-stt">1</td>
                                    <td class=" table-name">Mark</td>
                                    <td class=" table-date">00/00/0000</td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="text-center table-stt">1</td>
                                    <td class=" table-name">Mark</td>
                                    <td class=" table-date">00/00/0000</td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="text-center table-stt">1</td>
                                    <td class=" table-name">Mark</td>
                                    <td class=" table-date">00/00/0000</td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" class="text-center table-stt">1</td>
                                    <td class=" table-name">Mark</td>
                                    <td class=" table-date">00/00/0000</td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="exampleCheck1">
                                        </div>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="box-footer">
                    <div class="btn btn-danger btn-reset">Tải lại</div>
                    <div class="btn btn-primary btn-save">Lưu</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="feedback/js/box.js"></script>
<!-- BoxJS -->
@endsection