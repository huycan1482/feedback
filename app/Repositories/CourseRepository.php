<?php

namespace App\Repositories;

use App\Course;
use App\Repositories\EloquentRepository;
use App\Subject;
use App\User;
use Exception;

class CourseRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Course::class;
    }

    public function showModel($id)
    {
        try {
            $result = Course::selectRaw('classes.id as classId, subjects.code as subject, classes.name as class, users.name as teacher, classes.is_active as active')
                ->leftJoin('subjects', 'subjects.id', '=', 'courses.subject_id')
                ->leftJoin('classes', 'classes.course_id', '=', 'courses.id')
                ->join('users', 'classes.teacher_id', '=', 'users.id')
                ->where('course_id', '=', $id)
                ->get();
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getTeachers()
    {
        try {
            $result = User::select('users.*')
                ->leftJoin('roles', 'roles.id', '=', 'users.role_id')
                ->where('roles.name', '=', 'teacher')
                // ->groupBy('users.id')
                ->latest('users.created_at')->get();
            return $result;
        } catch (Exception $e) {
            return [];
        }
    }

    public function getSubjects ()
    {
        try {
            $result = Subject::where('is_active', '=', 1)->latest()->get();
            return $result;
        } catch (Exception $e) {
            return [];
        }

    }

}
