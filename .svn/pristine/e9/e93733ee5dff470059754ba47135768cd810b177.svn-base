<?php

Route::group(['prefix'=>'it', 'middleware'=>['auth']], function () {
	Route::resource('wos', 'WorkOrdersController');
	Route::get('dashboard/wos', [
		'as'=>'dashboard.wos',
		'uses'=>'WorkOrdersController@dashboard'
	]);
	Route::get('wos/delete/{param}', [
		'as' => 'wos.delete',
		'uses' => 'WorkOrdersController@delete'
	]);
	Route::get('showapp/wos/{param}', [
		'as' => 'wos.showapp',
		'uses'=>'WorkOrdersController@showapp'
	]);
	Route::get('approval/wos', [
		'as' => 'wos.approval',
		'uses'=>'WorkOrdersController@indexapproval'
	]);
	Route::get('dashboardapproval/wos', [
		'as'=>'wos.dashboardapproval',
		'uses'=>'WorkOrdersController@dashboardapproval'
	]);
	Route::get('wos/approve/{param}/{param2}', [
		'as' => 'wos.approve',
		'uses' => 'WorkOrdersController@approve'
	]);
	Route::get('wos/unapprove/{param}/{param2}', [
		'as' => 'wos.unapprove',
		'uses' => 'WorkOrdersController@unapprove'
	]);
	Route::get('solusi/wos/{param}', [
		'as' => 'wos.solusi',
		'uses'=>'WorkOrdersController@solusi'
	]);
	Route::get('wos/updatesolusi/{param}', [
		'as' => 'wos.updatesolusi',
		'uses'=>'WorkOrdersController@updatesolusi'
	]);
	Route::get('wos/itselesai/{param}/{param2}', [
		'as' => 'wos.itselesai',
		'uses'=>'WorkOrdersController@itselesai'
	]);
	Route::get('wos/userselesai/{param}/{param2}', [
		'as' => 'wos.userselesai',
		'uses'=>'WorkOrdersController@userselesai'
	]);
	Route::get('wos/printwo/{param}', [
		'as' => 'wos.printwo',
		'uses' => 'WorkOrdersController@printwo'
	]);
});