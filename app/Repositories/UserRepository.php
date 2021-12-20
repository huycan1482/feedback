<?php

namespace App\Repositories;

use App\Repositories\EloquentRepository;
use App\User;

class UserRepository extends EloquentRepository{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\User::class;
    }

    public function createModelByEloquent ($request) 
    {
        $user = new User;
        $user->name = '';
        $user->email = '';
    }

}