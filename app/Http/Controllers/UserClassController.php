<?php

namespace App\Http\Controllers;

use App\ClassRoom;
use App\Course;
use App\User;
use App\UserClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'classRoom_id' => 'required|exists:classes,id',
            'course_id' => 'required|exists:courses,id',
            'user_code' => 'required|exists:users,code',
        ], [
            'classRoom_id.required' => 'Yêu cầu không để trống',
            'classRoom_id.exists' => 'Dữ liệu không tồn tại',
            'course_id.required' => 'Yêu cầu không để trống',
            'course_id.exists' => 'Dữ liệu không tồn tại',
            'user_code.required' => 'Yêu cầu không để trống',
            'user_code.exists' => 'Dữ liệu không tồn tại',
        ]);

        $errs = $validator->errors();

        $user_id = User::where('code', '=', $request->input('user_code'))->first()->id;

        $check = UserClass::where([['class_id', '=', $request->input('classRoom_id')], ['user_id', '=', $user_id]])->get()->first();
        // dd(UserClass::where([['class_id', '=', $request->input('classRoom_id')], ['user_id', '=', $user_id]])->get());
        if ( $validator->fails() ) {
            return response()->json(['errors' => $errs, 'mess' => 'Thêm bản ghi lỗi'], 400);
        } else if (!empty($check)) {
            return response()->json(['mess' => 'Thêm bản ghi lỗi, học viên đã đăn kí lớp học'], 400);
        } else {
            $user_class = new UserClass;
            $user_class->class_id = $request->input('classRoom_id');
            $user_class->user_id = $user_id;
            $user_class->is_active = 1;
            if ( $user_class->save() ) {
                return response()->json(['mess' => 'Thêm bản ghi thành công, chạy lại sau 1,5s', 200]);
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
        $userClass = UserClass::findOrFail($id);

        $courses = Course::where('is_active', '=', 1)->latest()->get();

        $classRooms = ClassRoom::where('is_active', '=', 1)->latest()->get();

        return view ('admin.userClass.edit', [
            'userClass' => $userClass,
            'courses' => $courses,
            'classRooms' => $classRooms
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
        $userClass = UserClass::find($id);

        if (empty($userClass)) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 400);
        } else {
            $validator = Validator::make($request->all(), [
                'classRoom_id' => 'required|exists:classes,id',
                'is_active' => 'integer|boolean',
            ], [
                'classRoom_id.required' => 'Yêu cầu không để trống',
                'classRoom_id.exists' => 'Dữ liệu không tồn tại',
                'is_active.integer' => 'Sai kiểu dữ liệu',
                'is_active.boolean' => 'Sai kiểu dữ liệu',
            ]);
    
            $errs = $validator->errors();

            $check = UserClass::where([['class_id', '=', $request->input('classRoom_id')], ['user_id', '=', $userClass->user_id]])->get()->first();
    
            if ( $validator->fails() ) {
                return response()->json(['errors' => $errs, 'mess' => 'Thêm bản ghi lỗi'], 400);
            } else if (!empty($check)) {
                return response()->json(['mess' => 'Thêm bản ghi lỗi, học viên đã đăng kí lớp học'], 400);
            } else {
                $userClass->class_id = $request->input('classRoom_id');
                $userClass->is_active = $request->input('is_active');

                if ($userClass->save()) {
                    return response()->json(['mess' => 'Sửa bản ghi thành công, quay về trang cũ trong 1.5s', 200]);
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
