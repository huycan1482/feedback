<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Http\Requests\QuestionRequest;
use App\Question;
use App\Repositories\QuestionRepository;
use App\User;
use DateTime;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class QuestionController extends QuestionRepository
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        $questionsWithTrashed = [];

        if ($currentUser->can('forceDelete', Question::class)) {
            $questionsWithTrashed = $this->getAllWithTrashed();
        }

        $questions = $this->getAll();

        return view('admin.question.index', [
            'questions' => $questions,
            'questionsWithTrashed' => $questionsWithTrashed,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('admin.question.create');
        return view('admin.question.create1');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {
        $current_date = new DateTime();
        $created_time = date('Y-m-d H:i:s', $current_date->getTimestamp());

        $request->merge([
            'user_create' => Auth::user()->id,
            'created_at' =>  $created_time,
        ]);

        $request['content'] = $request->trueContent;
        // dd($request->all());
        DB::beginTransaction();

        try {
            if ($this->createModelByEloquent($request->all()) == false)
                throw new Exception();

            $latestQuestion = $this->getLatestQuestion($created_time);

            // dd($latestQuestion->id);
            if ($request['type'] != 3)
                if (!$this->createAnswers($request['answers'], $latestQuestion->code, $latestQuestion->id))
                    throw new Exception();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mess' => 'Th??m b???n ghi l???i'], 502);
        }

        return response()->json(['mess' => 'Th??m b???n ghi th??nh c??ng', 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = $this->find($id);

        if (empty($question)) {
            return response()->json(['mess' => 'B???n ghi kh??ng t???n t???i', 404]);
        }

        $answers = $this->getAnswersBelongsTo($id);

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
        $question = $this->find($id);

        if (empty($question)) {
            return response()->json(['mess' => 'B???n ghi kh??ng t???n t???i', 404]);
        }

        $answers = $this->getAnswersBelongsTo($id);

        return view('admin.question.edit1', [
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
    public function update(QuestionRequest $request, $id)
    {
        $request->merge([
            'user_update' => Auth::user()->id,
        ]);

        dd($request->all());

        if ($this->updateModel($id, $request->all())) {
            return response()->json(['mess' => 'S???a b???n ghi th??nh c??ng', 200]);
        } else {
            return response()->json(['mess' => 'S???a b???n ghi l???i'], 502);
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
            return response()->json(['mess' => 'Xo??a ba??n ghi tha??nh c??ng'], 200);
        } else {
            return response()->json(['mess' => 'Xo??a ba??n kh??ng tha??nh c??ng'], 400);
        }
    }

    public function getListAnswers($id)
    {
        $question = $this->find($id);

        if (empty($question)) {
            return redirect()->route('admin.errors.404');
        }

        $answers = $this->getAnswersBelongsTo($id);

        return view('admin.question.listAnswers', [
            'answers' => $answers,
            'question' => $question->first(),
        ]);
    }

    public function forceDelete($id)
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ($currentUser->can('forceDelete', Question::class)) {
            if ($this->forceDeleteModel($id)) {
                return response()->json(['mess' => 'Xo??a ba??n ghi tha??nh c??ng'], 200);
            } else {
                return response()->json(['mess' => 'Xo??a ba??n kh??ng tha??nh c??ng'], 400);
            }
        } else {
            return response()->json(['mess' => 'X??a b???n ghi l???i, b???n kh??ng ????? th???m quy???n'], 403);
        }
    }

    public function restore($id)
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ($currentUser->can('restore', Question::class)) {
            if ($this->restoreModel($id)) {
                return response()->json(['mess' => 'Kh??i ba??n ghi tha??nh c??ng'], 200);
            } else {
                return response()->json(['mess' => 'Kh??i ba??n kh??ng tha??nh c??ng'], 400);
            }
        } else {
            return response()->json(['mess' => 'Kh??i ph???c b???n ghi l???i, b???n kh??ng ????? th???m quy???n'], 403);
        }
    }
}
