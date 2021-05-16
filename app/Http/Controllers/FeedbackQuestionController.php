<?php

namespace App\Http\Controllers;

use App\FeedbackQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedbackQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question_id' => 'required|exists:questions,id',
            'feedback_id' => 'required|exists:feedbacks,id',
        ], [
            'question_id.required' => 'Yêu cầu không để trống',
            'question_id.exists' => 'Bản ghi không tồn tại',
            'feedback_id.required' => 'Yêu cầu không để trống',
            'feedback_id.exists' => 'Bản ghi không tồn tại',
        ]);

        $errs = $validator->errors();

        $checkQuestion = FeedbackQuestion::where([['feedback_id', '=', $request->input('feedback_id')], ['question_id', '=', $request->input('question_id')]])->get()->first();

        if (!empty($checkQuestion)) {
            return response()->json([ 'mess' => 'Thêm bản ghi lỗi, câu hỏi đã tồn tại'], 400);
        } else if ( $validator->fails() ) {
            return response()->json(['errors' => $errs, 'mess' => 'Thêm bản ghi lỗi'], 400);
        } else {
            $feedbackQuestion = new FeedbackQuestion;
            $feedbackQuestion->question_id = $request->input('question_id');
            $feedbackQuestion->feedback_id = $request->input('feedback_id');
            $feedbackQuestion->position = 0;

            if ($feedbackQuestion->save()) {
                return response()->json(['mess' => 'Thêm bản ghi thành công, tải lại sau 1.5s', 200]);
            } else {
                return response()->json(['mess' => 'Thêm bản ghi lỗi'], 502);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $feedbackQuestion = FeedbackQuestion::find($id);

        if (empty($feedbackQuestion)) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 400);
        } else {
            $validator = Validator::make($request->all(), [
                'position' => 'required|integer',
            ], [
                'position.required' => 'Yêu cầu không để trống',
                'position.integer' => 'Sai kiểu dữ liệu',
            ]);
    
            $errs = $validator->errors();
    
            if ( $validator->fails() ) {
                return response()->json(['errors' => $errs, 'mess' => 'Sửa bản ghi lỗi'], 400);
            } else {
                $feedbackQuestion->position = $request->input('position');

                if ($feedbackQuestion->save()) {
                    return response()->json(['mess' => 'Sửa bản ghi thành công, tải lại sau 1.5s', 200]);
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
        $feedbackQuestion = FeedbackQuestion::find($id);
        if ( empty($feedbackQuestion) ) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 400);
        }

        if( FeedbackQuestion::destroy($id) != 0 ) {
            return response()->json(['mess' => 'Xóa bản ghi thành công, tải lại trong 1.5s'], 200);
        } else {
            return response()->json(['mess' => 'Xóa bản không thành công'], 400);
        }
    }
}
