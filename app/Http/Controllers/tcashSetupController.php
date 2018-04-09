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

class tcashSetupController extends Controller
{
  public function __construct(Request $request){

  }

  public function setTcashLimit(Request $request) {

    try{

      $storeCode = $request->storeCode;
      $currLimit = $request->currLimit;
      $newLimit = $request->newLimit;

      $data = DB::statement("[spVIDM_setTcashLimit] '$storeCode', '$currLimit', '$newLimit' ");

      $res['success'] = true;
      $res['result'] = "Sukses";

      return response($res);
    } catch(QueryException $ex){
      $res['success'] = false;
      $res['result'] = 'Query Exception.. Please Check Database!';

      return response($res);
    }

  }

  public function checkLimit(Request $request)
  {
    try
    {
      $storeCode = $request->storeCode;
      $branchCode = $request->branchCode;
      $merch_id = $request->merch_id;

      $data = DB::select("[spVIDM_checkLimit] '$storeCode', '$branchCode','$merch_id'");

      $data = json_encode($data);
      $data = json_decode($data, true);

      $limit = $data[0]['FTCASHTOPUPLIMIT'];

      if($limit == '')
      {
        $limit = 0;

        $res['success'] = true;
        $res['status'] = "not found";
        $res['limit'] = $limit;
      }
      else
      {
        $res['success'] = true;
        $res['status'] = "found";
        $res['limit'] = $limit;
      }

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
