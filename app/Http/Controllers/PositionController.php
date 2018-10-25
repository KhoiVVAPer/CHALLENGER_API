<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Position;
use App\User;
class PositionController extends Controller
{
    public function GetUsers($id){
    	return Position::find($id)->users;
    }
    public function GetAllPositions(){
    	return Position::all();
    }

    public function UpdateUserPosition($id, Request $request){
    	$position = Position::find($request['position_id']);
    	$user = User::find($id);
    	if($request['type'] == "EP"){
    		$user->ExtraPosition = $position->PositionName;
    	}else if($request['type'] == "MP"){
    		$user->MainPosition = $position->PositionName;
    	}
    	$user->save();
    	return $user;
    }
    public function DeleteUserEPosition($id){
        $user = User::find($id);
        $user->ExtraPosition = "";
        $user->save();
        return $user;
    }
}
