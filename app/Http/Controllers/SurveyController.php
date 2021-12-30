<?php

namespace App\Http\Controllers;

use App\FeedBack;
use App\Http\Requests\SurveyRequest;
use App\Repositories\SurveyRepository;
use App\Survey;
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

        $feedbacksWithTrashed = [];

        if ($currentUser->can('forceDelete', Survey::class)) {
            $feedbacksWithTrashed = $this->getAllWithTrashed();
        }

        $feedbacks = $this->getAll();

        return view('admin.survey.index', [
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
}
