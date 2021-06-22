<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $answers = Answer::latest()->get();
        return view ('admin.answer.index', [
            'answers' => $answers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $questions = Question::latest()->get();
        return view ('admin.answer.create', [
            'questions' => $questions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *p
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question_id' => 'required|exists:questions,id',
            'add_answer_content' => 'required',
            'add_answer_active' => 'integer|boolean',
        ], [
            'question_id.required' => 'Yêu cầu không để trống',
            'question_id.exists' => 'Câu hỏi không tồn tại',
            'add_answer_content.required' => 'Yêu cầu không để trống',
            // 'add_answer_content.unique' => 'Câu trả lời bị trùng',
            'add_answer_active.integer' => 'Sai kiểu dữ liệu',
            'add_answer_active.boolean' => 'Sai kiểu dữ liệu',
        ]);

        $errs = $validator->errors();

        $check_question_id = Answer::where('question_id', $request->input('question_id'))->count();

        if ( $validator->fails() ) {
            return response()->json(['errors' => $errs, 'mess' => 'Thêm bản ghi lỗi'], 400);
        } else if ($check_question_id >= 4) {
            return response()->json(['errors' => $errs, 'mess' => 'Thêm bản ghi lỗi, quá số lượng đáp án'], 400);
        } else {

            $answer = new Answer;
            $answer->question_id = $request->input('question_id');
            $answer->content = $request->input('add_answer_content');
            $answer->type = 1;
            $answer->is_true = (int)$request->input('add_answer_active');
            $answer->user_create = Auth::user()->id;

            if ($answer->save()) {
                return response()->json(['mess' => 'Thêm bản ghi thành công', 200]);
            } else {
                return response()->json(['errors' => $errs, 'mess' => 'Thêm bản ghi lỗi'], 400);
            }
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
        $answer = Answer::find($id);

        $question = Question::find($answer->question_id);

        return response()->json(['answer' => $answer, 'question' => $question], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        $answer = Answer::find($id);

        if (empty($answer)) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 400);
        } else {
            $validator = Validator::make($request->all(), [
                'answer_content' => 'required|unique:answers,content',
                'answer_is_active' => 'integer|boolean',
            ], [
                'answer_content.required' => 'Yêu cầu không để trống',
                'answer_content.unique' => 'Câu trả lời bị trùng',
                'answer_is_active.integer' => 'Sai kiểu dữ liệu',
                'answer_is_active.boolean' => 'Sai kiểu dữ liệu',
            ]);
    
            $errs = $validator->errors();
    
            if ( $validator->fails() ) {
                return response()->json(['errors' => $errs, 'mess' => 'Sửa bản ghi lỗi'], 400);
            } else {
                $answer->content = $request->input('answer_content');
                $answer->type = 1;
                // $answer->is_true = (int)$request->input('answer_is_active');
                $answer->is_true = 1;
                $answer->user_update = Auth::user()->id;
                if ($answer->save()) {
                    return response()->json(['mess' => 'Sửa bản ghi thành công', 200]);
                } else {
                    return response()->json(['errors' => $errs, 'mess' => 'Sửa bản ghi lỗi'], 400);
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
        $answer = Answer::withTrashed()->find($id);
        if ( empty($answer) ) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 400);
        }
    
        if( $answer->forceDelete() ) {
            return response()->json(['mess' => 'Xóa bản ghi thành công'], 200);
        } else {
            return response()->json(['mess' => 'Xóa bản không thành công'], 400);
        }
    }
}
