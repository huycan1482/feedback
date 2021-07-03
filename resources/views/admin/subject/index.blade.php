@extends('admin.layouts.main')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('content')
<section class="content-header">
    <h1>
        Quản lý danh sách Môn học
        <small><a href="{{ route('admin.subject.create') }}">Thêm mới</a></small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Thông tin chi tiết câu hỏi</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box">
                            <div class="box-body table-responsive no-padding">
                                <table class="table-hover table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info" style="margin-top: 0 !important;">
                                    <tbody>
                                        <tr style="width: 100%">
                                            <td class="" style="width: 30%">
                                                Tên môn học:
                                            </td>
                                            <td class="modal-subject-name" style="width: 70%">

                                            </td>
                                        </tr>
                                        <tr style="width: 100%">
                                            <td class="" style="width: 30%">
                                                Mã môn học:
                                            </td>
                                            <td class="modal-subject-code" style="width: 70%">

                                            </td>
                                        </tr>
                                        <tr style="width: 100%">
                                            <td class="" style="width: 30%">
                                                Kích hoạt:
                                            </td>
                                            <td class="modal-subject-active" style="width: 70%">

                                            </td>
                                        </tr>
                                        <tr style="width: 100%">
                                            <td class="" style="width: 30%">
                                                Người tạo:
                                            </td>
                                            <td class="modal-subject-userCreate" style="width: 70%">

                                            </td>
                                        </tr>
                                        <tr style="width: 100%">
                                            <td class="" style="width: 30%">
                                                Ngày tạo:
                                            </td>
                                            <td class="modal-subject-createdAt" style="width: 70%">

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
                                <th class="text-center">Mã môn</th>

                                <th class="text-center">Người tạo</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $key => $subject)
                            <tr class="item-{{ $subject->id }}">
                                <td class="text-center">{{ $key + 1}}</td>
                                <td class="text-center">{{ $subject->name }}</td>
                                <td class="text-center">{{ $subject->code }}</td>
                                <td class="text-center">{{ (asset($subject->userCreate->name)) ? $subject->userCreate->name : 'Trống' }}</td>
                                <td class="text-center">
                                    <span class="label label-{{ ($subject->is_active == 1) ? 'success' : 'danger' }}">{{ ($subject->is_active == 1) ? 'Hiển thị' : 'Ẩn' }}</span>
                                </td>
                                <td class="text-center">

                                    <button type="button" class="btn btn-warning btn-detail" data-toggle="modal" data-target="#modal-default" title="Chi tiết" data-id="{{$subject->id}}">
                                        <i class="fas fa-cog"></i>
                                    </button>

                                    <a href="{{ route('admin.subject.edit', ['id'=> $subject->id]) }}" class="btn btn-success" title="Sửa">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <a href="javascript:void(0)" class="btn btn-danger" onclick="destroyModel('subject', '{{ $subject->id }}' )" title="Xóa">
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

                    @can('forceDelete', App\Subject::class)
                    <div>
                        <h3 style="display: inline; margin-right: 5px">Danh sách đã bị xóa </h3>
                        <small>(Tải lại sau khi xóa mềm)</small>
                    </div>

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Tên</th>
                                <th class="text-center">Mã môn</th>
                                <th class="text-center">Người tạo</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjectsWithTrashed as $key => $subject)
                            <tr class="item-{{ $subject->id }}">
                                <td class="text-center">{{ $key + 1}}</td>
                                <td class="text-center">{{ $subject->name }}</td>
                                <td class="text-center">{{ $subject->code }}</td>
                                <td class="text-center">{{ (asset($subject->userCreate->name)) ? $subject->userCreate->name : 'Trống' }}</td>
                                <td class="text-center">
                                    <span class="label label-{{ ($subject->is_active == 1) ? 'success' : 'danger' }}">{{ ($subject->is_active == 1) ? 'Hiển thị' : 'Ẩn' }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" onclick="restore('subject/restore', '{{ $subject->id }}' )" class="btn btn-primary" title="Khôi phục">
                                        <i class="fas fa-trash-restore"></i>
                                    </a>

                                    <a href="javascript:void(0)" onclick = "forceDelete('subject/forceDelete', '{{ $subject->id }}' )" class="btn btn-danger" title="Xóa">
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
                url: base_url + '/admin/subject/' + itemId,
                data: {},
                dataType: "json",
                success: function (response) {
                    var html = '';
                    // console.log(response.subject);
                    $('.modal-subject-name').html(response.subject.name);
                    $('.modal-subject-code').html(response.subject.code);
                    if (response.subject.is_active == 1) {
                        $('.modal-subject-active').html("<span class='label label-success'> Hiển thị </span>");
                    } else {
                        $('.modal-subject-active').html("<span class='label label-danger'> Ẩn </span>")
                    }

                    // $('.modal-subject-userCreate').html(response.subject.code);
                    $('.modal-subject-createAt').html(response.subject.created_at);

                }
            });
        })

    })
</script>
@endsection