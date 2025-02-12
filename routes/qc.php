<?php

Route::group(['prefix' => 'qc', 'middleware' => ['auth']], function () {
	Route::get('qprs/monitoring', [
		'as' => 'qprs.monitoring',
		'uses' => 'QprsController@monitoring'
	]);
	Route::get('qprs/monitoring/{param}/{param2}/{param3}', [
		'as' => 'qprs.monitoring2',
		'uses' => 'QprsController@monitoring2'
	]);
	Route::get('qprs/monitoringprint/{param}/{param2}/{param3}', [
		'as' => 'qprs.monitoringprint',
		'uses' => 'QprsController@monitoringprint'
	]);
	Route::get('qprs/all', [
		'as' => 'qprs.all',
		'uses' => 'QprsController@indexAll'
	]);
	Route::get('qprs/dashboard/all', [
		'as' => 'dashboardall.qprs',
		'uses' => 'QprsController@dashboardAll'
	]);
	Route::get('qprs/bystatus/{param}', [
		'as' => 'qprs.indexbystatus',
		'uses' => 'QprsController@indexbystatus'
	]);
	Route::get('qprs/dashboard/bystatus', [
		'as' => 'dashboardbystatus.qprs',
		'uses' => 'QprsController@dashboardbystatus'
	]);
	Route::get('qprs/showall/{param}', [
		'as' => 'qprs.showall',
		'uses' => 'QprsController@showall'
	]);
	Route::get('picas/all', [
		'as' => 'picas.all',
		'uses' => 'PicasController@indexAll'
	]);
	Route::get('picas/dashboard/all', [
		'as' => 'dashboardall.picas',
		'uses' => 'PicasController@dashboardAll'
	]);
	Route::get('picas/showall/{param}', [
		'as' => 'picas.showall',
		'uses' => 'PicasController@showall'
	]);
	Route::get('picas/bystatus/{param}', [
		'as' => 'picas.indexbystatus',
		'uses' => 'PicasController@indexbystatus'
	]);
	Route::get('picas/dashboard/bystatus', [
		'as' => 'dashboardbystatus.picas',
		'uses' => 'PicasController@dashboardbystatus'
	]);
	Route::resource('qpremails', 'QprEmailsController');
	Route::get('dashboard/qpremails', [
		'as' => 'dashboard.qpremails',
		'uses' => 'QprEmailsController@dashboard'
	]);
	Route::resource('qcmnpks', 'QcmNpksController');
	Route::get('dashboard/qcmnpks', [
		'as' => 'dashboard.qcmnpks',
		'uses' => 'QcmNpksController@dashboard'
	]);
	Route::get('qcmnpks/delete/{param}', [
		'as' => 'qcmnpks.delete',
		'uses' => 'QcmNpksController@delete'
	]);
	Route::resource('alatukur', 'AlatUkurController');
	Route::get('alatukur/print/{param}/{param1}/{param2}/{param3}/{param4}/{param5}/{param6}/{param7}', [
		'as' => 'alatukur.print',
		'uses' => 'AlatUkurController@print'
	]);
	Route::resource('histalatukur', 'Tclbr001tController');
	Route::get('dashboard/histalatukur/{param}/{param1}', [
		'as' => 'histalatukur.dashboard',
		'uses' => 'Tclbr001tController@dashboard'
	]);
	Route::get('create/histalatukur/{param}/{param1}', [
		'as' => 'histalatukur.create',
		'uses' => 'Tclbr001tController@create'
	]);
	Route::get('edit/histalatukur/{param}/{param1}/{param2}', [
		'as' => 'histalatukur.edit',
		'uses' => 'Tclbr001tController@edit'
	]);
	Route::get('histalatukur/{param}/{param1}', [
		'as' => 'histalatukur.indexs',
		'uses' => 'Tclbr001tController@indexs'
	]);
	Route::resource('mstalatukur', 'Tclbr005mController');
	Route::get('dashboard/mstalatukur', [
		'as' => 'mstalatukur.dashboard',
		'uses' => 'Tclbr005mController@dashboard'
	]);
	Route::get('edit/mstalatukur/{param}/{param1}/{param2}', [
		'as' => 'mstalatukur.edit',
		'uses' => 'Tclbr005mController@edit'
	]);
	Route::get('destroy/mstalatukur/{param}/{param1}/{param2}', [
		'as' => 'mstalatukur.destroy',
		'uses' => 'Tclbr005mController@destroy'
	]);
	Route::get('mstalatukur/deleteimage/{param}/{param1}/{param2}', [
		'as' => 'mstalatukur.deleteimage',
		'uses' => 'Tclbr005mController@deleteimage'
	]);
	Route::resource('usulprob', 'UsulProbController');
	Route::get('dashboard/usulprob', [
		'as' => 'dashboard.usulprob',
		'uses' => 'UsulProbController@dashboard'
	]);
	Route::get('usulprob/delete/{param}', [
		'as' => 'usulprob.delete',
		'uses' => 'UsulProbController@delete'
	]);
	Route::resource('pppolpb', 'PpPoLpbController');
	Route::get('dashboard/pppolpb', [
		'as' => 'pppolpb.dashboard',
		'uses' => 'PpPoLpbController@dashboard'
	]);
	Route::get('pppolpb/print/{param}/{param1}', [
		'as' => 'pppolpb.print',
		'uses' => 'PpPoLpbController@print'
	]);
	
});
