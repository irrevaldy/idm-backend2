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

class MenuController extends Controller
{
  public function __construct(Request $request)
  {

  }

  public function getMenuMain()
  {
    try
    {
			$data = DB::select("[spVIDM_SelectGroupMainMenu]");

			$data = json_encode($data);
			$data = json_decode($data, true);

				$user_data['name'] = $data[0]['NAME'];
				$user_data['logo'] = $data[0]['LOGO'];
				$user_data['result'] = $data[0]['RESULT'];

				$res['success'] = true;
				$res['result'] = $user_data['result'];
				$res['data'] = $data;


			return response($res);
		}
    catch(QueryException $ex){
			$res['success'] = 'error';
			$res['result'] = 'Query Exception.. Please Check Database!';

			return response($res);
		}
  }

  public function getMenuRegular()
  {
    try
    {
			$data = DB::select("[spVIDM_SelectGroupRegularMenu]");

			$data = json_encode($data);
			$data = json_decode($data, true);

				$user_data['code'] = $data[0]['CODE'];
				$user_data['name'] = $data[0]['NAME'];
				$user_data['parentid'] = $data[0]['PARENTID'];
				$user_data['parentname'] = $data[0]['PARENTNAME'];
				$user_data['link'] = $data[0]['LINK'];
				$user_data['isview'] = $data[0]['ISVIEW'];
				$user_data['iscreate'] = $data[0]['ISCREATE'];
				$user_data['isupdate'] = $data[0]['ISUPDATE'];
        $user_data['result'] = $data[0]['RESULT'];

				$res['success'] = true;
				$res['result'] = $user_data['result'];
				$res['data'] = $data;


			return response($res);
		}
    catch(QueryException $ex){
			$res['success'] = 'error';
			$res['result'] = 'Query Exception.. Please Check Database!';

			return response($res);
		}
  }



}
