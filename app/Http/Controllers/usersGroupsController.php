<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class usersGroupsController extends Controller
{
  public function addUsers(Request $request)
  {
    try
    {
      $corporateName = $request->corporateName;
      $file = $request->file;
      //$date = $request->date;

      $data = DB::statement("[spVIDM_InsertNewCorporate] '$corporateName', '$file' ");

      $res['success'] = true;
      $res['result'] = "Add Corporate Success";

      return response($res);
    }
    catch(QueryException $ex)
    {
      $res['success'] = false;
      $res['result'] = 'Add Corporate Failed';

      return response($res);
    }
  }

  public function updateUsers(Request $request)
  {
    try
    {
      $corporateId = $request->corporateId;
      $corporateName = $request->corporateName;
      $file = $request->file;
      //$date = $request->date;

      $data = DB::statement("[spVIDM_UpdateNewCorporate] '$corporateId', '$corporateName', '$file' ");

      $res['success'] = true;
      $res['result'] = "Update Corporate Success";

      return response($res);
    }
    catch(QueryException $ex)
    {
      $res['success'] = false;
      $res['result'] = 'Update Corporate Failed';

      return response($res);
    }
  }

  public function deleteUsers(Request $request)
  {
    try
    {
      $corporateIdDel = $request->corporateIdDel;

      $data = DB::statement("[spVIDM_DeleteNewCorporate] '$corporateIdDel' ");

      $res['success'] = true;
      $res['result'] = "Delete Corporate Success";

      return response($res);
    }
    catch(QueryException $ex)
    {
      $res['success'] = false;
      $res['result'] = 'Delete Corporate Failed';

      return response($res);
    }
  }

  public function addGroups(Request $request)
  {
    try
    {
      $corporateId = $request->corporateId;
      $merchName = $request->merchName;
      $file = $request->file;
      //$date = $request->date;

      $data = DB::statement("[spVIDM_InsertNewMerchant] '$corporateId', '$merchName','$file' ");

      $res['success'] = true;
      $res['result'] = "Add Merchant Success";

      return response($res);
    }
    catch(QueryException $ex)
    {
      $res['success'] = false;
      $res['result'] = 'Add Merchant Failed';

      return response($res);
    }
  }

  public function updateGroups(Request $request)
  {
    try
    {
      $merchId = $request->merchId;
      $corporateId = $request->corporateId;
      $merchName = $request->merchName;
      $file = $request->file;
      //$date = $request->date;

      $data = DB::statement("[spVIDM_UpdateMerchant] '$merchId', '$corporateId', '$merchName', '$file' ");

      $res['success'] = true;
      $res['result'] = "Update Merchant Success";

      return response($res);
    }
    catch(QueryException $ex)
    {
      $res['success'] = false;
      $res['result'] = 'Update Merchant Failed';

      return response($res);
    }
  }

  public function deleteGroups(Request $request)
  {
    try
    {
      $merchantIdDel = $request->merchantIdDel;

      $data = DB::statement("[spVIDM_DeleteMerchant] '$merchantIdDel' ");

      $res['success'] = true;
      $res['result'] = "Delete Merchant Success";

      return response($res);
    }
    catch(QueryException $ex)
    {
      $res['success'] = false;
      $res['result'] = 'Delete Merchant Failed';

      return response($res);
    }
  }
}
