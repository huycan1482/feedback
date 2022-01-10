<?php

namespace App\Http\Controllers;

use App\AnonymousUser;
use App\FeedBack;
use App\Http\Requests\SurveyRequest;
use App\Question;
use App\Repositories\SurveyRepository;
use App\Survey;
use App\SurveyAnswer;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyController extends SurveyRepository
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        $surveysWithTrashed = [];

        if ($currentUser->can('forceDelete', Survey::class)) {
            $surveysWithTrashed = $this->getAllWithTrashed();
        }

        $surveys = $this->getAll();

        return view('admin.survey.index', [
            'surveys' => $surveys,
            'surveysWithTrashed' => $surveysWithTrashed
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $feedbacks = $this->getFeedback();

        return view ('admin.survey.create', [
            'feedbacks' => $feedbacks
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SurveyRequest $request)
    {

        dd($request->all());
        DB::beginTransaction();

        try {
            if ($this->createModelByEloquent($request->all()) == false)
                throw new Exception();

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
        $checkSurvey = $this->find($id);

        if (empty($checkSurvey)) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 404);    

        } else {
            $checkFeedback = FeedBack::find($checkSurvey->feedback_id);

            if (!empty($checkFeedback)) {
                $data = $this->getSurveyDetail($checkFeedback);
                return response()->json(['feedback' => $checkFeedback, 'data' => json_encode($data)], 200);
            } else {
                return response()->json(['mess' => 'Bản ghi không tồn tại'], 404);    
            }
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
        $feedbacks = $this->getFeedback();

        $survey = $this->find($id);

        if (empty($survey)) {
            return redirect()->route('admin.errors.404');
        }

        return view('admin.survey.edit', [
            'feedbacks' => $feedbacks,
            'survey' => $survey,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SurveyRequest $request, $id)
    {
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

    public function forceDelete($id)
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ($currentUser->can('forceDelete', Survey::class)) {
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

        if ($currentUser->can('restore', Survey::class)) {
            if ($this->restoreModel($id)) {
                return response()->json(['mess' => 'Khôi bản ghi thành công'], 200);
            } else {
                return response()->json(['mess' => 'Khôi bản không thành công'], 400);
            }
        } else {
            return response()->json(['mess' => 'Khôi phục bản ghi lỗi'], 403);
        }
    }

    public function getSurveyResult($id) 
    {
        $survey = $this->find($id);

        

        if (empty($survey)) {
            return redirect()->route('admin.errors.404');
        }

        $user_out_system = $this->getUserOutSystem($id);
        $user_in_system = $this->getUserInSystem($id);

        $users_chart = "['Trong hệ thống', ".$user_in_system."], ['Ngoài hệ thống', ".$user_out_system."],";

        $opinions = $this->getOpinion($id);

        // $opinions_chart = $opinions;

        $questions = $this->getQuestionsBelongsTo($survey->feedback_id);

        return view ('admin.survey.result', [
            'anonymous_users' => $survey->anonymous_users,
            'survey_id' => $id,
            'users_chart' => $users_chart,
            'questions' => $questions
        ]);
    }

    public function getAnonymousUser ($user_id, $survey_id)
    {
        $anonymous_user = AnonymousUser::find($user_id);

        $data = SurveyAnswer::where([['anonymous_user_id', '=', $user_id], ['survey_id', '=', $survey_id]])->get()->first();

        // dd($anonymous_user, $data);
        return response()->json([
            'anonymous_user' => $anonymous_user,
            'data' => $data,
        ]);
    }

    public function getQuestionChart ($survey_id, $question_id)
    {
        $question = Question::find($question_id);

        $survey_answer = SurveyAnswer::where('survey_id', $survey_id)->pluck('id')->toArray();
        // dd(implode(',',$survey_answer));

        $question_chart = DB::table('answers')
        ->selectRaw("COUNT(test.id) as 'number', answers.code, answers.content")
        ->leftJoin(DB::raw("(SELECT survey_answer_details.answer_id as id FROM survey_answer_details 
        WHERE survey_answer_details.survey_answer_id IN (".implode(',',$survey_answer).")
        AND survey_answer_details.question_id = $question_id) as test"), 'test.id', '=', 'answers.id')
        ->where("answers.question_id", $question_id)
        ->groupBy("answers.id")
        ->get();

        return response()->json([
            'question_chart' => $question_chart,
            'question_content' => $question->content,
        ]);
    }

    public function getAnswersChart ($survey_id, $question_id) 
    {
        $question = Question::find($question_id);

        $survey_answer = SurveyAnswer::where('survey_id', $survey_id)->pluck('id')->toArray();

        $questions = DB::table('answers')
        ->selectRaw("COUNT(test.id) as 'number', answers.code, answers.content")
        ->leftJoin(DB::raw("(SELECT survey_answer_details.answer_id as id FROM survey_answer_details 
        WHERE survey_answer_details.survey_answer_id IN (".implode(',',$survey_answer).")
        AND survey_answer_details.question_id = $question_id) as test"), 'test.id', '=', 'answers.id')
        ->where("answers.question_id", $question_id)
        ->groupBy("answers.id")
        ->get();

        $question_chart = "";

        foreach($questions as $key => $item) {
            $question_chart .= "['".$item->code."',".$item->number."],";
        }

        return view ('admin.survey.answersChart', [
            'question' => $question,
            'questions' => $questions,
            'question_chart' => $question_chart
        ]);
    }
}
