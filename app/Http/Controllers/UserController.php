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
        $user = User::withTrashed()->find(4);
        $user->restore();
        // User::withTrashed()->find(4)->restore();
        $users = User::latest()->get();
        // dd(User::find(4)->classes);
        // $users = User::withTrashed()->latest()->get();
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,id',
            'code' => 'required|unique:users,code',
            'gender' => 'required|integer|min:1|max:3',
            'date_of_birth' => 'required|date_format:"Y-m-d"',
            'phone' => 'required|size:10',
            'address' => 'required',
            'is_active' => 'integer|boolean',
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
            'role.exists' => 'Dữ liệu không tồn tại',
            'code.required' => 'Yêu cầu không để trống',
            'code.unique' => 'Dữ liệu bị trùng',
            'gender.required' => 'Yêu cầu không để trống',
            'gender.integer' => 'Sai kiểu dữ liệu',
            'gender.min' => 'Sai kiểu dữ liệu',
            'gender.max' => 'Sai kiểu dữ liệu',
            'date_of_birth.required' => 'Yêu cầu không để trống',
            'date_of_birth.date_format' => 'Sai kiểu dữ liệu',
            'phone.required' => 'Yêu cầu không để trống',
            'phone.size' => 'ĐỌ dài 10 chữ số',
            'address.required' => 'Yêu cầu không để trống',
            'is_active.integer' => 'Sai kiểu dữ liệu',
            'is_active.boolean' => 'Sai kiểu dữ liệu',
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
            $user->code = $request->input('code');
            $user->gender = $request->input('gender');
            $user->date_of_birth = $request->input('date_of_birth');
            $user->phone = $request->input('phone');
            $user->address = $request->input('address');
            $user->is_active = (int)$request->input('is_active');   
            
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
                'code' => 'required|unique:users,code,'.$id,
                'gender' => 'required|integer|min:1|max:3',
                'date_of_birth' => 'required|date_format:"Y-m-d"',
                'phone' => 'required|size:10',
                'address' => 'required',
                'is_active' => 'integer|boolean',
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
                'role.exits' => 'Dữ liệu không tồn tại',
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
                'is_active.integer' => 'Sai kiểu dữ liệu',
                'is_active.boolean' => 'Sai kiểu dữ liệu',
            ]);
    
            $errs = $validator->errors();
    
            if ( $validator->fails() ) {
                return response()->json(['errors' => $errs, 'mess' => 'Thêm bản ghi lỗi'], 400);
            } else {
                $user = new User();

                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->role_id = $request->input('role');
                $user->code = $request->input('code');
                $user->gender = $request->input('gender');
                $user->date_of_birth = $request->input('date_of_birth');
                $user->phone = $request->input('phone');
                $user->address = $request->input('address'); 
                $user->is_active = (int)$request->input('is_active');   

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
        // User::destroy($id);

        // $user->classes->delete;

        // foreach ($user->classes as $item) {
        //     $item->delete();
        // }

        $user->delete();

    }

    
}
