<?php

Route::group(['prefix'=>'budget', 'middleware'=>['auth']], function () {
	Route::resource('bgttkomite1s', 'BgttKomite1sController');
	Route::get('dashboard/bgttkomite1s', [
		'as' => 'dashboard.bgttkomite1s',
		'uses'=>'BgttKomite1sController@dashboard'
	]);
	Route::get('bgttkomite1s/delete/{param}', [
		'as' => 'bgttkomite1s.delete',
		'uses' => 'BgttKomite1sController@delete'
	]);
	Route::get('bgttkomite1sall', [
		'as' => 'bgttkomite1s.all',
		'uses'=>'BgttKomite1sController@indexAll'
	]);
	Route::get('bgttkomite1s/dashboard/all', [
		'as' => 'dashboardall.bgttkomite1s',
		'uses'=>'BgttKomite1sController@dashboardAll'
	]);
	Route::get('bgttkomite1s/detail/{param}', [
		'as'=>'bgttkomite1s.detail',
		'uses'=>'BgttKomite1sController@detail'
	]);
	Route::get('bgttkomite1sallnotulen', [
		'as' => 'bgttkomite1s.allnotulen',
		'uses'=>'BgttKomite1sController@indexNotulen'
	]);
	Route::get('bgttkomite1s/dashboard/allnotulen', [
		'as' => 'dashboardallnotulen.bgttkomite1s',
		'uses'=>'BgttKomite1sController@dashboardNotulen'
	]);
	Route::get('bgttkomite1s/showall/{param}', [
		'as' => 'bgttkomite1s.showall',
		'uses'=>'BgttKomite1sController@showall'
	]);
	Route::get('bgttkomite1s/shownotulen/{param}', [
		'as' => 'bgttkomite1s.shownotulen',
		'uses'=>'BgttKomite1sController@shownotulen'
	]);
	Route::get('bgttkomite1s/{param}/mapping', [
		'as' => 'bgttkomite1s.mapping',
		'uses'=>'BgttKomite1sController@mapping'
	]);
	Route::post('bgttkomite1s/updatemapping/{param}', [
		'as' => 'bgttkomite1s.updatemapping',
		'uses' => 'BgttKomite1sController@updatemapping'
	]);
	Route::get('bgttkomite1s/{param}/notulen', [
		'as' => 'bgttkomite1s.notulen',
		'uses'=>'BgttKomite1sController@notulen'
	]);
	Route::post('bgttkomite1s/updatenotulen/{param}', [
		'as' => 'bgttkomite1s.updatenotulen',
		'uses' => 'BgttKomite1sController@updatenotulen'
	]);
	Route::delete('bgttkomite1s/deletedetail/{param}/{param2}', [
		'as' => 'bgttkomite1s.deletedetail',
		'uses'=>'BgttKomite1sController@deletedetail'
	]);
	Route::post('sendemail/notifikasi', [
		'as' => 'bgttkomite1s.sendemail',
		'uses' => 'BgttKomite1sController@sendemail'
	]);
	Route::get('bgttkomite1s/showrevisi/{param}/{param2}', [
		'as' => 'bgttkomite1s.showrevisi',
		'uses'=>'BgttKomite1sController@showrevisi'
	]);
	Route::post('bgttkomite1s/approve', [
		'as' => 'bgttkomite1s.approve',
		'uses' => 'BgttKomite1sController@approve'
	]);
	Route::get('bgttkomite1s/downloadfile/{param}', [
		'as' => 'bgttkomite1s.downloadfile',
		'uses' => 'BgttKomite1sController@downloadfile'
	]);
	Route::get('bgttkomite1s/deletefile/{param}', [
		'as' => 'bgttkomite1s.deletefile',
		'uses' => 'BgttKomite1sController@deletefile'
	]);
	Route::get('bgttkomite1s/print/{param}/{param2}', [
		'as' => 'bgttkomite1s.print',
		'uses' => 'BgttKomite1sController@print'
	]);
	Route::resource('bgttcrrates', 'BgttCrRatesController');
	Route::get('dashboard/bgttcrrates', [
		'as' => 'bgttcrrates.dashboard',
		'uses'=>'BgttCrRatesController@dashboard'
	]);
	Route::get('bgttcrrates/delete/{param}', [
		'as' => 'bgttcrrates.delete',
		'uses' => 'BgttCrRatesController@delete'
	]);
	Route::resource('bgttcrklasifis', 'BgttCrKlasifisController');
	Route::get('dashboard/bgttcrklasifis', [
		'as' => 'bgttcrklasifis.dashboard',
		'uses'=>'BgttCrKlasifisController@dashboard'
	]);
	Route::get('bgttcrklasifis/delete/{param}', [
		'as' => 'bgttcrklasifis.delete',
		'uses' => 'BgttCrKlasifisController@delete'
	]);
	Route::resource('bgttcrkategors', 'BgttCrKategorsController');
	Route::get('dashboard/bgttcrkategors', [
		'as' => 'bgttcrkategors.dashboard',
		'uses'=>'BgttCrKategorsController@dashboard'
	]);
	Route::get('bgttcrkategors/delete/{param}', [
		'as' => 'bgttcrkategors.delete',
		'uses' => 'BgttCrKategorsController@delete'
	]);
	Route::resource('bgttcrregiss', 'BgttCrRegissController');
	Route::get('dashboard/bgttcrregiss', [
		'as' => 'bgttcrregiss.dashboard',
		'uses'=>'BgttCrRegissController@dashboard'
	]);
	Route::get('bgttcrregiss/detail/{param}', [
		'as'=>'bgttcrregiss.detail',
		'uses'=>'BgttCrRegissController@detail'
	]);
	Route::get('bgttcrregiss/detailrevisi/{param}', [
		'as'=>'bgttcrregiss.detailrevisi',
		'uses'=>'BgttCrRegissController@detailrevisi'
	]);
	Route::get('bgttcrregiss/delete/{param}', [
		'as' => 'bgttcrregiss.delete',
		'uses' => 'BgttCrRegissController@delete'
	]);
	Route::get('indexdep/bgttcrregiss', [
		'as' => 'bgttcrregiss.indexdep',
		'uses'=>'BgttCrRegissController@indexdep'
	]);
	Route::get('dashboarddep/bgttcrregiss', [
		'as' => 'bgttcrregiss.dashboarddep',
		'uses'=>'BgttCrRegissController@dashboarddep'
	]);
	Route::get('indexdiv/bgttcrregiss', [
		'as' => 'bgttcrregiss.indexdiv',
		'uses'=>'BgttCrRegissController@indexdiv'
	]);
	Route::get('dashboarddiv/bgttcrregiss', [
		'as' => 'bgttcrregiss.dashboarddiv',
		'uses'=>'BgttCrRegissController@dashboarddiv'
	]);
	Route::get('indexbudget/bgttcrregiss', [
		'as' => 'bgttcrregiss.indexbudget',
		'uses'=>'BgttCrRegissController@indexbudget'
	]);
	Route::get('dashboardbudget/bgttcrregiss', [
		'as' => 'bgttcrregiss.dashboardbudget',
		'uses'=>'BgttCrRegissController@dashboardbudget'
	]);
	Route::post('bgttcrregiss/approvedep', [
		'as' => 'bgttcrregiss.approvedep',
		'uses' => 'BgttCrRegissController@approvedep'
	]);
	Route::post('bgttcrregiss/rejectdep', [
		'as' => 'bgttcrregiss.rejectdep',
		'uses' => 'BgttCrRegissController@rejectdep'
	]);
	Route::post('bgttcrregiss/approvediv', [
		'as' => 'bgttcrregiss.approvediv',
		'uses' => 'BgttCrRegissController@approvediv'
	]);
	Route::post('bgttcrregiss/rejectdiv', [
		'as' => 'bgttcrregiss.rejectdiv',
		'uses' => 'BgttCrRegissController@rejectdiv'
	]);
	Route::post('bgttcrregiss/approvebudget', [
		'as' => 'bgttcrregiss.approvebudget',
		'uses' => 'BgttCrRegissController@approvebudget'
	]);
	Route::post('bgttcrregiss/rejectbudget', [
		'as' => 'bgttcrregiss.rejectbudget',
		'uses' => 'BgttCrRegissController@rejectbudget'
	]);
	Route::get('bgttcrregiss/showdep/{param}', [
		'as' => 'bgttcrregiss.showdep',
		'uses'=>'BgttCrRegissController@showdep'
	]);
	Route::get('bgttcrregiss/showdiv/{param}', [
		'as' => 'bgttcrregiss.showdiv',
		'uses'=>'BgttCrRegissController@showdiv'
	]);
	Route::get('bgttcrregiss/showbudget/{param}', [
		'as' => 'bgttcrregiss.showbudget',
		'uses'=>'BgttCrRegissController@showbudget'
	]);
	Route::get('bgttcrregiss/showrevisi/{param}', [
		'as' => 'bgttcrregiss.showrevisi',
		'uses'=>'BgttCrRegissController@showrevisi'
	]);
	Route::get('bgttcrregiss/updatestatusperiode/{param}', [
		'as' => 'bgttcrregiss.periode',
		'uses' => 'BgttCrRegissController@periode'
	]);
	Route::resource('bgttcrsubmits', 'BgttCrSubmitsController');
	Route::get('dashboard/bgttcrsubmits', [
		'as' => 'bgttcrsubmits.dashboard',
		'uses'=>'BgttCrSubmitsController@dashboard'
	]);
	Route::get('bgttcrsubmits/detail/{param}', [
		'as'=>'bgttcrsubmits.detail',
		'uses'=>'BgttCrSubmitsController@detail'
	]);
	Route::get('bgttcrsubmits/detailrevisi/{param}', [
		'as'=>'bgttcrsubmits.detailrevisi',
		'uses'=>'BgttCrSubmitsController@detailrevisi'
	]);
	Route::get('bgttcrsubmits/delete/{param}', [
		'as' => 'bgttcrsubmits.delete',
		'uses' => 'BgttCrSubmitsController@delete'
	]);
	Route::get('indexdep/bgttcrsubmits', [
		'as' => 'bgttcrsubmits.indexdep',
		'uses'=>'BgttCrSubmitsController@indexdep'
	]);
	Route::get('dashboarddep/bgttcrsubmits', [
		'as' => 'bgttcrsubmits.dashboarddep',
		'uses'=>'BgttCrSubmitsController@dashboarddep'
	]);
	Route::get('indexdiv/bgttcrsubmits', [
		'as' => 'bgttcrsubmits.indexdiv',
		'uses'=>'BgttCrSubmitsController@indexdiv'
	]);
	Route::get('dashboarddiv/bgttcrsubmits', [
		'as' => 'bgttcrsubmits.dashboarddiv',
		'uses'=>'BgttCrSubmitsController@dashboarddiv'
	]);
	Route::get('indexbudget/bgttcrsubmits', [
		'as' => 'bgttcrsubmits.indexbudget',
		'uses'=>'BgttCrSubmitsController@indexbudget'
	]);
	Route::get('dashboardbudget/bgttcrsubmits', [
		'as' => 'bgttcrsubmits.dashboardbudget',
		'uses'=>'BgttCrSubmitsController@dashboardbudget'
	]);
	Route::post('bgttcrsubmits/approvedep', [
		'as' => 'bgttcrsubmits.approvedep',
		'uses' => 'BgttCrSubmitsController@approvedep'
	]);
	Route::post('bgttcrsubmits/rejectdep', [
		'as' => 'bgttcrsubmits.rejectdep',
		'uses' => 'BgttCrSubmitsController@rejectdep'
	]);
	Route::post('bgttcrsubmits/approvediv', [
		'as' => 'bgttcrsubmits.approvediv',
		'uses' => 'BgttCrSubmitsController@approvediv'
	]);
	Route::post('bgttcrsubmits/rejectdiv', [
		'as' => 'bgttcrsubmits.rejectdiv',
		'uses' => 'BgttCrSubmitsController@rejectdiv'
	]);
	Route::post('bgttcrsubmits/approvebudget', [
		'as' => 'bgttcrsubmits.approvebudget',
		'uses' => 'BgttCrSubmitsController@approvebudget'
	]);
	Route::post('bgttcrsubmits/rejectbudget', [
		'as' => 'bgttcrsubmits.rejectbudget',
		'uses' => 'BgttCrSubmitsController@rejectbudget'
	]);
	Route::get('bgttcrsubmits/showdep/{param}', [
		'as' => 'bgttcrsubmits.showdep',
		'uses'=>'BgttCrSubmitsController@showdep'
	]);
	Route::get('bgttcrsubmits/showdiv/{param}', [
		'as' => 'bgttcrsubmits.showdiv',
		'uses'=>'BgttCrSubmitsController@showdiv'
	]);
	Route::get('bgttcrsubmits/showbudget/{param}', [
		'as' => 'bgttcrsubmits.showbudget',
		'uses'=>'BgttCrSubmitsController@showbudget'
	]);
	Route::get('bgttcrsubmits/showrevisi/{param}', [
		'as' => 'bgttcrsubmits.showrevisi',
		'uses'=>'BgttCrSubmitsController@showrevisi'
	]);
	Route::get('bgttcrsubmits/updatestatusperiode/{param}/{param2}', [
		'as' => 'bgttcrsubmits.periode',
		'uses' => 'BgttCrSubmitsController@periode'
	]);
	Route::get('indexreport/bgttcrsubmits', [
		'as' => 'bgttcrsubmits.report',
		'uses'=>'BgttCrSubmitsController@report'
	]);
	Route::get('dashboardreport/bgttcrsubmits', [
		'as' => 'bgttcrsubmits.dashboardreport',
		'uses'=>'BgttCrSubmitsController@dashboardreport'
	]);
	Route::get('dashboardreportdetail/bgttcrsubmits/{param}/{param2}/{param3}', [
		'as' => 'bgttcrsubmits.dashboardreportdetail',
		'uses'=>'BgttCrSubmitsController@dashboardreportdetail'
	]);
	Route::get('indexgrafik/bgttcrsubmits/{param?}/{param2?}', [
		'as' => 'bgttcrsubmits.indexgrafik',
		'uses'=>'BgttCrSubmitsController@indexgrafik'
	]);
	Route::get('indexdashboard/bgttcrsubmits/{param?}/{param2?}', [
		'as' => 'bgttcrsubmits.indexdashboard',
		'uses'=>'BgttCrSubmitsController@indexdashboard'
	]);
	Route::get('indexreportclassification/bgttcrsubmits', [
		'as' => 'bgttcrsubmits.reportclassification',
		'uses'=>'BgttCrSubmitsController@reportclassification'
	]);
	Route::get('dashboardreportclassification/bgttcrsubmits', [
		'as' => 'bgttcrsubmits.dashboardreportclassification',
		'uses'=>'BgttCrSubmitsController@dashboardreportclassification'
	]);
	Route::get('dashboardreportclassificationdetail/bgttcrsubmits/{param}/{param2}/{param3}', [
		'as' => 'bgttcrsubmits.dashboardreportclassificationdetail',
		'uses'=>'BgttCrSubmitsController@dashboardreportclassificationdetail'
	]);
	Route::get('indexreportcategories/bgttcrsubmits', [
		'as' => 'bgttcrsubmits.reportcategories',
		'uses'=>'BgttCrSubmitsController@reportcategories'
	]);
	Route::get('dashboardreportcategories/bgttcrsubmits', [
		'as' => 'bgttcrsubmits.dashboardreportcategories',
		'uses'=>'BgttCrSubmitsController@dashboardreportcategories'
	]);
	Route::get('dashboardreportcategoriesdetail/bgttcrsubmits/{param}/{param2}/{param3}', [
		'as' => 'bgttcrsubmits.dashboardreportcategoriesdetail',
		'uses'=>'BgttCrSubmitsController@dashboardreportcategoriesdetail'
	]);
});