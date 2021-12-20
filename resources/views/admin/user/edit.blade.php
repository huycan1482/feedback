@extends('admin.layouts.main')

@section('content')

<section class="content-header">
    <h1>
        Sửa - Nhân viên
        <small><a href="{{ route('admin.user.index') }}">Danh sách</a></small>
    </h1>
</section>

<section class="content">
    <div class="row">

        <div class="col-md-7">
            <!-- general form elements -->

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin Chung</h3>
                    {{-- <a href="#" class="btn btn-danger">Thêm lớp học</a> --}}
                </div>
                <!-- /.box-header -->

                <form enctype="multipart/form-data">
                    <div class="box-body">

                        <div class="form-group " id="form-name">
                            <label class="" for="">Tên </label>
                            <div>
                                <input name="name" type="text" class="form-control " placeholder="Tên học viên" value="{{ $user->name }}">
                            </div>
                        </div>

                        <div class="form-group " id="form-identity">
                            <label class="" for="">Mã người dùng </label>
                            <div>
                                <input name="identity" type="text" class="form-control " placeholder="Mã người dùng" value="{{ $user->identity_code }}" disabled>
                            </div>
                        </div>

                        <div class="form-group " id="form-code">
                            <label class="" for="">Số căn cước công dân</label>
                            <div>
                                <input name="code" type="text" class="form-control " placeholder="Căn cước công dân" value="{{ $user->code }}">
                            </div>
                        </div>

                        <div class="form-group" id="form-gender">
                            <label>Giới tính</label>
                            <div>
                                <select class="form-control" id="gender" name="gender">
                                    <option value="">-- Chọn --</option>
                                    <option value="1" {{ ($user->gender == 1) ? 'selected' : ''}}>Nam</option>
                                    <option value="2" {{ ($user->gender == 2) ? 'selected' : ''}}>Nữ</option>
                                    <option value="3" {{ ($user->gender == 3) ? 'selected' : ''}}>Khác</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group " id="form-date_of_birth">
                            <label for="">Ngày sinh</label>
                            <div>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right datepicker" name="date-of-birth" placeholder="DD-MM-YYYY" value="{{date_format(date_create($user->date_of_birth), 'd-m-Y')}}"> 
                                </div>
                            </div>
                        </div>

                        <div class="form-group " id="form-phone">
                            <label class="" for="">Số điện thoại</label>
                            <div>
                                <input name="phone" type="text" class="form-control " placeholder="Số điện thoại" value="{{ $user->phone }}">
                            </div>
                        </div>

                        <div class="form-group " id="form-address">
                            <label class="" for="">Địa chỉ</label>
                            <div>
                                <input name="address" type="text" class="form-control " placeholder="Địa chỉ" value="{{ $user->address }}">
                            </div>
                        </div>

                        <div class="checkbox form-group" id="form-is_active">
                            <label>
                                <input type="checkbox" name="is_active" value="1" {{ ($user->is_active == 1) ? 'checked' : '' }}> Kích hoạt
                            </label>
                        </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <div class="btn btn-info btn-update-user" data-id="{{ $user->id }}">Update</div>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (right) -->

        <div class="col-md-5">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin Tài khoản</h3>
                </div>

                <form enctype="multipart/form-data">
                    <div class="box-body">
                        
                        <div class="form-group" id="form-email">
                            <label for="">Email</label>
                            <div>
                                <input name="email" type="email" class="form-control" placeholder="Email" value="{{ $user->email }}">
                            </div>
                        </div>

                        <div class="form-group" id="form-password">
                            <label for="">Mật khẩu**</label>
                            <div>
                                <input name="password" type="password" class="form-control" placeholder="Mật khẩu">
                            </div>
                        </div>

                        <div class="form-group" id="form-password_confirmation">
                            <label for="">Nhập lại mật khẩu**</label>
                            <div>
                                <input name="password_confirmation" type="password" class="form-control" placeholder="Nhập lại mật khẩu">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin Chức năng</h3>
                </div>

                <form enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group" id="form-role">
                            <label>Chức năng</label>
                            <div>
                                <select class=" select2 form-control" style="width: 100%;" name="role" id="role">
                                    <option value="">-- Chọn --</option>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ ($user->role_id == $role->id) ? ' selected' : ''}}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
        </div>
        <!-- left column -->
    </div>
    <!-- /.row -->
</section>
@endsection

@section('my_script')
<!-- Select2 -->
<script src="backend/bower_components/select2/dist/js/select2.full.min.js"></script>

<script>
    $(function () {
        $('.btn-update-user').click( function () {
            var name = $("input[name='name']").val();
            var email = $("input[name='email']").val(); 
            var password = $("input[name='password']").val(); 
            var password_confirmation = $("input[name='password_confirmation']").val(); 
            var address = $("input[name='address']").val();
            var gender = $('#gender').val();
            var phone = $("input[name='phone']").val(); 
            var code = $("input[name='code']").val(); 
            var role = $("#role").val();
            var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;

            if ($("input[name='date-of-birth']").val() != '') { 
                var date = $("input[name='date-of-birth']").val().split('-');
                var date_of_birth = date[2] + '-' + date[1] + '-' + date[0];
            }

            var data = { 
                name : name,
                email : email,
                password : password,
                password_confirmation : password_confirmation,
                address : address,
                gender : gender,
                phone : phone,
                code : code,
                date_of_birth : date_of_birth,
                role_id : role,
                is_active : is_active,
            };

            var model = '/admin/user/' + $(this).attr('data-id');

            updateModel(model, data);
        });


    });

    

    
</script>

@endsection