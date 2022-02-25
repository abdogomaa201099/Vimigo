<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['middleware'=>'auth:api', 'middleware'=>'client_credentials'], function(){
    Route::apiResource('user', 'App\Http\Controllers\RESTAPI\UserResource'); 
});


Route::post('InsertUpdateFromCsv', [App\Http\Controllers\CSVController::class, 'InsertUpdateFromCsv']);

Route::post('DeleteBycsvfile', [App\Http\Controllers\CSVController::class, 'DeleteBycsvfile']);