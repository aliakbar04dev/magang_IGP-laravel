<?php

Route::group(['prefix'=>'supplier/eproc', 'middleware'=>['auth']], function () {
	Route::get('prctrfqs/all', [
		'as' => 'prctrfqs.indexall',
		'uses'=>'PrctRfqsController@indexAll'
	]);
	Route::get('prctrfqs/dashboard/all', [
		'as' => 'dashboardall.prctrfqs',
		'uses'=>'PrctRfqsController@dashboardAll'
	]);
	Route::post('prctrfqs/approve', [
		'as' => 'prctrfqs.approve',
		'uses' => 'PrctRfqsController@approve'
	]);
	Route::post('prctrfqs/reject', [
		'as' => 'prctrfqs.reject',
		'uses' => 'PrctRfqsController@reject'
	]);
	Route::delete('prctrfqs/deleterm/{param}/{param2}/{param3}', [
		'as' => 'prctrfqs.deleterm',
		'uses'=>'PrctRfqsController@deleterm'
	]);
	Route::delete('prctrfqs/deleteproses/{param}/{param2}/{param3}', [
		'as' => 'prctrfqs.deleteproses',
		'uses'=>'PrctRfqsController@deleteproses'
	]);
	Route::delete('prctrfqs/deleteht/{param}/{param2}/{param3}', [
		'as' => 'prctrfqs.deleteht',
		'uses'=>'PrctRfqsController@deleteht'
	]);
	Route::delete('prctrfqs/deleteppart/{param}/{param2}/{param3}', [
		'as' => 'prctrfqs.deleteppart',
		'uses'=>'PrctRfqsController@deleteppart'
	]);
	Route::delete('prctrfqs/deletetool/{param}/{param2}/{param3}', [
		'as' => 'prctrfqs.deletetool',
		'uses'=>'PrctRfqsController@deletetool'
	]);
});