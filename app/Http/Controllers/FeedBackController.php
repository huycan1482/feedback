<?php

namespace App\Http\Controllers;

use App\FeedBack;
use App\FeedbackQuestion;
use App\Http\Requests\FeedbackRequest;
use App\Question;
use App\Repositories\FeedbackRepository;
use App\User;
use DateTime;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FeedBackController extends FeedbackRepository
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $currentUser = User::findOrFail(Auth()->user()->id);

        $feedbacksWithTrashed = [];

        if ($currentUser->can('forceDelete', FeedBack::class)) {
            $feedbacksWithTrashed = $this->getAllWithTrashed();
        }

        $feedbacks = $this->getAll();

        return view('admin.feedback.index', [
            'feedbacks' => $feedbacks,
            'feedbacksWithTrashed' => $feedbacksWithTrashed
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
        return view('admin.feedback.create', [
            'questions' => $questions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FeedbackRequest $request)
    {
        $current_date = new DateTime();
        $created_time = date('Y-m-d H:i:s', $current_date->getTimestamp());

        $request->merge([
            'name' => $request->input('trueName'),
            'created_at' => $created_time,
            'user_create' => Auth::user()->id,
        ]);

        DB::beginTransaction();

        try {
            if (!$this->createModelByEloquent($request->all())) {
                return new Exception;
            }

            $latest_feedback_id = $this->getLatestFeedBackId($created_time);

            if (!$this->createFeedbackQuestion($request->input('question_id'), $latest_feedback_id)) {
                return new Exception;
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mess' => 'Thêm bản ghi lỗi'], 502);
        }

        return response()->json(['mess' => 'Thêm bản ghi thành công', 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $checkFeedback = $this->find($id);

        if (empty($checkFeedback)) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 404);
        } else {
            // $test = FeedBack::selectRaw('feedback_question.*')
            // ->leftJoin('feedback_question', 'feedbacks.id', '=', 'feedback_question.feedback_id')
            // ->where('feedbacks.id', $id)
            // ->orderBy('position', 'asc')
            // ->orderBy('feedback_question.id', 'desc')
            // ->get();

            $data = $this->getFeedbackFDetail($checkFeedback);

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
        $feedback = $this->find($id);

        if (empty($feedback)) {
            return redirect()->route('admin.errors.404');
        }

        $question_ids = $this->getIdsQuestionBelongsTo($feedback);

        $questions = $this->getQuestionsNotBelongsTo($feedback);

        $data = $this->getQuestionsBelongsTo($id, $question_ids);

        return view('admin.feedback.edit', [
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
    public function update(FeedbackRequest $request, $id)
    {
        $request->merge([
            'name' => $request->input('trueName'),
            'user_update' => Auth::user()->id,
        ]);

        if ($this->updateModel($id, $request->all())) {
            return response()->json(['mess' => 'Sửa bản ghi thành công', 200]);
        } else {
            return response()->json(['mess' => 'Sửa bản ghi lỗi'], 502);
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
        if ($this->deleteModel($id)) {
            return response()->json(['mess' => 'Xóa bản ghi thành công'], 200);
        } else {
            return response()->json(['mess' => 'Xóa bản không thành công'], 400);
        }
    }

    public function getListQuestions($id)
    {
        $feedback = $this->find($id);

        if (empty($feedback)) {
            return redirect()->route('admin.errors.404');
        }

        return view('admin.feedback.listQuestions', [
            'feedback' => $feedback
        ]);
    }

    public function forceDelete($id)
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ($currentUser->can('forceDelete', FeedBack::class)) {
            if ($this->forceDeleteModel($id)) {
                return response()->json(['mess' => 'Xóa bản ghi thành công'], 200);
            } else {
                return response()->json(['mess' => 'Xóa bản không thành công'], 400);
            }
        } else {
            return response()->json(['mess' => 'Xóa bản ghi lỗi'], 403);
        }
    }

    public function restore($id)
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ($currentUser->can('restore', FeedBack::class)) {
            if ($this->restoreModel($id)) {
                return response()->json(['mess' => 'Khôi bản ghi thành công'], 200);
            } else {
                return response()->json(['mess' => 'Khôi bản không thành công'], 400);
            }
        } else {
            return response()->json(['mess' => 'Khôi phục bản ghi lỗi'], 403);
        }
    }
}
