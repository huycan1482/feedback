<?php

namespace App\Repositories;

use App\CheckIn;
use App\Course;
use App\Lesson;
use App\Repositories\EloquentRepository;
use App\Subject;
use App\User;
use Exception;

class CheckInRepository extends EloquentRepository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\CheckIn::class;
    }

    public function getSubjects()
    {
        try {
            return Subject::where('is_active', 1)->latest()->get();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getCoursesBySubject($id)
    {
        try {
            return Course::where(['is_active' => 1, 'subject_id' => $id])->latest()->get();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getClassesByCourse($id)
    {
        try {
            return Course::where(['is_active' => 1, 'subject_id' => $id])->latest()->get();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getLessonsByClass($id)
    {
        try {
            return Lesson::where(['class_id' => $id])->orderBy('start_at', 'desc')->get();
        } catch (Exception $e) {
            return [];
        }
    }

    public function findLesson($id)
    {
        try {
            return Lesson::find($id);
        } catch (Exception $e) {
            return null;
        }
    }

    public function getStudentsByClass($id)
    {
        try {
            return User::select('users.id', 'users.name', 'users.date_of_birth')
                ->join('user_class', 'users.id', '=', 'user_class.user_id')
                ->join('classes', 'user_class.class_id', '=', 'classes.id')
                ->where('classes.id', $id)
                ->get();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getCheckInProperties($classId, $lessonId)
    {
        try {
            $students = $this->getStudentsByClass($classId);

            foreach ($students as $student) {
                $checkLesson = CheckIn::where([['lesson_id', '=', $lessonId], ['user_id', '=', $student->id]])
                    ->get()->first();

                if (empty($checkLesson)) {
                    $checkIn_check[$student->id] = 0;
                    $checkIn_id[$student->id] = 0;
                } else {
                    $checkIn_check[$student->id] = $checkLesson->is_check;
                    $checkIn_id[$student->id] = $checkLesson->id;
                }
            }

            return [
                'checkIn_check' => $checkIn_check,
                'checkIn_id' => $checkIn_check
            ];
        } catch (Exception $e) {
            return [
                'checkIn_check' => [],
                'checkIn_id' => []
            ];
        }
    }
}
