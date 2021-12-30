@extends('admin.layouts.main')

@section('css')
  <!-- Theme style -->
  <link rel="stylesheet" href="backend/dist/css/AdminLTE.min.css">
@endsection

@section('content')

<section class="content-header">
    <h1>
        Thêm - Bài khảo sát
        <small><a href="{{ route('admin.survey.index') }}">Danh sách</a></small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-7">
            <!-- general form elements -->

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin Chung</h3>
                    {{-- <a href="#" class="btn btn-danger">Thêm lớp học</a> --}}
                </div>
                <!-- /.box-header -->

                <form enctype="multipart/form-data">
                    <div class="box-body">

                        <div class="form-group" id="form-feedback_id">
                            <label>Chọn bài khảo sát</label>
                            <div>
                                <select class="form-control" id="feedback_id" name="feedback_id">
                                    <option value="" disabled selected>-- Chọn --</option>
                                    @foreach($feedbacks as $feedback)
                                    <option value="{{ $feedback->id }}">{{ $feedback->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="form-start_at">
                            <label for="">Ngày bắt đầu</label>
                            <div>
                                <input name="start_at" type="date" class="form-control" placeholder="Ngày bắt đầu">
                            </div>
                        </div>

                        <div class="form-group" id="form-end_at">
                            <label for="">Ngày kết thúc</label>
                            <div>
                                <input name="end_at" type="date" class="form-control" placeholder="Ngày kết thúc">
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
                        <div class="btn btn-info add-survey">Add</div>
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

        $('.select2').select2();

        $('.datepicker').datepicker({
            // autoclose: false,
            format: 'dd-mm-yyyy',
            forceParse: false,
        })

        $(document).on('change', '#course_id', function(e) { 
            var itemId = $(this).val();
            if (itemId != '') {
                $.ajax({
                    type: "get",
                    url: base_url + '/admin/course/' + itemId,
                    data: {},
                    dataType: "json",
                    success: function (response) {

                        var html = '';

                        response.data.forEach(function (value, index) {

                            html += "<option value='"+ value.classId +"'>"+ value.class + "</option>";

                        });

                        $('#form-classRoom_id').show();

                        $('#classRoom_id').html(html);
                    }
                });
            }
        });

        $('.add-survey').click(function (e) {
            var feedback_id = $("#feedback_id").val();
            var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;

            if ($("input[name='start_at']").val() != '') { 
                var date = $("input[name='start_at']").val().split('-');
                console.log(date);
                var start_at = date[0] + '/' + date[1] + '/' + date[2];
            }

            if ($("input[name='end_at']").val() != '') { 
                var date = $("input[name='end_at']").val().split('-');
                var end_at = date[0] + '/' + date[1] + '/' + date[2];
            }
             
            var data = { 
                'feedback_id': feedback_id, 
                'start_at': start_at,
                'end_at': end_at, 
                'is_active': is_active,
            };

            var model = '/admin/survey';

            addModel(model, data);
        }); 

        
    });
    
</script>


@endsection