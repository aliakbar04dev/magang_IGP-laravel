<?php

Route::group(['prefix'=>'sales', 'middleware'=>['auth']], function () {
	Route::resource('tcsls004ms', 'Tcsls004msController');
	Route::get('dashboard/tcsls004ms', [
		'as'=>'dashboard.tcsls004ms',
		'uses'=>'Tcsls004msController@dashboard'
	]);
	Route::get('tcsls004ms/detail/{param}/{param2}/{param3}', [
		'as'=>'tcsls004ms.detail',
		'uses'=>'Tcsls004msController@detail'
	]);
	Route::get('tcsls004ms/detail2/{param}/{param2}/{param3}', [
		'as'=>'tcsls004ms.detail2',
		'uses'=>'Tcsls004msController@detail2'
	]);
	Route::get('tcsls004ms/delete/{param}', [
		'as' => 'tcsls004ms.delete',
		'uses' => 'Tcsls004msController@delete'
	]);
	Route::delete('tcsls004ms/deletedetail/{param}/{param2}', [
		'as' => 'tcsls004ms.deletedetail',
		'uses'=>'Tcsls004msController@deletedetail'
	]);
	Route::resource('slstboms', 'SlstBomsController');
	Route::get('bom/slstboms/{param?}/{param2?}/{param3?}', [
		'as'=>'slstboms.bom',
		'uses'=>'SlstBomsController@bom'
	]);
});