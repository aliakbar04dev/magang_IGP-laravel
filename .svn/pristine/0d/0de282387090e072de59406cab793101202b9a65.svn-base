<?php

Route::group(['prefix'=>'dashboard/warehouse', 'middleware'=>['auth']], function () {
	Route::get('listhenkaten', [
		'as' => 'smartwhss.listhenkaten',
		'uses'=>'SmartWhssController@listhenkaten'
	]);

	Route::get('listInventoryControl', [
		'as' => 'smartwhss.listInventoryControl',
		'uses'=>'SmartWhssController@listInventoryControl'
	]);

	Route::get('listInventoryControlPerUser/{param}/{param2}/{param3}', [
		'as' => 'smartwhss.listInventoryControlPerUser',
		'uses'=>'SmartWhssController@listInventoryControlPerUser'
	]);

	Route::get('listInventoryControlJmlItem/{param}/{param2}', [
		'as' => 'smartwhss.listInventoryControlJmlItem',
		'uses'=>'SmartWhssController@listInventoryControlJmlItem'
	]);

	Route::get('listLchForklift/{param?}/{param2?}', [
        'as' => 'smartwhss.listLchForklift',
        'uses'=>'SmartWhssController@listLchForklift'
    ]);

	Route::get('supplierTruckArrival', [
		'as' => 'smartwhss.supplierTruckArrival',
		'uses'=>'SmartWhssController@supplierTruckArrival'
	]);

	Route::get('supplierTruckOutstanding', [
		'as' => 'smartwhss.supplierTruckOutstanding',
		'uses'=>'SmartWhssController@supplierTruckOutstanding'
	]);

	Route::get('supplierTruckArrivalDailyMaingate', [
		'as' => 'smartwhss.supplierTruckArrivalDailyMaingate',
		'uses'=>'SmartWhssController@supplierTruckArrivalDailyMaingate'
	]);

	Route::get('supplierTruckArrivalMonthlyMaingate', [
		'as' => 'smartwhss.supplierTruckArrivalMonthlyMaingate',
		'uses'=>'SmartWhssController@supplierTruckArrivalMonthlyMaingate'
	]);

	Route::get('supplierTruckArrivalDailyUnloading', [
		'as' => 'smartwhss.supplierTruckArrivalDailyUnloading',
		'uses'=>'SmartWhssController@supplierTruckArrivalDailyUnloading'
	]);

	Route::get('supplierTruckArrivalMonthlyUnloading', [
		'as' => 'smartwhss.supplierTruckArrivalMonthlyUnloading',
		'uses'=>'SmartWhssController@supplierTruckArrivalMonthlyUnloading'
	]);

	Route::get('supplierTruckRankMainGate', [
		'as' => 'smartwhss.supplierTruckRankMainGate',
		'uses'=>'SmartWhssController@supplierTruckRankMainGate'
	]);

	Route::get('supplierTruckRankUnloading', [
		'as' => 'smartwhss.supplierTruckRankUnloading',
		'uses'=>'SmartWhssController@supplierTruckRankUnloading'
	]);

	Route::get('supplierTruckArrivalDailyMaingatePerSupplier/{param}', [
		'as' => 'smartwhss.supplierTruckArrivalDailyMaingatePerSupplier',
		'uses'=>'SmartWhssController@supplierTruckArrivalDailyMaingatePerSupplier'
	]);

	Route::get('supplierTruckArrivalDailyUnloadingPerSupplier/{param}', [
		'as' => 'smartwhss.supplierTruckArrivalDailyUnloadingPerSupplier',
		'uses'=>'SmartWhssController@supplierTruckArrivalDailyUnloadingPerSupplier'
	]);

	Route::get('supplierTruckArrivalYearly', [
		'as' => 'smartwhss.supplierTruckArrivalYearly',
		'uses'=>'SmartWhssController@supplierTruckArrivalYearly'
	]);

	Route::get('supplierTruckArrivalMonthlyPerSupplier/{param}', [
		'as' => 'smartwhss.supplierTruckArrivalMonthlyPerSupplier',
		'uses'=>'SmartWhssController@supplierTruckArrivalMonthlyPerSupplier'
	]);

	Route::get('supplierTruckArrivalMonthlyPerDate/{param}/{param2}', [
		'as' => 'smartwhss.supplierTruckArrivalMonthlyPerDate',
		'uses'=>'SmartWhssController@supplierTruckArrivalMonthlyPerDate'
	]);
});
// Route::get('/monitoringlp/{param?}/{param2?}/{param3?}', [
// 	'as' => 'smartmtcs.monitoringlp',
// 	'uses'=>'SmartMtcsController@monitoringlp'
// ]);