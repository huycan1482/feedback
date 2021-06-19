<?php

namespace App\Http\Controllers;

use App\CheckIn;
use App\ClassRoom;
use App\FeedBack;
use App\Lesson;
use App\User;
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

            $class = DB::table('classes')
            ->selectRaw('classes.id, classes.name, classes.code, courses.name as course, courses.code as course_code, subjects.name as subject, subjects.code as subject_code, 
            count(lessons.id) as total_number,
            (select count(lessons.id) from lessons
            where lessons.class_id = 5 and date(now()) < lessons.start_at) as number,
            (select lessons.start_at from lessons
            where lessons.class_id = 5 order by lessons.start_at asc limit 1 ) as start_at,
            (select lessons.start_at from lessons
            where lessons.class_id = 5 order by lessons.start_at desc limit 1 ) as end_at')
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
            ->whereRaw("classes.id = ".$classes->first()->id." and date(now()) > lessons.start_at")
            ->orderBy('lessons.start_at', 'asc')
            ->get();

            foreach ($students as $key => $student) {
                $checkIn [$student->id] = DB::select("select classes.code, lessons.id, lessons.start_at, test.is_check, test.id from classes
                    join lessons on lessons.class_id = classes.id
                    left join (select check_in.id, check_in.is_check, check_in.lesson_id from check_in
                    join users on users.id = check_in.user_id
                    where users.id = $student->id) as test on test.lesson_id = lessons.id
                    where classes.id =". $classes->first()->id ." and date(now()) > lessons.start_at
                    order by lessons.start_at asc");

                $user_checkIn [$student->id] = DB::select("select
                    (select count(check_in.id) from check_in join lessons on check_in.lesson_id = lessons.id where check_in.is_check = 1 and check_in.user_id = $student->id and lessons.class_id = ".$classes->first()->id.") as di_hoc,
                    (select count(check_in.id) from check_in join lessons on check_in.lesson_id = lessons.id where check_in.is_check = 2 and check_in.user_id = $student->id and lessons.class_id = ".$classes->first()->id.") as 'di_muon',
                    (select count(check_in.id) from check_in join lessons on check_in.lesson_id = lessons.id where check_in.is_check = 3 and check_in.user_id = $student->id and lessons.class_id = ".$classes->first()->id.") as 'vang_mat'
                    ");
            }

            // dd($checkIn);

            $notes = Lesson::whereRaw("lessons.class_id =". $classes->first()->id ." and lessons.note is not null")->get();

            $events = '';

            foreach ($notes as $note) {
                $events .= "{title : '$note->note', start : '$note->updated_at'},";
            }

            // dd($event);
            return view ('feedback.checkIn', [
                'classes' => $classes,
                'class' => $class, 
                'lessons' => $lessons,
                'students' => $students,
                'checkIn' => $checkIn,
                'user_checkIn' => $user_checkIn,
                'events' => $events,
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

            $classes = ClassRoom::where('teacher_id', '=', Auth()->user()->id)->orderBy('id', 'asc')->get();

            $class = DB::table('classes')
            ->selectRaw('classes.id, classes.name, classes.code, courses.name as course, courses.code as course_code, subjects.name as subject, subjects.code as subject_code, 
            count(lessons.id) as total_number,
            (select count(lessons.id) from lessons
            where lessons.class_id = 5 and date(now()) < lessons.start_at) as number,
            (select lessons.start_at from lessons
            where lessons.class_id = 5 order by lessons.start_at asc limit 1 ) as start_at,
            (select lessons.start_at from lessons
            where lessons.class_id = 5 order by lessons.start_at desc limit 1 ) as end_at')
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

            $lessons = DB::table('classes')
            ->select('classes.code', 'lessons.id', 'lessons.start_at')
            ->join('lessons', 'lessons.class_id', '=', 'classes.id')
            ->whereRaw("classes.id = ".$id." and date(now()) > lessons.start_at")
            ->orderBy('lessons.start_at', 'asc')
            ->get();

            foreach ($students as $key => $student) {
                $checkIn [$student->id] = DB::select("select classes.code, lessons.id, lessons.start_at, test.is_check, test.id from classes
                    join lessons on lessons.class_id = classes.id
                    left join (select check_in.id, check_in.is_check, check_in.lesson_id from check_in
                    join users on users.id = check_in.user_id
                    where users.id = $student->id) as test on test.lesson_id = lessons.id
                    where classes.id =". $id ." and date(now()) > lessons.start_at
                    order by lessons.start_at asc");

                $user_checkIn [$student->id] = DB::select("select
                    (select count(check_in.id) from check_in join lessons on check_in.lesson_id = lessons.id where check_in.is_check = 1 and check_in.user_id = $student->id and lessons.class_id = ".$id.") as di_hoc,
                    (select count(check_in.id) from check_in join lessons on check_in.lesson_id = lessons.id where check_in.is_check = 2 and check_in.user_id = $student->id and lessons.class_id = ".$id.") as 'di_muon',
                    (select count(check_in.id) from check_in join lessons on check_in.lesson_id = lessons.id where check_in.is_check = 3 and check_in.user_id = $student->id and lessons.class_id = ".$id.") as 'vang_mat'
                    ");
            }

            // dd($checkIn);

            $notes = Lesson::whereRaw("lessons.class_id =". $id ." and lessons.note is not null")->get();

            $events = '';

            foreach ($notes as $note) {
                $events .= "{title : '$note->note', start : '$note->updated_at'},";
            }

            // dd($event);
            return view ('feedback.checkIn', [
                'classes' => $classes,
                'class' => $class, 
                'lessons' => $lessons,
                'students' => $students,
                'checkIn' => $checkIn,
                'user_checkIn' => $user_checkIn,
                'events' => $events,
            ]);
        } else {
            dd('forbidden');
            return view('');
        }
        
    }

    public function postCheckIn (Request $request)
    {
        // return response()->json(['mess' => 'Thêm bản ghi thành công', 200]);


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

            // if (date_format(date_create($lesson->start_at), 'Y-m-d') != $today) {
            if(false) {
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
        // dd('ad');
        $classes = ClassRoom::select('classes.id', 'classes.name', 'classes.code')
            ->join('user_class', 'user_class.class_id', '=', 'classes.id')
            ->where('user_class.user_id', Auth::user()->id)
            ->orderBy('user_class.created_at', 'asc')
            ->get();
dd($classes->first()->id);
        $feedBack = FeedBack::findOrFail($classes->first()->id);

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
                'answer' => $arr,
            ];
        }

        shuffle($data);

        

        return view ('feedback.feedback', [
            'classes' => $classes,
            'data' => $data,
        ]);
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
