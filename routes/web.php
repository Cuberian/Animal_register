<?php

use App\Http\Controllers\CardController;
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


Route::group(['prefix' => 'register','as' => 'card.'], function () {
    Route::get('/', [CardController::class, 'index']);
    Route::resource('card', 'CardController', ['names' => [
        'create' => 'card.add',
        'edit' => 'card.edit'
    ]]);
});
