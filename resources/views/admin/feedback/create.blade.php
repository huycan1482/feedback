@extends('admin.layouts.main')

@section('css')
  <!-- DataTables -->
<link rel="stylesheet" href="backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('content')

<section class="content-header">
    <h1>
        Thêm - Bài đánh giá
        <small><a href="{{ route('admin.question.index') }}">Danh sách</a></small>
    </h1>
</section>

<div class="modal fade" id="modal-default">
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

<section class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Thêm câu hỏi</h3>
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
    
                                    <button type="button" class="btn btn-warning btn-detail" data-toggle="modal" data-target="#modal-default" title="Chi tiết" data-id="{{$question->id}}">
                                        <i class="fas fa-cog"></i>
                                    </button>
    
                                 </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
    
                        </tfoot>
                    </table>
                    <div id="form-question_id">
                        <h3 class="" style="font-size: 18px;padding-top: 25px; border-top: 1px solid #17a2b8" >Danh sách câu hỏi được thêm</h3>
                        <div class="table-responsive no-padding">
                            <table class="table-hover table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                <thead>
                                    <tr>
                                        <th class="text-center">STT</th>
                                        <th class="text-center">Mã câu hỏi</th>
                                        <th class="text-center">Nội dung</th>
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <!-- Lặp một mảng dữ liệu pass sang view để hiển thị -->
                                <tbody class="list-questions">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="btn btn-primary add-feedback">Add</div>
                    <button type="reset" class="btn btn-danger">Reset</button>
                </div>
            </div>

        </div>
        <div class="col-md-4">
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
                                <input name="name" type="text" class="form-control" placeholder="Tên bài đánh giá">
                            </div>
                        </div>

                        <div class="form-group" id="form-code">
                            <label for="">Mã bài đánh giá</label>
                            <div>
                                <input name="code" type="text" class="form-control" placeholder="Mã bài đánh giá">
                            </div>
                        </div>

                        <div class="form-group " id="form-start_at">
                            <label for="">Ngày bắt đầu</label>
                            <div>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right datepicker" name="start_at" placeholder="DD-MM-YYYY">
                                </div>
                            </div>
                        </div>

                        <div class="form-group " id="form-end_at">
                            <label for="">Ngày kết thúc</label>
                            <div>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right datepicker" name="end_at" placeholder="DD-MM-YYYY">
                                </div>
                            </div>
                        </div>

                        <div class="checkbox form-group">
                            <label>
                                <input type="checkbox" name="is_active" id="is_active"> Kích hoạt
                            </label>
                        </div>
                        
                    </form>
                </div>
                    
                <!-- /.box-body -->

                
                
            </div>
            <!-- /.box -->
            

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

        var index = 1;

        var questions = [];

        $(document).on('click', '.btn-add-question', function (e) {

            if ( jQuery.inArray( $(this).attr('data-id'), questions) != -1 ) {

            } else {
                var code_question = $('.item-' + $(this).attr('data-id')).children('td:nth-child(2)').text();
                var content_question = $('.item-' + $(this).attr('data-id')).children('td:nth-child(3)').text();

                html = "<tr class=question-"+ $(this).attr('data-id') +"><td class='text-center'>"+ index +"</td><td class='text-center'>"+ 
                    code_question +"</td><td class='text-center'>"+ content_question +"</td><td class='text-center'>"+
                    "<div class='btn btn-danger btn-del-question' data-id='"+ $(this).attr('data-id') +"' title='Xóa'><i class='fa fa-trash'></i></div></td><tr>";

                $('.list-questions').append(html);

                index++;

                questions.push($(this).attr('data-id'));

                $('.item-' + $(this).attr('data-id')).css('display', 'none');
            }  
            
        });

        $(document).on('click', '.btn-del-question', function(e) {
            $('.item-' + $(this).attr('data-id')).css('display', '');
            $('.question-'+ $(this).attr('data-id')).remove();

            answers = answers.filter(item => item != $(this).attr('data-id'));
        });

        $(document).on('click', '.add-feedback', function (e) {
            var questionsId = [];
            var name = $('[name="name"]').val();
            var code = $('[name="code"]').val();
            var start_at = '';
            var end_at = '';
            var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;

            if ($("input[name='start_at']").val() != '') { 
                var date_start_at = $("input[name='start_at']").val().split('-');
                var start_at = date_start_at[2] + '-' + date_start_at[1] + '-' + date_start_at[0];
            }

            if ($("input[name='end_at']").val() != '') { 
                var date_end_at = $("input[name='end_at']").val().split('-');
                var end_at = date_end_at[2] + '-' + date_end_at[1] + '-' + date_end_at[0];
            }

            $('[class*="question-"]').children('td:last-child').each(function (index, value) {
                questionsId.push($(this).children('div').attr('data-id'));
            });

            data = {
                name: name,
                code: code,
                start_at: start_at,
                end_at: end_at,
                is_active : is_active,
                question_id : questionsId
            };

            var model = '/admin/feedback';

            addModel(model, data);

        });

  
    });

    

    
</script>

@endsection