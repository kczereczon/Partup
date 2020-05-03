<?php
$NS = "Api\V1\\";

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->post('/groups', "{$NS}GroupController@store");
Route::middleware('auth:api')->get('/groups', "{$NS}GroupController@getForUsers");
Route::middleware('auth:api')->get('/groups/all', "{$NS}GroupController@getAllOwnedGroups");
Route::middleware('auth:api')->delete('/groups/{group}', "{$NS}GroupController@destroy");
Route::middleware('auth:api')->patch('/groups/{group}', "{$NS}GroupController@update");
Route::middleware('auth:api')->post('/groups/{id}/invite', "{$NS}GroupController@inviteUser");

//student view
Route::middleware('auth:api')->get('/user/groups', "{$NS}GroupController@getForStudent");
Route::middleware('auth:api')->get('/user/groups/{date}', "{$NS}GroupController@getForStudentDate");

Route::middleware('auth:api')->get('/user/course', "{$NS}CourseController@getForStudent");
Route::middleware('auth:api')->get('/user/course/{date}', "{$NS}CourseController@getForStudentDate");
//student view

//
//teacher view
//

//get teacher info with courses that he is signed in and all followed data
Route::middleware('auth:api')->get('/teacher/course/{date}', "{$NS}CourseController@getForTeacherDate");

//update,delete Exam
Route::middleware('auth:api')->patch('/teacher/course/exam/{exam}', "{$NS}ExamController@update");
Route::middleware('auth:api')->delete('/teacher/course/exam/{id}', "{$NS}ExamController@delete");

//
//teacher view
//

Route::middleware('auth:api')->post('/course', "{$NS}CourseController@store");
Route::middleware('auth:api')->get('/course', "{$NS}CourseController@index");
Route::middleware('auth:api')->delete('/course/{id}', "{$NS}CourseController@destroy");
Route::middleware('auth:api')->patch('/course/{id}', "{$NS}CourseController@update");

Route::get('/group-invitations', "{$NS}GroupInvitationController@show");
Route::middleware('auth:api')->post('/group-invitations/accept', "{$NS}GroupInvitationController@accept");

//courses
Route::middleware('auth:api')->post('/homeworks', "{$NS}HomeworkController@store");
Route::middleware('auth:api')->post('/exam', "{$NS}ExamController@store");
Route::middleware('auth:api')->post('course/news', "{$NS}NewsController@storeCourse");

//groups
Route::middleware('auth:api')->post('group/news', "{$NS}NewsController@storeGroup");


Route::post('/login', "{$NS}AuthController@login");
Route::post('/register', "{$NS}AuthController@register");
