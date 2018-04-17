<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class chartController extends Controller
{
  public function __construct(Request $request)
  {

  }

  public function barChart(Request $request)
  {
    try
    {
      $devlist = DB::table('TEDC_MERCHANT')
           ->select(DB::raw('FMERCH_ID'), DB::raw("count(FMERCH_ID) as total"))
           ->groupBy('FMERCH_ID')
           ->get();

      // $summary = json_encode($summary);
      // $summary = json_decode($summary, true);
      //
			// $res['success'] = true;
			// $res['data'] = $summary;

			return response($devlist);
		}
    catch(QueryException $ex){
			$res['success'] = 'error';
			$res['result'] = 'Query Exception.. Please Check Database!';

			return response($res);
		}
  }

}
