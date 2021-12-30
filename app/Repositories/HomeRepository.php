<?php

namespace App\Repositories;

use App\AnonymousUser;
use App\SurveyAnswer;
use App\SurveyAnswerDetail;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;

class HomeRepository
{

    public function getClassesByTeacherId($id)
    {
        try {
            return \App\ClassRoom::where('teacher_id', '=', $id)->orderBy('id', 'asc')->get();
        } catch (Exception $e) {
            return [];
        }
    }

    public function get1ClassByClassId($first_class)
    {
        try {
            return \App\ClassRoom::selectRaw("classes.id, classes.name, classes.code, courses.name as course, courses.code as course_code, subjects.name as subject, subjects.code as subject_code, 
            count(lessons.id) as total_number,
            (select count(lessons.id) from lessons
            where lessons.class_id = " . $first_class . " and date(now()) < lessons.start_at) as number,
            (select lessons.start_at from lessons
            where lessons.class_id = " . $first_class . " order by lessons.start_at asc limit 1 ) as start_at,
            (select lessons.start_at from lessons
            where lessons.class_id = " . $first_class . " order by lessons.start_at desc limit 1 ) as end_at")
                ->join('lessons', 'lessons.class_id', '=', 'classes.id')
                ->join('courses', 'courses.id', '=', 'classes.course_id')
                ->join('subjects', 'subjects.id', '=', 'courses.subject_id')
                ->where('classes.id', $first_class)
                ->groupBy('classes.id', 'classes.code', 'classes.name', 'courses.name', 'subjects.name', 'course_code', 'subject_code')
                ->get()->first();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getStudentsByClassId($class_id)
    {
        try {
            return \App\User::select('users.id', 'users.name', 'users.date_of_birth')
                ->join('user_class', 'users.id', '=', 'user_class.user_id')
                ->join('classes', 'user_class.class_id', '=', 'classes.id')
                ->where('classes.id', $class_id)
                ->get();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getCheckInByClassId($class_id)
    {
        try {
            $students = $this->getStudentsByClassId($class_id);

            $checkIn = [];
            $user_checkIn = [];

            foreach ($students as $key => $student) {
                $checkIn[$student->id] = DB::select("select classes.code, lessons.id, lessons.start_at, test.is_check, test.id from classes
                    join lessons on lessons.class_id = classes.id
                    left join (select check_in.id, check_in.is_check, check_in.lesson_id from check_in
                    join users on users.id = check_in.user_id
                    where users.id = $student->id) as test on test.lesson_id = lessons.id
                    where classes.id =" . $class_id . " and date(now()) >= lessons.start_at
                    order by lessons.start_at desc");

                $user_checkIn[$student->id] = DB::select("select
                    (select count(check_in.id) from check_in join lessons on check_in.lesson_id = lessons.id where check_in.is_check = 1 and check_in.user_id = $student->id and lessons.class_id = " . $class_id . ") as di_hoc,
                    (select count(check_in.id) from check_in join lessons on check_in.lesson_id = lessons.id where check_in.is_check = 2 and check_in.user_id = $student->id and lessons.class_id = " . $class_id . ") as 'di_muon',
                    (select count(check_in.id) from check_in join lessons on check_in.lesson_id = lessons.id where check_in.is_check = 3 and check_in.user_id = $student->id and lessons.class_id = " . $class_id . ") as 'vang_mat'
                    ");
            }

            return $result = [
                'checkIn' => $checkIn,
                'user_checkIn' => $user_checkIn
            ];
        } catch (Exception $e) {
            return $result = ['checkIn' => [], 'user_checkIn' => []];
        }
    }

    public function getLessonsByClassId($class_id)
    {
        try {
            return \App\ClassRoom::select('classes.code', 'lessons.id', 'lessons.start_at', 'lessons.time_limit')
                ->join('lessons', 'lessons.class_id', '=', 'classes.id')
                ->whereRaw("classes.id = " . $class_id . " and date(now()) >= lessons.start_at")
                ->orderBy('lessons.start_at', 'desc')
                ->get();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getNotesByClassId($class_id)
    {
        try {
            return \App\Lesson::whereRaw("lessons.class_id =" . $class_id . " and lessons.note is not null")->get();
        } catch (Exception $e) {
        }
    }

    public function getEventsByClassId($class_id)
    {
        try {
            $notes = $this->getNotesByClassId($class_id);

            $events = '';

            foreach ($notes as $note) {
                $events .= "{title : '$note->note', start : '$note->start_at'},";
            }

            return $events;
        } catch (Exception $e) {
            return '';
        }
    }

    public function getTotalStudentByClassId($class_id)
    {
        
        try {
            return \App\Lesson::selectRaw('count( DISTINCT check_in.user_id) as total')
                ->join('check_in', 'check_in.lesson_id', '=', 'lessons.id')
                ->rightJoin('users', 'users.id', '=', 'check_in.user_id')
                ->whereRaw("lessons.class_id = " . $class_id)
                ->get()->first();
        } catch (Exception $e) {
            return 0;
        }
    }

    public function getPresentStudentsByClassId ($class_id)
    {
        try {
            return \App\Lesson::selectRaw('count(check_in.user_id) as total')
            ->join('check_in', 'check_in.lesson_id', '=', 'lessons.id')
            ->rightJoin('users', 'users.id', '=', 'check_in.user_id')
            ->whereRaw("lessons.class_id = ". $class_id ." and date(check_in.created_at) = date(current_date() - 1) and check_in.is_check = 1")
            ->get()->first();
        } catch (Exception $e) {
            return 0;
        }
    }

    public function getNotPresentStudentsByClassId ($class_id)
    {
        try {
            return \App\Lesson::selectRaw('count(check_in.user_id) as total')
            ->join('check_in', 'check_in.lesson_id', '=', 'lessons.id')
            ->rightJoin('users', 'users.id', '=', 'check_in.user_id')
            ->whereRaw("lessons.class_id = ". $class_id ." and date(check_in.created_at) = date(current_date() - 1) and check_in.is_check = 2")
            ->get()->first();
        } catch (Exception $e) {
            return 0;
        }
    }

    public function getLateStudentsByClassId ($class_id)
    {
        try {
            return \App\Lesson::selectRaw('count(check_in.user_id) as total')
            ->join('check_in', 'check_in.lesson_id', '=', 'lessons.id')
            ->rightJoin('users', 'users.id', '=', 'check_in.user_id')
            ->whereRaw("lessons.class_id = ". $class_id ." and date(check_in.created_at) = date(current_date() - 1) and check_in.is_check = 3")
            ->get()->first();
        } catch (Exception $e) {
            return 0;
        }
    }

    public function checkCheckIn ($time, $user_id)
    {
        try {
            $result = \App\CheckIn::whereRaw("date(created_at) = '". $time ."' and lesson_id = ".$user_id )->get()->first();
            return (!empty($result) ) ? true : false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function checkUser ($user_id, $class_id)
    {
        try {
            $result = \App\User::select('users.id')
            ->join('user_class', 'user_class.user_id', '=', 'users.id')
            ->join('classes', 'classes.id', '=', 'user_class.class_id')
            ->where([['users.id', $user_id], ['classes.id', $class_id]])
            ->get()->first();
            return (empty($result)) ? true : false; 
        } catch (Exception $e) {
            return false;
        }
    }

    public function storeAnonymousUser($request) {
        $anonymous_user = new AnonymousUser();
        if (!empty($request['identity'])) {
            $user = User::where('identity_code', $request['identity'])->get();
            if (!empty($user->first())) {
                $anonymous_user->user_identity = $user->first()->id;
                $anonymous_user->name = $user->first()->name;
                $anonymous_user->email = $user->first()->email;
                $anonymous_user->phone = $user->first()->phone;
                $anonymous_user->address = $user->first()->address;
            }
        } else {
            $anonymous_user->name = $request['name'];
            $anonymous_user->email = $request['email'];
            $anonymous_user->phone = (!empty($request['phone'])) ? $request['phone'] : '';
            $anonymous_user->address = (!empty($request['address'])) ? $request['address'] : '';
        }

        $anonymous_user->facebook_link = (!empty($request['facebook_link'])) ? $request['facebook_link'] : '';
            
        if ($anonymous_user->save()) {
            return $anonymous_user->id;
        } else {
            return 0;
        }
    }

    public function storeSurveyAnswer($request, $anonymous_user_id) 
    {
        $survey_answer = new SurveyAnswer();
        $survey_answer->anonymous_user_id = $anonymous_user_id;
        $survey_answer->feedback_id = $request['feedback_id'];
        $survey_answer->opinion = (!empty($request['opinion'])) ? $request['opinion'] : '';
        $survey_answer->status = 1;

        if ($survey_answer->save()) {

            return $survey_answer->id;
        } else {
            return 0;
        }
    }

    public function storeSurveyAnswerDetail($request, $survey_answer_id) 
    {
        // dd($request);
        DB::beginTransaction();
        try { 
            if (!empty($request['feedback_radio'])) {
                foreach ($request['feedback_radio'] as $key => $item) {
                    $survey_answer_detail = new SurveyAnswerDetail();
                    $survey_answer_detail->survey_answer_id = $survey_answer_id;
                    $survey_answer_detail->answer_id = $item['answer_id'];
                    $survey_answer_detail->question_id = $item['question_id'];
                    $survey_answer_detail->question_type = 1;
                    if ($survey_answer_detail->save()) {

                    } else {
                        throw new Exception();
                    }
                }
            } 
    
            if (!empty($request['feedback_checkbox'])) {
                foreach ($request['feedback_checkbox'] as $item) {
                    $survey_answer_detail = new SurveyAnswerDetail();
                    $survey_answer_detail->survey_answer_id = $survey_answer_id;
                    $survey_answer_detail->answer_id = $item['answer_id'];
                    $survey_answer_detail->question_id = $item['question_id'];
                    $survey_answer_detail->question_type = 2;
                    if ($survey_answer_detail->save()) {

                    } else {
                        throw new Exception();
                    }
                }
            }
    
            if (!empty($request['feedback_text'])) {

                foreach ($request['feedback_text'] as $item) {
                    $survey_answer_detail = new SurveyAnswerDetail();
                    $survey_answer_detail->survey_answer_id = $survey_answer_id;
                    $survey_answer_detail->question_id = $item['question_id'];
                    $survey_answer_detail->answer_text = $item['answer'];
                    $survey_answer_detail->question_type = 3;

                    if ($survey_answer_detail->save()) {

                    } else {
                        throw new Exception();
                    }    
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return 0;
        }

        return 1;
    }
}

