<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Power;
use App\Position;
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
        ->select('power_user.id','powers.PowerName','powers.Description','position_user.TypeCode','power_user.self_point','power_user.ViewStatus')
        ->where('power_user.user_id',$id)
        ->where('position_user.user_id',$id)
        ->groupBy('power_user.id','powers.PowerName','powers.Description','position_user.TypeCode','power_user.self_point','power_user.ViewStatus')
        ->get();
    }

    public function addUserPowers($id,Request $request){
        $listPowers = Position::find($request['idPosition'])->power; 
        foreach ($listPowers as $key => $value) {
            DB::table('power_user')->insert(['user_id' => $id, 'power_id' => $value->id,'self_point' => '20','ViewStatus' => '1']);
        }
        return DB::table('powers')
        ->join('power_user', 'power_user.power_id','=','powers.id')
        ->join('position_user','powers.position_id','=','position_user.position_id')
        ->select('power_user.id','powers.PowerName','powers.Description','position_user.TypeCode','power_user.self_point','power_user.ViewStatus')
        ->where('power_user.user_id',$id)
        ->where('position_user.user_id',$id)
        ->groupBy('power_user.id','powers.PowerName','powers.Description','position_user.TypeCode','power_user.self_point','power_user.ViewStatus')
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
        $position = Position::find($request['position_id']);
        $user = User::find($request['user_id']);
        $user->MainPosition = $position->PositionName;
        $user->save();
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

    public function UserPowerUpdate($id,Request $request){
        $errorCount = 0;
        for($i = 0 ; $i < 20 ; $i++){
           DB::table('power_user')->where('id', $request[$i]['id'])
           ->update(['self_point' => $request[$i]['self_point'],
            'ViewStatus' => $request[$i]['ViewStatus']]); 
        }
        return "1";
    }

    public function UserListPowerUpdate($id,Request $request){
        $type = DB::table('position_user')
        ->select('position_user.TypeCode')
        ->where('id','=',$request['id'])
        ->get();
        $position = DB::table('position_user')->where('user_id','=',$id)->where('TypeCode','=',$type[0]->TypeCode)->get();
        $listPowers = Position::find($position[0]->position_id)->power;
        foreach ($listPowers as $key => $value) {
            DB::table('power_user')
            ->where('user_id','=',$id)
            ->where('power_id','=',$value->id)
            ->delete();
        }
        $listAddPowers = Position::find($request['position_id'])->power;
        foreach ($listAddPowers as $key => $value) {
            DB::table('power_user')->insert(['user_id' => $id, 'power_id' => $value->id,'self_point' => '20','ViewStatus' => '1']);
        }
    }
    public function UserListPowerDelete($id){
        $position = DB::table('position_user')->where('id','=',$id)->get();
        $user_id = $position[0]->user_id;
        $listPowers = Position::find($position[0]->position_id)->power;
        foreach ($listPowers as $key => $value) {
            DB::table('power_user')
            ->where('user_id','=',$user_id)
            ->where('power_id','=',$value->id)
            ->delete();
        }
    }
}
