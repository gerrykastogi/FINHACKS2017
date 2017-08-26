<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/bca/createUser', 'UserController@create');
Route::get('/bca/getUser/{id}', 'UserController@getUserById');
Route::post('/bca/addBalance', 'UserController@addBalance');

Route::post('/bca/createGroup', 'GroupController@create');
Route::get('/bca/testGuzzle', 'GroupController@test');

Route::post('/bca/group/create', 'GroupController@create');
Route::post('/bca/group/edit', 'GroupController@edit');
Route::post('/bca/group/addMember', 'GroupController@addMember');
Route::post('/bca/group/removeMember', 'GroupController@removeMember');

Route::post('/bca/event/index', 'EventController@index');
Route::post('/bca/event/create', 'EventController@create');
Route::post('/bca/event/edit', 'EventController@edit');
Route::post('/bca/event/addMember', 'EventController@addMember');
Route::post('/bca/event/removeMember', 'EventController@removeMember');

Route::get('/bca/fire/transfer', 'BcaFireController@doTeleTransfer');
Route::get('/bca/business/getBalance', 'BcaBusinessController@getBalanceInfo');
