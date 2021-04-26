<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->get();
        return view ('admin.user.index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        DB::table('users')
        ->select(['users.name', 'users.email', 'users.created_at', 'roles.name'])
        ->leftJoin('roles', 'roles.id', '=', 'users.role_id')
        ->where('users.id', '=', 2)
        ->get()->first();
        $roles = Role::latest()->get();
        return view ('admin.user.create', [
            'roles' => $roles
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
        dd($request->input('password'));
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exits:roles,id',
        ], [
            'name.required' => 'Yêu cầu không để trống',
            'name.string' => 'Sai kiểu dữ liệu',
            'email.required' => 'Yêu cầu không để trống',
            'email.email' => 'Yêu cầu email',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Yêu cầu không để trống',
            'password.min' => 'Độ dài phải lớn hơn 8 kí tự',
            'password.confirmed' => 'Nhập lại mật khẩu không khớp',
            'role.required' => 'Yêu cầu không để trống',
            'role.exits' => 'Dữ liệu không tồn tại'
        ]);

        $errs = $validator->errors();

        if ( $validator->fails() ) {
            return response()->json(['errors' => $errs, 'mess' => 'Thêm bản ghi lỗi'], 400);
        } else {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->role_id = $request->input('role');
            $user->password = Hash::make($request->input('password'));
            if (!empty($request->input('password'))) {
                $user->password = Hash::make($request->input('password'));
            }
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
        $user = DB::table('users')
            ->select(['users.name', 'users.email', 'users.created_at', 'roles.name as role'])
            ->leftJoin('roles', 'roles.id', '=', 'users.role_id')
            ->where('users.id', '=', $id)
            ->get()->first();

        if (empty($user)) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 404);
        } else {
            return response()->json(['user' => $user], 200);
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
        $user = User::findOrFail($id);
        $roles = Role::latest()->get();
        return view ('admin.user.edit', [
            'user' => $user,
            'roles' => $roles,
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
        
        $user = User::find($id);
        if (empty($user)) {
            return response()->json(['mess' => 'Bản ghi không tồn tại'], 400);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|string|email|max:255|unique:users,email,'.$id,
                'password' => 'nullable|string|min:8|confirmed',
                'role' => 'required|exits:roles,id',
            ], [
                'name.required' => 'Yêu cầu không để trống',
                'name.string' => 'Sai kiểu dữ liệu',
                'email.required' => 'Yêu cầu không để trống',
                'email.email' => 'Yêu cầu email',
                'email.unique' => 'Email đã tồn tại',
                'password.required' => 'Yêu cầu không để trống',
                'password.min' => 'Độ dài phải lớn hơn 8 kí tự',
                'password.confirmed' => 'Nhập lại mật khẩu không khớp',
                'role.required' => 'Yêu cầu không để trống',
                'role.exits' => 'Dữ liệu không tồn tại'
            ]);
    
            $errs = $validator->errors();
    
            if ( $validator->fails() ) {
                return response()->json(['errors' => $errs, 'mess' => 'Thêm bản ghi lỗi'], 400);
            } else {
                $user = new User();
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->role_id = $request->input('role');
                // $user->password = Hash::make($request->input('password'));
    
                if ($user->save()) {
                    return response()->json(['mess' => 'Thêm bản ghi thành công', 200]);
                } else {
                    return response()->json(['mess' => 'Thêm bản ghi lỗi'], 502);
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
