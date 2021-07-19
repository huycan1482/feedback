<?php

namespace App\Http\Controllers;

use App\CheckIn;
use App\ClassRoom;
use App\Course;
use App\Lesson;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CheckInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::where('is_active', 1)->latest()->get();
        return view ('admin.checkIn.index', [
            'subjects' => $subjects,
        ]);
    }

    public function getCourses ($id)
    {
        $checkCourse = Course::where(['is_active' => 1, 'subject_id' => $id])->latest()->get();

        return response()->json(['courses' => $checkCourse], 200);

    }

    public function getClasses ($id) 
    {
        $classes = ClassRoom::where(['course_id' => $id, 'is_active' => 1])->latest()->get();

        return response()->json(['classes' => $classes], 200);

    }

    public function getLessons ($id)
    {
        $lessons = Lesson::where(['class_id' => $id])->orderBy('start_at', 'desc')->get();

        return response()->json(['lessons' => $lessons], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lesson = Lesson::findOrFail($id);

        $students = User::
            select('users.id', 'users.name', 'users.date_of_birth')
            ->join('user_class', 'users.id', '=', 'user_class.user_id')
            ->join('classes', 'user_class.class_id', '=', 'classes.id')
            ->where('classes.id', $lesson->class_id)
            ->get();

        foreach ($students as $student) {
            $checkLesson = CheckIn::where([['lesson_id', '=', $lesson->id], ['user_id', '=', $student->id]])
            ->get()->first();

            if (empty($checkLesson) ) {
                $checkIn_check [$student->id] = 0;
                $checkIn_id [$student->id] = 0;

            } else {
                $checkIn_check [$student->id] = $checkLesson->is_check;
                $checkIn_id [$student->id] = $checkLesson->id;
            }

        }



        return view ('admin.checkIn.edit', [
            'lesson' => $lesson,
            'students' => $students,
            'checkIn_check' => $checkIn_check,
            'checkIn_id' => $checkIn_id,
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
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'checkIn' => 'required|array',
            // 'checkIn.*.id' => [
            //         'required',
            //         Rule::exists('check_in','id')->where(function($query) use ( $id) {
            //             $query->whereRaw('id = 0');
            //         }),
            // ],
            'checkIn.*.val' => 'required|numeric|min:1|max:3',
            'checkIn.*.user_id' => 'required|exists:users,id'
        ], [
            'checkIn.required' => 'Yêu cầu không để trống',
            'checkIn.array' => 'Sai kiểu dữ liệu',
            'checkIn.*.val.numeric' => 'Sai kiểu dữ liệu',
            'checkIn.*.val.min' => 'Sai kiểu dữ liệu',
            'checkIn.*.val.max' => 'Sai kiểu dữ liệu',
            'checkIn.*.val.required' => 'Yêu cầu không để trống', 
            'checkIn.*.user_id.required' => 'Yêu cầu không để trống',
            'checkIn.*.user_id.exists' => 'Dữ liệu không tồn tại'
        ]);

        $errs = $validator->errors();

        if ( $validator->fails() ) {
            return response()->json(['errors' => $errs, 'mess' => 'Thêm bản ghi lỗi'], 400);
        }

        $checkLesson = Lesson::find($id);

        if (empty($checkLesson)) {
            return response()->json(['mess' => 'Thêm bản ghi lỗi'], 400);
        }

        $checkLesson->note = $request->input('note');
        $checkLesson->save();

        foreach ($request->input('checkIn') as $item) {
            if ($item['lesson_id'] == 0) {
                $checkIn = new CheckIn;
                $checkIn->is_check = $item['val'];
                $checkIn->user_id = $item['user_id'];
                $checkIn->lesson_id = $id;
                $checkIn->save();

            } else {
                $checkIn = CheckIn::find($item['lesson_id']);
                if ( empty($checkIn) ) {
                    return response()->json(['mess' => 'Thêm bản ghi lỗi'], 400);
                }
                $checkIn->is_check = $item['val'];
                $checkIn->save();
            }
        }

        return response()->json(['mess' => 'Sửa bản ghi thành công', 200]);
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
