<?php

// Route::get('/test', function () {
// 	return view('layouts.test');
// });

Route::get('/', function () {
	return view('layouts.app');
})->middleware('auth');

Route::get('/home', function () {
	return view('layouts.app');
})->middleware('auth');

Auth::routes();

Route::get('/user', 'HomeController@index');

//  USER
Route::get('/users/all', 'UserController@index');
Route::post('/user/store', 'UserController@store');

// TEAM
Route::get('/teams/all', 'TeamController@index');
Route::post('teams/store', 'TeamController@store');

// DOCUMENT
Route::get('/documents/index', 'DocumentController@index');
Route::post('/documents/store', 'DocumentController@store');
Route::post('/documents/update/{id}', 'DocumentController@update');

// RECEPTION
Route::get('/receptions/index', 'ReceptionController@index');
Route::post('/receptions/store', 'ReceptionController@store');

// SCAN
Route::get('/receptions/scan/{id}', 'ReceptionController@scan');

// IMPORT
Route::get('/receptions/import/{id}', 'ReceptionController@import');
Route::get('/receptions/getScanned', 'ReceptionController@getScanned');

// AFFECT
Route::get('/receptions/getImported', 'ReceptionController@getImported');
Route::get('/receptions/clipping/{reception_id}/{agent_id}', 'ReceptionController@addAgent');

// CLIPPING
Route::get('/receptions/clipping/agent', 'ReceptionController@agentClipping');
Route::post('/receptions/clipping/{id}', 'ReceptionController@clipping');
Route::get('/receptions/deleteClipping/{id}', 'ReceptionController@deleteClipping');

// EXPORT
Route::get('/receptions/export/{id}', 'ReceptionController@export');
Route::get('/receptions/getClipped', 'ReceptionController@getClipped'); 

// SORT
Route::post('/sort/{model}', 'ReceptionController@sort');

