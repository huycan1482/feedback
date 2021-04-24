@extends('admin.layouts.main')

@section('css')
    <!-- Theme style -->
    <link rel="stylesheet" href="backend/dist/css/AdminLTE.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="backend/plugins/iCheck/all.css">
    <!-- my css -->
    <link rel="stylesheet" href="backend/mycss/createForm.css">
@endsection

@section('content')

<section class="content-header">
    <h1>
        Sửa - Câu hỏi
        <small><a href="{{ route('admin.question.index') }}">Danh sách</a></small>
    </h1>
</section>

<div class="modal fade" id="modal-default1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Chỉnh sửa câu trả lời</h4>
            </div>
            <div class="modal-body">

                <form role="form" action="" method="" enctype="multipart/form-data">
                    <div class="box-body">

                        <div class="form-group" id="form-answer_content">
                            <label for="">Nội dung câu trả lời</label>
                            <input name="modal-answer-content" type="text" class="form-control" placeholder="Nội dung câu hỏi" value="">
                        </div>

                        <div class="form-group" id="form-answer_is_active">
                            <label>
                                <input type="checkbox" name="modal-answer-active" value="1" > Kích hoạt
                            </label>
                        </div>

                        {{-- <div class="form-group">
                            <label>
                                <input type="checkbox" name="" value="1" > Câu trả lời đúng
                            </label>
                        </div> --}}

                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <div type="button" class="btn btn-primary btn-update-answer" data-id="">Update</div>
                {{-- <div type="button" class="btn btn-danger btn-delete-answer" data-id="">Delete</div> --}}
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
                <h4 class="modal-title">Thêm câu trả lời</h4>
            </div>
            <div class="modal-body">

                <form class="form-modal" role="form" action="" method="" enctype="multipart/form-data">
                    <div class="box-body">

                        <div class="form-group" id="form-add_answer_content">
                            <label for="">Nội dung câu trả lời</label>
                            <input name="modal-add-answer-content" type="text" class="form-control" placeholder="Nội dung câu hỏi" value="">
                        </div>

                        <div class="form-group" id="form-add_answer_active">
                            <label>
                                <input type="checkbox" name="modal-add-answer-active" value="1" > Kích hoạt
                            </label>
                        </div>

                        {{-- <div class="form-group">
                            <label>
                                <input type="checkbox" name="" value="1" > Câu trả lời đúng
                            </label>
                        </div> --}}

                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <div type="button" class="btn btn-primary btn-add-answer" >Add</div>
                <div type="button" class="btn btn-danger" data-dismiss="modal">Close</div>
            </div>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-8">
            <!-- general form elements -->

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin câu hỏi</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{ route('admin.question.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">

                        <div class="form-group">
                            <label for="">Nội dung câu hỏi</label>
                            <input name="content" type="text" class="form-control" placeholder="Nội dung câu hỏi" value="{{$question->content}}">
                        </div>

                        <div class="form-group">
                            <label for="">
                                <span>Danh sách câu trả lời </span>
                                <span class="label label-success" data-toggle="modal" data-target="#modal-default2" style="margin-left: 10px; cursor: pointer;"> Thêm đáp án</span>
                            </label>
                            <div class="answer">
                                @foreach($answers as $key => $answer)
                                <div data-id="{{ $answer->id }}">
                                    <input type="radio" class="minimal" checked>
                                    <div class="answer-content">
                                        <p class="" data-id="{{ $answer->id }}">{{$answer->content}}</p>
                                    </div>
                                    <div class="">
                                        <button type="button" class="btn btn-warning btn-detail" data-toggle="modal" data-target="#modal-default1" title="Chi tiết" data-id="{{$answer->id}}" style="margin-right: 5px">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                        <a class="btn btn-danger btn-delete" title="Xóa" data-id="{{$answer->id}}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="checkbox form-group">
                            <label>
                                <input type="checkbox" name="is_active" value="1" {{ ( $question->is_active == 1 ) ? 'checked' : '' }}> Kích hoạt
                            </label>
                        </div>
                        
                    </div>
                    
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="btn btn-primary btn-update-question" data-id="{{$question->id}}">Update</div>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
            

        </div>
    </div>
    <!-- /.row -->
</section>
@endsection

@section('my_script')
<!-- Select2 -->
<script src="backend/bower_components/select2/dist/js/select2.full.min.js"></script>

<script>
    $(function () {
        //Initialize Select2 Elements

        $(document).on('click', '.btn-add-answer', function (e) {
            if ($('input:radio').length < 4) {
                var add_answer_content = $("input[name*='modal-add-answer-content']").val();
                var add_answer_active = ( $("input[name*='modal-add-answer-active']").is(':checked') ) ? 1 : 0;
                var question_id = $('.update-question').attr('data-id');

                $.ajax({
                    type: "post",
                    url: base_url + '/admin/answer',
                    data: {
                        'question_id' : question_id,
                        'add_answer_content' : add_answer_content,
                        'add_answer_active' : add_answer_active,
                    },
                    dataType: "json",
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

            } else {
                var message = "<div class='pad margin no-print col-md-11' id='message' ><div class='alert alert-danger alert-dismissible'>"
                    +"<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4><i class='icon fa fa-check'></i> Thông báo !</h4> Tối đa 4 câu trả lời </div></div>";

                if ( $('#message') ) {
                    $('#message').remove();
                }

                $('.form-modal').before(message);
            }
        });

        $(document).on('click', '.btn-detail', function (e) {
            var itemId = $(this).attr('data-id');

            $.ajax({
                type: 'get',
                url: base_url + '/admin/answer/' + itemId,
                data: {},
                dataType: "json",
                success: function (response) {

                    $("input[name*='modal-answer-content']").val(response.answer.content);

                    if (response.answer.is_check == 1) {
                        $("input[name*='modal-answer-active']").attr('checked', 'checked');
                    } else if (response.answer.is_check == 0) {
                        $("input[name*='modal-answer-active']").attr('checked', '');
                    } 

                    $('.btn-update-answer').attr('data-id', response.answer.id);
                }
            });
        })

        $(document).on('click', '.btn-delete', function (e) {

            var result = confirm("Bạn có chắc chắn muốn xóa ?");
            if (result) { 
                var delete_id = $(this).attr('data-id');
                $.ajax({
                    url: base_url + '/admin/answer/' + delete_id, 
                    type: 'DELETE',
                    data: {}, 
                    dataType: "json", 
                    success: function (response) { 
                        $('div.data-id-' + delete_id).remove();
                        // messageResponse('success', response.mess);
                    },
                    error: function (e) { 
                        messageResponse('danger', e.responseJSON.mess);
                    }
                });
            }
        });

        $(document).on('click', '.btn-update-answer', function (e) {
            var question_id = $('.update-question').attr('data-id');
            var answer_id = $(this).attr('data-id');
            var answer_content = $("input[name*='modal-answer-content']").val();
            var answer_active = ( $("input[name*='modal-answer-active']").is(':checked') ) ? 1 : 0;

            $.ajax({
                type: 'PUT',
                url: base_url + '/admin/answer/' + answer_id,
                data: {
                    'answer_content' : answer_content,
                    'answer_is_active' : answer_active,
                },
                dataType: "json",
                success: function (response) {
                    $("p[data-id*='" +answer_id+ "']").text(answer_content);
                    $('#modal-default1').modal('hide');
                }, 
                error: function (e){
                    errorResponseModal(e);
                }
            });
        });

        $(document).on('click', '.btn-update-question', function (e) {
            var question_id = $('.btn-update-question').attr('data-id');
            var content = $("input[name='content']").val();
            var is_active = ( $("input[name*='is_active']").is(':checked') ) ? 1 : 0;

            $.ajax({
                type: 'PUT',
                url: base_url + '/admin/question/' + question_id,
                data: {
                    'content' : content,
                    'is_active' : is_active,
                },
                dataType: "json",
                success: function (response) {
                    successResponse(response);
                }, 
                error: function (e){
                    errorResponse(e);
                }
            });

        });

    });

    

    
</script>

@endsection