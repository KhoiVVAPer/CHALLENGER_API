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
Route::post('users/add','UserController@addUser');
/* Check User */
Route::post('users/check','UserController@checkUser');

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

// Cập nhập thay đổi giá trị của chỉ số người dùng 
Route::put('user/{id}/powers/update','UserController@UserPowerUpdate');

// Cập nhập thay đổi danh sách chỉ số người dùng
Route::put('user/{id}/listPower/update', 'UserController@UserListPowerUpdate');
Route::delete('user/listPower/delete/{id}', 'UserController@UserListPowerDelete');

Route::get('team/{id}','TeamController@GetTeamById');

Route::get('team/{id}/members','TeamController@GetTeamMembers');

Route::get('team/{id}/members/details','TeamController@GetTeamMembersDetails');

Route::post('user/{id}/powers/add/','UserController@addUserPowers');


Route::get('user/{id}/notifications','UserController@GetAllNotification');

Route::get('user/{id}/ListUserSendNotification','NotificationController@GetListUser');
Route::post('user/{id}/friend-request/add','NotificationController@AddFriendRequest');

Route::delete('user/notifications/delete/{id}','NotificationController@DeleteRequest');


Route::get('user/{id}/notifications/sended','UserController@GetListUserNotificationSended');

Route::post('user/{id}/friends/add', 'UserController@AddFriend');

Route::get('user/{id}/friends','UserController@GetFriends');


Route::delete('user/{user_id}/friends/delete/{friend_id}','UserController@DeleteFriend');


Route::get('user/{id}/conversations','UserController@GetConversations');
Route::post('user/conversations/add','UserController@AddConversations');
Route::get('conversations/{id}/messages','UserController@GetConversationsMessages');
Route::post('conversations/{id}/messages/add','UserController@AddConversationsMessages');