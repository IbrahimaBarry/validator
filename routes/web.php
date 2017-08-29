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
Route::post('/clipping', 'ClippingController@clipped');
Route::get('/clipping/confirm/{id}', 'ClippingController@confirm');

// EXPORT
Route::get('/export/index', 'ExportController@index');
Route::get('/export/{id}', 'ExportController@exported');
Route::get('/export/confirm/{id}', 'ExportController@confirm');

// SORT
Route::post('/sort/reception', 'ReceptionController@sort');
Route::post('/sort/scan', 'ScanController@sort');
Route::post('/sort/import', 'ImportController@sort');
Route::post('/sort/affect', 'AffectController@sort');
Route::post('/sort/export', 'ExportController@sort');

// ADMIN
Route::get('/admin/dashboard', 'AdminController@dashboard');