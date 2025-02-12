<?php

Route::group(['prefix'=>'hronline', 'middleware'=>['auth']], function () {
	Route::get('mobile/izinterlambat', [
		'as' => 'mobiles.izinterlambat',			
		'uses'=>'IzinTelatController@izinterlambat_dashboard'
	]);
	Route::get('mobile/izinterlambat/data', [
		'as' => 'mobiles.izinterlambatdata',			
		'uses'=>'IzinTelatController@izinterlambat'
	]);
	Route::post('mobile/izinterlambat/submit', [
		'as' => 'mobiles.itelatsubmit',
		'uses'=>'IzinTelatController@iTelatSubmit'	
	]);
	Route::get('mobile/izinterlambat/approval', [
		'as' => 'mobiles.approvaltelat',
		'uses'=>'IzinTelatController@listApprovalTelat'
	]);
	Route::get('mobile/izinterlambat/approval/data', [
		'as' => 'mobiles.approvaltelatdata',
		'uses'=>'IzinTelatController@listApprovalTelatdata'
	]);	
	Route::post('mobile/izinterlambat/approval/apprv', [
		'as' => 'mobiles.itelatappr',
		'uses'=>'IzinTelatController@updateStatusApprv'	
	]);
	Route::post('mobile/izinterlambat/approval/dcln', [
		'as' => 'mobiles.itelatdcln',
		'uses'=>'IzinTelatController@updateStatusDcln'	
	]);
	Route::post('mobile/izinterlambat/approval/ajubanding', [
		'as' => 'mobiles.itelatbanding',
		'uses'=>'IzinTelatController@updateAjuBanding'	
	]);
	Route::post('mobile/izinterlambat/cetak', [
		'as' => 'mobiles.cetakitelat',
		'uses'=>'IzinTelatController@cetak_itelat'	
	]);
	Route::post('mobile/izinterlambat/hapus', [
		'as' => 'mobiles.hapusitelat',
		'uses'=>'IzinTelatController@hapus_itelat'	
	]);
	Route::get('mobile/uniform', [
		'as' => 'mobiles.permintaanuniform',
		'uses'=>'UniformGAController@dashboard_uniform'	
	]);	
	Route::post('mobile/uniform/save', [ 
		'as' => 'mobiles.saveuniform',
		'uses'=>'UniformGAController@saveuniform'	
	]);	
	Route::post('mobile/uniform/submit', [ 
		'as' => 'mobiles.submituniform',
		'uses'=>'UniformGAController@submituniform'	
	]);	
	Route::get('mobile/uniform/approval', [  
		'as' => 'mobiles.uniformappr',
		'uses'=>'UniformGAController@uniform_appr_dashboard'	
	]);
	Route::get('mobile/uniform/approval/data', [  
		'as' => 'mobiles.uniformappr_data',
		'uses'=>'UniformGAController@uniform_appr'	
	]);
	Route::post('mobile/uniform/approval/acc', [  
		'as' => 'mobiles.uniformappr_acc',
		'uses'=>'UniformGAController@acc_uni_atasan'	
	]);
	Route::post('mobile/uniform/approval/dcln', [  
		'as' => 'mobiles.uniformappr_dcln',
		'uses'=>'UniformGAController@dcln_uni_atasan'	
	]);
	Route::get('mobile/uniform/approval_ga', [  
		'as' => 'mobiles.uniformappr_ga',
		'uses'=>'UniformGAController@uniform_appr_ga'	
	]);
	Route::get('mobile/uniform/ga/master_uniform', [  
		'as' => 'mobiles.uniform_ga_master',
		'uses'=>'UniformGAController@uniform_ga_master'	
	]);
	Route::get('mobile/uniform/ga/master', [  
		'as' => 'mobiles.uniformappr_ga_master',
		'uses'=>'UniformGAController@get_master_uniform'	
	]);
	Route::post('mobile/uniform/ga/master/add', [  
		'as' => 'mobiles.uniformappr_ga_master_add',
		'uses'=>'UniformGAController@add_master_uniform'	
	]);
	Route::post('mobile/uniform/ga/master/edit', [  
		'as' => 'mobiles.uniformappr_ga_master_edit',
		'uses'=>'UniformGAController@edit_master_uniform'	
	]);
	Route::post('mobile/uniform/ga/master/delete', [  
		'as' => 'mobiles.uniformappr_ga_master_delete',
		'uses'=>'UniformGAController@delete_master_uniform'	
	]);
	Route::post('mobile/uniform/approval_ga/acc', [  
		'as' => 'mobiles.uniformappr_ga_acc',
		'uses'=>'UniformGAController@submit_ga'	
	]);
	// MAGANG S
	Route::get('mobile/lupaprik/', [
		'as' => 'mobiles.indexlupaprik',
		'uses' => 'HrdLupaPriksController@indexlupaprik'
	]);
	Route::get('mobile/dashboard/lupaprik', [
		'as' => 'mobiles.dashboardlupaprik',
		'uses'=>'HrdLupaPriksController@dashboardlupaprik'
	]);
	Route::get('mobile/lupaprik/create', [
		'as' => 'mobiles.createlupaprik',
		'uses' => 'HrdLupaPriksController@createlupaprik'
	]);
	Route::post('mobile/lupaprik/store', [
		'as' => 'mobiles.storelupaprik',
		'uses' => 'HrdLupaPriksController@storelupaprik'
	]);
	Route::get('mobile/lupaprik/show', [
		'as' => 'mobiles.showlupaprik',
		'uses' => 'HrdLupaPriksController@showlupaprik'
	]);
	Route::get('mobile/lupaprik/hapus/{param}', [
		'as' => 'mobiles.hapuslupaprik',
		'uses' => 'HrdLupaPriksController@hapuslupaprik'
	]);
	Route::get('mobile/lupaprik/{param}/print', [
		'as' => 'mobiles.printlupaprik',
		'uses' => 'HrdLupaPriksController@printlupaprik'
	]);
	Route::get('mobile/lupaprik/{param}/pk', [
		'as' => 'mobiles.ajuankembalilupaprik',
		'uses' => 'HrdLupaPriksController@ajuankembalilupaprik'
	]);
	Route::get('mobile/approvallupaprik/{param}/setuju', [
		'as' => 'mobiles.setujuapprovallupaprik',
		'uses' => 'HrdLupaPriksController@setujuapprovallupaprik'
	]);
	Route::get('mobile/approvallupaprik/{param}/tolak', [
		'as' => 'mobiles.tolakapprovallupaprik',
		'uses' => 'HrdLupaPriksController@tolakapprovallupaprik'
	]);
	Route::get('mobile/approvallupaprik/', [
		'as' => 'mobiles.indexapprovallupaprik',
		'uses' => 'HrdLupaPriksController@indexapprovallupaprik'
	]);
	Route::get('mobile/dashboard/approvallupaprik', [
		'as' => 'mobiles.dashboardapprovallupaprik',
		'uses'=>'HrdLupaPriksController@dashboardapprovallupaprik'
	]);
	Route::get('mobile/approvallupaprik/sechead', [
		'as' => 'mobiles.indexapprovallupaprik_sechead',
		'uses' => 'HrdLupaPriksController@indexapprovallupaprik_sechead'
	]);
	Route::get('mobile/approvallupaprik/dephead', [
		'as' => 'mobiles.indexapprovallupaprik_dephead',
		'uses' => 'HrdLupaPriksController@indexapprovallupaprik_dephead'
	]);	
	Route::get('mobile/approvallupaprik/divhead', [
		'as' => 'mobiles.indexapprovallupaprik_divhead',
		'uses' => 'HrdLupaPriksController@indexapprovallupaprik_divhead'
	]);	
	Route::get('mobile/dashboard/approvallupaprik/sechead', [
		'as' => 'mobiles.dashboardapprovallupaprik_sechead',
		'uses'=>'HrdLupaPriksController@dashboardapprovallupaprik_sechead'
	]);
	Route::get('mobile/dashboard/approvallupaprik/dephead', [
		'as' => 'mobiles.dashboardapprovallupaprik_dephead',
		'uses'=>'HrdLupaPriksController@dashboardapprovallupaprik_dephead'
	]);
	Route::get('mobile/dashboard/approvallupaprik/divhead', [
		'as' => 'mobiles.dashboardapprovallupaprik_divhead',
		'uses'=>'HrdLupaPriksController@dashboardapprovallupaprik_divhead'
	]);
	Route::get('mobile/approvallupaprik/{param}', [
		'as' => 'mobiles.showapprovallupaprik',
		'uses' => 'HrdLupaPriksController@showapprovallupaprik'
	]);
	Route::get('mobile/approvallupaprik/sechead/{param}/setuju', [
		'as' => 'mobiles.setujuapprovallupaprik_sechead',
		'uses' => 'HrdLupaPriksController@setujuapprovallupaprik_sechead'
	]);
	Route::get('mobile/approvallupaprik/dephead/{param}/setuju', [
		'as' => 'mobiles.setujuapprovallupaprik_dephead',
		'uses' => 'HrdLupaPriksController@setujuapprovallupaprik_dephead'
	]);
	Route::get('mobile/approvallupaprik/divhead/{param}/setuju', [
		'as' => 'mobiles.setujuapprovallupaprik_divhead',
		'uses' => 'HrdLupaPriksController@setujuapprovallupaprik_divhead'
	]);
	Route::get('mobile/approvallupaprik/sechead/{param}/tolak', [
		'as' => 'mobiles.tolakapprovallupaprik_sechead',
		'uses' => 'HrdLupaPriksController@tolakapprovallupaprik_sechead'
	]);
	Route::get('mobile/approvallupaprik/dephead/{param}/tolak', [
		'as' => 'mobiles.tolakapprovallupaprik_dephead',
		'uses' => 'HrdLupaPriksController@tolakapprovallupaprik_dephead'
	]);
	Route::get('mobile/approvallupaprik/divhead/{param}/tolak', [
		'as' => 'mobiles.tolakapprovallupaprik_divhead',
		'uses' => 'HrdLupaPriksController@tolakapprovallupaprik_divhead'
	]);
	Route::get('mobile/indexreg', [		
	 	'as' => 'mobiles.indexreg',
		'uses'=>'HrdRegistratsiKarController@indexreg'
	]);
	Route::get('mobile/indexreg_/{param}/{param2}', [
		'as' => 'mobiles.indexreg_',
		'uses'=>'HrdRegistratsiKarController@index_'
	]);
	Route::post('mobile/datapribadi/update', [
		'as' => 'mobiles.regkaryawanpribadi',
		'uses'=>'HrdRegistratsiKarController@updatedatapribadi'	
	]);
	Route::post('mobile/save-form-datpendukung',[
		'as' => 'save.datapendukung',
		'uses' => 'HrdRegistratsiKarController@storedatapendukung'
	]);
	Route::post('mobile/save-form-datapribadi',[
		'as' => 'save.datapribadi',
		'uses' => 'HrdRegistratsiKarController@storedatapribadi'
	]);
	Route::post('mobile/save-form-dataorgtua',[
		'as' => 'save.dataorgtua',
		'uses' => 'HrdRegistratsiKarController@storedataorgtua'
	]);	
	Route::post('mobile/save-form-datapendukung',[
		'as' => 'save.datapendukung',
		'uses' => 'HrdRegistratsiKarController@storedatapendukung'
	]);
	Route::post('mobile/save-form-datamarital',[
		'as' => 'save.datamarital',
		'uses' => 'HrdRegistratsiKarController@storedatamarital'
	]);
	Route::get('mobile/save-form-datapendukung',[
		'as' => 'save.datapendukung',
		'uses' => 'HrdRegistratsiKarController@storedatapendukung'
	]);
	Route::match(['get', 'post'], 'mobile/form-datapendidikan/{noreg}',[
		'as' => 'create.datapendidikan',
		'uses' => 'HrdRegistratsiKarController@create_datpend'
	]);
	Route::match(['get', 'post'], 'mobile/form-datamarital/{noreg}',[
		'as' => 'create.datamarital',
		'uses' => 'HrdRegistratsiKarController@create_datmarit'
	]);
	Route::get('mobile/imp', [
		'as' => 'mobiles.indeximp',
		'uses' => 'HrdImpController@indeximp'
	]);
	Route::get('mobile/dashboard/imp', [
		'as' => 'mobiles.dashboardimp',
		'uses'=>'HrdImpController@dashboardimp'
	]);
	Route::get('mobile/create', [
		'as' => 'mobiles.createimp',
		'uses' => 'HrdImpController@createimp'
	]);
	Route::post('mobile/imp/store', [
		'as' => 'mobiles.storeimp',
		'uses' => 'HrdImpController@storeimp'
	]);
	Route::get('mobile/imp/{param}/edit', [
		'as' => 'mobiles.editjamimp',
		'uses' => 'HrdImpController@editjamimp'
	]);
	Route::put('mobile/imp/update/{param}', [
		'as' => 'mobiles.update',
		'uses' => 'HrdImpController@updatejamimp'
	]);
	Route::get('mobile/approvalimp/', [
		'as' => 'mobiles.indexapprovalimp',
		'uses' => 'HrdImpController@indexapprovalimp'
	]);
	Route::get('mobile/dashboard/approvalimp', [
		'as' => 'mobiles.dashboardapprovalimp',
		'uses'=>'HrdImpController@dashboardapprovalimp'
	]);
	Route::get('mobile/showimp/{param}', [
		'as' => 'mobiles.showimp',
		'uses' => 'HrdImpController@showimp'
	]);
	Route::get('mobile/approvalimp/{param}/setuju', [
		'as' => 'mobiles.setujuapprovalimp',
		'uses' => 'HrdImpController@setujuapprovalimp'
	]);
	Route::get('mobile/approvalimp/{param}/setuju', [
		'as' => 'mobiles.setujuapprovalimp',
		'uses' => 'HrdImpController@setujuapprovalimp'
	]);
	Route::get('mobile/approvalimp/{param}/tolak', [
		'as' => 'mobiles.tolakapprovalimp',
		'uses' => 'HrdImpController@tolakapprovalimp'
	]);
	//LPB UNIFORM
	Route::get('mobile/lpbuniform/', [
		'as' => 'mobiles.indexlpbuni',
		'uses' => 'GaLpbUniformsController@indexlpbuni'
	]);
	Route::get('mobile/dashboard/lpbuniform', [
		'as' => 'mobiles.dashboardlpbuni',
		'uses'=>'GaLpbUniformsController@dashboardlpbuni'
	]);
	Route::get('mobile/lpbuniform/create', [
		'as' => 'mobiles.createlpbuni',
		'uses' => 'GaLpbUniformsController@createlpbuni'
	]);
	Route::post('mobile/lpbuniform/store', [
		'as' => 'mobiles.storelpbuni',
		'uses' => 'GaLpbUniformsController@storelpbuni'
	]);
	Route::get('mobile/lpbuniform/{param}', [
		'as' => 'mobiles.showlpbuni',
		'uses' => 'GaLpbUniformsController@showlpbuni'
	]);
	Route::get('mobile/lpbuniform/{param}/print', [
		'as' => 'mobiles.printlpbuni',
		'uses' => 'GaLpbUniformsController@printlpbuni'
	]);
	//LPB UNIFORM
	//Mutasi Uniform
	Route::get('mobile/mutasiuniform/', [
		'as' => 'mobiles.indexmutasiuni',
		'uses' => 'GaLpbUniformsController@indexmutasiuni'
	]);
	Route::get('mobile/dashboard/mutasiuniform', [
		'as' => 'mobiles.dashboardmutasiuni',
		'uses'=>'GaLpbUniformsController@dashboardmutasiuni'
	]);
	Route::post('mobile/mutasiuniform/print', [
		'as' => 'mobiles.printmutasiuni',
		'uses' => 'GaLpbUniformsController@printmutasiuni'
	]);
	Route::get('mobile/mutasiuniform/createmutasi', [
		'as' => 'mobiles.createmutasi',
		'uses'=>'GaLpbUniformsController@createmutasi'
	]);
	Route::post('mobile/mutasiuniform/storemutasi', [
		'as' => 'mobiles.storemutasi',
		'uses' => 'GaLpbUniformsController@storemutasi'
	]);
	Route::get('mobile/mutasiuniform/createsto/{param}/{param2}/{param3}', [
		'as' => 'mobiles.createsto',
		'uses'=>'GaLpbUniformsController@createsto'
	]);
	Route::post('mobile/mutasiuniform/storesto', [
		'as' => 'mobiles.storesto',
		'uses' => 'GaLpbUniformsController@storesto'
	]);
	//Mutasi Uniform
	//surat keterangan 
	Route::get('mobile/dashboard/suketkaryawan', [
		'as' => 'mobiles.dashboardsuketkaryawan',
		'uses'=>'SuketkaryawanController@dashboardsuketkaryawan'
	]);
	Route::get('mobile/suketkaryawan/', [
		'as' => 'mobiles.suketkaryawan',
		'uses' => 'SuketkaryawanController@indexsuketkaryawan'
	]);
	Route::get('mobile/suketkaryawan/create', [
		'as' => 'mobiles.createsuketkaryawan',
		'uses' => 'SuketkaryawanController@createsuketkaryawan'
	]);
	Route::get('mobile/suketkaryawan/submit', [
		'as' => 'mobiles.submitsuketkaryawan',
		'uses' => 'SuketkaryawanController@submitsuketkaryawan'
	]);
	Route::post('mobile/suketkaryawan/store', [
		'as' => 'mobiles.storesuketkaryawan',
		'uses' => 'SuketkaryawanController@storesuketkaryawan'
	]);
	Route::get('mobile/suketkaryawan/{param}', [
		'as' => 'mobiles.showsuketkaryawan',
		'uses' => 'SuketkaryawanController@showsuketkaryawan'
	]);
	Route::get('mobile/suketkaryawan/{param}/edit', [
		'as' => 'mobiles.editsuketkaryawan',
		'uses' => 'SuketkaryawanController@editsuketkaryawan'
	]);
	Route::put('/mobile/suketkaryawan/update/{param}', [
		'as' => 'mobiles.updatesuketkaryawan',
		'uses' => 'SuketkaryawanController@updatesuketkaryawan'
	]);
	//Approval Surat Keterangan Pengajuan
	Route::get('mobile/dashboard/suketpengajuan', [ 
	 	'as' => 'mobiles.dashboardsuketpengajuan',
		'uses' =>'SuketpengajuanController@dashboardsuketpengajuan'
	]);
	Route::get('mobile/suketpengajuan', [
		'as' => 'mobiles.suketpengajuan',
		'uses' => 'SuketpengajuanController@indexsuketpengajuan'
	]);
	Route::get('mobile/suketpengajuan/{param}/agree', [
		'as' => 'mobiles.setujusuketpengajuan',
		'uses' => 'SuketpengajuanController@update_statussuketpengajuan'
	]);
	Route::get('mobile/suketpengajuan/{param}/show', [
  		'as' => 'mobiles.showdatasuketpengajuan',
  		'uses' => 'SuketpengajuanController@showdatasuketpengajuan'
 	]);
	Route::get('mobile/suketpengajuan/{param}/showhrd', [
		'as' => 'mobiles.tampildatahrdsuketpengajuan',
		'uses' => 'SuketpengajuanController@tampildatahrdsuketpengajuan'
	]);
	Route::get('mobile/suketpengajuan/{param}/tolak', [
		'as' => 'mobiles.refuse_statussuketpengajuan', 
		'uses' => 'SuketpengajuanController@refuse_statussuketpengajuan'
  	]);
	Route::get('mobile/suketpengajuan/{param}/tolakhrd', [
		'as' => 'mobiles.batal_status_hrdsuketpengajuan', 
		'uses' => 'SuketpengajuanController@batal_status_hrdsuketpengajuan'
  	]);
	Route::get('mobile/suketpengajuan/{param}/setuju',[ 
		'as' => 'mobiles.update_statussuketpengajuan',
		'uses' => 'SuketpengajuanController@update_statussuketpengajuan'
	]);
	Route::get('mobile/suketpengajuan/{param}/setujuhrd',[ 
		'as' => 'mobiles.ubah_status_hrdsuketpengajuan',
		'uses' => 'SuketpengajuanController@ubah_status_hrdsuketpengajuan'
	]);
	Route::get('mobile/RegistrasiUlangKaryawan/{param?}',[ 
		'as' => 'mobiles.RegistrasiUlangKaryawan',
		'uses' => 'HrdRegistratsiKarController@IndexRegistrasiUlangKaryawan'
	]);
	Route::put('mobile/UpdateRegistrasiUlangKaryawan/{param?}',[ 
		'as' => 'mobiles.UpdateRegistrasiUlangKaryawan',
		'uses' => 'HrdRegistratsiKarController@UpdateRegistrasiUlangKaryawan'
	]);
	Route::get('mobile/UbahStatusRegistrasiUlangKaryawan/{param}/{param2}/{param3}',[ 
		'as' => 'mobiles.UbahStatusRegistrasiUlangKaryawan',
		'uses' => 'HrdRegistratsiKarController@UbahStatusRegistrasiUlangKaryawan'
	]);

});

Route::group(['prefix' => 'laravel-crud-search-sort-ajax-modal-form'], function () {
	Route::get('/{param}/{noreg}', 'HrdRegistratsiKarController@index_');
  	Route::match(['get', 'post'], 'create_datpend', 'HrdRegistratsiKarController@create_datpend');
  	Route::match(['get', 'put'], 'update_datpend/{kd_jenjang}', 'HrdRegistratsiKarController@update_datpend');
});	


# Route::get('mobile/indexreg', 'HrdRegistratsiKarController@indexreg');