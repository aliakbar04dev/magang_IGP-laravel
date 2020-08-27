<?php

Route::get('/ops', 'GuestController@ops');
Route::get('/ops2', 'GuestController@ops2');
Route::get('/komite/{param?}', 'GuestController@komite');

Route::get('dashboard/ops', [
	'as' => 'dashboard.ops',
	'uses'=>'GuestController@dashboard'
]);
Route::get('dashboard/komite', [
	'as' => 'dashboard.komite',
	'uses'=>'GuestController@dashboardKomite'
]);
Route::get('/network/{param?}', 'GuestController@network');
Route::get('dashboard/network', [
	'as' => 'dashboard.network',
	'uses'=>'GuestController@dashboardNetwork'
]);
Route::get('/pppolpb/{param?}', 'GuestController@pppolpb');
Route::get('dashboard/pppolpb/{param}', [
	'as' => 'dashboard.pppolpb',
	'uses'=>'GuestController@dashboardPppolpb'
]);
Route::get('/pppolpb2/{param?}', 'GuestController@pppolpb2');
Route::get('dashboard/pppolpb2/{param}', [
	'as' => 'dashboard.pppolpb2',
	'uses'=>'GuestController@dashboardPppolpb2'
]);
Route::get('/testconnection', 'GuestController@testconnection');

Route::get('/monitoringwp/{param?}/{param2?}', 'GuestController@monitoringwp');
Route::get('/monitoringwpall/{param?}/{param2?}', 'GuestController@monitoringwpall');