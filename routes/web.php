<?php

use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function() {
   Route::get('/login',[AuthorizationController::class, 'login']);
   Route::get('/register',[AuthorizationController::class, 'register']);
});


Route::group(['prefix' => 'register','as' => 'card.'], function () {
    Route::get('/', [RegisterController::class, 'PrintRegister']);
    Route::get('/card/show/{id}', [RegisterController::class, 'OpenCard']);
    Route::get('/card/create', [RegisterController::class, 'CreateCard']);
    Route::post('/card/store', [RegisterController::class, 'StoreCard']);
    Route::get('/card/{id}/edit', [RegisterController::class, 'EditCard']);
    Route::put('/card/{id}',[RegisterController::class, 'UpdateCard']);
    Route::delete('/card/{id}',[RegisterController::class, 'DeleteCard']);
});
