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
                                    <option value="{{ $feedback->id }}" {{ ($survey->feedback_id == $feedback->id) ? ' selected="selected"' : '' }}>{{ $feedback->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="form-start_at">
                            <label for="">Ngày bắt đầu</label>
                            <div>
                               <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right datepicker" id="start_at" name="start_at" placeholder="DD-MM-YYYY" value="{{ date_format(date_create($survey->start_at), 'd-m-Y') }}">
                                </div> 
                            </div>
                            
                        </div>

                        <div class="form-group" id="form-end_at">
                            <label for="">Ngày kết thúc</label>
                            <div>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right datepicker" id="end_at" name="end_at" placeholder="DD-MM-YYYY" value="{{ date_format(date_create($survey->end_at), 'd-m-Y') }}">
                                </div>
                            </div>
                            
                        </div>

                        <div class="checkbox form-group" id="form-is_active">
                            <label>
                                <input type="checkbox" name="is_active" value="1" {{ $survey->is_active == 1 ? 'checked' : '' }}> Kích hoạt
                            </label>
                        </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <div class="btn btn-info edit-survey" data-id="{{ $survey->id }}">Edit</div>
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

        $('.edit-survey').click(function (e) {
            var feedback_id = $("#feedback_id").val();
            var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;

            if ($("input[name='start_at']").val() != '') { 
                var date = $("input[name='start_at']").val().split('-');
                var start_at = date[2] + '/' + date[1] + '/' + date[0];
            }

            if ($("input[name='end_at']").val() != '') { 
                var date = $("input[name='end_at']").val().split('-');
                var end_at = date[2] + '/' + date[1] + '/' + date[0];
            }
             
            var data = { 
                'feedback_id': feedback_id, 
                'start_at': start_at,
                'end_at': end_at, 
                'is_active': is_active,
            };

            var model = '/admin/survey/' + $(this).attr('data-id');

            updateModel(model, data);
        }); 
    });
    
</script>


@endsection