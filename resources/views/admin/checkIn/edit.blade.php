@extends('admin.layouts.main')

@section('css')
<link rel="stylesheet" href="backend/myCss/createForm.css">
@endsection

@section('content')

<section class="content-header">
    <h1>
        Sửa - Điểm danh ngày
        <small><a href="{{ route('admin.checkIn.index') }}" class="" style="cursor: pointer">Quay lại</a></small>
    </h1>

</section>

<section class="content">
    <div class="row">

        <div class="col-xs-12">
            <div class="box">
                {{-- <div class="box-header">
                </div>
                <!-- /.box-header --> --}}
                <div class="box-body">
                    <div style="display: flex; justify-content: space-between">
                        <h3 class="box-title" style="margin-top: 10px">Danh sách học viên</h3>
                        <div style="display: flex; align-items: flex-end">
                            <div class="btn btn-info btn-save" title="" data-id="{{ $lesson->id }}">Thay đổi</div>
                        </div>
                    </div>
                    <div class="">
                        <label for="phone" class="form-label">Ghi chú hôm nay</label>
                        <textarea name="" id="note" cols="" rows="5" class="form-control">{{ $lesson->note }}</textarea>
                    </div>
                    <table class="table-hover table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Tên học viên</th>
                                <th class="text-center">Ngày sinh</th>
                                <th class="text-center">Trạng thái</th>
                                {{-- <th class="text-center">Hành động</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $key => $student)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-center">{{ $student->name }}</td>
                                <td class="text-center">{{ $student->date_of_birth }}</td>
                                {{-- <td class="text-center"></td> --}}
                                <td class="text-center">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input input-info" name="{{$student->id}}" data-id="{{$checkIn_id[$student->id]}}" value="1" {{ ($checkIn_check[$student->id] == 1) ? 'checked' : '' }}>
                                        <input type="radio" class="form-check-input input-danger" name="{{$student->id}}" data-id="{{$checkIn_id[$student->id]}}" value="2" {{ ($checkIn_check[$student->id] == 2) ? 'checked' : '' }}>
                                        <input type="radio" class="form-check-input input-warning" name="{{$student->id}}" data-id="{{$checkIn_id[$student->id]}}" value="3" {{ ($checkIn_check[$student->id] == 3) ? 'checked' : '' }}>    
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>
                <!-- /.box-body -->
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

        $(document).on('click', '.btn-save', function (e) {

            var lesson_id = $(this).attr('data-id');

            var inputs_checkIn = $("input:checked");

            var note = $('#note').val();

            // console.log(inputs_checkIn);

            var checkIn = {};

            inputs_checkIn.each( function (index, value) {
                console.log(index, value.value, value.name);
                checkIn[index] = { 'lesson_id' : $(this).attr('data-id') , 'val': value.value , 'user_id' : $(this).attr('name')};
                // checkIn[index] = Object.assign({}, [$(this).attr('data-id'), value.value ]);

            });

            console.log(checkIn);

            var data = {
                checkIn : checkIn,
                note : note
            };

            $.ajax({
                type: 'PUT',
                url: base_url + '/admin/checkIn/' + lesson_id,
                data: data,
                dataType : 'json',

                success: function (response) {
                    // console.log(response);
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
