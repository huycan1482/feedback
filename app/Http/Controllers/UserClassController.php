<?php

namespace App\Http\Controllers;

use App\ClassRoom;
use App\Course;
use App\Http\Requests\UserClassRequest;
use App\Repositories\UserClassRepository;
use App\User;
use App\UserClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserClassController extends UserClassRepository
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
    public function store(UserClassRequest $request)
    {
        $user_id = $this->findUserById($request->input('user_id'));

        $check = $this->checkUserClass($request->input('classRoom_id'), $user_id->id);

        if (!empty($check)) {
            return response()->json(['mess' => 'Thêm bản ghi lỗi, học viên đã đăng kí lớp học'], 400);
        } else {

            $data = [
                'class_id' => $request->input('classRoom_id'),
                'user_id' => $user_id->id,
                'is_active' => 1,
                'user_create' => Auth::user()->id,
            ];

            if ($this->createModel($data)) {
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
        $userClass = $this->find($id);

        if (empty($userClass)) {
            return redirect()->route('admin.errors.404');
        }

        $courses = $this->getCourses();

        $classRooms = $this->getClasses();

        return view('admin.userClass.edit', [
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
    public function update(UserClassRequest $request, $id)
    {
        $check = $this->checkUserClass($request->input('classRoom_id'), $id);

        if (!empty($check)) {
            return response()->json(['mess' => 'Thêm bản ghi lỗi, học viên đã đăng kí lớp học'], 400);
        } else {

            $data = [
                'class_id' => $request->input('classRoom_id'),
                'is_active' => $request->input('is_active'),
                'user_update' => Auth::user()->id,
            ];

            if ($this->updateModel($id, $data)) {
                return response()->json(['mess' => 'Sửa bản ghi thành công, quay về trang cũ trong 1.5s', 200]);
            } else {
                return response()->json(['mess' => 'Sửa bản ghi lỗi'], 502);
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
