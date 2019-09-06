<?php

Route::get('/', 'PageController@welcome')->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/start', 'StartController@index')->name('start.index');

Route::post('/build', 'StartController@build')->name('start.build');

Route::get('/test/{identifier}', 'TakeController@take')->name('start.take')->middleware('session_questionnaire');

Route::post('/assess', 'TakeController@assess')->name('start.assess');

Route::get('/test/results/{identifier}', 'ResultController@results')->name('start.results')->middleware('session_questionnaire');
