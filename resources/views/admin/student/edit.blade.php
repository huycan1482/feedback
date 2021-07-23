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
                                <input name="name" type="text" class="form-control " placeholder="Tên học viên" value="{{ $student->name }}">
                            </div>
                        </div>

                        <div class="form-group " id="form-code">
                            <label class="" for="">Số căn cước công dân</label>
                            <div>
                                <input name="code" type="text" class="form-control " placeholder="Căn cước công dân" value="{{ $student->code }}">
                            </div>
                        </div>

                        <div class="form-group" id="form-gender">
                            <label>Giới tính</label>
                            <div>
                                <select class="form-control" id="gender" name="gender">
                                    <option value="">-- Chọn --</option>
                                    <option value="1" {{ ($student->gender == 1) ? 'selected' : ''}}>Nam</option>
                                    <option value="2" {{ ($student->gender == 2) ? 'selected' : ''}}>Nữ</option>
                                    <option value="3" {{ ($student->gender == 3) ? 'selected' : ''}}>Khác</option>
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
                                    <input type="text" class="form-control pull-right datepicker" name="date-of-birth" placeholder="DD-MM-YYYY" value="{{date_format(date_create($student->date_of_birth), 'd-m-Y')}}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group " id="form-phone">
                            <label class="" for="">Số điện thoại</label>
                            <div>
                                <input name="phone" type="text" class="form-control " placeholder="Số điện thoại" value="{{ $student->phone }}">
                            </div>
                        </div>

                        <div class="form-group " id="form-address">
                            <label class="" for="">Địa chỉ</label>
                            <div>
                                <input name="address" type="text" class="form-control " placeholder="Địa chỉ" value="{{ $student->address}}">
                            </div>
                        </div>

                        <div class="checkbox form-group" id="form-is_active">
                            <label>
                                <input type="checkbox" name="is_active" value="1" {{ ($student->is_active == 1) ? 'checked' : '' }}> Kích hoạt
                            </label>
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
                                <input name="email" type="email" class="form-control" placeholder="Email" value="{{ $student->email }}">
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
                    <div class="btn btn-info update-user" data-id="{{ $student->id }}">Update</div>
                    <button type="reset" class="btn btn-danger">Reset</button>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (right) -->

        <div class="col-md-5">
            
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Thêm Lớp học</h3>
                </div>

                <form enctype="multipart/form-data">
                    <div class="box-body">
                        {{-- <div>Thêm khóa học mới</div> --}}
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

                    <div class="box-footer">
                        <div class="btn btn-info add-class" style="display: none" data-id="{{ $student->id }}">Add</div>
                    </div>
                </form>
            </div>

            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin các Lớp học</h3>
                </div>
                
                <div class="box-body">
                    <table class="table-hover table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Tên lớp</th>
                                <th class="text-center">Khóa học</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($student->classRooms as $key => $item)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-center">{{ $item->name }}</td>
                                <td class="text-center">{{ $item->course->code }}</td>
                                <td class="text-center">
                                    @if ( $item->is_active == 0 )
                                        <td><span class="label label-danger">Đã hủy</span></td>
                                    @elseif ( (strtotime($item->lessons->sortBy('start_at')->first()->start_at) < time()) ) 
                                        <td><span class="label label-success">Đang học</span></td>
                                    @elseif ( (strtotime($item->lessons->sortBy('start_at')->first()->start_at) > time()) ) 
                                        <td><span class="label label-warning">Chờ học</span></td>
                                    @else
                                        <td><span class="label label-danger">Hoàn thành</span></td>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.userClass.edit', ['id' => $item->pivot->id] ) }}" class="btn btn-success detail-class" title="Sửa" data-id="{{ $item->id }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
                        $('.add-class').show();

                        $('#classRoom_id').html(html);
                    }
                });
            }
        });

        $('.add-class').click(function (e) {
            var classRoom_id = $('#classRoom_id').val();
            var course_id = $('#course_id').val();
            var user_id = $(this).attr('data-id');

            var data = { 
                classRoom_id : classRoom_id,
                course_id : course_id,
                user_id: user_id,
            };

            $.ajax({
                type: "post",
                url: base_url + '/admin/userClass',
                data: data,
                dataType: "json",
                success: function (response) {
                    successResponse(response);
                    setTimeout(function (){
                        location.reload()
                    }, 1500);
                }, 
                error: function (e) {
                    errorResponse(e)
                }
            });
        });

        $('.update-user').click(function (e) {
            var name = $("input[name='name']").val();
            var email = $("input[name='email']").val(); 
            var password = $("input[name='password']").val(); 
            var password_confirmation = $("input[name='password_confirmation']").val(); 
            var address = $("input[name='address']").val();
            var gender = $('#gender').val();
            var phone = $("input[name='phone']").val(); 
            var code = $("input[name='code']").val(); 
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
                is_active : is_active,
            };

            var model = '/admin/student/' + $(this).attr('data-id');

            updateModel(model, data);

        }); 
    });
    
</script>


@endsection