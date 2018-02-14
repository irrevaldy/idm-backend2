<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Login & logout */
Route::post('/login', ['uses' => 'login\loginController@login']);
//Route::get('/login', ['uses' => 'login\loginController@login']);
Route::post('/logout/{username}', ['uses' => 'login\loginController@logout']);
//Route::get('/logout/{username}', ['uses' => 'login\loginController@logout']);
//getAPItoken
Route::get('/user/{username}', ['uses' => 'UserController@getUserToken']);

/* Global function */
Route::get('/host_data', ['uses' => 'globalController@getHostData']);
Route::get('/corporate_data', ['uses' => 'globalController@getCorporateData']);
Route::get('/merchant_data/{corporate_id}', ['uses' => 'globalController@getMerchantData']);
Route::get('/card_data', ['uses' => 'globalController@getCardData']);

/* Search transaction */
Route::post('/search_transaction', ['uses' => 'searchTransactionController@search']);

/* Summary transaction */
Route::post('/summary_transaction', ['uses' => 'summaryTransactionController@summaryTransaction']);
Route::post('/summary_response_code', ['uses' => 'summaryTransactionController@summaryResponseCode']);

//menu
// Route::get('/menu/main/{groupid}/{token}',['uses' => 'MenuController@getMenuMain']);
// Route::get('/menu/regular/{groupid}/{token}',['uses' => 'MenuController@getMenuRegular']);

//menu
Route::get('/menu/main/{group_id}/{api_token}',['uses' => 'MenuController@getMenuMain']);
Route::get('/menu/regular/{group_id}/{api_token}',['uses' => 'MenuController@getMenuRegular']);
