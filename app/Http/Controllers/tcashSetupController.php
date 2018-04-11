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

  public function setTcashLimit(Request $request)
  {
    try
    {
      $storeCode = $request->storeCode;
      $newLimit = $request->newLimit;

<<<<<<< HEAD
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
=======
      $data = DB::statement("[spVIDM_setTcashLimit] '$storeCode', '$newLimit' ");

      $res['success'] = true;
      $res['result'] = "sukses";

      return response($res);
    }
    catch(QueryException $ex)
    {
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

      $data = DB::select("[spVIDM_checkLimit] '$storeCode', '$branchCode', '$merch_id' ");
>>>>>>> ff3643aaf47bc39f323be32b34f0bf94424d52f3

      $data = json_encode($data);
      $data = json_decode($data, true);

      $limit = $data[0]['FTCASHTOPUPLIMIT'];

      if($limit == '')
      {
<<<<<<< HEAD
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

=======
        $limit = '0';

        $limit_data['status'] = "not found";
        $limit_data['limit'] = $limit;
      }
      else
      {
        $limit_data['status'] = "found";
        $limit_data['limit'] = $limit;
      }

      $res['success'] = true;
      $res['result'] = $limit_data;

>>>>>>> ff3643aaf47bc39f323be32b34f0bf94424d52f3
      return response($res);
    }
    catch(QueryException $ex)
    {
      $res['success'] = false;
      $res['result'] = 'Query Exception.. Please Check Database!';

      return response($res);
    }
<<<<<<< HEAD
=======

>>>>>>> ff3643aaf47bc39f323be32b34f0bf94424d52f3
  }
}
