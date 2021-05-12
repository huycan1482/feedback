@extends('admin.layouts.main')

@section('css')
  <!-- Theme style -->
  <link rel="stylesheet" href="backend/dist/css/AdminLTE.min.css">
@endsection

@section('content')

<section class="content-header">
    <h1>
        Thêm - Học viên
        <small><a href="{{ route('admin.student.index') }}">Danh sách</a></small>
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
                            <label class="" for="">Tên học viên</label>
                            <div>
                                <input name="name" type="text" class="form-control " placeholder="Tên học viên">
                            </div>
                        </div>

                        <div class="form-group " id="form-code">
                            <label class="" for="">Số căn cước công dân</label>
                            <div>
                                <input name="code" type="text" class="form-control " placeholder="Căn cước công dân">
                            </div>
                        </div>

                        <div class="form-group" id="form-gender">
                            <label>Giới tính</label>
                            <div>
                                <select class="form-control" id="gender" name="gender">
                                    <option value="">-- Chọn --</option>
                                    <option value="1">Nam</option>
                                    <option value="2">Nữ</option>
                                    <option value="3">Khác</option>
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
                                    <input type="text" class="form-control pull-right datepicker" name="date-of-birth" placeholder="DD-MM-YYYY">
                                </div>
                            </div>
                        </div>

                        <div class="form-group " id="form-phone">
                            <label class="" for="">Số điện thoại</label>
                            <div>
                                <input name="phone" type="text" class="form-control " placeholder="Số điện thoại">
                            </div>
                        </div>

                        <div class="form-group " id="form-address">
                            <label class="" for="">Địa chỉ</label>
                            <div>
                                <input name="address" type="text" class="form-control " placeholder="Địa chỉ">
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <div class="btn btn-info add-user">Add</div>
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
                                <input name="email" type="email" class="form-control" placeholder="Email">
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
                    <h3 class="box-title">Thông tin Lớp học</h3>
                </div>

                <form enctype="multipart/form-data">
                    <div class="box-body">
                        
                        <div class="form-group" id="form-course_id">
                            <label>Chọn khóa học</label>
                            <div>
                                <select class=" select2 form-control" name="course" id="course_id">
                                    <option value="">-- Chọn --</option>
                                    @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->code }} / {{ $course->total_lesson }} buổi</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="form-classRoom_id" style="display: none">
                            <label>Chọn lớp học</label>
                            <div>
                                <select class="form-control" id="classRoom_id" name="classRoom_id">
                                    <option value="">-- Chọn --</option>
                                    
                                </select>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            
        </div>
    </div>
    <!-- /.row -->
</section>
@endsection

{{-- @section('ck_editor')
<script>
    CKEDITOR.replace('content');
    // CKEDITOR.replace('description');
</script> 
@endsection --}}

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

        $(document).on('change', '#course_id', function(e) { 
            var itemId = $(this).val();
            if (itemId != '') {
                $.ajax({
                    type: "get",
                    url: base_url + '/admin/course/' + itemId,
                    data: {},
                    dataType: "json",
                    success: function (response) {

                        var html = '';

                        response.data.forEach(function (value, index) {

                            html += "<option value='"+ value.classId +"'>"+ value.class + "</option>";

                        });

                        $('#form-classRoom_id').show();

                        $('#classRoom_id').html(html);
                    }
                });
            }
        });

        $('.add-user').click(function (e) {
            var name = $("input[name='name']").val();
            var email = $("input[name='email']").val(); 
            var password = $("input[name='password']").val(); 
            var password_confirmation = $("input[name='password_confirmation']").val(); 
            var address = $("input[name='address']").val();
            var gender = $('#gender').val();
            var phone = $("input[name='phone']").val(); 
            var code = $("input[name='code']").val(); 
            var classRoom_id = $('#classRoom_id').val();
            var course_id = $('#course_id').val();

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
                classRoom_id : classRoom_id,
                course_id : course_id,
            };

            var model = '/admin/student';

            addModel(model, data);
        }); 

        
    });
    
</script>


@endsection