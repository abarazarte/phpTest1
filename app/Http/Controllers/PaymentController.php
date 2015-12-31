<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Model
use App\Payment;

use Response;

class PaymentController extends Controller
{
  /**
 * Display a listing of the resource.
 *
 * @return Response
 */
  public function index(){
    try {
      $payments = Payment::all();
      return response()->json(['code'=>200,'data'=>$payments], 200);
    } catch (Exception $e) {
        return response()->json(['code'=>500,'messages'=>'Internal Server Error'],500);
    }
  }

  /**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id){
		try {
      $payment = Payment::find($id);
      if (!$payment){
        return response()->json(['code'=>404,'messages'=>'Payment not found.'],404);
  		}
  		return response()->json(['code'=>200,'data'=>$payment],200);
    } catch (Exception $e) {
        return response()->json(['code'=>500,'messages'=>'Internal Server Error'],500);
    }
	}
}
