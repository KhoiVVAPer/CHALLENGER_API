<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use App\User;
use App\Team;
use App\Events\DeleteNotification;
use Illuminate\Support\Facades\DB;
use App\Events\NewRequest;
class NotificationController extends Controller
{
    public function GetListUser($id){
    	if($id){
			$notifications =  User::find($id)->notifications;
			$listUser = [];
			foreach($notifications as $item){
				$listUser[] = User::find($item->from_id); 
			}
	    	return $listUser;
    	}
	}
	public function GetListTeam($id){
    	if($id){
			$notifications =  User::find($id)->notifications;
			$listTeams = [];
			foreach($notifications as $item){
				if($item->notification_type_id == '2'){
					$listTeams[] = Team::find($item->from_id); 
				}
			}
	    	return $listTeams;
    	}
	}
    public function AddFriendRequest($id , Request $request){
    	$notification = new Notification;
    	$notification->user_id = $id;
    	$notification->from_id = $request['from_id'];
    	$notification->notification_type_id = 1;
    	$notification->status = 0;
    	$notification->message = $request['message'];
    	$notification->created_at = date('Y-m-d H:i:s');
    	$notification->save();
    	$list = User::find($id)->notifications[0];
    	broadcast(new NewRequest($list))->toOthers();
    	return $list;
	}
	public function AddTeamRequest($id, Request $request){
		$notification = new Notification;
    	$notification->user_id = $id;
    	$notification->from_id = $request['from_id'];
    	$notification->notification_type_id = 2;
    	$notification->status = 0;
    	$notification->created_at = date('Y-m-d H:i:s');
    	$notification->save();
    	$list = User::find($id)->notifications[0];
    	broadcast(new NewRequest($list))->toOthers();
    	return $list;
	}
    public function DeleteRequest($id){
    	$result = DB::table('notifications')->where('id','=',$id)->delete();
    	return $result;
	}
	public function DeleteTeamRequest($idUser,$idTeam){
		$list = User::find($idUser)->notifications;
		foreach($list as $item => $value){
			if($value->from_id == $idTeam && $value->user_id == $idUser && $value->notification_type_id == '2'){
				broadcast(new DeleteNotification($value))->toOthers();
				DB::table('notifications')->where('id','=',$value->id)->delete();
				return "1";
			}
		}
	}	
}

