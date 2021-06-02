<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="{{ asset('') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Feed Back</title>

    <link rel="stylesheet" href="feedback/fontawesome-free-5.12.0-web/css/all.min.css">
    <!-- FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="feedback/css/layout.css">
    <!-- Css Layout -->

    @yield('css')

    <script type="text/javascript">
        var base_url = '{{ url('/') }}';
    </script>
</head>

<body>
    <div class="body-wrapper">

        @include('feedback.layouts.header')

        <div class="scroll-up">
            <i class="fas fa-chevron-up"></i>
        </div>

        <div class="content">
            @yield('content')
        </div>
        
        @include('feedback.layouts.footer')
        
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- JQuery -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>
    <!-- Bootstrap -->

    <script src="feedback/js/layout.js"></script>
    <!-- LayoutJS -->

    @yield('js')
</body>

</html>