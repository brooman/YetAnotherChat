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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');
Route::post('/login/refresh', 'AuthController@refresh');

Route::post('/channel/create', 'ChatController@store');
Route::post('/message/create', 'MessageController@store');
Route::post('/message/edit', 'MessageController@update');
Route::post('/message/destroy', 'MessageController@destroy');
