<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPayment extends Model
{
    // User Relation
    public function user(){
      return $this->belongsTo('App/User', 'user_id');
    }

    // Payment Relation
    public function payment(){
      return $this->hasOne('App/Payment', 'payment_id');
    }
}
