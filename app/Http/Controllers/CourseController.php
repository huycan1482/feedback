<?php

namespace App\Http\Controllers;

use App\ClassRoom;
use App\Course;
use App\Subject;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::latest()->get();
        return view ('admin.course.index', [
            'courses' => $courses,
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = Subject::where('is_active', '=', 1)->latest()->get();
        $teachers = DB::table('users')
            ->leftJoin('roles', 'roles.id', '=', 'users.role_id')
            ->where('roles.name', '=', 'teacher')
            // ->groupBy('users.id')
            ->latest('users.created_at')->get();

        return view ('admin.course.create', [
            'subjects' => $subjects,
            'teachers' => $teachers
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
        $request['trueName'] = $request->input('name');
        $request['name'] = Str::slug($request->input('name'));
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:courses,slug',
            'code' => 'required|unique:courses,code',
            'subject' => 'required|exists:subjects,id',
            'total_lesson' => 'required|integer|min:1"',
            'start_at' => 'required|date_format:"Y-m-d H:i:s"',
            'is_active' => 'integer|boolean',
        ], [
            'name.required' => 'Yêu cầu không để trống',
            'name.unique' => 'Dữ liệu trùng',
            'code.required' => 'Yêu cầu không để trống',
            'code.unique' => 'Dữ liệu bị trùng',
            'subject.required' => 'Yêu cầu không để trống',
            'subject.exists' => 'Dữ liệu không tồn tại',
            'total_lesson.required' => 'Yêu cầu không để trống',
            'total_lesson.integer' => 'Sai kiểu dữ liệu',
            'total_lesson.min' => 'Dữ liệu phải lớn hơn 0',
            'start_at.required' => 'Yêu cầu không để trống',
            'start_at.date_format' => 'Dữ liệu nhập vào không phù hợp',
            'is_active.integer' => 'Sai kiểu dữ liệu',
            'is_active.boolean' => 'Sai kiểu dữ liệu',
        ]);

        $errs = $validator->errors();

        if ( $validator->fails() ) {
            return response()->json(['errors' => $errs, 'mess' => 'Thêm bản ghi lỗi'], 400);
        } else {
            $course = new Course;
            $course->name = $request->input('trueName');
            $course->code = $request->input('code');
            $course->slug = $request->input('name');
            $course->subject_id = $request->input('subject');
            $course->total_lesson = $request->input('total_lesson');
            $course->start_at = $request->input('start_at');
            $course->is_active = (int)$request->input('is_active');
            $course->user_create = Auth::user()->id;

            if ($course->save()) {
                return response()->json(['mess' => 'Thêm bản ghi thành công', 200]);
            } else {
                return response()->json(['mess' => 'Thêm bản ghi lỗi'], 502);
            } 
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
        $course = Course::find($id);

        if (empty($course)) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 404);
        } else {

            $data = Course::selectRaw('classes.id as classId, subjects.code as subject, classes.name as class, users.name as teacher, classes.is_active as active')
            ->leftJoin('subjects', 'subjects.id', '=', 'courses.subject_id')
            ->leftJoin('classes', 'classes.course_id', '=', 'courses.id')
            ->join('users', 'classes.teacher_id', '=', 'users.id')
            ->where('course_id', '=', $id)
            ->get();

            return response()->json(['course' => $course, 'data' => $data], 200);
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
        $course = Course::findOrFail($id);
        $subjects = Subject::where('is_active', '=', 1)->get();
        return view ('admin.course.edit', [
            'course' => $course,
            'subjects' => $subjects
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
        $course = Course::find($id);
        if (empty($course)) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 400);
        } else {
            $request['trueName'] = $request->input('name');
            $request['name'] = Str::slug($request->input('name'));
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:courses,slug,'.$id,
                'code' => 'required|unique:courses,code,'.$id,
                'subject' => 'required|exists:subjects,id',
                'total_lesson' => 'required|integer|min:1"',
                'start_at' => 'required|date_format:"Y-m-d H:i:s"',
                'is_active' => 'integer|boolean',
            ], [
                'name.required' => 'Yêu cầu không để trống',
                'name.unique' => 'Dữ liệu trùng',
                'code.required' => 'Yêu cầu không để trống',
                'code.unique' => 'Dữ liệu bị trùng',
                'subject.required' => 'Yêu cầu không để trống',
                'subject.unique' => 'Dữ liệu bị trùng',
                'total_lesson.required' => 'Yêu cầu không để trống',
                'total_lesson.integer' => 'Sai kiểu dữ liệu',
                'total_lesson.min' => 'Dữ liệu phải lớn hơn 0',
                'start_at.required' => 'Yêu cầu không để trống',
                'start_at.date_format' => 'Dữ liệu nhập vào không phù hợp',
                'is_active.integer' => 'Sai kiểu dữ liệu',
                'is_active.boolean' => 'Sai kiểu dữ liệu',
            ]);
    
            $errs = $validator->errors();
    
            if ( $validator->fails() ) {
                return response()->json(['errors' => $errs, 'mess' => 'Thêm bản ghi lỗi'], 400);
            } else {
                $course->name = $request->input('trueName');
                $course->code = $request->input('code');
                $course->slug = $request->input('name');
                $course->subject_id = $request->input('subject');
                $course->total_lesson = $request->input('total_lesson');
                $course->start_at = $request->input('start_at');
                $course->is_active = (int)$request->input('is_active');
                $course->user_update = Auth::user()->id;

                if ($course->save()) {
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
