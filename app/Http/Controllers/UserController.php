<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function getUserData(Request $request)
  {
    try
    {
      $data = DB::select("[spVIDM_SelectUser] 'administrator','Administrator'");
      $res['success'] = true;
      $res['result'] = $data;

      return response($res);
    }
    catch(QueryException $ex)
    {
      $res['success'] = false;
      $res['result'] = 'Query Exception.. Please Check Database!';

      return response($res);
    }
  }

  public function getUser()
  {
    return "user";
  }

  public function getUserToken(Request $request)
  {
    $username = $request->username;

    try
    {
      $data = DB::select("[spVIDM_SelectUserToken] '$username'");

      $data = json_encode($data);
			$data = json_decode($data, true);

      $user_data['user_id'] = $data[0]['user_id'];
      $user_data['username'] = $data[0]['username'];
      $user_data['api_token'] = $data[0]['api_token'];
      $user_data['result'] = $data[0]['RESULT'];

      $res['success'] = true;
      $res['result'] = $user_data['result'];
      $res['data'] = $user_data;

      return response($res);
    }
    catch (QueryException $ex)
    {
      $res['success'] = false;
      $res['result'] = 'Query Exception.. Please Check Database!';

      return response($res);
    }

  }
}
