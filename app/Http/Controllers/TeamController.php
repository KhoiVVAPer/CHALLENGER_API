<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use Illuminate\Support\Facades\DB;
class TeamController extends Controller
{
    //
    public function Index(){
    	return Team::all();	 
    }
    public function GetTeamById($id){
    	return Team::find($id);
    }
    public function GetTeamMembers($id){
    	return Team::find($id)->users;
    }
    public function GetTeamMembersDetails($id){
    	return DB::table('team_user')->where('team_id','=',$id)->get();
    }
}
