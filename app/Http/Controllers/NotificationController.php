<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use App\User;
class NotificationController extends Controller
{
    public function GetListUser($id){
    	$notifications =  User::find($id)->notifications;
    	$listUser = [];
    	foreach ($notifications as $item) {
    		$listUser[] = User::find($item->from_id); 
    	}
    	return $listUser;
    }

    public function AddFriendRequest($id , Request $request){
    	$notification = new Notification;
    	$notification->user_id = $id;
    	$notification->from_id = $request['from_id'];
    	$notification->notification_type_id = 1;
    	$notification->status = 0;
    	$notification->message = $request['message'];
    	$notification->save();
    	return $notification;
    }
}
