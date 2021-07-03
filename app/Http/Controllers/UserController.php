<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // $user = User::withTrashed()->find(4);
        // $user->restore();
        // User::withTrashed()->find(4)->restore();
        // dd(Auth::check());
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ( $currentUser->can('checkAdmin', User::class) ) {
            $users = User::select('users.*')
                ->join('roles', 'roles.id', '=', 'users.role_id')
                ->where('users.id', '<>', Auth::user()->id)
                ->whereIn('roles.name', ['admin', 'manager'])
                ->latest('users.created_at')->get();

            $usersWithTrashed = User::onlyTrashed()
                ->select('users.*')
                ->join('roles', 'roles.id', '=', 'users.role_id')
                ->whereIn('roles.name', ['admin', 'manager'])
                ->latest('users.created_at')->get();

            return view ('admin.user.index', [
                'users' => $users,
                'usersWithTrashed' => $usersWithTrashed,
            ]);
        } else {
            return redirect()->route('admin.errors.403');
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ( $currentUser->can('checkAdmin', User::class) ) {
            $roles = Role::whereNotIn('roles.name', ['teacher', 'user'])
            ->latest()->get();
            return view ('admin.user.create', [
                'roles' => $roles
            ]); 
        } else {
            return redirect()->route('admin.errors.403');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ( $currentUser->can('checkAdmin', User::class) ) {
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
                'phone.size' => 'Độ dài 10 chữ số',
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
        } else {
            return response()->json(['mess' => 'Thêm bản ghi lỗi'], 403);
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
        $currentUser = User::findOrFail(Auth()->user()->id);
        
        if ( $currentUser->can('checkAdmin', User::class) ) {
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
        } else {
            return response()->json(['mess' => 'Thêm bản ghi lỗi'], 403);
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
        $currentUser = User::findOrFail(Auth()->user()->id);
        
        if ( $currentUser->can('checkAdmin', User::class) ) {
            $user = User::findOrFail($id);
            $roles = Role::whereNotIn('roles.name', ['teacher', 'user'])
            ->latest()->get();
            return view ('admin.user.edit', [
                'user' => $user,
                'roles' => $roles,
            ]);
        } else {
            return redirect()->route('admin.errors.403');
        }
       
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
        $currentUser = User::findOrFail(Auth()->user()->id);
        
        if ( $currentUser->can('checkAdmin', User::class) ) {

            $user = User::find($id);

            if (empty($user)) {
                return response()->json(['mess' => 'Bản ghi không tồn tại'], 400);
            } else {

                $validator = Validator::make($request->all(), [
                    'name' => 'required|string',
                    'email' => 'required|string|email|max:255|unique:users,email,'.$id,
                    'password' => 'nullable|string|min:8|confirmed',
                    'role' => 'required|exists:roles,id',
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
                    'phone.size' => 'Sai kiểu dữ liệu',
                    'address.required' => 'Yêu cầu không để trống',
                    'is_active.integer' => 'Sai kiểu dữ liệu',
                    'is_active.boolean' => 'Sai kiểu dữ liệu',
                ]);

                $errs = $validator->errors();
        
                if ( $validator->fails() ) {
                    return response()->json(['errors' => $errs, 'mess' => 'Sửa bản ghi lỗi'], 400);
                } else {

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
                        return response()->json(['mess' => 'Sửa bản ghi thành công', 200]);
                    } else {
                        return response()->json(['mess' => 'Sửa bản ghi lỗi'], 502);
                    }
                    
                }
            }
        } else {
            return response()->json(['mess' => 'Sửa bản ghi lỗi'], 403);
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
        $currentUser = User::findOrFail(Auth()->user()->id);

        if ( $currentUser->can('forceDelete', User::class) ) {
            $user = User::find($id);

            if ( empty($user) ) {
                return response()->json(['mess' => 'Bản ghi không tồn tại'], 400);
            }
        
            if( $user->delete() ) {
                return response()->json(['mess' => 'Xóa bản ghi thành công'], 200);
            } else {
                return response()->json(['mess' => 'Xóa bản không thành công'], 400);
            }
        } else {
            return response()->json(['mess' => 'Xóa bản ghi lỗi'], 403);
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
