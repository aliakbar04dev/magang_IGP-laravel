<?php

// Route::group(['prefix'=>'milkrun'], function () {
// 	Route::get('akebono', [
// 		'as' => 'apis.milkruns',
// 		'uses' => 'ApisController@milkruns'
// 	]);
// 	Route::get('akebonotrg', [
// 		'as' => 'apis.milkruns2',
// 		'uses' => 'ApisController@milkruns2'
// 	]);
// });

// Route::group(['prefix'=>'mierukaigp'], function () {
// 	Route::get('akebono/{param?}/{param2?}', [
// 		'as' => 'apis.mierukaigp',
// 		'uses' => 'ApisController@mierukaigp'
// 	]);
// });

Route::group(['prefix'=>'notifikasi'], function () {
	Route::get('qprs', [
		'as' => 'apis.qprs',
		'uses' => 'ApisController@qprs'
	]);
	Route::get('qprstrial', [
		'as' => 'apis.qprstrial',
		'uses' => 'ApisController@qprstrial'
	]);
	Route::get('baanpo1s', [
		'as' => 'apis.baanpo1s',
		'uses' => 'ApisController@baanpo1s'
	]);
	Route::get('baanpo1strial', [
		'as' => 'apis.baanpo1strial',
		'uses' => 'ApisController@baanpo1strial'
	]);
	Route::get('proseslaporanlch', [
		'as' => 'apis.proseslaporanlch',
		'uses' => 'ApisController@proseslaporanlch'
	]);
});