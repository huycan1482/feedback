<?php

namespace App\Http\Controllers;

use App\CheckIn;
use App\ClassRoom;
use App\FeedBack;
use App\Lesson;
use App\User;
use App\UserAnswer;
use App\UserAnswerDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('feedback.home');
    }

    public function getCheckIn ()
    {

        $currentUser = User::findOrFail(Auth()->user()->id);

        if ( $currentUser->can('viewCheckIn', User::class) ) {

            $classes = ClassRoom::where('teacher_id', '=', Auth()->user()->id)->orderBy('id', 'asc')->get();

            if (empty($classes->first())) {
                return view ('feedback.checkIn');
            }

            $class = DB::table('classes')
            ->selectRaw("classes.id, classes.name, classes.code, courses.name as course, courses.code as course_code, subjects.name as subject, subjects.code as subject_code, 
            count(lessons.id) as total_number,
            (select count(lessons.id) from lessons
            where lessons.class_id = ". $classes->first()->id ." and date(now()) < lessons.start_at) as number,
            (select lessons.start_at from lessons
            where lessons.class_id = ". $classes->first()->id ." order by lessons.start_at asc limit 1 ) as start_at,
            (select lessons.start_at from lessons
            where lessons.class_id = ". $classes->first()->id ." order by lessons.start_at desc limit 1 ) as end_at")
            ->join('lessons', 'lessons.class_id', '=', 'classes.id')
            ->join('courses', 'courses.id', '=', 'classes.course_id')
            ->join('subjects', 'subjects.id', '=', 'courses.subject_id')
            ->where('classes.id', $classes->first()->id)
            ->groupBy('classes.id', 'classes.code', 'classes.name', 'courses.name', 'subjects.name', 'course_code', 'subject_code')
            ->get()->first();

            $students = DB::table('users')
            ->select('users.id', 'users.name', 'users.date_of_birth')
            ->join('user_class', 'users.id', '=', 'user_class.user_id')
            ->join('classes', 'user_class.class_id', '=', 'classes.id')
            ->where('classes.id', $classes->first()->id)
            ->get();

            $lessons = DB::table('classes')
            ->select('classes.code', 'lessons.id', 'lessons.start_at')
            ->join('lessons', 'lessons.class_id', '=', 'classes.id')
            ->whereRaw("classes.id = ".$classes->first()->id." and date(now()) >= lessons.start_at")
            ->orderBy('lessons.start_at', 'desc')
            ->get();
 
            $checkIn = [];
            $user_checkIn = [];

            foreach ($students as $key => $student) {
                $checkIn [$student->id] = DB::select("select classes.code, lessons.id, lessons.start_at, test.is_check, test.id from classes
                    join lessons on lessons.class_id = classes.id
                    left join (select check_in.id, check_in.is_check, check_in.lesson_id from check_in
                    join users on users.id = check_in.user_id
                    where users.id = $student->id) as test on test.lesson_id = lessons.id
                    where classes.id =". $classes->first()->id ." and date(now()) >= lessons.start_at
                    order by lessons.start_at desc");

                $user_checkIn [$student->id] = DB::select("select
                    (select count(check_in.id) from check_in join lessons on check_in.lesson_id = lessons.id where check_in.is_check = 1 and check_in.user_id = $student->id and lessons.class_id = ".$classes->first()->id.") as di_hoc,
                    (select count(check_in.id) from check_in join lessons on check_in.lesson_id = lessons.id where check_in.is_check = 2 and check_in.user_id = $student->id and lessons.class_id = ".$classes->first()->id.") as 'di_muon',
                    (select count(check_in.id) from check_in join lessons on check_in.lesson_id = lessons.id where check_in.is_check = 3 and check_in.user_id = $student->id and lessons.class_id = ".$classes->first()->id.") as 'vang_mat'
                    ");
            }

            // dd($checkIn, $user_checkIn);

            $notes = Lesson::whereRaw("lessons.class_id =". $classes->first()->id ." and lessons.note is not null")->get();

            $events = '';

            foreach ($notes as $note) {
                $events .= "{title : '$note->note', start : '$note->updated_at'},";
            }


            $total_student = Lesson::selectRaw('count(check_in.user_id) as total')
                ->join('check_in', 'check_in.lesson_id', '=', 'lessons.id')
                ->rightJoin('users', 'users.id', '=', 'check_in.user_id')
                ->whereRaw("lessons.class_id = ". $classes->first()->id ." and date(check_in.created_at) = date(current_date())")
                ->get()->first();
            
            $present = Lesson::selectRaw('count(check_in.user_id) as total')
                ->join('check_in', 'check_in.lesson_id', '=', 'lessons.id')
                ->rightJoin('users', 'users.id', '=', 'check_in.user_id')
                ->whereRaw("lessons.class_id = ". $classes->first()->id ." and date(check_in.created_at) = date(current_date()) and check_in.is_check = 1")
                ->get()->first();

            $late = Lesson::selectRaw('count(check_in.user_id) as total')
                ->join('check_in', 'check_in.lesson_id', '=', 'lessons.id')
                ->rightJoin('users', 'users.id', '=', 'check_in.user_id')
                ->whereRaw("lessons.class_id = ". $classes->first()->id ." and date(check_in.created_at) = date(current_date()) and check_in.is_check = 2")
                ->get()->first();

            $not_present = Lesson::selectRaw('count(check_in.user_id) as total')
                ->join('check_in', 'check_in.lesson_id', '=', 'lessons.id')
                ->rightJoin('users', 'users.id', '=', 'check_in.user_id')
                ->whereRaw("lessons.class_id = ". $classes->first()->id ." and date(check_in.created_at) = date(current_date()) and check_in.is_check = 3")
                ->get()->first();
                

            return view ('feedback.checkIn', [
                'classes' => $classes,
                'class' => $class, 
                'lessons' => $lessons,
                'students' => $students,
                'checkIn' => $checkIn,
                'user_checkIn' => $user_checkIn,
                'events' => $events,
                'total_student' => $total_student,
                'present' => $present,
                'late' => $late,
                'not_present' => $not_present,
            ]);
        } else {
            dd('forbidden');
            return view('');
        }
        
        
    }

    public function getCheckInId ($id)
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ( $currentUser->can('viewCheckIn', User::class) ) {

            if (empty(ClassRoom::find($id))) {
                return view ('feedback.checkIn');
            }

            $classes = ClassRoom::where('teacher_id', '=', Auth()->user()->id)->orderBy('id', 'asc')->get();

            $class = DB::table('classes')
            ->selectRaw("classes.id, classes.name, classes.code, courses.name as course, courses.code as course_code, subjects.name as subject, subjects.code as subject_code, 
            count(lessons.id) as total_number,
            (select count(lessons.id) from lessons
            where lessons.class_id = ". $id ." and date(now()) < lessons.start_at) as number,
            (select lessons.start_at from lessons
            where lessons.class_id = ". $id ." order by lessons.start_at asc limit 1 ) as start_at,
            (select lessons.start_at from lessons
            where lessons.class_id = ". $id ." order by lessons.start_at desc limit 1 ) as end_at")
            ->join('lessons', 'lessons.class_id', '=', 'classes.id')
            ->join('courses', 'courses.id', '=', 'classes.course_id')
            ->join('subjects', 'subjects.id', '=', 'courses.subject_id')
            ->where('classes.id', $id)
            ->groupBy('classes.id', 'classes.code', 'classes.name', 'courses.name', 'subjects.name', 'course_code', 'subject_code')
            ->get()->first();

            $students = DB::table('users')
            ->select('users.id', 'users.name', 'users.date_of_birth')
            ->join('user_class', 'users.id', '=', 'user_class.user_id')
            ->join('classes', 'user_class.class_id', '=', 'classes.id')
            ->where('classes.id', $id)
            ->get();

            // $lessons = DB::table('classes')
            // ->select('classes.code', 'lessons.id', 'lessons.start_at')
            // ->join('lessons', 'lessons.class_id', '=', 'classes.id')
            // ->whereRaw("classes.id = ".$id." and date(now()) >= date(lessons.start_at)")
            // ->orderBy('lessons.start_at', 'desc')
            // ->get();

            $lessons = DB::table('classes')
            ->select('classes.code', 'lessons.id', 'lessons.start_at')
            ->join('lessons', 'lessons.class_id', '=', 'classes.id')
            ->whereRaw("classes.id = ".$id." ")
            ->orderBy('lessons.start_at', 'desc')
            ->get();

            $checkIn = [];
            $user_checkIn = [];

            foreach ($students as $key => $student) {
                // $checkIn [$student->id] = DB::select("select classes.code, lessons.id, lessons.start_at, test.is_check, test.id from classes
                //     join lessons on lessons.class_id = classes.id
                //     left join (select check_in.id, check_in.is_check, check_in.lesson_id from check_in
                //     join users on users.id = check_in.user_id
                //     where users.id = $student->id) as test on test.lesson_id = lessons.id
                //     where classes.id =". $id ." and date(now()) >= date(lessons.start_at)
                //     order by lessons.start_at desc");

                $checkIn [$student->id] = DB::select("select classes.code, lessons.id, lessons.start_at, test.is_check, test.id from classes
                    join lessons on lessons.class_id = classes.id
                    left join (select check_in.id, check_in.is_check, check_in.lesson_id from check_in
                    join users on users.id = check_in.user_id
                    where users.id = $student->id) as test on test.lesson_id = lessons.id
                    where classes.id =". $id ." 
                    order by lessons.start_at desc");

                $user_checkIn [$student->id] = DB::select("select
                    (select count(check_in.id) from check_in join lessons on check_in.lesson_id = lessons.id where check_in.is_check = 1 and check_in.user_id = $student->id and lessons.class_id = ".$id.") as di_hoc,
                    (select count(check_in.id) from check_in join lessons on check_in.lesson_id = lessons.id where check_in.is_check = 2 and check_in.user_id = $student->id and lessons.class_id = ".$id.") as 'di_muon',
                    (select count(check_in.id) from check_in join lessons on check_in.lesson_id = lessons.id where check_in.is_check = 3 and check_in.user_id = $student->id and lessons.class_id = ".$id.") as 'vang_mat'
                    ");
            }

            // dd($user_checkIn, $checkIn);

            $notes = Lesson::whereRaw("lessons.class_id =". $id ." and lessons.note is not null")->get();

            $events = '';

            foreach ($notes as $note) {
                $events .= "{title : '$note->note', start : '$note->updated_at'},";
            }

            $total_student = Lesson::selectRaw('count(check_in.user_id) as total')
                ->join('check_in', 'check_in.lesson_id', '=', 'lessons.id')
                ->rightJoin('users', 'users.id', '=', 'check_in.user_id')
                ->whereRaw("lessons.class_id = ". $id ." and date(check_in.created_at) = date(current_date())")
                ->get()->first();
            
            $present = Lesson::selectRaw('count(check_in.user_id) as total')
                ->join('check_in', 'check_in.lesson_id', '=', 'lessons.id')
                ->rightJoin('users', 'users.id', '=', 'check_in.user_id')
                ->whereRaw("lessons.class_id = ". $id ." and date(check_in.created_at) = date(current_date()) and check_in.is_check = 1")
                ->get()->first();

            $late = Lesson::selectRaw('count(check_in.user_id) as total')
                ->join('check_in', 'check_in.lesson_id', '=', 'lessons.id')
                ->rightJoin('users', 'users.id', '=', 'check_in.user_id')
                ->whereRaw("lessons.class_id = ". $id ." and date(check_in.created_at) = date(current_date()) and check_in.is_check = 2")
                ->get()->first();

            $not_present = Lesson::selectRaw('count(check_in.user_id) as total')
                ->join('check_in', 'check_in.lesson_id', '=', 'lessons.id')
                ->rightJoin('users', 'users.id', '=', 'check_in.user_id')
                ->whereRaw("lessons.class_id = ". $id ." and date(check_in.created_at) = date(current_date()) and check_in.is_check = 3")
                ->get()->first();

            return view ('feedback.checkIn', [
                'classes' => $classes,
                'class' => $class, 
                'lessons' => $lessons,
                'students' => $students,
                'checkIn' => $checkIn,
                'user_checkIn' => $user_checkIn,
                'events' => $events,
                'total_student' => $total_student,
                'present' => $present,
                'late' => $late,
                'not_present' => $not_present
            ]);
        } else {
            dd('forbidden');
            return view('');
        }
        
    }

    public function postCheckIn (Request $request)
    {
        dd($request->all());

        $today = Carbon::now('Asia/Ho_Chi_Minh');
        
        $checkCheckIn = CheckIn::whereRaw("date(created_at) = '". $today->toDateString() ."' and lesson_id = ".$request->input('id') )->get();

        if(!empty($checkCheckIn->first())) {
            return response()->json(['mess' => 'Thêm bản ghi lỗi, bạn đã điểm danh trước đó'], 400);
        }

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:lessons,id',
            'checkIn' => 'required|array',
        ], [
            'id.required' => 'Yêu cầu không để trống',
            'id.exists' => 'Dữ liệu không tồn tại',
            'checkIn.array' => 'Sai kiểu dữ liệu',
            'checkIn.required' => 'Yêu cầu không để trống',
        ]);

        $errs = $validator->errors();

        if ( $validator->fails() ) {
            return response()->json(['errors' => $errs, 'mess' => 'Thêm bản ghi lỗi'], 400);
        } else {

            $today = date("Y-m-d");

            $lesson = Lesson::find($request->input('id'));

            if (date_format(date_create($lesson->start_at), 'Y-m-d') != $today) {
            // if(false) {
                return response()->json(['mess' => 'Thêm bản ghi lỗi'], 400);
            } else {
                $lesson = Lesson::find($request->input('id'));

                $lesson->note = $request->input('note');

                $checkUser = DB::table('users')->select('users.id')
                    ->join('user_class', 'user_class.user_id', '=', 'users.id')
                    ->join('classes', 'classes.id', '=', 'user_class.class_id')
                    ->where([['users.id', 140], ['classes.id', $lesson->class_id]])
                    ->get()->first(); 

                DB::beginTransaction();

                try {
                    $lesson->save();

                    foreach ($request->input(['checkIn']) as $key => $item) {

                        $validator2 = Validator::make($item, [
                            'id' => 'required',
                            'val' => 'required|min:1|max:3',
                        ], [
                            'id.required' => 'Yêu cầu không để trống',
                            'val.required' => 'Yêu cầu không để trống',
                            // 'val.numeric' => 'Sai kiểu dữ liệu',
                            'val.min' => 'Sai kiểu dữ liệu',
                            'val.max' => 'Sai kiểu dữ liệu',
                        ]);

                        $errs2 = $validator2->errors();

                        if ( $validator2->fails() ) {
                            return response()->json(['errors' => $errs2, 'mess' => 'Thêm bản ghi lỗi'], 400);
                        } else {

                            $checkUser = DB::table('users')->select('users.id')
                                ->join('user_class', 'user_class.user_id', '=', 'users.id')
                                ->join('classes', 'classes.id', '=', 'user_class.class_id')
                                ->where([['users.id', $item["id"]], ['classes.id', $lesson->class_id]])
                                ->get()->first();   

                            if (empty($checkUser)) {
                                return response()->json(['mess' => 'Thêm bản ghi lỗi'], 400);
                            } else {
                                $checkIn = new CheckIn;
                                $checkIn->user_id = $item["id"];
                                $checkIn->lesson_id = $lesson->id;
                                $checkIn->is_check = $item["val"]; 
                                $checkIn->save();
                            }
                        }
                            
                    }
                        
                    DB::commit();

                } catch (Exception $e) {
                    DB::rollBack();
                    return response()->json(['mess' => 'Thêm bản ghi lỗi'], 502);
                }

                return response()->json(['mess' => 'Thêm bản ghi thành công', 200]);

            }
        }
    }

    public function getFeedback ()
    {

        $classes = ClassRoom::select('classes.*')
            ->join('user_class', 'user_class.class_id', '=', 'classes.id')
            ->leftJoin('feedback_details', 'classes.id', 'feedback_details.class_id')
            ->where([['user_class.user_id', Auth::user()->id], ['feedback_details.is_active', '=', 1]]) 
            ->groupBy('classes.id')
            ->orderBy('user_class.created_at', 'asc')
            ->get();

        if (empty($classes->first())) {
            return redirect()->route('errors.general')->withMessage('Bạn chưa đăng kí lớp học nào');
        } 

        foreach ( $classes as $key => $item ) {
            $checkFeedback = ClassRoom::selectRaw('count(check_in.id) * 100 / count(lessons.id) as percent')
            ->join('user_class', 'user_class.class_id', '=', 'classes.id')
            ->join('lessons', 'classes.id', '=', 'lessons.class_id')
            ->leftJoin('check_in', 'lessons.id', '=', 'check_in.lesson_id')
            ->where([['user_class.user_id', '=', Auth::user()->id], ['classes.id', '=', $item->id]])
            ->get();

            // if ($checkFeedback->first()->percent < 80) {
            //     $classes->forget($key);   
            // }
        }

        if (empty($classes->first())) {
            return redirect()->route('errors.general')->withMessage('Bạn không có bài khảo sát nào');
        } 

        foreach ($classes as $item) {
            if (!empty($item->feedback->first())) {
                $first_feedback = $item->feedback->first()->id;
                $first_class = $item->id;
                break;
            }
        }

        // DB::enableQueryLog();
        $classRoom = DB::table('classes')
            ->selectRaw("classes.id, classes.name, classes.code, courses.name as course, courses.code as course_code, subjects.name as subject, subjects.code as subject_code, users.name as 'teacher', 
            count(lessons.id) as total_number,
            (select count(lessons.id) from lessons
            where lessons.class_id = ". $first_class ." and date(now()) < lessons.start_at) as number,
            (select lessons.start_at from lessons
            where lessons.class_id = ". $first_class ." order by lessons.start_at asc limit 1 ) as start_at,
            (select lessons.start_at from lessons
            where lessons.class_id = ". $first_class ." order by lessons.start_at desc limit 1 ) as end_at")
            ->leftJoin('users', 'users.id', '=', 'classes.teacher_id')
            ->join('lessons', 'lessons.class_id', '=', 'classes.id')
            ->join('courses', 'courses.id', '=', 'classes.course_id')
            ->join('subjects', 'subjects.id', '=', 'courses.subject_id')
            ->where('classes.id', $first_class)
            ->groupBy('classes.id', 'classes.code', 'classes.name', 'courses.name', 'subjects.name', 'course_code', 'subject_code')
            ->get()->first(); 

        // dd(DB::getQueryLog());

        // dd($classRoom);
    
        $feedBack = FeedBack::findOrFail($first_feedback);
        // $data = [];
        foreach ($feedBack->question as $key => $item) {
            // dd($feedBack->question);
            $arr = [];

            foreach($item->answers as $item2) {
                $arr [] = [
                    'id' => $item2->id,
                    'content' => $item2->content,
                ];
            }

            shuffle($arr);

            $data [] = [
                'id' => $item->id, 
                'code' => $item->code,
                'content' => $item->content,
                'answers' => $arr,
            ];
        }

        // dd($data);

        shuffle($data);

        foreach ($feedBack->classRoom as $item) {
            if ($item->id == $first_class) {
                $feedback_detail = $item->pivot->id;
                break;
            }
        }
        // dd($feedback_detail);
        $checkUserAnswer = UserAnswer::join('feedback_details', 'user_answers.feedBackDetail_id', '=', 'feedback_details.id')
        ->where([['user_answers.user_id', '=', Auth::user()->id], 
        ['feedback_details.feedback_id', '=', $first_feedback], 
        ['feedback_details.class_id', '=', $classRoom->id]])->get();

        return view ('feedback.feedback', [
            'classes' => $classes,
            'data' => $data,
            'classRoom' => $classRoom,
            'feedback_detail' => $feedback_detail,
            'feedback_id' => $feedBack,
            'checkUserAnswer' => $checkUserAnswer,
        ]);
    }

    public function getFeedbackId($class_id, $feedback_id)
    {
        $classes = ClassRoom::select('classes.*')
            ->join('user_class', 'user_class.class_id', '=', 'classes.id')
            ->leftJoin('feedback_details', 'classes.id', 'feedback_details.class_id')
            ->where([['user_class.user_id', Auth::user()->id], ['feedback_details.is_active', '=', 1]]) 
            ->groupBy('classes.id')
            ->orderBy('user_class.created_at', 'asc')
            ->get();

        if (empty($classes->first())) {
            return redirect()->route('errors.general')->withMessage('Bạn chưa đăng kí lớp học nào');
        } 

        ClassRoom::findOrFail($class_id);

        foreach ( $classes as $key => $item ) {
            $checkFeedback = ClassRoom::selectRaw('count(check_in.id) * 100 / count(lessons.id) as percent')
            ->join('user_class', 'user_class.class_id', '=', 'classes.id')
            ->join('lessons', 'classes.id', '=', 'lessons.class_id')
            ->leftJoin('check_in', 'lessons.id', '=', 'check_in.lesson_id')
            ->where([['user_class.user_id', '=', Auth::user()->id], ['classes.id', '=', $item->id]])
            ->get();

            // dd($checkFeedback);
            // if ($checkFeedback->first()->percent < 80) {
            //     $classes->forget($key);   

            //     if ($item->id == $class_id) {
            //         return redirect()->route('errors.general')->withMessage('Bạn không có bài khảo sát nào');
            //     }
            // }
            
        }

        $classRoom = DB::table('classes')
            ->selectRaw('classes.id, classes.name, classes.code, courses.name as course, courses.code as course_code, subjects.name as subject, subjects.code as subject_code, users.name as teacher,
            count(lessons.id) as total_number,
            (select count(lessons.id) from lessons
            where lessons.class_id = 5 and date(now()) < lessons.start_at) as number,
            (select lessons.start_at from lessons
            where lessons.class_id = 5 order by lessons.start_at asc limit 1 ) as start_at,
            (select lessons.start_at from lessons
            where lessons.class_id = 5 order by lessons.start_at desc limit 1 ) as end_at')
            ->leftJoin('users', 'users.id', '=', 'classes.teacher_id')
            ->join('lessons', 'lessons.class_id', '=', 'classes.id')
            ->join('courses', 'courses.id', '=', 'classes.course_id')
            ->join('subjects', 'subjects.id', '=', 'courses.subject_id')
            ->where('classes.id', $class_id)
            ->groupBy('classes.id', 'classes.code', 'classes.name', 'courses.name', 'subjects.name', 'course_code', 'subject_code')
            ->get()->first(); 
    
        $feedBack = FeedBack::findOrFail($feedback_id);

        // dd($feedBack->question);

        foreach ($feedBack->question as $key => $item) {
            $arr = [];

            foreach($item->answers as $item2) {
                $arr [] = [
                    'id' => $item2->id,
                    'content' => $item2->content,
                ];
            }

            shuffle($arr);

            $data [] = [
                'id' => $item->id, 
                'code' => $item->code,
                'content' => $item->content,
                'answers' => $arr,
            ];
        }

        shuffle($data);

        foreach ($feedBack->classRoom as $item) {
            if ($item->id == $class_id) {
                $feedback_detail = $item->pivot->id;
                break;
            }
        }

        DB::enableQueryLog(); 

        $checkUserAnswer = UserAnswer::join('feedback_details', 'user_answers.feedBackDetail_id', '=', 'feedback_details.id')
        ->where([['user_answers.user_id', '=', Auth::user()->id], 
        ['feedback_details.feedback_id', '=', $feedback_id], 
        ['feedback_details.class_id', '=', $class_id]])->get();

        // dd(DB::getQueryLog()); 

        // dd($checkUserAnswer);
        return view ('feedback.feedback', [
            'classes' => $classes,
            'data' => $data,
            'classRoom' => $classRoom,
            'feedback_detail' => $feedback_detail,
            'feedback_id' => $feedBack,
            'checkUserAnswer' => $checkUserAnswer,
        ]);
    }

    public function postFeedback (Request $request)
    {
        // dd(count($request->input('feedback')));

        $checkUserAnswer = UserAnswer::join('feedback_details', 'user_answers.feedBackDetail_id', '=', 'feedback_details.id')
        ->where([['user_answers.user_id', '=', Auth::user()->id], 
        ['feedback_details.feedback_id', '=', $request->input('feedback_id')], 
        ['feedback_details.class_id', '=', $request->input('class_id')]])->get();

        // dd(empty($checkUserAnswer->first()));
        if($checkUserAnswer->first()) {
            return response()->json(['mess' => 'Gửi bản ghi lỗi, bạn đã hoàn thành trước đó'], 400);
        }

        $validator = Validator::make($request->all(), [
            'feedback_id' => 'required|exists:feedbacks,id',
            'feedback' => 'required|array',
            'feedback_detail' => 'required|exists:feedback_details,id',
            'note' => 'nullable|string'
        ], [
            'feedback_id.required' => 'Yêu cầu không để trống',
            'feedback_id.exists' => 'User không tồn tại',
            'feedback.required' => 'Yêu cầu không để trống',
            'feedback.array' => 'Sai kiểu dữ liệu',

            'feedback_detail.required' => 'Yêu cầu không để trống',
            'feedback_detail.exists' => 'Dữ liệu không tồn tại',

            'note.string' => 'Sai kiểu dữ liệu',
        ]);

        $errs = $validator->errors();

        $feedback = FeedBack::find($request->input('feedback_id'));
    
        if ( $validator->fails() ) {
            return response()->json(['errors' => $errs, 'mess' => 'Gửi bản ghi lỗi'], 400);
        } else if ($feedback->question->count() != count($request->input('feedback'))) {
            return response()->json(['mess' => 'Gửi bản ghi lỗi, bạn chưa hoàn thành bài làm'], 400);
        } else {
            // dd($feedback,  count($request->input('feedback')));

            $user_answer = new UserAnswer;
            $user_answer->user_id = Auth::user()->id;
            $user_answer->feedBackDetail_id = $request->input('feedback_detail');
            $user_answer->opinion = $request->input('note') ? $request->input('note') : '';
            $user_answer->status = 1;

            DB::beginTransaction();

            try {
                $user_answer->save();

                $latestUserAnswer = UserAnswer::where([ 'user_id' => Auth::user()->id ], ['feedBackDetail_id' => $request->input('feedback_detail')])->latest();

                foreach ($request->input('feedback') as $item) {
                    // dd($item['question_id']);
                    $userAnswer_detail = new UserAnswerDetail;
                    $userAnswer_detail->userAnswer_id = $latestUserAnswer->first()->id;
                    $userAnswer_detail->answer_id = $item['answer_id'];
                    $userAnswer_detail->save();
                }

                DB::commit();

            } catch (Exception $e) {
                DB::rollBack();
                return response()->json(['mess' => 'Thêm bản ghi lỗi'], 502);
            }

            return response()->json(['mess' => 'Gửi bài làm thành công', 200]);

        }
    }

    public function getProfile ()
    {
        $user = Auth::user();
        return view ('feedback.profile', [
            'user' => $user,
        ]);
    }

    public function updateProfile (Request $request, $id)
    {
        if (Auth::user()->id == $id) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'code' => 'required|unique:users,code,'.$id,
                'gender' => 'required|integer|min:0|max:1',
                'date_of_birth' => 'required|date_format:"Y-m-d"',
                'phone' => 'required|size:10',
                'address' => 'required',
                'email' => 'required|string|email|max:255|unique:users,email,'.$id,
                'password' => 'nullable|string|min:8|confirmed',
                'is_active' => 'integer|boolean',

            ], [
                'name.required' => 'Yêu cầu không để trống',
                'code.required' => 'Yêu cầu không để trống',
                'code.unique' => 'Dữ liệu bị trùng',
                'gender.required' => 'Yêu cầu không để trống',
                'gender.integer' => 'Sai kiểu dữ liệu',
                'gender.min' => 'Sai kiểu dữ liệu',
                'gender.max' => 'Sai kiểu dữ liệu',
                'date_of_birth.required' => 'Yêu cầu không để trống',
                'date_of_birth.date_format' => 'Sai kiểu dữ liệu',
                'phone.required' => 'Yêu cầu không để trống',
                'phone.size' => 'Sai kiểu dữ liệu',
                'address.required' => 'Yêu cầu không để trống',
                'email.required' => 'Yêu cầu không để trống',
                'email.email' => 'Yêu cầu email',
                'email.unique' => 'Email đã tồn tại',
                'password.min' => 'Độ dài phải lớn hơn 8 kí tự',
                'password.confirmed' => 'Nhập lại mật khẩu không khớp',
                'is_active.integer' => 'Sai kiểu dữ liệu',
                'is_active.boolean' => 'Sai kiểu dữ liệu',
            ]);
    
            $errs = $validator->errors();
    
            if ( $validator->fails() ) {
                return response()->json(['errors' => $errs, 'mess' => 'Sửa bản ghi lỗi'], 400);
            } else {
                $user = User::find($id);
                $user->name = $request->input('name');
                $user->code = $request->input('code');
                $user->gender = $request->input('gender');
                $user->date_of_birth = $request->input('date_of_birth');
                $user->phone = $request->input('phone');
                $user->address = $request->input('address');
                $user->email = $request->input('email');
                if (!empty($request->input('password'))) {
                    $user->password = Hash::make($request->input('password'));
                }

                if ($user->save()) {
                    return response()->json(['mess' => 'Sửa bản ghi thành công', 200]);
                } else {
                    return response()->json(['mess' => 'Sửa bản ghi lỗi'], 502);
                }
                
            }
        } else {
            return response()->json(['mess' => 'Hành động bị cấm'], 403);
        }
    }
}
