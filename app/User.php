<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
  // table name
  protected $table = 'users';

  // filleable fields
	protected $fillable = array('username','password', 'age');

	// protected fields, these aren't shown
	protected $hidden = ['password', 'pivot'];

  //Favorite user Relation
  public function payments(){
    return $this->hasMany('App\Payment', 'user_id', 'id');
  }

  public function favorites(){
    return $this->belongsToMany('App\User', 'user_favorites','user_id', 'favorite_user_id');
  }
}
