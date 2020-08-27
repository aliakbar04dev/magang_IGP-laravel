<?php

Route::group(['prefix' => 'dashboardmtc'], function () {
	Route::get('/', [
		'as' => 'smartmtcs.dashboardmtc',
		'uses' => 'SmartMtcsController@dashboardmtc'
	]);
	Route::get('/speedometer', [
		'as' => 'smartmtcs.speedometer',
		'uses' => 'SmartMtcsController@speedometer'
	]);
	Route::get('dm/{param}/{param2}', [
		'as' => 'smartmtcs.indexdm',
		'uses' => 'SmartMtcsController@indexdm'
	]);
	Route::get('dashboard/dm/{param}/{param2}', [
		'as' => 'smartmtcs.dashboarddm',
		'uses' => 'SmartMtcsController@dashboarddm'
	]);
	Route::get('showdetail/dm/{param}', [
		'as' => 'smartmtcs.showdetaildm',
		'uses' => 'SmartMtcsController@showdetaildm'
	]);
	Route::get('showdetail/lp/{param}', [
		'as' => 'smartmtcs.showdetaillp',
		'uses' => 'SmartMtcsController@showdetaillp'
	]);
	Route::get('grafik/pmsachievement/{param}/{param2}/{param3}/{param4}', [
		'as' => 'smartmtcs.pmsachievement',
		'uses' => 'SmartMtcsController@pmsachievement'
	]);
	Route::get('pmsachievementprogressmesin/{param}/{param2}/{param3}/{param4}', [
		'as' => 'smartmtcs.pmsachievementprogressmesin',
		'uses' => 'SmartMtcsController@pmsachievementprogressmesin'
	]);
	Route::get('stockohigp', [
		'as' => 'smartmtcs.indexstockohigp',
		'uses' => 'SmartMtcsController@indexstockohigp'
	]);
	Route::get('dashboardstockohigp/stockohigps', [
		'as' => 'smartmtcs.dashboardstockohigp',
		'uses' => 'SmartMtcsController@dashboardstockohigp'
	]);
	Route::get('dashboardmesinstockohigp/stockohigps', [
		'as' => 'smartmtcs.dashboardmesinstockohigp',
		'uses' => 'SmartMtcsController@dashboardmesinstockohigp'
	]);
	Route::get('mtctpms/{param}/{param2}', [
		'as' => 'smartmtcs.indexmtctpms',
		'uses' => 'SmartMtcsController@indexmtctpms'
	]);
	Route::get('dashboardmtctpms/mtctpms/{param}/{param2}/{param3}/{param4?}/{param5?}', [
		'as' => 'smartmtcs.dashboardmtctpms',
		'uses' => 'SmartMtcsController@dashboardmtctpms'
	]);
	Route::get('dashboarddmmtctpms/mtctpms/{param}/{param2}/{param3}', [
		'as' => 'smartmtcs.dashboarddmmtctpms',
		'uses' => 'SmartMtcsController@dashboarddmmtctpms'
	]);
	Route::get('dpm/{param}', [
		'as' => 'smartmtcs.dpm',
		'uses' => 'SmartMtcsController@dpm'
	]);
	Route::get('dpmtotal', [
		'as' => 'smartmtcs.dpmtotal',
		'uses' => 'SmartMtcsController@dpmtotal'
	]);
	Route::get('resumepengisianoli/{param}/{param2?}/{param3?}/{param4?}/{param5?}/{param6?}', [
		'as' => 'smartmtcs.resumepengisianoli',
		'uses' => 'SmartMtcsController@resumepengisianoli'
	]);
	Route::get('top/pengisianoli/{param}/{param2}/{param3}/{param4?}/{param5?}', [
		'as' => 'smartmtcs.toppengisianoli',
		'uses' => 'SmartMtcsController@toppengisianoli'
	]);
	Route::get('kpi/{param}/{param2}', [
		'as' => 'smartmtcs.kpi',
		'uses' => 'SmartMtcsController@kpi'
	]);
	Route::get('spm/{param?}', [
		'as' => 'smartmtcs.spm',
		'uses' => 'SmartMtcsController@spm'
	]);
	Route::get('dashboard/spm/{param?}', [
		'as' => 'smartmtcs.dashboardspm',
		'uses' => 'SmartMtcsController@dashboardspm'
	]);
});

Route::get('/smartmtc', [
	'as' => 'smartmtcs.dashboardmtc2',
	'uses' => 'SmartMtcsController@dashboardmtc2'
]);
Route::get('/indev/{param?}', [
	'as' => 'smartmtcs.indev',
	'uses' => 'SmartMtcsController@indev'
]);
Route::get('/dashdaily/{param?}', [
	'as' => 'smartmtcs.dashdaily',
	'uses' => 'SmartMtcsController@dashdaily'
]);
Route::get('/smartmtc/problist', [
	'as' => 'smartmtcs.problist',
	'uses' => 'SmartMtcsController@problist'
]);

Route::get('/smartmtc/sparepart', [
	'as' => 'smartmtcs.sparepart',
	'uses' => 'SmartMtcsController@sparepart'
]);

Route::get('/smartmtc/oilusage', [
	'as' => 'smartmtcs.oilusage',
	'uses' => 'SmartMtcsController@oilusage'
]);
Route::get('/smartmtc/powerutil', [
	'as' => 'smartmtcs.powerutil',
	'uses' => 'SmartMtcsController@powerutil'
]);
Route::get('/smartmtc/preventive', [
	'as' => 'smartmtcs.preventive',
	'uses' => 'SmartMtcsController@preventive'
]);
Route::get('/smartmtc/dailyactivity', [
	'as' => 'smartmtcs.dailyactivity',
	'uses' => 'SmartMtcsController@dailyactivity'
]);
Route::get('/smartmtc/checkforklift', [
	'as' => 'smartmtcs.checkforklift',
	'uses' => 'SmartMtcsController@checkforklift'
]);
Route::get('/smartmtc/kpimt', [
	'as' => 'smartmtcs.kpimt',
	'uses' => 'SmartMtcsController@kpimt'
]);
Route::get('/smartmtc/critical', [
	'as' => 'smartmtcs.critical',
	'uses' => 'SmartMtcsController@critical'
]);
Route::get('/smartmtc/searchhistory', [
	'as' => 'smartmtcs.searchhistory',
	'uses' => 'SmartMtcsController@searchhistory'
]);


Route::get('/monitoringlp/{param?}/{param2?}/{param3?}', [
	'as' => 'smartmtcs.monitoringlp',
	'uses' => 'SmartMtcsController@monitoringlp'
]);
Route::get('/monitoringmtc/{param?}', [
	'as' => 'smartmtcs.monitoringmtc',
	'uses' => 'SmartMtcsController@monitoringmtc'
]);
Route::get('/monitoringlch/{param?}/{param2?}', [
	'as' => 'smartmtcs.monitoringlch',
	'uses' => 'SmartMtcsController@monitoringlch'
]);
Route::get('lch/detail/{param}/{param2}/{param3}', [
	'as' => 'smartmtcs.detaillch',
	'uses' => 'SmartMtcsController@detaillch'
]);
Route::get('/monitoringasakai/{param}/{param2?}/{param3?}/{param4?}', [
	'as' => 'smartmtcs.monitoringasakai',
	'uses' => 'SmartMtcsController@monitoringasakai'
]);
Route::get('/monitoringandon', [
	'as' => 'smartmtcs.monitoringandon',
	'uses' => 'SmartMtcsController@monitoringandon'
]);
Route::get('/mtc-andon-igp1/{param?}', [
	'as' => 'smartmtcs.andon1',
	'uses' => 'SmartMtcsController@andon1'
]);
Route::get('/mtc-andon-igp2/{param?}', [
	'as' => 'smartmtcs.andon2',
	'uses' => 'SmartMtcsController@andon2'
]);
Route::get('/mtc-andon-igp3/{param?}', [
	'as' => 'smartmtcs.andon3',
	'uses' => 'SmartMtcsController@andon3'
]);

Route::group(['prefix' => 'api-mtc', 'middleware' => ['auth']], function () {
	Route::get('/andons/{param}/{param2}', [
		'as' => 'apimtcs.andons',
		'uses' => 'ApiMtcsController@andons'
	]);
	Route::get('/dm/{param}/{param2}/{param3}', [
		'as' => 'apimtcs.dm',
		'uses' => 'ApiMtcsController@dm'
	]);
	Route::get('/pms/{param}/{param2}/{param3}', [
		'as' => 'apimtcs.pmstahun',
		'uses' => 'ApiMtcsController@pmstahun'
	]);
	Route::get('/pms/{param}/{param2}/{param3}/{param4}', [
		'as' => 'apimtcs.pmsbulan',
		'uses' => 'ApiMtcsController@pmsbulan'
	]);
	Route::get('/pmsline/{param}/{param2}/{param3}/{param4}', [
		'as' => 'apimtcs.pmsline',
		'uses' => 'ApiMtcsController@pmsline'
	]);
	Route::get('/daz/{param}/{param2}/{param3}/{param4}', [
		'as' => 'apimtcs.daz',
		'uses' => 'ApiMtcsController@daz'
	]);
	Route::get('/dmpms/{param}/{param2}/{param3}/{param4}', [
		'as' => 'apimtcs.dmpms',
		'uses' => 'ApiMtcsController@dmpms'
	]);
	Route::get('/lch/{param}/{param2}', [
		'as' => 'apimtcs.lch',
		'uses' => 'ApiMtcsController@lch'
	]);
	Route::get('/lchdetail1/{param}/{param2}/{param3}', [
		'as' => 'apimtcs.lchdetail1',
		'uses' => 'ApiMtcsController@lchdetail1'
	]);
	Route::get('/lchdetail2/{param}', [
		'as' => 'apimtcs.lchdetail2',
		'uses' => 'ApiMtcsController@lchdetail2'
	]);
	Route::get('/resumeolisite/{param}/{param2}/{param3}', [
		'as' => 'apimtcs.resumeolisite',
		'uses' => 'ApiMtcsController@resumeolisite'
	]);
	Route::get('/resumeoliplant/{param}/{param2}/{param3}/{param4}', [
		'as' => 'apimtcs.resumeoliplant',
		'uses' => 'ApiMtcsController@resumeoliplant'
	]);
	Route::get('/resumeolimesin/{param}/{param2}/{param3}/{param4}/{param5}/{param6}', [
		'as' => 'apimtcs.resumeolimesin',
		'uses' => 'ApiMtcsController@resumeolimesin'
	]);
	Route::get('/resumeolimesinharian/{param}/{param2}/{param3}/{param4}/{param5}/{param6}/{param7}', [
		'as' => 'apimtcs.resumeolimesinharian',
		'uses' => 'ApiMtcsController@resumeolimesinharian'
	]);
	Route::get('popupLines/{param}', [
		'as' => 'apimtcs.popupLines',
		'uses' => 'ApiMtcsController@popupLines'
	]);
	Route::get('validasiLine/{param}/{param2}', [
		'as' => 'apimtcs.validasiLine',
		'uses' => 'ApiMtcsController@validasiLine'
	]);
	Route::get('mesin/{param}/{param2}', [
		'as' => 'apimtcs.mesin',
		'uses' => 'ApiMtcsController@mesin'
	]);
	Route::get('/toppengisianoli/{param}/{param2}/{param3}/{param4}', [
		'as' => 'apimtcs.toppengisianoli',
		'uses' => 'ApiMtcsController@toppengisianoli'
	]);
	Route::get('/dpm/{param}/{param2}', [
		'as' => 'apimtcs.dpm',
		'uses' => 'ApiMtcsController@dpm'
	]);
});
