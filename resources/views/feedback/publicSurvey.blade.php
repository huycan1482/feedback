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
        <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" type="text/css" media="screen" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css"/>
    
    <link rel="stylesheet" href="feedback/css/layout.css">
    <!-- Css Layout -->

    <!-- Box -->
    <link rel="stylesheet" href="feedback/css/box.css">
    <!-- Css -->
    <link rel="stylesheet" href="feedback/css/feedback.css">


    <script type="text/javascript">
        var base_url = '{{ url('/') }}';
    </script>

</head>

<body>
    <div class="body-wrapper">

        <header>
            <div class="logo">
                <span>Bài khảo sát</span>
                <i class="fas fa-bars sidebar-toggle"></i>
            </div>
            <div class="navbar">
                <ul>
                    
                </ul>
                <div class="menu-account">
                    
                </div>
            </div>
            
        </header>

        <div class="scroll-up">
            <i class="fas fa-chevron-up"></i>
        </div>

        <div class="content">
            <div class="main-content">
                <div class="row">
                    <div class="col-lg-4">
            
                        <div class="box">
                            <div class="drop-box-header">
                                <p>Số lượng câu hỏi: 20 câu</p>
                                <i class="fas fa-minus"></i>
                            </div>
                            <div class="box-body list-questions">
            
                                @foreach ($data as $key => $item)
                                <a class="questions" href="{{ Request::url() }}#feedback{{$item['id']}}">
                                    {{ $key + 1 }}
                                </a> 
                                @endforeach
            
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="box">

                            <div class="box-header">
                                <p class="box-title">
                                    Bài khảo sát đánh giá Giảng viên
                                </p>
                            </div>

                            <div class="box-body">
                                <div>
                                    @foreach ($data as $key => $item)
                                    <div class="feed-back" id="feedback{{ $item['id'] }}">
                                        <div class="feedback-question">
                                            <span>{{ $key + 1 }}. ({{ $item['code'] }}): </span>{{ $item['content'] }}
                                        </div>
                                        <div class="feedback-answers">
                                            @if($item['type'] == 3)
                                            <div class=" form-group" style="">
                                                <textarea cols="30" rows="10" class="form-control" name="question_{{ $item['id'] }}" data-type="{{ $item['type'] }}"></textarea>
                                            </div>
                                            @elseif($item['type'] == 2)
                                            <div class="row">
                                                @foreach ($item['answers'] as $answer)
                                                <div class="col-lg-6 answer-items">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"name="question_{{ $item['id'] }}" id="answer_{{ $answer['id'] }}" data-type="{{ $item['type'] }}">
                                                        <label class="form-check-label" for="answer_{{ $answer['id'] }}">{{ $answer['content'] }}</label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            @else
                                            <div class="row">
                                                @foreach ($item['answers'] as $answer)
                                                <div class="col-lg-6 answer-items">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="question_{{ $item['id'] }}" id="answer_{{ $answer['id'] }}" data-type="{{ $item['type'] }}">
                                                        <label class="form-check-label" for="answer_{{ $answer['id'] }}">{{ $answer['content'] }}</label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="d-flex flex-wrap">
                                        <div class="form-group col-md-4" style="padding: 20px">
                                            <label for="identity" class="form-label">Mã người dùng</label>
                                            <input type="text" class="form-control" id="identity" placeholder="Mã người dùng nếu có">
                                        </div>
                                        <div class="form-group col-md-4" style="padding: 20px">
                                            <label for="name" class="form-label">Họ tên</label><span style="color: red">*</span>
                                            <input type="text" id="name" class="form-control" placeholder="Họ và tên" required>
                                        </div>
                                        <div class="form-group col-md-4" style="padding: 20px">
                                            <label for="phone" class="form-label">Số điện thoại</label><span style="color: red">*</span>
                                            <input type="text" id="phone" class="form-control" placeholder="Số điện thoại" required>
                                        </div>
                                        <div class="form-group col-md-6" style="padding: 20px">
                                            <label for="email" class="form-label">Email</label><span style="color: red">*</span>
                                            <input type="text" id="email" class="form-control" placeholder="Email">
                                        </div>
                                        <div class="form-group col-md-6" style="padding: 20px">
                                            <label for="address" class="form-label">Địa chỉ</label>
                                            <input type="text" id="address" class="form-control" placeholder="Địa chỉ">
                                        </div>
                                        <div class="form-group col-md-6" style="padding: 20px">
                                            <label for="facebook_link" class="form-label">Link Facebook</label>
                                            <input type="text" id="facebook_link" class="form-control" placeholder="Link Facebook">
                                        </div>
                                    </div>
                                    <div class=" form-group" style="padding: 20px">
                                        <label for="phone" class="form-label">Góp ý:</label>
                                        <textarea name="" id="note" cols="30" rows="10" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <div style="margin: 20px; display: flex; justify-content: flex-end">
                                    <div class="btn btn-primary btn-save" data-id="{{$feedback_id}}">Hoàn thành</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

    <script src="feedback/js/box.js"></script>
    <!-- BoxJS -->
    <script src="feedback/js/form.js"></script>

    <script>
    $(document).ready(function () {
        
        $(document).on('click', '.btn-save', function (e) {
            var feedback_id = $(this).attr('data-id');   

            var identity = $("#identity").val();
            var name = $("#name").val();
            var email = $("#email").val();
            var phone = $("#phone").val();
            var address = $("#address").val();
            var facebook_link = $("#facebook_link").val();
            var note = $("#note").val();

            var feedback_radio = [];
            var feedback_checkbox = [];
            var feedback_text = [];

            $('input[type="radio"]:checked').each(function (index, value) {
                var question_id = value.name.split('_')[1];
                var answer_id = value.id.split('_')[1];
                var question_type = $(this).attr('data-type');

                feedback_radio [index] = {
                    'question_id' : question_id,
                    'answer_id' : answer_id,
                    'question_type' : question_type,
                };
            });

            $('input[type="checkbox"]:checked').each(function (index, value) {
                var question_id = value.name.split('_')[1];
                var answer_id = value.id.split('_')[1];
                var question_type = $(this).attr('data-type');

                feedback_checkbox [index] = {
                    'question_id' : question_id,
                    'question_type' : question_type,
                    'answer_id' : answer_id
                };
            });

            $('textarea').each(function (index, value) {
                if ($(this).attr('data-type') != undefined) {
                    console.log($(this).attr('data-type'));
                    var question_id = value.name.split('_')[1];
                    var answer = $(this).val();
                    var question_type = $(this).attr('data-type');

                    feedback_text [index] = {
                        'question_id' : question_id,
                        'question_type' : question_type,
                        'answer' : answer
                    };
                }
            });

            // console.log(feedback_radio);
            // console.log(feedback_checkbox);
            // console.log(feedback_text);

            var data = {
                'feedback_id' : feedback_id,

                'identity' : identity,
                'name' : name,
                'email' : email,
                'phone' : phone,
                'address' : address,
                'facebook_link' : facebook_link,
                'note' : note,

                'feedback_radio' : feedback_radio,
                'feedback_checkbox' : feedback_checkbox,
                'feedback_text' : feedback_text,
            }

            $.ajax({
                type: 'POST',
                url: base_url + '/postPublicSurvey',
                data: data,
                dataType : 'json',

                success: function (response) {
                    successResponse(response);
                },
                error: function (e) {
                    errorResponse(e)
                }
            });
        });
    });
    </script>
</body>

</html>