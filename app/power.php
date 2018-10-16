<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class power extends Model
{
	public function position(){
		return $this->belongsTo(Position::class);
	}    
	public function users(){
		return $this->belongsToMany(User::class);
	}
}
