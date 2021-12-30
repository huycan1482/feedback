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
        return view ('admin.errors.4xx', [
            'status' => 404
        ]);
    })->name('errors.404');

    Route::get('/403', function () {
        return view ('admin.errors.4xx', [
            'status' => 403
        ]);
    })->name('errors.403');
    
    Route::get('/', 'AdminController@index')->name('index');

    Route::get('/teacherClasses/class_{id}', 'AdminController@getTeacherClasses')->name('getTeacherClasses');
    Route::get('/classFeedbacks/feedback_{id}', 'AdminController@getClassFeedbacks')->name('getClassFeedbacks');
    Route::get('/feedbackResult/feedback_{id}', 'AdminController@getFeedbackResult')->name('getFeedbackResult');
    Route::get('/getFeedback', 'AdminController@getFeedback')->name('getFeedback');
    Route::get('/getActiveFeedback/{id}', 'AdminController@getActiveFeedback')->name('getActiveFeedback');
    Route::get('/activeFeedback/{id}', 'AdminController@activeFeedback')->name('activeFeedback');

    Route::resource('answer', 'AnswerController');

    Route::resource('question', 'QuestionController');
    Route::get('question/forceDelete/{id}', 'QuestionController@forceDelete')->name('question.forceDelete');
    Route::get('question/restore/{id}', 'QuestionController@restore')->name('question.restore');
    Route::get('listAnswers/{id}', 'QuestionController@getListAnswers')->name('question.getListAnswer');

    Route::resource('subject', 'SubjectController');
    Route::get('subject/forceDelete/{id}', 'SubjectController@forceDelete')->name('subject.forceDelete');
    Route::get('subject/restore/{id}', 'SubjectController@restore')->name('subject.restore');

    Route::resource('course', 'CourseController');
    Route::get('course/forceDelete/{id}', 'CourseController@forceDelete')->name('course.forceDelete');
    Route::get('course/restore/{id}', 'CourseController@restore')->name('course.restore');

    Route::resource('feedback', 'FeedbackController');
    Route::get('feedback/forceDelete/{id}', 'FeedbackController@forceDelete')->name('feedback.forceDelete');
    Route::get('feedback/restore/{id}', 'FeedbackController@restore')->name('feedback.restore');

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
    Route::get('class/forceDelete/{id}', 'ClassController@forceDelete')->name('class.forceDelete');
    Route::get('class/restore/{id}', 'ClassController@restore')->name('class.restore');

    Route::get('/dashboard', 'AdminController@getDashboard')->name('getDashboard');

    Route::resource('checkIn', 'CheckInController');
    Route::get('checkIn/getCourses/{id}', 'CheckInController@getCourses')->name('checkIn.getCourses');
    Route::get('checkIn/getClasses/{id}', 'CheckInController@getClasses')->name('checkIn.getClasses');
    Route::get('checkIn/getLessons/{id}', 'CheckInController@getLessons')->name('checkIn.getLessons');

    Route::resource('survey', 'SurveyController');
    Route::get('survey/forceDelete/{id}', 'SurveyController@forceDelete')->name('survey.forceDelete');
    Route::get('survey/restore/{id}', 'SurveyController@restore')->name('survey.restore');
});

//UserLogin
Route::get('login', 'Auth\LoginController@userLogin')->name('user.login');
Route::post('postUserLogin', 'Auth\LoginController@postUserLogin')->name('user.postUserLogin');
Route::get('logout', 'Auth\LoginController@userLogout')->name('user.logout');

Route::group(['middleware' => 'checkUserLogin'], function () {
    //Feedback
    Route::get('/404', function () {
        return view ('feedback.errors.4xx', [
            'status' => '404!',
            'msg' => 'Trang bạn tìm kiếm không tồn tại'
        ]);
    })->name('errors.404');

    Route::get('/generalError', function () {
        return view ('feedback.errors.general');
    })->name('errors.general');

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

Route::get('/publicSurvey/{code}', 'HomeController@getPublicSurvey')->name('getPublicSurvey');
Route::post('/postPublicSurvey', 'HomeController@postPublicSurvey')->name('postPublicSurvey');