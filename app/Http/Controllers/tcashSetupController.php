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
}
