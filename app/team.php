<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class team extends Model
{
    public function users(){
    	return $this->belongsToMany(User::class);
    }
    public function notifications(){
        return $this->hasMany(Notification::class);
    }
}

