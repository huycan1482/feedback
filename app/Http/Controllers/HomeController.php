<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('feedback.home');
    }

    public function getCheckIn ()
    {
        return view ('feedback.checkIn');
    }

    public function getFeedback ()
    {
        return view ('feedback.feedback');
    }

    public function getProfile ()
    {
        $user = Auth::user();
        return view ('feedback.profile', [
            'user' => $user,
        ]);
    }

    public function updateProfile (Request $request, $id)
    {
        if (Auth::user()->id == $id) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'code' => 'required|unique:users,code,'.$id,
                'gender' => 'required|integer|min:0|max:1',
                'date_of_birth' => 'required|date_format:"Y-m-d"',
                'phone' => 'required|size:10',
                'address' => 'required',
                'email' => 'required|string|email|max:255|unique:users,email,'.$id,
                'password' => 'nullable|string|min:8|confirmed',
                'is_active' => 'integer|boolean',

            ], [
                'name.required' => 'Yêu cầu không để trống',
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
                'email.required' => 'Yêu cầu không để trống',
                'email.email' => 'Yêu cầu email',
                'email.unique' => 'Email đã tồn tại',
                'password.min' => 'Độ dài phải lớn hơn 8 kí tự',
                'password.confirmed' => 'Nhập lại mật khẩu không khớp',
                'is_active.integer' => 'Sai kiểu dữ liệu',
                'is_active.boolean' => 'Sai kiểu dữ liệu',
            ]);
    
            $errs = $validator->errors();
    
            if ( $validator->fails() ) {
                return response()->json(['errors' => $errs, 'mess' => 'Sửa bản ghi lỗi'], 400);
            } else {
                $user = User::find($id);
                $user->name = $request->input('name');
                $user->code = $request->input('code');
                $user->gender = $request->input('gender');
                $user->date_of_birth = $request->input('date_of_birth');
                $user->phone = $request->input('phone');
                $user->address = $request->input('address');
                $user->email = $request->input('email');
                if (!empty($request->input('password'))) {
                    $user->password = Hash::make($request->input('password'));
                }

                if ($user->save()) {
                    return response()->json(['mess' => 'Sửa bản ghi thành công', 200]);
                } else {
                    return response()->json(['mess' => 'Sửa bản ghi lỗi'], 502);
                }
                
            }
        } else {
            return response()->json(['mess' => 'Hành động bị cấm'], 403);
        }
    }
}
