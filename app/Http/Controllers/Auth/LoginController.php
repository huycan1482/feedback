<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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

    public function login () 
    {
        return view ('auth.login');
    }

    public function postLogin (Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8'
        ], [
            'email.required' => 'Yêu cầu không để trống',
            'email.email' => 'Yêu cầu email',
            'password.required' => 'Yêu cầu không để trống',
            'password.min' => 'Độ dài phải lớn hơn 8 kí tự',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        // dd($request->input('remember'));

        $remember = $request->input('remember');

        // check success
        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            return redirect()->route('admin.question.index');
        }

        return redirect()->back()->with('msg', 'Email hoặc Password không chính xác');
    } 

    public function logout () 
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
