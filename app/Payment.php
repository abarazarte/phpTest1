<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //User Payment Relation
    public function userPayment(){
      return $this->belongsTo('App/UserPayment', 'payment_id');
    }
}
