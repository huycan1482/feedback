@extends('admin.layouts.main')

@section('content')

<section class="content-header">
    <h1>
        Sửa - Môn học
        <small><a href="{{ route('admin.subject.index') }}">Danh sách</a></small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-8">
            <!-- general form elements -->

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin môn học</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" enctype="multipart/form-data">
                    <div class="box-body">

                        <div class="form-group" id="form-name">
                            <label for="">Tên môn học</label>
                            <input name="name" type="text" class="form-control" placeholder="Tên môn" value="{{ $subject->name }}">
                        </div>

                        <div class="form-group" id="form-code">
                            <label for="">Mã môn học môn học</label>
                            <input name="code" type="text" class="form-control" placeholder="Mã môn học" value="{{ $subject->code }}">
                        </div>
                        
                        <div class="checkbox form-group" id="form-is_active">
                            <label>
                                <input type="checkbox" name="is_active" value="1" {{ ($subject->is_active == 1) ? 'checked' : '' }}> Kích hoạt
                            </label>
                        </div>
                        
                    </div>
                    
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="btn btn-primary btn-update-subject" data-id="{{$subject->id}}">Update</div>
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
        $('.btn-update-subject').click( function () {
            var name = $("input[name='name']").val();
            var code = $("input[name='code']").val(); 
            var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;
            var data = { 
                name : name,
                code : code,
                is_active : is_active
            };

            var model = '/admin/subject/' + $(this).attr('data-id');

            updateModel(model, data);
        });


    });

    

    
</script>

@endsection