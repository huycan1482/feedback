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
        Sửa - Lớp học
        <small><a href="{{ route('admin.class.index') }}">Danh sách</a></small>
    </h1>
</section>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Sửa thông tin buổi học</h4>
            </div>
            <div class="modal-body">
                <div class="box box-info">
                    <div class="box-header"></div>
                    <div class="box-body">
                        <div class="form-modal">
                            <div class="form-group" id="form-startDate">
                                <label for="">Ngày học</label>
                                <div>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right datepicker" name="end_at" placeholder="DD-MM-YYYY">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="form-startDate">
                                <label for="">Thời gian</label>
                                <div class="bootstrap-timepicker" style="padding-right: 0;">
                                    <div class="input-group" style="width: 100%">
                                        <input type="text" class="form-control timepicker" name="time">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info btn-update-lesson">Udate</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-default2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Thêm buổi học</h4>
            </div>
            <div class="modal-body">
                <div class="box box-info">
                    <div class="box-header"></div>
                    <div class="box-body">
                        <div class="form-modal">
                            <div class="form-group" id="form-addStartDate">
                                <label for="">Ngày học</label>
                                <div>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right datepicker" name="addEndAt" placeholder="DD-MM-YYYY">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="form-startDate">
                                <label for="">Thời gian</label>
                                <div class="bootstrap-timepicker" style="padding-right: 0;">
                                    <div class="input-group" style="width: 100%">
                                        <input type="text" class="form-control timepicker" name="addTime">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="form-addTimeLimit">
                                <label for="">Thời lượng (phút)</label>
                                <div>
                                    <input name="addTimeLimit" type="number" class="form-control" placeholder="Thời lượng">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info btn-add-lesson">Add</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

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
                                <input name="name" type="text" class="form-control " placeholder="Tên lớp" value="{{ $classRoom->name }}">
                            </div>
                        </div>

                        <div class="form-group" id="form-name">
                            <label class="" >Mã lớp</label>
                            <div>
                                <input name="code" type="text" class="form-control " placeholder="Mã lớp" value="{{ $classRoom->code }}">
                            </div>
                        </div>

                        <div class="form-group" id="form-course_id">
                            <label>Khóa học</label>
                            <div>
                                <select class=" select2 form-control" name="course" id="course_id">
                                    <option value="">-- Chọn --</option>
                                    @foreach ($courses as $course)
                                    <option value="{{ $course->id }}" {{ ($classRoom->course_id == $course->id) ? 'selected' : '' }}>{{ $course->name }} / {{ $course->total_lesson }} buổi</option>
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
                                    <option value="{{ $teacher->id }}" {{ ($classRoom->teacher_id == $teacher->id) ? 'selected' : '' }} >{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="form-total_number">
                            <label for="">Tổng số học viên</label>
                            <div>
                                <input name="total_number" type="number" class="form-control" placeholder="Tổng số học viên" value="{{ $classRoom->total_number }}">
                            </div>
                        </div>


                        <div class="form-group" id="form-feedback_id">
                            <label for="">Bài đánh giá cuối khóa</label>
                            <div class="form-group">
                                <select class="form-control select2" multiple="multiple" data-placeholder="Chọn bài đánh giá" style="width: 100%;" name="feedback_id" id="feedback_id">
                                    <option value="">-- Chọn --</option>
                                    @foreach ($feedbacks as $feedback)
                                    <option value="{{ $feedback->id }}" {{ $classRoom->feedback->contains("id", $feedback->id) ? 'selected' : '' }}>{{ $feedback->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="form-time_limit">
                            <label for="">Thời lượng các buổi học (phút)</label>
                            <div>
                                <input name="time_limit" type="number" class="form-control" placeholder="{{ $classRoom->lessons[0]->time_limit }}">
                            </div>
                        </div>
                        
                        <div class="checkbox form-group" id="form-is_active">
                            <label>
                                <input type="checkbox" name="is_active" value="1" {{ ($classRoom->is_active == 1) ? 'checked' : '' }}> Kích hoạt
                            </label>
                        </div>

                    </div>
                    
                    <!-- /.box-body -->

                    <div class="box-footer" >
                        <div class="btn btn-primary update-class" data-id="{{$classRoom->id}}">Update</div>
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

                        <div class="" id="form-" style="overflow: auto; max-height: 600px">
                            <label>Tổng số buổi thực tế: {{ count($classRoom->lessons) }} / </label>
                            <span class="label label-success add-lesson" style="cursor:pointer" data-toggle="modal" data-target="#modal-default2" data-id="{{$classRoom->id}}"> Thêm buổi học </span>
                            <table class="table-hover table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                <thead>
                                    <tr>
                                        <th class="text-center">STT</th>
                                        <th class="text-center">Thứ</th>
                                        <th class="text-center">Ngày học</th>
                                        <th class="text-center">Giờ học</th>
                                        <th class="text-center">Hành dộng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($classRoom->lessons as $key => $item)
                                    <tr class="item-{{ $item->id }}">
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td class="text-center">
                                            @switch( getdate(date_create($item->start_at)->getTimestamp())['weekday'] )
                                                @case('Monday')  Thứ hai @break
                                                @case('Tuesday') Thứ ba @break
                                                @case('Wednesday') Thứ tư @break
                                                @case('Thursday') Thứ năm @break
                                                @case('Friday') Thứ sáu @break
                                                @case('Saturday') Thứ bảy @break
                                                @case('Sunday') Chủ nhật @break
                                            @endswitch
                                        </td>
                                        <td class="text-center">
                                            {{ date_format(date_create($item->start_at), 'd-m-Y') }}
                                        </td>
                                        <td class="text-center">{{ date_format(date_create($item->start_at), 'H:i:s') }}</td>
                                        <td class="text-center">
                                            <div class="btn btn-success btn-edit-lesson" title="Sửa" data-toggle="modal" data-target="#modal-default" data-id="{{ $item->id }}">
                                                <i class="fa fa-edit"></i>
                                            </div>
        
                                            <div class="btn btn-danger" title="Xóa" >
                                                <i class="fa fa-trash"></i>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


                    </div>
                </form>
            </div>
            
        </div>
        <!--/.col (right) -->
    </div>
    <!-- /.row -->
</section>
@endsection

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

        $('.datepicker').datepicker({
            // autoclose: false,
            format: 'dd-mm-yyyy',
            forceParse: false,
        });

        //Timepicker
        $('.timepicker').timepicker({
            showInputs: false,
        });

        // $('.select2-search__field').attr('placeholder', 'Chọn bài đánh giá');

        $(document).on('click', '.btn-edit-lesson', function (e) {
            if ( $('#message') ) {
                $('#message').remove();
            }

            var itemId = $(this).attr('data-id');
            var date = $('.item-' + itemId + ' td:nth-of-type(3)').text().replace(/\s/g, '');
            var time = $('.item-' + itemId + ' td:nth-of-type(4)').text().replace(/\s/g, '');

            $("input[name='end_at']").val(date);
            $("input[name='time']").val(time);
            $('.btn-update-lesson').attr('data-id', itemId);
        });

        $(document).on('click', '.btn-update-lesson', function (e) {

            var test = $("input[name='time']").val();

            var time = test.split(' ')[0];
            var dayOrNight = test.split(' ')[1];
            var hour = time.split(':')[0];
            var minute = time.split(':')[1];
                    
            if (hour < 10) {
                hour = '0' + hour;
            }

            if (dayOrNight == 'PM') {
                hour = hour * 1 + 12;
            }

            var timeStartAt = hour + ':' + minute + ':00';

            var date = $("input[name='end_at']").val().split('-');

            var d = new Date(date[2] + '-'+ date[1] + '-'+ date[0]);

            var dDay = d.getDate();

            if ( d.getDate() < 10 ) {
                dDay = '0' + dDay;
            }

            var dMonth = (d.getMonth() + 1);

            if ( d.getMonth() < 10 ) {
                dMonth = '0' + dMonth;
            }

            var startDate = d.getFullYear() + '-' + dMonth + '-' + dDay + ' ' + timeStartAt;

            data = {
                startDate: startDate,
            }

            var model = '/admin/lesson/' + $(this).attr('data-id');

            $.ajax({
                type: 'PUT',
                url: base_url + model,
                data: data,
                dataType : "json",
                success: function (response) {
                    successResponseModal(response);
                    setTimeout(function (){
                        location.reload()
                    }, 1500);
                }, 
                error: function (e) {
                    errorResponseModal(e)
                }
            });


        });

        $(document).on('click', '.add-lesson', function (e) {
            if ( $('#message') ) {
                $('#message').remove();
            }

            var itemId = $(this).attr('data-id');

            $('.btn-add-lesson').attr('data-id', itemId);
        });

        $(document).on('click', '.btn-add-lesson', function (e) {
            var class_id = $(this).attr('data-id');
            var  addTimeLimit= $("input[name='addTimeLimit']").val();

            var test = $("input[name='addTime']").val();

            var time = test.split(' ')[0];
            var dayOrNight = test.split(' ')[1];
            var hour = time.split(':')[0];
            var minute = time.split(':')[1];
                    
            if (hour < 10) {
                hour = '0' + hour;
            }

            if (dayOrNight == 'PM') {
                hour = hour * 1 + 12;
            }

            var timeStartAt = hour + ':' + minute + ':00';

            var date = $("input[name='addEndAt']").val().split('-');

            var d = new Date(date[2] + '-'+ date[1] + '-'+ date[0]);

            var dDay = d.getDate();

            if ( d.getDate() < 10 ) {
                dDay = '0' + dDay;
            }

            var dMonth = (d.getMonth() + 1);

            if ( d.getMonth() < 10 ) {
                dMonth = '0' + dMonth;
            }

            var addStartDate = d.getFullYear() + '-' + dMonth + '-' + dDay + ' ' + timeStartAt;

            data = {
                class_id: class_id,
                addStartDate: addStartDate,
                addTimeLimit: addTimeLimit
            }

            var model = '/admin/lesson';

            $.ajax({
                type: "POST",
                url: base_url + model,
                data: data,
                dataType : "json",
                success: function (response) {
                    successResponseModal(response);
                    setTimeout(function (){
                        location.reload()
                    }, 1500);
                },
                error: function (e) {
                    errorResponseModal(e)
                }
            });

        });

        $(document).on('click', '.update-class', function (e) {
            var name = $("input[name='name']").val();
            var code = $("input[name='code']").val();
            var course_id = $('#course_id').val(); 
            var teacher_id = $('#teacher_id').val(); 
            var total_number = $("input[name='total_number']").val(); 
            var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;
            var time_limit = $("input[name='time_limit']").val(); 
            var feedback_id = $('#feedback_id').val(); 

        
            var data = { 
                name : name,
                code : code,
                course_id : course_id,
                teacher_id : teacher_id,
                total_number : total_number,
                is_active : is_active,
                time_limit : time_limit,
                feedback_id : feedback_id, 
            };

            var model = '/admin/class/' + $(this).attr('data-id');

            updateModel(model, data);

        }); 

        

        
    });

</script>


@endsection