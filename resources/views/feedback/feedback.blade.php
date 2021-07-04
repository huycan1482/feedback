@extends('feedback.layouts.main')

@section('css')
    <!-- Box -->
    <link rel="stylesheet" href="feedback/css/box.css">
    <!-- Css -->
    <link rel="stylesheet" href="feedback/css/feedback.css">
@endsection

@section('content')
<div class="main-content">
    <div class="row">
        <div class="col-lg-4">
            <div class="box">
                <div class="drop-box-header">
                    <p>Chọn lớp học</p>
                    <i class="fas fa-minus"></i>
                </div>
                <div class="box-body">
                    @foreach($classes as $class)
                    {{-- {{dd($class->pivot)}} --}}
                        @foreach ($class->feedback as $item)
                        @if ($item->pivot->is_active == 1)
                        <a class="class-item" href="{{ route('feedback.getFeedbackId', ['class_id' => $class->id, 'feedback_id' => $item->id]) }}">
                            <div>
                                <i class="fas fa-clipboard-list"></i>
                                <span>{{$class->name}} ({{$class->code}}) /{{ $item->name }} ({{ $item->code }})</span>
                            </div>
                            <i class="fas fa-check"></i>
                        </a>
                        @endif
                        @endforeach
                    
                    @endforeach
                </div>
            </div>

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
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="box-info">
                                <i class="fas fa-book-open"></i>
                                <span>Lớp học: </span>
                                <span>{{ $classRoom->name }} / {{ $classRoom->code }}</span>
                            </div>
                            <div class="box-info">
                                <i class="fas fa-bookmark"></i>
                                <span>Khóa học: </span>
                                <span>{{ $classRoom->course }} / {{ $classRoom->course_code }}</span>
                            </div>
                            <div class="box-info">
                                <i class="fas fa-book"></i>
                                <span>Môn học: </span>
                                <span>{{ $classRoom->subject }}</span> / {{ $classRoom->subject_code }}</span>
                            </div>
                            <div class="box-info">
                                <i class="fas fa-user-tie"></i>
                                <span>Giảng viên: </span>
                                <span>{{ $classRoom->teacher }}</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="box-info">
                                <i class="fas fa-bell"></i>
                                <span>Trạng thái: </span>
                                <span>Đang học</span>
                            </div>
                            <div class="box-info">
                                <i class="fas fa-hourglass-start"></i>
                                <span>Ngày bắt đầu: </span>
                                <span>{{ date_format(date_create($classRoom->start_at), 'd-m-Y') }}</span>
                            </div>
                            <div class="box-info">
                                <i class="fas fa-hourglass-end"></i>
                                <span>Ngày kết thúc: </span>
                                <span>{{ date_format(date_create($classRoom->end_at), 'd-m-Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="box-hr"></div>
                </div>
                <div class="box-body">
                    <div>
                        @foreach ($data as $key => $item)
                        <div class="feed-back" id="feedback{{ $item['id'] }}">
                            <div class="feedback-question">
                                <span>{{ $key + 1 }}. ({{ $item['code'] }}): </span>{{ $item['content'] }}
                            </div>
                            <div class="feedback-answers">
                                <div class="row">
                                    @foreach ($item['answers'] as $answer)
                                    <div class="col-lg-6 answer-items">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="question_{{ $item['id'] }}"
                                                id="answer_{{ $answer['id'] }}">
                                            <label class="form-check-label" for="answer_{{ $answer['id'] }}">
                                                {{ $answer['content'] }}
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="box-footer">
                    <div style="margin: 20px; display: flex; justify-content: flex-end">
                        <div class="btn btn-primary btn-save" feedback-id="{{ $feedback_id->id }}" feedbackDetail="{{ $feedback_detail }}">Hoàn thành</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="feedback/js/box.js"></script>
<!-- BoxJS -->
<script src="feedback/js/form.js"></script>

<script>
    $(document).ready(function () {

        $(document).on('click', '.btn-save', function (e) {
            var feedback_id = $(this).attr('feedback-id');   
            var feedback_detail = $(this).attr('feedbackDetail');
            // console.log($('div[id*=feedback]').length);

            var feedback = [];

            $('input[type="radio"]:checked').each(function (index, value) {

                var question_id = value.name.split('_')[1];
                var answer_id = value.id.split('_')[1];

                feedback [index] = {
                    'question_id' : question_id,
                    'answer_id' : answer_id
                };
            });

            // console.log(feedback);

            var data = {
                feedback_id: feedback_id,
                feedback_detail : feedback_detail,
                feedback: feedback,
            }

            $.ajax({
                type: 'POST',
                url: base_url + '/postFeedBack',
                data: data,
                dataType : 'json',

                success: function (response) {
                    console.log(response);
                    successResponse(response);
                },
                error: function (e) {
                    errorResponse(e)
                }
            });
        });
    });
</script>
@endsection