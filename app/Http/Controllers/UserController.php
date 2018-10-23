<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Power;
class UserController extends Controller
{
	/*
		Lấy danh sách User
	 */
    public function Index(){
    	return User::all(); 
    }

    /*
    	Lấy theo nhiều điều kiện
     */
    
    public function GetByOptions($request){
    	
    }
    
    /*
    	Lấy User theo id
     */
    public function GetById($id){
    	return User::find($id);
    }
    /*
    	Thêm user
     */
    public function AddUser(Request $request){
    	return User::create($request->all());
    }

    public function EditUser(Request $request, $id){
        $user = User::find($id);
        $user->Fullname = $request['Fullname'];
        $user->DateOfBirth = $request['DateOfBirth'];
        $user->Sex = $request['Sex'];
        $user->Email = $request['Email'];
        $user->Weight = $request['Weight'];
        $user->Height = $request['Height'];
        $user->City = $request['City'];
        $user->Ward = $request['Ward'];
        $user->Description = $request['Description'];
        $user->ImgUrl = $request['ImgUrl'];
        $user->MainPosition = $request['MainPosition'];
        $user->ExtraPosition = $request['ExtraPosition'];
        $user->save();
        return $user;
    }

    public function GetPositions($id){
    	return DB::table('positions')
        ->join('position_user','position_user.position_id','=','positions.id')
        ->select('position_user.id','position_user.position_id','positions.PositionCode','positions.PositionName','positions.Description',
            'position_user.TypeCode')
        ->where('position_user.user_id',$id)
        ->get();
    }

    public function GetPowers($id){
    	return DB::table('powers')
        ->join('power_user', 'power_user.power_id','=','powers.id')
        ->join('position_user','powers.position_id','=','position_user.position_id')
        ->select('powers.PowerName','powers.Description','position_user.TypeCode','power_user.self_point')
        ->where('power_user.user_id',$id)
        ->where('position_user.user_id',$id)
        ->groupBy('powers.PowerName','powers.Description','position_user.TypeCode','power_user.self_point')
        ->get();
    }
    public function GetTeams($id){
    	return User::find($id)->teams;
    }
    public function ChangePassword(Request $request, $id){
    	$user = User::find($id);
    	$user->password = $request['newPassword'];
    	$user->save();
    	return $user;
    }

    public function UserAddOrUpdateMainPosition(Request $request){
        if($request['id']){
            return DB::table('position_user')->where('id',$request['id'])
            ->update(['position_id' => $request['position_id'],'user_id' => $request['user_id']]);
        }else{
            return DB::table('position_user')
            ->insert(['position_id' => $request['position_id'],'user_id' => $request['user_id'],'TypeCode' => 'MP']);
        }
    }
    public function UserAddOrUpdateExtraPosition(Request $request){
        if($request['id']){
            return DB::table('position_user')->where('id',$request['id'])
            ->update(['position_id' => $request['position_id'],'user_id' => $request['user_id']]);
        }else{
            if(DB::table('position_user')
            ->insert(['position_id' => $request['position_id'],'user_id' => $request['user_id'],'TypeCode' => 'EP'])){
                return 1;
            }else{
                return 0;
            }
        }    
    }
    public function UserDeletePosition($id){
        return DB::table('position_user')->where('id','=',$id)->delete();
    }
}
