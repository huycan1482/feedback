@extends('admin.layouts.main')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('content')
<section class="content-header">
    <h1>
        Thông tin chi tiết bài đánh giá {{$checkFeedback->feedback->name}}
        <small><a class="btn-return" style="cursor: pointer">Quay lại</a></small>
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
                                <th class="text-center">Tên học sinh</th>
                                <th class="text-center">Góp ý</th>
                                <th class="text-center">Độ tín nhiệm</th>
                                <th class="text-center">Xem chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feedbackDetails as $key => $item)
                            <tr class="item-{{ $item->id }}">
                                <td class="text-center">{{ $key + 1}}</td>
                                <td class="text-center">{{ $item->student->name }}</td>
                                <td class="text-center">{{ str_limit($item->opinion, 20) }}</td>
                                <td class="text-center">{{ $results[$item->id] }}%</td>
                                <td class="text-center">
                                    <a href="" class="btn btn-warning btn-detail" title="Chi tiết">
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

        $('.btn-return').click(function (e) {
            history.back();
        });
    })
</script>
@endsection