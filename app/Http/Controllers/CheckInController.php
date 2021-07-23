<?php

namespace App\Http\Controllers;

use App\CheckIn;
use App\ClassRoom;
use App\Course;
use App\Lesson;
use App\Repositories\CheckInRepository;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckInController extends CheckInRepository
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = $this->getSubjects();

        return view('admin.checkIn.index', [
            'subjects' => $subjects,
        ]);
    }

    public function getCourses($id)
    {
        $checkCourse = $this->getCoursesBySubject($id);

        return response()->json(['courses' => $checkCourse], 200);
    }

    public function getClasses($id)
    {
        $classes = $this->getClassesByCourse($id);

        return response()->json(['classes' => $classes], 200);
    }

    public function getLessons($id)
    {
        $lessons = $this->getLessonsByClass($id);

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
        $lesson = $this->findLesson($id);

        if (empty($lesson)) {
            return redirect()->route('admin.errors.404');
        }

        $students = $this->getStudentsByClass($lesson->class_id);

        $getCheckInProperties = $this->getCheckInProperties($lesson->class_id, $lesson->id);

        return view('admin.checkIn.edit', [
            'lesson' => $lesson,
            'students' => $students,
            'checkIn_check' => $getCheckInProperties['checkIn_check'],
            'checkIn_id' => $getCheckInProperties['checkIn_id']
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
        $checkLesson = Lesson::find($id);

        $checkLesson->note = $request->input('note');
        $checkLesson->save();

        foreach ($request->input('checkIn') as $item) {
            if ($item['lesson_id'] == 0) {

                $data = [
                    'is_check' => $item['val'],
                    'user_id' => $item['user_id'],
                    'lesson_id' => $id,
                ];

                $this->createModel($data);
            } else {

                if (empty($this->find($item['lesson_id']))) {
                    return response()->json(['mess' => 'Thêm bản ghi lỗi'], 400);
                }

                $data['is_check'] = $item['val'];

                $this->updateModel($item['lesson_id'], $data);
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
