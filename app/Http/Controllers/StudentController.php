<?php

namespace App\Http\Controllers;

use App\Course;
use App\Role;
use App\User;
use App\UserClass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

// use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        $studentsWithTrashed = '';

        if ( $currentUser->can('checkAdmin', User::class) ) {
            $studentsWithTrashed = User::onlyTrashed()
                ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
                ->where('roles.name', '=', 'user')
                ->latest('users.created_at')->get('users.*');
        }

        $students = User::leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->where('roles.name', '=', 'user')
            ->latest('users.created_at')->get('users.*');   

        return view('admin.student.index', [
            'students' => $students,
            'studentsWithTrashed' => $studentsWithTrashed,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::where('is_active', '=', 1)->latest()->get();
        return view ('admin.student.create', [
            'courses' => $courses,
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'required|unique:users,code',
            'gender' => 'required|integer|min:1|max:3',
            'date_of_birth' => 'required|date_format:"Y-m-d"|before:(today - 864002)',
            'phone' => 'required|size:10',
            'address' => 'required',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'classRoom_id' => 'required|exists:classes,id',
            'course_id' => 'required|exists:courses,id',
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
            'password.required' => 'Yêu cầu không để trống',
            'password.min' => 'Độ dài phải lớn hơn 8 kí tự',
            'password.confirmed' => 'Nhập lại mật khẩu không khớp',
            'classRoom_id.required' => 'Yêu cầu không để trống',
            'classRoom_id.exists' => 'Dữ liệu không tồn tại',
            'course_id.required' => 'Yêu cầu không để trống',
            'course_id.exists' => 'Dữ liệu không tồn tại',
            'is_active.integer' => 'Sai kiểu dữ liệu',
            'is_active.boolean' => 'Sai kiểu dữ liệu',
        ]);


        $errs = $validator->errors();

        if ( $validator->fails() ) {
            return response()->json(['errors' => $errs, 'mess' => 'Thêm bản ghi lỗi'], 400);
        } else {
            $role_id = Role::where('name', '=','user')->first()->id;

            if ( empty($role_id) ) {
                return response()->json(['mess' => 'Thêm bản ghi lỗi'], 400);
            }

            $user = new User;
            $user->name = $request->input('name');
            $user->code = $request->input('code');
            $user->gender = (int)$request->input('gender');
            $user->date_of_birth = $request->input('date_of_birth');
            $user->phone = $request->input('phone');
            $user->address = $request->input('address');
            $user->is_active = (int)$request->input('is_active');
            // $user->course_id = $request->input('course_id');
            $user->email = $request->input('email');
            $user->role_id = $role_id;
            $user->password = Hash::make($request->input('password'));

            DB::beginTransaction();

            try {
                $user->save();
                
                $user_id = User::latest()->first()->id;

                
                $user_class = new UserClass;
                $user_class->user_id = $user_id;
                $user_class->class_id = (int)$request->input('classRoom_id');
                $user_class->is_active = 1;
                // dd($user_class);
                $user_class->save();
                
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
        $student = User::find($id);
        if (empty($student)) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 404);
        } else {
            
            $data = User::selectRaw('courses.code as course, classes.name as class, subjects.code as subject, user_class.is_active as is_active,
            ( select UNIX_TIMESTAMP(lessons.start_at)*1000 from lessons where lessons.class_id = classes.id order by lessons.start_at asc limit 1) as start_at, 
            ( select UNIX_TIMESTAMP(lessons.start_at)*1000 from lessons where lessons.class_id = classes.id order by lessons.start_at desc limit 1) as end_at ')
            ->join('user_class', 'user_class.user_id', '=', 'users.id')
            ->join('classes', 'classes.id', '=', 'user_class.class_id')
            ->join('courses', 'courses.id', '=', 'classes.course_id')
            ->join('subjects', 'subjects.id', '=', 'courses.subject_id')
            ->where('users.id', '=', $id)
            ->get();

            return response()->json(['student' => $student, 'data' => $data], 200);
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
        $student = User::findOrFail($id);

        $courses = Course::where('is_active', '=', 1)->latest()->get();

        return view ('admin.student.edit', [
            'student' => $student,
            'courses' => $courses
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
        $student = User::find($id);

        if (empty($student)) {
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
                $student->name = $request->input('name');
                $student->code = $request->input('code');
                $student->gender = $request->input('gender');
                $student->date_of_birth = $request->input('date_of_birth');
                $student->phone = $request->input('phone');
                $student->address = $request->input('address');
                $student->email = $request->input('email');
                if (!empty($request->input('password'))) {
                    $student->password = Hash::make($request->input('password'));
                }

                if ($student->save()) {
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

    public function forceDelete ($id)
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        $user = User::withTrashed()->find($id);

        if ( $currentUser->can('forceDelete', User::class) ) {
            if ( empty($user) ) {
                return response()->json(['mess' => 'Bản ghi không tồn tại'], 400);
            }
        
            if( $user->forceDelete() ) {
                return response()->json(['mess' => 'Xóa bản ghi thành công'], 200);
            } else {
                return response()->json(['mess' => 'Xóa bản không thành công'], 400);
            }
        } else {
            return response()->json(['mess' => 'Xóa bản ghi lỗi'], 403);
        }
    }

    public function restore ($id)
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        $user = User::withTrashed()->find($id);

        if ( $currentUser->can('restore', User::class) ) {
            if ( empty($user) ) {
                return response()->json(['mess' => 'Bản ghi không tồn tại'], 400);
            }
        
            if( $user->restore() ) {
                return response()->json(['mess' => 'Khôi bản ghi thành công'], 200);
            } else {
                return response()->json(['mess' => 'Khôi bản không thành công'], 400);
            }
        } else {
            return response()->json(['mess' => 'Khôi phục bản ghi lỗi'], 403);
        }
    }
}
