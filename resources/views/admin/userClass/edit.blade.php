@extends('admin.layouts.main')

@section('css')
  <!-- Theme style -->
  <link rel="stylesheet" href="backend/dist/css/AdminLTE.min.css">
@endsection

@section('content')

<section class="content-header">
    <h1>
        Sửa - Lịch học - Học viên {{ $userClass->user->name }}
        <small><a style="cursor: pointer" class="btn-history">Quay lại</a></small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-8">
            <!-- general form elements -->

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin lớp học</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" enctype="multipart/form-data">
                    <div class="box-body">

                        <div class="form-group" id="form-course_id">
                            <label>Thay đổi khóa học</label>
                            <div>
                                <select class=" select2 form-control" name="course" id="course_id">
                                    <option value="">-- Chọn --</option>
                                    @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->code }} / {{ $course->total_lesson }} buổi</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="form-classRoom_id">
                            <label>Lớp học</label>
                            <div>
                                <select class="form-control" id="classRoom_id" name="classRoom_id">
                                    <option value="">-- Chọn --</option>
                                    @foreach ( $classRooms as $key => $classRoom )
                                    <option value="{{ $classRoom->id }}" {{ ($classRoom->id == $userClass->class_id) ? 'selected' : '' }}>{{ $classRoom->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="form-is_active">
                            <label>Trạng thái</label>
                            <div>
                                <select class="form-control" id="is_active" name="is_active">
                                    <option value="1" {{ $userClass->is_active == 1 ? 'selected' : '' }}>
                                        {{ (strtotime($userClass->classRoom->lesson->first()->start_at) > time()) ? 'Đang học' : 'Chờ học' }}</option>
                                    <option value="0" {{ $userClass->is_active == 2 ? 'selected' : '' }}>Hủy</option>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                    
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="btn btn-primary btn-update-userClass" data-id="{{$userClass->id}}">Update</div>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
            

        </div>
    </div>
    <!-- /.row -->
</section>
@endsection

@section('my_script')
<!-- Select2 -->
<script src="backend/bower_components/select2/dist/js/select2.full.min.js"></script>

<script>
    $(function () {
        $('.select2').select2();

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
                        response.classRooms.forEach(function (value, index) {
                            html += "<option value='"+ value.id +"'>"+ value.name + "</option>";
                        });

                        $('#classRoom_id').html(html);
                    }
                });
            }
        });

        $('.btn-update-userClass').click( function () {
            var is_active = $('#is_active').val();
            var classRoom_id = $('#classRoom_id').val(); 
            var data = { 
                classRoom_id : classRoom_id,
                is_active : is_active
            };

            var model = '/admin/userClass/' + $(this).attr('data-id');

            // updateModel(model, data);

            $.ajax({
                type: 'PUT',
                url: base_url + model,
                data: data,
                dataType : "json",
                success: function (response) {
                    successResponse(response);
                    setTimeout(function (){
                        history.back();
                    }, 1500);
                }, 
                error: function (e) {
                    errorResponse(e)
                }
            });

        });

        $('.btn-history').click( function (e) {
            history.back();
        });


    });

    

    
</script>

@endsection