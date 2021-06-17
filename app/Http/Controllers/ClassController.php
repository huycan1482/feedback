<?php

namespace App\Http\Controllers;

use App\ClassRoom;
use App\Course;
use App\FeedBack;
use App\Lesson;
use App\User;
use DateTime;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classRooms = ClassRoom::latest()->get();

        return view ('admin.class.index', [
            'classRooms' => $classRooms,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teachers = DB::table('users')
            ->select('users.*')
            ->leftJoin('roles', 'roles.id', '=', 'users.role_id')
            ->where('roles.name', '=', 'teacher')
            ->latest()->get();
        $feedbacks = FeedBack::where('is_active', '=', 1)->latest()->get();
        $courses = Course::where('is_active', '=', 1)->latest()->get();
        return view ('admin.class.create', [
            'teachers' => $teachers,
            'courses' => $courses,
            'feedbacks' => $feedbacks,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all()); 
        $request['trueName'] = $request->input('name');
        $request['name'] = Str::slug($request->input('name'));
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:classes,slug',
            'code' => 'required|unique:classes,code',
            'course_id' => 'required|exists:courses,id',
            'teacher_id' => 'required|exists:users,id',
            'total_number' => 'required|integer|min:1',
            'feedback_id' => 'nullable|array',
            'feedback_id.*' => 'exists:feedbacks,id',
            'is_active' => 'integer|boolean',
            'lessons' => 'required|array|min:1',
            'time_limit' => 'required|integer|min:1',
        ], [
            'name.required' => 'Yêu cầu không để trống',
            'name.unique' => 'Dữ liệu trùng',
            'code.required' => 'Yêu cầu không để trống',
            'code.unique' => 'Dữ liệu trùng',
            'course_id.required' => 'Yêu cầu không để trống',
            'course_id.exists' => 'Dữ liệu không tồn tại',
            'feedback_id.exists' => 'Dữ liệu không tồn tại',
            'teacher_id.required' => 'Yêu cầu không để trống',
            'teacher_id.unique' => 'Dữ liệu bị trùng',
            'total_number.required' => 'Yêu cầu không để trống',
            'total_number.integer' => 'Sai kiểu dữ liệu',
            'total_number.min' => 'Dữ liệu phải lớn hơn 0',
            'is_active.integer' => 'Sai kiểu dữ liệu',
            'is_active.boolean' => 'Sai kiểu dữ liệu',
            'lessons.required' => 'Yêu cầu không để trống',
            'lessons.min' => 'Yêu cầu phải có từ 1 ngày học lời trở lên',
            'lessons.array' => 'Sai kiểu dữ liệu',
            'time_limit.required' => 'Yêu cầu không để trống',
            'time_limit.integer' => 'Sai kiểu dữ liệu',
            'time_limit.min' => 'Dữ liệu phải lớn hơn 0',
        ]);

        dd($request->all());

        $errs = $validator->errors();

        if ( $validator->fails() ) {
            return response()->json(['errors' => $errs, 'mess' => 'Thêm bản ghi lỗi'], 400);
        } else {
            $classRoom = new ClassRoom;
            $classRoom->name = $request->input('trueName');
            $classRoom->code = $request->input('code');
            $classRoom->slug = $request->input('name');
            $classRoom->course_id = $request->input('course_id');
            $classRoom->teacher_id = $request->input('teacher_id');
            // $classRoom->feedback_id = $request->input('feedback_id');
            $classRoom->total_number = $request->input('total_number');
            $classRoom->is_active = (int)$request->input('is_active'); 
            $classRoom->user_create = Auth::user()->id;

            $current_date = new DateTime();
            $created_time = date('Y-m-d H:i:s', $current_date->getTimestamp());
            $classRoom->created_at = $created_time;

            DB::beginTransaction();

            try {
                $classRoom->save();
                
                $courseTotalLessons = Course::where('id', '=', $request->input('course_id'))->first()->total_lesson;
                $latestClass = ClassRoom::where([ 'created_at' => $created_time ])->first()->id;

                $day = 0;
                $i = 0;

                while ($i < $courseTotalLessons) {
                    foreach ($request->input(['lessons']) as $key => $item) {

                        $validator2 = Validator::make($item[0], [
                            'lessons' => 'required|date_format:"Y-m-d H:i:s"',
                        ], [
                            'lessons.required' => 'Yêu cầu không để trống',
                            'lessons.date_format' => 'Sai kiểu dữ liệu'
                        ]);

                        $errs2 = $validator2->errors();

                        if ( $validator2->fails() ) {
                            return response()->json(['errors' => $errs2, 'mess' => 'Thêm bản ghi lỗi'], 400);
                        } else {
                            if ($i == $courseTotalLessons) {
                                break;
                            }
                            
                            $itemDay = date($item[0]["lessons"]);
                            $newDate = strtotime ( "+". $day ." day" , strtotime( $itemDay ) ) ;
                            
                            $lesson = new Lesson;
                            $lesson->start_at = date('Y-m-d H:i:s', $newDate);
                            $lesson->time_limit = $request->input('time_limit');
                            $lesson->class_id = $latestClass;
                            $lesson->is_active = 1;
                            
                            $lesson->save();
                   
                            $i++; 
                        }
                        
                    }
                    
                    $day += 7;
                };
                
                DB::commit();

            } catch (Exception $e) {
                DB::rollBack();
                return response()->json(['mess' => 'Thêm bản ghi lỗi'], 502);
            }

            return response()->json(['mess' => 'Thêm bản ghi thành công', 200]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $classRoom = ClassRoom::find($id);
        if (empty($classRoom)) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 404);
        } else {

            $data = DB::table('classes')
            ->selectRaw('users.id as id, users.name as name')
            ->leftJoin('user_class', 'classes.id', '=', 'user_class.class_id')
            ->leftJoin('users', 'users.id', '=', 'user_class.user_id')
            ->where('classes.id', $id)
            ->get();
            return response()->json(['classRoom' => $classRoom, 'data' => $data], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $classRoom = ClassRoom::findOrFail($id);

        $teachers = DB::table('users')
            ->select('users.*')
            ->leftJoin('roles', 'roles.id', '=', 'users.role_id')
            ->where('roles.name', '=', 'teacher')
            ->latest()->get();
        $courses = Course::where('is_active', '=', 1)->latest()->get();

        $feedbacks = FeedBack::where('is_active', '=', 1)->latest()->get();

        // $lessons = Lesson::
        // selectRaw('WEEKDAY(lessons.start_at) as day, lessons.time_limit, (select lessons.start_at from lessons where WEEKDAY(lessons.start_at) = day order by lessons.start_at asc limit 1) as time')
        // ->rightJoin('classes', 'classes.id', '=', 'lessons.class_id')
        // ->where('classes.id', '=', $id)
        // ->groupBy('day', 'time_limit')
        // ->orderBy('day', 'asc')
        // ->get();

        return view ('admin.class.edit', [
            'classRoom' => $classRoom,
            'teachers' => $teachers,
            'courses' => $courses,
            'feedbacks' => $feedbacks
            // 'lessons' => $lessons,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $classRoom = ClassRoom::find($id);

        if (empty($classRoom)) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 400);
        } else {
            $request['trueName'] = $request->input('name');
            $request['name'] = Str::slug($request->input('name'));
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:classes,slug,'.$id,
                'code' => 'required|unique:classes,code,'.$id,
                'course_id' => 'required|exists:courses,id',
                'teacher_id' => 'required|exists:users,id',
                'total_number' => 'required|integer|min:1',
                'feedback_id' => 'nullable|exists:feedbacks,id',
                'is_active' => 'integer|boolean',
                'time_limit' => 'nullable|integer|min:1',
            ], [
                'name.required' => 'Yêu cầu không để trống',
                'name.unique' => 'Dữ liệu trùng',
                'code.required' => 'Yêu cầu không để trống',
                'code.unique' => 'Dữ liệu trùng',
                'course_id.required' => 'Yêu cầu không để trống',
                'course_id.exists' => 'Dữ liệu không tồn tại',
                'feedback_id.exists' => 'Dữ liệu không tồn tại',
                'teacher_id.required' => 'Yêu cầu không để trống',
                'teacher_id.exists' => 'Dữ liệu không tồn tại',
                'total_number.required' => 'Yêu cầu không để trống',
                'total_number.integer' => 'Sai kiểu dữ liệu',
                'total_number.min' => 'Dữ liệu phải lớn hơn 0',
                'is_active.integer' => 'Sai kiểu dữ liệu',
                'is_active.boolean' => 'Sai kiểu dữ liệu',
                'time_limit.integer' => 'Sai kiểu dữ liệu',
                'time_limit.min' => 'Dữ liệu phải lớn hơn 0',
            ]);

            $errs = $validator->errors();

            if ( $validator->fails() ) {
                return response()->json(['errors' => $errs, 'mess' => 'Thêm bản ghi lỗi'], 400);
            } else {
                $classRoom->name = $request->input('trueName');
                $classRoom->code = $request->input('code');
                $classRoom->slug = $request->input('name');
                $classRoom->course_id = $request->input('course_id');
                $classRoom->teacher_id = $request->input('teacher_id');
                $classRoom->feedback_id = $request->input('feedback_id');
                $classRoom->total_number = $request->input('total_number');
                $classRoom->is_active = (int)$request->input('is_active'); 
                $classRoom->user_update = Auth::user()->id;

                if (!empty($request->input('time_limit'))) {
                    $classRoom->lesson()->update([
                        'time_limit' => $request->input('time_limit'),
                    ]);
                }

                if ($classRoom->save()) {
                    return response()->json(['mess' => 'Sửa bản ghi thành công', 200]);
                } else {
                    return response()->json(['mess' => 'Sửa bản ghi lỗi'], 502);
                }

            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
