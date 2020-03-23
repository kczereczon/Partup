<?php
$NS = "Api\V1\\";

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->post('/groups', "GroupController@store");
Route::middleware('auth:api')->get('/groups', "GroupController@getForUsers");
Route::middleware('auth:api')->get('/groups/all', "GroupController@getAllOwnedGroups");
Route::middleware('auth:api')->delete('/groups/{group}', "GroupController@destroy");
Route::middleware('auth:api')->patch('/groups/{group}', "GroupController@update");

Route::middleware('auth:api')->post('/course', "CourseController@store");

Route::post('/login', "{$NS}AuthController@login");
Route::post('/register', "{$NS}AuthController@register");
