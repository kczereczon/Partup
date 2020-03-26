<?php
$NS = "Api\V1\\";

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//
// Nie wiem czmu z {$NS} nie działa wywala error 500
//

Route::middleware('auth:api')->post('/groups', "GroupController@store");
Route::middleware('auth:api')->get('/groups', "GroupController@getForUsers");
Route::middleware('auth:api')->get('/groups/all', "GroupController@getAllOwnedGroups");
Route::middleware('auth:api')->delete('/groups/{group}', "GroupController@destroy");
Route::middleware('auth:api')->patch('/groups/{group}', "GroupController@update");

Route::middleware('auth:api')->post('/course', "{$NS}CourseController@store");
Route::middleware('auth:api')->get('/course', "{$NS}CourseController@index");
Route::middleware('auth:api')->delete('/course/{id}', "{$NS}CourseController@destroy");
Route::middleware('auth:api')->patch('/course/{id}', "{$NS}CourseController@update");

Route::middleware('auth:api')->post('/homeworks', "{$NS}HomeworkController@store");

Route::post('/login', "{$NS}AuthController@login");
Route::post('/register', "{$NS}AuthController@register");
