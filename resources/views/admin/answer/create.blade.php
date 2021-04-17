@extends('admin.layouts.main')

@section('css')
  <!-- Theme style -->
  <link rel="stylesheet" href="backend/dist/css/AdminLTE.min.css">
@endsection

@section('content')

<section class="content-header">
    <h1>
        Thêm - Câu trả lời
        <small><a href="">Danh sách</a></small>
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
                {{-- {{ dd(route('admin.category.store')) }} --}}
                <form role="form" action="{{ route('answer.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                {{-- <form class=""> --}}
                    <div class="box-body">

                        <div class="form-group">
                            <label>Câu hỏi</label>
                            <select class=" select2 form-control" style="width: 100%;">
                                @foreach ($questions as $question)
                                <option value="{{ $question->id }}">{{ $question->content }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="content">Nội dung câu trả lời</label>
                            <input name="content" type="text" class="form-control" placeholder="Nội dung câu trả lời">
                        </div>

                        {{-- <div class="checkbox form-group">
                            <label>
                                <input type="checkbox" name="is_check"> Tích chọn
                            </label>
                        </div> --}}

                        
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
        $('.select2').select2()
    });
</script>

@endsection