<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class corporateMerchantController extends Controller
{
  public function addCorporate(Request $request)
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

  public function updateCorporate(Request $request)
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

  public function deleteCorporate(Request $request)
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
}
