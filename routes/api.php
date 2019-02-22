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

Route::post('login', [ 'as' => 'login', 'uses' => 'AuthController@login']);
Route::post('register', 'AuthController@register');
Route::post('/user/unique', 'UserController@isUnique');
Route::get('favourite', 'FavouriteController@index');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('favourite/{image_id}', 'FavouriteController@show');
    Route::post('favourite', 'FavouriteController@store');
    Route::delete('favourite/{image_id}', 'FavouriteController@destroy');

    Route::post('logout', 'AuthController@logout');
    Route::get('user/favourites', 'UserController@favourites');
});