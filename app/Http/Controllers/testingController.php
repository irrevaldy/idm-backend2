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

class testingController extends Controller
{
   	public function __construct(Request $request){
        
    }
	
    public function test(Request $request) {
		
		/*
			proses di sini
		*/
		
		$data = array(
			"nama"	=> 'adhly',
			'alamat'	=> 'bekasi'
		);
		
		$res['success'] = true;
		$res['data'] = $data;
		
		return $res;
		
	}
  
}
