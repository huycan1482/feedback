<?php

namespace App\Repositories;

use App\Repositories\EloquentRepository;

class UserRepository extends EloquentRepository{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\User::class;
    }

}