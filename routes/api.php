<?php

use App\Http\Controllers\UserController;
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


Route::get('/', function () {
    return 'Hello World';
});
Route::resources([
    'users' => UserController::class,
]);
Route::get('users/upload-file', 'App\Http\Controllers\UserController@export')->name('users.export');
Route::post('users/download-file', 'App\Http\Controllers\UserController@import')->name('users.import');
