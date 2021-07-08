@extends('admin.layouts.main')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('content')
<section class="content-header">
    <h1>
        Thông tin lớp học Giảng viên {{$checkTeacher->name}}
        {{-- <small><a href="{{ route('admin.teacher.create') }}">Thêm mới</a></small> --}}
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
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
                                <th class="text-center">Số học sinh</th>
                                <th class="text-center">Số bài đánh giá</th>
                                <th class="text-center">Độ tín nhiệm</th>
                                <th class="text-center">Xem chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classes as $key => $class)
                            <tr class="item-{{ $class->id }}">
                                <td class="text-center">{{ $key + 1}}</td>
                                <td class="text-center">{{ $class->name }}</td>
                                <td class="text-center">{{ $class->user_class->count() }}</td>
                                <td class="text-center">{{ $class->feedback->count() }}</td>
                                <td class="text-center">{{ $results[$class->id] }}%</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.getClassFeedbacks', [ 'id' => $class->id ]) }}" class="btn btn-warning btn-detail" title="Chi tiết">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
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
    $(function() {
        $('#example1').DataTable();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    })
</script>
@endsection