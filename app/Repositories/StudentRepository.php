<?php

namespace App\Repositories;

use App\Repositories\EloquentRepository;
use App\User;
use App\UserClass;

class StudentRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\User::class;
    }

    public function getStudents()
    {
        try {
            return User::leftJoin('roles', 'users.role_id', '=', 'roles.id')
                ->where('roles.name', '=', 'user')
                ->latest('users.created_at')->get('users.*');
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getStudentsWithTrashed()
    {
        try {
            return User::onlyTrashed()
                ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
                ->where('roles.name', '=', 'user')
                ->latest('users.created_at')->get('users.*');
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getCourses()
    {
        try {
            return \App\Course::where('is_active', '=', 1)->latest()->get();
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getRoleUser()
    {
        try {
            return \App\Role::where('name', '=', 'user')->first();
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getLatestStudent()
    {
        try {
            return \App\User::latest()->first();
        } catch (\Exception $e) {
            return null;
        }
    }

    public function createUserClass($class_id)
    {
        try {
            $user_class = new UserClass;
            $user_class->user_id = $this->getLatestStudent()->id;
            $user_class->class_id = (int)$class_id;
            $user_class->is_active = 1;
            $user_class->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getUserDetails($id)
    {
        try {
            return  User::selectRaw('courses.code as course, classes.name as class, subjects.code as subject, user_class.is_active as is_active,
            ( select UNIX_TIMESTAMP(lessons.start_at)*1000 from lessons where lessons.class_id = classes.id order by lessons.start_at asc limit 1) as start_at, 
            ( select UNIX_TIMESTAMP(lessons.start_at)*1000 from lessons where lessons.class_id = classes.id order by lessons.start_at desc limit 1) as end_at ')
                ->join('user_class', 'user_class.user_id', '=', 'users.id')
                ->join('classes', 'classes.id', '=', 'user_class.class_id')
                ->join('courses', 'courses.id', '=', 'classes.course_id')
                ->join('subjects', 'subjects.id', '=', 'courses.subject_id')
                ->where('users.id', '=', $id)
                ->get();
        } catch (\Exception $e) {
            return false;
        }
    }
}
