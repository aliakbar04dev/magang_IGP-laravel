<?php

Route::group(['prefix'=>'mgt', 'middleware'=>['auth']], function () {
	Route::resource('mgmtgembas', 'MgmtGembasController');
	Route::get('dashboard/mgmtgembas', [
		'as'=>'dashboard.mgmtgembas',
		'uses'=>'MgmtGembasController@dashboard'
	]);
	Route::get('mgmtgembas/cm/all', [
		'as'=>'mgmtgembas.indexcm',
		'uses'=>'MgmtGembasController@indexcm'
	]);
	Route::get('dashboardcm/mgmtgembas', [
		'as'=>'dashboardcm.mgmtgembas',
		'uses'=>'MgmtGembasController@dashboardcm'
	]);
	Route::get('mgmtgembas/{param}/cm', [
		'as'=>'mgmtgembas.inputcm',
		'uses'=>'MgmtGembasController@inputcm'
	]);
	Route::get('mgmtgembas/showcm/{param}', [
		'as' => 'mgmtgembas.showcm',
		'uses'=>'MgmtGembasController@showcm'
	]);
	Route::get('mgmtgembas/delete/{param}', [
		'as' => 'mgmtgembas.delete',
		'uses' => 'MgmtGembasController@delete'
	]);
	Route::get('mgmtgembas/deleteimage/{param}/{param2}', [
		'as' => 'mgmtgembas.deleteimage',
		'uses' => 'MgmtGembasController@deleteimage'
	]);
	Route::get('mgmtgembas/laporan/print', [
		'as' => 'mgmtgembas.laporan',
		'uses'=>'MgmtGembasController@laporan'
	]);
	Route::get('mgmtgembas/printlaporan/{param}/{param2}/{param3}/{param4}', [
		'as' => 'mgmtgembas.printlaporan',
		'uses' => 'MgmtGembasController@printlaporan'
	]);
});

Route::group(['prefix'=>'mgtdep', 'middleware'=>['auth']], function () {
	Route::resource('mgmtgembadeps', 'MgmtGembaDepsController');
	Route::get('dashboard/mgmtgembadeps', [
		'as'=>'dashboard.mgmtgembadeps',
		'uses'=>'MgmtGembaDepsController@dashboard'
	]);
	Route::get('mgmtgembadeps/cm/all', [
		'as'=>'mgmtgembadeps.indexcm',
		'uses'=>'MgmtGembaDepsController@indexcm'
	]);
	Route::get('dashboardcm/mgmtgembadeps', [
		'as'=>'dashboardcm.mgmtgembadeps',
		'uses'=>'MgmtGembaDepsController@dashboardcm'
	]);
	Route::get('mgmtgembadeps/{param}/cm', [
		'as'=>'mgmtgembadeps.inputcm',
		'uses'=>'MgmtGembaDepsController@inputcm'
	]);
	Route::get('mgmtgembadeps/showcm/{param}', [
		'as' => 'mgmtgembadeps.showcm',
		'uses'=>'MgmtGembaDepsController@showcm'
	]);
	Route::get('mgmtgembadeps/delete/{param}', [
		'as' => 'mgmtgembadeps.delete',
		'uses' => 'MgmtGembaDepsController@delete'
	]);
	Route::get('mgmtgembadeps/deleteimage/{param}/{param2}', [
		'as' => 'mgmtgembadeps.deleteimage',
		'uses' => 'MgmtGembaDepsController@deleteimage'
	]);
	Route::get('mgmtgembadeps/laporan/print', [
		'as' => 'mgmtgembadeps.laporan',
		'uses'=>'MgmtGembaDepsController@laporan'
	]);
	Route::get('mgmtgembadeps/printlaporan/{param}/{param2}/{param3}/{param4}', [
		'as' => 'mgmtgembadeps.printlaporan',
		'uses' => 'MgmtGembaDepsController@printlaporan'
	]);
});