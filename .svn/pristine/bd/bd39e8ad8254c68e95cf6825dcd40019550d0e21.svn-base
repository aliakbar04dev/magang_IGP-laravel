<?php

Route::group(['prefix'=>'supplier/eppc', 'middleware'=>['auth']], function () {
	Route::get('ppctdprs/all', [
		'as' => 'ppctdprs.all',
		'uses'=>'PpctDprsController@indexAll'
	]);
	Route::get('ppctdprs/dashboard/all', [
		'as' => 'dashboardall.ppctdprs',
		'uses'=>'PpctDprsController@dashboardAll'
	]);
	Route::get('ppctdprs/showall/{param}', [
		'as' => 'ppctdprs.showall',
		'uses'=>'PpctDprsController@showall'
	]);
	Route::resource('ppctdprpicas', 'PpctDprPicasController');
	Route::get('dashboard/ppctdprpicas', [
		'as' => 'dashboard.ppctdprpicas',
		'uses'=>'PpctDprPicasController@dashboard'
	]);
	Route::get('ppctdprpicas/delete/{param}', [
		'as' => 'ppctdprpicas.delete',
		'uses' => 'PpctDprPicasController@delete'
	]);
	Route::get('ppctdprpicas/deleteimage/{param}/{param2}', [
		'as' => 'ppctdprpicas.deleteimage',
		'uses' => 'PpctDprPicasController@deleteimage'
	]);
	Route::get('ppctdprpicas/revisi/{param}', [
		'as' => 'ppctdprpicas.revisi',
		'uses' => 'PpctDprPicasController@revisi'
	]);
	Route::get('ppctdprpicas/showrevisi/{param}', [
		'as' => 'ppctdprpicas.showrevisi',
		'uses'=>'PpctDprPicasController@showrevisi'
	]);
	Route::get('baandnsupps/all', [
		'as' => 'baandnsupps.all',
		'uses'=>'BaanDnSuppsController@indexAll'
	]);
	Route::get('baandnsupps/dashboard/all', [
		'as' => 'dashboardall.baandnsupps',
		'uses'=>'BaanDnSuppsController@dashboardAll'
	]);
	Route::get('baaniginh008s/all', [
		'as' => 'baaniginh008s.all',
		'uses'=>'BaanIginh008sController@indexAll'
	]);
	Route::get('baaniginh008s/dashboard/all', [
		'as' => 'baaniginh008s.dashboardall',
		'uses'=>'BaanIginh008sController@dashboardAll'
	]);
	Route::resource('ppctdnclaimsj1s', 'PpctDnclaimSj1sController');
	Route::get('dashboard/ppctdnclaimsj1s', [
		'as' => 'dashboard.ppctdnclaimsj1s',
		'uses'=>'PpctDnclaimSj1sController@dashboard'
	]);
	Route::get('ppctdnclaimsj1s/delete/{param}', [
		'as' => 'ppctdnclaimsj1s.delete',
		'uses' => 'PpctDnclaimSj1sController@delete'
	]);
	Route::delete('ppctdnclaimsj1s/deletedetail/{param}/{param2}/{param3}', [
		'as' => 'ppctdnclaimsj1s.deletedetail',
		'uses'=>'PpctDnclaimSj1sController@deletedetail'
	]);
	Route::get('ppctdnclaimsj1s/validasiNoSj/{param}/{param2}', [
		'as' => 'ppctdnclaimsj1s.validasiNoSj',
		'uses' => 'PpctDnclaimSj1sController@validasiNoSj'
	]);
	Route::get('ppctdnclaimsj1s/unsubmit/{param}', [
		'as' => 'ppctdnclaimsj1s.unsubmit',
		'uses' => 'PpctDnclaimSj1sController@unsubmit'
	]);
	Route::get('ppctdnclaimsj1s/print/{param}', [
		'as' => 'ppctdnclaimsj1s.print',
		'uses' => 'PpctDnclaimSj1sController@print'
	]);
	Route::get('ppctdnclaimsj1s/generate/{param}/{param2}/{param3}', [
		'as'=>'ppctdnclaimsj1s.generate',
		'uses'=>'PpctDnclaimSj1sController@generate'
	]);
});