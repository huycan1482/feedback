@extends('admin.layouts.main')

@section('css')
  <!-- Theme style -->
  <link rel="stylesheet" href="backend/dist/css/AdminLTE.min.css">
@endsection

@section('content')

<section class="content-header">
    <h1>
        Sửa - Giảng viên
        <small><a href="{{ route('admin.teacher.index') }}">Danh sách</a></small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <!-- left column -->
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
                            <label class="" for="">Tên giảng viên</label>
                            <div>
                                <input name="name" type="text" class="form-control " placeholder="Tên học viên" value="{{ $teacher->name }}">
                            </div>
                        </div>

                        <div class="form-group " id="form-code">
                            <label class="" for="">Số căn cước công dân</label>
                            <div>
                                <input name="code" type="text" class="form-control " placeholder="Căn cước công dân" value="{{ $teacher->code }}">
                            </div>
                        </div>

                        <div class="form-group" id="form-gender">
                            <label>Giới tính</label>
                            <div>
                                <select class="form-control" id="gender" name="gender">
                                    <option value="">-- Chọn --</option>
                                    <option value="1" {{ ($teacher->gender == 1) ? 'selected' : ''}}>Nam</option>
                                    <option value="2" {{ ($teacher->gender == 2) ? 'selected' : ''}}>Nữ</option>
                                    <option value="3" {{ ($teacher->gender == 3) ? 'selected' : ''}}>Khác</option>
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
                                    <input type="text" class="form-control pull-right datepicker" name="date-of-birth" placeholder="DD-MM-YYYY" value="{{date_format(date_create($teacher->date_of_birth), 'd-m-Y')}}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group " id="form-phone">
                            <label class="" for="">Số điện thoại</label>
                            <div>
                                <input name="phone" type="text" class="form-control " placeholder="Số điện thoại" value="{{ $teacher->phone }}">
                            </div>
                        </div>

                        <div class="form-group " id="form-address">
                            <label class="" for="">Địa chỉ</label>
                            <div>
                                <input name="address" type="text" class="form-control " placeholder="Địa chỉ" value="{{ $teacher->address}}">
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->

                </form>
            </div>

            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin Tài khoản</h3>
                </div>

                <form enctype="multipart/form-data">
                    <div class="box-body">
                        
                        <div class="form-group" id="form-email">
                            <label for="">Email</label>
                            <div>
                                <input name="email" type="email" class="form-control" placeholder="Email" value="{{ $teacher->email }}">
                            </div>
                        </div>

                        <div class="form-group" id="form-password">
                            <label for="">Mật khẩu mới**</label>
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

                <div class="box-footer">
                    <div class="btn btn-info update-user" data-id="{{ $teacher->id }}">Update</div>
                    <button type="reset" class="btn btn-danger">Reset</button>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (right) -->
    </div>
    <!-- /.row -->
</section>
@endsection

@section('my_script')
<!-- Select2 -->
<script src="backend/bower_components/select2/dist/js/select2.full.min.js"></script>

<script src="backend/js/main.js"></script>

<script>
    $(function () {

        $('.select2').select2();

        $('.datepicker').datepicker({
            // autoclose: false,
            format: 'dd-mm-yyyy',
            forceParse: false,
        })

        $('.update-user').click(function (e) {
            var name = $("input[name='name']").val();
            var email = $("input[name='email']").val(); 
            var password = $("input[name='password']").val(); 
            var password_confirmation = $("input[name='password_confirmation']").val(); 
            var address = $("input[name='address']").val();
            var gender = $('#gender').val();
            var phone = $("input[name='phone']").val(); 
            var code = $("input[name='code']").val(); 

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
            };

            var model = '/admin/teacher/' + $(this).attr('data-id');

            updateModel(model, data);

        }); 
    });
    
</script>


@endsection