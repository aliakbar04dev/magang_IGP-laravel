<?php 


Route::group(['prefix' => 'securityonline', 'middleware' => ['auth']], function() {
    
	Route::get('mobile/security', [
		'as' => 'mobiles.index',
		'uses' => 'SecurityController@index'
	]);

	Route::get('mobile/security/dashboard', [
		'as' => 'mobiles.dashboard',
		'uses' => 'SecurityController@dashboard'
	]);

	Route::get('mobile/showimp/{param}', [
		'as' => 'mobiles.showimp',
		'uses' => 'SecurityController@showimp'
	]);



	Route::get('mobile/security/{param}/jamgate', [
		'as' => 'mobiles.isijamgate',
		'uses' => 'SecurityController@isijamgate'
	]);



});