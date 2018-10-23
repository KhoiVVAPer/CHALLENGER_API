<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class user extends Authenticatable
{
   public function positions(){
        return $this->belongsToMany(Position::class);
   }

   public function powers(){
        return $this->belongsToMany(Power::class);
   }

   public function teams(){
        return $this->belongsToMany(Team::class);
   }

}