<?php

Route::group(['prefix' => 'qa', 'middleware' => ['auth']], function () {
	Route::resource('kalibrasi', 'Tcalorder1Controller');
	Route::get('dashboard/kalibrasi', [
		'as' => 'kalibrasi.dashboard',
		'uses' => 'Tcalorder1Controller@dashboard'
	]);
	Route::get('kalibrasi/delete/{param}', [
		'as' => 'kalibrasi.delete',
		'uses' => 'Tcalorder1Controller@delete'
	]);
	Route::get('kalibrasi/print/{param}', [
		'as' => 'kalibrasi.print',
		'uses' => 'Tcalorder1Controller@print'
	]);
	Route::resource('kalibrasidet', 'Tcalorder2Controller');
	Route::get('dashboard/kalibrasidet', [
		'as' => 'kalibrasidet.dashboard',
		'uses' => 'Tcalorder2Controller@dashboard'
	]);
	Route::get('kalibrasidet/hapus/{param}/{param1}/{param2}', [
		'as' => 'kalibrasidet.hapus',
		'uses' => 'Tcalorder2Controller@hapus'
	]);
	Route::get('kalibrasidet/hapusdetail/{param}', [
		'as' => 'kalibrasidet.hapusdetail',
		'uses' => 'Tcalorder2Controller@hapusdetail'
	]);
	Route::get('kalibrasidet/index/tarik', [
		'as' => 'kalibrasidet.indextarik',
		'uses' => 'Tcalorder2Controller@indextarik'
	]);
	Route::get('dashboardtarik/kalibrasidet', [
		'as' => 'kalibrasidet.dashboardtarik',
		'uses' => 'Tcalorder2Controller@dashboardtarik'
	]);
	Route::get('kalibrasidet/index/kembali', [
		'as' => 'kalibrasidet.indexkembali',
		'uses' => 'Tcalorder2Controller@indexkembali'
	]);
	Route::get('dashboardkembali/kalibrasidet', [
		'as' => 'kalibrasidet.dashboardkembali',
		'uses' => 'Tcalorder2Controller@dashboardkembali'
	]);
	Route::post('kalibrasidet/bataltarik', [
		'as' => 'kalibrasidet.bataltarik',
		'uses' => 'Tcalorder2Controller@bataltarik'
	]);
	Route::get('savekembali/kalibrasidet/{param}/{param1}/{param2}', [
		'as' => 'kalibrasidet.savekembali',
		'uses' => 'Tcalorder2Controller@savekembali'
	]);
	Route::resource('serahkalibrasi', 'Tsrhalat1Controller');
	Route::get('dashboard/serahkalibrasi', [
		'as' => 'serahkalibrasi.dashboard',
		'uses' => 'Tsrhalat1Controller@dashboard'
	]);
	Route::get('serahkalibrasi/delete/{param}', [
		'as' => 'serahkalibrasi.delete',
		'uses' => 'Tsrhalat1Controller@delete'
	]);
	Route::resource('serahkalibrasidet', 'Tsrhalat2Controller');
	Route::get('serahkalibrasidet/hapus/{param}/{param1}/{param2}/{param3}', [
		'as' => 'serahkalibrasidet.hapus',
		'uses' => 'Tsrhalat2Controller@hapus'
	]);
	Route::resource('mstalatukurkal', 'Tclbr005mKalController');
	Route::get('dashboard/mstalatukurkal', [
		'as' => 'mstalatukurkal.dashboard',
		'uses' => 'Tclbr005mKalController@dashboard'
	]);
	Route::get('edit/mstalatukurkal/{param}/{param1}/{param2}', [
		'as' => 'mstalatukurkal.edit',
		'uses' => 'Tclbr005mKalController@edit'
	]);
	Route::get('destroy/mstalatukurkal/{param}/{param1}/{param2}', [
		'as' => 'mstalatukurkal.destroy',
		'uses' => 'Tclbr005mKalController@destroy'
	]);
	Route::get('mstalatukurkal/deleteimage/{param}/{param1}/{param2}', [
		'as' => 'mstalatukurkal.deleteimage',
		'uses' => 'Tclbr005mKalController@deleteimage'
	]);
	Route::get('showImage/mstalatukurkal/{param}', [
		'as' => 'mstalatukurkal.showImage',
		'uses' => 'Tclbr005mKalController@showImage'
	]);
	Route::get('mstalatukurkal/hapus/{param}/{param1}', [
		'as' => 'mstalatukurkal.hapus',
		'uses' => 'Tclbr005mKalController@hapus'
	]);
	Route::get('mstalatukurkal/hapusdetail/{param}', [
		'as' => 'mstalatukurkal.hapusdetail',
		'uses' => 'Tclbr005mKalController@hapusdetail'
	]);
	Route::get('mstalatukurkal/hapusout/{param}/{param1}', [
		'as' => 'mstalatukurkal.hapusout',
		'uses' => 'Tclbr005mKalController@hapusout'
	]);
	Route::get('mstalatukurkal/hapusdetailout/{param}', [
		'as' => 'mstalatukurkal.hapusdetailout',
		'uses' => 'Tclbr005mKalController@hapusdetailout'
	]);
	Route::get('mstalatukurkal/hapusdepth/{param}/{param1}', [
		'as' => 'mstalatukurkal.hapusdepth',
		'uses' => 'Tclbr005mKalController@hapusdepth'
	]);
	Route::get('mstalatukurkal/hapusdetaildepth/{param}', [
		'as' => 'mstalatukurkal.hapusdetaildepth',
		'uses' => 'Tclbr005mKalController@hapusdetaildepth'
	]);
	Route::resource('kalibrator', 'McalkalibratorController');
	Route::get('dashboard/kalibrator', [
		'as' => 'kalibrator.dashboard',
		'uses' => 'McalkalibratorController@dashboard'
	]);
	Route::get('kalibrator/destroy/{param}', [
		'as' => 'kalibrator.destroy',
		'uses' => 'McalkalibratorController@destroy'
	]);
	Route::get('kalibrator/hapus/{param}/{param1}', [
		'as' => 'kalibrator.hapus',
		'uses' => 'McalkalibratorController@hapus'
	]);
	Route::get('kalibrator/hapusdetail/{param}', [
		'as' => 'kalibrator.hapusdetail',
		'uses' => 'McalkalibratorController@hapusdetail'
	]);
	Route::get('kalibrator/hapusout/{param}/{param1}', [
		'as' => 'kalibrator.hapusout',
		'uses' => 'McalkalibratorController@hapusout'
	]);
	Route::get('kalibrator/hapusdetailout/{param}', [
		'as' => 'kalibrator.hapusdetailout',
		'uses' => 'McalkalibratorController@hapusdetailout'
	]);
	Route::resource('klbrtemp', 'McaltemphumiController');
	Route::get('dashboard/klbrtemp', [
		'as' => 'klbrtemp.dashboard',
		'uses' => 'McaltemphumiController@dashboard'
	]);
	Route::get('klbrtemp/destroy/{param}', [
		'as' => 'klbrtemp.destroy',
		'uses' => 'McaltemphumiController@destroy'
	]);
	Route::get('klbrtemp/hapus/{param}/{param1}', [
		'as' => 'klbrtemp.hapus',
		'uses' => 'McaltemphumiController@hapus'
	]);
	Route::get('klbrtemp/hapusdet/{param}/{param1}', [
		'as' => 'klbrtemp.hapusdet',
		'uses' => 'McaltemphumiController@hapusdet'
	]);
	Route::get('klbrtemp/hapusdetail/{param}', [
		'as' => 'klbrtemp.hapusdetail',
		'uses' => 'McaltemphumiController@hapusdetail'
	]);
	Route::get('klbrtemp/hapusdetaildet/{param}', [
		'as' => 'klbrtemp.hapusdetaildet',
		'uses' => 'McaltemphumiController@hapusdetaildet'
	]);
	Route::resource('kalserti', 'McalsertiController');
	Route::get('dashboard/kalserti', [
		'as' => 'kalserti.dashboard',
		'uses' => 'McalsertiController@dashboard'
	]);
	Route::get('dashboardapp/kalserti', [
		'as' => 'kalserti.dashboardapp',
		'uses' => 'McalsertiController@dashboardapp'
	]);
	Route::get('dashboardcust/kalserti', [
		'as' => 'kalserti.dashboardcust',
		'uses' => 'McalsertiController@dashboardcust'
	]);
	Route::get('kalserti/destroy/{param}', [
		'as' => 'kalserti.destroy',
		'uses' => 'McalsertiController@destroy'
	]);
	Route::get('kalserti/print/{param}/{param1}', [
		'as' => 'kalserti.print',
		'uses' => 'McalsertiController@print'
	]);
	Route::get('kalserti/index/approve', [
		'as' => 'kalserti.indexapp',
		'uses' => 'McalsertiController@indexapp'
	]);
	Route::get('kalserti/index/customer', [
		'as' => 'kalserti.indexcust',
		'uses' => 'McalsertiController@indexcust'
	]);
	Route::get('kalserti/editapp/{param}', [
		'as' => 'kalserti.editapp',
		'uses' => 'McalsertiController@editapp'
	]);
	Route::get('kalserti/approveserti/{param}/{param1}', [
		'as' => 'kalserti.approveserti',
		'uses' => 'McalsertiController@approveserti'
	]);
	Route::resource('kalworksheet', 'McalworksheetController');
	Route::get('dashboard/kalworksheet', [
		'as' => 'kalworksheet.dashboard',
		'uses' => 'McalworksheetController@dashboard'
	]);
	Route::get('dashboardorder/kalworksheet', [
		'as' => 'kalworksheet.dashboardorder',
		'uses' => 'McalworksheetController@dashboardorder'
	]);
	Route::get('dashboardws/kalworksheet', [
		'as' => 'kalworksheet.dashboardws',
		'uses' => 'McalworksheetController@dashboardws'
	]);
	Route::get('kalworksheet/destroy/{param}', [
		'as' => 'kalworksheet.destroy',
		'uses' => 'McalworksheetController@destroy'
	]);
	Route::get('kalworksheet/showdetail/{param}/{param1}/{param2}', [
		'as' => 'kalworksheet.showdetail',
		'uses' => 'McalworksheetController@showdetail'
	]);
	Route::get('kalworksheet/index/ws', [
		'as' => 'kalworksheet.indexws',
		'uses' => 'McalworksheetController@indexws'
	]);
	Route::get('kalworksheet/editws/{param}', [
		'as' => 'kalworksheet.editws',
		'uses' => 'McalworksheetController@editws'
	]);
	Route::get('kalworksheet/approvews/{param}/{param1}/{param2}/{param3}', [
		'as' => 'kalworksheet.approvews',
		'uses' => 'McalworksheetController@approvews'
	]);
	Route::get('kalworksheet/print/{param}', [
		'as' => 'kalworksheet.print',
		'uses' => 'McalworksheetController@print'
	]);
	Route::get('kalworksheet/deletefile/{param}', [
		'as' => 'kalworksheet.deletefile',
		'uses' => 'McalworksheetController@deletefile'
	]);
	Route::resource('konstanta', 'McalkonstantaController');
	Route::get('dashboard/konstanta', [
		'as' => 'konstanta.dashboard',
		'uses' => 'McalkonstantaController@dashboard'
	]);
	Route::get('konstanta/destroy/{param}', [
		'as' => 'konstanta.destroy',
		'uses' => 'McalkonstantaController@destroy'
	]);
	Route::resource('qatsas', 'QatSasController');
	Route::get('dashboard/qatsas', [
		'as' => 'qatsas.dashboard',
		'uses' => 'QatSasController@dashboard'
	]);
	Route::get('qatsas/destroy/{param}', [
		'as' => 'qatsas.destroy',
		'uses' => 'QatSasController@destroy'
	]);
	Route::get('qatsas/deleteimagepart/{param}', [
		'as' => 'qatsas.deleteimagepart',
		'uses' => 'QatSasController@deleteimagepart'
	]);
	Route::get('qatsas/deleteimageproblem/{param}', [
		'as' => 'qatsas.deleteimageproblem',
		'uses' => 'QatSasController@deleteimageproblem'
	]);
	Route::get('qatsas/deletecorrectivefile/{param}', [
		'as' => 'qatsas.deletecorrectivefile',
		'uses' => 'QatSasController@deletecorrectivefile'
	]);
	Route::get('qatsas/deleteapprovedfile/{param}', [
		'as' => 'qatsas.deleteapprovedfile',
		'uses' => 'QatSasController@deleteapprovedfile'
	]);
	Route::get('qatsas/submit/{param}', [
		'as' => 'qatsas.submit',
		'uses' => 'QatSasController@submit'
	]);
	Route::get('qatsas/revisi/{param}', [
		'as' => 'qatsas.revisi',
		'uses' => 'QatSasController@revisi'
	]);
	Route::get('dashboardapp/qatsas', [
		'as' => 'qatsas.dashboardapp',
		'uses' => 'QatSasController@dashboardapp'
	]);
	Route::get('qatsas/index/approve', [
		'as' => 'qatsas.indexapp',
		'uses' => 'QatSasController@indexapp'
	]);
	Route::get('qatsas/editapp/{param}', [
		'as' => 'qatsas.editapp',
		'uses' => 'QatSasController@editapp'
	]);
	Route::get('qatsas/approvesa/{param}/{param1}/{param2}', [
		'as' => 'qatsas.approvesa',
		'uses' => 'QatSasController@approvesa'
	]);

	Route::resource('schedulecpp', 'SchedulecppController');
	Route::get('dashboard/schedulecpp', [
		'as' => 'schedulecpp.dashboard',
		'uses' => 'SchedulecppController@dashboard'
	]);
	Route::get('schedulecpp/edit/{param}', [
		'as' => 'schedulecpp.edit',
		'uses' => 'SchedulecppController@edit'
	]);
	Route::get('schedulecpp/dropdownMesin/{param}', [
		'as' => 'schedulecpp.dropdownMesin',
		'uses' => 'SchedulecppController@dropdownMesin'
	]);
	Route::get('schedulecpp/showdetail/{param}/{param1}/{param2}/{param3}/{param4}', [
		'as' => 'schedulecpp.showdetail',
		'uses' => 'SchedulecppController@showDetail'
	]);
	Route::get('schedulecpp/destroy/{param}', [
		'as' => 'schedulecpp.destroy',
		'uses' => 'SchedulecppController@destroy'
	]);
	Route::resource('ceksheetcpp', 'QatTrCpp01Controller');
	Route::get('ceksheetcpp/showdetail/{param}', [
		'as' => 'ceksheetcpp.showdetail',
		'uses' => 'QatTrCpp01Controller@showdetail'
	]);
	Route::get('ceksheetcpp/destroy/{param}', [
		'as' => 'ceksheetcpp.destroy',
		'uses' => 'QatTrCpp01Controller@destroy'
	]);
	//auditor

	Route::get('auditor/auditor_form', [
		'as' => 'auditors.auditorform',
		'uses' => 'InternalAuditController@auditor_form'
	]);

	Route::get('auditor/auditor_form/data', [
		'as' => 'auditors.draft_data',
		'uses' => 'InternalAuditController@draft_data'
	]);

	Route::post('auditor/auditor_form/data/byNpk', [
		'as' => 'auditors.draft_data_byNpk',
		'uses' => 'InternalAuditController@add_row_draft'
	]);

	Route::post('auditor/auditor_form/data/delete', [
		'as' => 'auditors.draft_data_delete',
		'uses' => 'InternalAuditController@delete_row_draft'
	]);

	Route::post('auditor/auditor_form/data/save', [
		'as' => 'auditors.draft_data_save',
		'uses' => 'InternalAuditController@save_not_draft'
	]);

	Route::post('auditor/auditor_form/data/edit', [
		'as' => 'auditors.data_edit',
		'uses' => 'InternalAuditController@edit_new_rev'
	]);

	Route::post('auditor/auditor_form/data/editremark', [
		'as' => 'auditors.data_edit_remark',
		'uses' => 'InternalAuditController@edit_remark'
	]);


	Route::get('report/daftar_auditor', [
		'as' => 'auditors.daftar_auditor',
		'uses' => 'InternalAuditController@daftar_auditor'
	]);

	Route::get('report/daftar_auditor/cetak', [
		'as' => 'auditors.cetak_daftar_auditor',
		'uses' => 'InternalAuditController@cetak_daftar_auditor'
	]);

	Route::get('audit/turtle_form', [
		'as' => 'auditors.turtleform',
		'uses' => 'InternalAuditController@turtle_form'
	]);

	Route::get('audit/turtle_form/{param}', [
		'as' => 'auditors.turtleform_load',
		'uses' => 'InternalAuditController@turtle_form_load'
	]);

	Route::post('audit/turtle_form/edit', [
		'as' => 'auditors.edit_turtle',
		'uses' => 'InternalAuditController@edit_turtle'
	]);

	Route::post('audit/turtle_form/save', [
		'as' => 'auditors.save_turtle',
		'uses' => 'InternalAuditController@save_turtle'
	]);

	Route::post('audit/turtle_form/create', [
		'as' => 'auditors.create_turtle',
		'uses' => 'InternalAuditController@create_turtle'
	]);

	Route::post('audit/turtle_form/delete', [
		'as' => 'auditors.delete_turtle',
		'uses' => 'InternalAuditController@delete_turtle'
	]);

	Route::post('audit/turtle_form/rename', [
		'as' => 'auditors.rename_turtle',
		'uses' => 'InternalAuditController@rename_turtle'
	]);

	Route::post('audit/turtle_form/add/review', [
		'as' => 'auditors.add_review_turtle',
		'uses' => 'InternalAuditController@add_review_turtle'
	]);

	Route::post('audit/turtle_form/add/review/auditor', [
		'as' => 'auditors.add_review_auditor',
		'uses' => 'InternalAuditController@add_review_auditor'
	]);

	Route::get('audit/temuan_audit_form', [
		'as' => 'auditors.temuanauditform',
		'uses' => 'InternalAuditController@temuan_audit_form'
	]);

	Route::post('audit/temuan_audit_form/submit', [
		'as' => 'auditors.temuanauditform_submit',
		'uses' => 'InternalAuditController@temuan_audit_form_submit'
	]);

	Route::post('audit/temuan_audit_form/submit_draft', [
		'as' => 'auditors.temuanauditform_save_draft',
		'uses' => 'InternalAuditController@temuan_audit_form_save_draft'
	]);

	Route::get('audit/daftar_temuan', [
		'as' => 'auditors.daftartemuan',
		'uses' => 'InternalAuditController@daftartemuan'
	]);

	Route::get('audit/daftar_temuan/{param}', [
		'as' => 'auditors.daftartemuanByNo',
		'uses' => 'InternalAuditController@daftartemuanByNo'
	]);

	Route::get('audit/daftar_temuan/{param}/edit', [
		'as' => 'auditors.daftartemuanByNo_edit',
		'uses' => 'InternalAuditController@daftartemuanByNo_edit'
	]);

	Route::post('audit/daftar_temuan/delete_draft', [
		'as' => 'auditors.daftartemuanByNo_delete_draft',
		'uses' => 'InternalAuditController@temuan_audit_form_delete_draft'
	]);

	Route::post('audit/daftar_temuan/edit/submit', [
		'as' => 'auditors.daftartemuanByNo_edit_submit',
		'uses' => 'InternalAuditController@temuan_audit_form_edit'
	]);

	Route::get('audit/daftar_temuan/{param}/lead_sign', [
		'as' => 'auditors.temuanaudit_sign_lead',
		'uses' => 'InternalAuditController@sign_lead'
	]);

	Route::post('audit/daftar_temuan/{param}/lead_sign/submit', [
		'as' => 'auditors.temuanaudit_sign_lead_submit',
		'uses' => 'InternalAuditController@sign_lead_submit'
	]);

	Route::post('audit/daftar_temuan/{param}/lead_sign/tolak', [
		'as' => 'auditors.temuanaudit_sign_lead_tolak',
		'uses' => 'InternalAuditController@sign_lead_tolak'
	]);

	Route::post('audit/daftar_temuan/{param}/lead_sign/revisi', [
		'as' => 'auditors.temuanaudit_sign_lead_revisi',
		'uses' => 'InternalAuditController@sign_lead_revisi'
	]);

	Route::get('audit/daftar_temuan/{param}/auditee_sign', [
		'as' => 'auditors.temuanaudit_sign_auditee',
		'uses' => 'InternalAuditController@sign_auditee'
	]);

	Route::post('audit/daftar_temuan/{param}/auditee_sign/submit', [
		'as' => 'auditors.temuanaudit_sign_auditee_submit',
		'uses' => 'InternalAuditController@sign_auditee_submit'
	]);

	Route::get('audit/daftar_temuan/{param}/auditor_sign', [
		'as' => 'auditors.temuanaudit_sign_auditor',
		'uses' => 'InternalAuditController@sign_auditor'
	]);

	Route::post('audit/daftar_temuan/{param}/auditor_sign/submit', [
		'as' => 'auditors.temuanaudit_sign_auditor_submit',
		'uses' => 'InternalAuditController@sign_auditor_submit'
	]);

	Route::post('audit/daftar_temuan/{param}/auditor_sign/tolak', [
		'as' => 'auditors.temuanaudit_sign_auditor_tolak',
		'uses' => 'InternalAuditController@sign_auditor_tolak'
	]);

	Route::post('audit/daftar_temuan/{param}/auditor_sign/submit', [
		'as' => 'auditors.temuanaudit_sign_auditor_submit',
		'uses' => 'InternalAuditController@sign_auditor_submit'
	]);

	Route::get('audit/daftar_temuan/{param}/cetak', [
		'as' => 'auditors.temuanaudit_cetak',
		'uses' => 'InternalAuditController@cetak_temuanaudit'
	]);

	Route::get('pica_audit/form/id/{param}', [
		'as' => 'auditors.pica_audit_form_by_id',
		'uses' => 'InternalAuditController@pica_audit_form_by_id'
	]);

	Route::get('pica_audit/form/item/{param}', [
		'as' => 'auditors.picadaftarinput',
		'uses' => 'InternalAuditController@pica_temuan_list'
	]);
	
	Route::get('pica_audit/form/item/{param}/{param2}/{param3}/{param4}', [
		'as' => 'auditors.picadaftarinput_by_filter',
		'uses' => 'InternalAuditController@pica_temuan_list_by_filter'
	]);
	
	Route::get('pica_audit/form/{param}', [
		'as' => 'auditors.picadaftarinput_byid',
		'uses' => 'InternalAuditController@pica_input_data'
	]);
	
	Route::post('pica_audit/item/{param}/{param2}', [
		'as' => 'auditors.picadaftarinput_byid_add',
		'uses' => 'InternalAuditController@add_pica_item'
	]);
	
	Route::post('pica_audit/item/delete', [
		'as' => 'auditors.picadaftarinput_byid_delete',
		'uses' => 'InternalAuditController@delete_pica_item'
	]);
	
	Route::get('pica_audit', [
		'as' => 'auditors.daftar_pica',
		'uses' => 'InternalAuditController@daftar_pica'
	]);

	Route::get('pica_audit/{param}/{param2}/{param3}', [
		'as' => 'auditors.daftar_pica_by_filter',
		'uses' => 'InternalAuditController@daftar_pica_by_filter'
	]);
	
	Route::get('pica_audit/new', [
		'as' => 'auditors.new_pica',
		'uses' => 'InternalAuditController@new_pica'
	]);

	Route::get('pica_audit/detailpica/{param}', [
		'as' => 'auditors.detail_pica',
		'uses' => 'InternalAuditController@detail_pica'
	]);

	Route::post('pica_audit/submitpica/{param}', [
		'as' => 'auditors.submit_pica',
		'uses' => 'InternalAuditController@submit_pica'
	]);

	Route::post('pica_audit/hapusdraft/{param}', [
		'as' => 'auditors.hapus_draft',
		'uses' => 'InternalAuditController@hapus_draft'
	]);

	Route::get('pica_audit/editdraft/{param}', [
			'as' => 'auditors.edit_pica',
			'uses' => 'InternalAuditController@edit_pica'
		]);

	Route::post('pica_audit/editdraft/{param}/{param2}/submit', [
		'as' => 'auditors.picadaftarinput_byid_edit',
		'uses' => 'InternalAuditController@edit_pica_item'
	]);

	Route::get('pica_audit/cetak/{param}', [
		'as' => 'auditors.cetak_pica_satuan',
		'uses' => 'InternalAuditController@cetak_pica_satuan'
	]);

	Route::post('pica_audit/cetaklaporan', [
		'as' => 'auditors.cetak_pica_laporan',
		'uses' => 'InternalAuditController@cetak_pica_laporan'
	]);
	
	Route::post('pica_audit/update/statusqa1', [
		'as' => 'auditors.update_statusqa1',
		'uses' => 'InternalAuditController@statusbyqa1'
	]);

	Route::post('pica_audit/update/statusqa2', [
		'as' => 'auditors.update_statusqa2',
		'uses' => 'InternalAuditController@statusbyqa2'
	]);

	Route::post('pica_audit/update/statusqa3', [
		'as' => 'auditors.update_statusqa3',
		'uses' => 'InternalAuditController@statusbyqa3'
	]);

	// Route::get('schedule_audit/'.\Carbon\Carbon::now()->format("Y").'/'.\Carbon\Carbon::now()->format("m").'/I', [
	// 	'as' => 'auditors.schedule',
	// 	'uses' => 'InternalAuditController@schedule_dashboard'
	// ]);

	Route::get('schedule_audit/{param}/{param2}/{param3}/{param4}', [
		'as' => 'auditors.schedule',
		'uses' => 'InternalAuditController@schedule_dashboard'
	]);

	Route::post('schedule_audit/hapus', [
		'as' => 'auditors.schedule_hapus',
		'uses' => 'InternalAuditController@hapus_jadwal'
	]);

	Route::post('schedule_audit/selesai_jadwal', [
		'as' => 'auditors.selesai_jadwal',
		'uses' => 'InternalAuditController@selesai_jadwal'
	]);

	Route::post('schedule_audit/reschedule', [
		'as' => 'auditors.reschedule',
		'uses' => 'InternalAuditController@reschedule'
	]);

	Route::post('schedule_audit/batal_schedule', [
		'as' => 'auditors.batal_schedule',
		'uses' => 'InternalAuditController@batal_schedule'
	]);

	Route::post('schedule_audit/batal_dan_reschedule', [
		'as' => 'auditors.batal_dan_reschedule',
		'uses' => 'InternalAuditController@batal_dan_reschedule'
	]);

	Route::post('schedule_audit/edit_keterangan', [
		'as' => 'auditors.edit_keterangan',
		'uses' => 'InternalAuditController@edit_keterangan'
	]);

	Route::get('schedule_audit/list_auditee', [
		'as' => 'auditors.schedule_popup_auditee',
		'uses' => 'InternalAuditController@schedule_popup_auditee'
	]);

	Route::post('schedule_audit/submit_new_schedule', [
		'as' => 'auditors.submit_new_schedule',
		'uses' => 'InternalAuditController@submit_new_schedule'
	]);

	Route::post('schedule_audit/submit_new_schedule/{param}', [
		'as' => 'auditors.submit_new_schedule_all',
		'uses' => 'InternalAuditController@submit_new_schedule_all'
	]);

	Route::post('schedule_audit/simpan_schedule', [
		'as' => 'auditors.simpan_schedule',
		'uses' => 'InternalAuditController@simpan_schedule'
	]);

	Route::post('schedule_audit/revisi_schedule', [
		'as' => 'auditors.revisi_schedule',
		'uses' => 'InternalAuditController@revisi_schedule'
	]);

	Route::post('schedule_audit/hapus_draft_schedule/{param}', [
		'as' => 'auditors.hapus_draft_schedule',
		'uses' => 'InternalAuditController@hapus_draft_schedule'
	]);

	Route::get('schedule_audit/{param}/{param2}/{param3}/{param4}/cetak', [
		'as' => 'auditors.cetak_schedule',
		'uses' => 'InternalAuditController@cetak_schedule'
	]);

	// == GRAFIK
	Route::get('pica_audit/report/grafik_temuan_ia', [
		'as' => 'auditors.grafik_temuan_ia',
		'uses' => 'InternalAuditController@grafik_temuan_ia'
	]);


	Route::post('appusulprob/approve', [
		'as' => 'appusulprob.approve',
		'uses' => 'AppUsulProbController@approve'
	]);

	Route::get('dashboard/appusulprob', [
		'as' => 'dashboard.appusulprob',
		'uses' => 'AppUsulProbController@dashboard'
	]);

	Route::get('appusulprob/index', [
		'as' => 'appusulprob.index',
		'uses' => 'AppUsulProbController@index'
	]);
});

// Route::get('auditor/pica_audit_form', [
// 	'as' => 'auditors.pica_audit_form',			
// 	'uses'=>'InternalAuditController@pica_audit_form'
// ]);


