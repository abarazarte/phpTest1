<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
  // table name
  protected $table = 'users';

  // filleable fields
	protected $fillable = array('username','password');

	// protected fields, these aren't shown
	protected $hidden = ['password'];
    
}
