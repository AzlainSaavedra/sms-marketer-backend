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

Route::group(['prefix' => 'api-v1'], function () {
    Route::options('/rule','RuleController@options');
//    Route::post("/login", 'jwtLoginController@login');
//    Route::post("/userAuth", 'jwtLoginController@getUser');
//    Route::post("/tokenValidate", 'jwtLoginController@index');
//    Route::post("/register", 'jwtLoginController@register');
//    Route::put("/resetPassword", 'jwtLoginController@resetPassword');
//    Route::put("/passwordChange", 'jwtLoginController@passwordChange');
//    //Route::post("/user", 'UserController@index');
//    Route::get('/getUsers','UserController@getUsers' );
//
//    Route::resource('user', 'UserController');
//    Route::resource('client', 'ClientController');
   Route::resource('rule', 'RuleController');


});

//Route::get('send','MailController@send' );
//Route::get('sendmail','TestController@index' );


Route::resource('carros', 'carrosAPIController');