<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class TestController extends Controller
{
  public function getUserData(Request $request) {

    try{
      $data = DB::select("[spVIDM_SelectUser] 'administrator','Administrator'");
      $res['success'] = true;
      $res['result'] = $data;

      return response($res);
    } catch(QueryException $ex){
      $res['success'] = false;
      $res['result'] = 'Query Exception.. Please Check Database!';

      return response($res);
    }

  }

  public function getUser()
  {
    return "user";
  }
}
