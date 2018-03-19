<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class edcDataController extends Controller
{
  public function __construct(Request $request){

  }

  public function checkSN(Request $request)
  {
    try
    {
      $username = $request->username;

      $data = DB::select("[spVIDM_selectSN_EDC] '$username' ");

      $data = json_encode($data);
      $data = json_decode($data, true);

      if( count($data) > 0)
      {
        $username = 'exist';
      }
      else
      {
        $username = 'not';
      }

      $res['success'] = true;
      $res['total'] = count($data);
      $res['result'] = $data;
      $res['status'] = $username;


      return response($res);
    }
    catch(QueryException $ex)
    {
      $res['success'] = false;
      $res['result'] = 'Query Exception.. Please Check Database!';

      return response($res);
    }
  }

  public function getSN(Request $request)
  {
    try
    {
      $username = $request->username;

      $data = DB::select("[spVIDM_selectSN_Merchant] '$username' ");

      $data = json_encode($data);
      $data = json_decode($data, true);


      $res['success'] = true;
      $res['total'] = count($data);
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

  public function deleteSN(Request $request)
  {
    try
    {
      $username = $request->username;

      $data = DB::statement("[spVIDM_deleteSN_EDC] '$username' ");

      if($data)
      {
        $result = 'sukses';
      }
      else
      {
        $result = 'gagal';
      }

      $res['success'] = true;
      $res['status'] = $result;

      return response($res);
    }
    catch(QueryException $ex)
    {
      $res['success'] = false;
      $res['result'] = 'Query Exception.. Please Check Database!';

      return response($res);
    }
  }

  public function uploadEdc(Request $request)
  {
    try
    {
      $corporate = $request->corporate;
      $merchant = $request->merchant;
      $storage_path = $request->storage_path;

      /*
      $data = DB::statement("[spVIDM_deleteSN_EDC] '$username' ");

      if($data)
      {
        $result = 'sukses';
      }
      else

      */

      $objPHPSpreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($storage_path);
      $worksheet = $objPHPSpreadsheet->setActiveSheetIndex(0);
      $worksheetTitle     = $worksheet->getTitle();
      $highestRow         = $worksheet->getHighestRow(); // e.g. 10
      $highestRow_count = $highestRow -1;
      $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
      $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
      $nrColumns = ord($highestColumn) - 64;

      $midList = array("Serial Number", "TID MDR REGULER", "MID MDR REGULER", "TID MDR POWERBUY 3", "MID MDR POWERBUY 3", "TID MDR POWERBUY 6", "MID MDR POWERBUY 6", "TID MDR POWERBUY 12", "MID MDR POWERBUY 12", "TID MDR PREPAID", "MID MDR PREPAID", "TID BNI", "MID BNI", "TID BRI", "MID BRI", "TID TCASH", "MID TCASH", "TID CIMB", "MID CIMB"); //label for view

      $data = array("corporate"=>"$corporate",
                    "merchant"=>"$merchant",
                    "highestRow_count" => $highestRow_count,
                  "storage_path" => $storage_path);

      $headerExcel = array();
      $headerExcel2 = array();
      $indexExcel = array();
      $indexExcel2 = array();
      $bodyExcel = array();
      $bodyExcel2 = array();


      //header row
      $row = 1;
      $col = 0;

      for ($col = 0; $col <= $highestColumnIndex; ++ $col) {
        $cell = $worksheet->getCellByColumnAndRow($col, $row);
        $val = $cell->getValue();
        $headerExcel[] = $val;
      }

      foreach ($midList as $key => $value) {
        if(in_array($value, $headerExcel)) {
          $x = array_search($value, $headerExcel);
          if($x == 0)
          {
            $x = 26;
          }
          $indexExcel[] = $x;
        }
      }

      $row = 1;
      $col = 0;

      $cell = $worksheet->getCellByColumnAndRow($col, $row);
      $sn = $cell->getValue();

      //$cell = $worksheet->getCellByColumnAndRow($col, $row);
      //$sn = $cell->getValue();
      //$dataType = \PhpOffice\PhpSpreadsheet\Cell_DataType::dataTypeForValue($sn);

      foreach ($indexExcel as $key => $value) {
        $cell = $worksheet->getCellByColumnAndRow($value, $row);
        $header = $cell->getValue();
        //$dataType = \PhpOffice\PhpSpreadsheet\Cell_DataType::dataTypeForValue($header);
        $headerExcel2[] = $header;
      }

      $maxCol = count($indexExcel) + 1;

      //body row
      for ($row = 2; $row <= $highestRow; ++ $row) {
        $col = 0;
        $array = array();

        $cell = $worksheet->getCellByColumnAndRow($indexExcel[0], $row);
        $sn = $cell->getValue();

        $datas = DB::select("[spVIDM_selectSN_EDC] '$sn' ");

        $datas = json_encode($datas);
        $datas = json_decode($datas, true);

        if($sn == NULL || $sn == '')
        {
          $sn_status = 'SN is empty. Broken Data.';
        }
        elseif(count($datas) > 0)
        {
          $sn_status = 'SN has been registered';
        }
        else
        {
          $sn_status = 'OK';
        }

        foreach ($indexExcel as $key => $value) {
          $cell = $worksheet->getCellByColumnAndRow($value, $row);
          $mid = $cell->getValue();
          if($mid == null)
          {
            $mid = '';
          }
          //$dataType = PHPExcel_Cell_DataType::dataTypeForValue($mid);
          $array[$value] = $mid;
          $array['status'] = $sn_status;
          //array_push($array , "status" => $sn);
        }

      $bodyExcel[] = $array;
    }

      $res['success'] = true;
      $res['result'] = $data;
      $res['header'] = $headerExcel;
      $res['header2'] = $headerExcel2;
      //$res['index'] = $indexExcel;
      $res['body'] = $bodyExcel;

      return response($res);
    }
    catch(QueryException $ex)
    {
      $res['success'] = false;
      $res['result'] = 'Query Exception.. Please Check Database!';

      return response($res);
    }
  }
}
