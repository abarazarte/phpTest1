<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Model
use App\Payment;
use App\User;
use Response;
use Validator;

class UserPaymentsController extends Controller
{
  /**
 * Display a listing of the resource.
 *
 * @return Response
 */
  public function index($idUser){
    try {
      $user = User::find($idUser);
      if (!$user){
        return response()->json(['code'=>404,'messages'=>'User not found.'],404);
  		}
      $payments = $user->payments()->get();
      return response()->json(['code'=>200,'data'=>$payments], 200);
    } catch (Exception $e) {
        return response()->json(['code'=>500,'messages'=>'Internal Server Error'],500);
    }
  }

  /**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */

	public function store(Request $request, $idUser){
    $rules = [
      'amount'  => 'required'
    ];

		try {
      $user = User::find($idUser);
      if (!$user){
        return response()->json(['code'=>404,'messages'=>'User not found.'],404);
  		}

      $validator = Validator::make($request->all(), $rules);
  		if ($validator->fails()) {
        return response()->json(['code'=>422,
            'messages'  => $validator->errors()->all()],422);
      }
      if (!$request->input('amount') > 0){
        return response()->json(['code'=>422,
            'messages'  => 'Amount field should be greater than 0'],422);
  		}
      $payment = new Payment;
      $payment->amount = $request->input('amount');
      $payment->user_id = $user->id;
      $payment->save();
      //$newUser = User::create($request->all());
      //$response = Response::make(json_encode(['code'=>201,'data'=>$newUser]), 201);
      return $user->payments()->get();
    } catch (Exception $e) {
        return response()->json(['code'=>500,'messages'=>'Internal Server Error'],500);
    }
  }

  /**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $idUser, $idPayment){
    $rules = [
      'amount'  => 'required',
    ];
    try {
      $user = User::find($idUser);
      if (!$user){
        return response()->json(['code'=>404,'messages'=>'User not found.'],404);
  		}
      $payment = $user->payments()->find($idPayment);
      if (!$payment){
        return response()->json(['code'=>404,'messages'=>'Payment not found.'],404);
  		}

      $amount = $request->input('amount');

      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
        return response()->json(['code'=>422,
            'messages'  => $validator->errors()->all()],422);
      }
      if (!$amount > 0){
        return response()->json(['code'=>422,
            'messages'  => 'amount field must be greater than 0'],422);
      }
      if($amount){
        $payment->amount = $amount;
      }
      $payment->save();
      return response()->json(['code'=>200,'data'=>$payment],200);
      } catch (Exception $e) {
        return response()->json(['code'=>500,'messages'=>'Internal Server Error'],500);
    }
  }

  /**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($idUser, $idPayment){
    try {
      $user = User::find($idUser);
      if (!$user){
        return response()->json(['code'=>404,'messages'=>'User not found.'],404);
  		}

      $payment = $user->payments()->find($idPayment);
      if (!$user){
        return response()->json(['code'=>404,'messages'=>'Payment not found.'],404);
  		}

      $payment->delete();
  		return response()->json(['code'=>204,'message'=>'user payment deleted'],204);
    } catch (Exception $e) {
        return response()->json(['code'=>500,'messages'=>'Internal Server Error'],500);
    }
	}
}
