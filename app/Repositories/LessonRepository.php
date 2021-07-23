<?php

namespace App\Repositories;

use App\Lesson;
use App\Repositories\EloquentRepository;
use Exception;

class LessonRepository extends EloquentRepository {

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Lesson::class;
    }

    public function checkLessonExists ($class_id, $start_at)
    {
        try {
            $result = Lesson::where([['class_id', '=', $class_id], ['start_at', '=', $start_at]])->get()->first();
            return (empty($result)) ? false : true;
        } catch (Exception $e) {
            return false;
        }
    }

}