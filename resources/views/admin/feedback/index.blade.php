@extends('admin.layouts.main')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('content')
<section class="content-header">
    <h1>
        Quản lý danh sách Bài khảo sát
        <small><a href="{{ route('admin.feedback.create') }}">Thêm mới</a></small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Thông tin chi tiết Bài khảo sát</h3>
                    </div>
                    <div class="modal-body">
                        <div class="box box-info">
                            <div class="box-header">
                                <h4 class="feedback-name" style="text-align: center">Bài đánh giá khảo sát giảng viên</h4>
                            </div>
                            <div class="box-body">
                                <div class="feedback-info">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="feedback-item feedback-feedbackName">
                                                <i class="fas fa-scroll"></i>
                                                <span>Bài đánh giá: </span>
                                                <span></span>
                                            </div>
                                            {{-- <div class="feedback-item feedback-className">
                                                <i class="fas fa-book-open"></i>
                                                <span>Lớp học: </span>
                                                <span></span>
                                            </div>
                                            <div class="feedback-item feedback-teacherName">
                                                <i class="fas fa-user-tie"></i>
                                                <span>Giảng viên: </span>
                                                <span></span>
                                            </div>
                                            <div class="feedback-item feedback-courseName">
                                                <i class="fas fa-bookmark"></i>
                                                <span>Khóa học: </span>
                                                <span></span>
                                            </div>
                                            <div class="feedback-item feedback-subjectName">
                                                <i class="fas fa-book"></i>
                                                <span>Môn học: </span>
                                                <span></span>
                                            </div> --}}
                                        </div>
                                        <div class="col-lg-6">
                                            {{-- <div class="feedback-item feedback-start_at">
                                                <i class="far fa-circle"></i>
                                                <span>Ngày bắt đầu học: </span>
                                                <span></span>
                                            </div>
                                            <div class="feedback-item feedback-end_at">
                                                <i class="far fa-dot-circle"></i>
                                                <span>Ngày kết thúc<: </span>
                                                <span></span>
                                            </div> --}}
                                            <div class="feedback-item feedback-close">
                                                <i class="far fa-calendar-check"></i>
                                                <span>Ngày bắt đầu khảo sát: </span>
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>   
                                </div>
                                <div class="feedback-content">
                                   
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

        
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    {{-- <h3 class="box-title">Data Table With Full Features</h3> --}}
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Tên</th>
                                <th class="text-center">Mã đề khảo sát</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feedbacks as $key => $feedback)
                            <tr class="item-{{ $feedback->id }}">
                                <td class="text-center">{{ $key + 1}}</td>
                                <td class="text-center">{{ $feedback->name }}</td>
                                {{-- <td class="text-center">{!! Str::limit($feedback->content, 50) !!}</td> --}}
                                <td class="text-center">{{ $feedback->code }}</td>
                                <td class="text-center">
                                    <span class="label label-{{ ($feedback->is_active == 1) ? 'success' : 'danger' }}">{{ ($feedback->is_active == 1) ? 'Hiển thị' : 'Ẩn' }}</span>
                                </td>
                                <td class="text-center">

                                    <a href="{{ route('admin.question.getListAnswer', ['id' => $feedback->id]) }}" class="btn btn-primary" title="Câu trả lời liên quan">
                                        <i class="fas fa-long-arrow-alt-right"></i>
                                    </a>

                                    <button type="button" class="btn btn-warning btn-detail" data-toggle="modal" data-target="#modal-default" title="Chi tiết" data-id="{{$feedback->id}}">
                                        <i class="fas fa-cog"></i>
                                    </button>

                                    <a href="{{ route('admin.question.edit', ['id'=> $feedback->id]) }}" class="btn btn-success" title="Sửa">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <a href="javascript:void(0)" class="btn btn-danger" onclick="destroyModel('feedback', '{{ $feedback->id }}' )" title="Xóa">
                                        <i class="fa fa-trash"></i>
                                    </a>
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
    </div>
    <!-- /.row -->
</section>
@endsection

@section('my_script')
<script src="backend/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
    $(function() {
        $('#example1').DataTable();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.btn-detail', function(){
            var itemId = $(this).attr('data-id');
            $.ajax({
                type: "get",
                url: base_url + '/admin/feedback/' + itemId,
                data: {},
                dataType: "json",
                success: function (response) {
                    console.log(response);

                    $('.feedback-feedbackName > span:last-child').html(response.feedback.name + ' / ' + response.feedback.code);
                    $('.feedback-close > span:last-child').html(response.feedback.start_at);

                    var html = '';

                    var question = JSON.parse(response.data) ;

                    question.forEach( function (value, index) {
                        // console.log(value, index);
                        html += "<div class='feedback-question'><span>"+ (index + 1) +". ("+ value.code +"): </span>"+ value.content +"</div><div class='feedback-answers'><div class='row'>";

                        value.answer.forEach( function (value2, index2) {
                            // console.log(value2, index2);
                            html += "<div class='col-lg-6 answer-items'><i class='far fa-circle'></i>"+
                                value2.content +"</div>";
                        });

                        html += '</div></div>';
                    });

                    $('.feedback-content').html(html);
                }
            });
        })

    })
</script>
@endsection