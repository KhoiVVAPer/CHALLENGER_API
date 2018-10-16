<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Position;
class PositionController extends Controller
{
    public function GetUsers($id){
    	return Position::find($id)->users;
    }
}
