<?php

Route::group(['prefix'=>'eng', 'middleware'=>['auth']], function () {
	Route::resource('engttpfc1s', 'EngtTpfc1sController');
	Route::get('dashboard/engttpfc1s', [
		'as'=>'dashboard.engttpfc1s',
		'uses'=>'EngtTpfc1sController@dashboard'
	]);
	Route::get('engttpfc1s/detail/{param}', [
		'as'=>'engttpfc1s.detail',
		'uses'=>'EngtTpfc1sController@detail'
	]);
	Route::get('engttpfc1s/delete/{param}', [
		'as' => 'engttpfc1s.delete',
		'uses' => 'EngtTpfc1sController@delete'
	]);
	Route::delete('engttpfc1s/deletepart/{param}', [
		'as' => 'engttpfc1s.deletepart',
		'uses'=>'EngtTpfc1sController@deletepart'
	]);
	Route::delete('engttpfc1s/deletedetail/{param}', [
		'as' => 'engttpfc1s.deletedetail',
		'uses'=>'EngtTpfc1sController@deletedetail'
	]);
	Route::get('engttpfc1s/deleteimage/{param}/{param2}', [
		'as' => 'engttpfc1s.deleteimage',
		'uses' => 'EngtTpfc1sController@deleteimage'
	]);
	Route::get('engttpfc1s/print/{param}/{param2}', [
		'as' => 'engttpfc1s.print',
		'uses' => 'EngtTpfc1sController@print'
	]);
	Route::post('engttpfc1s/approve', [
		'as' => 'engttpfc1s.approve',
		'uses' => 'EngtTpfc1sController@approve'
	]);
	Route::resource('engtfcm1s', 'EngtFcm1sController');
	Route::get('dashboard/engtfcm1s', [
		'as'=>'dashboard.engtfcm1s',
		'uses'=>'EngtFcm1sController@dashboard'
	]);
	Route::get('engtfcm1s/detailfcm2/{param}', [
		'as'=>'engtfcm1s.detailfcm2',
		'uses'=>'EngtFcm1sController@detailfcm2'
	]);
	Route::get('engtfcm1s/deletefile/{param}', [
		'as' => 'engtfcm1s.deletefile',
		'uses' => 'EngtFcm1sController@deletefile'
	]);
	Route::get('engtfcm1s/deleteimagefcm2/{param}/{param2}/{param3}', [
		'as' => 'engtfcm1s.deleteimagefcm2',
		'uses' => 'EngtFcm1sController@deleteimagefcm2'
	]);
	Route::delete('engtfcm1s/deletefcm2/{param}', [
		'as' => 'engtfcm1s.deletefcm2',
		'uses'=>'EngtFcm1sController@deletefcm2'
	]);
	Route::get('dashboardfcm3/engtfcm1s/{param}', [
		'as'=>'engtfcm1s.dashboardfcm3',
		'uses'=>'EngtFcm1sController@dashboardfcm3'
	]);
	Route::get('detail/engtfcm1s/{param}', [
		'as'=>'engtfcm1s.detailfcm3',
		'uses'=>'EngtFcm1sController@detailfcm3'
	]);
	Route::delete('engtfcm1s/deletefcm3/{param}', [
		'as' => 'engtfcm1s.deletefcm3',
		'uses'=>'EngtFcm1sController@deletefcm3'
	]);
	Route::resource('engtmsimbols', 'EngtMsimbolsController');
	Route::get('dashboard/engtmsimbols', [
		'as'=>'dashboard.engtmsimbols',
		'uses'=>'EngtMsimbolsController@dashboard'
	]);
	Route::get('engtmsimbols/delete/{param}', [
		'as' => 'engtmsimbols.delete',
		'uses' => 'EngtMsimbolsController@delete'
	]);
	Route::resource('engtmplants', 'EngtMplantsController');
	Route::get('dashboard/engtmplants', [
		'as'=>'dashboard.engtmplants',
		'uses'=>'EngtMplantsController@dashboard'
	]);
	Route::get('engtmplants/delete/{param}', [
		'as' => 'engtmplants.delete',
		'uses' => 'EngtMplantsController@delete'
	]);
	Route::resource('engtmlines', 'EngtMlinesController');
	Route::get('dashboard/engtmlines', [
		'as'=>'dashboard.engtmlines',
		'uses'=>'EngtMlinesController@dashboard'
	]);
	Route::get('engtmlines/delete/{param}', [
		'as' => 'engtmlines.delete',
		'uses' => 'EngtMlinesController@delete'
	]);
	Route::resource('engtmcusts', 'EngtMcustsController');
	Route::get('dashboard/engtmcusts', [
		'as'=>'dashboard.engtmcusts',
		'uses'=>'EngtMcustsController@dashboard'
	]);
	Route::get('engtmcusts/delete/{param}', [
		'as' => 'engtmcusts.delete',
		'uses' => 'EngtMcustsController@delete'
	]);	
	Route::resource('engtmmodels', 'EngtMmodelsController');
	Route::get('dashboard/engtmmodels', [
		'as'=>'dashboard.engtmmodels',
		'uses'=>'EngtMmodelsController@dashboard'
	]);
	Route::get('engtmmodels/delete/{param}', [
		'as' => 'engtmmodels.delete',
		'uses' => 'EngtMmodelsController@delete'
	]);
	Route::resource('engtmparts', 'EngtMpartsController');
	Route::get('dashboard/engtmparts', [
		'as'=>'dashboard.engtmparts',
		'uses'=>'EngtMpartsController@dashboard'
	]);
	Route::get('engtmparts/delete/{param}', [
		'as' => 'engtmparts.delete',
		'uses' => 'EngtMpartsController@delete'
	]);	
	Route::resource('engtmmesins', 'EngtMmesinsController');
	Route::get('dashboard/engtmmesins', [
		'as'=>'dashboard.engtmmesins',
		'uses'=>'EngtMmesinsController@dashboard'
	]);
	Route::get('engtmmesins/delete/{param}', [
		'as' => 'engtmmesins.delete',
		'uses' => 'EngtMmesinsController@delete'
	]);	
	Route::resource('engtmdllines', 'EngtMdlLinesController');
	Route::get('dashboard/engtmdllines', [
		'as'=>'dashboard.engtmdllines',
		'uses'=>'EngtMdlLinesController@dashboard'
	]);
	Route::get('engtmdllines/delete/{param}', [
		'as' => 'engtmdllines.delete',
		'uses' => 'EngtMdlLinesController@delete'
	]);
	Route::delete('engtmdllines/destroy/{param}/{param1}', [
		'as'=>'engtmdllines.destroy',
		'uses'=>'EngtMdlLinesController@destroy'
	]);	
	Route::delete('engtmdllines/deleteLine/{param}/{param2}', [
		'as' => 'engtmdllines.deleteLine',
		'uses' => 'EngtMdlLinesController@deleteLine'
	]);
	Route::delete('engtmmodels/destroy/{param}/{param1}', [
		'as'=>'engtmmodels.destroy',
		'uses'=>'EngtMmodelsController@destroy'
	]);	
	Route::delete('engtmmodels/deleteCust/{param}/{param2}', [
		'as' => 'engtmmodels.deleteCust',
		'uses' => 'EngtMmodelsController@deleteCust'
	]);
	Route::get('vwtctperiods/eng/index', [
		'as' => 'vwtctperiods.indexeng',
		'uses'=>'VwTctPeriodsController@indexeng'
	]);
	Route::get('dashboardeng/vwtctperiods', [
		'as'=>'vwtctperiods.dashboardeng',
		'uses'=>'VwTctPeriodsController@dashboardeng'
	]);
	Route::get('vwtctperiods/cekdata/{param}/{param2}/{param3}/{param4}/{param5}', [
		'as'=>'vwtctperiods.cekdata',
		'uses'=>'VwTctPeriodsController@cekdata'
	]);
	Route::post('upload/vwtctperiods', [
		'as' => 'vwtctperiods.upload',
		'uses' => 'VwTctPeriodsController@upload'
	]);
	Route::get('template/vwtctperiods', [
		'as' => 'vwtctperiods.template',
		'uses' => 'VwTctPeriodsController@generateExcelTemplate'
	]);
});