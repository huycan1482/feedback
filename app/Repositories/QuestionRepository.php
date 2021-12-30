<?php

namespace App\Repositories;

use App\Answer;
use App\Question;
use App\Repositories\EloquentRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionRepository extends EloquentRepository {
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Question::class;
    }

    public function getLatestQuestion ($created_time)
    {
        try {
            return Question::where([ 'created_at' => $created_time ])->first();
        } catch (Exception $e) {
            return null;
        }
    }

    public function createModelByEloquent ($request)
    {
        $question = new Question;
        $question->content = $request['content'];
        $question->slug = $request['slug'];
        $question->type = $request['type'];
        $question->is_active = $request['is_active'];
        $question->user_create = $request['user_create'];
        $question->created_at = $request['created_at'];

        if ($question->save()) {
            $question->code = 'CH'. (1000 + $question->id);
            $question->save();
            return true;
        } else {
            return false;
        }
        

    }

    public function createAnswers ($data, $question_code, $question_id)
    {
        // dd($data);
        DB::beginTransaction();

        try {
            foreach ($data as $key => $item) {    
                $answer = new Answer;
                $answer->code = $question_code.'-'.$key.'-'.time();
                $answer->question_id = $question_id;
                $answer->content = $item['value'];
                // $answer->type = 1;
                // $answer->is_true = (int)$item['1'];
                // $answer->point = $item['point'];
                $answer->point = 0;
                $answer->user_create = Auth::user()->id;
                // dd($answer);
                $answer->save();
            }

            DB::commit();
            
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function getAnswersBelongsTo ($id)
    {
        try {
            return Answer::where('question_id', $id)->get();
        } catch (Exception $e) {
            return [];
        }
    }
}