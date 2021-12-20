<?php

namespace App\Repositories;

use App\Repositories\EloquentRepository;

class UserClassRepository extends EloquentRepository {
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\User::class;
    }

    public function findUserById ($id)
    {
        try {
            return \App\User::find($id);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function checkUserClass ($class_id, $user_id)
    {
        try {
            return \App\UserClass::where([['class_id', '=', $class_id], ['user_id', '=', $user_id]])->get()->first();
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getCourses () 
    {
        try {
            return \App\Course::where('is_active', '=', 1)->latest()->get();
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getClasses () 
    {
        try {
            return \App\ClassRoom::where('is_active', '=', 1)->latest()->get();
        } catch (\Exception $e) {
            return [];
        }
    }
}