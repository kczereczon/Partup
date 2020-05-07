<?php
$NS = "Api\V1\\";

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:web')->post('/groups', "{$NS}GroupController@store");
Route::middleware('auth:web')->get('/groups', "{$NS}GroupController@getForUsers");
Route::middleware('auth:web')->get('/groups/all', "{$NS}GroupController@getAllOwnedGroups");
Route::middleware('auth:web')->delete('/groups/{group}', "{$NS}GroupController@destroy");
Route::middleware('auth:web')->patch('/groups/{group}', "{$NS}GroupController@update");
Route::middleware('auth:web')->post('/groups/{id}/invite', "{$NS}GroupController@inviteUser");

//student view
Route::middleware('auth:web')->get('/user/groups', "{$NS}GroupController@getForStudent");
Route::middleware('auth:web')->get('/user/groups/{date}', "{$NS}GroupController@getForStudentDate");

Route::middleware('auth:web')->get('/user/course', "{$NS}CourseController@getForStudent");
Route::middleware('auth:web')->get('/user/course/{date}', "{$NS}CourseController@getForStudentDate");
//student view

//
//teacher view
//

//get teacher info with courses that he is signed in and all followed data
Route::middleware('auth:web')->get('/teacher/course/{date}', "{$NS}CourseController@getForTeacherDate");

//update,delete Exam
Route::middleware('auth:web')->patch('/teacher/course/exam/{exam}', "{$NS}ExamController@update");
Route::middleware('auth:web')->delete('/teacher/course/exam/{id}', "{$NS}ExamController@destroy");
//update,delete Homework
Route::middleware('auth:web')->patch('/teacher/course/homework/{homework}', "{$NS}HomeworkController@update");
Route::middleware('auth:web')->delete('/teacher/course/homework/{id}', "{$NS}HomeworkController@destroy");
//update,delete News
Route::middleware('auth:web')->patch('/teacher/course/news/{news}', "{$NS}NewsController@updateCourse");
Route::middleware('auth:web')->delete('/teacher/course/news/{id}', "{$NS}NewsController@destroy");

//
//teacher view
//

Route::middleware('auth:web')->post('/course', "{$NS}CourseController@store");
Route::middleware('auth:web')->get('/course', "{$NS}CourseController@index");
Route::middleware('auth:web')->delete('/course/{id}', "{$NS}CourseController@destroy");
Route::middleware('auth:web')->patch('/course/{id}', "{$NS}CourseController@update");

Route::middleware('auth:web')->post('/group-invitations/accept', "{$NS}GroupInvitationController@accept");
Route::middleware('api')->get('/group-invitations', "{$NS}GroupInvitationController@show");
Route::middleware('api')->get('/users/current-logged', "{$NS}UserController@currentLogged");

//courses
Route::middleware('auth:web')->post('/homeworks', "{$NS}HomeworkController@store");
Route::middleware('auth:web')->post('/exam', "{$NS}ExamController@store");
Route::middleware('auth:web')->post('course/news', "{$NS}NewsController@storeCourse");

//groups
Route::middleware('auth:web')->post('group/news', "{$NS}NewsController@storeGroup");


// Route::post('/login', "{$NS}AuthController@login");
// Route::post('/register', "{$NS}AuthController@register");

Auth::routes();
