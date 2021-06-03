@extends('admin.layouts.main')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('content')
<section class="content-header">
    <h1>
        Quản lý danh sách Câu hỏi Bài đánh giá {{$feedback->code}}
        <small><a href="{{ route('admin.feedback.index') }}">Quay lại</a></small>
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
                        <h4 class="modal-title">Thông tin chi tiết câu hỏi</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="box">
                                    <div class="box-header">
                                        <h4>Thông tin chung</h4>
                                    </div>
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table-hover table table-bordered table-striped dataTable"
                                            role="grid" aria-describedby="example1_info" style="margin-top: 0 !important;"> 
                                            <tbody>
                                                <tr style="width: 100%">
                                                    <td class="" style="width: 30%">
                                                        Nội dung câu hỏi:
                                                    </td>
                                                    <td class="modal-question-content" style="width: 70%">

                                                    </td>
                                                </tr>
                                                <tr style="width: 100%">
                                                    <td class="" style="width: 30%">
                                                        Kích hoạt:
                                                    </td>
                                                    <td class="modal-question-active" style="width: 70%">

                                                    </td>
                                                </tr>
                                                <tr style="width: 100%">
                                                    <td class="" style="width: 30%">
                                                        Người tạo:
                                                    </td>
                                                    <td class="modal-question-" style="width: 70%">

                                                    </td>
                                                </tr>
                                                <tr style="width: 100%">
                                                    <td class="" style="width: 30%">
                                                        Ngày tạo:
                                                    </td>
                                                    <td class="modal-question-createdAt" style="width: 70%">

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="box">
                                    <div class="box-header">
                                        <h4>Thông tin Đáp án</h4>
                                    </div>
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table-hover table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info" style="margin-top: 0 !important;">
                                            <thead>
                                                <th>STT</th>
                                                <th>Nội dung</th>
                                            </thead>
                                            <tbody class="modal-answer-data modal-question-answers">
                                                
                                            </tbody>
                                        </table>
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
                                <th class="text-center">Nội dung</th>
                                {{-- <th class="text-center"></th> --}}
                                <th class="text-center">Người tạo</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feedback->question as $key => $question)
                            <tr class="item-{{ $question->id }}">
                                <td class="text-center">{{ $key + 1}}</td>
                                <td class="text-center">{!! Str::limit($question->content, 50) !!}</td>
                                {{-- <td class="text-center"></td> --}}
                                <td class="text-center"></td>
                                <td class="text-center">
                                    <span class="label label-{{ ($question->is_active == 1) ? 'success' : 'danger' }}">{{ ($question->is_active == 1) ? 'Hiển thị' : 'Ẩn' }}</span>
                                </td>
                                <td class="text-center">

                                    <a href="{{ route('admin.question.getListAnswer', ['id' => $question->id]) }}" class="btn btn-primary" title="Câu trả lời liên quan">
                                        <i class="fas fa-long-arrow-alt-right"></i>
                                    </a>

                                    <button type="button" class="btn btn-warning btn-detail" data-toggle="modal" data-target="#modal-default" title="Chi tiết" data-id="{{$question->id}}">
                                        <i class="fas fa-cog"></i>
                                    </button>

                                    <a href="{{ route('admin.question.edit', ['id'=> $question->id]) }}" class="btn btn-success" title="Sửa">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <a href="javascript:void(0)" class="btn btn-danger" onclick="destroyModel('question', '{{ $question->id }}' )" title="Xóa">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            {{-- <tr>
                                <th>STT</th>
                                <th>Nội dung</th>
                                <th></th>
                                <th>Trạng thái</th>
                                <th>Người tạo</th>
                                <th>Hành động</th>
                            </tr> --}}
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
                url: base_url + '/admin/question/' + itemId,
                data: {},
                dataType: "json",
                success: function (response) {
                    var html = '';
                    // console.log(response.question);
                    $('.modal-question-content').html(response.question.content);
                    if (response.question.is_active == 1) {
                        $('.modal-question-active').html("<span class='label label-success'> Hiển thị </span>");
                    } else {
                        $('.modal-question-active').html("<span class='label label-danger'> Ẩn </span>")
                    }
                    response.answers.forEach( function (value, index) {
                        // console.log(value, index);
                        html += "<tr><td>" + (index + 1) + "</td><td style='overflow-wrap: anywhere'> " + value.content +
                            "</td></tr>"
                    });

                    $('.modal-question-answers').html(html);
                    // console.log(html);
                }
            });
        });

    });
</script>
@endsection