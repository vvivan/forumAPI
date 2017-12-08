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

Route::post('/register', 'RegisterController@register');

Route::group(['prefix' => 'topics'], function(){

    Route::get('/', 'TopicController@index');
    Route::get('/{topic}', 'TopicController@show');
    Route::middleware('auth:api')->post('/', 'TopicController@store');
    Route::middleware('auth:api')->patch('/{topic}', 'TopicController@update');
    Route::middleware('auth:api')->delete('/{topic}', 'TopicController@destroy');

    Route::group(['prefix' => '/{topic}/posts'], function() {
       Route::middleware('auth:api')->post('/', 'PostController@store');
       Route::middleware('auth:api')->patch('/{post}', 'PostController@update');
       Route::middleware('auth:api')->delete('/{post}', 'PostController@destroy');

       Route::group(['prefix' => '/{post}/likes'], function(){
           Route::middleware('auth:api')->post('/', 'PostLikeController@store');
       });
    });

});

