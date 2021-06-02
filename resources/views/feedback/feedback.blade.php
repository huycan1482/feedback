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
                    <a class="class-item" href="#">
                        <div>
                            <i class="fas fa-clipboard-list"></i>
                            <span>Tên lớp học (Mã lớp)</span>
                        </div>
                        <i class="fas fa-check"></i>
                    </a>
                    <a class="class-item" href="#">
                        <div>
                            <i class="fas fa-clipboard-list"></i>
                            <span>Tên lớp học (Mã lớp)</span>
                        </div>
                        <i class="fas fa-check"></i>
                    </a>
                    <a class="class-item" href="#">
                        <div>
                            <i class="fas fa-clipboard-list"></i>
                            <span>Tên lớp học (Mã lớp)</span>
                        </div>
                        <i class="fas fa-check"></i>
                    </a>

                </div>
            </div>

            <div class="box">
                <div class="drop-box-header">
                    <p>Số lượng câu hỏi: 20 câu</p>
                    <i class="fas fa-minus"></i>
                </div>
                <div class="box-body list-questions">

                    <a class="questions" href="#feedback1">
                        1
                    </a>
                    <a class="questions" href="#feedback2">
                        2
                    </a>
                    <a class="questions" href="#">
                        1
                    </a>
                    <a class="questions" href="#">
                        1
                    </a>
                    <a class="questions" href="#">
                        1
                    </a>

                    <a class="questions" href="#">
                        54
                    </a>
                    <a class="questions" href="#">
                        134
                    </a>
                    <a class="questions" href="#">
                        115
                    </a>
                    <a class="questions" href="#">
                        12
                    </a>
                    <a class="questions" href="#">
                        11
                    </a>
                    <a class="questions" href="#">
                        1
                    </a>
                    <a class="questions" href="#">
                        9
                    </a>
                    <a class="questions" href="#">
                        1
                    </a>
                    <a class="questions" href="#">
                        1
                    </a>
                    <a class="questions" href="#">
                        1
                    </a>


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
                                <span>Lớp học / Mã lớp</span>
                            </div>
                            <div class="box-info">
                                <i class="fas fa-bookmark"></i>
                                <span>Khóa học: </span>
                                <span>Khóa học / Mã khóa</span>
                            </div>
                            <div class="box-info">
                                <i class="fas fa-book"></i>
                                <span>Môn học: </span>
                                <span>Môn học / Mã môn</span>
                            </div>
                            <div class="box-info">
                                <i class="fas fa-user-tie"></i>
                                <span>Giảng viên: </span>
                                <span>Giảng viên</span>
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
                                <span>00/00/0000</span>
                            </div>
                            <div class="box-info">
                                <i class="fas fa-hourglass-end"></i>
                                <span>Ngày kết thúc: </span>
                                <span>00/00/0000</span>
                            </div>
                        </div>
                    </div>
                    <div class="box-hr"></div>
                </div>
                <div class="box-body">
                    <div>
                        <div class="feed-back" id="feedback1">
                            <div class="feedback-question"><span>1. (CH9): </span>Câu hỏi 9</div>
                            <div class="feedback-answers">
                                <div class="row">
                                    <div class="col-lg-6 answer-items">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="question1"
                                                id="answer1">
                                            <label class="form-check-label" for="answer1">
                                                Đáp án 1
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 answer-items">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="question1"
                                                id="answer2">
                                            <label class="form-check-label" for="answer2">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque est expedita neque et totam omnis consequatur, aliquid doloremque voluptates incidunt, adipisci ullam eos molestias quasi eveniet dicta accusamus hic ex.
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 answer-items">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="question1"
                                                id="answer3">
                                            <label class="form-check-label" for="answer3">
                                                Đáp án 3
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 answer-items">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="question1"
                                                id="answer4">
                                            <label class="form-check-label" for="answer4">
                                                Đáp án 4
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="feed-back" id="feedback2">
                            <div class="feedback-question"><span>1. (CH9): </span>Câu hỏi 9</div>
                            <div class="feedback-answers">
                                <div class="row">
                                    <div class="col-lg-6 answer-items">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="question1"
                                                id="answer1">
                                            <label class="form-check-label" for="answer1">
                                                Đáp án 1
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 answer-items">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="question1"
                                                id="answer2">
                                            <label class="form-check-label" for="answer2">
                                                đáp án
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 answer-items">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="question1"
                                                id="answer3">
                                            <label class="form-check-label" for="answer3">
                                                Đáp án 3
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 answer-items">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="question1"
                                                id="answer4">
                                            <label class="form-check-label" for="answer4">
                                                Đáp án 4
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="feedback/js/box.js"></script>
<!-- BoxJS -->
@endsection