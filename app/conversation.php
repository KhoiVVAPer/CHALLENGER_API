<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class conversation extends Model
{
    public function messages(){
    	return $this->hasMany(Message::class);
    }
    public function user(){
		return $this->belongsTo(User::class);
    }
}
