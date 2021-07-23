<?php

namespace App\Repositories;

use App\Question;
use App\Repositories\EloquentRepository;
use Exception;

class AnswerRepository extends EloquentRepository {

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Answer::class;
    }

    public function getQuestions ()
    {
        try {
            return Question::latest()->get();
        } catch (Exception $e) {
            return [];
        }
    }

    public function findQuestion ($id)
    {
        return Question::find($id);
    }
}