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

    public function getBranchData(Request $request)
    {
      $merch_id = $request->merch_id;

  		try
      {
  			$data = DB::select("[spVIDM_getBranchData] '$merch_id' ");
  			$res['success'] = true;
  			$res['result'] = $data;

  			return response($res);
  		}
      catch(QueryException $ex)
      {
  			$res['success'] = false;
  			$res['result'] = 'Query Exception.. Please Check Database!';

  			return response($res);
  		}
	}

  public function getHostData(Request $request)
    {
      $merch_id = $request->merch_id;

  		try
      {
  			$data = DB::select("[spVIDM_getHostData] '$merch_id' ");
  			$res['success'] = true;
  			$res['result'] = $data;

  			return response($res);
  		}
      catch(QueryException $ex)
      {
  			$res['success'] = false;
  			$res['result'] = 'Query Exception.. Please Check Database!';

  			return response($res);
  		}
	}

	public function getCorporateData(Request $request) {

		try{
			$data = DB::select("[spVIDM_getCorporateData]");
			$res['success'] = true;
			$res['result'] = $data;

			return response($res);
		} catch(QueryException $ex){
			$res['success'] = false;
			$res['result'] = 'Query Exception.. Please Check Database!';

			return response($res);
		}

	}

  public function getMerchantData(Request $request) {

		try{
			$data = DB::select("[spVIDM_getMerchantData]");
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

  public function getUsersData(Request $request) {

    $FCODE = $request->FCODE;
    $user_id = $request->user_id;

		try{
			$data = DB::select("[spVIDM_ViewUser] '$FCODE','$user_id'");

      $data = json_encode($data);
      $data = json_decode($data, true);

      $total = count($data);

      for($i = 0; $i < $total; $i++)
      {
        $user_data['FID'] = $data[$i]['FID'];
        $user_data['merch_id'] = $data[$i]['merch_id'];
        $merchid = $user_data['merch_id'];

        if($user_data['FID'] == '99')
        {
          $merchant_call = DB::select("[spVIDM_GetMerchant] '$merchid'");

          $merchant_call = json_encode($merchant_call);
          $merchant_call = json_decode($merchant_call, true);

          $data[$i]['FNAME'] = $merchant_call[0]['FMERCHNAME'];
        }
        else if($user_data['FID'] == '1909')
        {
          $data[$i]['FNAME'] = 'Wirecard';
        }

      }

			$res['success'] = true;
			$res['result'] = $data;

			return response($res);
      //return Response::json($res);
		} catch(QueryException $ex){
			$res['success'] = false;
			$res['result'] = 'Query Exception.. Please Check Database!';

			return response($res);
		}

	}

  public function getGroupsData(Request $request)
  {

    $FCODE = $request->FCODE;
    $group_id = $request->group_id;

    try{
      $data = DB::select("[spVIDM_ViewGroup] '$FCODE','$group_id'");
      $data = json_encode($data);
      $data = json_decode($data, true);

      $total = count($data);

      for($i = 0; $i < $total; $i++)
      {
        $user_data['FID'] = $data[$i]['FID'];
        $user_data['merch_id'] = $data[$i]['merch_id'];
        $merchid = $user_data['merch_id'];
        $fid = $user_data['FID'];

        if($user_data['FID'] != '99' && $user_data['FID'] != '1909')
        {
          $data1 = DB::select("[spVIDM_SelectBackEnd] '$fid'");
          $data1 = json_encode($data1);
          $data1 = json_decode($data1, true);

          $data[$i]['FMERCHNAME'] = $data1[0]['FNAME'];
        }
        else if($user_data['FID'] == '1909')
        {
          $data[$i]['FMERCHNAME'] = 'Wirecard';
        }
        else {
          $merchant_call = DB::select("[spVIDM_GetMerchant] '$merchid'");

          $merchant_call = json_encode($merchant_call);
          $merchant_call = json_decode($merchant_call, true);

          $data[$i]['FMERCHNAME'] = $merchant_call[0]['FMERCHNAME'];
        }

      }

      $res['success'] = true;
      $res['result'] = $data;

      return response($res);
    } catch(QueryException $ex){
      $res['success'] = false;
      $res['result'] = 'Query Exception.. Please Check Database!';

      return response($res);
    }

  }

  public function updatePassword(Request $request)
  {
    date_default_timezone_set('Asia/Jakarta');
    $now = date("Ymdhis");

    $user_id = $request->user_id;
    $name = $request->name;
    $username = $request->username;
    $oldPassword = $request->oldPassword;
    $newPassword = $request->newPassword;
    $note = $request->note;

    try
    {
      if($oldPassword != '')
      {
        $oldPassword = hash('sha256', $oldPassword);
      	$newPassword = hash('sha256',$newPassword);

        $check = DB::select("[spPortal_ViewDetailUser] '$user_id'");

        $check = json_encode($check);
        $check = json_decode($check, true);

        $oldName = $check[0]['name'];
        $oldPassword2 = $check[0]['password'];
        if($name != $oldName)
        {
          $desc = "Change name, change password";
        }
        else
        {
          $desc = "Change password";
        }
        if ($oldPassword != $oldPassword2)
        {
          $res['status'] = '#ERROR';
          $res['message'] = 'Update Profile Failed';
        }
        else
        {
          $data = DB::statement("[spPortal_UpdateProfile] '$user_id', '$username', '$newPassword', '$name', '$note'");
          if ($data)
          {
            Session::put('name', $name);

            $audit_trail = DB::statement("[spPortal_InsertAuditTrail] '5', '$user_id', '$username', '$name', $now, '$desc'");

            $res['status'] = '#SUCCESS';
            $res['message'] = 'Update Profile Success';
          }
          else
          {
            $res['status'] = '#ERROR';
            $res['message'] = 'Update Profile Failed';
          }
        }
      }
      else
      {
      	$check = DB::select("[spPortal_ViewDetailUser] '$user_id'");

        $check = json_encode($check);
        $check = json_decode($check, true);

        $oldName = $check[0]['name'];
        $oldPassword2 = $check[0]['password'];
        if($name != $oldName) {
      		$desc = "Change name";
      	}

        $data = DB::statement("[spPortal_UpdateProfile] '$user_id', '$username', '$oldPassword', '$name', '$note'");

      	if ($data)
        {
      		Session::put('name', $name);

          $audit_trail = DB::statement("[spPortal_InsertAuditTrail] '5', '$user_id', '$username', '$name', $now, '$desc'");

          $res['status'] = '#SUCCESS';
          $res['message'] = 'Update Profile Success';
      	}
        else
        {
          $res['status'] = '#ERROR';
          $res['message'] = 'Update Profile Failed';
      	}
      }
      return response($res);
    }
    catch(QueryException $ex)
    {
      $res['success'] = '#ERROR';
      $res['result'] = 'Query Exception.. Please Check Database!';

      return response($res);
    }
  }
}
