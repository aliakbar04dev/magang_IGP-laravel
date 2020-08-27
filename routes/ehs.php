<?php

Route::group(['prefix'=>'ehs', 'middleware'=>['auth']], function () {
	Route::get('ehstwp1s/all', [
		'as' => 'ehstwp1s.all',
		'uses'=>'EhstWp1sController@indexAll'
	]);
	Route::get('ehstwp1s/dashboard/all', [
		'as' => 'dashboardall.ehstwp1s',
		'uses'=>'EhstWp1sController@dashboardAll'
	]);
	Route::get('ehstwp1s/showall/{param}', [
		'as' => 'ehstwp1s.showall',
		'uses'=>'EhstWp1sController@showall'
	]);
	Route::post('ehstwp1s/reject', [
		'as' => 'ehstwp1s.reject',
		'uses' => 'EhstWp1sController@reject'
	]);
	Route::post('ehstwp1s/approve', [
		'as' => 'ehstwp1s.approve',
		'uses' => 'EhstWp1sController@approve'
	]);
	Route::post('ehstwp1s/approveehs', [
		'as' => 'ehstwp1s.approveehs',
		'uses' => 'EhstWp1sController@approveehs'
	]);
	Route::get('ehstwp1s/print/{param}', [
		'as' => 'ehstwp1s.print',
		'uses' => 'EhstWp1sController@print'
	]);
	Route::resource('ehsmwppics', 'EhsmWpPicsController');
	Route::get('dashboard/ehsmwppics', [
		'as'=>'dashboard.ehsmwppics',
		'uses'=>'EhsmWpPicsController@dashboard'
	]);
	Route::get('ehsmwppics/delete/{param}', [
		'as' => 'ehsmwppics.delete',
		'uses' => 'EhsmWpPicsController@delete'
	]);
	Route::resource('mgmtgembaehss', 'MgmtGembaEhssController');
	Route::get('dashboard/mgmtgembaehss', [
		'as'=>'dashboard.mgmtgembaehss',
		'uses'=>'MgmtGembaEhssController@dashboard'
	]);
	Route::get('mgmtgembaehss/cm/all', [
		'as'=>'mgmtgembaehss.indexcm',
		'uses'=>'MgmtGembaEhssController@indexcm'
	]);
	Route::get('dashboardcm/mgmtgembaehss', [
		'as'=>'dashboardcm.mgmtgembaehss',
		'uses'=>'MgmtGembaEhssController@dashboardcm'
	]);
	Route::get('mgmtgembaehss/{param}/cm', [
		'as'=>'mgmtgembaehss.inputcm',
		'uses'=>'MgmtGembaEhssController@inputcm'
	]);
	Route::get('mgmtgembaehss/showcm/{param}', [
		'as' => 'mgmtgembaehss.showcm',
		'uses'=>'MgmtGembaEhssController@showcm'
	]);
	Route::get('mgmtgembaehss/delete/{param}', [
		'as' => 'mgmtgembaehss.delete',
		'uses' => 'MgmtGembaEhssController@delete'
	]);
	Route::get('mgmtgembaehss/deleteimage/{param}/{param2}', [
		'as' => 'mgmtgembaehss.deleteimage',
		'uses' => 'MgmtGembaEhssController@deleteimage'
	]);
	Route::get('mgmtgembaehss/laporan/print', [
		'as' => 'mgmtgembaehss.laporan',
		'uses'=>'MgmtGembaEhssController@laporan'
	]);
	Route::get('mgmtgembaehss/printlaporan/{param}/{param2}/{param3}/{param4}/{param5}', [
		'as' => 'mgmtgembaehss.printlaporan',
		'uses' => 'MgmtGembaEhssController@printlaporan'
	]);

	//MAGANG S
	// ROUTE EHS SAFETY PERFORMANCE (ACCIDENT) //
	Route::get('sp/accident/', [
		'as' => 'ehsspaccidents.index_sp_accident',
		'uses'=>'EhsSpAccidentsController@index_sp_accident'
	]);
	Route::get('sp/accident/dashboard', [
		'as' => 'ehsspaccidents.dashboard_sp_accident',
		'uses'=>'EhsSpAccidentsController@dashboard_sp_accident'
	]);
	Route::post('sp/accident/store', [
		'as' => 'ehsspaccidents.store_sp_accident',
		'uses'=>'EhsSpAccidentsController@store_sp_accident'
	]);
	Route::get('sp/accident/grafik', [
		'as' => 'ehsspaccidents.grafik_sp_accident',
		'uses'=>'EhsSpAccidentsController@grafik_sp_accident'
	]);
	// ROUTE SWAPANATU //
	Route::resource('ehsspaccidents', 'EhsEnvPerfController'); 
	Route::get('ep/swapantau/', [
		'as' => 'ehsspaccidents.index_swapantau',
		'uses'=>'EhsEnvPerfController@index_swapantau'
	]);
	Route::post('ep/swapantau/store', [
		'as' => 'ehsspaccidents.store_swapantau',
		'uses'=>'EhsEnvPerfController@store_swapantau'
	]);
	Route::get('ep/swapantau/dashboard', [
		'as' => 'ehsspaccidents.dashboard_swapantau',
		'uses'=>'EhsEnvPerfController@dashboard_swapantau'
	]);
	Route::get('/ep/swapantau/delete/{param}', [
		'as' => 'ehsspaccidents.delete_swapantau',
		'uses'=>'EhsEnvPerfController@delete_swapantau'
	]);
	// ROUTE INSTALASI AIR LIMBAH //
	Route::get('ep/lvlairlimbah', [
		'as' => 'ehsspaccidents.index_lvlairlimbah',
		'uses'=>'EhsEnvPerfController@index_lvlairlimbah'
	]);
	Route::post('ep/lvlairlimbah/store', [
		'as' => 'ehsspaccidents.store_lvlairlimbah',
		'uses'=>'EhsEnvPerfController@store_lvlairlimbah'
	]);
	Route::get('ep/lvlairlimbah/dashboard', [
		'as' => 'ehsspaccidents.dashboard_lvlairlimbah',
		'uses'=>'EhsEnvPerfController@dashboard_lvlairlimbah'
	]);
	Route::get('ep/lvlairlimbah/delete/{param}/{param2}', [
		'as' => 'ehsspaccidents.delete_lvlairlimbah',
		'uses'=>'EhsEnvPerfController@delete_lvlairlimbah'
	]);
	// ROUTE PEMAKAIAN BAHAN KIMIA //
	Route::get('ep/pbhnkimia', [
		'as' => 'ehsspaccidents.index_pbhnkimia',
		'uses'=>'EhsEnvPerfController@index_pbhnkimia'
	]);
	Route::post('ep/pbhnkimia/store', [
		'as' => 'ehsspaccidents.store_pbhnkimia',
		'uses'=>'EhsEnvPerfController@store_pbhnkimia'
	]);
	Route::get('ep/pbhnkimia/dashboard', [
		'as' => 'ehsspaccidents.dashboard_pbhnkimia',
		'uses'=>'EhsEnvPerfController@dashboard_pbhnkimia'
	]);
	Route::get('ep/pbhnkimia/delete/{param}/{param2}', [
		'as' => 'ehsspaccidents.delete_pbhnkimia',
		'uses'=>'EhsEnvPerfController@delete_pbhnkimia'
	]);
	// ROUTE PENGANGKUTAN LIMBAH B3 //
	Route::get('ep/angkutlimb3', [
		'as' => 'ehsspaccidents.index_angkutlimb3',
		'uses'=>'EhsEnvPerfController@index_angkutlimb3'
	]);
	Route::post('ep/angkutlimb3/store', [
		'as' => 'ehsspaccidents.store_angkutlimb3',
		'uses'=>'EhsEnvPerfController@store_angkutlimb3'
	]);
	Route::get('ep/angkutlimb3/dashboard', [
		'as' => 'ehsspaccidents.dashboard_angkutlimb3',
		'uses'=>'EhsEnvPerfController@dashboard_angkutlimb3'
	]);
	Route::get('/ep/angkutlimb3/delete/{param}/{param2}/{param3}', [
		'as' => 'ehsspaccidents.delete_angkutlimb3',
		'uses'=>'EhsEnvPerfController@delete_angkutlimb3'
	]);
	Route::get('festronik/', [
		'as' => 'ehsspaccidents.index_festronik',
		'uses'=>'EhsEnvPerfController@index_festronik'
	]);
	Route::get('festronik/dashboard', [
		'as' => 'ehsspaccidents.dashboard_festronik',
		'uses'=>'EhsEnvPerfController@dashboard_festronik'
	]);
	Route::get('festronik1/{param}/{param2}/{param3}', [
		'as' => 'ehsspaccidents.approv_penghasil',
		'uses'=>'EhsEnvPerfController@approv_penghasil'
	]);
	Route::get('festronik2/{param}/{param2}/{param3}', [
		'as' => 'ehsspaccidents.approv_transporter',
		'uses'=>'EhsEnvPerfController@approv_transporter'
	]);
	Route::get('festronik3/{param}/{param2}/{param3}', [
		'as' => 'ehsspaccidents.approv_penerima',
		'uses'=>'EhsEnvPerfController@approv_penerima'
	]);
	// ROUTE EQUIPMENT FACILITY  //
	Route::get('ep/equipfacility/', [
		'as' => 'ehsspaccidents.index_equipfacility',
		'uses'=>'EhsEnvPerfController@index_equipfacility'
	]);
	Route::get('ep/equipfacility/dashboard/', [
		'as' => 'ehsspaccidents.dashboard_equipfacility',
		'uses'=>'EhsEnvPerfController@dashboard_equipfacility'
	]);
	Route::post('ep/equipfacility/store', [
		'as' => 'ehsspaccidents.store_equipfacility', 
		'uses'=>'EhsEnvPerfController@store_equipfacility'
	]);
	Route::get('ep/equipfacility/create', [
		'as' => 'ehsspaccidents.create_equipfacility',
		'uses'=>'EhsEnvPerfController@create_equipfacility'
	]);
	Route::get('ep/equipfacility/edit/{param}', [
		'as' => 'ehsspaccidents.edit_equipfacility',
		'uses'=>'EhsEnvPerfController@edit_equipfacility'
	]);
/*	Route::post('equipfacility/update/{param}', [
		'as'=>'ehsspaccidents.update',
		'uses'=>'EhsSpAccidentsController@update'
	]);*/
	/*Route::get('ep/equipfacility/update/{param}', [
		'as' => 'ehsspaccidents.update_equipfacility',
		'uses'=>'EhsSpAccidentsController@update_equipfacility'
	]);*/
	Route::get('ep/equipfacility/delete/{param}', [
		'as' => 'ehsspaccidents.delete_equipfacility',
		'uses'=>'EhsEnvPerfController@delete_equipfacility'
	]);
	Route::get('ep/equipfacility/{param}', [
		'as' => 'ehsspaccidents.show_equipfacility',
		'uses'=>'EhsEnvPerfController@show_equipfacility'
	]);
	// ROUTE EQUIPMENT FACILITY REVISI //
	Route::resource('ehsenv', 'EhsEnvPerfEfController'); 
	Route::get('ep/ef/', [
		'as' => 'ehsenv.index_ef',
		'uses'=>'EhsEnvPerfEfController@index_ef'
	]);
	Route::get('ep/ef/dashboard/', [
		'as' => 'ehsenv.dashboard_ef',
		'uses'=>'EhsEnvPerfEfController@dashboard_ef'
	]);
	Route::post('ep/ef/store', [
		'as' => 'ehsenv.store_ef', 
		'uses'=>'EhsEnvPerfEfController@store_ef'
	]);
	Route::get('ep/ef/create', [
		'as' => 'ehsenv.create_ef',
		'uses'=>'EhsEnvPerfEfController@create_ef'
	]);
	Route::get('ep/ef/edit/{param}', [
		'as' => 'ehsenv.edit_ef',
		'uses'=>'EhsEnvPerfEfController@edit_ef'
	]);
	Route::get('ep/ef/delete/{param}', [
		'as' => 'ehsenv.delete_ef',
		'uses'=>'EhsEnvPerfEfController@delete_ef'
	]);
	Route::get('ep/ef/show/{param}', [
		'as' => 'ehsenv.show_ef',
		'uses'=>'EhsEnvPerfEfController@show_ef'
	]);
	// ROUTE MASTER LIMBAH  //
	Route::get('/mstrlimb3', [
		'as' => 'ehsspaccidents.index_masterlimbah',
		'uses'=>'EhsEnvPerfController@index_masterlimbah'
	]);
	Route::get('/mstrlimb3/dashboard', [
		'as' => 'ehsspaccidents.dashboard_masterlimbah',
		'uses'=>'EhsEnvPerfController@dashboard_masterlimbah'
	]);
	Route::post('/mstrlimb3/store', [
		'as' => 'ehsspaccidents.store_masterlimbah',
		'uses'=>'EhsEnvPerfController@store_masterlimbah'
	]);
	Route::get('/mstrlimb3/delete/{param}', [
		'as' => 'ehsspaccidents.delete_masterlimbah',
		'uses'=>'EhsEnvPerfController@delete_masterlimbah'
	]);
	Route::post('/mstrlimb3/update/', [
		'as' => 'ehsspaccidents.update_masterlimbah',
		'uses'=>'EhsEnvPerfController@update_masterlimbah'
	]);
	//grafik
	Route::get('/envperf', [
		'as' => 'ehsspaccidents.index_kikenyoochi',
		'uses'=>'EhsSpAccidentsController@index_kikenyoochi'
	]);
	//popup karyawan
	Route::get('ehs/validate/karyawan/{param}', [
		'as' => 'kikenyoochi.validasiKaryawanKy',
		'uses' => 'EhsEnvPerfController@validasiKaryawanKy'
	]);
	Route::get('ehs/karyawan/popupKaryawanKy', [
		'as' => 'kikenyoochi.popupKaryawanKy',
		'uses' => 'EhsEnvPerfController@popupKaryawanKy'
	]);
	Route::get('selectlimbah/{param}/{param2}', [
		'as' => 'ehsspaccidents.selectlimbah',
		'uses' => 'EhsEnvPerfController@selectlimbah'
	]);
	Route::get('equipfacility/laporan/', [
		'as' => 'ehsenvreps.proses_equipment',
		'uses' => 'EhsEnvRepsController@proses_equipment'
	]);
	Route::get('equipfacility/proses/{param}/{param2}', [
		'as' => 'ehsenvreps.proseslaporan',
		'uses' => 'EhsEnvRepsController@proseslaporan'
	]);
	Route::get('equipfacility/monitoring/{param}/{param2}', [
		'as' => 'ehsenvreps.monitoring_ef',
		'uses' => 'EhsEnvRepsController@monitoring_ef'
	]);
	Route::get('equipfacility/detailef/{param}/{param2}', [
		'as' => 'ehsenvreps.detail_equipfacility',
		'uses' => 'EhsEnvRepsController@detail_equipfacility'
	]);
	Route::get('pkimia/laporan/', [
		'as' => 'ehsenvreps.prosesmon_pkimia',
		'uses' => 'EhsEnvRepsController@prosesmon_pkimia'
	]);
	Route::get('pkimia/monitoring/{param}/{param2}', [
		'as' => 'ehsenvreps.monitoring_pkimia',
		'uses' => 'EhsEnvRepsController@monitoring_pkimia'
	]);
	Route::get('alimbah/laporan/', [
		'as' => 'ehsenvreps.prosesmon_alimbah',
		'uses' => 'EhsEnvRepsController@prosesmon_alimbah'
	]);
	Route::get('alimbah/monitoring/{param}/{param2}', [
		'as' => 'ehsenvreps.monitoring_alimbah',
		'uses' => 'EhsEnvRepsController@monitoring_alimbah'
	]);
	Route::get('pkimia/grafik/monitoring/{param}', [
		'as' => 'ehsenvreps.grafik_pkimia',
		'uses'=>'EhsEnvRepsController@grafik_pkimia'
	]);
	Route::get('alimbah/grafik/monitoring/{param}', [
		'as' => 'ehsenvreps.grafik_alimbah',
		'uses'=>'EhsEnvRepsController@grafik_alimbah'
	]);
	//MAGANG E
});