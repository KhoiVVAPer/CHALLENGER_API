<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Events\Login;
use App\Events\Logout;

class AuthenController extends Controller
{
    public function login(Request $request){
    	$user = DB::table('users')->where('Username',$request['username'])->first();
    	if($user && $user->password == $request['password']){
            DB::table('users')->where('Username',$request['username'])
                ->update(['status' => 1]);
            broadcast(new Login(User::where('Username',$request['username'])->get()[0]))->toOthers();
            return User::where('Username',$request['username'])->value('id');
        }else{
            return 0;
        };
    }
    public function logout(Request $request){
        $user = User::find($request->userId);
        $user->status = 0;
        if($user->save()){
                    broadcast(new Logout(User::find($request->userId)))->toOthers();
                    return 1;
                }
        return 0;
    }
}
