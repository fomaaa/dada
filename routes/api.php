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
Route::middleware('api')->get('/{lang}/team', 'AppController@team');
Route::middleware('api')->get('/{lang}/{tag}/works/{date?}', 'AppController@latestWorksWithTag');
Route::middleware('api')->get('/{lang}/{case}/{tag?}', 'AppController@caseContent');

//Route::middleware('api')->get('/{lang}/works/{date?}', 'AppController@latestWorks');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


