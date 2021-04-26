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

Route::get('/', function () {
    return view('welcome');
});



// Auth::routes();

//login
Route::get('login', 'Auth\LoginController@login')->name('admin.login');
Route::post('postLogin', 'Auth\LoginController@postLogin')->name('admin.postLogin');

//Register
Route::get('register', 'Auth\RegisterController@register')->name('admin.register');
Route::post('postRegister', 'Auth\RegisterController@postRegister')->name('admin.postRegister');

// //ResetPassword
// Route::get('checkEmail', 'Auth\ResetPasswordController@checkEmail')->name('admin.checkEmail');
// Route::post('postCheckEmail', 'Auth\ResetPasswordController@postCheckEmail')->name('admin.postCheckEmail');
// // Route::get('checkToken', 'Auth\ResetPasswordController@checkToken')->name('admin.checkToken');
// // Route::post('postCheckToken', 'Auth\ResetPasswordController@postCheckToken')->name('admin.postCheckToken');
// Route::get('resetPassword', 'Auth\ResetPasswordController@index')->name('admin.resetPassword');
// Route::post('postResetPassword', 'Auth\ResetPasswordController@postResetPassword')->name('admin.postResetPassword');

// // logout
// Route::get('logout', 'Auth\LoginController@logout')->name('admin.logout');

Route::group(['prefix' => 'admin' , 'as' => 'admin.', 'middleware' => 'guest'], function () {
    Route::get('/', 'AdminController@index')->name('dashboard');
    Route::resource('answer', 'AnswerController');
    Route::resource('question', 'QuestionController');
    Route::get('listAnswers/{id}', 'QuestionController@getListAnswers')->name('question.getListAnswer');
    Route::resource('feedback', 'FeedbackController');
    Route::resource('subject', 'SubjectController');
    Route::resource('course', 'CourseController');
    Route::resource('user', 'UserController');
});
// Route::get('/home', 'HomeController@index')->name('home');
