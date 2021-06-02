<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view ('feedback.profile');
    }
}
