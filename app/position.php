<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class position extends Model
{
    public function power(){
    	return $this->hasMany(Power::class);
    }
    public function users(){
    	return $this->belongsToMany(User::class);
    }
}
