@extends('feedback.layouts.main')

@section('css')
<!-- Box -->
<link rel="stylesheet" href="feedback/css/box.css">
<!-- Css -->
<link rel="stylesheet" href="feedback/css/profile.css">
@endsection

@section('content')
<div class="main-content">
    <div class="row">
        <div class="col-lg-4">
            <div class="box">
                <div class="box-header">

                </div>
                <div class="box-body">
                    <div class="card-images" style="height: 200px; background-color: red">
                        <img src="feedback/images/stars-Hd_4k_desktop_wallpaper_photos-544.jpg" alt="">
                    </div>
                    <div class="card-content">
                        <div class="card-avatar">
                            <img src="feedback/images/unnamed.png" alt="">
                        </div>
                        <div class="card-info">
                            <p>Huy</p>
                            <p>Vai trò: Học viên</p>
                            <p>SDT: 0936274859</p>
                            <p>Địa chỉ: Số 1 Hùng Vương</p>
                        </div>
                    </div>
                </div>
                <div class="box-footer">

                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="box">
                <div class="box-header">
                    <p class="box-title">Sửa thông tin</p>
                    <div class="btn">Thay đổi</div>
                </div>
                <div class="box-hr"></div>
                <div class="box-body">
                    <form action="">
                        <p class="info-title">Thông tin chung</p>
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label for="name" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" id="name" placeholder="Họ và tên">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label for="code" class="form-label">Chứng minh thư</label>
                                <input type="text" class="form-control" id="code"
                                    placeholder="Chứng minh thư">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label for="address" class="form-label">Giới tính</label>
                                <select class="form-control" name="" id="">
                                    <option value="">-- Chọn --</option>
                                    <option value="1">Nam</option>
                                    <option value="0">Nữ</option>
                                </select>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label for="date_of_birth" class="form-label">Ngày sinh</label>
                                <input type="date" class="form-control" id="date_of_birth" placeholder="Ngày sinh">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" id="phone" placeholder="Số điện thoại">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" id="address" placeholder="Địa chỉ">
                            </div>
                        </div>

                        <div class="short-hr"></div>
                        <p class="info-title">Thông tin Tài khoản</p>
                        <div class="row">
                            <div class="col-lg-4 form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="name" placeholder="Email">
                            </div>
                            <div class="col-lg-4 form-group">
                                <label for="password" class="form-label">Mật khẩu mới**</label>
                                <input type="password" class="form-control" id="password" placeholder="Mật khẩu mới">
                            </div>
                            <div class="col-lg-4 form-group">
                                <label for="password_confirmation" class="form-label">Nhập lại mật khẩu**</label>
                                <input type="password" class="form-control" id="password_confirmation" placeholder="Nhập lại mật khẩu">
                            </div>
                        </div>

                        <div class="short-hr"></div>
                        <p class="info-title">Thông tin Lớp học</p>
                        <table class="table table-striped table-inverse table-responsive">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>STT</th>
                                    <th>Tên lớp (Mã lớp)</th>
                                    <th>Bắt đầu</th>
                                    <th>Kết thúc</th>
                                    <th>Trạng thái</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td scope="row">1</td>
                                        <td>Lớp 1 (LH1)</td>
                                        <td>00/00/0000</td>
                                        <td>00/00/0000</td>
                                        <td><span class="label label-success">Đang học</span></td>
                                    </tr>
                                    <tr>
                                        <td scope="row">2</td>
                                        <td>Lớp 2 (LH2)</td>
                                        <td>00/00/0000</td>
                                        <td>00/00/0000</td>
                                        <td><span class="label label-warning">Đang học</span></td>
                                    </tr>
                                    <tr>
                                        <td scope="row">3</td>
                                        <td>Lớp 3 (LH3)</td>
                                        <td>00/00/0000</td>
                                        <td>00/00/0000</td>
                                        <td><span class="label label-danger">Đang học</span></td>
                                    </tr>
                                </tbody>
                        </table>
                    </form>
                </div>
                <div class="box-footer">

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