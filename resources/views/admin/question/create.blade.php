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
        <small><a href="{{ route('question.index') }}">Danh sách</a></small>
    </h1>
</section>

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
                <form role="form" action="{{ route('question.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                {{-- <form class=""> --}}
                    <div class="box-body">

                        <div class="form-group">
                            <label for="">Nội dung câu hỏi</label>
                            <input name="" type="text" class="form-control" placeholder="Nội dung câu hỏi">
                        </div>

                        <div class="form-group">
                            <label for="content">
                                <span>Câu trả lời </span>
                                <span class="label label-danger more-answer" style="margin-left: 10px; cursor: pointer;"> Thêm đáp án</span>
                            </label>
                            <div class="answer">
                                <div></div>
                            </div>

                            <input id="content" name="content" type="text" class="form-control" placeholder="Nội dung câu hỏi">
                        </div>
                        
                        <div class="checkbox form-group">
                            <label>
                                <input type="checkbox" name="is_active" value="1"> Kích hoạt
                            </label>
                        </div>

                        
                    </div>
                    
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button class="btn btn-primary add-article">Add</button>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
            

        </div>
        {{-- <div class="col-md-4">
            <!-- general form elements -->

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin câu trả lời</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{ route('question.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">

                        <div class="form-group">
                            <label for="content">
                                <span>Câu trả lời </span>
                                <span class="label label-danger more-answer" style="margin-left: 10px; cursor: pointer;"> Thêm đáp án</span>
                            </label>
                            <div class="answer">
                                <div></div>
                            </div>

                            <input id="content" name="content" type="text" class="form-control" placeholder="Nội dung câu hỏi">
                        </div>
                        
                    </div>
                    
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button class="btn btn-primary add-article">Add</button>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
            

        </div> --}}
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

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2();

        let data_id = 1;
        let current_id = 0; 

        $('#content').keyup(function (e) { 
            // e.preventDefault();

            if ($(this).val() == '' && $('input:radio').length > 3) {
                $('.more-answer').removeClass('label-success');
                $('.more-answer').addClass('label-danger');  
            // } else if () {

            } else {
                $('.more-answer').addClass('label-success');
                $('.more-answer').removeClass('label-danger');
            }
        });

        $('.more-answer').click(function (e) { 
            var empty = $('#content').val();

            if (empty != '') {
                if ( $(this).hasClass('label-success') && $('.more-answer').text() == 'Sửa đáp án' ) {
                    $('p.data-id-' + current_id).text($('#content').val());
                    $('.more-answer').text('Thêm đáp án');
                    current_id = 0;

                    if ($('input:radio').length > 3) {
                        $('.more-answer').removeClass('label-success');
                        $('.more-answer').addClass('label-danger');  
                    }
                    
                } else if ( $(this).hasClass('label-success') ) {
                    var val = $('#content').val();
                    $('.answer > div:last-child').after("<div class='data-id-"+ data_id +"'><input type='radio' class='minimal' checked>" + 
                        "<div class='answer-content'><p class='data-id-"+ data_id +"'>"+ val +"</p></div>" +
                        "<div class='answer-icon'><i class='fas fa-edit' data-id="+ data_id +"></i><i class='fas fa-trash-alt' data-id="+ data_id +"></i></div></div>");
                    data_id++;
                    if ($('input:radio').length > 3) {
                        $('.more-answer').removeClass('label-success');
                        $('.more-answer').addClass('label-danger');  
                    }
                }   
            } else {
                $('.more-answer').removeClass('label-success');
                $('.more-answer').addClass('label-danger'); 
            }

            
            
            $('.fa-edit').click(function (e) {
                var edit_id = $(this).attr('data-id');
                var value = $('p.data-id-' + edit_id).text();
                $('#content').val(value);
                $('.more-answer').text('Sửa đáp án');
                current_id = edit_id;
                $('.more-answer').addClass('label-success');
                $('.more-answer').removeClass('label-danger');
            });

            $('.fa-trash-alt').click(function (e) {
                var delete_id = $(this).attr('data-id');
                $('div.data-id-' + delete_id).remove();
                $('.more-answer').addClass('label-success');
                $('.more-answer').removeClass('label-danger');
            });
        });
    });

    

    
</script>

@endsection