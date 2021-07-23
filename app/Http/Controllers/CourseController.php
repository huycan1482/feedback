<?php

namespace App\Http\Controllers;

use App\ClassRoom;
use App\Course;
use App\Http\Requests\CourseRequest;
use App\Repositories\CourseRepository;
use App\Subject;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CourseController extends CourseRepository
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        $coursesWithTrashed = [];

        if ($currentUser->can('forceDelete', Course::class)) {
            $coursesWithTrashed = $this->getAllWithTrashed();
        }

        $courses = $this->getAll();

        return view('admin.course.index', [
            'courses' => $courses,
            'coursesWithTrashed' => $coursesWithTrashed,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = $this->getSubjects();

        // $teachers = $this->getTeachers();

        return view('admin.course.create', [
            'subjects' => $subjects,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        $request->merge([
            'name' => $request->input('trueName'),
            'user_create' => Auth::user()->id,
        ]);

        if ($this->createModel($request->all())) {
            return response()->json(['mess' => 'Thêm bản ghi thành công', 200]);
        } else {
            return response()->json(['mess' => 'Thêm bản ghi lỗi'], 502);
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
        if (!$this->check($id)) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 404);
        } else {
            
            $data = $this->showModel($id);

            if (!$data) {
                return response()->json(['mess' => 'Lấy dữ liệu thất bại'], 404);
            }

            return response()->json(['course' => $this->find($id), 'data' => $data], 200);
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
        $course = $this->find($id);

        if (empty($course)) {
            return redirect()->route('admin.errors.404');
        }

        $subjects = $this->getSubjects();

        return view('admin.course.edit', [
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
    public function update(CourseRequest $request, $id)
    {
        $request->merge([
            'name' => $request->input('trueName'),
            'user_update' => Auth::user()->id,
        ]);

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

        if ($currentUser->can('forceDelete', Course::class)) {
            if ($this->forceDeleteModel($id)) {
                return response()->json(['mess' => 'Xóa bản ghi thành công'], 200);
            } else {
                return response()->json(['mess' => 'Xóa bản không thành công'], 400);
            }
        } else {
            return response()->json(['mess' => 'Xóa bản ghi lỗi, bạn không đủ thẩm quyền'], 403);
        }
    }

    public function restore($id)
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ($currentUser->can('restore', Course::class)) {
            if ($this->restoreModel($id)) {
                return response()->json(['mess' => 'Khôi bản ghi thành công'], 200);
            } else {
                return response()->json(['mess' => 'Khôi bản không thành công'], 400);
            }
        } else {
            return response()->json(['mess' => 'Khôi phục bản ghi lỗi, bạn không đủ thẩm quyền'], 403);
        }
    }
}
