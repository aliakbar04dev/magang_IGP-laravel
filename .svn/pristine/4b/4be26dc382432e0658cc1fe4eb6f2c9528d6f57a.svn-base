<?php

Route::group(['prefix'=>'audit', 'middleware'=>['auth']], function () {

    Route::get('auditor/auditor_form', [
		'as' => 'auditors.auditorform',			
		'uses'=>'InternalAuditController@auditor_form'
    ]);

    Route::get('auditor/auditor_form/data', [
		'as' => 'auditors.draft_data',			
		'uses'=>'InternalAuditController@draft_data'
    ]);

    Route::post('auditor/auditor_form/data/byNpk', [
		'as' => 'auditors.draft_data_byNpk',			
		'uses'=>'InternalAuditController@add_row_draft'
    ]);

    Route::post('auditor/auditor_form/data/delete', [
		'as' => 'auditors.draft_data_delete',			
		'uses'=>'InternalAuditController@delete_row_draft'
    ]);

    Route::post('auditor/auditor_form/data/save', [
		'as' => 'auditors.draft_data_save',			
		'uses'=>'InternalAuditController@save_not_draft'
    ]);

    Route::post('auditor/auditor_form/data/edit', [
		'as' => 'auditors.data_edit',			
		'uses'=>'InternalAuditController@edit_new_rev'
    ]);
    
    Route::get('auditor/turtle_form', [
		'as' => 'auditors.turtleform',			
		'uses'=>'InternalAuditController@turtle_form'
    ]);


});