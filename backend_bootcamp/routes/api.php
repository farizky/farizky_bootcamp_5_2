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

Route::group(['prefix' => 'userlist'], function(){
    Route::get('/','UserListController@getData')->middleware('jwt.auth');
    Route::post('/add','UserListController@addData')->middleware('jwt.auth');
    Route::post('/delete','UserListController@deleteData')->middleware('jwt.auth');

    //add, get dan delete butuh middleware(harus pakai token)
});

Route::post('/login', 'AuthenticationController@login');
Route::post('/register', 'AuthenticationController@register');


