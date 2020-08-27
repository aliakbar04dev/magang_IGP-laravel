<?php

Route::group(['prefix'=>'sync', 'middleware'=>['auth']], function () {
	Route::get('index', [
		'as' => 'syncs.index',
		'uses'=>'SyncsController@index'
	]);
	Route::get('data/{param}', [
		'as' => 'syncs.satu',
		'uses'=>'SyncsController@satu'
	]);
	Route::get('data/{param}/{param2}', [
		'as' => 'syncs.dua',
		'uses'=>'SyncsController@dua'
	]);
	Route::get('data/{param}/{param2}/{param3}', [
		'as' => 'syncs.tiga',
		'uses'=>'SyncsController@tiga'
	]);
	Route::get('data/{param}/{param2}/{param3}/{param4}', [
		'as' => 'syncs.empat',
		'uses'=>'SyncsController@empat'
	]);
	Route::get('data/{param}/{param2}/{param3}/{param4}/{param5}', [
		'as' => 'syncs.lima',
		'uses'=>'SyncsController@lima'
	]);
	Route::get('data/{param}/{param2}/{param3}/{param4}/{param5}/{param6}', [
		'as' => 'syncs.enam',
		'uses'=>'SyncsController@enam'
	]);
});