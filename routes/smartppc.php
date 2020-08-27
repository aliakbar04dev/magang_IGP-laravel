<?php

Route::group(['prefix'=>'dashboard/ppc', 'middleware'=>['auth']], function () {
	
	Route::get('listHenkaten', [
		'as' => 'smartppc.listHenkaten',
		'uses'=>'SmartPpcController@listHenkaten'
	]);
	Route::get('listInventoryControl/{param}/{param2}', [
		'as' => 'smartppc.listInventoryControl',
		'uses'=>'SmartPpcController@listInventoryControl'
	]);
	Route::get('listInventoryControlCust/{param}', [
		'as' => 'smartppc.listInventoryControlCust',
		'uses'=>'SmartPpcController@listInventoryControlCust'
	]);
	Route::get('listTruck', [
		'as' => 'smartppc.listTruck',
		'uses'=>'SmartPpcController@listTruck'
	]);
	Route::get('listTruckArrival', [
		'as' => 'smartppc.listTruckArrival',
		'uses'=>'SmartPpcController@listTruckArrival'
	]);
	Route::get('listLchForklift/{param?}/{param2?}', [
		'as' => 'smartppc.listLchForklift',
		'uses'=>'SmartPpcController@listLchForklift'
	]);
	Route::get('listDetailLchForklift/{param}/{param2}/{param3}', [
		'as'=>'smartppc.listDetailLchForklift',
		'uses'=>'SmartPpcController@listDetailLchForklift'
	]);
	Route::get('listDlvrPerformance/{param}/{param2}/{param3}', [
		'as'=>'smartppc.listDlvrPerformance',
		'uses'=>'SmartPpcController@listDlvrPerformance'
	]);
});