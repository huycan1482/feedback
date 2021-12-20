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
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = $request['password'];
        $user->role_id = $request['role_id'];
        $user->gender = $request['gender'];
        $user->address = $request['address'];
        $user->date_of_birth = $request['date_of_birth'];
        $user->code = $request['code'];
        $user->phone = $request['phone'];
        $user->is_active = $request['is_active'];
        if ($user->save()) {
            $user->identity_code = 100000 + $user->id*1;
            return true;
        } else {
            return false;
        }
        
    }

}