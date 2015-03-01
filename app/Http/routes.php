<?php

use Illuminate\Support\Facades\Route;
/*
 * |--------------------------------------------------------------------------
 * | Application Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register all of the routes for an application.
 * | It's a breeze. Simply tell Laravel the URIs it should respond to
 * | and give it the controller to call when that URI is requested.
 * |
 */
Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController'
]);

Route::get('/req', 'req@index');
//Route::get('/pic', 'pic@index');
Route::group(['middleware' => 'pixauth'], function (){
	Route::get('/minpic', 'minpic@index');
	Route::get('/download', 'download@index');
	Route::get('/picadmin', 'picadmin@index');
	Route::get('/request', 'pixrequest@index');
	Route::get('/requestdel', 'pixrequest@delete');
});
Route::get('/entrance', 'entrance@index');
Route::post('/login', 'login@index');
