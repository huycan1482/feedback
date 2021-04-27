<?php

namespace App\Http\Controllers;

use App\Subject;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::latest()->get();
        return view ('admin.subject.index', [
            'subjects' => $subjects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.subject.create');
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
            'name' => 'required|unique:subjects,name',
            'code' => 'required',
            'is_active' => 'integer|boolean',
        ], [
            'name.required' => 'Yêu cầu không để trống',
            'name.unique' => 'Dữ liệu bị trùng',
            'code.required' => 'Yêu cầu không để trống',
            'is_active.integer' => 'Sai kiểu dữ liệu',
            'is_active.boolean' => 'Sai kiểu dữ liệu',
        ]);

        $errs = $validator->errors();

        if ( $validator->fails() ) {
            return response()->json(['errors' => $errs, 'mess' => 'Thêm bản ghi lỗi'], 400);
        } else {
            $subject = new Subject;
            $subject->name = $request->input('name');
            $subject->slug = Str::slug($request->input('name'));
            $subject->code = $request->input('code');
            $subject->is_active = (int)$request->input('is_active');
            $subject->user_create = Auth::user()->id;

            if ($subject->save()) {
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
        $subject = Subject::find($id);
        if (empty($subject)) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 404);
        } else {
            return response()->json(['subject' => $subject], 200);
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
        $subject = Subject::findOrFail($id);
        return view ('admin.subject.edit', [
            'subject' => $subject,
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
        $subject = Subject::find($id);
        if (empty($subject)) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 400);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:subjects,name,'.$id,
                'code' => 'required',
                'is_active' => 'integer|boolean',
            ], [
                'name.required' => 'Yêu cầu không để trống',
                'name.unique' => 'Dữ liệu bị trùng',
                'code.required' => 'Yêu cầu không để trống',
                'is_active.integer' => 'Sai kiểu dữ liệu',
                'is_active.boolean' => 'Sai kiểu dữ liệu',
            ]);
    
            $errs = $validator->errors();
    
            if ( $validator->fails() ) {
                return response()->json(['errors' => $errs, 'mess' => 'Sửa bản ghi lỗi'], 400);
            } else {
                $subject->name = $request->input('name');
                $subject->slug = Str::slug($request->input('name'));
                $subject->code = $request->input('code');
                $subject->is_active = (int)$request->input('is_active');
                $subject->user_update = Auth::user()->id;
    
                if ($subject->save()) {
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
