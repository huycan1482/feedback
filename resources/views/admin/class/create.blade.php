@extends('admin.layouts.main')

@section('css')
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="backend/plugins/iCheck/all.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="backend/dist/css/AdminLTE.min.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="backend/plugins/timepicker/bootstrap-timepicker.min.css">
@endsection

@section('content')

<section class="content-header">
    <h1>
        Thêm - Lớp học
        <small><a href="{{ route('admin.class.index') }}">Danh sách</a></small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-5">
            <!-- general form elements -->

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin lớp học</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {{-- {{ dd(route('admin.category.store')) }} --}}
                <form enctype="multipart/form-data">
                    <div class="box-body">

                        <div class="form-group" id="form-name">
                            <label class="" >Tên lớp</label>
                            <div>
                                <input name="name" type="text" class="form-control " placeholder="Tên lớp">
                            </div>
                        </div>

                        <div class="form-group" id="form-code">
                            <label class="" >Mã lớp</label>
                            <div>
                                <input name="code" type="text" class="form-control " placeholder="Mã lớp">
                            </div>
                        </div>

                        <div class="form-group" id="form-course_id">
                            <label>Khóa học</label>
                            <div>
                                <select class=" select2 form-control" name="course" id="course_id">
                                    <option value="">-- Chọn --</option>
                                    @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }} / {{ $course->total_lesson }} buổi</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="form-teacher_id">
                            <label>Giảng viên</label>
                            <div>
                                <select class=" select2 form-control" name="teacher" id="teacher_id">
                                    <option value="">-- Chọn --</option>
                                    @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="form-total_number">
                            <label for="">Tổng số học viên</label>
                            <div>
                                <input name="total_number" type="number" class="form-control" placeholder="Tổng số học viên">
                            </div>
                        </div>

                        <div class="form-group" id="form-feedback_id">
                            <label for="">Bài đánh giá cuối khóa</label>

                            <div class="form-group">
                                <select class="form-control select2" multiple="multiple" data-placeholder="Chọn bài đánh giá" style="width: 100%;" name="feedback_id" id="feedback_id">
                                    <option value="">-- Chọn --</option>
                                    @foreach ($feedbacks as $feedback)
                                    <option value="{{ $feedback->id }}">{{ $feedback->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="checkbox form-group" id="form-is_active">
                            <label>
                                <input type="checkbox" name="is_active" value="1"> Kích hoạt
                            </label>
                        </div>

                    </div>
                    
                    <!-- /.box-body -->

                    <div class="box-footer" >
                        <div class="btn btn-primary add-class">Add</div>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
            

        </div>

        <div class="col-md-7">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin lịch học</h3>
                </div>

                <form enctype="multipart/form-data">
                    <div class="box-body">

                        <div class="" id="form-" style="overflow: auto">

                            <label for="">Ngày học / tuần</label> 
                            <table class="table-hover table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                <thead>
                                    <tr>
                                        <th class="text-center"><label for="2">Thứ 2 </label></th>
                                        <th class="text-center"><label for="3">Thứ 3</label></th>
                                        <th class="text-center"><label for="4">Thứ 4</label></th>
                                        <th class="text-center"><label for="5">Thứ 5</label></th>
                                        <th class="text-center"><label for="6">Thứ 6</label></th>
                                        <th class="text-center"><label for="7">Thứ 7</label></th>
                                        <th class="text-center"><label for="8">Chủ nhật</label></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="width: 100px"><input type="checkbox" class="flat-red" value="2" name="Thứ 2"><span style="margin-left: 5px">Học</span></td>
                                        <td style="width: 100px"><input type="checkbox" class="flat-red" value="3" name="Thứ 3"><span style="margin-left: 5px">Học</span></td>
                                        <td style="width: 100px"><input type="checkbox" class="flat-red" value="4" name="Thứ 4"><span style="margin-left: 5px">Học</span></td>
                                        <td style="width: 100px"><input type="checkbox" class="flat-red" value="5" name="Thứ 5"><span style="margin-left: 5px">Học</span></td>
                                        <td style="width: 100px"><input type="checkbox" class="flat-red" value="6" name="Thứ 6"><span style="margin-left: 5px">Học</span></td>
                                        <td style="width: 100px"><input type="checkbox" class="flat-red" value="7" name="Thứ 7"><span style="margin-left: 5px">Học</span></td>
                                        <td style="width: 100px"><input type="checkbox" class="flat-red" value="8" name="Chủ nhật"><span style="margin-left: 5px">Học</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="bootstrap-timepicker" style="padding-right: 0;">
                                                <div class="form-group">
                                                    <div class="input-group" style="width: 100%">
                                                        <input type="text" class="form-control timepicker" name="time_startAt_2">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="bootstrap-timepicker" style="padding-right: 0;">
                                                <div class="form-group">
                                                    <div class="input-group" style="width: 100%">
                                                        <input type="text" class="form-control timepicker" name="time_startAt_3">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="bootstrap-timepicker" style="padding-right: 0;">
                                                <div class="form-group">
                                                    <div class="input-group" style="width: 100%">
                                                        <input type="text" class="form-control timepicker" name="time_startAt_4">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="bootstrap-timepicker" style="padding-right: 0;">
                                                <div class="form-group">
                                                    <div class="input-group" style="width: 100%">
                                                        <input type="text" class="form-control timepicker" name="time_startAt_5">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="bootstrap-timepicker" style="padding-right: 0;">
                                                <div class="form-group">
                                                    <div class="input-group" style="width: 100%">
                                                        <input type="text" class="form-control timepicker" name="time_startAt_6">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="bootstrap-timepicker" style="padding-right: 0;">
                                                <div class="form-group">
                                                    <div class="input-group" style="width: 100%">
                                                        <input type="text" class="form-control timepicker" name="time_startAt_7">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="bootstrap-timepicker" style="padding-right: 0;">
                                                <div class="form-group">
                                                    <div class="input-group" style="width: 100%">
                                                        <input type="text" class="form-control timepicker" name="time_startAt_8">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group" id="form-lessons">
                            <label for="">Bắt đầu từ</label>
                            <div>
                                <div class="input-group date" style="width: 100%">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right datepicker" name="day_startAt" id="day_startAt" placeholder="DD-MM-YYYY">
                                </div>
                            </div> 
                        </div>
                        <div class="form-group" id="form-time_limit">
                            <label for="">Thời lượng (phút)</label>
                            <div>
                                <input name="time_limit" type="number" class="form-control" placeholder="Thời lượng">
                            </div>
                        </div>
                        {{-- <button type="button" class="btn btn-success btn-detail" data-toggle="modal" data-target="#modal-default" title="Chi tiết" data-id="">
                            Chi tiết các buổi học <i class="fas fa-cog"></i>
                        </button> --}}

                    </div>
                </form>
            </div>
            
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
<!-- iCheck 1.0.1 -->
<script src="backend/plugins/iCheck/icheck.min.js"></script>
<!-- bootstrap time picker -->
<script src="backend/plugins/timepicker/bootstrap-timepicker.min.js"></script>

<script src="backend/js/main.js"></script>

<script>
    $(function () {
        $('.select2').select2();

        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        });

        $('.datepicker').datepicker({
            // autoclose: false,
            format: 'dd-mm-yyyy',
            forceParse: false,
        });

        //Timepicker
        $('.timepicker').timepicker({
            showInputs: false,
        });


        $('.add-class').click(function (e) {
            var name = $("input[name='name']").val();
            var code = $("input[name='code']").val(); 
            var course_id = $('#course_id').val(); 
            var teacher_id = $('#teacher_id').val(); 
            var feedback_id = $('#feedback_id').val(); 
            var total_number = $("input[name='total_number']").val(); 
            var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;
            var time_limit = $("input[name='time_limit']").val(); 

            console.log(feedback_id);

            var date = $("input[name='day_startAt']").val().split('-');
            var dateStartAt = date[2] + '-' + date[1] + '-' + date[0];

            var lessons = [];

            $('input[type="checkbox"].flat-red').each(function (index, value) { 
                if ( $(this).is(':checked') ) {
                    // var date = $("'#day_startAt_"+ value.value +"'").val();
                    var test = $("input[name='time_startAt_"+ value.value +"']").val();

                    var time = test.split(' ')[0];
                    var dayOrNight = test.split(' ')[1];
                    var hour = time.split(':')[0];
                    var minute = time.split(':')[1];
                    // console.log(time3);
                    if (hour < 10) {
                        hour = '0' + hour;
                    }

                    if (dayOrNight == 'PM') {
                        hour = hour * 1 + 12;
                    }

                    var timeStartAt = hour + ':' + minute + ':00';

                    var date = $("input[name='day_startAt']").val().split('-');

                    var d = new Date(date[2] + '-'+ date[1] + '-'+ date[0]);

                    var day = value.value - (d.getDay() + 1);

                    if ( day < 0) {
                        d.setDate(d.getDate() + 7 + day);
                    } else {
                        d.setDate(d.getDate() + day);
                    }

                    var dMonth = (d.getMonth() + 1);

                    if ( d.getMonth() < 10 ) {
                        dMonth = '0' + dMonth;
                    }

                    var dDay = d.getDate();

                    if ( d.getDate() < 10 ) {
                        dDay = '0' + d.getDate();
                    }

                    var startDate = d.getFullYear() + '-' + dMonth + '-' + dDay + ' ' + timeStartAt;

                    lessons.push(
                        startDate
                    );
                }
            });

            var data = { 
                name : name,
                code: code,
                course_id : course_id,
                feedback_id : feedback_id,
                teacher_id : teacher_id,
                total_number : total_number,
                is_active : is_active,
                lessons : lessons,
                time_limit : time_limit,
            };

            var model = '/admin/class';

            addModel(model, data);

        }); 

        
    });

    

    
</script>


@endsection