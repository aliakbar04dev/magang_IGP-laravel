<?php

Route::group(['prefix'=>'supplier/ehs', 'middleware'=>['auth']], function () {
	Route::resource('ehstwp1s', 'EhstWp1sController');
	Route::get('dashboard/ehstwp1s', [
		'as'=>'dashboard.ehstwp1s',
		'uses'=>'EhstWp1sController@dashboard'
	]);
	Route::get('userguide/ehstwp1s', [
		'as' => 'ehstwp1s.userguide',
		'uses' => 'EhstWp1sController@userguide'
	]);
	Route::get('ehstwp1s/delete/{param}/{param2}', [
		'as' => 'ehstwp1s.delete',
		'uses' => 'EhstWp1sController@delete'
	]);
	Route::get('ehstwp1s/revisi/{param}', [
		'as' => 'ehstwp1s.revisi',
		'uses' => 'EhstWp1sController@revisi'
	]);
	Route::get('ehstwp1s/showrevisi/{param}', [
		'as' => 'ehstwp1s.showrevisi',
		'uses'=>'EhstWp1sController@showrevisi'
	]);
	Route::get('ehstwp1s/perpanjang/{param}', [
		'as' => 'ehstwp1s.perpanjang',
		'uses' => 'EhstWp1sController@perpanjang'
	]);
	Route::get('ehstwp1s/copy/{param}', [
		'as' => 'ehstwp1s.copy',
		'uses' => 'EhstWp1sController@copy'
	]);
	Route::resource('ehstwp2mps', 'EhstWp2MpsController');
	Route::get('ehstwp2mps/deleteimage/{param}', [
		'as' => 'ehstwp2mps.deleteimage',
		'uses' => 'EhstWp2MpsController@deleteimage'
	]);
	Route::resource('ehstwp2k3s', 'EhstWp2K3sController');
	Route::resource('ehstwp2envs', 'EhstWp2EnvsController');
});