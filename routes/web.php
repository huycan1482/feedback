<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Admin login
Route::get('adminLogin', 'Auth\LoginController@login')->name('admin.login');
Route::post('postAdminLogin', 'Auth\LoginController@postLogin')->name('admin.postLogin');
Route::get('adminLogout', 'Auth\LoginController@logout')->name('admin.logout');

//Admin Register
Route::get('register', 'Auth\RegisterController@register')->name('admin.register');
Route::post('postRegister', 'Auth\RegisterController@postRegister')->name('admin.postRegister');

Route::group(['prefix' => 'admin' , 'as' => 'admin.', 'middleware' => 'checkAdminLogin'], function () {

    Route::get('/404', function () {
        return view ('admin.errors.404', [
            'status' => 404
        ]);
    })->name('errors.404');

    Route::get('/403', function () {
        return view ('admin.errors.404', [
            'status' => 403
        ]);
    })->name('errors.403');
    
    Route::get('/', 'AdminController@index')->name('dashboard');
    Route::resource('answer', 'AnswerController');
    Route::resource('question', 'QuestionController');
    Route::get('listAnswers/{id}', 'QuestionController@getListAnswers')->name('question.getListAnswer');

    Route::resource('subject', 'SubjectController');
    Route::get('subject/forceDelete/{id}', 'SubjectController@forceDelete')->name('subject.forceDelete');
    Route::get('subject/restore/{id}', 'SubjectController@restore')->name('subject.restore');

    Route::resource('course', 'CourseController');

    Route::resource('feedback', 'FeedbackController');
    Route::resource('feedbackQuestion', 'FeedbackQuestionController');
    Route::get('listQuestions/{id}', 'FeedBackController@getListQuestions')->name('question.getListQuestions');

    Route::resource('teacher', 'TeacherController');
    Route::get('teacher/forceDelete/{id}', 'TeacherController@forceDelete')->name('teacher.forceDelete');
    Route::get('teacher/restore/{id}', 'TeacherController@restore')->name('teacher.restore');

    Route::resource('user', 'UserController');
    Route::get('user/forceDelete/{id}', 'UserController@forceDelete')->name('user.forceDelete');
    Route::get('user/restore/{id}', 'UserController@restore')->name('user.restore');

    Route::resource('student', 'StudentController');
    Route::get('user/forceDelete/{id}', 'StudentController@forceDelete')->name('student.forceDelete');
    Route::get('user/restore/{id}', 'StudentController@restore')->name('student.restore');

    Route::resource('userClass', 'UserClassController');

    Route::resource('lesson', 'LessonController');
    Route::resource('class', 'ClassController');
});


//UserLogin
Route::get('login', 'Auth\LoginController@userLogin')->name('user.login');
Route::post('postUserLogin', 'Auth\LoginController@postUserLogin')->name('user.postUserLogin');
Route::get('logout', 'Auth\LoginController@userLogout')->name('user.logout');

Route::group(['middleware' => 'checkUserLogin'], function () {
    //Feedback
    Route::get('/', 'HomeController@index')->name('feedback.index');
    Route::get('/checkIn', 'HomeController@getCheckIn')->name('feedback.getCheckIn');
    Route::get('/checkIn/{id}', 'HomeController@getCheckInId')->name('feedback.getCheckInId');
    Route::post('/postCheckIn', 'HomeController@postCheckIn')->name('feedback.postCheckIn');
    Route::get('/feed_back', 'HomeController@getFeedback')->name('feedback.getFeedback');
    Route::get('/feed_back/{class_id}_{feedback_id}', 'HomeController@getFeedbackId')->name('feedback.getFeedbackId');
    Route::post('/postFeedBack', 'HomeController@postFeedback')->name('feedback.postFeedback');
    Route::get('/profile', 'HomeController@getProfile')->name('feedback.getProfile');
    Route::put('/updateProfile/{id}/edit', 'HomeController@updateProfile')->name('feedback.updateProfile');
});

Route::get('/', function () {
    return redirect()->route('user.login');
});