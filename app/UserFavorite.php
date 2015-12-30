<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFavorite extends Model
{
    //User Relation
    public function user(){
      return $this->belongsTo('App/User', 'user_id');
    }

    //Favorite user Relation
    public function favoriteUser(){
      return $this->hasOne('App/User', 'favorite_user_id');
    }
}
