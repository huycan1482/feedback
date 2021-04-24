<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use DateTime;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::latest()->get();
        return view ('admin.question.index', [
            'questions' => $questions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.question.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all(), $request['answers']);
        $request['trueContent'] = $request->input('content');
        $request['content'] = Str::slug($request->input('content'));

        $validator = Validator::make($request->all(), [
            'content' => 'required|unique:questions,slug',
            'is_active' => 'integer|boolean',
            'answers' => 'required|array|min:1|max:4',
        ], [
            'content.required' => 'Yêu cầu không để trống',
            'content.unique' => 'Dữ liệu bị trùng',
            'is_active.integer' => 'Sai kiểu dữ liệu',
            'is_active.boolean' => 'Sai kiểu dữ liệu',
            'answers.required' => 'Yêu cầu không để trống',
            'answers.min' => 'Yêu cầu phải có từ 1 câu trả lời trở lên',
            'answers.max' => 'Tối đa 4 câu trả lời',
            'answers.array' => 'Sai kiểu dữ liệu',
        ]);

        // dd($validator->errors());

        $errs = $validator->errors();

        if ( $validator->fails() ) {
            return response()->json(['errors' => $errs, 'mess' => 'Thêm bản ghi lỗi'], 400);
        } else {
            $question = new Question;

            $question->content = $request->input('trueContent');
            $question->slug = $request->input('content');
            $question->code = 0;
            $question->is_active = (int)$request->input('is_active'); 
            // $question->user_create = Auth::user()->id;
            $current_date = new DateTime();
            $created_time = date('Y-m-d H:i:s', $current_date->getTimestamp());
            $question->created_at = $created_time;

            DB::beginTransaction();

            try {
                $question->save();
                $latestQuestion = Question::where([ 'created_at' => $created_time ]);
                foreach ($request['answers'] as $item) {
                    $answer = new Answer;
                    $answer->question_id = $latestQuestion->first()->id;
                    $answer->content = $item['0'];
                    $answer->type = 1;
                    $answer->is_true = (int)$item['1'];
                    $answer->save();
                }

                DB::commit();

            } catch (Exception $e) {
                DB::rollBack();
                return response()->json(['mess' => 'Thêm bản ghi lỗi'], 502);
            }

            // try {
            //     DB::transaction(function () use ($question, $request, $created_time) {
            //         $question->save();
            //         $latestQuestion = Question::where([ 'created_at' => $created_time ]);
            //         foreach ($request['answers'] as $item) {
            //             $answer = new Answer;
            //             $answer->question_id = $latestQuestion->first()->id;
            //             $answer->content = $item['0'];
            //             $answer->is_check = (int)$item['1'];
                        
            //             $answer->save();
            //         }
            //     });

            // } catch (Exception $e) {
            //     return response()->json(['mess' => 'Thêm bản ghi lỗi', 502]);
            // }
            

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
        $question = Question::find($id);
        
        $answers = Answer::where('question_id', '=', $id)->get();

        return response()->json(['question' => $question, 'answers' => $answers], 200);

        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::find($id);
        
        $answers = Answer::where('question_id', '=', $id)->get();

        return view('admin.question.edit', [
            'question' => $question,
            'answers' => $answers,
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
        $question = Question::find($id);
        
        if (empty($question)) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 404);
        } else {
            $request['trueContent'] = $request->input('content');
            $request['content'] = Str::slug($request->input('content'));

            $validator = Validator::make($request->all(), [
                'content' => 'required|unique:questions,slug,'.$id,
                'is_active' => 'integer|boolean',
                // 'answers' => 'required|array|min:1|max:4',
            ], [
                'content.required' => 'Yêu cầu không để trống',
                'content.unique' => 'Dữ liệu bị trùng',
                'is_active.integer' => 'Sai kiểu dữ liệu',
                'is_active.boolean' => 'Sai kiểu dữ liệu',
                // 'answers.required' => 'Yêu cầu không để trống',
                // 'answers.min' => 'Yêu cầu phải có từ 1 câu trả lời trở lên',
                // 'answers.max' => 'Tối đa 4 câu trả lời',
                // 'answers.array' => 'Sai kiểu dữ liệu',
            ]);

            $errs = $validator->errors();

            if ( $validator->fails() ) {
                return response()->json(['errors' => $errs, 'mess' => 'Sửa bản ghi lỗi'], 400);
            } else {
                $question->content = $request->input('trueContent');
                $question->slug = $request->input('content');
                $question->is_active = (int)$request->input('is_active'); 

                // DB::beginTransaction();

                // try {
                //     $question->save();
                    
                //     foreach ($request['answers'] as $item) {
                        
                //         $answer = Answer::where([['id', '=', $item['0']], ['question_id', '=', $id]])->get()->first();

                //         if ($answer != null) {
                //             $answer->question_id = $id;
                //             $answer->content = $item['1'];
                //             $answer->is_check = (int)$item['2'];
                //             $answer->save();
                //         } else {
                //             throw new Exception();
                //         }
                //     }

                //     DB::commit();

                // } catch (Exception $e) {
                //     DB::rollBack();
                //     return response()->json(['mess' => 'Sửa bản ghi lỗi'], 502);
                // }   
                if ($question->save()) {
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
        //
    }

    public function getListAnswers ($id)
    {
        $question = Question::findOrFail($id);

        $answers = Answer::where(['question_id' => $id])->get();

        return view ('admin.question.listAnswers', [
            'answers' => $answers,
            'question' => $question->first(),
        ]);
    }
}
