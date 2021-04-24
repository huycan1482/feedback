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
        Thêm - Câu hỏi
        <small><a href="{{ route('admin.question.index') }}">Danh sách</a></small>
    </h1>
</section>

<div class="modal fade" id="modal-default2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Thêm câu trả lời</h4>
            </div>
            <div class="modal-body">

                <form class="form-modal" enctype="multipart/form-data">
                    <div class="box-body">

                        <div class="form-group" id="form-add_answer_content">
                            <label for="">Nội dung câu trả lời</label>
                            <input name="modal-add-answer-content" type="text" class="form-control" placeholder="Nội dung câu hỏi" value="">
                        </div>

                        {{-- <div class="form-group" id="form-add_answer_active">
                            <label>
                                <input type="checkbox" name="modal-add-answer-active" value="1" > Kích hoạt
                            </label>
                        </div> --}}

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
                {{-- {{ dd(route('admin.category.store')) }} --}}
                <form enctype="multipart/form-data">
                    <div class="box-body">

                        <div class="form-group" id="form-content">
                            <label for="">Nội dung câu hỏi</label>
                            <input name="content" type="text" class="form-control" placeholder="Nội dung câu hỏi">
                        </div>

                        <div class="form-group">
                            <label for="">
                                <span>Danh sách câu trả lời </span>
                                <span class="label label-success" data-toggle="modal" data-target="#modal-default2" style="margin-left: 10px; cursor: pointer;"> Thêm đáp án</span>
                            </label>
                            <div class="answer">
                                <div></div>
                            </div>

                        </div>
                        
                        {{-- <div class="checkbox form-group" id="form-is_active">
                            <label>
                                <input type="checkbox" name="is_active" value="1"> Kích hoạt
                            </label>
                        </div> --}}
                    </div>
                    
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <div class="btn btn-primary add-question">Add</div>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
            

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
<script src="backend/js/main.js"></script>
<script>
    $(function () {
        let data_id = 1;
        let current_id = 0;

        $('.btn-add-answer').click(function (e) {
            if ($('input:radio').length < 4) {
                var val = $("input[name*='modal-add-answer-content']").val();
                $('.answer > div:last-child').after("<div class='data-id-"+ data_id +"'>" +
                        "<input type='radio' class='minimal data-id-" + data_id + "' name='answer-"+ data_id +"' value='"+ val +"' checked>" + 
                        "<div class='answer-content'><p class='data-id-"+ data_id +"'>"+ val +"</p></div>" +
                        "<div class='answer-icon'><i class='fas fa-edit' data-id="+ data_id +" data-toggle='modal' data-target='#modal-default2'></i><i class='fas fa-trash-alt' data-id="+ data_id +"></i></div></div>");
                    data_id++;
            } else {
                var message = "<div class='pad margin no-print col-md-11' id='message' ><div class='alert alert-danger alert-dismissible'>"
                    +"<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4><i class='icon fa fa-check'></i> Thông báo !</h4> Tối đa 4 câu trả lời </div></div>";

                if ( $('#message') ) {
                    $('#message').remove();
                }

                $('.form-modal').before(message);
            }
            
        });

        $(document).on('click', '.fa-edit', function(e) {
            var edit_id = $(this).attr('data-id');
            var value = $('p.data-id-' + edit_id).text();
            $("input[name*='modal-add-answer-content']").val(value);
            current_id = edit_id;

            $('.btn-add-answer').text('Update');
            $('.btn-add-answer').removeClass('btn-primary');
            $('.btn-add-answer').addClass('btn-success');
        });

        $(document).on('click', '.fa-trash-alt', function(e) {
            var delete_id = $(this).attr('data-id');
            $('div.data-id-' + delete_id).remove();
        });

        $('.add-question').click(function (e) {
            var content = $("input[name*='content']").val();
            var is_active = ( $("input[name*='is_active']").is(':checked') ) ? 1 : 0;
            var answers = [];

            $('input:radio').each(function (index, value) {
                console.log(index, value.value);
                answers.push([
                    value.value,
                    (value.checked) ? 1 : 0,
                ]);
            });

            $.ajax({
                type: "post",
                url: base_url + '/admin/question',
                data: {
                    'content' : content,
                    'answers' : answers,
                    'is_active' : is_active,
                },
                dataType: "json",
                success: function (response) {
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