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

class UserFavoritesController extends Controller
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
      $favorites = $user->favorites()->get();
      return response()->json(['code'=>200,'data'=>$favorites], 200);
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
        'favorite_user_id'  => 'required|integer'
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
        $favUser = User::find($request->input('favorite_user_id'));
        if (!$favUser){
          return response()->json(['code'=>404,'messages'=>'User not found.'],404);
    		}
        $user->favorites()->attach($favUser->id);
        return $user->favorites()->get();
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
  	public function destroy($idUser, $idFavorite){
      try {
        $user = User::find($idUser);
        if (!$user){
          return response()->json(['code'=>404,'messages'=>'User not found.'],404);
    		}

        $favUser = User::find($idFavorite);
        if (!$favUser){
          return response()->json(['code'=>404,'messages'=>'User not found.'],404);
    		}

        $user->favorites()->detach($favUser->id);
    		return response()->json(['code'=>204,'message'=>'user payment deleted'],204);
      } catch (Exception $e) {
          return response()->json(['code'=>500,'messages'=>'Internal Server Error'],500);
      }
  	}
}
