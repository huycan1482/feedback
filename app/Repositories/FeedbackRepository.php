<?php

namespace App\Repositories;

use App\FeedBack;
use App\FeedbackQuestion;
use App\Question;
use Exception;
use Illuminate\Support\Facades\Auth;

class FeedbackRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\FeedBack::class;
    }

    public function getQuestions()
    {
        try {
            return Question::where('is_active', '=', 1)->latest()->get();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getLatestFeedBackId($created_time)
    {
        try {
            return FeedBack::where(['created_at' => $created_time])->first()->id;
        } catch (Exception $e) {
            return null;
        }
    }

    public function createFeedbackQuestion($data, $latestFeedBack)
    {
        // dd($data, $latestFeedBack);
        try {
            foreach ($data as $item) {
                $feedback_question = new FeedbackQuestion();
                $feedback_question->question_id = $item;
                $feedback_question->feedback_id = $latestFeedBack;
                // $feedback_question->position = 1;
                $feedback_question->user_create = Auth::user()->id;
                $feedback_question->save();
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getFeedbackFDetail($feedback)
    {
        try {
            foreach ($feedback->question as $key => $item) {
                $arr = [];

                foreach ($item->answers as $item2) {
                    $arr[] = [
                        'id' => $item2->id,
                        'content' => $item2->content,
                    ];
                }

                $data[] = [
                    'id' => $item->id,
                    'type' => $item->type,
                    'code' => $item->code,
                    'content' => $item->content,
                    'answer' => $arr,
                ];
            }

            return $data;
        } catch (Exception $e) {
            return [];
        }
    }

    public function getIdsQuestionBelongsTo($feedback)
    {
        try {
            $question_ids = [];

            foreach ($feedback->question as $item) {
                $question_ids[] = $item->id;
            }
            return $question_ids;
        } catch (Exception $e) {
            return [];
        }
    }

    public function getQuestionsNotBelongsTo($feedback)
    {
        try {
            $question_ids = $this->getIdsQuestionBelongsTo($feedback);

            return Question::where('is_active', '=', 1)->whereNotIn('id', $question_ids)->latest()->get();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getQuestionsBelongsTo($feedback_id, $question_ids)
    {
        try {
            return Question::selectRaw('questions.*, feedback_question.position as position, feedback_question.id as feedbackQuestionId')
                ->join('feedback_question', 'questions.id', '=', 'feedback_question.question_id')
                ->where('feedback_question.feedback_id', $feedback_id)
                ->whereIn('questions.id', $question_ids)
                ->orderBy('position', 'desc')
                ->orderBy('feedback_question.id', 'asc')
                ->get();
        } catch (Exception $e) {
            return [];
        }
    }

    public function createModelByEloquent ($request)
    {
        $feedback = new FeedBack();
        $feedback->name = $request['name'];
        $feedback->slug = $request['slug'];
        $feedback->time = $request['time'];
        $feedback->is_active = $request['is_active'];
        $feedback->user_create = $request['user_create'];
        $feedback->is_public = 0;
        $feedback->created_at = $request['created_at'];
        
        if ($feedback->save()) {
            $feedback->code = 'BDG' . (1000 + $feedback->id);
            $feedback->save();
            return true;
        } else {
            return false;
        }

    }
}
