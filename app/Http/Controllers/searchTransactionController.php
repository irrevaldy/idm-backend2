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
		
		try{
			
			$corporate = $request->corporate;
			$merchant = $request->merchant;
			$branc_code = $request->branc_code;
			$store_code = $request->store_code;
			$host = $request->host;
			$transaction_type = $request->transaction_type;
			$prepaid_card_number = $request->prepaid_card_number;
			$approval_code = $request->approval_code;
			$mid = $request->mid;
			$tid = $request->tid; 
			$transaction_date = $request->transaction_date;
			
			$data = DB::select("[spDWH_searchTransaction] '$corporate', '$merchant', '$branc_code', '$store_code',
															'$host', '$transaction_type', '$prepaid_card_number', '$approval_code', 
															'$mid', '$tid', '$transaction_date' ");
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
