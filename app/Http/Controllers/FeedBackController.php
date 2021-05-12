<?php

namespace App\Http\Controllers;

use App\FeedBack;
use App\FeedbackQuestion;
use App\Question;
use DateTime;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
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
            'start_at' => 'required|date_format:"Y-m-d"',
            'end_at' => 'required|date_format:"Y-m-d"|after:start_at',
            'is_active' => 'integer|boolean',
            'question_id' => 'required|min:1|array',
            'question_id.*' => 'exists:questions,id',
        ], [
            'name.required' => 'Yêu cầu không để trống',
            'name.unique' => 'Dữ liệu trùng',
            'code.required' => 'Yêu cầu không để trống',
            'code.unique' => 'Dữ liệu trùng',
            'start_at.required' => 'Yêu cầu không để trống',
            'start_at.date_format' => 'Sai định dạng',
            'end_at.required' => 'Yêu cầu không để trống',
            'end_at.date_format' => 'Sai định dạng',
            'end_at.after' => 'Thời gian kết thúc p sau thời gian bắt đầu',
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
            $feedback->start_at = $request->input('start_at');
            $feedback->end_at = $request->input('end_at');
            $feedback->is_active = (int)$request->input('is_active');

            $feedback->teacher_id = 1;
            $feedback->course_id = 1;

            $current_date = new DateTime();
            $created_time = date('Y-m-d H:i:s', $current_date->getTimestamp());
            $feedback->created_at = $created_time;

            DB::beginTransaction();

            try {

                // dd($feedback);

                $feedback->save();

                $latestFeedBack = FeedBack::where([ 'created_at' => $created_time ])->first()->id;

                foreach ($request->input('question_id') as $item) {
                    $feedback_question = new FeedbackQuestion;
                    $feedback_question->question_id = $item;
                    $feedback_question->feedback_id = $latestFeedBack;

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
        //
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
}
