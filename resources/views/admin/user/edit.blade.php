@extends('admin.layouts.main')

@section('content')

<section class="content-header">
    <h1>
        Sửa - Người dùng
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
                <form role="form" enctype="multipart/form-data">
                    <div class="box-body">

                        <div class="form-group" id="form-name">
                            <label for="">Tên người dùng</label>
                            <input name="name" type="text" class="form-control" placeholder="Tên người dùng" value="{{$user->name}}">
                        </div>

                        <div class="form-group" id="form-eamil">
                            <label for="">Email</label>
                            <input name="email" type="email" class="form-control" placeholder="Email" value="{{$user->email}}"
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
                                <option value="{{ $role->id }}" {{ ($user->role_id == $role->id) ? ' selected' : ''}}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                    </div>
                    
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="btn btn-primary btn-update-user" data-id="{{$user->id}}">Update</div>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </div>
                </form>
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
        $('.btn-update-user').click( function () {
            var name = $("input[name='name']").val();
            var code = $("input[name='code']").val(); 
            var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;
            var data = { 
                name : name,
                code : code,
                is_active : is_active
            };

            var model = '/admin/user/' + $(this).attr('data-id');

            updateModel(model, data);
        });


    });

    

    
</script>

@endsection