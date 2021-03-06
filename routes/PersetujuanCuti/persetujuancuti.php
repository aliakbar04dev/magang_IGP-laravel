<?php

Route::group(['prefix' => 'hr', 'middleware' => ['auth']], function () {
	Route::get('persetujuancuti/daftarpersetujuancuti', [
		'as' => 'persetujuancuti.daftarpersetujuancuti',
		'uses' => 'PersetujuanCutiController@indexPersetujuanCuti'
	]);
	Route::get('persetujuancuti/listpersetujuancuti', [
		'as' => 'persetujuancuti.listpersetujuancuti',
		'uses' => 'PersetujuanCutiController@listpersetujuancuti'
	]);
	Route::get('persetujuancuti/viewdetails', [
		'as' => 'persetujuancuti.viewdetails',
		'uses' => 'PersetujuanCutiController@viewdetails'
	]);
	Route::get('persetujuancuti/listpengajuancuti/{params}', [
		'as' => 'persetujuancuti.listpengajuancuti',
		'uses' => 'PersetujuanCutiController@listpengajuancuti'
	]);
	Route::post('persetujuancuti/approve', [
		'as' => 'persetujuancuti.approve',
		'uses' => 'PersetujuanCutiController@approve'
	]);
	Route::post('persetujuancuti/decline', [
		'as' => 'persetujuancuti.decline',
		'uses' => 'PersetujuanCutiController@decline'
	]);
	Route::post('persetujuancuti/edit', [
		'as' => 'persetujuancuti.edit',
		'uses' => 'PersetujuanCutiController@edit'
	]);
});
