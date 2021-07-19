@extends('admin.layouts.main')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('content')
<section class="content-header">
    <h1>
        Kích hoạt bài đánh giá lớp {{ $feedbackDetails->first()->class->name }}
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
                                <th class="text-center">Tên bài đánh giá</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Thay đổi trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feedbackDetails as $key => $feedbackDetail)
                            <tr class="item-{{ $feedbackDetail->id }}">
                                <td class="text-center">{{ $key + 1}}</td>
                                <td class="text-center">{{ $feedbackDetail->feedback->name }}</td>
                                <td class="text-center"><span class="label label-{{ ($feedbackDetail->is_active == 1) ? 'success' : 'danger' }}">{{ ($feedbackDetail->is_active == 1) ? 'Hiển thị' : 'Ẩn' }}</span></td>
                                <td class="text-center">
                                    <a class="btn btn-success btn-edit" title="Thay đổi trạng thái" data-id="{{ $feedbackDetail->id }}">
                                        <i class="fas fa-edit"></i>
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

        $(document).on('click', '.btn-edit', function (e) {
            // var result = confirm("Bạn có chắc chắn muốn khôi phục bản ghi ?");
            // if (result) { 
                var id = $(this).attr('data-id');
                $.ajax({
                    url: base_url + '/admin/activeFeedback/'+id,
                    type: 'GET',
                    data: {}, 
                    dataType: "json", 
                    success: function (response) { 
                        // $('.item-'+id).closest('label').html('');
                        messageReload('success', response.mess, 'Tải lại sau 1,5s');
                        setTimeout(function (){
                            location.reload()
                        }, 1500);
                    },
                    error: function (e) { 
                        messageReload('danger', e.responseJSON.mess, 'Tải lại sau 1,5s');
                    }
                });
            // }
        });
    })
</script>
@endsection