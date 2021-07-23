<?php

namespace App\Http\Controllers;

use App\ClassRoom;
use App\Course;
use App\FeedBack;
use App\Http\Requests\ClassRequest;
use App\Lesson;
use App\Repositories\ClassRepository;
use App\User;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ClassController extends ClassRepository
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        $classesWithTrashed = [];

        if ($currentUser->can('forceDelete', ClassRoom::class)) {
            $classesWithTrashed = $this->getAllWithTrashed();
        }

        $classRooms = $this->getAll();

        return view('admin.class.index', [
            'classRooms' => $classRooms,
            'classesWithTrashed' => $classesWithTrashed,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teachers = $this->getTeachers();
        $feedbacks = $this->getFeedbacks();
        $courses = $this->getCourses();
        
        return view('admin.class.create', [
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
    public function store(ClassRequest $request)
    {
        $current_date = new DateTime();
        $created_time = date('Y-m-d H:i:s', $current_date->getTimestamp());

        $request->merge([
            'name' => $request->input('trueName'),
            'created_at' => $created_time,
            'user_create' => Auth::user()->id,
        ]);

        // bắt đầu Rollback
        DB::beginTransaction();

        try {
            $this->createModel($request->all());
            // Lưu thông tin lớp học

            $courseTotalLessons = Course::where('id', '=', $request->input('course_id'))->first()->total_lesson;
            // Lấy tổng số buổi học của khóa học

            $latestClass = ClassRoom::where(['created_at' => $created_time])->first();
            // Lấy lớp học vừa lưu

            if (!empty($request->input('feedback_id'))) {
                // Kiểm tra có feedback dc thêm hay k

                if (!$this->createFeedbacks($request->input('feedback_id'), $latestClass->id)) {
                    // Kiểm tra có thêm được vào bảng trung gian hay k
                    throw new Exception();
                }
            }

            if (!$this->createLessons($courseTotalLessons, $latestClass->id, $request->input('lessons'), $request->input('time_limit'))) {
                // thêm dữ liệu cho buổi học
                throw new Exception();
            }

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
        $classRoom = $this->find($id);
        if (empty($classRoom)) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 404);
        } else {

            $data = $this->showModel($id);

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
        $classRoom = $this->find($id);

        if (empty($classRoom)) {
            return redirect()->route('admin.errors.404');
        }

        $teachers = $this->getTeachers();
        $courses = $this->getCourses();
        $feedbacks = $this->getFeedbacks();

        // $lessons = Lesson::
        // selectRaw('WEEKDAY(lessons.start_at) as day, lessons.time_limit, (select lessons.start_at from lessons where WEEKDAY(lessons.start_at) = day order by lessons.start_at asc limit 1) as time')
        // ->rightJoin('classes', 'classes.id', '=', 'lessons.class_id')
        // ->where('classes.id', '=', $id)
        // ->groupBy('day', 'time_limit')
        // ->orderBy('day', 'asc')
        // ->get();

        return view('admin.class.edit', [
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
        $request->merge([
            'name' => $request->input('trueName'),
            'user_update' => Auth::user()->id,
        ]);

        if (!empty($request->input('time_limit'))) {
            if( !$this->updateLessons($id, $request->input('time_limit')) ) {
                return response()->json(['mess' => 'Sửa bản ghi lỗi'], 502);
            }
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

        if ($currentUser->can('forceDelete', ClassRoom::class)) {

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

        if ($currentUser->can('restore', ClassRoom::class)) {

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
