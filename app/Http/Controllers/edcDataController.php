<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Session;
use Exception;

class edcDataController extends Controller
{
  public function __construct(Request $request){

  }

  public function checkSN(Request $request)
  {
    try
    {
      $username = $request->username;

      $data = DB::select("[spVIDM_selectSN_EDC] '$username' ");

      $data = json_encode($data);
      $data = json_decode($data, true);

      if( count($data) > 0)
      {
        $username = 'exist';
      }
      else
      {
        $username = 'not';
      }

      $res['success'] = true;
      $res['total'] = count($data);
      $res['result'] = $data;
      $res['status'] = $username;


      return response($res);
    }
    catch(QueryException $ex)
    {
      $res['success'] = false;
      $res['result'] = 'Query Exception.. Please Check Database!';

      return response($res);
    }
  }

  public function getSN(Request $request)
  {
    try
    {
      $username = $request->username;

      $data = DB::select("[spVIDM_selectSN_Merchant] '$username' ");

      $data = json_encode($data);
      $data = json_decode($data, true);


      $res['success'] = true;
      $res['total'] = count($data);
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

  public function deleteSN(Request $request)
  {
    try
    {
      $username = $request->username;

      $data = DB::statement("[spVIDM_deleteSN_EDC] '$username' ");

      if($data)
      {
        $result = 'sukses';
      }
      else
      {
        $result = 'gagal';
      }

      $res['success'] = true;
      $res['status'] = $result;

      return response($res);
    }
    catch(QueryException $ex)
    {
      $res['success'] = false;
      $res['result'] = 'Query Exception.. Please Check Database!';

      return response($res);
    }
  }
}
