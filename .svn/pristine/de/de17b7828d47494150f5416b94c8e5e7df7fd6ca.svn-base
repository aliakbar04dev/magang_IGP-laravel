<?php

Route::group(['prefix' => 'hr', 'middleware' => ['auth']], function () {
	Route::get('pengajuancuti/daftarpengajuancuti', [
		'as' => 'pengajuancuti.daftarpengajuancuti',
		'uses' => 'PengajuanCutiController@indexPengajuanCuti'
	]);
	Route::get('pengajuancuti/listpengajuancuti', [
		'as' => 'pengajuancuti.listpengajuancuti',
		'uses' => 'PengajuanCutiController@listpengajuancuti'
	]);
	Route::get('pengajuancuti/checkAtasan', [
		'as' => 'pengajuancuti.checkAtasan',
		'uses' => 'PengajuanCutiController@checkAtasan'
	]);
	Route::get('pengajuancuti/listkode_cuti', [
		'as' => 'pengajuancuti.listkode_cuti',
		'uses' => 'PengajuanCutiController@listkode_cuti'
	]);
	Route::post('pengajuancuti/submit', [
		'as' => 'pengajuancuti.submit',
		'uses' => 'PengajuanCutiController@submit'
	]);
	Route::post('pengajuancuti/takeatasan', [
		'as' => 'pengajuancuti.takeatasan',
		'uses' => 'PengajuanCutiController@takeatasan'
	]);
	Route::get('pengajuancuti/viewdetails', [
		'as' => 'pengajuancuti.viewdetails',
		'uses' => 'PengajuanCutiController@viewdetails'
	]);
	Route::get('pengajuancuti/listdetail/{params}', [
		'as' => 'pengajuancuti.listdetail',
		'uses' => 'PengajuanCutiController@listdetail'
	]);
	Route::get('pengajuancuti/detailpengajuancuti/{params}', [
		'as' => 'pengajuancuti.detailpengajuancuti',
		'uses' => 'PengajuanCutiController@detailpengajuancuti'
	]);
	Route::post('pengajuancuti/cetak', [
		'as' => 'pengajuancuti.cetak',
		'uses' => 'PengajuanCutiController@cetak'
	]);
	Route::post('pengajuancuti/destroy', [
		'as' => 'pengajuancuti.destroy',
		'uses' => 'PengajuanCutiController@destroy'
	]);
});
