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

<div class="modal fade" id="modal-default1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Thêm câu trả lời</h4>
            </div>
            <div class="modal-body">
                <div class="form-modal">
                    <div class="form-group" id="form-add_answer_content">
                        <label for="">Nội dung câu trả lời</label>
                        <div>
                            <input name="modal-add-answer-content" type="text" class="form-control" placeholder="Nội dung câu hỏi" value="" style="margin-left: 10px">
                        </div>
                    </div>
                </div>
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

<div class="modal fade" id="modal-default2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Sửa câu trả lời</h4>
            </div>
            <div class="modal-body">
                <div class="form-modal">
                    <div class="form-group" id="form-add_answer_content">
                        <label for="">Nội dung câu trả lời</label>
                        <div>
                            <input name="modal-edit-answer-content" type="text" class="form-control" placeholder="Nội dung câu trả lời" value="" style="margin-left: 10px">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div type="button" class="btn btn-success btn-edit-answer" >Edit</div>
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
                <form enctype="multipart/form-data">
                    <div class="box-body">

                        {{-- <div class="form-group" id="form-code">
                            <label for="">Mã câu hỏi</label>
                            <div>
                                <input name="code" type="text" class="form-control" placeholder="Mã câu hỏi">
                            </div>
                        </div> --}}

                        <div class="form-group" id="form-content">
                            <label for="">Nội dung câu hỏi</label>
                            <div>
                                <input name="content" type="text" class="form-control" placeholder="Nội dung câu hỏi">
                            </div>
                        </div>

                        <div class="form-group" id="form-type">
                            <label for="">Loại câu hỏi</label>
                            <div>
                                <select class="form-control" name="type">
                                    <option value="0" disabled selected>--Chọn--</option>
                                    <option value="1">Chọn 1 đáp án</option>
                                    <option value="2">Chọn nhiều đáp án</option>
                                    <option value="3">Viết câu trả lời</option>
                                </select>
                            </div>
                        </div>

                        <div class="list-answer">
                            <label for="">
                                <span>Danh sách câu trả lời </span>
                                <span class="label label-success" data-toggle="modal" data-target="#modal-default1" style="margin-left: 10px; cursor: pointer;"> Thêm đáp án</span>
                            </label>
                            <div class="answer">
                                <div></div>
                            </div>
                        </div>
                        
                        <div class="checkbox form-group" id="form-is_active">
                            <label>
                                <input type="checkbox" name="is_active" value="1"> Kích hoạt
                            </label>
                        </div>
                    </div>
                    
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <div class="btn btn-primary add-question">Add</div>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        {{-- </div> --}}
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
            
            var val = $("input[name='modal-add-answer-content']").val();

            if ($.trim(val) != '') {
                if ($('input:radio').length < 4) {
                    $('.answer > div:last-child').after("<div class='data-id-"+ data_id +"'>" +
                            "<input type='radio' class='minimal data-id-" + data_id + "' name='answer-"+ data_id +"' value='"+ val +"' checked>" + 
                            "<div class='answer-content'><p class='data-id-"+ data_id +"'>"+ val +"</p></div>" +
                            "<div class='answer-icon'><i class='fas fa-edit' data-id="+ data_id +" data-toggle='modal' data-target='#modal-default2'></i><i class='fas fa-trash-alt' data-id="+ data_id +"></i></div></div>");
                        data_id++;
                } else {
                    var message = "<div class='pad margin no-print' id='message' ><div class='alert alert-danger alert-dismissible'>"
                        +"<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4><i class='icon fa fa-check'></i> Thông báo !</h4> Tối đa 4 câu trả lời </div></div>";

                    if ( $('#message') ) {
                        $('#message').remove();
                    }

                    $('#modal-default1 .form-modal').before(message);
                }
            }
            
            
        });

        $(document).on('click', '.fa-edit', function(e) {
            var edit_id = $(this).attr('data-id');
            var value = $('p.data-id-' + edit_id).text();
            $("input[name*='modal-edit-answer-content']").val(value);
            current_id = edit_id;
        });

        $(document).on('click', '.btn-edit-answer', function(e) {
            var answer_content = $("input[name='modal-edit-answer-content']").val();
            $("p.data-id-" + current_id).text(answer_content);
            $("input.data-id-" + current_id).val(answer_content);
            $('#modal-default2').modal('hide');
        });

        $(document).on('click', '.fa-trash-alt', function(e) {
            var delete_id = $(this).attr('data-id');
            $('div.data-id-' + delete_id).remove();
        });

        $("select[name='type']").change(function(e) {
            if ($(this).val() == 3)
                $('.list-answer').hide();
            else
                $('.list-answer').show();
        });

        $('.add-question').click(function (e) {
            // var code = $("input[name='code']").val();
            var content = $("input[name='content']").val();
            var type =  $("select[name='type']").val();
            var is_active = ( $("input[name*='is_active']").is(':checked') ) ? 1 : 0;
            var answers = [];

            $('input:radio').each(function (index, value) {
                console.log(index, value.value);
                var arr_val = {
                    'value': value.value,
                    'checked': (value.checked) ? 1 : 0,
                };
                answers.push({
                    'value': value.value,
                    'checked': (value.checked) ? 1 : 0,
                });
            });

            $.ajax({
                type: "post",
                url: base_url + '/admin/question',
                data: {
                    // 'code' : code,
                    'content' : content,
                    'type' : type,
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