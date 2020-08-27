<?php

Route::group(['prefix'=>'workorders', 'middleware'=>['auth']], function () {

	Route::get('viewdaftar',
	['uses'=>'OrdersController@ViewDaftar','as'=>'view.daftar']);

	Route::get('viewpengajuan',
	['uses'=>'OrdersController@ViewPengajuan','as'=>'view.pengajuan']);

	Route::post('storepengajuan',
	['uses'=>'OrdersController@ProsesPengajuan','as'=>'store.pengajuan']);

	Route::get('viewapproval',
	['uses'=>'OrdersController@ViewApproval','as'=>'view.approval']);

	Route::get('viewmonitoring',
	['uses'=>'OrdersController@ViewMonitoring','as'=>'view.monitoring']);

	Route::post('prosesselesai',
	['uses'=>'OrdersController@ProsesSelesai','as'=>'proses.selesai']);

	Route::post('viewapproval/acc',
	['uses'=>'OrdersController@ViewApprovalSetujui','as'=>'view.approval_acc']);

	Route::post('viewapproval/decline',
	['uses'=>'OrdersController@ViewApprovalTolak','as'=>'view.approval_decline']);

	Route::post('viewapproval/accIT',
	['uses'=>'OrdersController@ViewApprovalSetujuiIT','as'=>'view.approval_accIT']);

	Route::post('viewapproval/declineIT',
	['uses'=>'OrdersController@ViewApprovalTolakIT','as'=>'view.approval_declineIT']);

	Route::get('viewapprovalIT',
	['uses'=>'OrdersController@ViewApprovalIT','as'=>'view.approvalit']);

	Route::get('getdetail/{nowo}',
	['uses'=>'OrdersController@Detail','as'=>'get.detail']);

	Route::get('atasanbelumapproval',
	['uses'=>'OrdersController@AtasanBelum','as'=>'atasan.belum']);

	Route::get('atasansudahapproval',
	['uses'=>'OrdersController@AtasanSudah','as'=>'atasan.sudah']);

	Route::get('atasantolakapproval',
	['uses'=>'OrdersController@AtasanTolak','as'=>'atasan.tolak']);

	Route::get('ITbelumapproval',
	['uses'=>'OrdersController@ITBelum','as'=>'IT.belum']);

	Route::get('ITsudahapproval',
	['uses'=>'OrdersController@ITSudah','as'=>'IT.sudah']);

	Route::get('ITtolakapproval',
	['uses'=>'OrdersController@ITTolak','as'=>'IT.tolak']);

	Route::get('sudahclosing',
	['uses'=>'OrdersController@SudahClosing','as'=>'sudah.closing']);
});
