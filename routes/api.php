<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->post('/groups', 'GroupController@store');
Route::middleware('auth:api')->get('/groups', 'GroupController@getForUsers');
Route::middleware('auth:api')->delete('/groups/{group}', 'GroupController@destroy');
Route::middleware('auth:api')->patch('/groups/{group}', 'GroupController@update');
