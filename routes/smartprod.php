<?php

Route::group(['prefix'=>'dashboardprod'], function () {
	Route::get('/', [
		'as' => 'smartprods.dashboardprod',
		'uses'=>'SmartProdsController@dashboardprod'
	]);
	
	Route::get('linestop/{param1}/{param2}', [
		'as' => 'smartprods.linestopproblem',
		'uses'=>'SmartProdsController@linestopproblem'
	]);
	Route::get('effeciency/{param1}/{param2}', [
		'as' => 'smartprods.effeciency',
		'uses'=>'SmartProdsController@effeciency'
	]);
	// Route::get('linestop/{param1}/{param2}', [
	// 	'as' => 'smartprods.effeciency',
	// 	'uses'=>'SmartProdsController@effeciency'
	// ]);
});