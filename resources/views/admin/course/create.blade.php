@extends('admin.layouts.main')


@section('css')
  <!-- Theme style -->
  <link rel="stylesheet" href="backend/dist/css/AdminLTE.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="backend/plugins/timepicker/bootstrap-timepicker.min.css">
@endsection

@section('content')

<section class="content-header">
    <h1>
        Thêm - Khóa học
        <small><a href="{{ route('admin.course.index') }}">Danh sách</a></small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-8">
            <!-- general form elements -->

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin khóa học</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {{-- {{ dd(route('admin.category.store')) }} --}}
                <form enctype="multipart/form-data">
                    <div class="box-body">

                        <div class="form-group" id="form-name">
                            <label for="">Tên khóa học</label>
                            <div>
                                <input name="name" type="text" class="form-control" placeholder="Tên khóa">
                            </div>
                        </div>

                        <div class="form-group" id="form-code">
                            <label for="">Mã khóa học</label>
                            <div>
                                <input name="code" type="text" class="form-control" placeholder="Mã khóa học">
                            </div>
                        </div>

                        <div class="form-group" id="form-subject_id">
                            <label>Môn học</label>
                            <div>
                                <select class=" select2 form-control" style="width: 100%;" name="subject_id" id="subject_id">
                                    <option value="">-- Chọn --</option>
                                    @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="form-total_lesson">
                            <label for="">Tổng số buổi học</label>
                            <div>
                                <input name="total-lesson" type="number" class="form-control" placeholder="Tổng số buổi học">
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
                        <div class="btn btn-primary add-course">Add</div>
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
<!-- bootstrap time picker -->
<script src="backend/plugins/timepicker/bootstrap-timepicker.min.js"></script>

<script src="backend/js/main.js"></script>
<script>
    $(function () {

        $('.select2').select2();

        $('.datepicker').datepicker({
            // autoclose: false,
            format: 'dd-mm-yyyy',
            forceParse: false,
        })

        //Timepicker
        $('.timepicker').timepicker({
            showInputs: false,
        })

        $('.add-course').click(function (e) {
            var name = $("input[name='name']").val();
            var code = $("input[name='code']").val(); 
            var subject_id = $('#subject_id').val();
            var total_lesson = $("input[name='total-lesson']").val();
            var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;
            
            var data = { 
                name : name,
                code : code,
                subject_id : subject_id,
                total_lesson : total_lesson,
                is_active : is_active,
            };

            var model = '/admin/course';

            addModel(model, data);

        }); 

        
    });

    

    
</script>


@endsection