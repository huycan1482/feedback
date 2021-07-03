@extends('admin.layouts.main')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('content')
<section class="content-header">
    <h1>
        Quản lý danh sách Nhân viên
        <small><a href="{{ route('admin.user.create') }}">Thêm mới</a></small>
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
                        <h4 class="modal-title">Thông tin chi tiết Nhân viên</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box box-info">
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
                                                Email:
                                            </td>
                                            <td class="modal-user-email" style="width: 70%">

                                            </td>
                                        </tr>
                                        <tr style="width: 100%">
                                            <td class="" style="width: 30%">
                                                Chức năng:
                                            </td>
                                            <td class="modal-user-role" style="width: 70%">

                                            </td>
                                        </tr>
                                        <tr style="width: 100%">
                                            <td class="" style="width: 30%">
                                                Ngày tạo:
                                            </td>
                                            <td class="modal-user-createdAt" style="width: 70%">

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
                    <table id="" class="table table-bordered table-striped example1">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Tên</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Chức năng</th>
                                {{-- <th class="text-center">Trạng thái</th> --}}
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key => $user)
                            <tr class="item-{{ $user->id }}">
                                <td class="text-center">{{ $key + 1}}</td>
                                <td class="text-center">{{ $user->name }}</td>
                                <td class="text-center">{{ $user->email }}</td>
                                {{-- <td class="text-center"></td> --}}
                                <td class="text-center">{{ $user->role->name }}</td>
                                {{-- <td class="text-center">
                                    <span class="label label-{{ ($user->is_active == 1) ? 'success' : 'danger' }}">{{ ($user->is_active == 1) ? 'Hiển thị' : 'Ẩn' }}</span>
                                </td> --}}
                                <td class="text-center">

                                    <button type="button" class="btn btn-warning btn-detail" data-toggle="modal" data-target="#modal-default" title="Chi tiết" data-id="{{$user->id}}">
                                        <i class="fas fa-cog"></i>
                                    </button>

                                    <a href="{{ route('admin.user.edit', ['id'=> $user->id]) }}" class="btn btn-success" title="Sửa">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <a href="javascript:void(0)" class="btn btn-danger" onclick="destroyModel('user', '{{ $user->id }}' )" title="Xóa">
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

                    @can('forceDelete', App\User::class)
                    <h3>Danh sách đã bị xóa</h3>

                    <table id="" class="table table-bordered table-striped example1">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Tên</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Chức năng</th>
                                {{-- <th class="text-center">Trạng thái</th> --}}
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usersWithTrashed as $key => $user)
                            <tr class="item-{{ $user->id }}">
                                <td class="text-center">{{ $key + 1}}</td>
                                <td class="text-center">{{ $user->name }}</td>
                                <td class="text-center">{{ $user->email }}</td>
                                <td class="text-center">{{ $user->role->name }}</td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" onclick="restore('user/restore', '{{ $user->id }}' )" class="btn btn-primary" title="Khôi phục">
                                        <i class="fas fa-trash-restore"></i>
                                    </a>

                                    <a href="javascript:void(0)" onclick = "forceDelete('user/forceDelete', '{{ $user->id }}' )" class="btn btn-danger" title="Xóa">
                                        <i class="fas fa-ban"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
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
        $('.example1').DataTable();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.btn-detail', function(){
            var itemId = $(this).attr('data-id');
            $.ajax({
                type: "get",
                url: base_url + '/admin/user/' + itemId,
                data: {},
                dataType: "json",
                success: function (response) {
                    $('.modal-user-name').html(response.user.name);
                    $('.modal-user-email').html(response.user.email);
                    $('.modal-user-role').html(response.user.role);
                    $('.modal-user-createdAt').html(response.user.created_at);

                }
            });
        })

    })
</script>
@endsection