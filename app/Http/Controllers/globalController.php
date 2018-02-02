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

class globalController extends Controller
{
   	public function __construct(Request $request){
        
    }
	
    public function getHostData(Request $request) {
		
		try{
			$data = DB::select("[spDWH_getHostData]");
			$res['success'] = true;
			$res['result'] = $data;
	
			return response($res);
		} catch(QueryException $ex){ 
			$res['success'] = false;
			$res['result'] = 'Query Exception.. Please Check Database!';
	
			return response($res);
		}
		
	}
	
	public function getCorporateData(Request $request) {
		
		try{
			$data = DB::select("[spDWH_getCorporateData]");
			$res['success'] = true;
			$res['result'] = $data;
	
			return response($res);
		} catch(QueryException $ex){ 
			$res['success'] = false;
			$res['result'] = 'Query Exception.. Please Check Database!';
	
			return response($res);
		}
		
	}
	
	public function getMerchantData(Request $request, $corporate_id) {
		
		try{
			$data = DB::select("[spDWH_getMerchantData] '$corporate_id'");
			$res['success'] = true;
			$res['result'] = $data;
	
			return response($res);
		} catch(QueryException $ex){ 
			$res['success'] = false;
			$res['result'] = 'Query Exception.. Please Check Database!';
	
			return response($res);
		}
		
	}
	
	public function getCardData(Request $request) {
		
		try{
			$data = DB::select("[spDWH_getCardData]");
			$res['success'] = true;
			$res['result'] = $data;
	
			return response($res);
		} catch(QueryException $ex){ 
			$res['success'] = false;
			$res['result'] = 'Query Exception.. Please Check Database!';
	
			return response($res);
		}
		
	}
  
}
