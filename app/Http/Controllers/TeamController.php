<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invitation;
use App\Team;
use App\Matches;
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
    public function AddMatch(Request $request){
        $newMatch = new Matches;
        $newMatch->team_one_id = $request['teamOne'];
        $newMatch->team_second_id = $request['teamSecond'];
        $newMatch->team_second_score = 0;
        $newMatch->team_one_score = 0;
        $newMatch->organization_day = "";
        $newMatch->place = "";
        $newMatch->match_note="";
        $newMatch->save();
        return "1";
    }
    public function GetMatches($id){
        $listMatch = DB::table('matches')->where('team_one_id','=',$id)->orWhere('team_second_id','=',$id)->get();
        return $listMatch;
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

    public function GetNotifications($id){
        return DB::table('notifications')->where('user_id',"=",$id)
        ->where('notification_type_id',"=",3)->get();
    }

    public function GetListTeamChallenge($id){
        if($id){
			$notifications = DB::table('notifications')->where('user_id',"=",$id)
            ->where('notification_type_id',"=",3)->get();
			$listTeams = [];
			foreach($notifications as $item){
				if($item->notification_type_id == '3'){
					$listTeams[] = Team::find($item->from_id); 
				}
			}
	    	return $listTeams;
    	}
    }
}
