<?php

namespace App\Http\Controllers\login;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Session;
use Exception;

class loginController extends Controller
{
   	public function __construct(Request $request){

    }

    public function login(Request $request) {

      $username = $request->username;
  		$password = $request->password;

		try{
			$data = DB::select("[spVIDM_login] '$username', '$password'");

			$data = json_encode($data);
			$data = json_decode($data, true);

			if( count($data) == 1 ){

				$api_token = sha1(date('YmdHis').$username.explode('.',microtime(true))[1]);

				session(['username' => $username], ['token' => $api_token]);
				$set_token = DB::statement("[spVIDM_setAPIToken] '$username', '$api_token' ");

        $addData = DB::statement("[spVIDM_getMerchBranchData] '$username'");
        $merchant = $addData[0]['merch_id'];
         $branch = $addData[0]['branch_code'];
        // //session(['merchant' => $merchant], ['branch' => $branch]);
        $summary = DB::statement("[spVIDM_MonitoringSum] '7','$merchant','$branch'");

				$user_data['name'] = $data[0]['name'];
				$user_data['username'] = $data[0]['username'];
				$user_data['group_id'] = $data[0]['GROUPID'];
				$user_data['token'] = $api_token;
        $user_data['total_edc'] = $summary[0]['Total EDC'];
        $user_data['total_active'] = $summary[0]['Total Active'];
         $user_data['total_non_active'] = $summary[0]['Total Non Active'];
         $user_data['total_active_transaction'] = $summary[0]['Total Active Transaction'];

				$res['success'] = true;
				$res['result'] = 'Login Success !';
				$res['data'] = $user_data;

			} else {
				$res['success'] = false;
				$res['result'] = 'Wrong username or password !';
			}

			return response($res);
		} catch(QueryException $ex){
			$res['success'] = 'error';
			$res['result'] = 'Query Exception.. Please Check Database!';

			return response($res);
		}

	}

	public function logout(Request $request, $username) {
		session()->flush();
		$set_token = DB::statement(" [spVIDM_setAPIToken] '$username', '' ");

		$res['success'] = true;
		$res['result'] = 'Logout success';

		return $res;
	}

}
