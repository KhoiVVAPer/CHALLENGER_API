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

/* Edit User */
Route::put('users/edit/{id}','UserController@EditUser');


/* Trả về danh sách position theo user_id */
Route::get('users/{id}/positions','UserController@GetPositions');

Route::get('positions/{id}/users','PositionController@GetUsers');

Route::get('positions', 'PositionController@GetAllPositions');

Route::get('positions/{id}', 'PositionController@GetPosition');

Route::get('users/{id}/powers','UserController@GetPowers');

Route::get('users/{id}/teams','UserController@GetTeams');

Route::put('users/edit/password/{id}','UserController@ChangePassword');

Route::get('teams','TeamController@Index');

Route::post('user/positions/mp/add','UserController@UserAddOrUpdateMainPosition');
Route::put('user/positions/mp/update','UserController@UserAddOrUpdateMainPosition');

Route::post('user/positions/ep/add','UserController@UserAddOrUpdateExtraPosition');
Route::put('user/positions/ep/update','UserController@UserAddOrUpdateExtraPosition');

Route::put('user/{id}/position/update','PositionController@UpdateUserPosition');
Route::delete('user/{id}/position/delete','PositionController@DeleteUserEPosition');

Route::delete('user/positions/ep/delete/{id}','UserController@UserDeletePosition');

Route::put('user/{id}/powers/update','UserController@UserPowerUpdate');

Route::get('team/{id}','TeamController@GetTeamById');

Route::get('team/{id}/members','TeamController@GetTeamMembers');

Route::get('team/{id}/members/details','TeamController@GetTeamMembersDetails');