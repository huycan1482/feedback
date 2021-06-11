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

// Route::get('/', function () {
//     return view('welcome');
// });


//UserLogin
Route::get('/login', 'Auth\LoginController@userLogin')->name('user.login');
Route::post('postUserLogin', 'Auth\LoginController@postUserLogin')->name('user.postUserLogin');
Route::get('logout', 'Auth\LoginController@userLogout')->name('user.logout');

Route::group(['middleware' => 'checkUserLogin'], function () {
    //Feedback
    Route::get('/', 'HomeController@index')->name('feedback.index');
    Route::get('/checkIn', 'HomeController@getCheckIn')->name('feedback.getCheckIn');
    Route::get('/feed_back', 'HomeController@getFeedback')->name('feedback.getFeedback');
    Route::get('/profile', 'HomeController@getProfile')->name('feedback.getProfile');
    Route::put('/updateProfile/{id}/edit', 'HomeController@updateProfile')->name('feedback.updateProfile');
});


//Admin login
Route::get('adminLogin', 'Auth\LoginController@login')->name('admin.login');
Route::post('postAdminLogin', 'Auth\LoginController@postLogin')->name('admin.postLogin');
Route::get('adminLogout', 'Auth\LoginController@logout')->name('admin.logout');

//Admin Register
Route::get('register', 'Auth\RegisterController@register')->name('admin.register');
Route::post('postRegister', 'Auth\RegisterController@postRegister')->name('admin.postRegister');


Route::group(['prefix' => 'admin' , 'as' => 'admin.', 'middleware' => 'checkAdminLogin'], function () {
    Route::get('/', 'AdminController@index')->name('dashboard');
    Route::resource('answer', 'AnswerController');
    Route::resource('question', 'QuestionController');
    Route::get('listAnswers/{id}', 'QuestionController@getListAnswers')->name('question.getListAnswer');
    Route::resource('subject', 'SubjectController');
    Route::resource('course', 'CourseController');

    Route::resource('feedback', 'FeedbackController');
    Route::resource('feedbackQuestion', 'FeedbackQuestionController');
    Route::get('listQuestions/{id}', 'FeedBackController@getListQuestions')->name('question.getListQuestions');

    Route::resource('teacher', 'TeacherController');
    Route::resource('user', 'UserController');
    Route::resource('student', 'StudentController');
    Route::resource('userClass', 'UserClassController');

    Route::resource('lesson', 'LessonController');
    Route::resource('class', 'ClassController');
});
// Route::get('/home', 'HomeController@index')->name('home');
