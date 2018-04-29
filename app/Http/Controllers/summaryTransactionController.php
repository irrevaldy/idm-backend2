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

class summaryTransactionController extends Controller
{
   	public function __construct(Request $request){
        
    }
	
    public function summaryTransaction(Request $request) {
		
		try{
			
			$host = $request->host;
			$card_type = $request->card_type;
			$transaction_type = $request->transaction_type;
			$corporate = $request->corporate;
			$merchant = $request->merchant;
			$status = $request->status;
			$transaction_month = $request->transaction_month;
			$response_code = $request->response_code;	
			
			$data = DB::select("[spDWH_summaryTransactionData] '$host', '$card_type', '$transaction_type', '$corporate',
															'$merchant', '$status', '$transaction_month', '$response_code' ");
															
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
	
	public function summaryResponseCode(Request $request) {
		
		try{
			
			$host = $request->host;
			$transaction_type = $request->transaction_type;
			$corporate = $request->corporate;
			$merchant = $request->merchant;
			$transaction_month = $request->transaction_month;
			
			$data = DB::select("[spDWH_summaryResponseCodeData] '$host', '$transaction_type', '$corporate',
															'$merchant', '$transaction_month' ");
															
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
