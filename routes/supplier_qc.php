<?php

Route::group(['prefix' => 'supplier/qc', 'middleware' => ['auth']], function () {
	Route::resource('qprs', 'QprsController');
	Route::get('dashboard/qprs', [
		'as' => 'dashboard.qprs',
		'uses' => 'QprsController@dashboard'
	]);
	Route::get('qprs/status/{param}', [
		'as' => 'qprs.indexstatus',
		'uses' => 'QprsController@indexstatus'
	]);
	Route::get('qprs/dashboard/status', [
		'as' => 'dashboardstatus.qprs',
		'uses' => 'QprsController@dashboardstatus'
	]);
	Route::post('qprs/approve', [
		'as' => 'qprs.approve',
		'uses' => 'QprsController@approve'
	]);
	Route::post('qprs/reject', [
		'as' => 'qprs.reject',
		'uses' => 'QprsController@reject'
	]);
	Route::get('qprs/download/{param}', [
		'as' => 'qprs.download',
		'uses' => 'QprsController@download'
	]);
	Route::resource('picas', 'PicasController');
	Route::get('dashboard/picas', [
		'as' => 'dashboard.picas',
		'uses' => 'PicasController@dashboard'
	]);
	Route::get('picas/status/{param}', [
		'as' => 'picas.indexstatus',
		'uses' => 'PicasController@indexstatus'
	]);
	Route::get('picas/dashboard/status', [
		'as' => 'dashboardstatus.picas',
		'uses' => 'PicasController@dashboardstatus'
	]);
	Route::get('picas/delete/{param}', [
		'as' => 'picas.delete',
		'uses' => 'PicasController@delete'
	]);
	Route::get('picas/deleteimage/{param}/{param2}', [
		'as' => 'picas.deleteimage',
		'uses' => 'PicasController@deleteimage'
	]);
	Route::get('picas/revisi/{param}', [
		'as' => 'picas.revisi',
		'uses' => 'PicasController@revisi'
	]);
	Route::post('picas/reject', [
		'as' => 'picas.reject',
		'uses' => 'PicasController@reject'
	]);
	Route::post('picas/approve', [
		'as' => 'picas.approve',
		'uses' => 'PicasController@approve'
	]);
	Route::post('picas/close', [
		'as' => 'picas.close',
		'uses' => 'PicasController@close'
	]);
	Route::post('picas/efektif', [
		'as' => 'picas.efektif',
		'uses' => 'PicasController@efektif'
	]);
	Route::get('picas/showrevisi/{param}', [
		'as' => 'picas.showrevisi',
		'uses' => 'PicasController@showrevisi'
	]);
	Route::get('picas/print/{param}', [
		'as' => 'picas.print',
		'uses' => 'PicasController@print'
	]);
	Route::get('userguide/qprs', [
		'as' => 'qprs.userguide',
		'uses' => 'QprsController@userguide'
	]);
});

Route::get('supplier/qc/qprs/downloadqpr/{param}/{param2}', [
	'as' => 'qprs.downloadqpr',
	'uses' => 'QprsController@downloadqpr'
]);
