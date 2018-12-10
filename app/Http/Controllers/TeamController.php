<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invitation;
use App\Team;
use Illuminate\Support\Facades\DB;
class TeamController extends Controller
{
    public function LeaveTeam($idTeam,$idUser){
        if(DB::table('team_user')->where('user_id','=',$idUser)
        ->where('team_id','=',$idTeam)->delete()){
            return "1";
        }else{
            return false;
        }
    }

    public function Index(){
    	return Team::all();	 
    }
    public function AddTeam(Request $request){
        $team = new Team;
        $code =  rand (100,99999) . "";
        $team->TeamCode = $code;
        $team->Fullname = $request['teamName'];
        $team->ImgUrl =$request['imgName'];
        $team->Ward = $request['teamWard'];
        $team->City = $request['teamCity'];
        $team->Description = $request['teamDescription'];
        $team->latitude = $request['latitude'];
        $team->longitude = $request['longitude'];
        $team->WinRate = 0;
        $team->TotalScore = 0;
        $team->TotalMatch = 0;
        $team->TotalWin = 0;
        $team->save();
        $newTeam = Team::where('TeamCode',$code)->get();
        if(DB::table('team_user')->insert(['user_id' => $request['idUser'],
        'team_id' => $newTeam[0]->id,
        'position_id' => 1,
        'role_id' => 3])){
            return "1";
        }
    }
    public function GetTeamById($id){
    	return Team::find($id);
    }
    public function GetTeamMembers($id){
    	return Team::find($id)->users;
    }
    public function GetMemberRole($idTeam,$idMember){
        return DB::table('team_user')
        ->where('team_id','=',$idTeam)
        ->where('user_id','=',$idMember)
        ->get();
    }

    public function GetTeamMembersDetails($id){
    	return DB::table('team_user')->where('team_id','=',$id)->get();
    }
    public function DeleteMember($id){
        if(DB::table('team_user')->where('id','=',$id)->delete()){
            return "1";
        }else{
            return false;
        }
    }       
    public function DeleteTeam($idTeam){
        if(DB::table('team_user')->where('team_id','=',$idTeam)->delete() &&
        DB::table('teams')->where('id','=',$idTeam)->delete()){
            return "1";
        }else{
            return false;
        }
    }
    public function GetInvitations($id){
        return DB::table('invitations')->where('team_id','=',$id)->orderBy('id','DESC')->get();
    }
    public function AddInvitation(Request $request){
        DB::table('invitations')->insert(['user_id' => $request['userId'],'team_id' => $request['teamId'],'status' => 0]);
        return DB::table('invitations')
        ->where('user_id','=',$request['userId'])
        ->where('team_id','=',$request['teamId'])   
        ->get();
    }
    public function DeleteInvitation($id){
        if(DB::table('invitations')->where('id',$id)->delete()){
            return 1;
        }
        return 0;
    }
    public function AddMember(Request $request){
        
        if(DB::table('team_user')
        ->insert(['user_id' => $request['idUser'],
        'team_id' => $request['idTeam'],
        'position_id' => 1,
        'role_id' => 1]) && 
        DB::table('invitations')
        ->where('team_id',$request['idTeam'])
        ->where('user_id',$request['idUser'])
        ->delete()){
            return "1";
        }
    }

}
