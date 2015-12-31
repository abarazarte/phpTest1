<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPayment extends Model
{
    // table name
    protected $table = 'user_payments';

    // User Relation
    public function user(){
      return $this->belongsTo('app\User', 'user_id', 'id');
    }
}
