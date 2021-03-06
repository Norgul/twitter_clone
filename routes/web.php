<?php

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

Route::get('/', 'UserController@index');

Route::get('search', 'UserController@search');
Route::post('search/tweets', 'UserController@query');
Route::get('search/results', 'UserController@results');

Route::get('{username}', 'UserController@store');
Route::get('user/{user}', 'UserController@show');
