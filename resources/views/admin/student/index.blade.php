@extends('admin.layouts.main')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('content')
<section class="content-header">
    <h1>
        Quản lý danh sách Học viên
        <small><a href="{{ route('admin.student.create') }}">Thêm mới</a></small>
    </h1>
</section>

<section class="content">
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Thông tin chi tiết Học viên</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="box box-info">
                                <div class="box-header">
                                    <h4>Thông tin chung</h4>
                                </div>
                                <div class="box-body table-responsive no-padding">
                                    <table class="table-hover table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info" style="margin-top: 0 !important;">
                                        <tbody>
                                            <tr style="width: 100%">
                                                <td class="" style="width: 30%">
                                                    Tên người dùng:
                                                </td>
                                                <td class="modal-user-name" style="width: 70%">

                                                </td>
                                            </tr>
                                            <tr style="width: 100%">
                                                <td class="" style="width: 30%">
                                                    Mã người dùng:
                                                </td>
                                                <td class="modal-user-identity" style="width: 70%">

                                                </td>
                                            </tr>
                                            <tr style="width: 100%">
                                                <td class="" style="width: 30%">
                                                    Email:
                                                </td>
                                                <td class="modal-user-email" style="width: 70%">

                                                </td>
                                            </tr>
                                            <tr style="width: 100%">
                                                <td class="" style="width: 30%">
                                                    SĐT:
                                                </td>
                                                <td class="modal-user-phone" style="width: 70%">

                                                </td>
                                            </tr>
                                            <tr style="width: 100%">
                                                <td class="" style="width: 30%">
                                                    Ngày sinh:
                                                </td>
                                                <td class="modal-user-birth" style="width: 70%">

                                                </td>
                                            </tr>
                                            <tr style="width: 100%">
                                                <td class="" style="width: 30%">
                                                    Chứng minh thư:
                                                </td>
                                                <td class="modal-user-code" style="width: 70%">

                                                </td>
                                            </tr>
                                            <tr style="width: 100%">
                                                <td class="" style="width: 30%">
                                                    Địa chỉ
                                                </td>
                                                <td class="modal-user-address" style="width: 70%">

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h4>Thông tin lớp học</h4>
                                </div>
                                <div class="box-body table-responsive no-padding">
                                    <table class="table-hover table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                        <thead>
                                            <th>STT</th>
                                            <th>Tên Lớp</th>
                                            <th>Mã khóa</th>
                                            <th>Mã môn</th>
                                            <th>Tình trạng</th>
                                        </thead>
                                        <tbody class="modal-student-data">

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
    <div class="row">
        <div class="col-lg-12">
            
            <div class="custom-import">

                <form action="{{ route('admin.import.importTest') }}" method="POST" name="importform" enctype="multipart/form-data">
                    @csrf
                    {{-- <a href="{{ route('admin.import.importTest') }}" class="label-type-file btn btn-success">Import file</a> --}}
                    <input name="import_file" type="file" class="input-type-file" id="import-file">
                    <button href="{{ route('admin.import.importTest') }}" class="label-type-file btn btn-success">Import file</button>
                </form>
    
                {{-- <label class="label-type-file btn btn-info" for="">Export file</label>
                <input name="" type="file" class="input-type-file" id="export-file"> --}}
            </div>
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
                                <th class="text-center">Mã người dùng</th>
                                <th class="text-center">SĐT</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $key => $student)
                            <tr class="item-{{ $student->id }}">
                                <td class="text-center">{{ $key + 1}}</td>
                                <td class="text-center">{{ $student->name }}</td>
                                <td class="text-center">{{ $student->indentity_code }}</td>
                                <td class="text-center">{{ $student->phone }}</td>
                                <td class="text-center">{{ $student->email }}</td>
                                <td class="text-center">
                                    <span class="label label-{{ ($student->is_active == 1) ? 'success' : 'danger' }}">{{ ($student->is_active == 1) ? 'Hiển thị' : 'Ẩn' }}</span>
                                </td>
                                <td class="text-center">

                                    <button type="button" class="btn btn-warning btn-detail" data-toggle="modal" data-target="#modal-default" title="Chi tiết" data-id="{{$student->id}}">
                                        <i class="fas fa-cog"></i>
                                    </button>

                                    <a href="{{ route('admin.student.edit', ['id'=> $student->id]) }}" class="btn btn-success" title="Sửa">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <a href="javascript:void(0)" class="btn btn-danger" onclick="destroyModel('student', '{{ $student->id }}' )" title="Xóa">
                                        <i class="fa fa-trash"></i>
                                    </a>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>

                    @can('forceDelete', App\User::class)
                    <div>
                        <h3 style="display: inline; margin-right: 5px">Danh sách đã bị xóa </h3>
                        <small>(Tải lại sau khi xóa mềm)</small>
                    </div>

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Tên</th>
                                <th class="text-center">Mã người dùng</th>
                                <th class="text-center">SĐT</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($studentsWithTrashed as $key => $student)
                            <tr class="item-{{ $student->id }}">
                                <td class="text-center">{{ $key + 1}}</td>
                                <td class="text-center">{{ $student->name }}</td>
                                <td class="text-center">{{ $student->identity_code }}</td>
                                <td class="text-center">{{ $student->phone }}</td>
                                <td class="text-center">{{ $student->email }}</td>
                                <td class="text-center">
                                    <span class="label label-{{ ($student->is_active == 1) ? 'success' : 'danger' }}">{{ ($student->is_active == 1) ? 'Hiển thị' : 'Ẩn' }}</span>
                                </td>
                                <td class="text-center">

                                    <a href="javascript:void(0)" onclick="restore('student/restore', '{{ $student->id }}' )" class="btn btn-primary" title="Khôi phục">
                                        <i class="fas fa-trash-restore"></i>
                                    </a>

                                    <a href="javascript:void(0)" onclick = "forceDelete('student/forceDelete', '{{ $student->id }}' )" class="btn btn-danger" title="Xóa">
                                        <i class="fas fa-ban"></i>
                                    </a>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                    @endcan
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
                url: base_url + '/admin/student/' + itemId,
                data: {},
                dataType: "json",
                success: function (response) {

                    $('.modal-user-name').html(response.student.name);
                    $('.modal-user-identity').html(response.student.identity_code);
                    $('.modal-user-email').html(response.student.email);
                    $('.modal-user-phone').html(response.student.phone);
                    $('.modal-user-birth').html(response.student.date_of_birth);
                    $('.modal-user-code').html(response.student.code);
                    $('.modal-user-address').html(response.student.address);

                    var html = '';

                    response.data.forEach(function (value, index) {
                        var status = '';
                        var start_at = new Date(value.start_at);
                        var end_at = new Date(value.end_at);
                        if ( value.is_active == 0 ) {
                            status = '<span class="label label-danger"> Hủy </span>';
                        } else if ( $.now() < (1 * value.start_at) ) {
                            status = '<span class="label label-warning"> Chờ học </span>';
                        } else if ( $.now() < (1 * value.end_at) ) {
                            status = '<span class="label label-success"> Đang học </span>';
                        } else {
                            console.log( $.now() , 1 * value.end_at);

                            status = '<span class="label label-danger"> Hoàn thành </span>';
                        }

                        html += "<tr style='width: 100%'><td>"+ (index + 1)  +"</td><td>"+ value.class +"</td>" + 
                                "<td>"+ value.course +"</td><td>"+ value.subject +"</td>" +
                                "<td>"+ status +"</td></tr>";
                    });

                    $('.modal-student-data').html(html);
                }
            });
        })

    })
</script>
@endsection