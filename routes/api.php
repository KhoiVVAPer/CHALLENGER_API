<?php

use Illuminate\Http\Request;
use App\User;
use App\Power;
use App\Position;
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
Route::post('login','AuthenController@login');
/* Trả về danh sách user */
Route::get('users','UserController@Index');

/* Trả về user theo id */
Route::get('users/{id}','UserController@GetById');

/* Thêm User */
Route::post('users','UserController@AddUser');

/* Trả về danh sách position theo user_id */
Route::get('users/{id}/positions','UserController@GetPositions');

Route::get('positions/{id}/users','PositionController@GetUsers');

Route::get('users/{id}/powers','UserController@GetPowers');

Route::get('users/{id}/teams','UserController@GetTeams');

Route::get('teams','TeamController@Index');