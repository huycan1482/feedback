<?php

namespace App\Http\Controllers;

use App\Course;
use App\Http\Requests\StudentRequest;
use App\Repositories\StudentRepository;
use App\Role;
use App\User;
use App\UserClass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

// use Illuminate\Support\Facades\Validator;

class StudentController extends StudentRepository
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        $studentsWithTrashed = [];

        if ($currentUser->can('checkAdmin', User::class)) {
            $studentsWithTrashed = $this->getStudentsWithTrashed();
        }

        $students = $this->getStudents();

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
        $courses = $this->getCourses();
        return view('admin.student.create', [
            'courses' => $courses,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {

        $role = $this->getRoleUser();

        if (empty($role)) {
            return response()->json(['mess' => 'Thêm bản ghi lỗi'], 400);
        }

        $request->merge([
            'role_id' => $role->id,
            'password' => Hash::make($request->input('password'))
        ]);

        DB::beginTransaction();

        try {
            if (!$this->createModel($request->all()))
                throw new Exception;

            if (!$this->createUserClass($request->input('classRoom_id')))
                throw new Exception;

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mess' => 'Thêm bản ghi lỗi'], 502);
        }

        return response()->json(['mess' => 'Thêm bản ghi thành công', 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = $this->find($id);
        if (empty($student)) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 404);
        } else {

            $data = $this->getUserDetails($id);

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
        $student = $this->find($id);
        if (empty($student))
            return redirect()->route('admin.errors.404');

        $courses = $this->getCourses();

        return view('admin.student.edit', [
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

        $role = $this->getRoleUser();

        if (empty($role)) {
            return response()->json(['mess' => 'Thêm bản ghi lỗi'], 400);
        }

        $request->merge([
            'role_id' => $role->id,

        ]);

        if (!empty($request->input('password'))) {
            $request->merge([
                'password' => Hash::make($request->input('password'))
            ]);
        }

        if ($this->updateModel($id, $request->all())) {
            return response()->json(['mess' => 'Sửa bản ghi thành công', 200]);
        } else {
            return response()->json(['mess' => 'Sửa bản ghi lỗi'], 502);
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
        if ($this->deleteModel($id)) {
            return response()->json(['mess' => 'Xóa bản ghi thành công'], 200);
        } else {
            return response()->json(['mess' => 'Xóa bản không thành công'], 400);
        }
    }

    public function forceDelete($id)
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ($currentUser->can('forceDelete', User::class)) {

            if ($this->forceDeleteModel($id)) {
                return response()->json(['mess' => 'Xóa bản ghi thành công'], 200);
            } else {
                return response()->json(['mess' => 'Xóa bản không thành công'], 400);
            }
        } else {
            return response()->json(['mess' => 'Xóa bản ghi lỗi'], 403);
        }
    }

    public function restore($id)
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ($currentUser->can('restore', User::class)) {
            if ($this->restoreModel($id)) {
                return response()->json(['mess' => 'Khôi bản ghi thành công'], 200);
            } else {
                return response()->json(['mess' => 'Khôi bản không thành công'], 400);
            }
        } else {
            return response()->json(['mess' => 'Khôi phục bản ghi lỗi'], 403);
        }
    }
}
