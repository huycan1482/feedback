<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Http\Requests\AnswerRequest;
use App\Question;
use App\Repositories\AnswerRepository;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AnswerController extends AnswerRepository
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $answers = $this->getAll();
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
        $questions = $this->getQuestions();
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
    public function store(AnswerRequest $request)
    {
        

        // $check_question_id = Answer::where('question_id', $request->input('question_id'))->count();

        // if ($check_question_id >= 4) {
        //     return response()->json(['mess' => 'Thêm bản ghi lỗi, quá số lượng đáp án'], 422);
        // } else {

        //     $answer = new Answer;

        //     $answer->question_id = $request->input('question_id');
        //     $answer->content = $request->input('add_answer_content');
        //     $answer->type = 1;
        //     $answer->is_true = (int)$request->input('add_answer_active');
        //     $answer->user_create = Auth::user()->id;

        //     $data = [
        //         'question_id' => $request->input('question_id'),
        //         'content' => $request->input('add_answer_content'),
        //         'type' => 1,
        //         'is_true' => 
        //     ];

        
        //     if ( $answer->save() ) {  
        //         return response()->json(['mess' => 'Thêm bản ghi thành công', 200]);
        //     } else {
        //         return response()->json(['mess' => 'Thêm bản ghi lỗi'], 502);
        //     }
  
           

        // }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $answer = $this->find($id);

        if (empty($answer)) {
            return redirect()->route('admin.errors.404');
        }

        $question = $this->findQuestion($answer->question_id);

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
    public function update(AnswerRequest $request, $id)
    {
        $data = [
            'content' => $request->input('content'),
            'user_update' => Auth::user()->id,
        ];

        if ($this->updateModel($id, $data)) {
            return response()->json(['mess' => 'Sửa bản ghi thành công', 200]);
        } else {
            return response()->json(['mess' => 'Sửa bản ghi lỗi'], 520);
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
        // $answer = Answer::withTrashed()->find($id);
        // if ( empty($answer) ) {
        //     return response()->json(['mess' => 'Bản ghi không tồn tại'], 400);
        // }
    
        if( $this->forceDeleteModel($id) ) {
            return response()->json(['mess' => 'Xóa bản ghi thành công'], 200);
        } else {
            return response()->json(['mess' => 'Xóa bản không thành công'], 400);
        }
    }
}
