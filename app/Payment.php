<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    // table name
    protected $table = 'payments';

    // filleable fields
  	protected $fillable = array('amount');

    //User Payment Relation
    public function userPayment(){
      return $this->belongsTo('App/User', 'user_id', 'id');
    }
}
