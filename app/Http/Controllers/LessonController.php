<?php

namespace App\Http\Controllers;

use App\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('admin.lesson.index');
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

        $validator = Validator::make($request->all(), [
            'class_id' => 'required|exists:classes,id',
            'addStartDate' => 'required|date_format:"Y-m-d H:i:s',
            'addTimeLimit' => 'required|integer|min:1'
        ], [
            'class_id.required' => 'Yêu cầu không để trống',
            'class_id.exists' => 'Dữ liệu không tồn tại',
            'addStartDate.required' => 'Yêu cầu không để trống',
            'addStartDate.date_format' => 'Sai định dạng',
            'addTimeLimit.required' => 'Yêu cầu không để trống',
            'addTimeLimit.integer' => 'Sai kiểu dữ liệu',
            'addTimeLimit.min' => 'Giá trị phải lớn hơn 1',
        ]);

        $errs = $validator->errors();

        $checkLesson = Lesson::where([['class_id', '=', $request->input('class_id')], ['start_at', '=', $request->input('addTimeLimit')]])->get()->first();

        if (!empty($checkLesson)) {
            return response()->json([ 'mess' => 'Sửa bản ghi lỗi, buổi học đã tồn tại'], 400);
        } else if ( $validator->fails() ) {
            return response()->json(['errors' => $errs, 'mess' => 'Sửa bản ghi lỗi'], 400);
        } else {
            $lesson = new Lesson;
            $lesson->start_at = $request->input('addStartDate');
            $lesson->class_id = $request->input('class_id');
            $lesson->time_limit = $request->input('addTimeLimit');
            $lesson->is_active = 1;

            if ($lesson->save()) {
                return response()->json(['mess' => 'Sửa bản ghi thành công', 200]);
            } else {
                return response()->json(['mess' => 'Sửa bản ghi lỗi'], 502);
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
        $lesson = Lesson::find($id);

        if (empty($lesson)) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 400);
        } else {
            $validator = Validator::make($request->all(), [
                'startDate' => 'required|date_format:"Y-m-d H:i:s',
            ], [
                'startDate.required' => 'Yêu cầu không để trống',
                'startDate.date_format' => 'Sai định dạng',
            ]);
    
            $errs = $validator->errors();
    
            if ( $validator->fails() ) {
                return response()->json(['errors' => $errs, 'mess' => 'Sửa bản ghi lỗi'], 400);
            } else {

                $lesson->start_at = $request->input('startDate');
               
                if ($lesson->save()) {
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
