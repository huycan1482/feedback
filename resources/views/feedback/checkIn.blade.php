@extends('feedback.layouts.main')

@section('css')
<!-- FullCalendar -->
<link rel='stylesheet' href='feedback/fullcalendar-3.9.0/fullcalendar.css' />
<!-- TimePicker -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css"
    rel="stylesheet">
<!-- Box -->
<link rel="stylesheet" href="feedback/css/box.css">
<!-- Css Layout -->
<link rel="stylesheet" href="feedback/css/checkIn.css">
{{-- <!-- Calendar -->
<link rel="stylesheet" href="feedback/css/calendar.css"> --}}

@endsection

@section('content')
<div class="main-content">
    <div class="row">
        {{-- {{dd(isset($classes))}} --}}
        @if (!isset($classes))
        <h1>Không có lớp</h1>
        @else
        <div class="col-lg-12">
            <div class="box">
                <div class="drop-box-header">
                    <p>Chọn lớp học</p>
                    <i class="fas fa-minus"></i>
                </div>
                <div class="box-body">
                    @foreach($classes as $class_item)
                    <a class="class-item" href="{{ route('feedback.getCheckInId', ['id' => $class_item->id]) }}">
                        <div>
                            <i class="fas fa-chalkboard"></i>
                            <span>{{ $class_item->name }} ({{ $class_item->code }})</span>
                        </div>
                        <i class="fas fa-check"></i>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    <p class="box-title">Điểm danh Học viên</p>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="box-info">
                                <i class="fas fa-book-open"></i>
                                <span>Lớp học: </span>
                                <span>{{ $class->name }}/{{ $class->code }}</span>
                            </div>
                            <div class="box-info">
                                <i class="fas fa-bookmark"></i>
                                <span>Khóa học: </span>
                                <span>{{ $class->course }}/{{ $class->course_code }}</span>
                            </div>
                            <div class="box-info">
                                <i class="fas fa-book"></i>
                                <span>Môn học: </span>
                                <span>{{ $class->subject }}/{{ $class->subject_code }}</span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="box-info">
                                <i class="fas fa-bell"></i>
                                <span>Trạng thái: </span>
                                <span>{{ (strtotime($class->start_at) > strtotime(date("Y-m-d"))) ? 'Chờ học' : 'Đang học' }}</span>
                            </div>
                            <div class="box-info">
                                <i class="fas fa-concierge-bell"></i>
                                <span>Tống số buổi: </span>
                                <span>{{ $class->total_number }}</span>
                            </div>
                            <div class="box-info">
                                <i class="fas fa-hourglass-end"></i>
                                <span>Số buổi còn lại: </span>
                                <span>{{ $class->number }}</span>
                            </div>
                            {{-- <div class="box-info">
                                <i class="fas fa-users"></i>
                                <span>Tổng số học viên: </span>
                                <span>??</span>
                            </div> --}}
                        </div>
                        <div class="col-lg-4">
                            <div class="box-info">
                                <i class="fas fa-hourglass-start"></i>
                                <span>Ngày bắt đầu: </span>
                                <span>{{ date_format(date_create($class->start_at), 'd-m-Y') }}</span>
                            </div>
                            <div class="box-info">
                                <i class="fas fa-hourglass-end"></i>
                                <span>Ngày kết thúc: </span>
                                <span>{{ date_format(date_create($class->end_at), 'd-m-Y') }}</span>
                            </div>
                            <div>
                                <div class="form-check form-check-note">
                                    <p>Chú thích: </p>
                                    <div>
                                        <input type="radio" class="form-check-input input-info" id="" name="" value=""
                                            checked> Có mặt
                                    </div>
                                    <div>
                                        <input type="radio" class="form-check-input input-warning" id="" name=""
                                            value="" checked> Muộn
                                    </div>
                                    <div>
                                        <input type="radio" class="form-check-input input-danger" id="" name="" value=""
                                            checked> Vắng mặt
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-hr"></div>
                <div class="box-body">
                    <div class="form-table">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center col sticky-col first-col">STT</th>
                                    <th scope="col" class="text-center col sticky-col second-col">Họ và tên</th>
                                    <th scope="col" class="text-center col sticky-col third-col">Ngày sinh</th>
                                    @if (!empty($lessons->first()))
                                    @foreach($lessons as $key => $lesson)
                                    <th scope="col" class="text-center col {{ ( date_format(date_create($lesson->start_at), 'd-m-Y') != date("d-m-Y") ) ? 'hidden_checkIn' : '' }}">
                                        {{date_format(date_create($lesson->start_at), 'd-m-Y')}}</th>
                                    @endforeach
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($students as $key => $student)
                                <tr>
                                    <td scope="row" class="text-center table-stt sticky-col first-col">{{ $key + 1 }}</td>
                                    <td class="text-center table-name sticky-col second-col">
                                        <p>{{ $student->name }}</p>

                                        @foreach($user_checkIn[$student->id] as $item)
                                        {{-- {{dd($user_checkIn)}} --}}
                                        <span class="label label-info">{{$item->di_hoc}}</span>
                                        <span class="label label-warning">{{$item->di_muon}}</span>
                                        <span class="label label-danger">{{$item->vang_mat}}</span>
                                        @endforeach

                                    </td>
                                    <td class=" table-date text-center sticky-col third-col">
                                        {{ date_format(date_create($student->date_of_birth), 'd-m-Y') }}</td>

                                    @if ($checkIn[$student->id] != null)
                                    @foreach($checkIn[$student->id] as $key => $item)
                                    {{-- {{dd($checkIn)}} --}}
                                    <td class="text-center">
                                        <div class="form-check">
                                            {{-- {{dd($item->is_check)}} --}}
                                            @if($item->is_check == null)
                                            <input type="radio" class="form-check-input input-info"
                                                name="{{$student->id}}_{{date_format(date_create($item->start_at), 'd-m-Y')}}"
                                                id="{{$student->id}}_1" value="1" data-id="{{ $student->id }}">
                                            <input type="radio" class="form-check-input input-warning"
                                                name="{{$student->id}}_{{date_format(date_create($item->start_at), 'd-m-Y')}}"
                                                id="{{$student->id}}_2" value="2" data-id="{{ $student->id }}">
                                            <input type="radio" class="form-check-input input-danger"
                                                name="{{$student->id}}_{{date_format(date_create($item->start_at), 'd-m-Y')}}"
                                                id="{{$student->id}}_3" value="3" data-id="{{ $student->id }}">
                                            @elseif($item->is_check == 1)
                                            <input type="radio" class="form-check-input input-info hidden_checkIn"
                                                name="{{$student->id}}_{{date_format(date_create($item->start_at), 'd-m-Y')}}"
                                                checked>
                                            @elseif($item->is_check == 2)
                                            <input type="radio" class="form-check-input input-warning hidden_checkIn"
                                                name="{{$student->id}}_{{date_format(date_create($item->start_at), 'd-m-Y')}}"
                                                checked>
                                            @else
                                            <input type="radio" class="form-check-input input-danger hidden_checkIn"
                                                name="{{$student->id}}_{{date_format(date_create($item->start_at), 'd-m-Y')}}"
                                                checked>
                                            @endif
                                        </div>
                                    </td>
                                    @endforeach
                                    @endif

                                    @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="container ">
                        <div class="row choose-time">
                            <div class="col-lg-4">
                                <p class="btn btn-primary" data-item="8:00 AM">Ca Sáng: 8h - 11h</p>   
                            </div>
                            <div class="col-lg-4">
                                <p class="btn btn-primary" data-item="2:00 PM">Ca Chiều: 14h - 17h</p>
                            </div>
                            <div class="col-lg-4">
                                <p class="btn btn-primary" data-item="6:00 PM">Ca Tối: 18h - 21h</p>
                            </div>
                        </div>
                        <div class="row pick-time">

                            <div class='col-lg-2'>
                                <div class="form-group">
                                    <label for="">Thời gian bắt đầu</label>
                                    <div class='input-group date datetimepicker3' id=''>
                                        <input type='text' class="form-control" value="{{date_format(date_create($lessons->first()->start_at), 'H:m')}}" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-notice">
                        <div class="row">
                            <div class="col-lg-4">
                                <p>Thông tin buổi học</p>
                                <table>
                                    <tr>
                                        <td>Điểm danh:</td>
                                        {{-- {{ dd( $present ) }} --}}
                                        @if (date_format(date_create(array_values($checkIn)[0][0]->start_at), 'd-m-Y') == date("d-m-Y"))
                                            @if($present->total != 0 && $late->total != 0 && $not_present->total != 0)
                                            <td><span class="label label-success">Hoàn thành</span></td>
                                            @else
                                            <td><span class="label label-danger">Chưa hoàn thành</span></td>
                                            @endif
                                        @else
                                        <td><span class="label label-danger">Chưa đến ngày học</span></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Có mặt:</td>
                                        <td><span
                                                class="label label-success">{{ $present->total }}/{{ $total_student->total }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Muộn:</td>
                                        <td><span
                                                class="label label-warning">{{ $late->total }}/{{ $total_student->total }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Vắng mặt:</td>
                                        <td><span
                                                class="label label-danger">{{ $not_present->total }}/{{ $total_student->total }}</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <form action="" class="col-lg-8">
                                <div class=" form-group">
                                    <label for="phone" class="form-label">Ghi chú hôm nay</label>
                                    <textarea name="" id="note" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                            </form>

                        </div>

                    </div>

                    <div class="form-footer">
                        <div class="">

                        </div>
                        <div>
                            <div class="btn btn-danger btn-reset">Tải lại</div>
                            <div class="btn btn-primary btn-save"
                                data-id="{{ (empty($lessons->first())) ? 0 : $lessons->first()->id}}">Lưu</div>
                        </div>
                    </div>

                </div>

                <div class="box-footer">

                    <div id="calendar" style="padding: 20px">

                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection

@section('js')
<script src='feedback/fullcalendar-3.9.0/lib/jquery.min.js'></script>
<script src='feedback/fullcalendar-3.9.0/lib/moment.min.js'></script>
<script src='feedback/fullcalendar-3.9.0/fullcalendar.js'></script>
{{-- FullCalendar --}}
<script src="feedback/js/box.js"></script>
<!-- BoxJS -->
{{-- <script src="feedback/js/calendar.js"></script> --}}

<!-- TimePicker -->
<script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
</script>


<script type="text/javascript">
    $(function () {
        $('.datetimepicker3').datetimepicker({
            format: 'LT'
        });
        

        $('#calendar').fullCalendar({
            // put your options and callbacks here
            events: [

                @if(isset($classes)) 
                {!! $events !!}
                @endif
            ]
        });

    });

</script>

<script src="feedback/js/form.js"></script>

<script type="text/javascript">
    $(function () {

        $(document).on('click', '.choose-time .btn', function () {
            $('.datetimepicker3 input').val($(this).attr('data-item'));
        });

        $(document).on('click', '.btn-save', function () {
            var date = new Date();

            if (date.getMonth() < 9) {
                var getMonth = '0' + (date.getMonth() + 1);
            } else {
                var getMonth = (date.getMonth() + 1);
            }

            var today = date.getDate() + '-' + getMonth + '-' + date.getFullYear();

            var id = $(this).attr('data-id');

            // var inputs_checkIn = $("[name*='"+ today +"']:checked");

            var inputs_checkIn = $("[name*='05-08-2021']:checked");


            var note = $('#note').val();

            var checkIn = [];

            inputs_checkIn.each(function (index, value) {
                console.log($(this).attr('data-id'), value.value);
                checkIn[index] = {
                    'id': $(this).attr('data-id'),
                    'val': value.value
                };
            });

            var timeStartAt = $('.datetimepicker3 input').val();

            var time = timeStartAt.split(' ')[0];
            var dayOrNight = timeStartAt.split(' ')[1];
            var hour = time.split(':')[0];
            var minute = time.split(':')[1];
                    // console.log(time3);
            if (hour < 10) {
                hour = '0' + hour;
            }

            if (dayOrNight == 'PM') {
                hour = hour * 1 + 12;
            }

            var start_at = hour + ':' + minute + ':00';

            var data = {
                id: id,
                checkIn: checkIn,
                note: note,
                start_at: start_at
            }

            $.ajax({
                type: 'POST',
                url: base_url + '/postCheckIn',
                data: data,
                dataType: 'json',

                success: function (response) {
                    console.log(response);
                    successResponse(response);
                },
                error: function (e) {
                    errorResponse(e)
                }
            });


        });
    });

</script>

@endsection
