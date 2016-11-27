<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
header('Access-Control-Allow-Origin: *');
Route::group(['prefix' => 'api-v1'], function () {
    Route::options('/login','jwtLoginController@options');
    Route::post("/login", 'jwtLoginController@login');
    Route::post("/userAuth", 'jwtLoginController@getUser');
    Route::post("/tokenValidate", 'jwtLoginController@index');
    Route::post("/register", 'jwtLoginController@register');
    Route::put("/resetPassword", 'jwtLoginController@resetPassword');
    Route::put("/passwordChange", 'jwtLoginController@passwordChange');
    //Route::post("/user", 'UserController@index');
    Route::get('/getUsers','UserController@getUsers' );

    Route::resource('user', 'UserController');
    Route::resource('client', 'ClientController');
    Route::resource('rule', 'RuleController');


});