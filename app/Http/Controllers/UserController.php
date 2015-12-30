<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Model
use App\User;

use Response;

class UserController extends Controller
{
  /**
 * Display a listing of the resource.
 *
 * @return Response
 */
  public function index(){
    return response()->json(['status'=>'ok','data'=>User::all()], 200);
  }

  /**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user=User::find($id);

		// Si no existe ese fabricante devolvemos un error.
		if (!$user){
			return response()->json(['errors'=>array(['code'=>404,'message'=>'User not found.'])],404);
		}
		return response()->json(['status'=>'ok','data'=>$user],200);

	}

  /**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */

	public function store(Request $request)
	{
    if (!$request->input('username') || !$request->input('password')){
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Missing fields.'])],422);
		}
		$newUser = User::create($request->all());
		$response = Response::make(json_encode(['data'=>$newUser]), 201);
		return $response;
	}
}
