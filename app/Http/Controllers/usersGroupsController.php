<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class usersGroupsController extends Controller
{
  public function addUsers(Request $request)
  {
    try
    {
      $name = $request->name;
      $group = $request->group;
      $branch = $request->branch;
      $note = $request->note;
      $username = $request->username;
      $password = $request->password;
      $status = '1';

      $data = DB::statement("[spVIDM_InsertNewUser] '$name', '$group', '$branch', '$note', '$username', '$password'");

      $res['success'] = true;
      $res['result'] = "Add Users Success";

      return response($res);
    }
    catch(QueryException $ex)
    {
      $res['success'] = false;
      $res['result'] = 'Add Users Failed';

      return response($res);
    }
  }

  public function updateUsers(Request $request)
  {
    try
    {
      date_default_timezone_set('Asia/Jakarta');
      $now = date("Ymdhis");

      $user_id = $request->user_id;
      $name = $request->name;
      $group = $request->group;
      $branch = $request->branch;
      $note = $request->note;
      $username = $request->username;
      $newpassword = $request->password;
      $status = $request->status;
      $session_username = $request->session_username;
      $session_name = $request->session_name;
      $session_user_id = $request->session_user_id;

      $check = DB::select("[spPortal_ViewDetailUser] '$user_id' ");

      $check = json_encode($check);
      $check = json_decode($check, true);

      $old_name = $check[0]['name'];
      $old_password = $check[0]['password'];
      $old_group_id = $check[0]['group_id'];
      $old_description = $check[0]['description'];
      $old_FID = $check[0]['FID'];
      $old_status = $check[0]['status'];
      $old_branch_code = $check[0]['branch_code'];

      $desc_at = "";
      if($name != $old_name || $note != $old_description || $newpassword != $old_password || $group != $old_group_id || $branch != $old_branch_code || $status != $old_status) {
          $desc_at = "Change";
      }

      if ($name != $old_name) {
          if($desc_at == "Change") {
              $desc_at .= " name";
          }
      }

      if ($group != $old_group_id) {
          if($desc_at == "Change") {
              $desc_at .= " group";
          } else {
          	$desc_at .= ", group";
          }
      }

      if ($branch != $old_branch_code) {
          if($desc_at == "Change") {
              $desc_at .= " branch code";
          } else {
          	$desc_at .= ", branch code";
          }
      }

      if ($newpassword != $old_password) {
          if($desc_at == "Change") {
              $desc_at .= " password";
          } else {
          	$desc_at .= ", password";
          }
      }

      if ($note != $old_description) {
          if($desc_at == "Change") {
              $desc_at .= " note";
          } else {
          	$desc_at .= ", note";
          }
      }

      if ($status != $old_status) {
          if($desc_at == "Change") {
              $desc_at .= " status";
          } else {
          	$desc_at .= ", status";
          }
      }

      if ($old_password == $newpassword) {
      $newpassword == $old_password;
      }

      $update = DB::statement("[spPortal_updateUser] '$user_id', '$username', '$newpassword', '$name', '$note', '$group', '$branch', '$status'");

      $res['success'] = true;
      $res['result'] = "Update User Success";

      $audit_trail = DB::statement("[spPortal_InsertAuditTrail] '18', '$session_user_id', '$session_username', '$session_name', $now, 'Update user for username : $username. $desc_at'");

      return response($res);
    }
    catch(QueryException $ex)
    {
      $res['success'] = false;
      $res['result'] = 'Update User Failed';

      return response($res);
    }
  }

  public function deleteUsers(Request $request)
  {
    try
    {
      date_default_timezone_set('Asia/Jakarta');
      $now = date("Ymdhis");

      $delete_user_id = $request->delete_user_id;
      $session_username = $request->session_username;
      $session_name = $request->session_name;
      $session_user_id = $request->session_user_id;

      $data = DB::statement("[spPortal_DeleteUser] '$delete_user_id' ");

      $res['success'] = true;
      $res['result'] = "Delete Corporate Success";

      $audit_trail = DB::statement("[spPortal_InsertAuditTrail] '19', '$session_user_id', '$session_username', '$session_name', $now, 'Delete user, username : $delete_user_id'");


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
