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
Route::middleware('auth:api')->get('/user/groups', "{$NS}UserController@getGroups");
Route::middleware('auth:api')->get('/groups/{id}/news', "{$NS}GroupController@getNewsList");
Route::middleware('auth:api')->get('/course/{id}/exams', "{$NS}CourseController@getExamsList");
Route::middleware('auth:api')->get('/course/{id}/homeworks', "{$NS}CourseController@getHomeworksList");


Route::middleware('auth:api')->post('/course', "{$NS}CourseController@store");
Route::middleware('auth:api')->get('/course', "{$NS}CourseController@index");
Route::middleware('auth:api')->delete('/course/{id}', "{$NS}CourseController@destroy");
Route::middleware('auth:api')->patch('/course/{id}', "{$NS}CourseController@update");

Route::get('/group-invitations', "{$NS}GroupInvitationController@show");
Route::middleware('auth:api')->post('/group-invitations/accept', "{$NS}GroupInvitationController@accept");

//courses
Route::middleware('auth:api')->post('/homeworks', "{$NS}HomeworkController@store");
Route::middleware('auth:api')->post('/exam', "{$NS}ExamController@store");

//groups
Route::middleware('auth:api')->post('/news', "{$NS}NewsController@store");

Route::post('/login', "{$NS}AuthController@login");
Route::post('/register', "{$NS}AuthController@register");
