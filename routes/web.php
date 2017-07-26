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

// RECEPTION
Route::get('/receptions/index', 'ReceptionController@index');
Route::post('/receptions/store', 'ReceptionController@store');

// SCAN
Route::get('/receptions/scan/{id}', 'ReceptionController@scan');
Route::get('/receptions/scan', 'ReceptionController@getScan');

// IMPORT
Route::get('/receptions/import/{id}', 'ReceptionController@import');
Route::get('/receptions/import', 'ReceptionController@getImport');

// CLIPPING
Route::get('/receptions/clipping/{reception_id}/{agent_id}', 'ReceptionController@addAgent');
Route::get('/receptions/clipping/agent', 'ReceptionController@agentClipping');
Route::post('/receptions/clipping/{id}', 'ReceptionController@clipping');
Route::get('/receptions/clipping', 'ReceptionController@getClipping');
Route::get('/receptions/deleteClipping/{id}', 'ReceptionController@deleteClipping');

// EXPORT

Route::get('/receptions/export/{id}', 'ReceptionController@export');
Route::get('/receptions/export', 'ReceptionController@getExport'); 

// ADMIN

