<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Role;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }


    public function userLogin () 
    {
        return view ('auth.userLogin');
    }

    public function postUserLogin (LoginRequest $request)
    {

        $remember = $request->input('remember');

        $role_ids = Role::whereIn('name', ['user', 'teacher'])->get('id');

        foreach ($role_ids as $item) {
            $roles [] = $item->id; 
        }

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'is_active' => 1, 'role_id' => $roles], $remember)) {
            return redirect()->route('feedback.getProfile');
        }

        return redirect()->back()->with('msg', 'Email hoặc Password không chính xác');
    } 

    public function userLogout () 
    {
        Auth::logout();
        return redirect()->route('user.login');
    }

    public function login () 
    {
        return view ('auth.adminLogin');
    }

    public function postLogin (LoginRequest $request)
    {

        $remember = $request->input('remember');

        $role_ids = Role::whereIn('name', ['admin', 'manager'])->get('id');

        foreach ($role_ids as $item) {
            $roles [] = $item->id; 
        }

        if (Auth::attempt(['email' =>  $request->input('email'), 'password' => $request->input('password'), 'is_active' => 1, 'role_id' => $roles], $remember)) {
            return redirect()->route('admin.index');
        }

        return redirect()->back()->with('msg', 'Email hoặc Password không chính xác');
    } 

    public function logout () 
    {
        Auth::logout();
        return view ('auth.adminLogin');

    }


}
