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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/start', 'StartController@index')->name('start.index');

Route::post('/build', 'StartController@build')->name('start.build');

Route::get('/test/{identifier}', 'StartController@take')->name('start.take');

Route::post('/assess', 'StartController@assess')->name('start.assess');

Route::get('/test/results/{identifier}', 'StartController@results')->name('start.results');
