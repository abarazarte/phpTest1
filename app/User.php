<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserPayment;

class User extends Model
{
  // table name
  protected $table = 'users';

  // filleable fields
	protected $fillable = array('username','password', 'age');

	// protected fields, these aren't shown
	protected $hidden = ['password'];

  //Favorite user Relation
  public function payments(){
    return $this->hasMany('App\Payment', 'user_id', 'id');
  }

}
