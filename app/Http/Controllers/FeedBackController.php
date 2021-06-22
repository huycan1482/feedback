<?php

namespace App\Http\Controllers;

use App\FeedBack;
use App\FeedbackQuestion;
use App\Question;
use DateTime;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FeedBackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feedbacks = FeedBack::latest()->get();
        return view ('admin.feedback.index', [
            'feedbacks' => $feedbacks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $questions = Question::where('is_active', '=', 1)->latest()->get(); 
        return view ('admin.feedback.create', [
            'questions' => $questions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request['trueName'] = $request->input('name');
        $request['name'] = Str::slug($request->input('name'));
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:feedbacks,slug',
            'code' => 'required|unique:feedbacks,code',
            'is_active' => 'integer|boolean',
            'question_id' => 'required|min:1|array',
            'question_id.*' => 'exists:questions,id',
        ], [
            'name.required' => 'Yêu cầu không để trống',
            'name.unique' => 'Dữ liệu trùng',
            'code.required' => 'Yêu cầu không để trống',
            'code.unique' => 'Dữ liệu trùng',
            'is_active.integer' => 'Sai kiểu dữ liệu',
            'is_active.boolean' => 'Sai kiểu dữ liệu',
            'question_id.required' => 'Yêu cầu không để trống',
            'question_id.min' => 'Yêu cầu có ít nhất 1 câu hỏi',
            'question_id.array' => 'Sai kiểu định dạng',
            'question_id.*.exists' => 'Dữ liệu không tồn tại',
        ]);

        // dd($request->input('question_id'));

        $errs = $validator->errors();

        if ( $validator->fails() ) {
            return response()->json(['errors' => $errs, 'mess' => 'Thêm bản ghi lỗi'], 400);
        } else {
            $feedback = new Feedback;
            $feedback->name = $request->input('trueName');
            $feedback->slug = $request->input('name');
            $feedback->code = $request->input('code');
            $feedback->is_active = (int)$request->input('is_active');
            $feedback->user_create = Auth::user()->id;

            $current_date = new DateTime();
            $created_time = date('Y-m-d H:i:s', $current_date->getTimestamp());
            $feedback->created_at = $created_time;

            DB::beginTransaction();

            try {

                $feedback->save();

                $latestFeedBack = FeedBack::where([ 'created_at' => $created_time ])->first()->id;

                foreach ($request->input('question_id') as $item) {
                    $feedback_question = new FeedbackQuestion;
                    $feedback_question->question_id = $item;
                    $feedback_question->feedback_id = $latestFeedBack;
                    $feedback_question->position = 1;
                    $feedback_question->user_create = Auth::user()->id;
                    $feedback_question->save();
                }

                DB::commit();

            } catch (Exception $e) {
                DB::rollBack();
                return response()->json(['mess' => 'Thêm bản ghi lỗi'], 502);
            }

            return response()->json(['mess' => 'Thêm bản ghi thành công', 200]);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $checkFeedback = FeedBack::find($id);

        if (empty($checkFeedback)) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 404);
        } else {
            // $test = FeedBack::selectRaw('feedback_question.*')
            // ->leftJoin('feedback_question', 'feedbacks.id', '=', 'feedback_question.feedback_id')
            // ->where('feedbacks.id', $id)
            // ->orderBy('position', 'asc')
            // ->orderBy('feedback_question.id', 'desc')
            // ->get();

            foreach ($checkFeedback->question as $key => $item) {
                $arr = [];

                foreach($item->answers as $item2) {
                    $arr [] = [
                        'id' => $item2->id,
                        'content' => $item2->content,
                    ];
                }

                $data [] = [
                    'id' => $item->id, 
                    'code' => $item->code,
                    'content' => $item->content,
                    'answer' => $arr,
                ];
            }

            // $feedback = FeedBack::selectRaw('feedbacks.code, feedbacks.name, classes.name as class, users.name as teacher, courses.name as course, subjects.name as subject')
            // ->leftJoin('classes', 'feedbacks.id', '=' ,'classes.feedback_id')
            // ->join('courses', 'classes.course_id', '=', 'courses.id')
            // ->join('subjects', 'courses.subject_id', '=', 'subjects.id')
            // ->join('users', 'classes.teacher_id', '=', 'users.id')
            // ->where('feedback', $id)
            // ->get();

            return response()->json(['feedback' => $checkFeedback, 'data' => json_encode($data)], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $feedback = Feedback::findOrFail($id);

        $question_ids = [];

        foreach ($feedback->question as $item) {
            $question_ids [] = $item->id;
        }

        $questions = Question::where('is_active', '=', 1)->whereNotIn('id', $question_ids)->latest()->get(); 

        $data = Question::selectRaw('questions.*, feedback_question.position as position, feedback_question.id as feedbackQuestionId')
        ->rightJoin('feedback_question', 'questions.id', '=', 'feedback_question.question_id')
        ->whereIn('questions.id', $question_ids)
        ->orderBy('position', 'desc')
        ->orderBy('feedback_question.id', 'asc')
        ->get(); 

        return view ('admin.feedback.edit', [
            'feedback' => $feedback,
            'questions' => $questions,
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $feedback = FeedBack::find($id);

        if (empty($feedback)) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 400);
        } else {
            $request['trueName'] = $request->input('name');
            $request['name'] = Str::slug($request->input('name'));
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:feedbacks,slug,'.$id,
                'code' => 'required|unique:feedbacks,code,'.$id,
                'is_active' => 'integer|boolean',
            ], [
                'name.required' => 'Yêu cầu không để trống',
                'name.unique' => 'Dữ liệu trùng',
                'code.required' => 'Yêu cầu không để trống',
                'code.unique' => 'Dữ liệu trùng',
                'is_active.integer' => 'Sai kiểu dữ liệu',
                'is_active.boolean' => 'Sai kiểu dữ liệu',
            ]);

            $errs = $validator->errors();

            if ( $validator->fails() ) {
                return response()->json(['errors' => $errs, 'mess' => 'Sửa bản ghi lỗi'], 400);
            } else {
                $feedback->name = $request->input('trueName');
                $feedback->slug = $request->input('name');
                $feedback->code = $request->input('code');
                $feedback->is_active = (int)$request->input('is_active');
                $feedback->user_update = Auth::user()->id;

                if ($feedback->save()) {
                    return response()->json(['mess' => 'Sửa bản ghi thành công', 200]);
                } else {
                    return response()->json(['mess' => 'Sửa bản ghi lỗi'], 502);
                }
            }
                
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feedback = Feedback::find($id);

        if ( empty($feedback) ) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 400);
        }
    
        if( $feedback->delete() ) {
            return response()->json(['mess' => 'Xóa bản ghi thành công'], 200);
        } else {
            return response()->json(['mess' => 'Xóa bản không thành công'], 400);
        }
    }

    public function getListQuestions($id)
    {
        $feedback = Feedback::findOrFail($id);
        
        return view ('admin.feedback.listQuestions', [
            'feedback' => $feedback
        ]);
    }
}
