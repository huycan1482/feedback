@extends('admin.layouts.main')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('content')
<section class="content-header">
    <h1>
        Quản lý danh sách Bài khảo sát
        <small><a class="btn-return" style="cursor: pointer">Quay lại</a></small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">Thống kê lựa chọn</h3>
                </div>
                <div class="box-body">
                    <div id="answers-chart" style="width: 100%; height: 300px;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="box box-danger">
                <div class="box-header">
                    <h3 class="box-title">Chi tiết nội dung</h3>
                </div>
                <div class="box-body">
                    <h4 style="font-size: 16px">Câu hỏi: {{ $question->content }}</h4>
                    @foreach($questions as $item)
                    <p>- {{ $item->content }}</p>
                    @endforeach
                </div>
            </div>
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

    function drawChart() {

        var answers_chart_data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            {!! $question_chart !!}
        ]);

        var answers_chart_options = {
            title: 'Thống kê lựa chọn'
        };

        var answer_chart = new google.visualization.PieChart(document.getElementById('answers-chart'));

        answer_chart.draw(answers_chart_data, answers_chart_options);
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

        $('.btn-return').click(function (e) {
            history.back();
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
