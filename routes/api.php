<?php

use App\Http\Controllers\api\v1\LoginController;
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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::middleware('auth:api')->get('/get_user', function(Request $request) {
   return $request->user();
});


Route::prefix('/user')->group( function () {
    Route::post('/login',[LoginController::class,'login']);
    Route::post('/register',[LoginController::class,'register']);
    Route::post('/logout',[LoginController::class,'logout'])->middleware('auth:api');
});
