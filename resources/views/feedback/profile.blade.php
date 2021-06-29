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
                            <p>{{ $user->name }}</p>
                            <p>Vai trò: {{ $user->role->name }}</p>
                            <p>SDT: {{ $user->phone }}</p>
                            <p>Địa chỉ: {{ $user->address }}</p>
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
                    <div class="btn edit-user" data-id="{{ $user->id }}">Thay đổi</div>
                </div>
                <div class="box-hr"></div>
                <div class="box-body">
                    <form action="">
                        <p class="info-title">Thông tin chung</p>
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label for="name" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" id="name" placeholder="Họ và tên" value="{{ $user->name }}">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label for="code" class="form-label">Chứng minh thư</label>
                                <input type="text" class="form-control" id="code" placeholder="Chứng minh thư" value="{{ $user->code }}">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label for="address" class="form-label">Giới tính</label>
                                <select class="form-select" name="" id="gender" >
                                    <option value="">-- Chọn --</option>
                                    <option value="1" {{ ($user->gender == 1) ? ' selected="selected"' : '' }}>Nam</option>
                                    <option value="0" {{ ($user->gender == 0) ? ' selected="selected"' : '' }}>Nữ</option>
                                </select>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label for="date_of_birth" class="form-label">Ngày sinh</label>
                                <input type="date" class="form-control" id="date_of_birth" placeholder="Ngày sinh" value="{{ date_format(date_create($user->date_of_birth), 'Y-m-d') }}">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" id="phone" placeholder="Số điện thoại" value="{{ $user->phone }}">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" id="address" placeholder="Địa chỉ" value="{{ $user->address }}">
                            </div>
                        </div>

                        <div class="short-hr"></div>
                        <p class="info-title">Thông tin Tài khoản</p>
                        <div class="row">
                            <div class="col-lg-4 form-group form-error">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Email" value={{ $user->email }}>
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
                                    {{-- {{dd($user->classes->first())}} --}}
                                    @if ((!empty($user->classes->first())))
                                        @foreach( $user->classes as $key => $item )
                                        <tr>
                                            <td scope="row">{{ $key + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ ( ($item->lessons->sortBy('start_at')->first()->start_at) )}}</td>
                                            <td>{{ ( ($item->lessons->SortByDesc('start_at')->first()->start_at) )}}</td>
                                        
                                            @if ( $item->is_active == 0 )
                                                <td><span class="label label-danger">Đã hủy</span></td>
                                            @elseif ( (strtotime($item->lessons->sortBy('start_at')->first()->start_at) < time()) ) 
                                                <td><span class="label label-success">Đang dạy</span></td>
                                            @elseif ( (strtotime($item->lessons->sortBy('start_at')->first()->start_at) > time()) ) 
                                                <td><span class="label label-warning">Chờ dạy</span></td>
                                            @else
                                                <td><span class="label label-danger">Hoàn thành</span></td>
                                            @endif
                                        
                                        </tr>
                                        @endforeach
                                    @else  
                                        @foreach( $user->classRooms as $key => $item )
                                        <tr>
                                            <td scope="row">{{ $key + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ ( ($item->lessons->sortBy('start_at')->first()->start_at) )}}</td>
                                            <td>{{ ( ($item->lessons->SortByDesc('start_at')->first()->start_at) )}}</td>
                                        
                                            @if ( $item->is_active == 0 )
                                                <td><span class="label label-danger">Đã hủy</span></td>
                                            @elseif ( (strtotime($item->lessons->sortBy('start_at')->first()->start_at) < time()) ) 
                                                <td><span class="label label-success">Đang học</span></td>
                                            @elseif ( (strtotime($item->lessons->sortBy('start_at')->first()->start_at) > time()) ) 
                                                <td><span class="label label-warning">Chờ học</span></td>
                                            @else
                                                <td><span class="label label-danger">Hoàn thành</span></td>
                                            @endif
                                        
                                        </tr>
                                        @endforeach
                                    @endif
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

<script src="feedback/js/form.js"></script>

<script>
    $(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.edit-user').click(function (e) {
        var id = $(this).attr('data-id');
        var name = $('#name').val();
        var code  = $('#code').val();
        var gender = $('#gender').val();
        var date_of_birth = $('#date_of_birth').val();

        console.log(date_of_birth);
        var phone = $('#phone').val(); 
        var address = $('#address').val();
        
        var email = $('#email').val(); 
        var password = $('#password').val(); 
        var password_confirmation = $('#password_confirmation').val(); 
        
        var data = { 
            // id : id,
            name : name,
            email : email,
            password : password,
            password_confirmation : password_confirmation,
            address : address,
            gender : gender,
            phone : phone,
            code : code,
            date_of_birth : date_of_birth,

        };

        var model = '/updateProfile/' + id + '/edit';

        $.ajax({
            type: 'PUT',
            url: base_url + model,
            data: data,
            dataType : "json",

            success: function (response) {
                successResponse(response);
            }, 
            error: function (e) {
                errorResponse(e);
            }
        });
        // addModel(model, data);
    }); 


    });
</script>
@endsection