<?php

namespace App\Repositories;

use App\Repositories\EloquentRepository;

class SubjectRepository extends EloquentRepository {

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Subject::class;
    }

}