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

Route::get('/', 'SiteController@index');

//обрабатываем форму
Route::post('/form','SiteController@post');

//Редиректим
Route::get('/goto/{token}', 'SiteController@goto')->name('goto');
