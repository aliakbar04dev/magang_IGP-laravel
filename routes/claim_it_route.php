<?php

Route::group(['prefix'=>'user', 'middleware'=>['auth']], function () {
	Route::get('daftar', 
    ['uses'=>'ClaimITController@DaftarClaimUser','as'=>'user.daftar']);

    Route::post('proses', 
    ['uses'=>'ClaimITController@ProsesSubmit','as'=>'proses.submit']);

    Route::post('hapus', 
	['uses'=>'ClaimITController@ProsesHapus','as'=>'user.hapus']);
 
});

Route::group(['prefix'=>'staff', 'middleware'=>['auth']], function () {
	Route::get('daftar', 
    ['uses'=>'ClaimITController@DaftarClaimStaff','as'=>'staff.daftar']);
});



