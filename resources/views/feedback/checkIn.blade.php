@extends('feedback.layouts.main')

@section('css')
<!-- FullCalendar -->
<link rel='stylesheet' href='feedback/fullcalendar-3.9.0/fullcalendar.css' />
<!-- Box -->
<link rel="stylesheet" href="feedback/css/box.css">
<!-- Css Layout -->
<link rel="stylesheet" href="feedback/css/checkIn.css">
<!-- Calendar -->
<link rel="stylesheet" href="feedback/css/calendar.css">
@endsection

@section('content')
<div class="main-content">
    <div class="row">
        <div class="col-lg-12">
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
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    <p class="box-title">Điểm danh Học viên</p>
                    <div class="row">
                        <div class="col-lg-4">
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
                        </div>
                        <div class="col-lg-4">
                            <div class="box-info">
                                <i class="fas fa-bell"></i>
                                <span>Trạng thái: </span>
                                <span>Đang học</span>
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
                        <div class="col-lg-4">
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
                            <div class="box-info">
                                <i class="fas fa-hourglass-end"></i>
                                <span>Số buổi còn lại: </span>
                                <span>20</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-hr"></div>
                <div class="box-body">
                    <div class="form-table">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center col">STT</th>
                                    <th scope="col" class="text-center col">Họ và tên</th>
                                    <th scope="col" class="text-center col">Ngày sinh</th>
                                    <th scope="col" class="text-center col">1/2</th>
                                    <th scope="col" class="text-center col">00/00</th>
                                    <th scope="col" class="text-center col">00/00</th>
                                    <th scope="col" class="text-center col">00/00</th>
                                    <th scope="col" class="text-center col">00/00</th>
                                    <th scope="col" class="text-center col">00/00</th>
                                    <th scope="col" class="text-center col">00/00</th>
                                    <th scope="col" class="text-center col">00/00</th>
                                    <th scope="col" class="text-center col">00/00</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td scope="row" class="text-center table-stt">1</td>
                                    <td class="text-center table-name">
                                        <p>Mark</p>   
                                        <span class="label label-info">00</span>
                                        <span class="label label-warning">00</span>
                                        <span class="label label-danger">00</span>
                                    </td>
                                    <td class=" table-date text-center">00/00/0000</td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_1_1" value="1" checked disabled>
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_1_1" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_1_1" value="3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_1_2" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_1_2" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_1_2" value="3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_1_3" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_1_3" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_1_3" value="3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_1_1" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_1_1" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_1_1" value="3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_1_2" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_1_2" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_1_2" value="3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_1_3" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_1_3" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_1_3" value="3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_1_1" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_1_1" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_1_1" value="3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_1_2" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_1_2" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_1_2" value="3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_1_3" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_1_3" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_1_3" value="3">
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td scope="row" class="text-center table-stt">1</td>
                                    <td class=" table-name">Mark</td>
                                    <td class=" table-date text-center">00/00/0000</td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_2_1" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_2_1" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_2_1" value="3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_2_2" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_2_2" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_2_2" value="3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_2_3" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_2_3" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_2_3" value="3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_2_1" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_2_1" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_2_1" value="3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_2_2" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_2_2" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_2_2" value="3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_2_3" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_2_3" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_2_3" value="3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_2_1" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_2_1" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_2_1" value="3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_2_2" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_2_2" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_2_2" value="3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_2_3" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_2_3" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_2_3" value="3">
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td scope="row" class="text-center table-stt">1</td>
                                    <td class=" table-name">Mark</td>
                                    <td class=" table-date text-center">00/00/0000</td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_3_1" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_3_1" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_3_1" value="3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_3_2" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_3_2" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_3_2" value="3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_3_3" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_3_3" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_3_3" value="3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_3_1" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_3_1" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_3_1" value="3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_3_2" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_3_2" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_3_2" value="3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_3_3" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_3_3" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_3_3" value="3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_3_1" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_3_1" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_3_1" value="3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_3_2" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_3_2" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_3_2" value="3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input input-info" id=""
                                                name="check_3_3" value="1">
                                            <input type="radio" class="form-check-input input-warning" id=""
                                                name="check_3_3" value="2">
                                            <input type="radio" class="form-check-input input-danger" id=""
                                                name="check_3_3" value="3">
                                        </div>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="form-notice">
                        <div class="row">
                            <div class="col-lg-4">
                                <p>Thông tin buổi học</p>
                                <table>
                                    <tr>
                                        <td>Điểm danh:</td>
                                        <td><span class="label label-danger">Chưa hoàn thành</span></td>
                                    </tr>
                                    <tr>
                                        <td>Có mặt:</td>
                                        <td><span class="label label-success">0/00</span></td>
                                    </tr>
                                    <tr>
                                        <td>Muộn:</td>
                                        <td><span class="label label-warning">0/00</span></td>
                                    </tr>
                                    <tr>
                                        <td>Vắng mặt:</td>
                                        <td><span class="label label-danger">0/00</span></td>
                                    </tr>
                                </table>
                            </div>
                            <form action="" class="col-lg-8">
                                <div class=" form-group">
                                    <label for="phone" class="form-label">Ghi chú hôm nay</label>
                                    <textarea name="" id="" cols="30" rows="10"
                                        class="form-control"></textarea>
                                </div>
                            </form>

                        </div>

                    </div>

                    <div class="form-footer">
                        <div class="">
                            <div class="form-check">
                                <p>Chú thích: </p>
                                <div>
                                    <input type="radio" class="form-check-input input-info" id="" name=""
                                        value="" checked> Có mặt
                                </div>
                                <div>
                                    <input type="radio" class="form-check-input input-warning" id="" name=""
                                        value="" checked> Muộn
                                </div>
                                <div>
                                    <input type="radio" class="form-check-input input-danger" id="" name=""
                                        value="" checked> Vắng mặt
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="btn btn-danger btn-reset">Tải lại</div>
                            <div class="btn btn-primary btn-save">Lưu</div>
                        </div>
                    </div>

                </div>

                <div class="box-footer">
                    <!-- <div class="calendar">
                        <div class="calendar-header">
                            <i class="fas fa-calendar-alt"></i>
                            <p>Lịch làm việc</p>
                        </div>
                        <div class="calendar-body">
                            <div class="calendar-title">
                                <div class="calendar-left">
                                    <div>
                                        <div class="calendar-prev-btn my-btn">
                                            <i class="fas fa-chevron-left"></i>
                                        </div>
                                        <div class="calendar-next-btn my-btn">
                                            <i class="fas fa-chevron-right"></i>
                                        </div>
                                    </div>
                                    <div class="calendar-today my-btn">
                                        Hôm nay
                                    </div>
                                </div>
                                <div class="calendar-center">
                                    <p>
                                        Tháng 6, Năm 2021
                                    </p>
                                </div>
                                <div class="calendar-right">
                                    <div class="calendar-month my-btn">
                                        Tháng
                                    </div>
                                    <div class="calendar-year my-btn">
                                        Năm
                                    </div>
                                </div>
                            </div>
                            <div class="calendar-main">
                                <table>
                                    <thead>
                                        <th>Thứ 2</th>
                                        <th>Thứ 3</th>
                                        <th>Thứ 4</th>
                                        <th>Thứ 5</th>
                                        <th>Thứ 6</th>
                                        <th>Thứ 7</th>
                                        <th>Chủ nhật</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>
                                            <td>
                                                <p class="calendar-table-date">1</p>
                                                <p class="calendar-table-notice label label-danger">
                                                    Lorem ipsum dolor sit amet askdjasdh akjsdhushn
                                                </p>
                                            </td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div> -->

                    <div id="calendar" style="padding: 20px">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src='feedback/fullcalendar-3.9.0/lib/jquery.min.js'></script>
<script src='feedback/fullcalendar-3.9.0/lib/moment.min.js'></script>
<script src='feedback/fullcalendar-3.9.0/fullcalendar.js'></script>
{{-- FullCalendar --}}
<script src="feedback/js/box.js"></script>
<!-- BoxJS -->
<script src="feedback/js/calendar.js"></script>

<script>
    $(function () {

        // page is now ready, initialize the calendar...

        $('#calendar').fullCalendar({
            // put your options and callbacks here
            events: [{
                    title: 'event1',
                    start: '2021-06-06'
                },
                {
                    title: 'event2',
                    start: '2021-06-06',
                    end: '2021-06-08'
                },
                {
                    title: 'event3',
                    start: '2010-01-09T12:30:00',
                    allDay: false // will make the time show
                }
            ]
        })

    });
</script>

@endsection