<?php

Route::group(['prefix'=>'prc', 'middleware'=>['auth']], function () {
	Route::resource('ppregs', 'PpRegsController');
	Route::get('dashboard/ppregs', [
		'as'=>'dashboard.ppregs',
		'uses'=>'PpRegsController@dashboard'
	]);
	Route::get('ppregs/detail/{noreg}', [
		'as'=>'ppregs.detail',
		'uses'=>'PpRegsController@detail'
	]);
	Route::get('ppregs/reject/{param}/{param2}', [
		'as' => 'ppregs.reject',
		'uses' => 'PpRegsController@reject'
	]);
	Route::get('ppregs/approve/{param}/{param2}', [
		'as' => 'ppregs.approve',
		'uses' => 'PpRegsController@approve'
	]);
	Route::resource('ppregdetails', 'PpRegDetailsController');
	Route::resource('baanpo1s', 'BaanPo1sController');
	Route::get('baanpo1s/pic/all', [
		'as' => 'baanpo1s.indexpic',
		'uses'=>'BaanPo1sController@indexpic'
	]);
	Route::get('baanpo1s/dashboard/pic', [
		'as' => 'baanpo1s.dashboardpic',
		'uses'=>'BaanPo1sController@dashboardpic'
	]);
	Route::get('baanpo1s/sh/all', [
		'as' => 'baanpo1s.indexsh',
		'uses'=>'BaanPo1sController@indexsh'
	]);
	Route::get('baanpo1s/dashboard/sh', [
		'as' => 'baanpo1s.dashboardsh',
		'uses'=>'BaanPo1sController@dashboardsh'
	]);
	Route::get('baanpo1s/dep/all', [
		'as' => 'baanpo1s.indexdep',
		'uses'=>'BaanPo1sController@indexdep'
	]);
	Route::get('baanpo1s/dashboard/dep', [
		'as' => 'baanpo1s.dashboarddep',
		'uses'=>'BaanPo1sController@dashboarddep'
	]);
	Route::get('baanpo1s/div/all', [
		'as' => 'baanpo1s.indexdiv',
		'uses'=>'BaanPo1sController@indexdiv'
	]);
	Route::get('baanpo1s/dashboard/div', [
		'as' => 'baanpo1s.dashboarddiv',
		'uses'=>'BaanPo1sController@dashboarddiv'
	]);
	Route::get('dashboard/baanpo1s', [
		'as'=>'baanpo1s.dashboard',
		'uses'=>'BaanPo1sController@dashboard'
	]);
	Route::get('baanpo1s/detail/{param}/{param2}', [
		'as'=>'baanpo1s.detail',
		'uses'=>'BaanPo1sController@detail'
	]);
	Route::get('baanpo1s/detailrevisi/{param}/{param2}', [
		'as'=>'baanpo1s.detailrevisi',
		'uses'=>'BaanPo1sController@detailrevisi'
	]);
	Route::get('baanpo1s/showpic/{param}', [
		'as' => 'baanpo1s.showpic',
		'uses'=>'BaanPo1sController@showpic'
	]);
	Route::get('baanpo1s/showsh/{param}', [
		'as' => 'baanpo1s.showsh',
		'uses'=>'BaanPo1sController@showsh'
	]);
	Route::get('baanpo1s/showdep/{param}', [
		'as' => 'baanpo1s.showdep',
		'uses'=>'BaanPo1sController@showdep'
	]);
	Route::get('baanpo1s/showdiv/{param}', [
		'as' => 'baanpo1s.showdiv',
		'uses'=>'BaanPo1sController@showdiv'
	]);
	Route::get('baanpo1s/showrevisi/{param}/{param2}', [
		'as' => 'baanpo1s.showrevisi',
		'uses'=>'BaanPo1sController@showrevisi'
	]);
	Route::post('baanpo1s/approvepic', [
		'as' => 'baanpo1s.approvepic',
		'uses' => 'BaanPo1sController@approvepic'
	]);
	Route::post('baanpo1s/revisipic', [
		'as' => 'baanpo1s.revisipic',
		'uses' => 'BaanPo1sController@revisipic'
	]);
	Route::post('baanpo1s/approve', [
		'as' => 'baanpo1s.approve',
		'uses' => 'BaanPo1sController@approve'
	]);
	Route::post('baanpo1s/reject', [
		'as' => 'baanpo1s.reject',
		'uses' => 'BaanPo1sController@reject'
	]);
	Route::post('baanpo1s/approvediv', [
		'as' => 'baanpo1s.approvediv',
		'uses' => 'BaanPo1sController@approvediv'
	]);
	Route::post('baanpo1s/rejectdiv', [
		'as' => 'baanpo1s.rejectdiv',
		'uses' => 'BaanPo1sController@rejectdiv'
	]);
	Route::get('baanpo1s/print/{param}', [
		'as' => 'baanpo1s.print',
		'uses' => 'BaanPo1sController@print'
	]);
	Route::get('prc/baanpo1s/downloadfile/{param}', [
		'as' => 'baanpo1s.downloadfile',
		'uses' => 'BaanPo1sController@downloadfile'
	]);
	Route::get('baanpo1s/history/all', [
		'as' => 'baanpo1s.indexhistory',
		'uses'=>'BaanPo1sController@indexhistory'
	]);
	Route::get('baanpo1s/dashboard/history', [
		'as' => 'baanpo1s.dashboardhistory',
		'uses'=>'BaanPo1sController@dashboardhistory'
	]);
	Route::get('baanpo1s/history/{param}/{param2}', [
		'as'=>'baanpo1s.history',
		'uses'=>'BaanPo1sController@history'
	]);
	Route::get('baanpo1s/monitoring/portal', [
		'as' => 'baanpo1s.monitoring',
		'uses'=>'BaanPo1sController@monitoring'
	]);
	Route::get('baanpo1s/dashboard/monitoring', [
		'as' => 'baanpo1s.dashboardmonitoring',
		'uses'=>'BaanPo1sController@dashboardmonitoring'
	]);
	Route::get('baanpo1s/detailmonitoring/{param}/{param2}/{param3}', [
		'as'=>'baanpo1s.detailmonitoring',
		'uses'=>'BaanPo1sController@detailmonitoring'
	]);
	Route::get('baanpo1s/monitoringtotal/portal', [
		'as' => 'baanpo1s.monitoringtotal',
		'uses'=>'BaanPo1sController@monitoringtotal'
	]);
	Route::get('baanpo1s/dashboard/monitoringtotal', [
		'as' => 'baanpo1s.dashboardmonitoringtotal',
		'uses'=>'BaanPo1sController@dashboardmonitoringtotal'
	]);
	Route::get('baanpo1s/dashboard/monitoringtotalpo', [
		'as' => 'baanpo1s.dashboardmonitoringtotalpo',
		'uses'=>'BaanPo1sController@dashboardmonitoringtotalpo'
	]);
	Route::get('baanpo1s/downloadmonitoringtotalpo/{param}/{param2}', [
		'as' => 'baanpo1s.downloadmonitoringtotalpo',
		'uses' => 'BaanPo1sController@downloadmonitoringtotalpo'
	]);
	Route::resource('prcmnpks', 'PrcmNpksController');
	Route::get('dashboard/prcmnpks', [
		'as'=>'dashboard.prcmnpks',
		'uses'=>'PrcmNpksController@dashboard'
	]);
	Route::get('prcmnpks/delete/{param}', [
		'as' => 'prcmnpks.delete',
		'uses' => 'PrcmNpksController@delete'
	]);
	Route::resource('prctssr1s', 'PrctSsr1sController');
	Route::get('dashboard/prctssr1s', [
		'as'=>'dashboard.prctssr1s',
		'uses'=>'PrctSsr1sController@dashboard'
	]);
	Route::get('prctssr1s/detail/{param}', [
		'as'=>'prctssr1s.detail',
		'uses'=>'PrctSsr1sController@detail'
	]);
	Route::get('prctssr1s/delete/{param}', [
		'as' => 'prctssr1s.delete',
		'uses' => 'PrctSsr1sController@delete'
	]);
	Route::post('prctssr1s/approve', [
		'as' => 'prctssr1s.approve',
		'uses' => 'PrctSsr1sController@approve'
	]);
	Route::post('prctssr1s/reject', [
		'as' => 'prctssr1s.reject',
		'uses' => 'PrctSsr1sController@reject'
	]);
	Route::delete('prctssr1s/deletedetail/{param}/{param2}', [
		'as' => 'prctssr1s.deletedetail',
		'uses'=>'PrctSsr1sController@deletedetail'
	]);
	Route::resource('prctrfqs', 'PrctRfqsController');
	Route::get('dashboard/prctrfqs', [
		'as'=>'dashboard.prctrfqs',
		'uses'=>'PrctRfqsController@dashboard'
	]);
	Route::get('prctrfqs/detail/{param}/{param2}/{param3}', [
		'as'=>'prctrfqs.detail',
		'uses'=>'PrctRfqsController@detail'
	]);
	Route::delete('prctrfqs/deletedetail/{param}/{param2}', [
		'as' => 'prctrfqs.deletedetail',
		'uses'=>'PrctRfqsController@deletedetail'
	]);
	Route::get('prctrfqs/modif/{param}/{param2}/{param3}', [
		'as'=>'prctrfqs.modif',
		'uses'=>'PrctRfqsController@modif'
	]);
	Route::match(['put', 'patch'], 'prctrfqs/save/{param}/{param2}/{param3}', [
		'as'=>'prctrfqs.save',
		'uses'=>'PrctRfqsController@save'
	]);
	Route::get('prctrfqs/analisa/{param}/{param2}/{param3}', [
		'as'=>'prctrfqs.analisa',
		'uses'=>'PrctRfqsController@analisa'
	]);
	Route::get('prctrfqs/index/analisa', [
		'as' => 'prctrfqs.indexanalisa',
		'uses'=>'PrctRfqsController@indexanalisa'
	]);
	Route::get('prctrfqs/dashboard/analisa', [
		'as' => 'dashboardanalisa.prctrfqs',
		'uses'=>'PrctRfqsController@dashboardanalisa'
	]);
	Route::get('prctrfqs/showdetail/{param}', [
		'as' => 'prctrfqs.showdetail',
		'uses'=>'PrctRfqsController@showdetail'
	]);
	Route::resource('prctepobpids', 'PrctEpoBpidsController');
	Route::get('dashboard/prctepobpids', [
		'as'=>'dashboard.prctepobpids',
		'uses'=>'PrctEpoBpidsController@dashboard'
	]);
	Route::get('prctepobpids/delete/{param}', [
		'as' => 'prctepobpids.delete',
		'uses' => 'PrctEpoBpidsController@delete'
	]);
	Route::resource('reportpp', 'PrctMonitoringPpController');
	Route::get('reportpp/print/{param}/{param1}/{param2}', [
		'as' => 'reportpp.print',
		'uses' => 'PrctMonitoringPpController@print'
	]);
});

Route::get('prc/baanpo1s/download/{param}/{param2}', [
	'as' => 'baanpo1s.download',
	'uses' => 'BaanPo1sController@download'
]);