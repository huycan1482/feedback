@extends('admin.layouts.main')

@section('css')
  <!-- Theme style -->
  <link rel="stylesheet" href="backend/dist/css/AdminLTE.min.css">
@endsection

@section('content')

<section class="content-header">
    <h1>
        Thêm - Câu trả lời
        <small><a href="{{route('admin.answer.index')}}">Danh sách</a></small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-8">
            <!-- general form elements -->

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin bài viết</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{ route('admin.answer.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">

                        <div class="form-group">
                            <label>Câu hỏi</label>
                            <select class=" select2 form-control" style="width: 100%;" id="question_id">
                                @foreach ($questions as $question)
                                <option value="{{ $question->id }}">{{ $question->content }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="content">Nội dung câu trả lời</label>
                            <input id="content" name="content" type="text" class="form-control" placeholder="Nội dung câu trả lời">
                        </div>

                        <div class="checkbox form-group">
                            <label>
                                <input type="checkbox" name="is_active" id="is_active"> Kích hoạt
                            </label>
                        </div>

                        <div class="checkbox form-group">
                            <label>
                                <input type="checkbox" name="is_true" id="is_true"> Câu trả lời đúng
                            </label>
                        </div>
                        
                    </div>
                    
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <div class="btn btn-primary add-article">Add</div>
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
        //Initialize Select2 Elements
        $('.select2').select2();

        $('.add-article').click(function (e) {
            var question_id = $('#question'u).val();
            var content = $('#content').val();
            // var is_active = $('#is_active').is(':checked') ) ? 1 : 0;

            $.ajax({
                type: "post",
                url: base_url + '/admin/answer',
                data: {
                    'question_id' : question_id,
                    'content' : content,
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