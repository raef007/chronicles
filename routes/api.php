<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('{user}/trades','\App\Trade\Controllers\EntryApiController@index')->name('trade.entries');
Route::post('{user}/trades','\App\Trade\Controllers\EntryApiController@store')->name('trade.store');
Route::put('{user}/trades/{trade}','\App\Trade\Controllers\EntryApiController@update')->name('trade.update');

Route::get('{user}/capitals','\App\Capital\Controllers\EntryApiController@index')->name('capital.entries');
Route::get('{user}/pnl-summary','\App\User\Controllers\UserApiController@getPnlSummary')->name('pnl.summary');

Route::group(['middleware' => 'auth:api'], function () {
    
});