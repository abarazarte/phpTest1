<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Model
use App\User;

use Response;
use Validator;

class UserController extends Controller{
  /**
 * Display a listing of the resource.
 *
 * @return Response
 */
  public function index(){
    try {
      $users = User::all();
      return response()->json(['code'=>200,'data'=>$users], 200);
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
      $user=User::find($id);
      if (!$user){
        return response()->json(['code'=>404,'messages'=>'User not found.'],404);
  		}
  		return response()->json(['code'=>200,'data'=>$user],200);
    } catch (Exception $e) {
        return response()->json(['code'=>500,'messages'=>'Internal Server Error'],500);
    }
	}

  /**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */

	public function store(Request $request){
    $rules = [
      'username'  => 'required|unique:users',
      'password'  => 'required',
      'age' =>  'required|integer'
    ];

		try {
      $validator = Validator::make($request->all(), $rules);
  		if ($validator->fails()) {
        return response()->json(['code'=>422,
            'messages'  => $validator->errors()->all()],422);
      }
      if ($request->input('age') < 18){
        return response()->json(['code'=>422,
            'messages'  => 'Age field must be greater than 18'],422);
  		}
      $newUser = User::create($request->all());
      $response = Response::make(json_encode(['code'=>201,'data'=>$newUser]), 201);
      return $response;
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
	public function update(Request $request, $id){
    $rules = [
      'username'  => 'required',
      'password'  => 'required',
      'age' =>  'required|integer'
    ];
    try {
      $user = User::find($id);
      if (!$user){
        return response()->json(['code'=>404,'messages'=>'User not found.'],404);
  		}

      $username = $request->input('username');
      $password = $request->input('password');
      $age = $request->input('age');

      if($username){
        $user->username = $username;
      }
      if($password){
        $user->password = $password;
      }
      if($age){
        $user->age = (int)$age;
      }

      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
        return response()->json(['code'=>422,
            'messages'  => $validator->errors()->all()],422);
      }
      if ($age < 18){
        return response()->json(['code'=>422,
            'messages'  => 'Age field must be greater than 18'],422);
      }

      $user->save();
      return response()->json(['code'=>200,'data'=>$user],200);
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
	public function destroy($id){
    try {
      $user=User::find($id);
      if (!$user){
        return response()->json(['code'=>404,'messages'=>'User not found.'],404);
  		}
      $user->delete();
  		return response()->json(['code'=>204,'message'=>'User deleted'],204);
    } catch (Exception $e) {
        return response()->json(['code'=>500,'messages'=>'Internal Server Error'],500);
    }
	}
}
