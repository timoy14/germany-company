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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post("register","App\Http\Controllers\Auth\RegisterController@store");
Route::post("invite","App\Http\Controllers\Admin\AdminController@invite")->middleware('auth:api');
Route::put("user","App\Http\Controllers\User\UserController@update")->middleware('auth:api');
Route::post("invitation/{token}","App\Http\Controllers\Admin\AdminController@register_invitee");


