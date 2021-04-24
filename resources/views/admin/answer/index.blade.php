@extends('admin.layouts.main')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('content')
<section class="content-header">
    <h1>
        Quản lý danh sách Câu trả lời
        {{-- <small><a href="{{ route('answer.create') }}">Thêm mới</a></small> --}}
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
                        <h4 class="modal-title">Thông tin chi tiết câu trả lời</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box">
                            <div class="box-body table-responsive no-padding">
                                <table class="table-hover table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <tbody>
                                        <tr style="width: 100%">
                                            <td class="" style="width: 30%">
                                                Nội dung câu hỏi:
                                            </td>
                                            <td class="modal-answer-question" style="width: 70%">

                                            </td>
                                        </tr>
                                        <tr style="width: 100%">
                                            <td class="" style="width: 30%">
                                                Nội dung câu trả lời:
                                            </td>
                                            <td class="modal-answer-content" style="width: 70%">

                                            </td>
                                        </tr>
                                        <tr style="width: 100%">
                                            <td class="" style="width: 30%">
                                                Kích hoạt:
                                            </td>
                                            <td class="modal-answer-true" style="width: 70%">

                                            </td>
                                        </tr>
                                        <tr style="width: 100%">
                                            <td class="" style="width: 30%">
                                                Người tạo:
                                            </td>
                                            <td class="modal-answer-user" style="width: 70%">

                                            </td>
                                        </tr>
                                        <tr style="width: 100%">
                                            <td class="" style="width: 30%">
                                                Ngày tạo:
                                            </td>
                                            <td class="modal-answer-createdAt" style="width: 70%">

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
                                <th class="text-center">Đáp án</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($answers as $key => $answer)
                            <tr class="item-{{ $answer->id }}">
                                <td class="text-center">{{ $key + 1}}</td>
                                <td class="text-center">{!! Str::limit($answer->content, 50) !!}</td>
                                {{-- <td class="text-center"></td> --}}
                                <td class="text-center"></td>
                                <td class="text-center">
                                    <span class="label label-{{ ($answer->is_true == 1) ? 'success' : 'danger' }}">{{ ($answer->is_true == 1) ? 'Đúng' : 'Sai' }}</span>
                                </td>
                                <td class="text-center">

                                    <button type="button" class="btn btn-warning btn-detail" data-toggle="modal" data-target="#modal-default" title="Chi tiết" data-id="{{$answer->id}}">
                                        <i class="fas fa-cog"></i>
                                    </button>

                                    <a href="{{ route('admin.answer.edit', ['id'=> $answer->id]) }}" class="btn btn-success" title="Sửa">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <a href="javascript:void(0)" class="btn btn-danger" onclick="destroyModel('answer', '{{ $answer->id }}' )" title="Xóa">
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
                url: base_url + '/admin/answer/' + itemId,
                data: {},
                dataType: "json",
                success: function (response) {
                    var html = '';
                    // console.log(response.answer);
                    $('.modal-answer-question').html(response.question.content);
                    $('.modal-answer-content').html(response.answer.content);
                    if (response.answer.is_true == 1) {
                        $('.modal-answer-true').html("<span class='label label-success'> Đúng </span>");
                    } else {
                        $('.modal-answer-true').html("<span class='label label-danger'> Sai </span>")
                    }
                    $('.modal-answer-createdAt').html(response.answer.created_at);
                    
                }
            });
        });

        
    })
</script>
@endsection