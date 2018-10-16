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


    public function GetPositions($id){
    	return User::find($id)->positions;
    }

    public function GetPowers($id){
    	return DB::table('powers')
    	->join('power_user', 'powers.id', '=', 'power_user.power_id')
    	->where('user_id','=',$id)
    	->select('powers.id','powers.PowerName','powers.Description','power_user.self_point','power_user.TypeCode')
    	->get();
    }
    public function GetTeams($id){
    	return User::find($id)->teams;
    }
}
