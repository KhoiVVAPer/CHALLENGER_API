<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Events\NewRequest;
class NotificationController extends Controller
{
    public function GetListUser($id){
    	if($id){
    		$notifications =  User::find($id)->notifications;
	    	$listUser = [];
	    	foreach ($notifications as $item) {
	    		$listUser[] = User::find($item->from_id); 
	    	}
	    	return $listUser;
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
    public function DeleteRequest($id){
    	return DB::table('notifications')->where('id','=',$id)->delete();

    }
}
