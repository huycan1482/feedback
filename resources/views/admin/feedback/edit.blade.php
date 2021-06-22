@extends('admin.layouts.main')

@section('css')
  <!-- DataTables -->
<link rel="stylesheet" href="backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('content')

<section class="content-header">
    <h1>
        Sửa - Bài đánh giá
        <small><a href="{{ route('admin.feedback.index') }}">Danh sách</a></small>
    </h1>
</section>

<div class="modal fade" id="modal-default1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Thông tin chi tiết câu hỏi</h4>
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
                                <tr style="width: 100%">
                                    <td class="" style="width: 30%">
                                        Câu trả lời
                                    </td>
                                    <td class="modal-question-answers" style="overflow-wrap: anywhere;width: 70%" >
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

{{-- <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Thay đổi thứ tự câu hỏi</h4>
            </div>
            <div class="modal-body">
                <div class="box box-info">
                    <div class="box-header"></div>
                    <div class="box-body">
                        <div class="form-modal">
                            <div class="form-group" id="form-questionPosition">
                                <label for="">Số thứ tự</label>
                                <div>
                                    <input name="questionPosition" type="number" class="form-control" placeholder="Số thứ tự" min="0">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info btn-update-question">Udate</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div> --}}

<section class="content">
    <div class="row">
        <div class="col-md-6">
            <!-- general form elements -->

            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin Bài đánh giá</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {{-- {{ dd(route('admin.category.store')) }} --}}
                
                <div class="box-body">
                    <form enctype="multipart/form-data">
                        <div class="form-group" id="form-name">
                            <label for="">Tên bài đánh giá</label>
                            <div>
                                <input name="name" type="text" class="form-control" placeholder="Tên bài đánh giá" value="{{ $feedback->name }}">
                            </div>
                        </div>

                        <div class="form-group" id="form-code">
                            <label for="">Mã bài đánh giá</label>
                            <div>
                                <input name="code" type="text" class="form-control" placeholder="Mã bài đánh giá" value="{{ $feedback->code }}">
                            </div>
                        </div>

                        <div class="checkbox form-group">
                            <label>
                                <input type="checkbox" name="is_active" id="is_active" {{ ($feedback->is_active == 1) ? 'checked' : '' }}> Kích hoạt
                            </label>
                        </div>
                        
                    </form>

                    <div id="form-question_id">
                        <h3 class="" style="font-size: 18px;padding-top: 25px; border-top: 1px solid #17a2b8" >Danh sách câu hỏi được thêm</h3>
                        <div class="table-responsive no-padding">
                            <table class="table-hover table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                <thead>
                                    <tr>
                                        <th class="text-center">STT</th>
                                        <th class="text-center">Mã câu hỏi</th>
                                        <th class="text-center">Nội dung</th>
                                        {{-- <th class="text-center">Thứ tự</th> --}}
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <!-- Lặp một mảng dữ liệu pass sang view để hiển thị -->
                                <tbody class="list-questions">
                                    @foreach($data as $key => $item)
                                    <tr class="item-{{ $item->feedbackQuestionId }}">
                                        <td class="text-center">{{ $key + 1}}</td>
                                        <td class="text-center">{{ $item->code }}</td>
                                        <td class="text-center">{{ $item->content }}</td>
                                        {{-- <td class="text-center">{{ $item->position }}</td> --}}
                                        <td class="text-center">
        
                                            {{-- <div class="btn btn-primary btn-edit-question" title="Sửa" data-id="{{$item->feedbackQuestionId}}" data-toggle="modal" data-target="#modal-default">
                                                <i class="fa fa-edit"></i>
                                            </div> --}}

                                            <div class="btn btn-danger btn-del-question" title="Xóa" data-id="{{$item->feedbackQuestionId}}"> 
                                                <i class="fa fa-trash"></i>
                                            </div>
            
                                            <button type="button" class="btn btn-warning btn-detail" data-toggle="modal" data-target="#modal-default1" title="Chi tiết" data-id="{{$item->id}}">
                                                <i class="fas fa-cog"></i>
                                            </button>
            
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="btn btn-primary update-feedback" data-id="{{ $feedback->id }}">Update</div>
                    <button type="reset" class="btn btn-danger">Reset</button>
                </div>  
                
            </div>
            <!-- /.box -->
        </div>

        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Quản lí câu hỏi</h3>
                    {{-- <span class="label label-success add-lesson" style="cursor:pointer" data-toggle="modal" data-target="#modal-default" > Thêm câu hỏi </span> --}}
                </div>

                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Mã câu hỏi</th>
                                <th class="text-center">Nội dung</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($questions as $key => $question)
                            <tr class="item-{{ $question->id }}">
                                <td class="text-center">{{ $key + 1}}</td>
                                <td class="text-center">{{ $question->code }}</td>
                                <td class="text-center">{{ $question->content }}</td>
                                <td class="text-center">

                                    <div class="btn btn-success btn-add-question" title="Thêm" data-id="{{$question->id}}">
                                        <i class="fas fa-plus"></i>
                                    </div>
    
                                    <button type="button" class="btn btn-warning btn-detail" data-toggle="modal" data-target="#modal-default1" title="Chi tiết" data-id="{{$question->id}}">
                                        <i class="fas fa-cog"></i>
                                    </button>
    
                                 </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
    
                        </tfoot>
                    </table>
                    
                </div>

                
            </div>

        </div>
        
        <!--/.col (right) -->
    </div>
    <!-- /.row -->
</section>
@endsection

@section('my_script')
<!-- Table -->
<script src="backend/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script src="backend/js/main.js"></script>
<script>
    $(function () {
        $('#example1').DataTable();

        $('.datepicker').datepicker({
            // autoclose: false,
            format: 'dd-mm-yyyy',
            forceParse: false,
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
                        html += "<div>Câu "+ (index + 1) +": "+ value.content +"</div>"
                    });

                    $('.modal-question-answers').html(html);
                    // console.log(html);
                }
            });
        });

        $(document).on('click', '.btn-add-question', function (e) {

            var itemId = $(this).attr('data-id');
            var feedback_id = $('.update-feedback').attr('data-id');

            data = {
                question_id : itemId,
                feedback_id : feedback_id
            }

            var model = '/admin/feedbackQuestion';

            // addModel(model, data)

            $.ajax({
                type: "POST",
                url: base_url + model,
                data: data,
                dataType : "json",
                success: function (response) {
                    successResponse(response);
                    setTimeout(function (){
                        location.reload()
                    }, 1500);
                },
                error: function (e) {
                    errorResponse(e)
                }
            });

                
            

        });

        $(document).on('click', '.btn-edit-question', function (e) {
            var itemId = $(this).attr('data-id');
            var data = $('.item-' + itemId + ' td:nth-of-type(4)').text().replace(/\s/g, '');
            $('.btn-update-question').attr('data-id', itemId);
            $("input[name='questionPosition']").val(data);
        });

        $(document).on('click', '.btn-update-question', function (e) {
            var position = $("input[name='questionPosition']").val();

            var model = '/admin/feedbackQuestion/' + $(this).attr('data-id');

            data = {
                position: position
            }

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

        $(document).on('click', '.btn-del-question', function(e) {
            var id = $(this).attr('data-id');

            var result = confirm("Bạn có chắc chắn muốn xóa ?");

            if (result) { 
                $.ajax({
                    url: base_url + '/admin/feedbackQuestion/'+id, 
                    type: 'DELETE',
                    data: {},
                    dataType: "json", 
                    success: function (response) { 
                        successResponse(response);
                        setTimeout(function (){
                            location.reload()
                        }, 1500);
                    },
                    error: function (e) { 
                        messageResponse('danger', e.responseJSON.mess);
                    }
                });
            }
        });

        $(document).on('click', '.update-feedback', function (e) {

            var name = $("input[name='name']").val();
            var code = $("input[name='code']").val();
            var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;

            data = {
                name: name,
                code: code,
                is_active : is_active
            };

            var model = '/admin/feedback/' + $(this).attr('data-id');

            updateModel(model, data);

        });

  
    });

    

    
</script>

@endsection