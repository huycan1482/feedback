<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed back</title>

    <link rel="stylesheet" href="feedback/fontawesome-free-5.12.0-web/css/all.min.css">
    <!-- FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="feedback/css/layout.css">
    <!-- Box -->
    <link rel="stylesheet" href="feedback/css/box.css">
    <!-- Css Layout -->
    <link rel="stylesheet" href="feedback/css/login.css">
</head>

<body>

    <div class="body-wrapper">
        <div class="scroll-up">
            <i class="fas fa-chevron-up"></i>
        </div>

        <div class="content">
            <div class="main-content">
                <div class="box">
                    <div class="box-header">
                        <i class="fas fa-graduation-cap"></i>
                        <p class="box-title">
                            Hệ thống đánh giá <br>
                            Giảng viên
                        </p>
                        <!-- <button>Facebook</button>
                        <button>Google</button> -->
                    </div>

                    <div class="box-body">
                        <form action="{{route('user.postUserLogin')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{old('email')}}">
                                <span class="error-text">{{$errors->first('email')}}</span>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="password" placeholder="Password" name="password" value="{{old('password')}}">
                                <span class="error-text">{{$errors->first('password')}}</span>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                            </div>
                            
                            <p class="error-alert"></p>

                            <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                        </form>
                    </div>

                    <div class="box-footer">
                        <a href="">Lấy lại mật khẩu</a>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- JQuery -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>
    <!-- Bootstrap -->

    <script src="feedback/js/layout.js"></script>
    <!-- LayoutJS -->

    <script src="feedback/js/box.js"></script>
    <!-- BoxJS -->
</body>

</html>