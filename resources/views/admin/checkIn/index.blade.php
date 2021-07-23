@extends('admin.layouts.main')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('content')
<section class="content-header">
    <h1>
        Quản lý điểm danh
        {{-- <small><a href="{{ route('admin.question.create') }}">Thêm mới</a></small> --}}
    </h1>
</section>

<section class="content">
    <div class="row">

        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group" id="form-subject_id">
                                <label>Chọn môn học</label>
                                <div>
                                    <select class="form-control" name="course" id="subject_id">
                                        <option value="">-- Chọn --</option>
                                        @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" id="form-course_id">
                                <label>Chọn Khóa học</label>
                                <div>
                                    <select class="form-control" name="course" id="course_id">
                                        <option value="">-- Chọn --</option>
                                       
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" id="form-class_id">
                                <label>Chọn Lớp học</label>
                                <div>
                                    <select class="form-control" name="course" id="class_id">
                                        <option value="">-- Chọn --</option>
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="box-title">Danh sách điểm danh</h3>

                    <table class="table-hover table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Ngày bắt đầu</th>
                                <th class="text-center">Thời gian</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- <tr class="item-">
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center">
                                    <a href=""
                                        class="btn btn-success" title="Sửa">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr> --}}
                        </tbody>
                        <tfoot>

                        </tfoot>
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
<script src="backend/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>

    // $(function () {

        // $('#example1').DataTable();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // let courses = '';

        $(document).on('change', '#subject_id', function () {
           console.log($(this).val());

           var subject_id = $(this).val();
           
           $.ajax({
                type: "get",
                url: base_url + '/admin/checkIn/getCourses/' + subject_id,
                data: {},
                dataType: "json",
                success: function (response) {
                    courses = response.courses;
                    // console.log(courses);
                    var html = '<option value="">-- Chọn --</option>';

                    courses.forEach(function (value, index) {
                        html += '<option value="'+ value.id +'">'+ value.name +'</option>';
                    });

                    // console.log(html);

                    $('#course_id').html(html);
                }
            });
        });

        $(document).on('change', '#course_id', function (e) {
            var course_id = $(this).val();

            $.ajax({
                type: "get",
                url: base_url + '/admin/checkIn/getClasses/' + course_id,
                data: {},
                dataType: "json",
                success: function (response) {
                    var classes = response.classes;
                    // console.log(courses);
                    var html = '<option value="">-- Chọn --</option>';

                    classes.forEach(function (value, index) {
                        html += '<option value="'+ value.id +'">'+ value.name +'</option>';
                    });

                    $('#class_id').html(html);
                }
            });
        });

        $(document).on('change', '#class_id', function (e) {
            var class_id = $(this).val();

            $.ajax({
                type: "get",
                url: base_url + '/admin/checkIn/getLessons/' + class_id,
                data: {},
                dataType: "json",
                success: function (response) {
                    var lessons = response.lessons;
                    console.log(lessons);
                    var html = '';

                    lessons.forEach(function (value, index) {
                        html += '<tr class="item-"><td class="text-center">'+ (index * 1 + 1) +'</td>'
                            +'<td class="text-center">'+ value.start_at +'</td>'
                            +'<td class="text-center">'+ value.time_limit +'</td>'
                            +'<td class="text-center">'+ value.is_active +'</td>'
                            +'<td class="text-center"><a href="'+ base_url +'/admin/checkIn/'+ value.id +'/edit" class="btn btn-success" title="Sửa">'
                            +'<i class="fa fa-edit"></i></a></td></tr>';
                    });

                    $('tbody').html(html);
                }
            });
        });

    // });

</script>
@endsection
