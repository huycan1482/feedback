@extends('admin.layouts.main')

@section('css')
  <!-- Theme style -->
  <link rel="stylesheet" href="backend/dist/css/AdminLTE.min.css">
@endsection

@section('content')

<section class="content-header">
    <h1>
        Thêm - Người dùng
        <small><a href="{{ route('admin.user.index') }}">Danh sách</a></small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-8">
            <!-- general form elements -->

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin Người dùng</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {{-- {{ dd(route('admin.category.store')) }} --}}
                <form enctype="multipart/form-data">
                    <div class="box-body">

                        <div class="form-group" id="form-name">
                            <label for="">Tên người dùng</label>
                            <input name="name" type="text" class="form-control" placeholder="Tên người dùng">
                        </div>

                        <div class="form-group" id="form-eamil">
                            <label for="">Email</label>
                            <input name="email" type="email" class="form-control" placeholder="Email">
                        </div>

                        <div class="form-group" id="form-password">
                            <label for="">Mật khẩu**</label>
                            <input name="password" type="password" class="form-control" placeholder="Mật khẩu">
                        </div>

                        <div class="form-group" id="form-password_confirmation">
                            <label for="">Nhập lại mật khẩu**</label>
                            <input name="password_confirmation" type="password" class="form-control" placeholder="Nhập lại mật khẩu">
                        </div>

                        <div class="form-group" id="form-role">
                            <label>Chức năng</label>
                            <select class=" select2 form-control" style="width: 100%;" name="role" id="role">
                                @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                    </div>
                    
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <div class="btn btn-primary add-user">Add</div>
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

{{-- @section('ck_editor')
<script>
    CKEDITOR.replace('content');
    // CKEDITOR.replace('description');
</script> 
@endsection --}}

@section('my_script')
<!-- Select2 -->
<script src="backend/bower_components/select2/dist/js/select2.full.min.js"></script>

<script src="backend/js/main.js"></script>
<script>
    $(function () {

        $('.select2').select2();

        $('.add-user').click(function (e) {
            var name = $("input[name='name']").val();
            var email = $("input[name='email']").val(); 
            var password = $("input[name='password']").val(); 
            var password_confirmation = $("input[name='password_confirmation']").val(); 
            var role = $("#role").val();
            var data = { 
                name : name,
                email : email,
                password : password,
                password_confirmation : password_confirmation,
                role : role     
            };

            var model = '/admin/user';

            addModel(model, data);
        }); 

        
    });
    
</script>


@endsection