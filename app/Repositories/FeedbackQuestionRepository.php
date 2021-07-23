<?php

namespace App\Repositories;

use App\FeedbackQuestion;
use Exception;

class FeedbackQuestionRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\FeedbackQuestion::class;
    }

    public function checkFeedbackQuestionExists($feedback_id, $question_id)
    {
        try {
            $result = FeedbackQuestion::where([['feedback_id', '=', $feedback_id], ['question_id', '=', $question_id]])->get()->first();
            return (empty($result)) ? false : true;
        } catch (Exception $e) {
            return false;
        }
    }
}
