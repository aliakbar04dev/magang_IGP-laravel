<?php

Route::group(['prefix'=>'telegram'], function () {
	Route::get('botigps', [
		'as' => 'botigps.index',
		'uses' => 'BotIgpsController@index'
	]);
	Route::post('botigps/webhooks', [
		'as' => 'botigps.webhooks',
		'uses'=>'BotIgpsController@webhooks'
	]);
	Route::post('botigps/webhooks2', [
		'as' => 'botigps.webhooks2',
		'uses'=>'BotIgpsController@webhooks2'
	]);
});