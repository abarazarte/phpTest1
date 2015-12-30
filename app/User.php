<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //UserPayment Relation
    public function userPayments(){
      return $this->hasMany('App/UserPayment', 'user_id');
    }

    //UserFavorite Relation
    public function userFavorites(){
      return $this->hasMany('App/UserFavorite', 'favorite_user_id');
    }

    public function userFavorite(){
      return $this->belongsTo('App/UserFavorite', 'user_id')
    }
}
