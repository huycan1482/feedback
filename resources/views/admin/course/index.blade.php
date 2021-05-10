@extends('admin.layouts.main')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('content')
<section class="content-header">
    <h1>
        Quản lý danh sách Khóa học
        <small><a href="{{ route('admin.course.create') }}">Thêm mới</a></small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog" style="">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Thông tin chi tiết Khóa học</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="box box-info">
                                    <div class="box-header">
                                        <h4>Thông tin chung</h4>
                                    </div>
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table-hover table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                            <tbody>
                                                <tr style="width: 100%">
                                                    <td class="" style="width: 30%">
                                                        Tên khóa:
                                                    </td>
                                                    <td class="modal-course-name" style="width: 70%">

                                                    </td>
                                                </tr>
                                                <tr style="width: 100%">
                                                    <td class="" style="width: 30%">
                                                        Mã khóa học:
                                                    </td>
                                                    <td class="modal-course-code" style="width: 70%">

                                                    </td>
                                                </tr>
                                                <tr style="width: 100%">
                                                    <td class="" style="width: 30%">
                                                        Tổng số buổi học:
                                                    </td>
                                                    <td class="modal-course-total" style="width: 70%">

                                                    </td>
                                                </tr>
                                                <tr style="width: 100%">
                                                    <td class="" style="width: 30%">
                                                        Kích hoạt:
                                                    </td>
                                                    <td class="modal-course-active" style="width: 70%">

                                                    </td>
                                                </tr>
                                                <tr style="width: 100%">
                                                    <td class="" style="width: 30%">
                                                        Người tạo:
                                                    </td>
                                                    <td class="modal-course-userCreate" style="width: 70%">

                                                    </td>
                                                </tr>
                                                <tr style="width: 100%">
                                                    <td class="" style="width: 30%">
                                                        Ngày tạo:
                                                    </td>
                                                    <td class="modal-course-createdAt" style="width: 70%">

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-7">
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h4>Thông tin lớp học liên quan</h4>
                                    </div>
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table-hover table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">STT</th>
                                                    <th class="text-center">Lớp</th>
                                                    <th class="text-center">Môn học</th>
                                                    <th class="text-center">Giảng viên</th>
                                                    <th class="text-center">Trạng thái</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-class">
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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

        
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    {{-- <h3 class="box-title">Data Table With Full Features</h3> --}}
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Tên</th>
                                <th class="text-center">Mã Khóa học</th>
                                <th class="text-center">Môn học</th>
                                <th class="text-center">Người tạo</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $key => $course)
                            <tr class="item-{{ $course->id }}">
                                <td class="text-center">{{ $key + 1}}</td>
                                <td class="text-center">{{ $course->name }}</td>
                                <td class="text-center">{{ $course->code }}</td>
                                <td class="text-center">{{ $course->subject->name }}</td>
                                <td class="text-center"></td>
                                <td class="text-center">
                                    <span class="label label-{{ ($course->is_active == 1) ? 'success' : 'danger' }}">{{ ($course->is_active == 1) ? 'Hiển thị' : 'Ẩn' }}</span>
                                </td>
                                <td class="text-center">

                                    <button type="button" class="btn btn-warning btn-detail" data-toggle="modal" data-target="#modal-default" title="Chi tiết" data-id="{{$course->id}}">
                                        <i class="fas fa-cog"></i>
                                    </button>

                                    <a href="{{ route('admin.course.edit', ['id'=> $course->id]) }}" class="btn btn-success" title="Sửa">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <a href="javascript:void(0)" class="btn btn-danger" onclick="destroyModel('course', '{{ $course->id }}' )" title="Xóa">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            {{-- <tr>
                                <th>STT</th>
                                <th>Nội dung</th>
                                <th></th>
                                <th>Trạng thái</th>
                                <th>Người tạo</th>
                                <th>Hành động</th>
                            </tr> --}}
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
    $(function() {
        $('#example1').DataTable();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.btn-detail', function(){
            var itemId = $(this).attr('data-id');
            $.ajax({
                type: "get",
                url: base_url + '/admin/course/' + itemId,
                data: {},
                dataType: "json",
                success: function (response) {
                    var html = '';
                    // console.log(response.course, response.data);
                    
                    $('.modal-course-name').html(response.course.name);
                    $('.modal-course-code').html(response.course.code);
                    $('.modal-course-total').html(response.course.total_lesson);
                    if ( response.course.is_active == 1 ) {
                        $('.modal-course-active').html('<span class="label label-success">Kích hoạt</span>');
                    } else {
                        $('.modal-course-active').html('<span class="label label-success">Ẩn</span>');
                    }

                    response.data.forEach( function (value, index) {
                        html += "<tr><td class='text-center'>"+ (index + 1) +"</td>"+
                                "<td class='text-center'>"+ value.class +"</td>"+ 
                                "<td class='text-center'>"+ value.subject +"</td>"+ 
                                "<td class='text-center'>"+ value.teacher +"</td>";

                        // if (value.active == 1) {
                        //     html+= '<td class="text-center">Hiển thị</td></tr>';
                        // } else {
                        //     html+= '<td class="text-center">Ẩn</td></tr>';
                        // }

                        (value.active == 1) ? html+= '<td class="text-center"><span class="label label-success">Kích hoạt</span></td></tr>' 
                            : html+= '<td class="text-center"><span class="label label-danger">Ẩn</span></td></tr>';
                    });


                    $('.table-class').html(html);

                    
                }
            });
        })

    })
</script>
@endsection