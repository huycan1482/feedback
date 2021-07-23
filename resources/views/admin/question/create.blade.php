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

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-7">
            <!-- general form elements -->

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin câu hỏi</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {{-- {{ dd(route('admin.category.store')) }} --}}
                <form enctype="multipart/form-data">
                    <div class="box-body">

                        <div class="form-group" id="form-code">
                            <label for="">Mã câu hỏi</label>
                            <div>
                                <input name="code" type="text" class="form-control" placeholder="Mã câu hỏi">
                            </div>
                        </div>

                        <div class="form-group" id="form-content">
                            <label for="">Nội dung câu hỏi</label>
                            <div>
                                <input name="content" type="text" class="form-control" placeholder="Nội dung câu hỏi">
                            </div>
                        </div>
                        
                        <div class="checkbox form-group" id="form-is_active">
                            <label>
                                <input type="checkbox" name="is_active" value="1" checked="checked"> Kích hoạt
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
            

        </div>
        <div class="col-md-5">
            <!-- general form elements -->

            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin câu trả lời</h3>
                </div>
                <div class="box-body">
                    <div class="answer" id="form-answers">
                        <div class="form-group" id="form-answers.0.value">
                            <label for="answer_100"> Câu trả lời 1 (100%) </label>
                            <div>
                                <input id="answer_100" name="answer_100" type="text" class="form-control" placeholder="Câu trả lời 1">
                            </div>
                        </div>
                        <div class="form-group" id="form-answers.1.value">
                            <label for="answer_66"> Câu trả lời 2 (66.66%) </label>
                            <div>
                                <input id="answer_66" name="answer_66" type="text" class="form-control" placeholder="Câu trả lời 2">
                            </div>
                        </div>
                        <div class="form-group" id="form-answers.2.value">
                            <label for="answer_33"> Câu trả lời 3 (33.33%) </label>
                            <div>
                                <input id="answer_33" name="answer_33" type="text" class="form-control" placeholder="Câu trả lời 3">
                            </div>
                        </div>
                        <div class="form-group" id="form-answers.3.value">
                            <label for="answer_0"> Câu trả lời 4 (0%) </label>
                            <div>
                                <input id="answer_0" name="answer_0" type="text" class="form-control" placeholder="Câu trả lời 4">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
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
        
        

        $('.add-question').click(function (e) {
            var code = $("input[name='code']").val();
            var content = $("input[name='content']").val();
            var is_active = ( $("input[name*='is_active']").is(':checked') ) ? 1 : 0;
            var answer_100 = $('#answer_100').val();
            var answer_66 = $('#answer_66').val();
            var answer_33 = $('#answer_33').val();
            var answer_0 = $('#answer_0').val();

            // $('input:radio').each(function (index, value) {
            //     console.log(index, value.value);
            //     answers.push([
            //         value.value,
            //         (value.checked) ? 1 : 0,
            //     ]);
            // });

            var answers = [] ;
            answers.push(
                {'value' : answer_100, 'point' : 100},
                {'value' : answer_66, 'point' : 66.66},
                {'value' : answer_33, 'point' : 33.33},
                {'value' : answer_0, 'point' : 0},
            );

            $.ajax({
                type: "post",
                url: base_url + '/admin/question',
                data: {
                    'code' : code,
                    'content' : content,
                    'is_active' : is_active,
                    'answers' : answers,
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