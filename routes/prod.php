<?php

Route::group(['prefix'=>'prod', 'middleware'=>['auth']], function () {	
	
	Route::resource('prodpos', 'ProdPosController');
	Route::get('dashboard/prodpos', [
		'as'=>'prodpos.dashboard',
		'uses'=>'ProdPosController@dashboard'
	]);
	Route::get('prodpos/edit/{param}', [
		'as' => 'prodpos.edit',
		'uses' => 'ProdPosController@edit'
	]);
	Route::get('prodpos/dropdownMesin/{param}', [
		'as' => 'prodpos.dropdownMesin',
		'uses' => 'ProdPosController@dropdownMesin'
	]);
	Route::get('prodpos/showdetail/{param}/{param1}/{param2}/{param3}/{param4}', [
		'as' => 'prodpos.showdetail',
		'uses' => 'ProdPosController@showDetail'
	]);
	Route::get('prodpos/destroy/{param}', [
		'as' => 'prodpos.destroy',
		'uses' => 'ProdPosController@destroy'
	]);

	Route::resource('prodskill', 'ProdSkillController');
	Route::get('dashboard/prodskill', [
		'as'=>'prodskill.dashboard',
		'uses'=>'ProdSkillController@dashboard'
	]);
	Route::get('prodskill/edit/{param}', [
		'as' => 'prodskill.edit',
		'uses' => 'ProdSkillController@edit'
	]);
	Route::get('prodskill/dropdownMesin/{param}', [
		'as' => 'prodskill.dropdownMesin',
		'uses' => 'ProdSkillController@dropdownMesin'
	]);
	Route::get('prodskill/showdetail/{param}/{param1}/{param2}/{param3}/{param4}', [
		'as' => 'prodskill.showdetail',
		'uses' => 'ProdSkillController@showDetail'
	]);
	Route::get('prodskill/destroy/{param}', [
		'as' => 'prodskill.destroy',
		'uses' => 'ProdSkillController@destroy'
	]);

	Route::resource('prodsaldo', 'ProdSaldoController');
	Route::get('prodsaldo/index', [
		'as'=>'prodsaldo.index',
		'uses'=>'ProdSaldoController@index'
	]);

	Route::resource('prodlhp', 'Tlhpn01Controller');
	Route::get('dashboard/prodlhp', [
		'as'=>'prodlhp.dashboard',
		'uses'=>'Tlhpn01Controller@dashboard'
	]);
	Route::get('prodlhp/delete/{param}', [
		'as' => 'prodlhp.delete',
		'uses' => 'Tlhpn01Controller@delete'
	]);
	Route::get('prodlhp/hapus/{param}/{param1}/{param2}', [
		'as' => 'prodlhp.hapus',
		'uses' => 'Tlhpn01Controller@hapus'
	]);
	Route::get('prodlhp/hapusdetail/{param}', [
		'as' => 'prodlhp.hapusdetail',
		'uses' => 'Tlhpn01Controller@hapusdetail'
	]);
	Route::get('prodlhp/hapusls/{param}/{param1}', [
		'as' => 'prodlhp.hapusls',
		'uses' => 'Tlhpn01Controller@hapusls'
	]);
	Route::get('prodlhp/hapusdetails/{param}', [
		'as' => 'prodlhp.hapusdetails',
		'uses' => 'Tlhpn01Controller@hapusdetails'
	]);
	Route::get('prodlhp/getMenitLhp/{param}/{param1}/{param2}', [
		'as' => 'prodlhp.getMenitLhp',
		'uses' => 'Tlhpn01Controller@getMenitLhp'
	]);
	Route::get('prodlhp/getJmlLs/{param}', [
		'as' => 'prodlhp.getJmlLs',
		'uses' => 'Tlhpn01Controller@getJmlLs'
	]);
	Route::get('prodlhp/getWorkingTime/{param}/{param1}/{param2}', [
		'as' => 'prodlhp.getWorkingTime',
		'uses' => 'Tlhpn01Controller@getWorkingTime'
	]);

	Route::resource('prodparamharden', 'ProdParamHardensController');
	Route::get('dashboard/prodparamharden', [
		'as'=>'prodparamharden.dashboard',
		'uses'=>'ProdParamHardensController@dashboard'
	]);
	Route::get('getDataSqlServ/prodparamharden', [
		'as'=>'prodparamharden.getdatasqlserv',
		'uses'=>'ProdParamHardensController@getDataSqlServ'
	]);
	Route::get('deletenodoc/prodparamharden/{param}', [
		'as'=>'prodparamharden.deletenodoc',
		'uses'=>'ProdParamHardensController@deletenodoc'
	]);

	Route::resource('prodnpks', 'ProdNpksController');
	Route::get('dashboard/prodnpks', [
		'as' => 'dashboard.prodnpks',
		'uses' => 'ProdNpksController@dashboard'
	]);
	Route::get('prodnpks/delete/{param}', [
		'as' => 'prodnpks.delete',
		'uses' => 'ProdNpksController@delete'
	]);
});