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

    public function createAnswers ($data, $code, $question)
    {
        // dd($data);
        DB::beginTransaction();

        try {
            foreach ($data as $key => $item) {    
                $answer = new Answer;
                $answer->code = $code.'-'.$key.'-'.time();
                $answer->question_id = $question->id;
                $answer->content = $item['value'];
                // $answer->type = 1;
                // $answer->is_true = (int)$item['1'];
                $answer->point = $item['point'];
                $answer->user_create = Auth::user()->id;
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