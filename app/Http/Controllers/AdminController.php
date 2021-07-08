<?php

namespace App\Http\Controllers;

use App\ClassRoom;
use App\FeedbackDetail;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index () 
    {
        return view ('admin.dashboard');
    }

    public function getDashboard ()
    {
        // $result = FeedbackDetail::selectRaw('round(sum(answers.point)/(count(answers.id) * 3.00)*100, 2) as result, feedback_details.feedback_id, feedback_details.class_id')
        //     ->join('user_answers', 'user_answers.feedBackDetail_id', '=', 'feedback_details.id')
        //     ->join('useranswer_details', 'user_answers.id', '=', 'useranswer_details.userAnswer_id')
        //     ->join('answers', 'useranswer_details.answer_id', '=', 'answers.id')
        //     ->join('classes', 'classes.id', '=', 'feedback_details.class_id')
        //     ->where('classes.teacher_id', 2)
        //     ->groupBy('feedback_details.id')
        //     ->get();

        // dd($result);

        $teachers = User::select('users.*')
        ->join('classes', 'users.id', '=', 'classes.teacher_id')
        ->join('roles', 'roles.id', '=', 'users.role_id')
        ->join('feedback_details', 'feedback_details.class_id', '=', 'classes.id')
        ->join('user_answers', 'user_answers.feedBackDetail_id', '=', 'feedback_details.id')
        ->where('roles.name', 'teacher')
        ->groupBy('users.id')
        ->get();
        
            
        // $teachers = User::select('users.*')
        // ->join('roles', 'roles.id', '=', 'users.role_id')
        // ->where('roles.name', 'teacher')
        // ->latest()
        // ->get();

        foreach ($teachers as $teacher) {
            $feedback_result = FeedbackDetail::selectRaw('round(sum(answers.point)/(count(answers.id) * 3.00)*100, 2) as result')
                ->join('user_answers', 'user_answers.feedBackDetail_id', '=', 'feedback_details.id')
                ->join('useranswer_details', 'user_answers.id', '=', 'useranswer_details.userAnswer_id')
                ->join('answers', 'useranswer_details.answer_id', '=', 'answers.id')
                ->join('classes', 'classes.id', '=', 'feedback_details.class_id')
                ->where('classes.teacher_id', $teacher->id)
                ->groupBy('feedback_details.id')->get();

            $quantity = 0;
            $sum = 0;

            foreach ($feedback_result as $item) {
                $quantity ++;
                $sum += $item->result;
            }

            $results [$teacher->id] = round($sum/$quantity, 2);
        }

        // dd($results);

        return view ('admin.dashboard.index', [
            'teachers' => $teachers,
            'results' => empty($results) ? '' : $results,
        ]);
    }

    public function getTeacherClasses ($id) 
    {

        $checkTeacher = User::select('users.*')
        ->join('classes', 'users.id', '=', 'classes.teacher_id')
        ->join('roles', 'roles.id', '=', 'users.role_id')
        ->join('feedback_details', 'feedback_details.class_id', '=', 'classes.id')
        ->join('user_answers', 'user_answers.feedBackDetail_id', '=', 'feedback_details.id')
        ->where([['roles.name', '=', 'teacher'], ['users.id', '=', $id]])
        ->groupBy('users.id')
        ->get()->first();

        if (empty($checkTeacher)) {
            return redirect()->route('errors.404');
        }

        $classes = ClassRoom::select('classes.*')
        ->join('feedback_details', 'feedback_details.class_id', '=', 'classes.id')
        ->join('user_answers', 'user_answers.feedBackDetail_id', '=', 'feedback_details.id')
        ->where('teacher_id', $id)
        ->groupBy('classes.id')
        ->get();

        foreach ($classes as $class) {
            $feedback_result = FeedbackDetail::selectRaw('round(sum(answers.point)/(count(answers.id) * 3.00)*100, 2) as result')
                ->join('user_answers', 'user_answers.feedBackDetail_id', '=', 'feedback_details.id')
                ->join('useranswer_details', 'user_answers.id', '=', 'useranswer_details.userAnswer_id')
                ->join('answers', 'useranswer_details.answer_id', '=', 'answers.id')
                ->where('feedback_details.class_id', $class->id)
                ->groupBy('feedback_details.id')->get();

            $quantity = 0;
            $sum = 0;

            foreach ($feedback_result as $item) {
                $quantity ++;
                $sum += $item->result;
            }

            $results [$class->id] = round($sum/$quantity, 2);
           
        }

        return view ('admin.dashboard.teacherClasses', [
            'classes' => $classes,
            'checkTeacher' => $checkTeacher,
            'results' => $results,
        ]);

        

    }

    public function getClassFeedbacks($id) 
    {

    }

    public function getFeedbackResult($id)
    {

    }

}
