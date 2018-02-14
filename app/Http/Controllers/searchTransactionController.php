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

class searchTransactionController extends Controller
{
   	public function __construct(Request $request){

    }

    public function search(Request $request) {

      $storeCode = $request->store_code;
      $branchCode = $request->branch_code;
      $bankCode = $request->host;
      $trxType = $request->transaction_type;
      $prepaidCardNum = $request->prepaid_card_number;
      $apprCode = $request->approval_code;
      $mid = $request->mid;
      $tid = $request->tid;
      $transaction_date = $request->transaction_date;
      $startDate = $transaction_date;
      $endDate = $transaction_date;

		try{

			//$corporate = $request->corporate;
			//$merchant = $request->merchant;

			$data = DB::select("[spVIDM_FilterTrx2] '$storeCode','$branchCode','$bankCode','$trxType','$prepaidCardNum','$apprCode','$mid','$tid','$startDate','$endDate'");

      $data = json_encode($data);
      $data = json_decode($data, true);

        $res['success'] = true;
        $res['total'] = count($data);
        $res['result'] = $data;

			return response($res);
		} catch(QueryException $ex){
			$res['success'] = false;
			$res['result'] = 'Query Exception.. Please Check Database!';

			return response($res);
		}

	}

}
