<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = User::leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->where('roles.name', '=', 'teacher')
            ->latest('users.created_at')->get('users.*');

        return view ('admin.teacher.index', [
            'teachers' => $teachers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.teacher.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'required|unique:users,code',
            'gender' => 'required|integer|min:1|max:3',
            'date_of_birth' => 'required|date_format:"Y-m-d"',
            'phone' => 'required|size:10',
            'address' => 'required',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
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
            'phone.size' => 'Đọ dài phải lớn hơn 10',
            'address.required' => 'Yêu cầu không để trống',
            'email.required' => 'Yêu cầu không để trống',
            'email.email' => 'Yêu cầu email',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Yêu cầu không để trống',
            'password.min' => 'Độ dài phải lớn hơn 8 kí tự',
            'password.confirmed' => 'Nhập lại mật khẩu không khớp',
            'is_active.integer' => 'Sai kiểu dữ liệu',
            'is_active.boolean' => 'Sai kiểu dữ liệu',
        ]);

        $errs = $validator->errors();

        if ( $validator->fails() ) {
            return response()->json(['errors' => $errs, 'mess' => 'Thêm bản ghi lỗi'], 400);
        } else {
            $role_id = Role::where('name', '=','teacher')->first()->id;

            if ( empty($role_id) ) {
                return response()->json(['mess' => 'Thêm bản ghi lỗi'], 400);
            }

            $user = new User;
            $user->name = $request->input('name');
            $user->code = $request->input('code');
            $user->gender = $request->input('gender');
            $user->date_of_birth = $request->input('date_of_birth');
            $user->phone = $request->input('phone');
            $user->address = $request->input('address');
            $user->email = $request->input('email');
            $user->role_id = $role_id;
            $user->is_active = $request->input('is_active');
            $user->password = Hash::make($request->input('password'));
    
            if ($user->save()) {
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
        $teacher = User::find($id);
        if (empty($teacher)) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 404);
        } else {
            $data = User::selectRaw('users.id, classes.name as class, courses.code as course, subjects.code as subject, 
            (select UNIX_TIMESTAMP(min(lessons.start_at))*1000 from lessons where lessons.class_id = classes.id) as start_at,
            (select UNIX_TIMESTAMP(max(lessons.start_at))*1000 from lessons where lessons.class_id = classes.id) as end_at')
            ->leftJoin('classes', 'users.id', '=', 'classes.teacher_id')
            ->join('courses', 'classes.course_id', '=', 'courses.id')
            ->join('subjects', 'courses.subject_id', '=', 'subjects.id')
            ->where('users.id', $id)
            ->get();

            // dd($data);
            return response()->json(['teacher' => $teacher, 'data' => $data], 200);
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
        $teacher = User::findOrFail($id);

        return view ('admin.teacher.edit', [
            'teacher' => $teacher,
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
        $teacher = User::find($id);

        if (empty($teacher)) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 400);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'code' => 'required|unique:users,code,'.$id,
                'gender' => 'required|integer|min:1|max:3',
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
                $role_id = Role::where('name', '=','teacher')->first()->id;
    
                if ( empty($role_id) ) {
                    return response()->json(['mess' => 'Sửa bản ghi lỗi'], 400);
                }

                $teacher->name = $request->input('name');
                $teacher->code = $request->input('code');
                $teacher->gender = $request->input('gender');
                $teacher->date_of_birth = $request->input('date_of_birth');
                $teacher->phone = $request->input('phone');
                $teacher->address = $request->input('address');
                $teacher->email = $request->input('email');
                // $teacher->role_id = $role_id;
                if (!empty($request->input('password'))) {
                    $teacher->password = Hash::make($request->input('password'));
                }
        
                if ($teacher->save()) {
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
        $user = User::find($id);

        if ( empty($user) ) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 400);
        }
    
        if( $user->delete() ) {
            return response()->json(['mess' => 'Xóa bản ghi thành công'], 200);
        } else {
            return response()->json(['mess' => 'Xóa bản không thành công'], 400);
        }
    }
}
