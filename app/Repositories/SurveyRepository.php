<?php

namespace App\Repositories;

use App\AnonymousUser;
use App\FeedBack;
use App\Question;
use App\Repositories\EloquentRepository;
use App\Survey;
use App\SurveyAnswer;
use Exception;

class SurveyRepository extends EloquentRepository{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Survey::class;
    }

    public function getFeedback () 
    {
        return FeedBack::where('is_active', 1)->latest()->get();
    }

    public function createModelByEloquent ($request)
    {
        $survey = new Survey();
        $survey->feedback_id = $request['feedback_id'];
        $survey->start_at = $request['start_at'];
        $survey->end_at = $request['end_at'];
        $survey->is_active = 1*$request['is_active'];

        if ($survey->save()) {
            $survey->code = 'BKS' . (1000 + $survey->id);
            $survey->save();
            return true;
        } else {
            return false;
        }
    }

    public function getSurveyDetail ($feedback) 
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
                    'code' => $item->code,
                    'type' => $item->type,
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

    public function getQuestionsBelongsTo($feedback_id)
    {
        try {
            return Question::selectRaw('questions.*, feedback_question.position as position, feedback_question.id as feedbackQuestionId')
                ->join('feedback_question', 'questions.id', '=', 'feedback_question.question_id')
                ->where('feedback_question.feedback_id', $feedback_id)
                ->orderBy('position', 'desc')
                ->orderBy('feedback_question.id', 'asc')
                ->get();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getUserOutSystem ($survey_id)
    {
        try {
            return AnonymousUser::selectRaw("COUNT(anonymous_users.id) as quantity ")
            ->join('survey_answers', 'anonymous_users.id', '=', 'survey_answers.anonymous_user_id')
            ->whereRaw("anonymous_users.user_identity is null AND survey_answers.survey_id = $survey_id")
            ->get()->first()->quantity;
        } catch (Exception $e) {
            return [];
        }
    }

    public function getUserInSystem ($survey_id)
    {
        try {
            return AnonymousUser::selectRaw("COUNT(anonymous_users.id) as quantity ")
            ->join('survey_answers', 'anonymous_users.id', '=', 'survey_answers.anonymous_user_id')
            ->whereRaw("anonymous_users.user_identity is not null AND survey_answers.survey_id = $survey_id")
            ->get()->first()->quantity;
        } catch (Exception $e) {
            return 0;
        }
    }

    public function getOpinion ($survey_id)
    {
        try {
            return SurveyAnswer::selectRaw("COUNT(survey_answers.id) as quantity ")
            ->whereRaw("anonymous_users.user_identity is not null AND survey_answers.survey_id = $survey_id")
            ->get()->first()->quantity;
        } catch (Exception $e) {
            return 0;
        }
    }
}