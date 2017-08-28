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
Route::get('/users/destroy/{id}', 'UserController@destroy');
Route::get('/user/{id}', 'UserController@profile');

// DOCUMENT
Route::get('/documents/index', 'DocumentController@index');
Route::post('/documents/store', 'DocumentController@store');
Route::post('/documents/update/{id}', 'DocumentController@update');

// RECEPTION
Route::get('/receptions/index', 'ReceptionController@index');
Route::post('/receptions/store', 'ReceptionController@store');
Route::get('/receptions/update/{id}/{nbrPage}', 'ReceptionController@update');

// SCAN
Route::get('/scan/index', 'ScanController@index');
Route::get('/scan/scanning/{id}', 'ScanController@scanning');
Route::get('/scan/confirm/{id}', 'ScanController@confirm');

// IMPORT
Route::get('/import/index', 'ImportController@index');
Route::get('/import/importing/{id}', 'ImportController@importing');
Route::get('/import/confirm/{id}', 'ImportController@confirm');

// AFFECT
Route::get('/affect/index', 'AffectController@index');
Route::get('/affect/{id}', 'AffectController@affect');

// CLIPPING
Route::get('/clipping/index', 'ClippingController@index');

// EXPORT
Route::get('/receptions/export/{id}', 'ReceptionController@export');
Route::get('/receptions/getClipped', 'ReceptionController@getClipped'); 

// SORT
Route::post('/sort/{model}', 'ReceptionController@sort');

// ADMIN
Route::get('/admin/dashboard', 'AdminController@dashboard');