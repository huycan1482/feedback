@extends('admin.layouts.main')


@section('css')
  <!-- Theme style -->
  <link rel="stylesheet" href="backend/dist/css/AdminLTE.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="backend/plugins/timepicker/bootstrap-timepicker.min.css">
@endsection

@section('content')

<section class="content-header">
    <h1>
        Thêm - Khóa học
        <small><a href="{{ route('admin.course.index') }}">Danh sách</a></small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-8">
            <!-- general form elements -->

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin khóa học</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {{-- {{ dd(route('admin.category.store')) }} --}}
                <form enctype="multipart/form-data">
                    <div class="box-body">

                        <div class="form-group" id="form-name">
                            <label for="">Tên khóa học</label>
                            <input name="name" type="text" class="form-control" placeholder="Tên khóa">
                        </div>

                        <div class="form-group" id="form-code">
                            <label for="">Mã khóa học</label>
                            <input name="code" type="text" class="form-control" placeholder="Mã khóa học">
                        </div>

                        <div class="form-group" id="form-subject">
                            <label>Môn học</label>
                            <select class=" select2 form-control" style="width: 100%;" name="subject">
                                @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group" id="form-teacher">
                            <label>Giảng viên</label>
                            <select class=" select2 form-control" style="width: 100%;" name="teacher">
                                @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group" id="form-total_lesson">
                            <label for="">Tổng số buổi học</label>
                            <input name="total-lesson" type="number" class="form-control" placeholder="Tổng số buổi học">
                        </div>

                        <div class="form-group" id="form-total_number">
                            <label for="">Tổng số học viên</label>
                            <input name="total-number" type="number" class="form-control" placeholder="Tổng số buổi học">
                        </div>

                        <div class="form-group" id="form-start_at">
                            <label for="">Ngày bắt đầu</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right datepicker" name="day_startAt" placeholder="DD-MM-YYYY">
                            </div>
                        </div>

                        <div class="bootstrap-timepicker">
                            <div class="form-group">
                                <label>Thời gian bắt đầu</label>
            
                                <div class="input-group">
                                    <input type="text" class="form-control timepicker" name="time_startAt">
            
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id="form-time_limit">
                            <label for="">Thời lượng</label>
                            <input name="total-time_limit" type="number" class="form-control" placeholder="Thời lượng theo phút">
                        </div>

                        <div class="checkbox form-group" id="form-is_active">
                            <label>
                                <input type="checkbox" name="is_active" value="1"> Kích hoạt
                            </label>
                        </div>
                    </div>
                    
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <div class="btn btn-primary add-course">Add</div>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
            

        </div>
        <!--/.col (right) -->
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
<!-- bootstrap time picker -->
<script src="backend/plugins/timepicker/bootstrap-timepicker.min.js"></script>

<script src="backend/js/main.js"></script>
<script>
    $(function () {

        $('.select2').select2();

        $('.datepicker').datepicker({
            // autoclose: false,
            format: 'dd-mm-yyyy',
            forceParse: false,
        })

            //Timepicker
        $('.timepicker').timepicker({
            showInputs: false
        })

        $('.add-course').click(function (e) {
            var name = $("input[name='name']").val();
            var code = $("input[name='code']").val(); 
            var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;
            var data = { 
                name : name,
                code : code,
                is_active : is_active
            };

            var model = '/admin/course';

            addModel(model, data);

            // $.ajax({
            //     type: "post",
            //     url: base_url + '/admin/course',
            //     data: {
            //         'content' : content,
            //         'answers' : answers,
            //         'is_active' : is_active,
            //     },
            //     dataType: "json",
            //     success: function (response) {
            //         successResponse(response);
            //     }, 
            //     error: function (e) {
            //         errorResponse(e)
            //     }
            // });
        }); 

        
    });

    

    
</script>


@endsection