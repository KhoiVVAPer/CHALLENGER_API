<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class AuthenController extends Controller
{
    public function login(Request $request){
    	$user = DB::table('users')->where('Username',$request['username'])->first();
    	return (($user && $user->password == $request['password'])? $user->id : 0);
    }
}
