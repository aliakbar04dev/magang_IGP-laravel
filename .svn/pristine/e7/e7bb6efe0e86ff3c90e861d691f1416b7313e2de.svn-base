<?php

Route::group(['prefix'=>'faco', 'middleware'=>['auth']], function () {
	Route::resource('lalins', 'LalinsController');
	Route::get('serahterima/ksracc/', [
		'as' => 'lalins.createksracc',
		'uses'=>'LalinsController@createksracc'
	]);
	Route::get('serahterima/accfin/', [
		'as' => 'lalins.createaccfin',
		'uses'=>'LalinsController@createaccfin'
	]);
	Route::get('serahterima/finksr/', [
		'as' => 'lalins.createfinksr',
		'uses'=>'LalinsController@createfinksr'
	]);
	Route::get('indexksracc', [
		'as' => 'lalins.indexksracc',
		'uses'=>'LalinsController@indexksracc'
	]);
	Route::get('indexaccfin', [
		'as' => 'lalins.indexaccfin',
		'uses'=>'LalinsController@indexaccfin'
	]);
	Route::get('indexfinksr', [
		'as' => 'lalins.indexfinksr',
		'uses'=>'LalinsController@indexfinksr'
	]);
	Route::get('dashboardksracc/lalins', [
		'as'=>'lalins.dashboardksracc',
		'uses'=>'LalinsController@dashboardksracc'
	]);
	Route::get('lalins/detailksracc/{param}', [
		'as'=>'lalins.detailksracc',
		'uses'=>'LalinsController@detailksracc'
	]);
	Route::get('dashboardaccfin/lalins', [
		'as'=>'lalins.dashboardaccfin',
		'uses'=>'LalinsController@dashboardaccfin'
	]);
	Route::get('lalins/detailaccfin/{param}', [
		'as'=>'lalins.detailaccfin',
		'uses'=>'LalinsController@detailaccfin'
	]);
	Route::get('dashboardfinksr/lalins', [
		'as'=>'lalins.dashboardfinksr',
		'uses'=>'LalinsController@dashboardfinksr'
	]);
	Route::get('lalins/detailfinksr/{param}', [
		'as'=>'lalins.detailfinksr',
		'uses'=>'LalinsController@detailfinksr'
	]);
	Route::get('lalins/delete/{param}', [
		'as' => 'lalins.delete',
		'uses' => 'LalinsController@delete'
	]);
	Route::get('lalins/popup/serahksracc/{param?}', [
		'as'=>'lalins.popupserahksracc',
		'uses'=>'LalinsController@popupserahksracc'
	]);
	Route::get('lalins/popup/serahaccfin/{param?}', [
		'as'=>'lalins.popupserahaccfin',
		'uses'=>'LalinsController@popupserahaccfin'
	]);
	Route::get('lalins/popup/serahfinksr/{param?}', [
		'as'=>'lalins.popupserahfinksr',
		'uses'=>'LalinsController@popupserahfinksr'
	]);
	Route::delete('lalins/deletedetail/{param}/{param2}', [
		'as' => 'lalins.deletedetail',
		'uses'=>'LalinsController@deletedetail'
	]);
	Route::get('terima/ksracc/{param}', [
		'as' => 'lalins.terimaksracc',
		'uses'=>'LalinsController@terima'
	]);
	Route::get('terima/accfin/{param}', [
		'as' => 'lalins.terimaaccfin',
		'uses'=>'LalinsController@terima'
	]);
	Route::get('terima/finksr/{param}', [
		'as' => 'lalins.terimafinksr',
		'uses'=>'LalinsController@terima'
	]);
	Route::get('lalins/validasiNoTtPp/{param}/{param2}/{param3}', [
		'as' => 'lalins.validasiNoTtPp',
		'uses' => 'LalinsController@validasiNoTtPp'
	]);
});