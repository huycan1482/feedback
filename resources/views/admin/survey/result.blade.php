@extends('admin.layouts.main')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('content')
<section class="content-header">
    <h1>
        Quản lý danh sách Bài khảo sát
        <small><a href="{{ route('admin.survey.index') }}">Danh sách</a></small>
    </h1>
</section>

<section class="content">
    <div class="modal modal-chart fade modal-xl" id="modal-chart">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Thông tin chi tiết Bài khảo sát</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="box box-info">
                                <div class="box-header">
                                    <h4 class="feedback-name" style="text-align: center">Biểu đồ</h4>
                                </div>
                                <div class="box-body">
                                    <div id="quetions-chart" style="width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="box box-info">
                                <div class="box-header">
                                    <h4 class="feedback-name" style="text-align: center">Danh sách câu trả lời</h4>
                                </div>
                                <div class="box-body">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal modeal-user fade" id="modal-user">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Thông tin Người tham gia khảo sát</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="box box-info">
                                <div class="box-header">
                                    <h4 class="modal-title">Thông tin cá nhân</h4>
                                </div>
                                <div class="box-body table-responsive no-padding">
                                    <table class="table-hover table table-bordered table-striped dataTable" role="grid"
                                        aria-describedby="example1_info" style="margin-top: 0 !important;">
                                        <tbody>
                                            <tr style="width: 100%">
                                                <td class="" style="width: 30%">
                                                    Tên người dùng:
                                                </td>
                                                <td class="modal-user-name" style="width: 70%">

                                                </td>
                                            </tr>
                                            <tr style="width: 100%">
                                                <td class="" style="width: 30%">
                                                    Mã người dùng:
                                                </td>
                                                <td class="modal-user-identity" style="width: 70%">

                                                </td>
                                            </tr>
                                            <tr style="width: 100%">
                                                <td class="" style="width: 30%">
                                                    Email:
                                                </td>
                                                <td class="modal-user-email" style="width: 70%">

                                                </td>
                                            </tr>
                                            <tr style="width: 100%">
                                                <td class="" style="width: 30%">
                                                    Số điện thoại:
                                                </td>
                                                <td class="modal-user-phone" style="width: 70%">

                                                </td>
                                            </tr>
                                            <tr style="width: 100%">
                                                <td class="" style="width: 30%">
                                                    Địa chỉ:
                                                </td>
                                                <td class="modal-user-address" style="width: 70%">

                                                </td>
                                            </tr>
                                            <tr style="width: 100%">
                                                <td class="" style="width: 30%">
                                                    Địa chỉ Facebook:
                                                </td>
                                                <td class="modal-user-facebook" style="width: 70%">

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h4 class="modal-title">Thông tin chung bài khảo sát</h4>
                                </div>
                                <div class="box-body table-responsive no-padding">
                                    <table class="table-hover table table-bordered table-striped dataTable" role="grid"
                                        aria-describedby="example1_info" style="margin-top: 0 !important;">
                                        <tbody>
                                            <tr style="width: 100%">
                                                <td class="" style="width: 30%">
                                                    Thời gian làm khảo sát:
                                                </td>
                                                <td class="modal-user-created" style="width: 70%">

                                                </td>
                                            </tr>
                                            <tr style="width: 100%">
                                                <td class="" style="width: 30%">
                                                    Góp í:
                                                </td>
                                                <td class="modal-user-opinion" style="width: 70%">

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal-user">Close</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="row">
        <div class="col-lg-6 ">
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">Lượng người tham gia</h3>
                </div>
                <div class="box-body">
                    <div id="users-chart" style="width: 100%; height: 300px;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="box box-danger">
                <div class="box-header">
                    <h3 class="box-title">Số lượng góp í</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Danh sách người tham gia khảo sát</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="table1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Tên</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Điện thoại</th>
                                <th class="text-center">Loại người dùng</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($anonymous_users as $key => $anonymous_user)
                            <tr class="item-{{ $anonymous_user->id }}">
                                <td class="text-center">{{ $key + 1}}</td>
                                {{-- <td class="text-center">{!! Str::limit($feedback->content, 50) !!}</td> --}}
                                <td class="text-center">{{ $anonymous_user->name }}</td>
                                <td class="text-center">{{ $anonymous_user->email }}</td>
                                <td class="text-center">{{ $anonymous_user->phone }}</td>
                                <td class="text-center">
                                    <span
                                        class="label label-{{ ($anonymous_user->user_identity != '') ? 'success' : 'danger' }}">{{ ($anonymous_user->user_identity != '') ? 'Trong hệ thống' : 'Ngoài hệ thống' }}</span>
                                </td>
                                <td class="text-center">

                                    <a href="{{ route('admin.survey.getSurveyResult', ['id' => $anonymous_user->id]) }}"
                                        class="btn btn-primary" title="Kết quả bài đánh giá">
                                        <i class="fas fa-long-arrow-alt-right"></i>
                                    </a>

                                    <button type="button" class="btn btn-success btn-user-detail" data-toggle="modal"
                                        data-target="#modal-user" title="Chi tiết thông tin"
                                        data-id="{{$anonymous_user->id}}" survey-id="{{ $survey_id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Thống kê chi tiết </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="table2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Mã câu hỏi</th>
                                <th class="text-center">Nội dung</th>
                                <th class="text-center">Loại câu hỏi</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($questions as $key => $question)
                            <tr class="item-{{ $question->id }}">
                                <td class="text-center">{{ $key + 1}}</td>
                                <td class="text-center">{{ $question->code }}</td>
                                <td class="text-center">{!! Str::limit($question->content, 50) !!}</td>
                                <td class="text-center">
                                    @if($question->type == 1)
                                    {{'Chọn một đáp án'}}
                                    @elseif($question->type == 2)
                                    {{'Chọn nhiều đáp án'}}
                                    @else
                                    {{'Viết câu trả lời'}}
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{-- <button type="button" class="btn btn-success btn-chart-detail" data-toggle="modal"
                                        data-target="#modal-chart" title="Chi tiết thông tin" survey-id="{{ $survey_id }}" question-id="{{ $question->id }}">
                                        <i class="fas fa-chart-pie"></i>
                                    </button> --}}

                                    <a href="{{ route('admin.survey.getAnswersChart', ['survey_id'=> $survey_id, 'question_id' => $question->id]) }}" class="btn btn-success btn-chart-detail">
                                        <i class="fas fa-chart-pie"></i>
                                    </a>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-body">

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.row -->
</section>
@endsection

@section('my_script')
<script src="backend/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });

    google.charts.setOnLoadCallback(drawChart);

    // let user_chart_string = "";
    // let question_content_string = "";

    // $(document).on('click', '.btn-chart-detail', function (e) {
    //     var survey_id = $(this).attr('survey-id');
    //     var question_id = $(this).attr('question-id');

    //     $.ajax({
    //         type: "get",
    //         url: base_url + "/admin/survey/getQuestionChart/" + survey_id + "_" + question_id,
    //         data: {},
    //         dataType: "json",
    //         success: function (response) {
    //             console.log(response.question_chart);
    //             console.log(response.question_content);

    //             response.question_chart.forEach( function (value, index) {
    //                 user_chart_string += "'" + value.code + "', " + value.number;  
    //             });
    //         }
    //     });

    //     google.charts.load('current', {
    //         'packages': ['corechart']
    //     });

       
    // });

    // function drawQuestionChart() {
    //     console.log( user_chart_string, user_chart_string.split(','));
    //     var users_chart_data = google.visualization.arrayToDataTable([
    //         ['Task', 'Hours per Day'],
    //         // user_chart_string.split(',') 
    //     ]);

    //     var users_chart_options = {
    //         title: 'Lượng người tham gia',
    //         is3D: true,
    //     };

    //     // var user_chart = new google.visualization.PieChart(document.getElementById('quetions-chart'));
    //     var user_chart = new google.visualization.PieChart(document.getElementById('quetions-chart'));

    //     user_chart.draw(users_chart_data, users_chart_options);
    // }

    function drawChart() {

        var users_chart_data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            {!! $users_chart !!}
        ]);

        var users_chart_options = {
            title: 'Lượng người tham gia'
        };

        var user_chart = new google.visualization.PieChart(document.getElementById('users-chart'));

        user_chart.draw(users_chart_data, users_chart_options);
    }

</script>
<script>
    $(function () {
        $('#table1').DataTable();
        $('#table2').DataTable();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.btn-user-detail', function (e) {
            var user_id = $(this).attr('data-id');
            var survey_id = $(this).attr('survey-id');

            $.ajax({
                type: "get",
                url: base_url + '/admin/survey/getAnonymousUser/' + user_id + '_' + survey_id,
                data: {},
                dataType: "json",
                success: function (response) {
                    console.log(response);

                    if (response.anonymous_user != null) {
                        $('.modal-user-name').html(response.anonymous_user.name);
                        $('.modal-user-identity').html(response.anonymous_user
                            .user_identity);
                        $('.modal-user-email').html(response.anonymous_user.email);
                        $('.modal-user-phone').html(response.anonymous_user.phone);
                        $('.modal-user-address').html(response.anonymous_user.address);
                        $('.modal-user-facebook').html(response.anonymous_user.facebook);
                    }

                    if (response.data != null) {
                        $('.modal-user-created').html(response.data.created_at);
                        $('.modal-user-opinion').html(response.data.opinion);
                    }
                }
            });
        });

    })

</script>
@endsection
